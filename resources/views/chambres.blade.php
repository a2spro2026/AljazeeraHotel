@extends('layouts.app')
@section('title','Chambres')
@include('partials.page-hero')
@push('styles')
<style>
    .rooms{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:30px}
    .room{background:rgba(255,255,255,.03);border:1px solid rgba(201,162,39,.12);border-radius:12px;overflow:hidden;transition:transform .3s ease,border-color .3s ease}
    .room:hover{transform:translateY(-6px);border-color:rgba(201,162,39,.4)}
    .room .thumb{height:180px;background:url('{{ asset('images/hotel.png') }}') center/cover}
    .room .body{padding:24px}
    .room h3{font-family:'Cormorant Garamond',serif;font-size:26px;color:#fff;margin-bottom:8px}
    .room p{color:var(--text-muted);font-size:14px;margin-bottom:16px}
    .room .price{color:var(--gold);font-size:20px;font-weight:600}
    .room .price small{color:var(--text-muted);font-size:12px;font-weight:400}
    .book{margin-top:16px;width:100%;background:linear-gradient(135deg,var(--gold),var(--gold-light));color:#1a1304;border:none;padding:12px;border-radius:5px;font-weight:600;letter-spacing:1px;text-transform:uppercase;font-size:12px;cursor:pointer}
</style>
@endpush
@section('content')
<header class="page-hero"><div class="ph-inner"><div class="crumb">Al Jazeera Hotel</div><h1 class="serif">Nos Chambres</h1></div></header>
<section class="page-body">
    <div class="rooms">
        @foreach([['Chambre Standard','Confort essentiel pour un séjour serein.','450'],['Chambre Deluxe','Espace généreux et vue dégagée.','750'],['Suite Junior','Salon privé et finitions raffinées.','1100'],['Suite Présidentielle','Le summum du luxe et de l\'élégance.','2200'],['Chambre Familiale','Idéale pour toute la famille.','950'],['Suite Royale','Une expérience d\'exception absolue.','3000']] as $r)
        <div class="room">
            <div class="thumb"></div>
            <div class="body">
                <h3 class="serif">{{ $r[0] }}</h3>
                <p>{{ $r[1] }}</p>
                <div class="price">{{ $r[2] }} DH <small>/ nuit</small></div>
                <button class="book">Réserver</button>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endsection
