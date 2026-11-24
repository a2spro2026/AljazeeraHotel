<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelUser extends Model
{
    public const USER_PROFILS = [
        'Direction',
        'Administration',
        'Réception',
        'S. Commercial',
        'House Keeping',
        'S. Technique',
    ];

    public const COMM_PROFILS = ['Accueil', 'Administration', 'Facturation', 'Service Achats', 'Service Technique'];

    public const PROFILS = [
        'Direction', 'Administration', 'Réception', 'S. Commercial', 'House Keeping', 'S. Technique',
        'Comptabilité', 'Commercial', 'Maintenance', 'Restauration',
        'Accueil', 'Facturation', 'Service Achats', 'Service Technique',
    ];

    public const CONTRATS = ['CDI', 'CDD', 'Vacataire', 'Stage'];

    public const REMU_TYPES = ['Salaire', 'Journalier', 'Par/H', 'Forfait'];

    /** Profils autorisés à ouvrir chaque espace. */
    public const SPACE_PROFILS = [
        'admin' => ['Direction', 'Administration', 'Réception', 'House Keeping', 'Maintenance', 'Restauration'],
        'facturation' => ['Direction', 'Administration', 'Comptabilité', 'Facturation'],
        'commercial' => ['Direction', 'Administration', 'S. Commercial', 'Commercial', 'Accueil', 'Facturation', 'Service Achats', 'S. Technique', 'Service Technique'],
        'administration' => ['Direction', 'Administration'],
    ];

    protected $fillable = [
        'code', 'kind', 'fiche_date', 'nom', 'cin', 'tel', 'adresse', 'profil', 'contrat',
        'debut', 'fin', 'formation', 'remu_type', 'salaire', 'login', 'password', 'autorisations', 'photo',
    ];

    protected $hidden = ['password'];

    protected function casts(): array
    {
        return [
            'fiche_date' => 'date:Y-m-d',
            'debut' => 'date:Y-m-d',
            'fin' => 'date:Y-m-d',
            'salaire' => 'decimal:2',
            'password' => 'hashed',
            'autorisations' => 'array',
        ];
    }

    public function canOpen(string $space): bool
    {
        if ($this->kind === 'commercial' && $space === 'commercial') {
            return true;
        }

        return in_array($this->profil, self::SPACE_PROFILS[$space] ?? [], true);
    }

    public function toAdminArray(bool $withPhoto = false): array
    {
        $data = [
            'id' => $this->code,
            'kind' => $this->kind ?: 'user',
            'date' => $this->fiche_date?->format('Y-m-d'),
            'nom' => $this->nom,
            'cin' => $this->cin,
            'tel' => $this->tel,
            'adresse' => $this->adresse,
            'profil' => $this->profil,
            'contrat' => $this->contrat,
            'debut' => $this->debut?->format('Y-m-d'),
            'fin' => $this->fin?->format('Y-m-d'),
            'formation' => $this->formation,
            'remu_type' => $this->remu_type,
            'salaire' => $this->salaire,
            'login' => $this->login,
            'autorisations' => $this->autorisations ?? new \stdClass,
            'has_photo' => filled($this->photo),
        ];

        if ($withPhoto) {
            $data['photo'] = $this->photo;
        }

        return $data;
    }
}
