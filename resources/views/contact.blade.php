@extends('layouts.app')
@section('title','Contact')
@include('partials.page-hero')
@push('styles')
<style>
    .contact-grid{display:grid;grid-template-columns:1fr 1fr;gap:40px}
    .info-card{background:rgba(255,255,255,.03);border:1px solid rgba(201,162,39,.12);border-radius:14px;padding:30px;margin-bottom:20px}
    .info-card .ico{font-size:26px;color:var(--gold);margin-bottom:10px}
    .info-card h4{color:#fff;font-size:16px;margin-bottom:6px;letter-spacing:1px}
    .info-card p{color:var(--text-muted);font-size:14px}
    .c-form{background:rgba(255,255,255,.03);border:1px solid rgba(201,162,39,.15);border-radius:14px;padding:32px}
    .c-form h3{font-family:'Cormorant Garamond',serif;font-size:28px;color:#fff;margin-bottom:22px;text-align:center}
    .c-form input,.c-form textarea{
        width:100%;margin-bottom:16px;padding:13px 15px;border-radius:8px;
        background:rgba(0,0,0,.25);border:1px solid rgba(201,162,39,.2);
        color:var(--cream);font-family:'Montserrat',sans-serif;font-size:14px;outline:none;transition:border-color .2s,box-shadow .2s;text-align:center;
    }
    .c-form input:focus,.c-form textarea:focus{border-color:var(--gold);box-shadow:0 0 12px rgba(201,162,39,.3)}
    .c-form textarea{min-height:130px;resize:vertical}
    .c-form button{background:linear-gradient(135deg,var(--gold),var(--gold-light));color:#1a1304;border:none;padding:14px 30px;border-radius:8px;font-weight:600;letter-spacing:1px;text-transform:uppercase;font-size:13px;cursor:pointer;transition:transform .2s,box-shadow .3s}
    .c-form button:hover{transform:translateY(-2px);box-shadow:0 8px 22px rgba(201,162,39,.5)}
    @media(max-width:860px){.contact-grid{grid-template-columns:1fr}}
</style>
@endpush
@section('content')
<header class="page-hero"><div class="ph-inner"><div class="crumb">Al Jazeera Hotel</div><h1 class="serif">Contactez-nous</h1></div></header>
<section class="page-body">
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
                <p style="background:rgba(80,200,120,.15);color:#7fd99b;border:1px solid rgba(80,200,120,.3);padding:12px 14px;border-radius:8px;margin-bottom:16px;font-size:14px">Merci ! Votre message a bien été envoyé.</p>
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
