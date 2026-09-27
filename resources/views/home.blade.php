@extends('layouts.app')

@section('title','Accueil')

@push('styles')
<style>
    .home-hero{
        position:relative;min-height:100vh;margin-top:0;
        display:block;
        background:url('{{ asset('images/hotel-hero.png') }}') center center/cover no-repeat;
        background-color:#1a1520;
    }
    .home-hero::before,
    .home-hero::after{display:none}
    .home-hero-inner{display:none}
    @keyframes txtFadeUp{from{opacity:0;transform:translateY(28px)}to{opacity:1;transform:translateY(0)}}
    @keyframes goldGlow{
        0%,100%{text-shadow:0 0 12px rgba(212,176,106,.45),0 0 28px rgba(197,160,89,.25),0 2px 20px rgba(0,0,0,.35)}
        50%{text-shadow:0 0 22px rgba(255,232,170,.75),0 0 48px rgba(212,176,106,.5),0 2px 24px rgba(0,0,0,.3)}
    }
    @keyframes whiteGlow{
        0%,100%{text-shadow:0 2px 24px rgba(0,0,0,.45),0 0 40px rgba(255,255,255,.12)}
        50%{text-shadow:0 2px 28px rgba(0,0,0,.4),0 0 60px rgba(255,255,255,.22)}
    }
    @keyframes lineExpand{from{width:0;opacity:0}to{width:48px;opacity:1}}
    .txt-line{display:inline-block;opacity:0;animation:txtFadeUp .9s ease forwards}
    .home-hero-eyebrow .txt-line{animation-delay:.15s}
    .txt-hero-main.txt-line{animation-delay:.3s}
    .txt-hero-sub.txt-line{animation-delay:.5s}
    .home-hero-tagline.txt-line{animation-delay:.65s}
    .home-hero-actions{animation:txtFadeUp .9s .8s ease forwards;opacity:0}
    .home-hero-eyebrow{
        display:block;font-size:clamp(13px,1.3vw,16px);
        color:var(--gold-light);margin-bottom:12px;
        letter-spacing:4px;text-transform:uppercase;font-weight:600;
        text-shadow:0 0 18px rgba(212,176,106,.5),0 0 36px rgba(197,160,89,.25);
    }
    .home-hero-eyebrow::before{
        content:'';display:inline-block;width:28px;height:1px;background:var(--gold-light);
        margin-right:12px;vertical-align:middle;box-shadow:0 0 10px rgba(212,176,106,.6);
    }
    .home-hero h1{
        font-family:'Cormorant Garamond',serif;font-weight:700;line-height:1.02;
        font-size:clamp(44px,6.5vw,78px);color:#fff;margin:0 0 6px;
        letter-spacing:3px;
    }
    .home-hero h1 .txt-hero-main{
        display:block;
        text-shadow:0 4px 30px rgba(0,0,0,.5),0 0 50px rgba(255,255,255,.15);
        animation:txtFadeUp .9s .3s ease forwards,whiteGlow 4s ease-in-out infinite;
    }
    .home-hero h1 .gold{
        color:var(--gold-light);font-style:italic;font-weight:600;
        font-size:.48em;display:block;margin-top:8px;letter-spacing:5px;
        text-transform:uppercase;
        animation:txtFadeUp .9s .5s ease forwards,goldGlow 3.2s ease-in-out infinite;
    }
    .home-hero-tagline{
        font-size:clamp(15px,1.5vw,19px);color:rgba(255,255,255,.92);
        max-width:540px;margin:22px 0 34px;line-height:1.7;font-weight:400;
        text-shadow:0 2px 16px rgba(0,0,0,.45);
        border-left:2px solid rgba(212,176,106,.65);
        padding-left:18px;
        box-shadow:-8px 0 20px rgba(212,176,106,.08);
    }
    .home-hero-actions{display:flex;align-items:center;gap:16px;flex-wrap:wrap}
    .btn-discover{
        background:linear-gradient(135deg,var(--gold),var(--gold-light));
        color:#1a1304;font-weight:700;font-size:12px;letter-spacing:1.4px;
        text-transform:uppercase;padding:16px 32px;border:none;border-radius:6px;cursor:pointer;
        transition:transform .2s,box-shadow .2s;
    }
    .btn-discover:hover{transform:translateY(-2px);box-shadow:0 10px 28px rgba(197,160,89,.45)}
    .btn-play{
        width:52px;height:52px;border-radius:50%;border:2px solid rgba(255,255,255,.7);
        background:rgba(255,255,255,.12);color:#fff;font-size:18px;cursor:pointer;
        display:flex;align-items:center;justify-content:center;backdrop-filter:blur(4px);
        transition:background .2s,border-color .2s;
    }
    .btn-play:hover{background:rgba(255,255,255,.22);border-color:#fff}

    .home-cta-wrap{
        position:relative;z-index:10;margin-top:-72px;
        padding:0 clamp(16px,3vw,40px);max-width:var(--content-max);
        margin-left:auto;margin-right:auto;
        display:flex;justify-content:center;
    }
    .btn-offers{
        display:inline-flex;align-items:center;justify-content:center;gap:12px;
        padding:18px 42px;border:none;border-radius:50px;cursor:pointer;
        font-family:'Montserrat',sans-serif;font-size:13px;font-weight:700;
        letter-spacing:2px;text-transform:uppercase;color:#1a1304;
        background:linear-gradient(135deg,#e8c878 0%,var(--gold-light) 40%,var(--gold) 100%);
        box-shadow:0 12px 36px rgba(197,160,89,.4),0 0 40px rgba(212,176,106,.18),inset 0 1px 0 rgba(255,255,255,.45);
        transition:transform .25s ease,box-shadow .3s ease;
        position:relative;overflow:hidden;
    }
    .btn-offers::before{
        content:'';position:absolute;inset:0;
        background:linear-gradient(105deg,transparent 35%,rgba(255,255,255,.45) 50%,transparent 65%);
        transform:translateX(-120%);transition:transform .55s ease;
    }
    .btn-offers:hover{
        transform:translateY(-3px) scale(1.02);
        box-shadow:0 18px 48px rgba(197,160,89,.5),0 0 56px rgba(212,176,106,.25),inset 0 1px 0 rgba(255,255,255,.5);
    }
    .btn-offers:hover::before{transform:translateX(120%)}
    .btn-offers span{position:relative;z-index:1}

    .home-section{padding:72px clamp(20px,4vw,48px);max-width:var(--content-max);margin:0 auto;width:100%}
    .home-section-head{
        display:flex;align-items:flex-end;justify-content:space-between;
        gap:20px;margin-bottom:32px;flex-wrap:wrap;
    }
    .home-section-head h2,.home-title-luxe{
        font-family:'Cormorant Garamond',serif;font-size:clamp(28px,3vw,38px);
        color:var(--text-dark);letter-spacing:3px;text-transform:uppercase;font-weight:600;
        position:relative;display:inline-block;
        background:linear-gradient(135deg,var(--text-dark) 20%,#3d4a5c 50%,var(--text-dark) 80%);
        background-size:200% auto;-webkit-background-clip:text;background-clip:text;
        -webkit-text-fill-color:transparent;
        animation:titleShine 6s linear infinite;
    }
    @keyframes titleShine{0%{background-position:0% center}100%{background-position:200% center}}
    .home-section-head h2::after,.home-title-luxe::after{
        content:'';display:block;width:48px;height:2px;margin-top:10px;
        background:linear-gradient(90deg,var(--gold),var(--gold-light),transparent);
        box-shadow:0 0 14px rgba(197,160,89,.45);
        animation:lineExpand .8s ease forwards;
    }
    .home-link{
        font-size:12px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;
        color:var(--text-muted);transition:color .25s,transform .25s,text-shadow .25s;white-space:nowrap;
        position:relative;
    }
    .home-link::after{
        content:'';position:absolute;left:0;bottom:-4px;width:0;height:1px;
        background:linear-gradient(90deg,var(--gold),var(--gold-light));
        box-shadow:0 0 8px rgba(197,160,89,.5);transition:width .3s ease;
    }
    .home-link:hover{color:var(--gold);transform:translateX(4px);text-shadow:0 0 20px rgba(197,160,89,.2)}
    .home-link:hover::after{width:100%}

    .home-rooms-track{
        display:grid;grid-template-columns:repeat(5,minmax(0,1fr));gap:18px;
    }
    @media(max-width:1200px){.home-rooms-track{grid-template-columns:repeat(3,minmax(0,1fr))}}
    @media(max-width:760px){.home-rooms-track{grid-template-columns:repeat(2,minmax(0,1fr))}}
    @media(max-width:480px){.home-rooms-track{grid-template-columns:1fr}}

    .home-room{
        background:var(--white);border-radius:12px;overflow:hidden;
        border:1px solid rgba(0,0,0,.06);box-shadow:0 4px 20px rgba(0,0,0,.06);
        transition:transform .3s,box-shadow .3s;display:flex;flex-direction:column;
    }
    .home-room:hover{transform:translateY(-6px);box-shadow:0 16px 40px rgba(0,0,0,.1)}
    .home-room-img{position:relative;aspect-ratio:4/3;overflow:hidden;background:#e5e7eb}
    .home-room-img img{width:100%;height:100%;object-fit:cover}
    .home-room-badge{
        position:absolute;top:12px;left:12px;background:var(--gold);color:#1a1304;
        font-size:9px;font-weight:700;letter-spacing:1px;text-transform:uppercase;
        padding:5px 10px;border-radius:4px;
    }
    .home-room-body{padding:16px 16px 18px;flex:1;display:flex;flex-direction:column}
    .home-room-body h3{
        font-family:'Cormorant Garamond',serif;font-size:21px;color:var(--text-dark);
        margin:0 0 10px;font-weight:600;letter-spacing:.5px;
        transition:color .3s,text-shadow .3s;
    }
    .home-room:hover .home-room-body h3{
        color:#0f1a2e;
        text-shadow:0 0 24px rgba(197,160,89,.15);
    }
    .home-room-meta{
        display:flex;flex-wrap:wrap;gap:10px;font-size:11px;color:var(--text-muted);margin-bottom:14px;
    }
    .home-room-meta span{display:inline-flex;align-items:center;gap:4px}
    .home-room-foot{
        display:flex;align-items:center;justify-content:space-between;gap:10px;margin-top:auto;
    }
    .home-room-price{
        font-size:15px;font-weight:700;color:var(--navy-mid);
        text-shadow:0 0 20px rgba(197,160,89,.08);
    }
    .home-room-price small{font-size:11px;font-weight:500;color:var(--text-muted);-webkit-text-fill-color:var(--text-muted)}
    .btn-room{
        background:linear-gradient(135deg,var(--gold),var(--gold-light));
        color:#1a1304;border:none;border-radius:6px;padding:10px 14px;
        font-size:10px;font-weight:700;letter-spacing:.8px;text-transform:uppercase;cursor:pointer;
        white-space:nowrap;transition:transform .2s,box-shadow .2s;
    }
    .btn-room:hover{transform:translateY(-1px);box-shadow:0 6px 16px rgba(197,160,89,.35)}

    .home-services{
        background:var(--surface);padding:56px clamp(20px,4vw,48px);
        border-top:1px solid rgba(0,0,0,.05);border-bottom:1px solid rgba(0,0,0,.05);
    }
    .home-services-inner{max-width:var(--content-max);margin:0 auto}
    .home-services h2{
        font-family:'Cormorant Garamond',serif;font-size:clamp(26px,2.8vw,34px);
        text-align:center;color:var(--text-dark);letter-spacing:3px;text-transform:uppercase;
        margin-bottom:40px;font-weight:600;position:relative;
    }
    .home-services h2::before,.home-services h2::after{
        content:'';display:inline-block;width:36px;height:1px;background:var(--gold);
        vertical-align:middle;margin:0 16px;box-shadow:0 0 10px rgba(197,160,89,.4);
    }
    .home-services-grid{
        display:grid;grid-template-columns:repeat(8,minmax(0,1fr));gap:20px;
    }
    @media(max-width:1000px){.home-services-grid{grid-template-columns:repeat(4,minmax(0,1fr))}}
    @media(max-width:560px){.home-services-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}
    .home-svc{text-align:center;padding:12px 8px}
    .home-svc .ico{
        width:48px;height:48px;margin:0 auto 10px;border-radius:50%;
        display:flex;align-items:center;justify-content:center;
        background:rgba(197,160,89,.12);color:var(--gold);font-size:22px;
        border:1px solid rgba(197,160,89,.25);
    }
    .home-svc span{
        font-size:11px;font-weight:700;color:var(--text-dark);letter-spacing:.6px;
        text-transform:uppercase;transition:color .3s,text-shadow .3s;
    }
    .home-svc:hover span{color:var(--gold);text-shadow:0 0 16px rgba(197,160,89,.25)}

    .home-promos{padding:56px clamp(20px,4vw,48px);max-width:var(--content-max);margin:0 auto}
    .home-promos-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:16px}
    @media(max-width:900px){.home-promos-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}
    @media(max-width:480px){.home-promos-grid{grid-template-columns:1fr}}
    .home-promo{
        position:relative;border-radius:12px;overflow:hidden;min-height:160px;
        padding:22px 20px;display:flex;flex-direction:column;justify-content:flex-end;
        background:var(--navy-mid) center/cover no-repeat;color:#fff;
    }
    .home-promo::before{
        content:'';position:absolute;inset:0;
        background:linear-gradient(180deg,rgba(10,23,54,.2),rgba(10,23,54,.88));
    }
    .home-promo>*{position:relative;z-index:1}
    .home-promo .p-ico{font-size:28px;margin-bottom:10px;opacity:.95}
    .home-promo h4{
        font-family:'Cormorant Garamond',serif;font-size:21px;margin:0 0 6px;font-weight:600;
        text-shadow:0 2px 16px rgba(0,0,0,.4),0 0 24px rgba(255,255,255,.08);
        letter-spacing:.5px;
    }
    .home-promo p{
        font-size:12px;opacity:.9;margin:0;font-weight:500;
        text-shadow:0 1px 8px rgba(0,0,0,.35);
    }

    .home-trust{
        background:var(--surface);border-top:1px solid rgba(0,0,0,.06);
        padding:28px clamp(20px,4vw,48px);
    }
    .home-trust-inner{
        max-width:var(--content-max);margin:0 auto;
        display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:24px;
    }
    @media(max-width:760px){.home-trust-inner{grid-template-columns:repeat(2,minmax(0,1fr))}}
    .home-trust-item{display:flex;align-items:center;gap:14px}
    .home-trust-item .t-ico{
        width:44px;height:44px;border-radius:50%;flex-shrink:0;
        background:rgba(197,160,89,.15);color:var(--gold);
        display:flex;align-items:center;justify-content:center;font-size:20px;
        border:1px solid rgba(197,160,89,.3);
    }
    .home-trust-item b{
        display:block;font-size:13px;color:var(--text-dark);font-weight:700;
        letter-spacing:.3px;transition:color .3s;
    }
    .home-trust-item:hover b{color:var(--navy-mid)}
    .home-trust-item span{font-size:11px;color:var(--text-muted);line-height:1.4}

    .home-about{
        padding:64px clamp(20px,4vw,48px);max-width:100%;margin:0 auto;text-align:center;
    }
    .home-about h2{
        font-family:'Cormorant Garamond',serif;font-size:clamp(28px,3.5vw,36px);
        color:var(--text-dark);margin-bottom:18px;letter-spacing:2px;
        position:relative;display:inline-block;
    }
    .home-about h2::after{
        content:'';position:absolute;left:50%;bottom:-8px;transform:translateX(-50%);
        width:60px;height:2px;background:linear-gradient(90deg,transparent,var(--gold),transparent);
        box-shadow:0 0 12px rgba(197,160,89,.4);
    }
    .home-about p{
        font-size:16px;color:var(--text-muted);line-height:1.8;letter-spacing:.2px;
    }
    .home-about em{color:var(--gold);font-style:normal;font-weight:600}

    @media(max-width:560px){
        .btn-offers{padding:16px 28px;font-size:12px;letter-spacing:1.4px;width:100%;max-width:360px}
    }
</style>
@endpush

@section('content')
@php
    $featuredNums = ['101', '201', '301', '302', '402'];
    $featuredLabels = [
        '101' => ['label' => 'Chambre Deluxe', 'guests' => 2, 'size' => '28 m²', 'view' => 'Vue ville'],
        '201' => ['label' => 'Chambre Supérieure', 'guests' => 2, 'size' => '32 m²', 'view' => 'Vue jardin'],
        '301' => ['label' => 'Suite Junior', 'guests' => 3, 'size' => '45 m²', 'view' => 'Vue mer', 'popular' => true],
        '302' => ['label' => 'Suite Executive', 'guests' => 3, 'size' => '50 m²', 'view' => 'Vue panoramique'],
        '402' => ['label' => 'Suite Présidentielle', 'guests' => 4, 'size' => '65 m²', 'view' => 'Vue premium'],
    ];
    $allRooms = collect(config('hotel_rooms.rooms'))->keyBy('num');
@endphp

<section class="home-hero" aria-label="Hotel Al Jazzera"></section>

<div class="home-cta-wrap">
    <a href="{{ route('chambres') }}" class="btn-offers"><span>Découvrez nos offres</span></a>
</div>

<section class="home-section" id="chambres">
    <div class="home-section-head">
        <h2 class="serif">Nos Chambres &amp; Suites</h2>
        <a href="{{ route('chambres') }}#chambres-list" class="home-link">Voir toutes les chambres &rarr;</a>
    </div>
    <div class="home-rooms-track" id="homeRooms">
        @foreach($featuredNums as $num)
        @php
            $room = $allRooms->get($num);
            $meta = $featuredLabels[$num] ?? [];
            if (!$room) continue;
        @endphp
        <article class="home-room" data-num="{{ $num }}">
            <div class="home-room-img">
                <img src="{{ $room['img'] }}" alt="{{ $meta['label'] ?? $room['title'] }}" loading="lazy">
                @if(!empty($meta['popular']))
                    <span class="home-room-badge">Populaire</span>
                @endif
            </div>
            <div class="home-room-body">
                <h3 class="serif">{{ $meta['label'] ?? $room['title'] }}</h3>
                <div class="home-room-meta">
                    <span>&#128101; {{ $meta['guests'] ?? 2 }}</span>
                    <span>&#9632; {{ $meta['size'] ?? '30 m²' }}</span>
                    <span>&#127749; {{ $meta['view'] ?? 'Vue' }}</span>
                </div>
                <div class="home-room-foot">
                    <div class="home-room-price room-price">{{ number_format($room['price'], 0, ',', ' ') }} DH <small>/ nuit</small></div>
                    <a href="{{ route('chambres') }}#chambres-list"><button type="button" class="btn-room">Voir les détails</button></a>
                </div>
            </div>
        </article>
        @endforeach
    </div>
</section>

<section class="home-services" id="services">
    <div class="home-services-inner">
        <h2 class="serif">Nos Services Premium</h2>
        <div class="home-services-grid">
            <div class="home-svc"><div class="ico">&#127946;</div><span>Piscine</span></div>
            <div class="home-svc"><div class="ico">&#128150;</div><span>Spa &amp; Bien-être</span></div>
            <div class="home-svc"><div class="ico">&#127869;</div><span>Restaurant</span></div>
            <div class="home-svc"><div class="ico">&#9749;</div><span>Café &amp; Lounge</span></div>
            <div class="home-svc"><div class="ico">&#127947;</div><span>Salle de Sport</span></div>
            <div class="home-svc"><div class="ico">&#128246;</div><span>Wi-Fi Gratuit</span></div>
            <div class="home-svc"><div class="ico">&#128652;</div><span>Parking</span></div>
            <div class="home-svc"><div class="ico">&#127869;</div><span>Room Service</span></div>
        </div>
    </div>
</section>

<section class="home-promos">
    <div class="home-promos-grid">
        <article class="home-promo" style="background-image:url('https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=600&h=400&fit=crop&q=80')">
            <div class="p-ico">&#128737;</div>
            <h4>Réservation Sécurisée</h4>
            <p>Meilleur tarif garanti</p>
        </article>
        <article class="home-promo" style="background-image:url('https://images.unsplash.com/photo-1564501049412-61c3a3083791?w=600&h=400&fit=crop&q=80')">
            <div class="p-ico">&#128241;</div>
            <h4>Check-in en ligne</h4>
            <p>Gagnez du temps</p>
        </article>
        <article class="home-promo" style="background-image:url('https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=600&h=400&fit=crop&q=80')">
            <div class="p-ico">&#127991;</div>
            <h4>Offres Exclusives</h4>
            <p>Jusqu'à -30%</p>
        </article>
        <article class="home-promo" style="background-image:url('https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=600&h=400&fit=crop&q=80')">
            <div class="p-ico">&#128081;</div>
            <h4>Programme de Fidélité</h4>
            <p>Des avantages uniques</p>
        </article>
    </div>
</section>

<section class="home-trust">
    <div class="home-trust-inner">
        <div class="home-trust-item">
            <span class="t-ico">&#128176;</span>
            <div><b>Meilleur prix garanti</b><span>Tarifs officiels</span></div>
        </div>
        <div class="home-trust-item">
            <span class="t-ico">&#128197;</span>
            <div><b>Annulation gratuite</b><span>Sous conditions</span></div>
        </div>
        <div class="home-trust-item">
            <span class="t-ico">&#128222;</span>
            <div><b>Support 24/7</b><span>À votre écoute</span></div>
        </div>
        <div class="home-trust-item">
            <span class="t-ico">&#11088;</span>
            <div><b>Avis des clients</b><span>4.8/5 — 1 200 avis</span></div>
        </div>
    </div>
</section>

<section class="home-about" id="apropos">
    <h2 class="serif">À propos d'<em>ALJAZEERA</em></h2>
    <p>Un hôtel <em>5 étoiles</em> qui allie élégance marocaine et confort international. Piscine, spa, gastronomie raffinée et un service attentionné pour un séjour d'exception au cœur de la ville.</p>
</section>
@endsection

@push('scripts')
<script>window.AJ_HOTEL_DEFAULTS=@json(config('hotel_rooms'));</script>
<script src="{{ asset('js/hotel-content.js') }}"></script>
<script>
(function(){
    if(!window.AJ_HOTEL)return;
    const meta={
        '101':{label:'Chambre Deluxe',guests:2,size:'28 m²',view:'Vue ville'},
        '201':{label:'Chambre Supérieure',guests:2,size:'32 m²',view:'Vue jardin'},
        '301':{label:'Suite Junior',guests:3,size:'45 m²',view:'Vue mer',popular:true},
        '302':{label:'Suite Executive',guests:3,size:'50 m²',view:'Vue panoramique'},
        '402':{label:'Suite Présidentielle',guests:4,size:'65 m²',view:'Vue premium'}
    };
    const nums=['101','201','301','302','402'];
    nums.forEach(num=>{
        const room=window.AJ_HOTEL.getRoom(num);
        const card=document.querySelector(`.home-room[data-num="${num}"]`);
        if(!room||!card)return;
        const m=meta[num]||{};
        const img=card.querySelector('.home-room-img img');
        const title=card.querySelector('h3');
        const price=card.querySelector('.room-price');
        if(img&&room.img)img.src=room.img;
        if(title)title.textContent=m.label||room.title;
        if(price)price.innerHTML=Number(room.price).toLocaleString('fr-FR')+' DH <small>/ nuit</small>';
    });
})();
</script>
@endpush
