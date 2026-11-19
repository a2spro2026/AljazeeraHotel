@extends('layouts.app')

@section('title','Accueil')

@push('styles')
<style>
    .home-hero{
        position:relative;width:100%;margin-top:0;display:block;overflow:hidden;
        background:transparent;
    }
    .home-hero .hb-photo{display:block;width:100%;height:auto;filter:brightness(var(--hb-light,1))}
    .home-hero::after{
        content:'';position:absolute;inset:0;z-index:1;display:block;pointer-events:none;
        background:var(--hb-veil,transparent);
    }
    .home-hero-inner{
        position:absolute;inset:0;z-index:2;display:flex;flex-direction:column;justify-content:flex-end;
        width:100%;height:auto;min-height:0;padding:8% 8vw 7%;
    }
    [data-hb-zone]{position:relative}
    .hb-writing{
        position:absolute;z-index:20;left:50%;top:50%;max-width:92%;
        transform:translate(-50%,-50%) scale(var(--hb-wsize,1));transform-origin:center center;
        color:var(--hb-wcolor,#fff);text-align:center;pointer-events:none;line-height:1.05;
        white-space:normal;word-break:normal;
    }
    html:has(body.hb-edit),body.hb-edit{overflow:auto!important;height:100%!important;background:#0b1220}
    body.hb-edit .hb-writing{pointer-events:auto;cursor:grab;touch-action:none}
    body.hb-edit .hb-writing.is-on{outline:none}
    body.hb-edit [data-hb-zone].is-focus{outline:none}
    body.hb-edit.hb-solo nav,
    body.hb-edit.hb-solo footer,
    body.hb-edit.hb-solo [data-hb-zone]:not(.is-focus){display:none!important}
    body.hb-edit.hb-solo .home-hero.is-focus{min-height:auto}
    body.hb-edit.hb-solo [data-hb-zone].is-focus{min-height:280px}
    .hb-w-1,.hb-w-2{display:block}
    .hb-w-stars,.hb-w-orn,.hb-w-2{display:none}
    .hb-mode-lignes .hb-w-stars,.hb-mode-lignes .hb-w-orn{display:flex}
    .hb-mode-lignes .hb-w-2{display:block}
    .hb-w-stars{align-items:center;justify-content:center;gap:12px;margin:10px 0;color:var(--hb-wcolor,#f6e7b8);width:100%}
    .hb-w-stars span{display:block;height:1px;flex:1;min-width:36px;max-width:160px;background:linear-gradient(90deg,transparent,var(--hb-wcolor,#f4e4b4) 18%,color-mix(in srgb,var(--hb-wcolor,#fff6d8) 70%,#fff) 50%,var(--hb-wcolor,#f4e4b4) 82%,transparent)}
    .hb-w-stars b{font-weight:400;letter-spacing:.28em;font-size:.34em;padding-left:.28em}
    .hb-w-orn{align-items:center;justify-content:center;gap:12px;margin-top:10px;color:var(--hb-wcolor,#f6e7b8);width:100%}
    .hb-w-orn span{display:block;height:1px;flex:1;min-width:36px;max-width:160px;background:linear-gradient(90deg,transparent,var(--hb-wcolor,#f4e4b4) 18%,color-mix(in srgb,var(--hb-wcolor,#fff6d8) 70%,#fff) 50%,var(--hb-wcolor,#f4e4b4) 82%,transparent)}
    .hb-w-orn i{font-style:normal;font-size:11px}
    .hb-style-enseigne{font-size:clamp(34px,5vw,84px)}
    .hb-style-enseigne .hb-w-1,.hb-style-enseigne .hb-w-2{
        font-family:'Cinzel',serif;font-weight:700;text-transform:uppercase;
        letter-spacing:.08em;word-spacing:-.42em;white-space:nowrap;
        background:linear-gradient(180deg,color-mix(in srgb,var(--hb-wcolor,#e2b65a) 35%,#fff) 0%,color-mix(in srgb,var(--hb-wcolor,#e2b65a) 75%,#fff) 28%,var(--hb-wcolor,#e2b65a) 62%,color-mix(in srgb,var(--hb-wcolor,#e2b65a) 70%,#000) 100%);
        -webkit-background-clip:text;background-clip:text;color:transparent;-webkit-text-fill-color:transparent;
    }
    .hb-style-enseigne .hb-w-2{font-size:.9em;letter-spacing:.1em;word-spacing:-.48em}
    .hb-style-classique{font-family:'Cormorant Garamond',serif;font-weight:600;font-size:clamp(32px,4.4vw,72px);text-shadow:0 3px 18px rgba(0,0,0,.35)}
    .hb-style-signature{font-family:'Cormorant Garamond',serif;font-style:italic;font-weight:600;font-size:clamp(30px,4vw,64px);text-shadow:0 3px 18px rgba(0,0,0,.28)}
    .hb-style-moderne{font-family:'Montserrat',sans-serif;font-weight:700;letter-spacing:.18em;text-transform:uppercase;font-size:clamp(16px,2.1vw,34px);text-shadow:0 2px 12px rgba(0,0,0,.35)}
    .hb-style-lisere{font-family:'Cormorant Garamond',serif;font-weight:600;letter-spacing:.16em;text-transform:uppercase;font-size:clamp(26px,3.2vw,52px)}
    .hb-style-lisere .hb-w-1{border-bottom:1px solid #e8c56a;padding-bottom:8px}
    .hb-style-contour{font-family:'Cinzel',serif;font-weight:700;letter-spacing:.14em;text-transform:uppercase;font-size:clamp(28px,4vw,68px);color:transparent;-webkit-text-stroke:1.5px var(--hb-wcolor,#fff)}
    .hb-style-neon{font-family:'Montserrat',sans-serif;font-weight:700;letter-spacing:.12em;text-transform:uppercase;font-size:clamp(18px,2.4vw,40px);text-shadow:0 0 8px var(--hb-wcolor,#fff),0 0 22px var(--hb-wcolor,#fff)}
    .hb-writing.hb-light-none .hb-w-1,
    .hb-writing.hb-light-none .hb-w-2,
    .hb-writing.hb-light-none .hb-w-stars,
    .hb-writing.hb-light-none .hb-w-orn,
    .hb-writing.hb-nolight .hb-w-1,
    .hb-writing.hb-nolight .hb-w-2,
    .hb-writing.hb-nolight .hb-w-stars,
    .hb-writing.hb-nolight .hb-w-orn{
        filter:none!important;text-shadow:none!important;
    }
    .hb-writing.hb-light-soft .hb-w-1,
    .hb-writing.hb-light-soft .hb-w-2{
        filter:drop-shadow(0 2px 2px rgba(0,0,0,.35))!important;
        text-shadow:0 2px 10px rgba(0,0,0,.28)!important;
    }
    .hb-writing.hb-light-glow .hb-w-1,
    .hb-writing.hb-light-glow .hb-w-2{
        filter:drop-shadow(0 0 6px color-mix(in srgb,var(--hb-wcolor,#fff) 65%,transparent)) drop-shadow(0 0 16px color-mix(in srgb,var(--hb-wcolor,#fff) 40%,transparent))!important;
        text-shadow:0 0 14px color-mix(in srgb,var(--hb-wcolor,#fff) 55%,transparent)!important;
    }
    .hb-writing.hb-light-forte .hb-w-1,
    .hb-writing.hb-light-forte .hb-w-2{
        filter:drop-shadow(0 4px 8px rgba(0,0,0,.45)) drop-shadow(0 0 14px color-mix(in srgb,var(--hb-wcolor,#fff) 50%,transparent))!important;
        text-shadow:0 3px 16px rgba(0,0,0,.4),0 0 22px color-mix(in srgb,var(--hb-wcolor,#fff) 45%,transparent)!important;
    }
    .hb-writing.hb-light-neon .hb-w-1,
    .hb-writing.hb-light-neon .hb-w-2{
        filter:drop-shadow(0 0 4px var(--hb-wcolor,#fff)) drop-shadow(0 0 14px var(--hb-wcolor,#fff)) drop-shadow(0 0 28px color-mix(in srgb,var(--hb-wcolor,#fff) 60%,transparent))!important;
        text-shadow:0 0 8px var(--hb-wcolor,#fff),0 0 20px var(--hb-wcolor,#fff)!important;
    }
    .hb-writing.hb-light-or .hb-w-1,
    .hb-writing.hb-light-or .hb-w-2{
        filter:drop-shadow(0 0 8px rgba(232,190,110,.55)) drop-shadow(0 2px 4px rgba(0,0,0,.35))!important;
        text-shadow:0 0 12px rgba(246,231,184,.55),0 0 24px rgba(197,160,89,.4)!important;
    }
    .hb-writing.hb-light-relief .hb-w-1,
    .hb-writing.hb-light-relief .hb-w-2{
        filter:drop-shadow(1px 1px 0 rgba(255,255,255,.35)) drop-shadow(-1px -1px 0 rgba(0,0,0,.35)) drop-shadow(0 3px 6px rgba(0,0,0,.4))!important;
        text-shadow:1px 1px 0 rgba(255,255,255,.25),-1px -1px 0 rgba(0,0,0,.35)!important;
    }
    .hb-writing.hb-light-halo .hb-w-1,
    .hb-writing.hb-light-halo .hb-w-2{
        filter:drop-shadow(0 0 12px rgba(255,255,255,.35)) drop-shadow(0 0 28px color-mix(in srgb,var(--hb-wcolor,#fff) 35%,transparent))!important;
        text-shadow:0 0 18px rgba(255,255,255,.4),0 0 36px color-mix(in srgb,var(--hb-wcolor,#fff) 30%,transparent)!important;
    }
    .hb-style-enseigne.hb-light-soft .hb-w-1,
    .hb-style-enseigne.hb-light-soft .hb-w-2,
    .hb-style-enseigne.hb-light-glow .hb-w-1,
    .hb-style-enseigne.hb-light-glow .hb-w-2,
    .hb-style-enseigne.hb-light-forte .hb-w-1,
    .hb-style-enseigne.hb-light-forte .hb-w-2,
    .hb-style-enseigne.hb-light-neon .hb-w-1,
    .hb-style-enseigne.hb-light-neon .hb-w-2,
    .hb-style-enseigne.hb-light-or .hb-w-1,
    .hb-style-enseigne.hb-light-or .hb-w-2,
    .hb-style-enseigne.hb-light-relief .hb-w-1,
    .hb-style-enseigne.hb-light-relief .hb-w-2,
    .hb-style-enseigne.hb-light-halo .hb-w-1,
    .hb-style-enseigne.hb-light-halo .hb-w-2{text-shadow:none!important}
    .hb-writing.hb-nostars .hb-w-stars,
    .hb-writing.hb-nostars .hb-w-orn{display:none!important}
    .hb-mode-bandeau{background:rgba(6,15,36,.62);padding:12px 18px;border-radius:10px}
    .hb-mode-encadre{border:1px solid currentColor;padding:12px 18px}
    .hb-writing.hb-mode-incline{transform:translate(-50%,-50%) rotate(-8deg) scale(var(--hb-wsize,1))}
    .hb-writing.hb-mode-vertical{writing-mode:vertical-rl;text-orientation:mixed;letter-spacing:.2em}
    .hb-resize{display:none}
    body.hb-edit .hb-resize{display:block;position:absolute;right:-14px;bottom:-14px;width:16px;height:16px;border-radius:4px;background:#fff;border:2px solid #c5a059;cursor:nwse-resize}
    .home-hero-inner h1,.home-hero-inner p{color:var(--hb-title,#fff)}
    .home-hero-inner.hb-style-enseigne,
    .home-hero-inner.hb-style-signature,
    .home-hero-inner.hb-style-lisere{justify-content:center;align-items:center;text-align:center}
    .hb-lockup{max-width:92%;transform:scale(var(--hb-size,1));transform-origin:left bottom}
    .home-hero-inner.hb-style-enseigne .hb-lockup,
    .home-hero-inner.hb-style-signature .hb-lockup,
    .home-hero-inner.hb-style-lisere .hb-lockup{transform-origin:center center}
    .home-hero-inner.is-placed{padding:0}
    .home-hero-inner.is-placed .hb-lockup{position:absolute;left:var(--hb-x,50%);top:var(--hb-y,50%);transform:translate(-50%,-50%) scale(var(--hb-size,1));transform-origin:center center}
    .hb-stars,.hb-ornament{display:none;align-items:center;justify-content:center;gap:14px;width:min(920px,92vw);margin:0 auto}
    .hb-style-enseigne .hb-stars,.hb-style-enseigne .hb-ornament{display:flex}
    .hb-stars span,.hb-ornament span{display:block;height:1px;flex:1;max-width:220px;background:linear-gradient(90deg,transparent,#f4e4b4 18%,#fff6d8 50%,#f4e4b4 82%,transparent)}
    .hb-stars b{font-weight:400;letter-spacing:.38em;font-size:clamp(14px,1.7vw,22px);color:#f6e7b8;text-shadow:0 0 12px rgba(246,231,184,.6);padding-left:.38em}
    .hb-ornament{margin-top:14px}
    .hb-ornament i{color:#f6e7b8;font-style:normal;font-size:11px;text-shadow:0 0 8px rgba(246,231,184,.7)}
    .hb-style-enseigne .hb-lockup h1,.hb-style-enseigne .hb-lockup p{
        font-family:'Cinzel',serif;font-weight:700;text-transform:uppercase;letter-spacing:.08em;word-spacing:-.42em;line-height:1.05;white-space:nowrap;
        background:linear-gradient(180deg,#fff8e4 0%,#f3dc9a 30%,#e2b65a 62%,#c9963a 100%);
        -webkit-background-clip:text;background-clip:text;color:transparent;-webkit-text-fill-color:transparent;
        filter:drop-shadow(0 2px 2px rgba(0,0,0,.35));text-shadow:none;
    }
    .home-hero-inner.hb-style-enseigne h1{font-size:clamp(48px,7.4vw,108px);margin:0}
    .home-hero-inner.hb-style-enseigne p{max-width:none;margin:10px 0 0;padding:0;border:0;box-shadow:none;font-size:clamp(26px,4vw,62px);letter-spacing:.1em;word-spacing:-.48em}
    .home-hero-inner.hb-style-signature h1{font-family:'Cormorant Garamond',serif;font-style:italic;font-weight:600;letter-spacing:1px;text-transform:none}
    .home-hero-inner.hb-style-signature p{font-family:'Cormorant Garamond',serif;font-style:italic;letter-spacing:1px;max-width:none;border:0;padding:0;box-shadow:none}
    .home-hero-inner.hb-style-moderne h1{font-family:'Montserrat',sans-serif;font-weight:700;letter-spacing:.22em;text-transform:uppercase;font-size:clamp(26px,4vw,54px)}
    .home-hero-inner.hb-style-moderne p{font-family:'Montserrat',sans-serif;font-weight:500;letter-spacing:.2em;text-transform:uppercase;font-size:clamp(12px,1.3vw,15px);border:0;padding:0;box-shadow:none}
    .home-hero-inner.hb-style-lisere h1{letter-spacing:.18em;text-transform:uppercase}
    .home-hero-inner.hb-style-lisere h1::after{content:'';display:block;width:88px;height:1px;margin:14px auto 0;background:linear-gradient(90deg,transparent,#e8c56a,transparent)}
    .home-hero-inner.hb-style-lisere p{font-family:'Montserrat',sans-serif;letter-spacing:.28em;text-transform:uppercase;font-size:clamp(12px,1.3vw,15px);max-width:none;border:0;padding:0;box-shadow:none}
    .home-hero-inner p{
        max-width:640px;margin-top:12px;font-size:clamp(16px,1.6vw,20px);line-height:1.5;
        text-shadow:0 2px 16px rgba(0,0,0,.45);
    }
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
        font-size:clamp(44px,6.5vw,78px);color:var(--hb-title,#fff);margin:0 0 6px;
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
        display:flex;flex-wrap:wrap;justify-content:center;align-items:flex-start;gap:28px 20px;
    }
    .home-svc{position:relative;text-align:center;padding:12px 8px;flex:0 1 110px;width:110px;max-width:140px}
    .home-svc .ico{
        width:48px;height:48px;margin:0 auto 10px;border-radius:50%;
        display:flex;align-items:center;justify-content:center;
        background:rgba(197,160,89,.12);color:var(--gold);font-size:22px;
        border:1px solid rgba(197,160,89,.25);
    }
    .home-svc > span{
        font-size:11px;font-weight:700;color:var(--text-dark);letter-spacing:.6px;
        text-transform:uppercase;transition:color .3s,text-shadow .3s;
    }
    .home-svc:hover > span{color:var(--gold);text-shadow:0 0 16px rgba(197,160,89,.25)}
    .home-svc.is-off{display:none!important}
    .home-svc-eye{
        display:none;position:absolute;top:0;right:4px;z-index:5;
        width:28px;height:28px;border-radius:50%;border:1px solid rgba(197,160,89,.45);
        background:#fff;color:#8a6a2f;cursor:pointer;font-size:14px;line-height:1;
        align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(10,23,54,.12);
    }
    body.hb-edit .home-svc-eye{display:inline-flex}

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
        background:var(--hb-about-bg,#0a1736);
        --hb-about-title:var(--hb-about-title-color,#8b93a3);
        --hb-about-accent-color:var(--hb-about-accent,#c5a059);
        --hb-about-body:var(--hb-about-text-color,#c5cbd6);
    }
    .home-about h2{
        font-size:clamp(28px,3.5vw,36px);
        color:var(--hb-about-title);margin-bottom:18px;letter-spacing:2px;
        position:relative;display:inline-block;
    }
    .home-about.hb-about-serif h2{font-family:'Cormorant Garamond',serif;font-weight:600}
    .home-about.hb-about-moderne h2{font-family:'Montserrat',sans-serif;font-weight:700;text-transform:uppercase;letter-spacing:.18em;font-size:clamp(18px,2.4vw,28px)}
    .home-about.hb-about-signature h2{font-family:'Cormorant Garamond',serif;font-style:italic;font-weight:500}
    .home-about.hb-about-enseigne h2{
        font-family:'Cinzel',serif;font-weight:700;text-transform:uppercase;letter-spacing:.12em;
        background:linear-gradient(180deg,color-mix(in srgb,var(--hb-about-accent-color) 35%,#fff),var(--hb-about-accent-color) 55%,color-mix(in srgb,var(--hb-about-accent-color) 70%,#000));
        -webkit-background-clip:text;background-clip:text;color:transparent;-webkit-text-fill-color:transparent;
    }
    .home-about.hb-about-enseigne h2 em{
        background:linear-gradient(180deg,color-mix(in srgb,var(--hb-about-accent-color) 35%,#fff),var(--hb-about-accent-color) 55%,color-mix(in srgb,var(--hb-about-accent-color) 70%,#000));
        -webkit-background-clip:text;background-clip:text;color:transparent;-webkit-text-fill-color:transparent;
    }
    .home-about h2::after{
        content:'';position:absolute;left:50%;bottom:-8px;transform:translateX(-50%);
        width:60px;height:2px;background:linear-gradient(90deg,transparent,var(--hb-about-accent-color),transparent);
        box-shadow:0 0 12px color-mix(in srgb,var(--hb-about-accent-color) 50%,transparent);
    }
    .home-about p{
        font-size:16px;color:var(--hb-about-body);line-height:1.8;letter-spacing:.2px;max-width:820px;margin:0 auto;
    }
    .home-about em{color:var(--hb-about-accent-color);font-style:normal;font-weight:600;-webkit-text-fill-color:var(--hb-about-accent-color)}
    .home-about.hb-about-enseigne em{-webkit-text-fill-color:transparent}

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

<section class="home-hero" data-hb-zone="hero" aria-label="Hotel Al Jazzera">
    <img class="hb-photo" src="{{ $habillage['image_url'] ?? asset('images/hotel-hero.png') }}" alt="">
    @include('partials.hb-writings', ['zone' => 'hero'])
</section>

<div class="home-cta-wrap" data-hb-zone="offres">
    <a href="{{ route('chambres') }}" class="btn-offers"><span>Découvrez nos offres</span></a>
    @include('partials.hb-writings', ['zone' => 'offres'])
</div>

<section class="home-section" id="chambres" data-hb-zone="chambres">
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
                <img src="{{ $room['img'] ?: asset('images/rooms/default.svg') }}" alt="{{ $meta['label'] ?? $room['title'] }}" loading="lazy">
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
    @include('partials.hb-writings', ['zone' => 'chambres'])
</section>

@php
    $hbServices = $habillage['services'] ?? \App\Support\Habillage::defaultServices();
    $hbEdit = request()->boolean('hb-edit');
    $hbVisibleServices = $hbEdit ? $hbServices : array_values(array_filter($hbServices, fn ($s) => ($s['visible'] ?? true)));
@endphp
@if(count($hbVisibleServices))
<section class="home-services" id="services" data-hb-zone="services">
    <div class="home-services-inner">
        <h2 class="serif">Nos Services Premium</h2>
        <div class="home-services-grid" id="homeServicesGrid">
            @foreach($hbVisibleServices as $svc)
                <div class="home-svc{{ ($svc['visible'] ?? true) ? '' : ' is-off' }}" data-svc-id="{{ $svc['id'] }}">
                    @if($hbEdit)
                        <button type="button" class="home-svc-eye" data-svc-toggle="{{ $svc['id'] }}" title="{{ ($svc['visible'] ?? true) ? 'Masquer' : 'Afficher' }}" aria-label="{{ ($svc['visible'] ?? true) ? 'Masquer' : 'Afficher' }}">{{ ($svc['visible'] ?? true) ? '👁' : '🙈' }}</button>
                    @endif
                    <div class="ico">{{ $svc['icon'] }}</div>
                    <span>{{ $svc['label'] }}</span>
                </div>
            @endforeach
        </div>
    </div>
    @include('partials.hb-writings', ['zone' => 'services'])
</section>
@endif

<section class="home-promos" data-hb-zone="promos">
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
    @include('partials.hb-writings', ['zone' => 'promos'])
</section>

<section class="home-trust" data-hb-zone="confiance">
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
    @include('partials.hb-writings', ['zone' => 'confiance'])
</section>

@php
    $hbAbout = $habillage['about'] ?? \App\Support\Habillage::defaultAbout();
    $hbAboutStyle = in_array($hbAbout['style'] ?? '', ['serif','moderne','signature','enseigne'], true) ? $hbAbout['style'] : 'serif';
@endphp
<section
    class="home-about hb-about-{{ $hbAboutStyle }}"
    id="apropos"
    data-hb-zone="apropos"
    style="--hb-about-bg:{{ $hbAbout['bg'] }};--hb-about-title-color:{{ $hbAbout['title_color'] }};--hb-about-accent:{{ $hbAbout['accent'] }};--hb-about-text-color:{{ $hbAbout['text_color'] }};"
>
    <h2><span data-hb-about="title">{{ $hbAbout['title'] }}</span><em data-hb-about="brand">{{ $hbAbout['brand'] }}</em></h2>
    <p data-hb-about="text">{!! $hbAbout['text'] !!}</p>
    @include('partials.hb-writings', ['zone' => 'apropos'])
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
@if(request()->boolean('hb-edit'))
<script>
(function(){
    const zones=['hero','offres','chambres','services','promos','confiance','apropos'];
    const styles=['enseigne','classique','signature','moderne','lisere','contour','neon'];
    const modes=['libre','lignes','bandeau','encadre','incline','vertical'];
    let drag=null;
    function zoneOf(name){
        return document.querySelector('[data-hb-zone="'+(zones.includes(name)?name:'hero')+'"]')||document.querySelector('[data-hb-zone="hero"]');
    }
    function draw(list, selected){
        document.querySelectorAll('.hb-writing').forEach(n=>n.remove());
        (list||[]).forEach(w=>{
            const style=styles.includes(w.style)?w.style:'classique';
            const mode=modes.includes(w.mode)?w.mode:'libre';
            const zoneName=zones.includes(w.zone)?w.zone:'hero';
            const zone=zoneOf(zoneName);
            if(!zone)return;
            zone.classList.add('is-focus');
            const el=document.createElement('div');
            const light=(w.light===false||w.light==='none')?'none':(w.light===true?'soft':(['soft','glow','forte','neon','or','relief','halo'].includes(w.light)?w.light:'soft'));
            el.className='hb-writing hb-style-'+style+' hb-mode-'+mode+' hb-light-'+light+(w.id===selected?' is-on':'')+(w.stars===false?' hb-nostars':'');
            el.dataset.id=w.id;
            el.dataset.zone=zoneName;
            el.style.left=(Number(w.x)||50)+'%';
            el.style.top=(Number(w.y)||50)+'%';
            el.style.setProperty('--hb-wsize', String((Number(w.size)||100)/100));
            el.style.setProperty('--hb-wcolor', w.color||'#ffffff');
            const a=document.createElement('span');a.className='hb-w-1';a.textContent=w.text||'';
            const stars=document.createElement('span');stars.className='hb-w-stars';stars.setAttribute('aria-hidden','true');
            stars.innerHTML='<span></span><b>★★★★★</b><span></span>';
            const b=document.createElement('span');b.className='hb-w-2';b.textContent=w.text2||'';
            const orn=document.createElement('span');orn.className='hb-w-orn';orn.setAttribute('aria-hidden','true');orn.innerHTML='<span></span><i>◆</i><span></span>';
            const handle=document.createElement('span');handle.className='hb-resize';handle.title='Agrandir';
            el.append(a,stars,b,orn,handle);
            zone.appendChild(el);
        });
    }
    function applyBg(d){
        document.body.style.setProperty('--hb-color', d.color||'#1a1520');
        document.body.style.setProperty('--hb-light', String(d.light??1));
        document.body.style.setProperty('--hb-veil', d.veil||'transparent');
        const img=document.querySelector('.home-hero .hb-photo');
        if(img&&d.image&&img.getAttribute('src')!==d.image)img.src=d.image;
    }
    function applyServices(list){
        if(!Array.isArray(list))return;
        list.forEach(s=>{
            const el=document.querySelector('.home-svc[data-svc-id="'+s.id+'"]');
            if(!el)return;
            const on=s.visible!==false;
            el.classList.toggle('is-off', !on);
            const btn=el.querySelector('[data-svc-toggle]');
            if(btn){
                btn.textContent=on?'👁':'🙈';
                btn.title=on?'Masquer':'Afficher';
                btn.setAttribute('aria-label', on?'Masquer':'Afficher');
            }
        });
    }
    function applyAbout(about){
        const box=document.querySelector('.home-about');
        if(!box||!about)return;
        const styles=['serif','moderne','signature','enseigne'];
        const style=styles.includes(about.style)?about.style:'serif';
        box.classList.remove('hb-about-serif','hb-about-moderne','hb-about-signature','hb-about-enseigne');
        box.classList.add('hb-about-'+style);
        box.style.setProperty('--hb-about-bg', about.bg||'#0a1736');
        box.style.setProperty('--hb-about-title-color', about.title_color||'#8b93a3');
        box.style.setProperty('--hb-about-accent', about.accent||'#c5a059');
        box.style.setProperty('--hb-about-text-color', about.text_color||'#c5cbd6');
        const title=box.querySelector('[data-hb-about="title"]');
        const brand=box.querySelector('[data-hb-about="brand"]');
        const text=box.querySelector('[data-hb-about="text"]');
        if(title)title.textContent=about.title||'';
        if(brand)brand.textContent=about.brand||'';
        if(text)text.innerHTML=String(about.text||'').replace(/<(?!\/?em\b)[^>]*>/gi,'');
    }
    function focusZone(name, solo, keep){
        const active=Array.isArray(keep)&&keep.length?keep:[name||'hero'];
        document.body.classList.add('hb-edit');
        document.body.classList.toggle('hb-solo', !!solo);
        document.querySelectorAll('[data-hb-zone]').forEach(z=>z.classList.toggle('is-focus', active.includes(z.dataset.hbZone)));
        const first=document.querySelector('[data-hb-zone="'+active[0]+'"]');
        window.scrollTo(0,0);
        document.documentElement.scrollTop=0;
        document.body.scrollTop=0;
        if(first){
            requestAnimationFrame(()=>{
                first.scrollIntoView({block:'start',behavior:'instant' in document.documentElement.style ? 'instant' : 'auto'});
                window.scrollTo(0, Math.max(0, (first.getBoundingClientRect().top+window.scrollY)-8));
            });
        }
    }
    function sameOrigin(origin){
        try{return !origin||origin===location.origin||new URL(origin).host===location.host;}catch(err){return false;}
    }
    window.addEventListener('message', e=>{
        if(!sameOrigin(e.origin)||!e.data)return;
        if(e.data.type==='hb-focus'){focusZone(e.data.zone||'hero', e.data.solo!==false, e.data.zones);return;}
        if(e.data.type!=='hb-state')return;
        if(e.data.zones)focusZone(e.data.focus||e.data.zones[0]||'hero', e.data.solo!==false, e.data.zones);
        applyBg(e.data);
        applyServices(e.data.services);
        applyAbout(e.data.about);
        draw(e.data.writings, e.data.selected);
    });
    document.addEventListener('click', e=>{
        const btn=e.target.closest('[data-svc-toggle]');
        if(!btn)return;
        e.preventDefault();
        e.stopPropagation();
        parent.postMessage({type:'hb-svc-toggle',id:btn.dataset.svcToggle}, '*');
    });
    document.addEventListener('pointerdown', e=>{
        if(e.target.closest('[data-svc-toggle]'))return;
        const node=e.target.closest('.hb-writing');
        if(!node)return;
        e.preventDefault();
        node.setPointerCapture(e.pointerId);
        if(e.target.closest('.hb-resize')){
            drag={mode:'size',id:node.dataset.id,x:e.clientX,size:Math.round(parseFloat(node.style.getPropertyValue('--hb-wsize')||'1')*100),node};
        }else{
            drag={mode:'move',id:node.dataset.id,moved:false,node};
        }
    });
    document.addEventListener('pointermove', e=>{
        if(!drag)return;
        if(drag.mode==='size'){
            drag.sizeNow=Math.min(220, Math.max(50, Math.round(drag.size+(e.clientX-drag.x))));
            drag.node.style.setProperty('--hb-wsize', String(drag.sizeNow/100));
            return;
        }
        drag.moved=true;
        drag.node.style.pointerEvents='none';
        const under=document.elementFromPoint(e.clientX, e.clientY);
        drag.node.style.pointerEvents='auto';
        const zone=under&&under.closest('[data-hb-zone]');
        if(!zone)return;
        if(drag.node.parentElement!==zone)zone.appendChild(drag.node);
        const r=zone.getBoundingClientRect();
        const x=Math.min(96, Math.max(4, (e.clientX-r.left)/r.width*100));
        const y=Math.min(96, Math.max(4, (e.clientY-r.top)/r.height*100));
        drag.node.style.left=x+'%';
        drag.node.style.top=y+'%';
        drag.zone=zone.dataset.hbZone;
        drag.px=x;
        drag.py=y;
    });
    document.addEventListener('pointerup', ()=>{
        if(!drag)return;
        if(drag.mode==='size'){
            parent.postMessage({type:'hb-size',id:drag.id,size:drag.sizeNow||drag.size}, '*');
        }else if(drag.moved&&drag.zone){
            parent.postMessage({type:'hb-move',id:drag.id,zone:drag.zone,x:+drag.px.toFixed(1),y:+drag.py.toFixed(1)}, '*');
        }else{
            parent.postMessage({type:'hb-select',id:drag.id}, '*');
        }
        drag=null;
    });
    parent.postMessage({type:'hb-ready'}, '*');
})();
</script>
@endif
@endpush
