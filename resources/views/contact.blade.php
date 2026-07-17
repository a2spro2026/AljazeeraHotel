@extends('layouts.app')
@section('title','Contact')
@include('partials.page-hero')
@push('styles')
<style>
    .contact-intro{text-align:center;max-width:640px;margin:0 auto 44px}
    .contact-intro h2{
        font-family:'Cormorant Garamond',serif;font-size:clamp(26px,3vw,34px);
        color:var(--text-dark);letter-spacing:2px;text-transform:uppercase;margin-bottom:12px;
    }
    .contact-intro h2::after{
        content:'';display:block;width:48px;height:2px;margin:12px auto 0;
        background:linear-gradient(90deg,var(--gold),var(--gold-light),transparent);
        box-shadow:0 0 12px rgba(197,160,89,.4);
    }
    .contact-intro p{color:var(--text-muted);font-size:14px;line-height:1.65}
    .contact-grid{display:grid;grid-template-columns:1fr 1fr;gap:28px;align-items:start}
    .info-card{
        background:var(--white);border:1px solid rgba(197,160,89,.16);border-radius:14px;
        padding:24px 26px;margin-bottom:16px;
        box-shadow:0 4px 20px rgba(0,0,0,.05);
        transition:transform .3s,border-color .3s,box-shadow .3s;
    }
    .info-card:hover{
        transform:translateY(-3px);
        border-color:rgba(197,160,89,.3);
        box-shadow:0 12px 32px rgba(197,160,89,.1);
    }
    .info-card .ico{
        width:44px;height:44px;border-radius:50%;display:flex;align-items:center;justify-content:center;
        font-size:20px;color:var(--gold);margin-bottom:12px;
        background:rgba(197,160,89,.12);border:1px solid rgba(197,160,89,.22);
    }
    .info-card h4{color:var(--text-dark);font-size:15px;font-weight:700;margin-bottom:6px;letter-spacing:.5px}
    .info-card p{color:var(--text-muted);font-size:14px;line-height:1.55}
    .c-form{
        background:var(--white);border:1px solid rgba(197,160,89,.18);border-radius:14px;
        padding:32px 28px;box-shadow:0 8px 32px rgba(0,0,0,.06);
    }
    .c-form h3{
        font-family:'Cormorant Garamond',serif;font-size:26px;color:var(--text-dark);
        margin-bottom:22px;text-align:center;letter-spacing:1px;
    }
    .c-form input,.c-form textarea{
        width:100%;margin-bottom:14px;padding:13px 15px;border-radius:8px;
        background:var(--white);border:1px solid rgba(197,160,89,.22);
        color:var(--text-dark);font-family:'Montserrat',sans-serif;font-size:14px;
        outline:none;transition:border-color .2s,box-shadow .2s;
    }
    .c-form input:focus,.c-form textarea:focus{
        border-color:var(--gold);box-shadow:0 0 0 3px rgba(197,160,89,.12);
    }
    .c-form textarea{min-height:130px;resize:vertical}
    .c-form button{
        width:100%;background:linear-gradient(135deg,var(--gold),var(--gold-light));
        color:#1a1304;border:none;padding:14px 30px;border-radius:8px;
        font-weight:700;letter-spacing:1.2px;text-transform:uppercase;font-size:13px;
        cursor:pointer;transition:transform .2s,box-shadow .3s;
    }
    .c-form button:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(197,160,89,.35)}
    .c-form .success{
        background:rgba(34,139,84,.08);color:#1a7a3a;
        border:1px solid rgba(34,139,84,.25);padding:12px 14px;border-radius:8px;
        margin-bottom:16px;font-size:14px;text-align:center;
    }
    @media(max-width:860px){.contact-grid{grid-template-columns:1fr}}
</style>
@endpush
@section('content')
<header class="page-hero"><div class="ph-inner"><div class="crumb">Al Jazeera Hotel</div><h1 class="serif">Contactez-nous</h1></div></header>
<section class="page-body">
    <div class="contact-intro">
        <h2 class="serif">Nous sommes à votre écoute</h2>
        <p>Notre équipe est disponible 24h/24 pour répondre à toutes vos demandes.</p>
    </div>
    <div class="contact-grid">
        <div>
            <div class="info-card"><div class="ico">&#128205;</div><h4>Adresse</h4><p>Boulevard principal, Centre-ville</p></div>
            <div class="info-card"><div class="ico">&#128222;</div><h4>Téléphone</h4><p>+212 600 000 000</p></div>
            <div class="info-card"><div class="ico">&#9993;</div><h4>Email</h4><p>contact@aljazeerahotel.com</p></div>
            <div class="info-card"><div class="ico">&#128336;</div><h4>Réception</h4><p>Ouvert 24h/24 — 7j/7</p></div>
        </div>
        <form class="c-form" method="POST" action="{{ route('contact.send') }}">
            @csrf
            <h3 class="serif">Envoyez-nous un message</h3>
            @if(session('sent'))
                <p class="success">Merci ! Votre message a bien été envoyé.</p>
            @endif
            <input type="text" name="name" placeholder="Votre nom" required>
            <input type="email" name="email" placeholder="Votre email" required>
            <input type="text" name="subject" placeholder="Sujet">
            <textarea name="message" placeholder="Votre message" required></textarea>
            <button type="submit">Envoyer</button>
        </form>
    </div>
</section>
@endsection
