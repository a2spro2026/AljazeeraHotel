@extends('layouts.app')
@section('title','Chambres')
@push('styles')
<style>
    body.page-chambres{background:var(--surface)}
    .ch-page{padding-top:74px;background:var(--surface)}

    .ch-hero{
        position:relative;min-height:52vh;display:flex;align-items:center;
        background:
            linear-gradient(180deg,rgba(255,250,240,.16) 0%,rgba(255,255,255,.05) 45%,transparent 70%),
            linear-gradient(90deg,rgba(6,15,36,.58) 0%,rgba(6,15,36,.22) 50%,rgba(6,15,36,.08) 100%),
            url('{{ asset('images/hotel-facade.png') }}') center center/cover no-repeat;
        background-color:#e8e4dc;
    }
    .ch-hero::before{
        content:'';position:absolute;inset:0;pointer-events:none;
        background:radial-gradient(ellipse 70% 60% at 75% 40%,rgba(255,255,255,.18),transparent 60%);
    }
    .ch-hero-inner{
        position:relative;z-index:2;width:100%;max-width:var(--content-max);
        margin:0 auto;padding:100px clamp(20px,4vw,48px) 70px;text-align:left;
    }
    .ch-hero-eyebrow{
        display:inline-block;font-size:12px;letter-spacing:4px;text-transform:uppercase;
        color:var(--gold-light);margin-bottom:14px;font-weight:600;
        text-shadow:0 0 18px rgba(212,176,106,.5);
    }
    .ch-hero-eyebrow::before{
        content:'';display:inline-block;width:28px;height:1px;background:var(--gold-light);
        margin-right:12px;vertical-align:middle;box-shadow:0 0 10px rgba(212,176,106,.6);
    }
    .ch-hero h1{
        font-family:'Cormorant Garamond',serif;
        font-size:clamp(32px,4.5vw,56px);color:#fff;line-height:1.15;margin:0 0 14px;
        letter-spacing:2px;text-shadow:0 4px 28px rgba(0,0,0,.45),0 0 40px rgba(255,255,255,.1);
    }
    .ch-hero h1 em{font-style:normal;color:var(--gold-light);text-shadow:0 0 24px rgba(212,176,106,.45)}
    .ch-hero-sub{font-size:clamp(14px,1.4vw,17px);color:rgba(255,255,255,.9);max-width:560px;line-height:1.65}

    .ch-body{max-width:min(1520px,98vw);margin:0 auto;padding:48px clamp(10px,2vw,28px) 80px;width:100%}
    @media(max-width:860px){.ch-body{padding:32px 12px 60px}}

    .ch-stats{
        display:flex;flex-wrap:wrap;gap:14px;margin-bottom:40px;
    }
    .ch-stat{
        flex:1;min-width:140px;padding:18px 20px;background:var(--white);
        border:1px solid rgba(197,160,89,.18);border-radius:12px;
        box-shadow:0 4px 20px rgba(0,0,0,.05);text-align:center;
    }
    .ch-stat b{display:block;font-family:'Cormorant Garamond',serif;font-size:32px;color:var(--navy-mid);line-height:1}
    .ch-stat span{font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--gold)}

    .ch-frames{
        display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:clamp(14px,2vw,22px);
        width:100%;margin:0 auto 56px;align-items:stretch;
    }
    @media(max-width:1100px){.ch-frames{grid-template-columns:repeat(2,minmax(0,1fr))}}
    @media(max-width:680px){.ch-frames{grid-template-columns:1fr}}

    .ch-frame{
        background:var(--white);border:1px solid rgba(197,160,89,.16);border-radius:14px;overflow:hidden;
        box-shadow:0 8px 32px rgba(0,0,0,.07);display:flex;flex-direction:column;
        min-height:clamp(440px,52vh,620px);transition:transform .3s,box-shadow .3s;
    }
    .ch-frame:hover{transform:translateY(-4px);box-shadow:0 16px 48px rgba(197,160,89,.12)}
    .ch-frame-head{
        padding:16px 18px 18px;border-top:1px solid rgba(197,160,89,.12);flex-shrink:0;
        background:linear-gradient(180deg,var(--white),rgba(247,245,240,.6));
    }
    .ch-frame-head h2{
        font-family:'Cormorant Garamond',serif;font-size:clamp(20px,2vw,24px);
        color:var(--text-dark);margin-bottom:4px;letter-spacing:1px;
    }
    .ch-frame-head p{font-size:12px;color:var(--text-muted);letter-spacing:.3px}

    .ch-carousel{position:relative;display:flex;flex-direction:column;flex:1;min-height:0}
    .ch-slides{position:relative;flex:1;min-height:clamp(300px,40vh,480px);overflow:hidden;background:#e5e7eb}
    .ch-slide{
        position:absolute;inset:0;opacity:0;z-index:0;cursor:pointer;
        background:center top/cover no-repeat #e5e7eb;transition:opacity .65s ease;pointer-events:none;
    }
    .ch-slide.active{opacity:1;z-index:1;pointer-events:auto}
    .ch-slide img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:center top;display:block}
    .ch-slide::after{
        content:'';position:absolute;inset:0;z-index:1;pointer-events:none;
        background:linear-gradient(180deg,transparent 40%,rgba(6,15,36,.75) 100%);
    }
    .ch-slide-cap{position:absolute;bottom:0;left:0;right:0;z-index:2;padding:18px 20px}
    .ch-slide-cap .ch-num{font-size:10px;color:var(--gold-light);letter-spacing:1.4px;text-transform:uppercase;margin-bottom:6px;font-weight:600}
    .ch-slide-cap h3{font-family:'Cormorant Garamond',serif;font-size:clamp(18px,1.6vw,22px);color:#fff;margin-bottom:6px;line-height:1.2}
    .ch-slide-cap p{font-size:12px;color:rgba(255,255,255,.9);line-height:1.45;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}

    .ch-car-nav{
        display:flex;align-items:center;justify-content:space-between;
        padding:10px 12px;background:rgba(247,245,240,.95);flex-shrink:0;
        border-top:1px solid rgba(197,160,89,.1);
    }
    .ch-car-btn{
        width:34px;height:34px;border-radius:50%;border:1px solid rgba(197,160,89,.35);
        background:var(--white);color:var(--gold);font-size:17px;cursor:pointer;transition:all .25s;
        box-shadow:0 2px 10px rgba(197,160,89,.1);
    }
    .ch-car-btn:hover{background:linear-gradient(135deg,var(--gold-light),var(--gold));color:#1a1304;box-shadow:0 4px 18px rgba(197,160,89,.35)}
    .ch-dots{display:flex;gap:6px;flex-wrap:wrap;justify-content:center}
    .ch-dot{width:8px;height:8px;border-radius:50%;border:none;padding:0;background:rgba(197,160,89,.25);cursor:pointer;transition:all .25s}
    .ch-dot.active{background:var(--gold);box-shadow:0 0 10px rgba(197,160,89,.55);transform:scale(1.15)}

    .ch-grid-wrap{
        width:100%;margin:0 auto;padding-top:48px;
        border-top:1px solid rgba(197,160,89,.15);scroll-margin-top:96px;
    }
    .ch-grid-head{margin-bottom:36px;text-align:center}
    .ch-grid-head h2{
        font-family:'Cormorant Garamond',serif;font-size:clamp(28px,3.5vw,38px);
        color:var(--text-dark);margin-bottom:10px;letter-spacing:3px;text-transform:uppercase;
        position:relative;display:inline-block;
    }
    .ch-grid-head h2::after{
        content:'';display:block;width:56px;height:2px;margin:12px auto 0;
        background:linear-gradient(90deg,var(--gold),var(--gold-light),transparent);
        box-shadow:0 0 12px rgba(197,160,89,.4);
    }
    .ch-grid-head p{color:var(--text-muted);font-size:14px;letter-spacing:.3px}
    .ch-grid-section{margin-bottom:52px}
    .ch-grid-section h3{
        font-family:'Cormorant Garamond',serif;font-size:26px;color:var(--text-dark);
        margin-bottom:8px;letter-spacing:1px;display:flex;align-items:center;gap:12px;flex-wrap:wrap;
    }
    .ch-grid-section h3::before{
        content:'';width:4px;height:28px;border-radius:2px;
        background:linear-gradient(180deg,var(--gold-light),var(--gold));
        box-shadow:0 0 12px rgba(197,160,89,.4);
    }
    .ch-section-count{
        font-family:'Montserrat',sans-serif;font-size:11px;font-weight:700;
        letter-spacing:1px;text-transform:uppercase;color:var(--gold);
        padding:5px 12px;border-radius:20px;
        background:rgba(197,160,89,.1);border:1px solid rgba(197,160,89,.22);
    }
    .ch-grid{display:grid;grid-template-columns:repeat(5,minmax(0,1fr));gap:16px;width:100%;margin-top:20px}
    @media(max-width:1200px){.ch-grid{grid-template-columns:repeat(3,minmax(0,1fr))}}
    @media(max-width:760px){.ch-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}
    @media(max-width:480px){.ch-grid{grid-template-columns:1fr}}

    .ch-card{
        background:var(--white);border:1px solid rgba(0,0,0,.06);border-radius:14px;overflow:hidden;
        box-shadow:0 4px 20px rgba(0,0,0,.06);transition:transform .3s,box-shadow .3s,border-color .3s;
        display:flex;flex-direction:column;min-height:100%;
    }
    .ch-card:hover{transform:translateY(-6px);border-color:rgba(197,160,89,.35);box-shadow:0 16px 40px rgba(197,160,89,.12)}
    .ch-card-img{position:relative;width:100%;aspect-ratio:4/3;min-height:200px;overflow:hidden;background:#e5e7eb;flex-shrink:0}
    .ch-card-img img{width:100%;height:100%;object-fit:cover;object-position:center top;display:block;transition:transform .5s}
    .ch-card:hover .ch-card-img img{transform:scale(1.05)}
    .ch-card-img::after{
        content:'';position:absolute;inset:0;
        background:linear-gradient(180deg,transparent 55%,rgba(6,15,36,.55) 100%);pointer-events:none;
    }
    .ch-card-num{
        position:absolute;bottom:10px;left:14px;z-index:2;
        font-size:10px;color:var(--gold-light);letter-spacing:1.4px;text-transform:uppercase;font-weight:700;
        text-shadow:0 2px 8px rgba(0,0,0,.4);
    }
    .ch-card-body{padding:16px 16px 18px;display:flex;flex-direction:column;flex:1}
    .ch-card-body h4{
        font-family:'Cormorant Garamond',serif;font-size:20px;color:var(--text-dark);
        margin-bottom:6px;font-weight:600;transition:color .3s;
    }
    .ch-card:hover .ch-card-body h4{color:var(--navy-mid)}
    .ch-card-body p{font-size:12px;color:var(--text-muted);line-height:1.55;margin-bottom:12px;flex:1}
    .ch-card-foot{display:flex;align-items:center;justify-content:space-between;gap:10px;margin-top:auto}
    .ch-card-price{font-size:14px;font-weight:700;color:var(--navy-mid)}
    .ch-card-price small{font-size:11px;font-weight:500;color:var(--text-muted)}
    .ch-btn-card{
        background:linear-gradient(135deg,var(--gold),var(--gold-light));color:#1a1304;
        border:none;padding:10px 16px;border-radius:8px;font-weight:700;font-size:10px;
        letter-spacing:1px;text-transform:uppercase;cursor:pointer;white-space:nowrap;
        transition:transform .2s,box-shadow .2s;
    }
    .ch-btn-card:hover{transform:translateY(-2px);box-shadow:0 8px 20px rgba(197,160,89,.35)}

    .ch-modal-overlay{
        display:none;position:fixed;inset:0;z-index:200;
        background:rgba(10,23,54,.55);backdrop-filter:blur(8px);
        align-items:center;justify-content:center;padding:20px;overflow-y:auto;
    }
    .ch-modal-overlay.show{display:flex}
    .ch-modal{
        width:min(560px,100%);max-height:92vh;overflow-y:auto;
        background:linear-gradient(165deg,#fff,rgba(247,245,240,.98));
        border:1px solid rgba(197,160,89,.25);border-radius:18px;
        box-shadow:0 24px 64px rgba(0,0,0,.15),0 0 60px rgba(197,160,89,.1);
        animation:chFadeIn .35s ease;position:relative;
    }
    @keyframes chFadeIn{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:translateY(0)}}
    .ch-modal-close{
        position:absolute;top:16px;right:18px;z-index:10;
        width:38px;height:38px;border-radius:10px;border:1px solid rgba(197,160,89,.2);
        background:var(--white);color:var(--text-dark);font-size:22px;cursor:pointer;
    }
    .ch-modal-close:hover{border-color:var(--gold);color:var(--gold)}
    .ch-modal-info{padding:28px 26px 26px}
    .ch-modal-info .ch-num{font-size:11px;color:var(--gold);letter-spacing:2px;text-transform:uppercase;margin-bottom:6px;font-weight:700}
    .ch-modal-info h2{font-family:'Cormorant Garamond',serif;font-size:28px;color:var(--text-dark);margin-bottom:10px}
    .ch-modal-info .ch-desc{font-size:14px;color:var(--text-muted);line-height:1.65;margin-bottom:24px}
    .ch-form{display:grid;grid-template-columns:1fr 1fr;gap:12px}
    @media(max-width:500px){.ch-form{grid-template-columns:1fr}}
    .ch-form .field{display:flex;flex-direction:column}
    .ch-form .field.span2{grid-column:1/-1}
    .ch-form label{font-size:10px;color:var(--gold);font-weight:700;text-transform:uppercase;letter-spacing:1px;margin-bottom:5px}
    .ch-form input{
        background:var(--white);border:1px solid rgba(197,160,89,.22);border-radius:8px;
        padding:11px 13px;color:var(--text-dark);font-family:inherit;font-size:14px;outline:none;
    }
    .ch-form input:focus{border-color:var(--gold);box-shadow:0 0 0 3px rgba(197,160,89,.12)}
    .ch-form input[readonly]{opacity:.75;background:rgba(247,245,240,.8)}
    .ch-btn-reserve{
        grid-column:1/-1;margin-top:6px;width:100%;
        background:linear-gradient(135deg,var(--gold),var(--gold-light));color:#1a1304;
        border:none;padding:14px;border-radius:8px;font-weight:700;font-size:13px;
        letter-spacing:1.2px;text-transform:uppercase;cursor:pointer;transition:transform .2s,box-shadow .2s;
    }
    .ch-btn-reserve:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(197,160,89,.35)}
</style>
@endpush

@section('content')
<div class="ch-page">
<header class="ch-hero">
    <div class="ch-hero-inner">
        <span class="ch-hero-eyebrow">Al Jazeera Hotel</span>
        <h1 class="serif">Découvrez le confort, <em>vivez l'exception</em></h1>
        <p class="ch-hero-sub">Explorez l'ensemble de nos chambres et suites — du confort essentiel aux suites présidentielles.</p>
    </div>
</header>

<section class="ch-body">
    <div class="ch-stats" id="chStats"></div>
    <div class="ch-frames" id="chFrames"></div>

    <div class="ch-grid-wrap" id="chambres-list">
        <div class="ch-grid-head">
            <h2 class="serif">Toutes nos chambres</h2>
            <p>22 chambres réparties en Suites, Familiales et Singles — réservez en un clic</p>
        </div>
        <div id="chGridSections"></div>
    </div>
</section>
</div>

<div class="ch-modal-overlay" id="chModal">
    <div class="ch-modal">
        <button type="button" class="ch-modal-close" id="chModalClose" aria-label="Fermer">&times;</button>
        <div id="chModalContent"></div>
    </div>
</div>
@endsection

@push('scripts')
<script>window.AJ_HOTEL_DEFAULTS=@json(config('hotel_rooms'));</script>
<script src="{{ asset('js/hotel-content.js') }}"></script>
<script>
(function(){
    const AUTO_MS=4500;
    const modal=document.getElementById('chModal');
    const modalContent=document.getElementById('chModalContent');
    const framesBox=document.getElementById('chFrames');
    const gridBox=document.getElementById('chGridSections');
    const statsBox=document.getElementById('chStats');
    let CATEGORIES=[];
    const today=()=>new Date().toISOString().slice(0,10);
    const fmtP=n=>Number(n||0).toLocaleString('fr-FR')+' DH';

    function esc(s){return String(s??'').replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));}

    function loadCategories(){
        CATEGORIES=window.AJ_HOTEL?window.AJ_HOTEL.categoriesForPublic():[];
    }

    function totalRooms(){
        return CATEGORIES.reduce((n,c)=>n+(c.rooms?.length||0),0);
    }

    function roomByNum(num){
        for(const cat of CATEGORIES){
            const r=cat.rooms.find(x=>x.num===num);
            if(r)return{...r,longDesc:r.longDesc||r.desc};
        }
        return null;
    }

    function renderStats(){
        if(!statsBox)return;
        const total=totalRooms();
        const suites=CATEGORIES.find(c=>c.key==='suite')?.rooms?.length||0;
        const fam=CATEGORIES.find(c=>c.key==='familiale')?.rooms?.length||0;
        const single=CATEGORIES.find(c=>c.key==='single')?.rooms?.length||0;
        statsBox.innerHTML=`
            <div class="ch-stat"><b>${total}</b><span>Chambres au total</span></div>
            <div class="ch-stat"><b>${suites}</b><span>Suites</span></div>
            <div class="ch-stat"><b>${fam}</b><span>Familiales</span></div>
            <div class="ch-stat"><b>${single}</b><span>Singles</span></div>`;
    }

    function renderFrames(){
        if(!framesBox)return;
        framesBox.innerHTML=CATEGORIES.map((cat,catIdx)=>{
            const slides=(cat.slides||[]).filter(s=>s.img);
            const slideHtml=slides.map((slide,slideIdx)=>{
                const num=slide.roomNum||'';
                const attrs=num?` data-num="${esc(num)}" role="button" tabindex="0"`:'';
                return`<div class="ch-slide${slideIdx===0?' active':''}"${attrs} style="background-image:url('${esc(slide.img)}')">
                    <img src="${esc(slide.img)}" alt="${esc(slide.title)}" width="900" height="600" loading="${slideIdx===0?'eager':'lazy'}" decoding="async">
                    <div class="ch-slide-cap">
                        ${num?`<div class="ch-num">Chambre ${esc(num)}</div>`:''}
                        <h3>${esc(slide.title)}</h3>
                        <p>${esc(slide.desc)}</p>
                    </div>
                </div>`;
            }).join('');
            const dots=slides.map((_,dotIdx)=>`<button type="button" class="ch-dot${dotIdx===0?' active':''}" data-i="${dotIdx}" aria-label="Slide ${dotIdx+1}"></button>`).join('');
            return`<article class="ch-frame" data-cat="${catIdx}">
                <div class="ch-carousel">
                    <div class="ch-slides">${slideHtml||'<div class="ch-slide active"></div>'}</div>
                    <div class="ch-car-nav">
                        <button type="button" class="ch-car-btn ch-prev" aria-label="Précédent">&#8249;</button>
                        <div class="ch-dots">${dots}</div>
                        <button type="button" class="ch-car-btn ch-next" aria-label="Suivant">&#8250;</button>
                    </div>
                </div>
                <div class="ch-frame-head">
                    <h2 class="serif">${esc(cat.title)}</h2>
                    <p>${esc(cat.subtitle)} · ${cat.rooms.length} chambre(s)</p>
                </div>
            </article>`;
        }).join('');
        bindCarousels();
    }

    function renderGrid(){
        if(!gridBox)return;
        gridBox.innerHTML=CATEGORIES.map(cat=>`
            <div class="ch-grid-section">
                <h3 class="serif">${esc(cat.title)} <span class="ch-section-count">${cat.rooms.length} chambres</span></h3>
                <div class="ch-grid">
                    ${cat.rooms.map(room=>`
                        <article class="ch-card">
                            <div class="ch-card-img">
                                <img src="${esc(room.img)}" alt="${esc(room.title)}" width="900" height="675" loading="lazy" decoding="async">
                                <span class="ch-card-num">Chambre ${esc(room.num)}</span>
                            </div>
                            <div class="ch-card-body">
                                <h4 class="serif">${esc(room.title)}</h4>
                                <p>${esc(room.desc)}</p>
                                <div class="ch-card-foot">
                                    <span class="ch-card-price">${fmtP(room.price)} <small>/ nuit</small></span>
                                    <button type="button" class="ch-btn-card" data-num="${esc(room.num)}">Réserver</button>
                                </div>
                            </div>
                        </article>
                    `).join('')}
                </div>
            </div>
        `).join('');
        document.querySelectorAll('.ch-btn-card').forEach(btn=>{
            btn.addEventListener('click',e=>{
                e.stopPropagation();
                const room=roomByNum(btn.dataset.num);
                if(room)openModal(room);
            });
        });
    }

    function goSlide(frame,idx){
        const slides=frame.querySelectorAll('.ch-slide');
        const dots=frame.querySelectorAll('.ch-dot');
        const n=slides.length;
        if(!n)return;
        const i=((idx%n)+n)%n;
        slides.forEach((s,j)=>s.classList.toggle('active',j===i));
        dots.forEach((d,j)=>d.classList.toggle('active',j===i));
    }

    function bindSlideOpen(el){
        const open=()=>{
            const room=roomByNum(el.dataset.num);
            if(room)openModal(room);
        };
        el.addEventListener('click',open);
        el.addEventListener('keydown',e=>{if(e.key==='Enter'||e.key===' '){e.preventDefault();open();}});
    }

    function bindCarousels(){
        document.querySelectorAll('.ch-frame').forEach(frame=>{
            let cur=0,timer=null;
            const total=frame.querySelectorAll('.ch-slide').length;
            if(!total)return;
            const tick=()=>{cur=(cur+1)%total;goSlide(frame,cur);};
            const restart=()=>{clearInterval(timer);if(total>1)timer=setInterval(tick,AUTO_MS);};
            frame.querySelector('.ch-prev')?.addEventListener('click',e=>{
                e.stopPropagation();cur=(cur-1+total)%total;goSlide(frame,cur);restart();
            });
            frame.querySelector('.ch-next')?.addEventListener('click',e=>{
                e.stopPropagation();cur=(cur+1)%total;goSlide(frame,cur);restart();
            });
            frame.querySelectorAll('.ch-dot').forEach(dot=>{
                dot.addEventListener('click',e=>{
                    e.stopPropagation();cur=+dot.dataset.i;goSlide(frame,cur);restart();
                });
            });
            frame.querySelectorAll('.ch-slide[data-num]').forEach(slide=>bindSlideOpen(slide));
            frame.addEventListener('mouseenter',()=>clearInterval(timer));
            frame.addEventListener('mouseleave',restart);
            restart();
        });
    }

    function openModal(room){
        modalContent.innerHTML=`
            <div class="ch-modal-info">
                <div class="ch-num">Chambre ${esc(room.num)}</div>
                <h2 class="serif">${esc(room.title)}</h2>
                <p class="ch-desc">${esc(room.longDesc||room.desc)}</p>
                <p class="ch-desc" style="margin-top:-12px;font-weight:700;color:var(--navy-mid)">Tarif : ${fmtP(room.price)} / nuit</p>
                <form class="ch-form" id="chResaForm" onsubmit="return false">
                    <div class="field"><label>N° Chambre</label><input type="text" id="rf_num" value="${esc(room.num)}" readonly></div>
                    <div class="field"><label>Date</label><input type="date" id="rf_date" value="${today()}" required></div>
                    <div class="field span2"><label>Nom Client</label><input type="text" id="rf_nom" placeholder="Nom complet" required></div>
                    <div class="field"><label>N° Téléphone</label><input type="tel" id="rf_tel" placeholder="06 XX XX XX XX" required></div>
                    <div class="field"><label>N° CIN / Passport</label><input type="text" id="rf_cin" placeholder="AB123456" required></div>
                    <div class="field"><label>Nbrs Personnes</label><input type="number" id="rf_personnes" min="1" value="1" required></div>
                    <div class="field"><label>Nbrs Nuités</label><input type="number" id="rf_nuits" min="1" value="1" required></div>
                    <button type="submit" class="ch-btn-reserve">Réserver</button>
                </form>
            </div>`;
        document.getElementById('chResaForm').addEventListener('submit',()=>{
            const nom=document.getElementById('rf_nom').value.trim();
            const tel=document.getElementById('rf_tel').value.trim();
            const cin=document.getElementById('rf_cin').value.trim();
            if(!nom||!tel||!cin){alert('Veuillez remplir tous les champs obligatoires.');return;}
            const data={num:room.num,title:room.title,date:document.getElementById('rf_date').value,nom,tel,cin,personnes:document.getElementById('rf_personnes').value,nuits:document.getElementById('rf_nuits').value,price:room.price,at:new Date().toISOString()};
            const list=JSON.parse(localStorage.getItem('aj_public_resa')||'[]');
            list.push(data);
            localStorage.setItem('aj_public_resa',JSON.stringify(list));
            alert('Réservation enregistrée pour la chambre '+room.num+'. Notre équipe vous contactera sous peu.');
            closeModal();
        });
        modal.classList.add('show');
        document.body.style.overflow='hidden';
    }

    function closeModal(){modal.classList.remove('show');document.body.style.overflow='';}
    document.getElementById('chModalClose')?.addEventListener('click',closeModal);
    modal?.addEventListener('click',e=>{if(e.target===modal)closeModal();});
    document.addEventListener('keydown',e=>{if(e.key==='Escape')closeModal();});

    if(window.location.hash==='#chambres-list'||window.location.hash==='#galerie'){
        setTimeout(()=>document.querySelector(window.location.hash)?.scrollIntoView({behavior:'smooth'}),300);
    }

    loadCategories();
    renderStats();
    renderFrames();
    renderGrid();
})();
</script>
@endpush
