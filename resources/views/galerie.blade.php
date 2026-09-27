@extends('layouts.app')
@section('title','Galerie')
@include('partials.page-hero')
@push('styles')
<style>
    .gal-intro{text-align:center;max-width:640px;margin:0 auto 44px}
    .gal-intro h2{
        font-family:'Cormorant Garamond',serif;font-size:clamp(26px,3vw,34px);
        color:var(--text-dark);letter-spacing:2px;text-transform:uppercase;margin-bottom:12px;
    }
    .gal-intro h2::after{
        content:'';display:block;width:48px;height:2px;margin:12px auto 0;
        background:linear-gradient(90deg,var(--gold),var(--gold-light),transparent);
    }
    .gal-intro p{color:var(--text-muted);font-size:14px;line-height:1.65}
    .gal-grid{
        display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:18px;
    }
    .gal-item{
        position:relative;aspect-ratio:4/3;border-radius:14px;overflow:hidden;
        border:1px solid rgba(197,160,89,.16);background:#e5e7eb;
        box-shadow:0 4px 20px rgba(0,0,0,.05);
        transition:transform .3s ease,box-shadow .3s ease;
    }
    .gal-item:hover{transform:translateY(-4px);box-shadow:0 16px 40px rgba(197,160,89,.12)}
    .gal-item img{width:100%;height:100%;object-fit:cover;display:block}
    .gal-item span{
        position:absolute;left:0;right:0;bottom:0;padding:14px 16px;
        background:linear-gradient(180deg,transparent,rgba(6,15,36,.75));
        color:#fff;font-size:13px;font-weight:600;letter-spacing:.3px;
    }
</style>
@endpush
@section('content')
<header class="page-hero"><div class="ph-inner"><div class="crumb">Al Jazeera Hotel</div><h1 class="serif">Galerie</h1></div></header>
<section class="page-body">
    <div class="gal-intro">
        <h2 class="serif">L'hôtel en images</h2>
        <p>Découvrez l'ambiance de nos chambres, suites et espaces communs.</p>
    </div>
    <div class="gal-grid" id="galGrid"></div>
</section>
@endsection
@push('scripts')
<script>window.AJ_HOTEL_DEFAULTS=@json(config('hotel_rooms'));</script>
<script src="{{ asset('js/hotel-content.js') }}"></script>
<script>
(function(){
    const box=document.getElementById('galGrid');
    if(!box||!window.AJ_HOTEL)return;
    const rooms=window.AJ_HOTEL.getCatalog().filter(r=>r.hasPhoto);
    box.innerHTML=rooms.map(r=>`
        <a class="gal-item" href="{{ route('chambres') }}#chambres-list">
            <img src="${r.img}" alt="${r.title}" loading="lazy" width="600" height="450">
            <span>${r.title} — Ch. ${r.num}</span>
        </a>`).join('')||'<p class="gal-empty" style="grid-column:1/-1;text-align:center;padding:40px 16px;opacity:.75">Les photos des chambres seront bientôt disponibles.</p>';
})();
</script>
@endpush
