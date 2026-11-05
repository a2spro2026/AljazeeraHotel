<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelUser extends Model
{
    public const PROFILS = ['Direction', 'Administration', 'Réception', 'Comptabilité', 'Commercial', 'Maintenance', 'Restauration'];

    public const CONTRATS = ['CDI', 'CDD', 'Stage', 'Formation', 'Vacataire'];

    /** Profils autorisés à ouvrir chaque espace. */
    public const SPACE_PROFILS = [
        'admin' => ['Direction', 'Administration', 'Réception', 'Maintenance', 'Restauration'],
        'facturation' => ['Direction', 'Administration', 'Comptabilité'],
        'commercial' => ['Direction', 'Administration', 'Commercial'],
        'administration' => ['Direction', 'Administration'],
    ];

    protected $fillable = [
        'code', 'fiche_date', 'nom', 'cin', 'tel', 'adresse', 'profil', 'contrat',
        'debut', 'fin', 'formation', 'salaire', 'login', 'password', 'autorisations',
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
        return in_array($this->profil, self::SPACE_PROFILS[$space] ?? [], true);
    }

    public function toAdminArray(): array
    {
        return [
            'id' => $this->code,
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
            'salaire' => $this->salaire,
            'login' => $this->login,
            'autorisations' => $this->autorisations ?? new \stdClass,
        ];
    }
}
