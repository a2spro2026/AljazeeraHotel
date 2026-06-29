@extends('layouts.app')
@section('title','Restaurant')
@include('partials.page-hero')
@push('styles')
<style>
    .menu{display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:40px}
    .menu h2{font-family:'Cormorant Garamond',serif;font-size:30px;color:var(--gold);margin-bottom:22px;border-bottom:1px solid rgba(201,162,39,.25);padding-bottom:10px}
    .dish{display:flex;justify-content:space-between;gap:14px;margin-bottom:18px}
    .dish .info h4{color:#fff;font-size:16px;margin-bottom:4px}
    .dish .info p{color:var(--text-muted);font-size:13px}
    .dish .price{color:var(--gold);font-weight:600;white-space:nowrap}
</style>
@endpush
@section('content')
<header class="page-hero"><div class="ph-inner"><div class="crumb">Al Jazeera Hotel</div><h1 class="serif">Notre Restaurant</h1></div></header>
<section class="page-body">
    <div class="menu">
        <div>
            <h2 class="serif">Entrées</h2>
            @foreach([['Soupe Harira','Spécialité marocaine traditionnelle','45'],['Salade César','Poulet grillé, parmesan, croûtons','60'],['Briouates au fromage','Croustillants dorés','55']] as $d)
            <div class="dish"><div class="info"><h4>{{ $d[0] }}</h4><p>{{ $d[1] }}</p></div><div class="price">{{ $d[2] }} DH</div></div>
            @endforeach
        </div>
        <div>
            <h2 class="serif">Plats</h2>
            @foreach([['Tajine d\'agneau','Pruneaux et amandes','120'],['Couscous Royal','Légumes et viandes variées','140'],['Filet de bœuf','Sauce aux poivres, gratin','160'],['Poisson grillé','Du jour, légumes de saison','135']] as $d)
            <div class="dish"><div class="info"><h4>{{ $d[0] }}</h4><p>{{ $d[1] }}</p></div><div class="price">{{ $d[2] }} DH</div></div>
            @endforeach
        </div>
        <div>
            <h2 class="serif">Desserts</h2>
            @foreach([['Pâtisseries marocaines','Assortiment maison','50'],['Tarte au citron','Meringuée','55'],['Salade de fruits','Fruits frais de saison','40']] as $d)
            <div class="dish"><div class="info"><h4>{{ $d[0] }}</h4><p>{{ $d[1] }}</p></div><div class="price">{{ $d[2] }} DH</div></div>
            @endforeach
        </div>
    </div>
</section>
@endsection
