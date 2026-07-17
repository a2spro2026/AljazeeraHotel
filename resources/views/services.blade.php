@extends('layouts.app')
@section('title','Services')
@include('partials.page-hero')
@push('styles')
<style>
    .srv-intro{text-align:center;max-width:640px;margin:0 auto 44px}
    .srv-intro h2{
        font-family:'Cormorant Garamond',serif;font-size:clamp(26px,3vw,34px);
        color:var(--text-dark);letter-spacing:2px;text-transform:uppercase;margin-bottom:12px;
    }
    .srv-intro h2::after{
        content:'';display:block;width:48px;height:2px;margin:12px auto 0;
        background:linear-gradient(90deg,var(--gold),var(--gold-light),transparent);
        box-shadow:0 0 12px rgba(197,160,89,.4);
    }
    .srv-intro p{color:var(--text-muted);font-size:14px;line-height:1.65}
    .srv-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:20px}
    .srv{
        padding:28px 24px;border-radius:14px;background:var(--white);
        border:1px solid rgba(197,160,89,.16);
        box-shadow:0 4px 20px rgba(0,0,0,.05);
        transition:transform .3s ease,border-color .3s ease,box-shadow .3s ease;
    }
    .srv:hover{
        transform:translateY(-6px);
        border-color:rgba(197,160,89,.35);
        box-shadow:0 16px 40px rgba(197,160,89,.1);
    }
    .srv .ico{
        width:52px;height:52px;border-radius:50%;display:flex;align-items:center;justify-content:center;
        font-size:24px;margin-bottom:16px;
        background:rgba(197,160,89,.12);border:1px solid rgba(197,160,89,.22);
    }
    .srv h3{
        font-family:'Cormorant Garamond',serif;font-size:22px;
        color:var(--text-dark);margin-bottom:8px;letter-spacing:.5px;
    }
    .srv p{color:var(--text-muted);font-size:13px;line-height:1.6}
</style>
@endpush
@section('content')
<header class="page-hero"><div class="ph-inner"><div class="crumb">Al Jazeera Hotel</div><h1 class="serif">Nos Services</h1></div></header>
<section class="page-body">
    <div class="srv-intro">
        <h2 class="serif">Votre confort, notre priorité</h2>
        <p>Des prestations haut de gamme pour rendre votre séjour inoubliable.</p>
    </div>
    <div class="srv-grid">
        @foreach([['🍽️','Restaurant gastronomique','Une cuisine raffinée préparée par nos chefs.'],['🏊','Piscine extérieure','Détendez-vous au bord de notre piscine.'],['💆','Spa & bien-être','Massages et soins pour une détente absolue.'],['🏋️','Salle de sport','Équipements modernes accessibles 24h/24.'],['📶','Wi-Fi haut débit','Connexion gratuite dans tout l\'établissement.'],['🚐','Transfert aéroport','Service de navette sur demande.'],['🅿️','Parking privé','Stationnement sécurisé pour nos clients.'],['🛎️','Conciergerie','Une équipe à votre service à tout moment.']] as $s)
        <div class="srv"><div class="ico">{{ $s[0] }}</div><h3 class="serif">{{ $s[1] }}</h3><p>{{ $s[2] }}</p></div>
        @endforeach
    </div>
</section>
@endsection
