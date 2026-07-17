@extends('layouts.app')
@section('title','Restaurant')
@include('partials.page-hero')
@push('styles')
<style>
    .menu-intro{text-align:center;max-width:640px;margin:0 auto 44px}
    .menu-intro h2{
        font-family:'Cormorant Garamond',serif;font-size:clamp(26px,3vw,34px);
        color:var(--text-dark);letter-spacing:2px;text-transform:uppercase;margin-bottom:12px;
    }
    .menu-intro h2::after{
        content:'';display:block;width:48px;height:2px;margin:12px auto 0;
        background:linear-gradient(90deg,var(--gold),var(--gold-light),transparent);
        box-shadow:0 0 12px rgba(197,160,89,.4);
    }
    .menu-intro p{color:var(--text-muted);font-size:14px;line-height:1.65}
    .menu{display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:28px}
    .menu-col{
        background:var(--white);border:1px solid rgba(197,160,89,.16);border-radius:14px;
        padding:28px 26px;box-shadow:0 4px 20px rgba(0,0,0,.05);
    }
    .menu-col h2{
        font-family:'Cormorant Garamond',serif;font-size:26px;color:var(--text-dark);
        margin-bottom:22px;padding-bottom:12px;
        border-bottom:2px solid rgba(197,160,89,.2);
        display:flex;align-items:center;gap:10px;
    }
    .menu-col h2::before{
        content:'';width:4px;height:24px;border-radius:2px;
        background:linear-gradient(180deg,var(--gold-light),var(--gold));
    }
    .dish{
        display:flex;justify-content:space-between;gap:14px;margin-bottom:18px;
        padding-bottom:18px;border-bottom:1px solid rgba(0,0,0,.05);
    }
    .dish:last-child{margin-bottom:0;padding-bottom:0;border-bottom:none}
    .dish .info h4{color:var(--text-dark);font-size:15px;font-weight:600;margin-bottom:4px}
    .dish .info p{color:var(--text-muted);font-size:13px;line-height:1.5}
    .dish .price{
        color:var(--navy-mid);font-weight:700;font-size:14px;white-space:nowrap;
        padding:4px 10px;border-radius:6px;background:rgba(197,160,89,.1);
    }
</style>
@endpush
@section('content')
<header class="page-hero"><div class="ph-inner"><div class="crumb">Al Jazeera Hotel</div><h1 class="serif">Notre Restaurant</h1></div></header>
<section class="page-body">
    <div class="menu-intro">
        <h2 class="serif">Saveurs &amp; raffinement</h2>
        <p>Une carte inspirée des traditions marocaines et de la gastronomie internationale.</p>
    </div>
    <div class="menu">
        <div class="menu-col">
            <h2 class="serif">Entrées</h2>
            @foreach([['Soupe Harira','Spécialité marocaine traditionnelle','45'],['Salade César','Poulet grillé, parmesan, croûtons','60'],['Briouates au fromage','Croustillants dorés','55']] as $d)
            <div class="dish"><div class="info"><h4>{{ $d[0] }}</h4><p>{{ $d[1] }}</p></div><div class="price">{{ $d[2] }} DH</div></div>
            @endforeach
        </div>
        <div class="menu-col">
            <h2 class="serif">Plats</h2>
            @foreach([['Tajine d\'agneau','Pruneaux et amandes','120'],['Couscous Royal','Légumes et viandes variées','140'],['Filet de bœuf','Sauce aux poivres, gratin','160'],['Poisson grillé','Du jour, légumes de saison','135']] as $d)
            <div class="dish"><div class="info"><h4>{{ $d[0] }}</h4><p>{{ $d[1] }}</p></div><div class="price">{{ $d[2] }} DH</div></div>
            @endforeach
        </div>
        <div class="menu-col">
            <h2 class="serif">Desserts</h2>
            @foreach([['Pâtisseries marocaines','Assortiment maison','50'],['Tarte au citron','Meringuée','55'],['Salade de fruits','Fruits frais de saison','40']] as $d)
            <div class="dish"><div class="info"><h4>{{ $d[0] }}</h4><p>{{ $d[1] }}</p></div><div class="price">{{ $d[2] }} DH</div></div>
            @endforeach
        </div>
    </div>
</section>
@endsection
