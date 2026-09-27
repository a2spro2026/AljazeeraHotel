<?php

namespace Tests\Feature;

use App\Models\HotelUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class HotelUserTest extends TestCase
{
    use RefreshDatabase;

    private function asDirection(): self
    {
        config(['admin_spaces.admin.manager_logins' => ['chef']]);

        return $this->withSession(['space_admin' => true, 'space_admin_login' => 'chef']);
    }

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'nom' => 'Test Réception',
            'profil' => 'Réception',
            'contrat' => 'CDI',
            'login' => 'recep1',
            'password' => 'secret123',
        ], $overrides);
    }

    public function test_direction_creates_user_with_hashed_password(): void
    {
        $this->asDirection()->postJson('/admin/api/users', $this->payload())
            ->assertOk()
            ->assertJsonPath('users.0.id', 'Ut0001')
            ->assertJsonPath('users.0.login', 'recep1')
            ->assertJsonMissingPath('users.0.password');

        $user = HotelUser::first();
        $this->assertNotSame('secret123', $user->password);
        $this->assertTrue(Hash::check('secret123', $user->password));
    }

    public function test_password_required_on_create_and_kept_when_empty_on_edit(): void
    {
        $this->asDirection()->postJson('/admin/api/users', $this->payload(['password' => '']))
            ->assertStatus(422)->assertJsonValidationErrors('password');

        $this->asDirection()->postJson('/admin/api/users', $this->payload())->assertOk();
        $this->asDirection()->postJson('/admin/api/users', $this->payload(['edit' => 'Ut0001', 'nom' => 'Renommé', 'password' => '']))
            ->assertOk()->assertJsonPath('users.0.nom', 'Renommé');

        $this->assertTrue(Hash::check('secret123', HotelUser::first()->password));
    }

    public function test_login_must_be_unique(): void
    {
        $this->asDirection()->postJson('/admin/api/users', $this->payload())->assertOk();
        $this->asDirection()->postJson('/admin/api/users', $this->payload(['nom' => 'Autre']))
            ->assertStatus(422)->assertJsonValidationErrors('login');
    }

    public function test_non_direction_cannot_manage_users(): void
    {
        $this->getJson('/admin/api/users')->assertForbidden();

        $this->withSession(['space_admin' => true, 'space_admin_login' => 'recep1', 'space_admin_profil' => 'Réception'])
            ->getJson('/admin/api/users')->assertForbidden();
    }

    public function test_user_logs_into_space_allowed_by_profile_only(): void
    {
        HotelUser::create($this->payload() + ['code' => 'Ut0001']);

        $this->post('/espace/admin/login', ['login' => 'recep1', 'password' => 'secret123'])
            ->assertRedirect(route('admin'))
            ->assertSessionHas('space_admin', true)
            ->assertSessionHas('space_admin_profil', 'Réception');

        $this->post('/espace/facturation/login', ['login' => 'recep1', 'password' => 'secret123'])
            ->assertRedirect(route('home'))
            ->assertSessionMissing('space_facturation');

        $this->post('/espace/admin/login', ['login' => 'recep1', 'password' => 'mauvais'])
            ->assertRedirect(route('home'))
            ->assertSessionHas('login_error');
    }
}
