@extends('layouts.app')
@section('title','Services')
@include('partials.page-hero')
@push('styles')
<style>
    .srv-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:26px}
    .srv{padding:34px 26px;border-radius:12px;background:rgba(255,255,255,.03);border:1px solid rgba(201,162,39,.12);transition:transform .3s ease,border-color .3s ease}
    .srv:hover{transform:translateY(-6px);border-color:rgba(201,162,39,.4)}
    .srv .ico{font-size:38px;margin-bottom:14px}
    .srv h3{font-family:'Cormorant Garamond',serif;font-size:24px;color:#fff;margin-bottom:8px}
    .srv p{color:var(--text-muted);font-size:14px}
</style>
@endpush
@section('content')
<header class="page-hero"><div class="ph-inner"><div class="crumb">Al Jazeera Hotel</div><h1 class="serif">Nos Services</h1></div></header>
<section class="page-body">
    <div class="srv-grid">
        @foreach([['🍽️','Restaurant gastronomique','Une cuisine raffinée préparée par nos chefs.'],['🏊','Piscine extérieure','Détendez-vous au bord de notre piscine.'],['💆','Spa & bien-être','Massages et soins pour une détente absolue.'],['🏋️','Salle de sport','Équipements modernes accessibles 24h/24.'],['📶','Wi-Fi haut débit','Connexion gratuite dans tout l\'établissement.'],['🚐','Transfert aéroport','Service de navette sur demande.'],['🅿️','Parking privé','Stationnement sécurisé pour nos clients.'],['🛎️','Conciergerie','Une équipe à votre service à tout moment.']] as $s)
        <div class="srv"><div class="ico">{{ $s[0] }}</div><h3 class="serif">{{ $s[1] }}</h3><p>{{ $s[2] }}</p></div>
        @endforeach
    </div>
</section>
@endsection
