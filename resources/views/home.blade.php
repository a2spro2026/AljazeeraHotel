@extends('layouts.app')

@section('title','Accueil')

@push('styles')
<style>
    .hero{
        position:relative;min-height:100vh;display:flex;align-items:center;
        background:url('{{ asset('images/hotel.png') }}') center center/cover no-repeat;
        background-attachment:fixed;
        overflow:hidden;
    }
    .hero::before{
        content:'';position:absolute;inset:0;
        background:linear-gradient(90deg,rgba(6,15,36,.94) 0%,rgba(6,15,36,.82) 40%,rgba(6,15,36,.55) 70%,rgba(6,15,36,.4) 100%);
    }
    .hero-inner{position:relative;z-index:2;max-width:760px;margin:0;padding:0 48px 0 72px;width:100%;text-align:left}
    .eyebrow{
        display:inline-block;letter-spacing:6px;font-size:clamp(16px,1.6vw,22px);text-transform:uppercase;
        color:var(--gold);margin-bottom:26px;font-weight:600;
        text-shadow:0 0 10px rgba(201,162,39,.7),0 0 24px rgba(201,162,39,.45);
        opacity:0;animation:fadeUp .9s .2s forwards;
    }

    /* ---- SLOGAN LUMINEUX + EFFETS ---- */
    .slogan{
        font-family:'Cormorant Garamond',serif;font-weight:700;
        font-size:clamp(24px,3.6vw,52px);line-height:1.1;letter-spacing:1px;white-space:nowrap;
        color:#fff;max-width:none;margin-bottom:32px;
        text-shadow:0 0 18px rgba(255,255,255,.3),0 4px 30px rgba(0,0,0,.6);
        opacity:0;animation:fadeUp 1s .35s forwards;
    }
    .slogan .line{display:inline}
    .slogan .line.glow{margin-left:.4ch}
    .slogan .glow{
        color:#f3d77a;
        text-shadow:
            0 0 8px rgba(255,243,200,.95),
            0 0 24px rgba(230,199,90,.8),
            0 0 52px rgba(201,162,39,.65),
            0 0 90px rgba(201,162,39,.4),
            0 3px 30px rgba(0,0,0,.4);
        animation:glowPulse 3.2s ease-in-out infinite;
    }
    @keyframes glowPulse{
        0%,100%{text-shadow:0 0 8px rgba(255,243,200,.85),0 0 22px rgba(230,199,90,.6),0 0 42px rgba(201,162,39,.45),0 0 70px rgba(201,162,39,.3),0 3px 30px rgba(0,0,0,.4)}
        50%{text-shadow:0 0 14px rgba(255,243,200,1),0 0 34px rgba(230,199,90,.95),0 0 68px rgba(201,162,39,.8),0 0 110px rgba(201,162,39,.55),0 3px 30px rgba(0,0,0,.4)}
    }
    @keyframes fadeUp{from{opacity:0;transform:translateY(30px)}to{opacity:1;transform:translateY(0)}}

    .hero-desc{
        font-size:18px;color:var(--text-muted);max-width:34ch;margin-bottom:40px;
        opacity:0;animation:fadeUp 1s .55s forwards;
    }
    .hero-actions{display:flex;gap:18px;flex-wrap:wrap;opacity:0;animation:fadeUp 1s .75s forwards}
    .btn-primary{
        position:relative;background:linear-gradient(135deg,var(--gold),var(--gold-light));
        color:#1a1304;font-weight:600;letter-spacing:1.5px;text-transform:uppercase;font-size:13px;
        padding:18px 38px;border:none;border-radius:5px;cursor:pointer;overflow:hidden;
        box-shadow:0 0 0 rgba(201,162,39,.6);
        animation:pulse 2.6s ease-in-out infinite;
    }
    .btn-primary:hover{transform:translateY(-3px);box-shadow:0 12px 30px rgba(201,162,39,.55)}
    @keyframes pulse{
        0%,100%{box-shadow:0 0 0 0 rgba(201,162,39,.45)}
        50%{box-shadow:0 0 0 14px rgba(201,162,39,0)}
    }
    .btn-ghost{
        background:transparent;color:#fff;border:1px solid rgba(245,241,230,.4);
        font-weight:500;letter-spacing:1.5px;text-transform:uppercase;font-size:13px;
        padding:18px 38px;border-radius:5px;cursor:pointer;transition:all .25s ease;
    }
    .btn-ghost:hover{border-color:var(--gold);color:var(--gold)}

    /* ---- SERVICES ---- */
    .section{padding:90px 48px;max-width:var(--content-max,1140px);margin:0 auto;width:100%}
    .section-title{text-align:center;margin-bottom:56px}
    .section-title h2{
        font-family:'Cormorant Garamond',serif;font-size:44px;color:#fff;letter-spacing:4px;
        text-transform:uppercase;
    }
    .section-title .divider{width:70px;height:2px;background:var(--gold);margin:16px auto 0}
    .services-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:30px}
    .service{
        text-align:center;padding:30px 16px;border-radius:10px;
        background:rgba(255,255,255,.02);border:1px solid rgba(201,162,39,.08);
        transition:transform .3s ease,border-color .3s ease,background .3s ease;
    }
    .service:hover{transform:translateY(-8px);border-color:rgba(201,162,39,.4);background:rgba(201,162,39,.05)}
    .service .ico{font-size:34px;color:var(--gold);margin-bottom:14px}
    .service h4{font-size:15px;letter-spacing:1.5px;text-transform:uppercase;color:#fff;margin-bottom:6px}
    .service p{font-size:13px;color:var(--text-muted)}

    @media(max-width:860px){
        .hero{background-attachment:scroll;background-position:center}
        .hero::before{background:linear-gradient(180deg,rgba(6,15,36,.8),rgba(6,15,36,.72))}
        .hero-inner{padding:0 22px}
        .slogan{max-width:100%;white-space:normal;font-size:clamp(30px,7vw,46px)}
        .slogan .line{display:block}
        .slogan .line.glow{margin-left:0}
        .section{padding:60px 22px}
    }
</style>
@endpush

@section('content')
<header class="hero">
    <div class="hero-inner">
        <span class="eyebrow">Bienvenue à Al Jazeera Hotel</span>
        <h1 class="slogan serif"><span class="line">Un accueil chaleureux,</span><span class="line glow">un séjour exceptionnel.</span></h1>
        <p class="hero-desc">Vivez une expérience inoubliable dans notre hôtel d'exception. Un havre de paix au cœur du raffinement.</p>
        <div class="hero-actions">
            <a href="{{ route('chambres') }}"><button class="btn-primary">Réserver maintenant</button></a>
            <a href="{{ route('services') }}"><button class="btn-ghost">Découvrir nos services</button></a>
        </div>
    </div>
</header>

<section class="section" id="services">
    <div class="section-title">
        <h2 class="serif">Nos Services</h2>
        <div class="divider"></div>
    </div>
    <div class="services-grid">
        <div class="service"><div class="ico">&#127869;</div><h4>Restaurant</h4><p>Gastronomique</p></div>
        <div class="service"><div class="ico">&#127946;</div><h4>Piscine</h4><p>Extérieure</p></div>
        <div class="service"><div class="ico">&#128150;</div><h4>Spa &amp; Bien-être</h4><p>Détente absolue</p></div>
        <div class="service"><div class="ico">&#127947;</div><h4>Salle de sport</h4><p>Équipée</p></div>
        <div class="service"><div class="ico">&#128246;</div><h4>Wi-Fi</h4><p>Haut débit</p></div>
        <div class="service"><div class="ico">&#128652;</div><h4>Transfert</h4><p>Aéroport</p></div>
    </div>
</section>
@endsection
