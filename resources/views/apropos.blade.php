@extends('layouts.app')
@section('title','À propos')
@include('partials.page-hero')
@push('styles')
<style>
    .about-intro{text-align:center;max-width:680px;margin:0 auto 48px}
    .about-intro h2{
        font-family:'Cormorant Garamond',serif;font-size:clamp(26px,3vw,36px);
        color:var(--text-dark);letter-spacing:2px;margin-bottom:14px;
    }
    .about-intro h2::after{
        content:'';display:block;width:48px;height:2px;margin:14px auto 0;
        background:linear-gradient(90deg,var(--gold),var(--gold-light),transparent);
    }
    .about-intro p{color:var(--text-muted);font-size:15px;line-height:1.75}
    .about-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:20px;margin-top:8px}
    .about-card{
        background:var(--white);border:1px solid rgba(197,160,89,.16);border-radius:14px;
        padding:28px 24px;text-align:center;box-shadow:0 4px 20px rgba(0,0,0,.05);
        transition:transform .3s,box-shadow .3s;
    }
    .about-card:hover{transform:translateY(-4px);box-shadow:0 14px 36px rgba(197,160,89,.1)}
    .about-card .ico{
        width:52px;height:52px;margin:0 auto 14px;border-radius:50%;
        display:flex;align-items:center;justify-content:center;font-size:22px;
        background:rgba(197,160,89,.12);border:1px solid rgba(197,160,89,.22);
    }
    .about-card h3{
        font-family:'Cormorant Garamond',serif;font-size:22px;color:var(--text-dark);margin-bottom:8px;
    }
    .about-card p{color:var(--text-muted);font-size:13px;line-height:1.6}
    .about-cta{text-align:center;margin-top:48px}
    .about-cta a{
        display:inline-flex;align-items:center;gap:8px;
        background:linear-gradient(135deg,var(--gold),var(--gold-light));
        color:#1a1304;font-weight:700;font-size:12px;letter-spacing:1.2px;text-transform:uppercase;
        padding:14px 28px;border-radius:50px;transition:transform .2s,box-shadow .3s;
    }
    .about-cta a:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(197,160,89,.35)}
</style>
@endpush
@section('content')
<header class="page-hero"><div class="ph-inner"><div class="crumb">Al Jazeera Hotel</div><h1 class="serif">À propos</h1></div></header>
<section class="page-body">
    <div class="about-intro">
        <h2 class="serif">À propos d'<em>ALJAZEERA</em></h2>
        <p>Un hôtel 5 étoiles qui allie élégance marocaine et confort international. Piscine, spa, gastronomie raffinée et un service attentionné pour un séjour d'exception au cœur de la ville.</p>
    </div>
    <div class="about-grid">
        <div class="about-card">
            <div class="ico">&#127775;</div>
            <h3 class="serif">5 étoiles</h3>
            <p>Un standard d'excellence pour chaque détail de votre séjour.</p>
        </div>
        <div class="about-card">
            <div class="ico">&#127860;</div>
            <h3 class="serif">Gastronomie</h3>
            <p>Une cuisine raffinée inspirée des traditions et du monde.</p>
        </div>
        <div class="about-card">
            <div class="ico">&#128718;</div>
            <h3 class="serif">Bien-être</h3>
            <p>Piscine, spa et espaces détente pour vous ressourcer.</p>
        </div>
        <div class="about-card">
            <div class="ico">&#128100;</div>
            <h3 class="serif">Service 24/7</h3>
            <p>Une équipe à votre écoute, jour et nuit.</p>
        </div>
    </div>
    <div class="about-cta">
        <a href="{{ route('chambres') }}">Découvrir nos chambres</a>
    </div>
</section>
@endsection
