<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Direction — Al Jazeera Hotel</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <meta name="theme-color" content="#0a1736">
    <script src="{{ asset('js/aj-dates.js') }}"></script>
    <script src="{{ asset('js/aj-money.js') }}"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800&family=Cormorant+Garamond:ital,wght@0,500;0,600;0,700;1,500&family=Montserrat:wght@300;400;500;600&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        :root{
            --navy:#0a1736;--navy-deep:#060f24;--navy-mid:#0f2a5c;
            --gold:#c5a059;--gold-light:#d4b06a;--gold-pale:#f3e4a8;
            --cream:#f5f1e6;--muted:#6b7280;--text-dark:#1a2332;
            --surface:#f7f5f0;--white:#ffffff;--panel:var(--white);
            --sb-w:280px;--topbar-h:74px;--content-max:100%;
            --kpi-bar-h:0px;--lock-top:0px;
            --border-gold:rgba(197,160,89,.18);
            --shadow-soft:0 4px 20px rgba(0,0,0,.06);
            --shadow-card:0 8px 32px rgba(197,160,89,.1);
        }
        *{margin:0;padding:0;box-sizing:border-box}
        html{height:100%;overflow:hidden;scroll-behavior:smooth}
        body{height:100%;overflow:hidden;font-family:'Montserrat',sans-serif;background:var(--surface);color:var(--text-dark)}
        a{text-decoration:none;color:inherit}
        .serif{font-family:'Cormorant Garamond',serif}
        .admin-wrap{display:flex;height:100%;min-height:0;overflow:hidden}

        @keyframes navShimmer{
            0%{background-position:200% center}
            100%{background-position:-200% center}
        }
        @keyframes brandPulse{
            0%,100%{box-shadow:0 0 12px rgba(197,160,89,.35),0 0 28px rgba(197,160,89,.15)}
            50%{box-shadow:0 0 22px rgba(212,176,106,.65),0 0 48px rgba(197,160,89,.35)}
        }

        /* SIDEBAR — style lumineux (interface publique) */
        .sidebar{
            width:var(--sb-w);flex-shrink:0;
            background:linear-gradient(180deg,rgba(255,255,255,.99) 0%,rgba(247,245,240,.97) 100%);
            border-right:1px solid var(--border-gold);
            box-shadow:4px 0 32px rgba(10,23,54,.06),0 0 60px rgba(197,160,89,.04);
            display:flex;flex-direction:column;
            position:fixed;top:0;bottom:0;left:0;z-index:40;
            transition:transform .35s cubic-bezier(.4,0,.2,1);
        }
        .sidebar::after{
            content:'';position:absolute;top:0;right:0;bottom:0;width:1px;pointer-events:none;
            background:linear-gradient(180deg,transparent,rgba(197,160,89,.25),var(--gold),rgba(197,160,89,.25),transparent);
            background-size:100% 200%;animation:navShimmer 8s linear infinite;opacity:.6;
        }
        .admin-wrap.sb-collapsed .sidebar{transform:translateX(-100%)}
        .sb-brand{
            position:relative;z-index:1;cursor:pointer;
            display:flex;align-items:center;gap:14px;
            padding:20px 18px 18px;
            border-bottom:1px solid var(--border-gold);
            transition:background .25s ease;
        }
        .sb-brand:hover{background:rgba(197,160,89,.06)}
        .sb-logo-wrap{
            flex-shrink:0;width:52px;height:52px;border-radius:14px;
            background:linear-gradient(145deg,rgba(255,255,255,.95),rgba(247,245,240,.9));
            border:1px solid rgba(197,160,89,.3);
            display:flex;align-items:center;justify-content:center;padding:5px;
            box-shadow:0 0 20px rgba(197,160,89,.15);
            position:relative;
        }
        .sb-logo-wrap::before{
            content:'';position:absolute;inset:-3px;border-radius:16px;
            background:radial-gradient(circle,rgba(212,176,106,.3),transparent 70%);
            animation:brandPulse 3.5s ease-in-out infinite;z-index:-1;
        }
        .sb-brand img{height:40px;width:auto;border-radius:5px}
        .sb-brand-text{display:flex;flex-direction:column;gap:3px;min-width:0}
        .sb-est{
            font-family:'Montserrat',sans-serif;font-size:9px;letter-spacing:2.8px;text-transform:uppercase;
            color:var(--gold);font-weight:600;
        }
        .sb-brand-text b{
            font-family:'Cormorant Garamond',serif;font-size:20px;font-weight:700;letter-spacing:.5px;
            color:var(--text-dark);line-height:1.1;
        }
        .sb-stars{font-size:8px;letter-spacing:2px;color:var(--gold-light)}
        .sb-nav{
            flex:1;overflow-y:auto;overflow-x:hidden;
            padding:14px 10px 12px;display:flex;flex-direction:column;gap:6px;
            position:relative;z-index:1;
            scrollbar-width:thin;scrollbar-color:rgba(197,160,89,.25) transparent;
        }
        .sb-nav::-webkit-scrollbar{width:3px}
        .sb-nav::-webkit-scrollbar-thumb{background:rgba(197,160,89,.3);border-radius:3px}
        .sb-section-label{
            font-family:'Montserrat',sans-serif;font-size:9px;font-weight:600;
            letter-spacing:2.2px;text-transform:uppercase;
            color:var(--gold);padding:14px 12px 8px;
            display:flex;align-items:center;gap:8px;
            opacity:.9;
        }
        .sb-section-label::before{
            content:'';width:14px;height:1px;border-radius:1px;
            background:linear-gradient(90deg,var(--gold),transparent);flex-shrink:0;
        }
        .sb-section-label:first-child{padding-top:4px}
        .sb-group{
            background:linear-gradient(180deg,#fff 0%,rgba(255,255,255,.75) 100%);
            border:1px solid rgba(197,160,89,.14);
            border-radius:14px;padding:5px;margin-bottom:4px;
            box-shadow:0 2px 10px rgba(10,23,54,.03);
            transition:border-color .25s,box-shadow .25s;
        }
        .sb-group:has(.sb-item.active),
        .sb-group:has(.sb-sub.open){
            border-color:rgba(197,160,89,.32);
            box-shadow:0 6px 20px rgba(197,160,89,.1),inset 0 1px 0 rgba(255,255,255,.95);
        }
        .sb-group:has(.sb-item.active) .sb-parent{color:var(--navy-mid)}
        .sb-item,.sb-parent{
            display:flex;align-items:center;gap:11px;
            padding:10px 12px;border-radius:10px;
            color:#5c6478;font-size:13px;font-weight:500;
            cursor:pointer;border:1px solid transparent;
            transition:background .22s ease,color .22s ease,border-color .22s ease,box-shadow .22s ease;
            position:relative;
        }
        .sb-item .lbl,.sb-parent .lbl{
            flex:1;font-family:'Montserrat',sans-serif;letter-spacing:.15px;line-height:1.35;
        }
        .sb-parent .lbl{font-weight:600;font-size:13px}
        .ic-wrap{
            flex-shrink:0;width:34px;height:34px;border-radius:10px;
            display:flex;align-items:center;justify-content:center;
            background:rgba(197,160,89,.1);
            border:1px solid rgba(197,160,89,.18);
            color:var(--gold);
            transition:all .22s ease;
        }
        .ic-wrap svg{width:17px;height:17px;stroke:currentColor;fill:none;stroke-width:1.75;stroke-linecap:round;stroke-linejoin:round}

        .sb-item.sb-pilot{
            margin-bottom:4px;padding:12px 14px;
            background:linear-gradient(135deg,rgba(197,160,89,.12) 0%,rgba(197,160,89,.04) 100%);
            border:1px solid rgba(197,160,89,.22);
            min-height:50px;
        }
        .sb-item.sb-pilot .lbl{font-weight:600;font-size:13.5px;color:var(--text-dark)}
        .sb-item.sb-pilot .ic-wrap{
            background:rgba(197,160,89,.15);border-color:rgba(197,160,89,.3);
            box-shadow:0 0 12px rgba(197,160,89,.12);
        }
        .sb-item.sb-pilot:hover{
            background:linear-gradient(135deg,rgba(197,160,89,.18) 0%,rgba(197,160,89,.08) 100%);
            border-color:rgba(197,160,89,.35);
        }
        .sb-item.sb-pilot.active{
            background:linear-gradient(135deg,var(--gold-light),var(--gold));
            border-color:rgba(255,255,255,.4);
            box-shadow:0 6px 24px rgba(197,160,89,.3);
            color:#1a1304;
        }
        .sb-item.sb-pilot.active .lbl{color:#1a1304;font-weight:700}
        .sb-item.sb-pilot.active .ic-wrap{color:#1a1304;background:rgba(26,19,4,.08);border-color:rgba(26,19,4,.15)}

        .sb-item:hover{
            background:rgba(197,160,89,.08);
            color:var(--text-dark);
            border-color:rgba(197,160,89,.14);
        }
        .sb-item:hover .ic-wrap{
            border-color:rgba(197,160,89,.4);
            background:rgba(197,160,89,.16);
            color:var(--gold);
        }
        .sb-item.active:not(.sb-pilot){
            background:linear-gradient(135deg,rgba(197,160,89,.16) 0%,rgba(197,160,89,.07) 100%);
            color:var(--navy-mid);
            border-color:rgba(197,160,89,.3);
            box-shadow:0 4px 16px rgba(197,160,89,.1),inset 0 1px 0 rgba(255,255,255,.8);
        }
        .sb-item.active:not(.sb-pilot) .lbl{font-weight:600;color:var(--navy-mid)}
        .sb-item.active:not(.sb-pilot) .ic-wrap{
            background:linear-gradient(135deg,var(--gold),var(--gold-light));
            border-color:transparent;color:#1a1304;
            box-shadow:0 4px 12px rgba(197,160,89,.3);
        }
        .sb-group.sb-group-flat{
            background:linear-gradient(180deg,#fff 0%,rgba(247,245,240,.85) 100%);
            padding:6px;
        }
        .sb-group.sb-group-flat .sb-item{padding:11px 12px;margin-bottom:2px}
        .sb-group.sb-group-flat .sb-item:last-child{margin-bottom:0}

        .sb-item::before,.sb-parent::before{display:none}
        .sb-item::after{display:none}
        .sb-parent:hover{background:rgba(197,160,89,.08);color:var(--text-dark)}
        .sb-parent:hover .ic-wrap{border-color:rgba(197,160,89,.35);background:rgba(197,160,89,.14)}
        .sb-parent.expanded{
            background:linear-gradient(135deg,rgba(197,160,89,.12),rgba(197,160,89,.05));
            color:var(--navy-mid);
            border-color:rgba(197,160,89,.2);
        }
        .sb-parent.expanded .ic-wrap{
            border-color:rgba(197,160,89,.4);
            background:rgba(197,160,89,.18);
            box-shadow:0 0 14px rgba(197,160,89,.15);
        }
        .sb-parent .caret{
            margin-left:auto;flex-shrink:0;width:22px;height:22px;
            display:flex;align-items:center;justify-content:center;border-radius:6px;
            background:rgba(197,160,89,.08);border:1px solid rgba(197,160,89,.15);
            font-size:9px;color:var(--gold);
            transition:transform .3s cubic-bezier(.4,0,.2,1),background .2s,border-color .2s;
        }
        .sb-parent.expanded .caret{transform:rotate(180deg);background:rgba(197,160,89,.18);border-color:rgba(197,160,89,.35)}
        .sb-parent .sb-badge{
            font-size:9px;font-weight:600;padding:2px 7px;border-radius:20px;
            background:rgba(197,160,89,.08);color:var(--muted);
            border:1px solid rgba(197,160,89,.15);margin-left:4px;flex-shrink:0;
        }
        .sb-group:has(.sb-item.active) .sb-parent .sb-badge,
        .sb-parent.expanded .sb-badge{background:rgba(197,160,89,.18);color:var(--gold);border-color:rgba(197,160,89,.3)}

        .sb-sub{
            display:none;flex-direction:column;gap:2px;
            padding:4px 8px 10px 46px;position:relative;
            margin-top:2px;
        }
        .sb-sub::before{
            content:'';position:absolute;left:28px;top:2px;bottom:12px;width:2px;border-radius:2px;
            background:linear-gradient(180deg,var(--gold),rgba(197,160,89,.15));
            opacity:.55;
        }
        .sb-sub.open{display:flex;animation:sbSubIn .28s ease}
        @keyframes sbSubIn{
            from{opacity:0;transform:translateY(-4px)}
            to{opacity:1;transform:translateY(0)}
        }
        .sb-sub .sb-item{
            padding:9px 12px 9px 14px;border-radius:9px;min-height:38px;
            font-size:12px;color:var(--muted);
            background:rgba(255,255,255,.45);
            border:1px solid transparent;
        }
        .sb-sub .sb-item .lbl{font-size:12px;font-weight:500}
        .sb-sub .sb-item .ic-wrap{display:none}
        .sb-dot{
            flex-shrink:0;width:7px;height:7px;border-radius:50%;
            border:1.5px solid rgba(197,160,89,.45);margin-left:-22px;margin-right:6px;
            background:transparent;
            transition:all .2s ease;
        }
        .sb-sub .sb-item:hover{
            background:rgba(197,160,89,.1);color:var(--text-dark);
            border-color:rgba(197,160,89,.18);
        }
        .sb-sub .sb-item:hover .sb-dot{border-color:var(--gold);background:rgba(197,160,89,.35);box-shadow:0 0 8px rgba(197,160,89,.35)}
        .sb-sub .sb-item.active{
            background:linear-gradient(135deg,rgba(197,160,89,.18),rgba(197,160,89,.08));
            color:var(--navy-mid);font-weight:600;
            border:1px solid rgba(197,160,89,.28);
            box-shadow:0 2px 10px rgba(197,160,89,.1);
        }
        .sb-sub .sb-item.active .lbl{font-weight:600}
        .sb-sub .sb-item.active .sb-dot{background:var(--gold);border-color:var(--gold);box-shadow:0 0 10px rgba(197,160,89,.45)}

        .sb-foot{
            position:relative;z-index:1;padding:14px 14px 16px;
            border-top:1px solid var(--border-gold);
            background:linear-gradient(180deg,rgba(247,245,240,.7),rgba(255,255,255,.95));
        }
        .sb-profile{
            display:flex;align-items:center;gap:10px;padding:10px 8px 12px;margin-bottom:8px;
            border-bottom:1px solid var(--border-gold);
        }
        .sb-profile-av{
            width:36px;height:36px;border-radius:50%;flex-shrink:0;overflow:hidden;
            background:linear-gradient(135deg,var(--gold),var(--gold-light));
            color:#1a1304;font-weight:700;font-size:14px;
            display:flex;align-items:center;justify-content:center;
            box-shadow:0 4px 12px rgba(197,160,89,.3);
        }
        .sb-profile-av img{width:100%;height:100%;object-fit:cover;display:block}
        .sb-profile-info{flex:1;min-width:0}
        .sb-profile-info b{display:block;font-size:13px;color:var(--text-dark);line-height:1.2}
        .sb-profile-info span{font-size:10px;color:var(--muted)}
        .sb-profile-caret{font-size:10px;color:var(--gold)}
        .sb-foot-note{
            font-size:9px;letter-spacing:1.8px;text-transform:uppercase;
            color:var(--muted);text-align:center;margin-bottom:10px;
            font-family:'Montserrat',sans-serif;font-weight:500;
        }
        .logout-btn{
            width:100%;
            background:rgba(255,255,255,.9);
            border:1px solid rgba(200,80,80,.25);color:#c05050;
            padding:11px 14px;border-radius:10px;
            font-family:'Montserrat',sans-serif;font-size:10px;font-weight:600;
            letter-spacing:1.5px;text-transform:uppercase;cursor:pointer;transition:all .22s ease;
        }
        .logout-btn:hover{
            background:rgba(200,70,70,.08);border-color:rgba(200,80,80,.4);color:#a03030;
        }

        /* MAIN — shell figé : seul .content défile */
        .main{
            flex:1;margin-left:var(--sb-w);display:flex;flex-direction:column;
            min-width:0;min-height:0;height:100%;overflow:hidden;
            transition:margin-left .35s cubic-bezier(.4,0,.2,1);background:var(--surface);
        }
        .admin-wrap.sb-collapsed .main{margin-left:0}
        .topbar{
            display:flex;align-items:center;justify-content:space-between;gap:16px;
            flex:0 0 auto;position:relative;z-index:30;
            padding:12px 28px;min-height:var(--topbar-h);
            background:linear-gradient(180deg,rgba(255,255,255,.99) 0%,rgba(247,245,240,.96) 100%);
            backdrop-filter:blur(18px) saturate(1.4);
            border-bottom:1px solid transparent;
            box-shadow:0 4px 24px rgba(10,23,54,.05);
        }
        .topbar::after{
            content:'';position:absolute;left:0;right:0;bottom:0;height:1px;
            background:linear-gradient(90deg,transparent,rgba(197,160,89,.15),var(--gold),rgba(212,176,106,.8),var(--gold),rgba(197,160,89,.15),transparent);
            background-size:200% 100%;animation:navShimmer 6s linear infinite;opacity:.85;
        }
        .topbar h1{font-family:'Cormorant Garamond',serif;font-size:22px;font-weight:600;letter-spacing:.3px;color:var(--text-dark);line-height:1.2}
        .topbar-left{display:flex;align-items:center;gap:14px;min-width:0}
        .topbar-brand{
            display:flex;align-items:center;gap:12px;cursor:pointer;
            padding:4px 8px 4px 4px;border-radius:12px;border:1px solid transparent;
            transition:all .25s ease;min-width:0;
        }
        .topbar-brand:hover{
            background:rgba(197,160,89,.06);border-color:rgba(197,160,89,.18);
            box-shadow:0 0 18px rgba(197,160,89,.1);
        }
        .top-logo-wrap{
            flex-shrink:0;width:44px;height:44px;border-radius:11px;
            background:linear-gradient(145deg,#fff,rgba(247,245,240,.95));
            border:1px solid rgba(197,160,89,.3);
            box-shadow:0 2px 14px rgba(197,160,89,.12);
            display:flex;align-items:center;justify-content:center;padding:5px;
        }
        .top-logo-wrap img{height:32px;width:auto;border-radius:4px}
        .topbar-brand-text{display:flex;flex-direction:column;gap:1px;min-width:0}
        .topbar-brand-text .top-est{
            font-family:'Montserrat',sans-serif;font-size:9px;letter-spacing:2.5px;
            text-transform:uppercase;color:var(--gold);font-weight:600;
        }
        .topbar-brand-text h1{font-size:20px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:320px}
        .topbar .who{display:flex;align-items:center;gap:12px}
        .topbar .who img{width:42px;height:42px;border-radius:50%;object-fit:cover;border:2px solid var(--gold)}
        .topbar .who b{font-size:14px;color:var(--text-dark);display:block}
        .topbar .who > div > span{font-size:11px;color:var(--gold);text-transform:uppercase;letter-spacing:1px}
        .aj-bell-wrap{position:relative}
        .aj-bell{
            position:relative;width:42px;height:42px;border-radius:12px;cursor:pointer;
            border:1px solid rgba(197,160,89,.35);background:rgba(255,255,255,.9);
            color:var(--navy-mid);display:inline-flex;align-items:center;justify-content:center;
            transition:border-color .2s,background .2s,box-shadow .2s;
        }
        .aj-bell svg{width:20px;height:20px;stroke:currentColor;fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round}
        .aj-bell:hover{border-color:var(--gold);box-shadow:0 0 0 3px rgba(197,160,89,.12)}
        .aj-bell-dot{
            position:absolute;top:-4px;right:-4px;min-width:18px;height:18px;padding:0 5px;
            border-radius:999px;background:#c45454;color:#fff;font-size:10px;font-weight:700;
            display:inline-flex;align-items:center;justify-content:center;line-height:1;
            border:2px solid #fff;
        }
        .aj-bell.is-alert{
            animation:ajBellPulse 1s ease-in-out infinite;
            border-color:#e07070;color:#b45309;background:#fff7f5;
            box-shadow:0 0 0 0 rgba(196,84,84,.45);
        }
        .aj-bell.is-alert .aj-bell-dot{animation:ajBellBlink .8s ease-in-out infinite}
        @keyframes ajBellPulse{
            0%,100%{transform:scale(1);box-shadow:0 0 0 0 rgba(196,84,84,.35)}
            50%{transform:scale(1.06);box-shadow:0 0 0 8px rgba(196,84,84,0)}
        }
        @keyframes ajBellBlink{
            0%,100%{opacity:1}
            50%{opacity:.35}
        }
        .aj-bell-panel{
            position:absolute;top:calc(100% + 10px);right:0;z-index:60;
            width:min(360px,84vw);max-height:420px;overflow:hidden;
            background:#fff;border:1px solid rgba(197,160,89,.35);border-radius:14px;
            box-shadow:0 18px 48px rgba(8,20,51,.18);display:flex;flex-direction:column;
        }
        .aj-bell-panel[hidden]{display:none!important}
        .aj-bell-head{
            display:flex;align-items:center;justify-content:space-between;gap:10px;
            padding:12px 14px;border-bottom:1px solid rgba(197,160,89,.2);
            background:linear-gradient(180deg,#fff,#f8f3e8);
        }
        .aj-bell-head strong{font-size:12px;letter-spacing:.6px;text-transform:uppercase;color:var(--navy-mid)}
        .aj-bell-mark{
            border:none;background:transparent;color:var(--gold);font-size:11px;font-weight:700;
            cursor:pointer;letter-spacing:.4px;text-transform:uppercase;
        }
        .aj-bell-mark:hover{color:var(--navy-mid)}
        .aj-bell-list{overflow:auto;max-height:360px;padding:8px}
        .aj-bell-item{
            padding:10px 12px;border-radius:10px;border:1px solid rgba(197,160,89,.15);
            margin-bottom:8px;background:#fff;cursor:pointer;
        }
        .aj-bell-item:hover{background:#fbf7ef}
        .aj-bell-item.is-unread{border-color:rgba(196,84,84,.35);background:#fff8f6}
        .aj-bell-item b{display:block;font-size:13px;color:var(--navy-mid);margin-bottom:4px}
        .aj-bell-item span{display:block;font-size:11px;color:var(--muted);line-height:1.4}
        .aj-bell-empty{text-align:center;color:var(--muted);font-size:13px;padding:28px 12px;margin:0}
        .hamb{display:none;background:none;border:none;color:var(--gold);font-size:24px;cursor:pointer;padding:4px}
        .sb-toggle{
            flex-shrink:0;width:42px;height:42px;border-radius:11px;cursor:pointer;
            display:flex;align-items:center;justify-content:center;
            background:linear-gradient(145deg,#fff,rgba(247,245,240,.95));
            border:1px solid rgba(197,160,89,.25);color:var(--gold);
            box-shadow:0 2px 14px rgba(197,160,89,.1);
            transition:all .28s ease;
        }
        .sb-toggle:hover{
            border-color:rgba(197,160,89,.45);color:var(--text-dark);
            box-shadow:0 4px 18px rgba(197,160,89,.2);
            transform:scale(1.04);
        }
        .sb-toggle svg{width:20px;height:20px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
        .sb-toggle .ico-expand{display:none}
        .sb-toggle.is-collapsed .ico-collapse{display:none}
        .sb-toggle.is-collapsed .ico-expand{display:block}
        .content{
            padding:30px;flex:1 1 auto;min-height:0;
            display:flex;flex-direction:column;align-items:center;
            background:var(--surface);overflow-x:hidden;overflow-y:auto;
            overscroll-behavior:contain;-webkit-overflow-scrolling:touch;
        }
        .panel{width:100%;max-width:var(--content-max);margin-left:auto;margin-right:auto}
        .panel#ch-etat{max-width:100%}
        .content.dash-view{padding-top:132px;--kpi-bar-h:118px;--lock-top:var(--kpi-bar-h)}
        .content.kpi-view,.content.ch-view{padding-top:150px;--kpi-bar-h:118px;--lock-top:var(--kpi-bar-h)}
        .content.ech-view{padding-top:12px;--kpi-bar-h:0px;--lock-top:0px}
        @media(max-width:1200px){
            .content.dash-view{padding-top:210px;--kpi-bar-h:190px}
            .content.ch-view{padding-top:260px;--kpi-bar-h:210px}
            .content.kpi-view{padding-top:150px;--kpi-bar-h:118px}
            .content.ech-view{padding-top:12px}
        }
        @media(max-width:640px){
            .content.dash-view{padding-top:280px;--kpi-bar-h:250px}
            .content.ch-view{padding-top:360px;--kpi-bar-h:300px}
            .content.kpi-view{padding-top:260px;--kpi-bar-h:210px}
        }
        @media(max-width:600px){.content.ech-view{padding-top:12px}}

        .panel{display:none;animation:fade .35s ease}
        .panel.active{display:block}
        #ch-etat.panel,#ch-etat.panel.active{animation:none!important;transform:none!important}
        @keyframes fade{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)}}
        .panel h2{font-family:'Cormorant Garamond',serif;font-size:30px;color:var(--text-dark);margin-bottom:6px;text-align:center;letter-spacing:1px}
        .panel .sub{color:var(--muted);font-size:14px;margin-bottom:26px;text-align:center}

        .cards{display:grid;grid-template-columns:repeat(auto-fit,minmax(190px,1fr));gap:18px;margin-bottom:30px}
        /* Barres KPI fixes — toutes sections */
        .dash-kpi,.ch-kpi,.section-kpi{
            position:fixed;top:var(--topbar-h);left:var(--sb-w);right:0;z-index:25;
            padding:14px 28px 16px;
            background:linear-gradient(180deg,rgba(255,255,255,.98) 0%,rgba(247,245,240,.96) 100%);
            border-bottom:1px solid var(--border-gold);
            box-shadow:0 8px 32px rgba(10,23,54,.06);
            backdrop-filter:blur(16px);
            transition:left .35s cubic-bezier(.4,0,.2,1);
        }
        .admin-wrap.sb-collapsed .dash-kpi,
        .admin-wrap.sb-collapsed .ch-kpi,
        .admin-wrap.sb-collapsed .section-kpi{left:0}
        .dash-kpi.hidden,.ch-kpi.hidden,.section-kpi.hidden{display:none!important}
        @media(max-width:900px){
            .dash-kpi,.ch-kpi,.section-kpi{left:0;padding:18px 20px}
        }
        .dash-kpi .cards{
            display:grid;grid-template-columns:repeat(5, minmax(0, 1fr));
            gap:20px;margin-bottom:0;max-width:100%;
        }
        .section-kpi .cards{
            display:grid;grid-template-columns:repeat(4,minmax(0,1fr));
            gap:16px;margin-bottom:0;max-width:100%;
        }
        .section-kpi[data-cols="3"] .cards{grid-template-columns:repeat(3,minmax(0,1fr))}
        @media(max-width:1200px){
            .dash-kpi .cards{grid-template-columns:repeat(3, minmax(0, 1fr))}
            .section-kpi .cards,.section-kpi[data-cols="3"] .cards{grid-template-columns:repeat(2,minmax(0,1fr))}
        }
        @media(max-width:768px){.dash-kpi .cards{grid-template-columns:repeat(2, minmax(0, 1fr));gap:14px}}
        @media(max-width:640px){.section-kpi .cards{grid-template-columns:1fr}}
        /* Verrouillage cartes : aucun mouvement au survol */
        .card,.card:hover,
        .section-kpi .card,.dash-kpi .card,
        .cd-card,.cd-card:hover,
        .ch-cat-card,.ch-cat-card:hover,
        .ch-etage-card,.ch-etage-card:hover,
        .rm-card,.rm-card:hover,
        .ech-kpi .ek-card,.ech-kpi .ek-card:hover,
        .dr-card,.dr-card:hover,
        .cc-card,.cc-card:hover,
        .da-card,.da-card:hover,
        .ch-stat-card,.ch-stat-card:hover,
        .ch-room-card,.ch-room-card:hover,
        .bal-row,.bal-row:hover{
            transform:none!important;translate:none!important;
        }

        /* Verrouillage barres d'outils / filtres (sticky dans .content) — hors chambres (évite de masquer les photos) */
        .ech-filters,
        .bc-filters,
        .panel .row-head{
            position:sticky;top:var(--lock-top);z-index:18;
            background:rgba(247,245,240,.97);
            backdrop-filter:blur(12px);
        }
        .ech-filters,.bc-filters{
            box-shadow:0 6px 18px rgba(8,20,51,.08);
        }
        /* Tableau de bord : pas de sticky — la barre ne doit jamais recouvrir les photos */
        #dashboard .dr-head{
            position:static!important;top:auto!important;z-index:auto!important;
            background:transparent!important;backdrop-filter:none!important;box-shadow:none!important;
        }
        .panel .row-head,.cc-tools{
            padding-top:6px;padding-bottom:8px;margin-top:0;
        }

        /* Verrouillage en-têtes de tableaux — collés sous KPI (+ barre outils ~52px) */
        .table-wrap,
        .da-table-wrap,
        .ba-lines-wrap,
        .ra-bons-wrap{
            overflow:visible;
        }
        .table-wrap table,
        .da-table-wrap table,
        .ra-bons-wrap .ra-bons-table,
        .ba-lines-wrap .ba-lines-table,
        .panel table{
            border-collapse:separate;border-spacing:0;
        }
        .table-wrap thead th,
        .da-table-wrap table thead th,
        #dashboard .da-table thead th,
        .ra-bons-wrap .ra-bons-table thead th,
        .ba-lines-wrap .ba-lines-table thead th,
        .panel table thead th{
            position:sticky;top:calc(var(--lock-top) + 52px);z-index:16;
            background:#f8f3e8 !important;
            box-shadow:0 1px 0 rgba(197,160,89,.28);
        }
        /* C-Occupées : jamais de sticky (filtres + thead) — évite en-têtes masqués / décalés */
        #ch-occupees .occ-filters,
        #ch-occupees.panel table thead th,
        #ch-occupees .table-wrap thead th{
            position:static!important;top:auto!important;z-index:auto!important;
            backdrop-filter:none!important;
        }
        /* Si une barre sticky précède le tableau, l'offset 52px évite le chevauchement */

        /* KPI — cartes lumineuses */
        .dash-kpi .card{
            position:relative;overflow:hidden;
            padding:18px 16px 16px 18px;border-radius:14px;
            background:var(--white);
            border:1px solid var(--border-gold);
            box-shadow:var(--shadow-soft);
            transition:none;
            min-height:100px;
            animation:none;
        }
        .dash-kpi .card::before{
            content:'';position:absolute;inset:0;pointer-events:none;border-radius:14px;
            background:radial-gradient(ellipse 80% 60% at 100% 0%,rgba(197,160,89,.06) 0%,transparent 55%);
        }
        .dash-kpi .card .kpi-accent{
            position:absolute;left:0;top:14px;bottom:14px;width:3px;border-radius:0 3px 3px 0;
            background:linear-gradient(180deg, var(--gold-light), var(--gold));
            box-shadow:0 0 16px rgba(201,162,39,.7), 0 0 8px rgba(230,199,90,.5);
        }
        .dash-kpi .card.kpi-chambres .kpi-accent{background:linear-gradient(180deg,#c8dcff,#6b9ef5);box-shadow:0 0 16px rgba(107,158,245,.6)}
        .dash-kpi .card.kpi-occupees .kpi-accent{background:linear-gradient(180deg,#b0f0c8,#45c878);box-shadow:0 0 16px rgba(69,200,120,.55)}
        .dash-kpi .card.kpi-charges .kpi-accent{background:linear-gradient(180deg,#ffc0c0,#e07070);box-shadow:0 0 16px rgba(224,112,112,.55)}
        .dash-kpi .card.kpi-soldedu .kpi-accent{background:linear-gradient(180deg,#e0c8f8,#a87fe0);box-shadow:0 0 16px rgba(168,127,224,.55)}
        .dash-kpi .card.kpi-caisse .kpi-accent{background:linear-gradient(180deg,var(--gold-light),var(--gold));box-shadow:0 0 18px rgba(201,162,39,.75)}
        .dash-kpi .card:hover{
            transform:none;
            border-color:rgba(197,160,89,.35);
            box-shadow:0 8px 28px rgba(197,160,89,.1);
            animation:none;
        }
        .dash-kpi .kpi-icon-wrap{
            position:absolute;top:14px;right:14px;width:38px;height:38px;border-radius:10px;
            display:flex;align-items:center;justify-content:center;
            background:rgba(197,160,89,.1);
            border:1px solid rgba(197,160,89,.22);
            color:var(--gold);
            transition:all .35s ease;
        }
        .dash-kpi .kpi-icon-wrap svg{width:20px;height:20px;stroke:currentColor;fill:none;stroke-width:1.6;stroke-linecap:round;stroke-linejoin:round}
        .dash-kpi .card:hover .kpi-icon-wrap{
            color:var(--navy-mid);border-color:rgba(197,160,89,.4);
            background:rgba(197,160,89,.18);
        }
        .dash-kpi .kpi-body{position:relative;z-index:1;padding-right:44px}
        .dash-kpi .card .l{
            display:block;margin:0 0 10px;
            font-family:'Montserrat',sans-serif;font-size:10px;font-weight:600;
            letter-spacing:2px;text-transform:uppercase;
            color:var(--gold);
        }
        .dash-kpi .card .n{
            font-family:'Cormorant Garamond',serif;font-size:clamp(22px,1.85vw,28px);
            font-weight:700;line-height:1;color:var(--navy-mid);letter-spacing:-.2px;
        }
        .dash-kpi .card .n.money{
            display:flex;align-items:baseline;gap:6px;flex-wrap:wrap;
            font-variant-numeric:tabular-nums;
        }
        .dash-kpi .card .n.money .amt{
            font-family:'Cormorant Garamond',serif;font-size:clamp(20px,1.7vw,26px);
            font-weight:700;color:var(--navy-mid);
        }
        .dash-kpi .card .n.money .unit{
            font-family:'Montserrat',sans-serif;font-size:10px;font-weight:600;
            letter-spacing:2px;color:var(--muted);text-transform:uppercase;
        }
        .dash-kpi .card .kpi-shine{display:none}
        #dashboard.panel.active{min-height:calc(100vh - var(--topbar-h) - 130px)}
        .card{background:var(--white);border:1px solid var(--border-gold);border-radius:14px;padding:22px;box-shadow:var(--shadow-soft)}
        .card .n{font-family:'Cormorant Garamond',serif;font-size:34px;color:var(--navy-mid);line-height:1}
        .card .l{color:var(--muted);font-size:12px;text-transform:uppercase;letter-spacing:1px;margin-top:6px}

        .block{background:var(--white);border:1px solid var(--border-gold);border-radius:14px;padding:22px;margin-bottom:22px;box-shadow:var(--shadow-soft)}
        .block h3{font-size:16px;color:var(--text-dark);margin-bottom:16px;letter-spacing:.5px;text-align:center;font-weight:600}
        table{width:100%;border-collapse:collapse}
        th,td{padding:12px 14px;text-align:center;vertical-align:middle;font-size:13.5px;border-bottom:1px solid rgba(0,0,0,.06)}
        th{color:var(--gold);text-transform:uppercase;font-size:11px;letter-spacing:1px;background:rgba(197,160,89,.06)}
        td{color:var(--text-dark)}
        tr:last-child td{border-bottom:none}
        tr:hover td{background:rgba(197,160,89,.04)}
        .tag{padding:3px 11px;border-radius:20px;font-size:11px;white-space:nowrap}
        .tag.ok{background:rgba(80,200,120,.15);color:#7fd99b}
        .tag.warn{background:rgba(230,199,90,.15);color:var(--gold-light)}
        .tag.bad{background:rgba(230,120,120,.15);color:#e89}
        .btn-gold{background:linear-gradient(135deg,var(--gold),var(--gold-light));color:#1a1304;border:none;
            padding:10px 18px;border-radius:8px;font-weight:600;font-size:12px;letter-spacing:.5px;cursor:pointer;text-transform:uppercase}
        .row-head{display:flex;align-items:center;justify-content:center;margin-bottom:16px;flex-wrap:wrap;gap:10px}

        /* SUB-TABS & FORMS (Fournisseur) */
        .subtabs{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:22px;border-bottom:1px solid var(--border-gold);padding-bottom:12px}
        .subtab{background:var(--white);border:1px solid var(--border-gold);color:var(--text-dark);padding:10px 16px;border-radius:8px;font-size:13px;cursor:pointer;transition:all .2s}
        .subtab:hover{border-color:var(--gold);background:rgba(197,160,89,.06)}
        .subtab.active{background:linear-gradient(135deg,var(--gold),var(--gold-light));color:#1a1304;font-weight:600;box-shadow:0 4px 16px rgba(197,160,89,.25)}
        .subpanel{display:none}
        .subpanel.active{display:block;animation:fade .3s ease}
        html:has(body.hb-lock),body.hb-lock{overflow:hidden!important;height:100%}
        body.hb-lock .content{overflow:hidden;height:calc(100vh - var(--topbar-h));padding-top:18px;padding-bottom:18px}
        body.hb-lock #configuration.panel.active{height:100%;display:flex;flex-direction:column;min-height:0}
        body.hb-lock #cfg-habillage.subpanel.active{
            display:flex;flex-direction:column;flex:1;min-height:0;overflow:hidden;animation:none;
        }
        body.hb-lock #cfg-habillage .block{
            display:flex;flex-direction:column;flex:1;min-height:0;overflow:hidden;margin:0;
            padding-bottom:84px;
        }
        body.hb-lock #cfg-habillage .block > .hb-head-row,
        body.hb-lock #cfg-habillage .block > .hb-parts{flex:0 0 auto}
        body.hb-lock #cfg-habillage .hb-workspace{
            flex:1 1 0;min-height:0;overflow:hidden;
        }
        body.hb-lock .hb-save-bar{
            position:fixed;left:calc(var(--sb-w) + 24px);right:24px;bottom:14px;
            z-index:120;margin:0;width:auto;
        }
        @media(max-width:900px){
            body.hb-lock .hb-save-bar{left:16px;right:16px}
        }
        .hb-workspace{
            display:grid;grid-template-columns:minmax(0,1.35fr) minmax(280px,.9fr);gap:16px;
            align-items:stretch;min-height:0;
        }
        .hb-workspace > *{min-width:0;min-height:0;max-height:100%}
        @media(max-width:1100px){
            .hb-workspace{grid-template-columns:1fr;grid-template-rows:minmax(280px,.55fr) minmax(220px,.45fr)}
        }
        .hb-frame{
            display:none;width:100%;height:100%;min-height:0;border:1px solid rgba(197,160,89,.35);
            border-radius:16px;background:#111;
        }
        .hb-frame.is-on{display:block}
        .hb-liveview{
            position:relative;width:100%;min-height:0;height:100%;border:1px solid rgba(197,160,89,.35);
            border-radius:16px;overflow:hidden;background:var(--hb-color,#1a1520);
        }
        .hb-liveview.is-off{display:none}
        .hb-liveview img{display:block;width:100%;height:100%;object-fit:contain;object-position:center;filter:brightness(var(--hb-light,1))}
        .hb-liveview .hb-live-veil{position:absolute;inset:0;z-index:1;pointer-events:none;background:var(--hb-veil,transparent)}
        .hb-liveview .hb-live-layer{position:absolute;inset:0;z-index:2}
        .hb-liveview .hb-writing{
            position:absolute;z-index:3;left:50%;top:50%;max-width:92%;
            transform:translate(-50%,-50%) scale(var(--hb-wsize,1));transform-origin:center center;
            color:var(--hb-wcolor,#fff);text-align:center;line-height:1.05;cursor:grab;touch-action:none;
            white-space:normal;word-break:normal;user-select:none;
        }
        .hb-liveview .hb-writing.is-on{outline:none}
        .hb-liveview .hb-w-1,.hb-liveview .hb-w-2{display:block}
        .hb-liveview .hb-w-stars,.hb-liveview .hb-w-orn,.hb-liveview .hb-w-2{display:none}
        .hb-liveview .hb-mode-lignes .hb-w-stars,.hb-liveview .hb-mode-lignes .hb-w-orn{display:flex}
        .hb-liveview .hb-mode-lignes .hb-w-2{display:block}
        .hb-liveview .hb-w-stars{align-items:center;justify-content:center;gap:12px;margin:10px 0;color:var(--hb-wcolor,#f6e7b8);width:100%}
        .hb-liveview .hb-w-stars span{display:block;height:1px;flex:1;min-width:36px;max-width:160px;background:linear-gradient(90deg,transparent,var(--hb-wcolor,#f4e4b4) 18%,color-mix(in srgb,var(--hb-wcolor,#fff6d8) 70%,#fff) 50%,var(--hb-wcolor,#f4e4b4) 82%,transparent)}
        .hb-liveview .hb-w-stars b{font-weight:400;letter-spacing:.28em;font-size:.34em;padding-left:.28em}
        .hb-liveview .hb-w-orn{align-items:center;justify-content:center;gap:12px;margin-top:10px;color:var(--hb-wcolor,#f6e7b8);width:100%}
        .hb-liveview .hb-w-orn span{display:block;height:1px;flex:1;min-width:36px;max-width:160px;background:linear-gradient(90deg,transparent,var(--hb-wcolor,#f4e4b4) 18%,color-mix(in srgb,var(--hb-wcolor,#fff6d8) 70%,#fff) 50%,var(--hb-wcolor,#f4e4b4) 82%,transparent)}
        .hb-liveview .hb-w-orn i{font-style:normal;font-size:11px}
        .hb-liveview .hb-style-enseigne{font-size:clamp(28px,4vw,72px)}
        .hb-liveview .hb-style-enseigne .hb-w-1,.hb-liveview .hb-style-enseigne .hb-w-2{
            font-family:'Cinzel',serif;font-weight:700;text-transform:uppercase;
            letter-spacing:.08em;word-spacing:-.42em;white-space:nowrap;
            background:linear-gradient(180deg,color-mix(in srgb,var(--hb-wcolor,#e2b65a) 35%,#fff) 0%,color-mix(in srgb,var(--hb-wcolor,#e2b65a) 75%,#fff) 28%,var(--hb-wcolor,#e2b65a) 62%,color-mix(in srgb,var(--hb-wcolor,#e2b65a) 70%,#000) 100%);
            -webkit-background-clip:text;background-clip:text;color:transparent;-webkit-text-fill-color:transparent;
        }
        .hb-liveview .hb-style-enseigne .hb-w-2{font-size:.9em;letter-spacing:.1em;word-spacing:-.48em}
        .hb-liveview .hb-style-classique{font-family:'Cormorant Garamond',serif;font-weight:600;font-size:clamp(26px,3.6vw,58px);text-shadow:0 3px 18px rgba(0,0,0,.35)}
        .hb-liveview .hb-style-signature{font-family:'Cormorant Garamond',serif;font-style:italic;font-weight:600;font-size:clamp(24px,3.2vw,52px);text-shadow:0 3px 18px rgba(0,0,0,.28)}
        .hb-liveview .hb-style-moderne{font-family:'Montserrat',sans-serif;font-weight:700;letter-spacing:.18em;text-transform:uppercase;font-size:clamp(14px,1.8vw,28px);text-shadow:0 2px 12px rgba(0,0,0,.35)}
        .hb-liveview .hb-style-lisere{font-family:'Cormorant Garamond',serif;font-weight:600;letter-spacing:.16em;text-transform:uppercase;font-size:clamp(22px,2.8vw,44px)}
        .hb-liveview .hb-style-lisere .hb-w-1{border-bottom:1px solid #e8c56a;padding-bottom:8px}
        .hb-liveview .hb-style-contour{font-family:'Cinzel',serif;font-weight:700;letter-spacing:.14em;text-transform:uppercase;font-size:clamp(24px,3.4vw,56px);color:transparent;-webkit-text-stroke:1.5px var(--hb-wcolor,#fff)}
        .hb-liveview .hb-style-neon{font-family:'Montserrat',sans-serif;font-weight:700;letter-spacing:.12em;text-transform:uppercase;font-size:clamp(16px,2vw,34px);text-shadow:0 0 8px var(--hb-wcolor,#fff),0 0 22px var(--hb-wcolor,#fff)}
        .hb-liveview .hb-mode-bandeau{background:rgba(6,15,36,.62);padding:12px 18px;border-radius:10px}
        .hb-liveview .hb-mode-encadre{border:1px solid currentColor;padding:12px 18px}
        .hb-liveview .hb-writing.hb-mode-incline{transform:translate(-50%,-50%) rotate(-8deg) scale(var(--hb-wsize,1))}
        .hb-liveview .hb-writing.hb-mode-vertical{writing-mode:vertical-rl;text-orientation:mixed}
        .hb-liveview .hb-resize{position:absolute;right:-12px;bottom:-12px;width:16px;height:16px;border-radius:4px;background:#fff;border:2px solid #c5a059;cursor:nwse-resize}
        .hb-tools{
            display:flex;flex-direction:column;gap:0;min-width:0;min-height:0;height:100%;
            overflow:hidden;padding:0;
        }
        .hb-tools-scroll{
            flex:1 1 auto;min-height:0;height:100%;overflow-x:hidden;overflow-y:auto;overscroll-behavior:contain;
            display:flex;flex-direction:column;gap:12px;padding:0 8px 12px 2px;scrollbar-gutter:stable;
        }
        .hb-tools-scroll::-webkit-scrollbar{width:8px}
        .hb-tools-scroll::-webkit-scrollbar-thumb{background:rgba(197,160,89,.45);border-radius:999px}
        .hb-tools-scroll::-webkit-scrollbar-track{background:rgba(197,160,89,.08);border-radius:999px}
        .hb-tools-scroll .hb-card{flex:0 0 auto}
        .hb-head-row{
            display:flex;align-items:flex-start;justify-content:space-between;gap:14px;
            margin:0 0 12px;position:relative;z-index:30;
        }
        .hb-head-row h3{margin:0 0 4px}
        .hb-save-bar{
            display:flex;align-items:center;justify-content:flex-end;gap:12px;flex-wrap:wrap;
            padding:14px 16px;margin-top:12px;border-radius:14px;
            background:#1a2332;border:2px solid #c5a059;
            box-shadow:0 12px 32px rgba(0,0,0,.35);z-index:120;
        }
        .hb-save-bar .hb-actions{display:flex;gap:10px;flex-wrap:wrap;margin-left:auto}
        .hb-save-bar .btn{
            display:inline-flex;align-items:center;justify-content:center;
            padding:14px 28px;font-size:14px;font-weight:800;min-width:160px;
            text-transform:uppercase;letter-spacing:.6px;
        }
        .hb-save-bar .btn.gold{
            background:linear-gradient(135deg,#f0cf85,#c5a059);color:#1a1304;
            box-shadow:0 8px 22px rgba(197,160,89,.55);
        }
        .hb-save-bar .btn.ghost{
            background:rgba(255,255,255,.06);color:#f6e7b8;border:1px solid rgba(246,231,184,.45);
        }
        .hb-save-bar .hb-note{color:#f6e7b8!important;margin:0;margin-right:auto;flex:1 1 140px;font-size:12px}
        #hbWriteBox[hidden]{display:none!important}
        .hb-card{
            background:#fff;border:1px solid rgba(197,160,89,.28);border-radius:14px;
            padding:14px 14px 12px;box-shadow:0 8px 22px rgba(10,23,54,.04);
        }
        .hb-card-head{
            display:flex;align-items:center;justify-content:space-between;gap:10px;
            margin:0 0 12px;padding-bottom:10px;border-bottom:1px solid rgba(197,160,89,.18);
        }
        .hb-card-head h4{margin:0;font-size:13px;font-weight:700;letter-spacing:.6px;text-transform:uppercase;color:#1a2332}
        .hb-card-head p{margin:0;font-size:11px;color:#6b7280}
        .hb-parts{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:8px;margin-bottom:14px}
        @media(max-width:900px){.hb-parts{grid-template-columns:repeat(2,minmax(0,1fr))}}
        .hb-part{
            padding:12px 12px;border-radius:12px;border:1px solid rgba(197,160,89,.35);
            background:#fff;color:#8a6a2f;cursor:pointer;text-align:left;
        }
        .hb-part b{display:block;font-size:12px;font-weight:700;letter-spacing:.3px}
        .hb-part span{display:block;margin-top:3px;font-size:10px;color:#6b7280;line-height:1.3}
        .hb-part.is-on{background:linear-gradient(135deg,#c5a059,#e7b15a);color:#1a1304;border-color:transparent}
        .hb-part.is-on span{color:rgba(26,19,4,.72)}
        .hb-part-panel{display:none}
        .hb-part-panel.is-on{display:block}
        .hb-presets{display:flex;flex-wrap:wrap;gap:6px}
        .hb-presets button,.hb-actions button,.hb-styles button,.hb-modes button{border-radius:9px;cursor:pointer;font-size:11px;font-weight:700}
        .hb-presets button{padding:7px 10px;border:1px solid rgba(197,160,89,.4);background:#fff;color:#8a6a2f}
        .hb-presets button:hover,.hb-presets button.is-on{background:linear-gradient(135deg,#c5a059,#e7b15a);color:#1a1304;border-color:transparent}
        .hb-fields{display:grid;grid-template-columns:1fr 1fr;gap:10px}
        .hb-fields .span2{grid-column:1/-1}
        .hb-fields label{display:flex;align-items:center;justify-content:space-between;gap:8px;font-size:10px;font-weight:700;letter-spacing:.8px;text-transform:uppercase;color:#8a6a2f;margin-bottom:5px}
        .hb-fields label b{font-size:11px;color:#1a2332;letter-spacing:0;text-transform:none}
        .hb-fields input[type="text"],.hb-fields select,.hb-fields input[type="file"],.hb-fields textarea{width:100%;padding:9px 11px;border-radius:9px;border:1px solid rgba(197,160,89,.35);background:#fff;color:#1a2332;font-size:13px}
        .hb-fields textarea{min-height:96px;resize:vertical;line-height:1.45;font-family:inherit}
        .hb-fields input[type="color"]{width:54px;height:38px;padding:3px;border-radius:9px;border:1px solid rgba(197,160,89,.35);background:#fff;cursor:pointer;flex-shrink:0}
        .hb-color-row{display:flex;align-items:center;gap:10px}
        .hb-color-swatches{display:flex;flex-wrap:wrap;gap:6px;align-items:center}
        .hb-color-swatches button{
            width:24px;height:24px;border-radius:50%;border:1px solid rgba(0,0,0,.15);
            cursor:pointer;padding:0;box-shadow:inset 0 0 0 1px rgba(255,255,255,.35);
        }
        .hb-color-swatches button.is-on{outline:2px solid #c5a059;outline-offset:2px}
        .hb-check{
            display:flex!important;align-items:center;justify-content:flex-start!important;gap:10px;
            margin:0!important;cursor:pointer;user-select:none;text-transform:none!important;letter-spacing:0!important;
            color:#1a2332!important;font-size:13px!important;font-weight:600!important;
        }
        .hb-check input{position:absolute;opacity:0;width:1px;height:1px;pointer-events:none}
        .hb-check-box{
            width:20px;height:20px;border-radius:6px;border:1.5px solid rgba(197,160,89,.55);
            background:#fff;display:inline-grid;place-items:center;flex-shrink:0;
            box-shadow:inset 0 1px 2px rgba(0,0,0,.04);
        }
        .hb-check-box::after{
            content:'';width:10px;height:6px;border-left:2px solid #fff;border-bottom:2px solid #fff;
            transform:rotate(-45deg) translate(1px,-1px);opacity:0;
        }
        .hb-check input:checked + .hb-check-box{
            background:linear-gradient(180deg,#d4a94f,#b8862f);border-color:#b8862f;
        }
        .hb-check input:checked + .hb-check-box::after{opacity:1}
        .hb-check-txt{color:#1a2332;font-size:13px;font-weight:600;letter-spacing:.2px}
        .hb-svc-list{display:flex;flex-direction:column;gap:8px}
        .hb-svc-row{
            display:flex;align-items:center;justify-content:space-between;gap:10px;
            padding:10px 12px;border-radius:10px;border:1px solid rgba(197,160,89,.22);background:#fff;
        }
        .hb-svc-row.is-off{opacity:.55;background:#f7f5f0}
        .hb-svc-row .hb-svc-meta{display:flex;align-items:center;gap:10px;min-width:0}
        .hb-svc-row .hb-svc-ico{
            width:36px;height:36px;border-radius:50%;display:grid;place-items:center;
            background:rgba(197,160,89,.12);border:1px solid rgba(197,160,89,.25);font-size:18px;flex-shrink:0;
        }
        .hb-svc-row b{font-size:12px;color:#1a2332;letter-spacing:.3px;text-transform:uppercase}
        .hb-svc-toggle{
            width:34px;height:34px;border-radius:50%;border:1px solid rgba(197,160,89,.45);
            background:#fff;color:#8a6a2f;cursor:pointer;font-size:15px;line-height:1;
            display:inline-flex;align-items:center;justify-content:center;
        }
        .hb-svc-row.is-off .hb-svc-toggle{background:#1a2332;color:#f6e7b8;border-color:#1a2332}
        .hb-liveview .hb-writing.hb-light-none .hb-w-1,
        .hb-liveview .hb-writing.hb-light-none .hb-w-2,
        .hb-liveview .hb-writing.hb-light-none .hb-w-stars,
        .hb-liveview .hb-writing.hb-light-none .hb-w-orn,
        .hb-liveview .hb-writing.hb-nolight .hb-w-1,
        .hb-liveview .hb-writing.hb-nolight .hb-w-2{
            filter:none!important;text-shadow:none!important;
        }
        .hb-liveview .hb-writing.hb-light-soft .hb-w-1,
        .hb-liveview .hb-writing.hb-light-soft .hb-w-2{filter:drop-shadow(0 2px 2px rgba(0,0,0,.35))!important;text-shadow:0 2px 10px rgba(0,0,0,.28)!important}
        .hb-liveview .hb-writing.hb-light-glow .hb-w-1,
        .hb-liveview .hb-writing.hb-light-glow .hb-w-2{filter:drop-shadow(0 0 6px color-mix(in srgb,var(--hb-wcolor,#fff) 65%,transparent)) drop-shadow(0 0 16px color-mix(in srgb,var(--hb-wcolor,#fff) 40%,transparent))!important;text-shadow:0 0 14px color-mix(in srgb,var(--hb-wcolor,#fff) 55%,transparent)!important}
        .hb-liveview .hb-writing.hb-light-forte .hb-w-1,
        .hb-liveview .hb-writing.hb-light-forte .hb-w-2{filter:drop-shadow(0 4px 8px rgba(0,0,0,.45)) drop-shadow(0 0 14px color-mix(in srgb,var(--hb-wcolor,#fff) 50%,transparent))!important;text-shadow:0 3px 16px rgba(0,0,0,.4),0 0 22px color-mix(in srgb,var(--hb-wcolor,#fff) 45%,transparent)!important}
        .hb-liveview .hb-writing.hb-light-neon .hb-w-1,
        .hb-liveview .hb-writing.hb-light-neon .hb-w-2{filter:drop-shadow(0 0 4px var(--hb-wcolor,#fff)) drop-shadow(0 0 14px var(--hb-wcolor,#fff)) drop-shadow(0 0 28px color-mix(in srgb,var(--hb-wcolor,#fff) 60%,transparent))!important;text-shadow:0 0 8px var(--hb-wcolor,#fff),0 0 20px var(--hb-wcolor,#fff)!important}
        .hb-liveview .hb-writing.hb-light-or .hb-w-1,
        .hb-liveview .hb-writing.hb-light-or .hb-w-2{filter:drop-shadow(0 0 8px rgba(232,190,110,.55)) drop-shadow(0 2px 4px rgba(0,0,0,.35))!important;text-shadow:0 0 12px rgba(246,231,184,.55),0 0 24px rgba(197,160,89,.4)!important}
        .hb-liveview .hb-writing.hb-light-relief .hb-w-1,
        .hb-liveview .hb-writing.hb-light-relief .hb-w-2{filter:drop-shadow(1px 1px 0 rgba(255,255,255,.35)) drop-shadow(-1px -1px 0 rgba(0,0,0,.35)) drop-shadow(0 3px 6px rgba(0,0,0,.4))!important;text-shadow:1px 1px 0 rgba(255,255,255,.25),-1px -1px 0 rgba(0,0,0,.35)!important}
        .hb-liveview .hb-writing.hb-light-halo .hb-w-1,
        .hb-liveview .hb-writing.hb-light-halo .hb-w-2{filter:drop-shadow(0 0 12px rgba(255,255,255,.35)) drop-shadow(0 0 28px color-mix(in srgb,var(--hb-wcolor,#fff) 35%,transparent))!important;text-shadow:0 0 18px rgba(255,255,255,.4),0 0 36px color-mix(in srgb,var(--hb-wcolor,#fff) 30%,transparent)!important}
        .hb-liveview .hb-style-enseigne.hb-light-soft .hb-w-1,
        .hb-liveview .hb-style-enseigne.hb-light-soft .hb-w-2,
        .hb-liveview .hb-style-enseigne.hb-light-glow .hb-w-1,
        .hb-liveview .hb-style-enseigne.hb-light-glow .hb-w-2,
        .hb-liveview .hb-style-enseigne.hb-light-forte .hb-w-1,
        .hb-liveview .hb-style-enseigne.hb-light-forte .hb-w-2,
        .hb-liveview .hb-style-enseigne.hb-light-neon .hb-w-1,
        .hb-liveview .hb-style-enseigne.hb-light-neon .hb-w-2,
        .hb-liveview .hb-style-enseigne.hb-light-or .hb-w-1,
        .hb-liveview .hb-style-enseigne.hb-light-or .hb-w-2,
        .hb-liveview .hb-style-enseigne.hb-light-relief .hb-w-1,
        .hb-liveview .hb-style-enseigne.hb-light-relief .hb-w-2,
        .hb-liveview .hb-style-enseigne.hb-light-halo .hb-w-1,
        .hb-liveview .hb-style-enseigne.hb-light-halo .hb-w-2{text-shadow:none!important}
        .hb-liveview .hb-writing.hb-nostars .hb-w-stars,
        .hb-liveview .hb-writing.hb-nostars .hb-w-orn{display:none!important}
        .hb-lights{display:flex;flex-wrap:wrap;gap:6px}
        .hb-lights button{
            border:1px solid rgba(197,160,89,.3);background:#fff;color:#1a2332;border-radius:999px;
            padding:7px 11px;font-size:11px;font-weight:700;cursor:pointer;letter-spacing:.3px;
        }
        .hb-lights button.is-on{background:linear-gradient(135deg,#c5a059,#e7b15a);color:#1a1304;border-color:transparent}
        .hb-range{display:flex;align-items:center;gap:8px;min-height:38px}
        .hb-range input{flex:1;width:100%}
        .hb-picks{display:flex;gap:8px;flex-wrap:wrap;max-height:168px;overflow:auto;padding:2px}
        .hb-picks button{width:72px;height:48px;border-radius:8px;border:2px solid transparent;background-size:cover;background-position:center;cursor:pointer;box-shadow:inset 0 0 0 1px rgba(0,0,0,.15);flex:0 0 auto}
        .hb-picks button.is-on{border-color:#c5a059}
        .hb-styles,.hb-modes{display:flex;flex-wrap:wrap;gap:6px}
        .hb-styles button,.hb-modes button{padding:7px 10px;border:1px solid rgba(197,160,89,.4);background:#fff;color:#8a6a2f}
        .hb-styles button.is-on,.hb-styles button:hover{background:linear-gradient(135deg,#c5a059,#e7b15a);color:#1a1304;border-color:transparent}
        .hb-modes button.is-on,.hb-modes button:hover{background:linear-gradient(135deg,#0a1736,#1a3a6b);color:#fff;border-color:transparent}
        .hb-note{min-height:1.1em;margin:0;font-size:12px;color:#059669}
        .hb-actions{display:flex;gap:8px;flex-wrap:wrap;align-items:center}
        .hb-actions .btn{padding:9px 14px}
        .hb-write-empty{margin:0;font-size:12px;color:#6b7280;line-height:1.45}
        .form-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(170px,1fr));gap:14px;margin-bottom:16px}
        .form-flex{display:flex;flex-wrap:wrap;gap:14px;margin-bottom:4px;justify-content:center}
        .form-flex .field{display:flex;flex-direction:column;margin-bottom:0}
        .ibtn{background:var(--white);border:1px solid var(--border-gold);color:var(--text-dark);width:32px;height:32px;border-radius:7px;cursor:pointer;font-size:14px;margin-right:5px;transition:all .2s}
        .ibtn:hover{border-color:var(--gold);color:var(--gold);background:rgba(197,160,89,.08)}
        .ibtn.del:hover{border-color:#e89;color:#c05050;background:rgba(230,120,120,.08)}
        .actions{display:flex;gap:10px;flex-wrap:wrap;margin:6px 0 4px;justify-content:center;align-items:center}
        .actions .ibtn{align-self:center;flex-shrink:0}
        .btn{border:none;cursor:pointer;padding:10px 18px;border-radius:8px;font-size:12px;font-weight:600;letter-spacing:.5px;text-transform:uppercase;transition:all .2s}
        .btn.gold{background:linear-gradient(135deg,var(--gold),var(--gold-light));color:#1a1304}
        .btn.ghost{background:var(--white);border:1px solid rgba(197,160,89,.35);color:var(--gold)}
        .btn:hover{transform:translateY(-2px);box-shadow:0 6px 16px rgba(197,160,89,.25)}
        .tbtn{background:var(--white);border:1px solid var(--border-gold);color:var(--text-dark);padding:5px 10px;border-radius:6px;font-size:11px;cursor:pointer;margin-right:4px;transition:all .2s}
        .tbtn:hover{border-color:var(--gold);color:var(--gold)}
        .tbtn.del:hover{border-color:#e89;color:#c05050}
        .table-wrap{border-radius:12px;border:1px solid var(--border-gold);background:var(--white)}
        .empty-row td{text-align:center;color:var(--muted);padding:22px}
        .bal-list{display:flex;flex-direction:column;gap:8px;margin:6px 0 16px}
        .bal-row{display:flex;align-items:center;gap:14px;flex-wrap:wrap;background:var(--white);border:1px solid var(--border-gold);border-radius:10px;padding:12px 14px;justify-content:center;box-shadow:var(--shadow-soft)}
        .bal-row label.chk{display:flex;align-items:center;gap:8px;font-size:14px;color:var(--text-dark);min-width:180px}
        .bal-row .mnt{color:var(--text-dark);font-weight:600;font-size:14px;min-width:130px}
        .bal-row .sld{color:var(--navy-mid);font-weight:600;font-size:14px;min-width:130px}
        .bal-row input.pay{width:130px;background:var(--white);border:1px solid var(--border-gold);border-radius:7px;padding:8px 10px;color:var(--text-dark);font-size:13px;outline:none}
        .bal-block{margin-bottom:14px}
        .ra-bons-wrap{margin:10px 0 4px;padding:12px 14px;background:rgba(247,245,240,.8);border:1px solid var(--border-gold);border-radius:10px}
        .ra-bons-wrap .hint{margin-bottom:8px;color:var(--gold);font-weight:600}
        .ra-bons-table{width:100%;border-collapse:collapse;margin-top:4px}
        .ra-bons-table th,.ra-bons-table td{font-size:12.5px;padding:9px 10px;text-align:center}
        .ra-bons-table th{color:var(--gold);font-size:10px;text-transform:uppercase;letter-spacing:1px}
        .hint{font-size:12px;color:var(--muted);margin-bottom:10px;text-align:center}

        /* ===== ÉTAT CHAMBRES ===== */
        .ech-sticky{
            position:fixed;top:var(--topbar-h);left:var(--sb-w);right:0;z-index:25;
            padding:16px 32px 14px;
            background:linear-gradient(180deg,rgba(255,255,255,.98) 0%,rgba(247,245,240,.96) 100%);
            border-bottom:1px solid var(--border-gold);
            box-shadow:0 8px 32px rgba(10,23,54,.06);
            backdrop-filter:blur(16px);
            transition:left .35s cubic-bezier(.4,0,.2,1);
        }
        .admin-wrap.sb-collapsed .ech-sticky{left:0}
        .ech-sticky.hidden{display:none}
        .ech-header{display:flex;align-items:center;justify-content:flex-end;margin-bottom:14px}
        .ech-legend{display:flex;flex-wrap:wrap;gap:10px}
        .ech-leg{
            display:inline-flex;align-items:center;gap:7px;padding:6px 12px;border-radius:20px;
            font-family:'Montserrat',sans-serif;font-size:10px;font-weight:600;letter-spacing:1px;text-transform:uppercase;
            background:var(--white);border:1px solid var(--border-gold);color:var(--text-dark);
        }
        .ech-leg i{width:10px;height:10px;border-radius:50%;flex-shrink:0;box-shadow:0 0 8px currentColor}
        .ech-leg.st-occupee i{background:#45c878;color:#45c878}
        .ech-leg.st-disponible i{background:#e6c75a;color:#e6c75a}
        .ech-leg.st-reservee i{background:#5b9ef5;color:#5b9ef5}
        .ech-leg.st-nettoyage i{background:#8a94a8;color:#8a94a8}
        .ech-leg.st-maintenance i{background:#e07070;color:#e07070}
        .ech-kpi{
            display:grid;grid-template-columns:repeat(6,minmax(0,1fr));gap:14px;margin-bottom:14px;
        }
        @media(max-width:1200px){.ech-kpi{grid-template-columns:repeat(3,minmax(0,1fr))}}
        @media(max-width:600px){.ech-kpi{grid-template-columns:repeat(2,minmax(0,1fr))}}
        .ech-kpi .ek-card{
            position:relative;overflow:hidden;padding:16px 14px 14px 16px;border-radius:12px;
            background:var(--white);
            border:1px solid var(--border-gold);
            box-shadow:var(--shadow-soft);
            transition:transform .3s ease,box-shadow .3s ease;
        }
        .ech-kpi .ek-card:hover{transform:none;box-shadow:0 4px 18px rgba(197,160,89,.08)}
        .ech-kpi .ek-accent{position:absolute;left:0;top:12px;bottom:12px;width:3px;border-radius:0 3px 3px 0}
        .ech-kpi .ek-lbl{display:block;font-family:'Montserrat',sans-serif;font-size:9px;font-weight:600;letter-spacing:1.6px;text-transform:uppercase;color:var(--muted);margin-bottom:8px}
        .ech-kpi .ek-val{font-family:'Cormorant Garamond',serif;font-size:26px;font-weight:700;color:var(--navy-mid);line-height:1}
        .ech-kpi .ek-card.ek-total .ek-accent{background:linear-gradient(180deg,#c8dcff,#6b9ef5);box-shadow:0 0 12px rgba(107,158,245,.5)}
        .ech-kpi .ek-card.ek-dispo .ek-accent{background:linear-gradient(180deg,#f5e6a0,#e6c75a);box-shadow:0 0 12px rgba(230,199,90,.5)}
        .ech-kpi .ek-card.ek-occu .ek-accent{background:linear-gradient(180deg,#b0f0c8,#45c878);box-shadow:0 0 12px rgba(69,200,120,.5)}
        .ech-kpi .ek-card.ek-resa .ek-accent{background:linear-gradient(180deg,#a8c8ff,#5b9ef5);box-shadow:0 0 12px rgba(91,158,245,.5)}
        .ech-kpi .ek-card.ek-nett .ek-accent{background:linear-gradient(180deg,#b8c0d0,#8a94a8);box-shadow:0 0 12px rgba(138,148,168,.4)}
        .ech-kpi .ek-card.ek-maint .ek-accent{background:linear-gradient(180deg,#ffc0c0,#e07070);box-shadow:0 0 12px rgba(224,112,112,.5)}
        .ech-kpi .ek-card.ek-dispo .ek-val{color:var(--gold)}
        .ech-kpi .ek-card.ek-occu .ek-val{color:#2a9d5c}
        .ech-kpi .ek-card.ek-resa .ek-val{color:#4a7fd4}
        .ech-filter{
            background:var(--white);border:1px solid var(--border-gold);color:var(--text-dark);
            padding:8px 16px;border-radius:20px;font-family:'Montserrat',sans-serif;font-size:11px;font-weight:600;
            letter-spacing:.8px;text-transform:uppercase;cursor:pointer;transition:all .25s ease;
        }
        .ech-filter:hover{border-color:rgba(197,160,89,.45);background:rgba(197,160,89,.06)}
        .ech-filter.active{background:linear-gradient(135deg,var(--gold),var(--gold-light));color:#1a1304;border-color:transparent;box-shadow:0 4px 16px rgba(197,160,89,.25)}
        .ech-filters{display:flex;flex-wrap:wrap;gap:8px;margin-bottom:0;padding-bottom:0;border-bottom:none}
        .ech-section{margin-bottom:36px}
        .ech-section-head{
            display:flex;align-items:center;gap:14px;margin-bottom:18px;padding-bottom:12px;
            border-bottom:1px solid var(--border-gold);
        }
        .ech-section-head h3{
            font-family:'Cormorant Garamond',serif;font-size:22px;color:var(--text-dark);margin:0;letter-spacing:.3px;
        }
        .ech-section-head .ech-count{
            font-family:'Montserrat',sans-serif;font-size:10px;font-weight:600;letter-spacing:1.5px;
            text-transform:uppercase;color:var(--gold);background:rgba(201,162,39,.1);
            border:1px solid rgba(201,162,39,.2);padding:4px 10px;border-radius:20px;
        }
        .ech-grid{display:grid;grid-template-columns:repeat(6,minmax(0,1fr));gap:14px;align-items:stretch}
        @media(max-width:1400px){.ech-grid{grid-template-columns:repeat(4,minmax(0,1fr))}}
        @media(max-width:1050px){.ech-grid{grid-template-columns:repeat(3,minmax(0,1fr))}}
        @media(max-width:720px){.ech-grid{grid-template-columns:repeat(2,minmax(0,1fr));gap:12px}}
        .rm-card{
            position:relative;border-radius:12px;overflow:hidden;cursor:pointer;
            display:flex;flex-direction:column;height:100%;
            background:var(--white);
            border:1px solid var(--border-gold);
            box-shadow:var(--shadow-soft);
            transition:transform .35s cubic-bezier(.4,0,.2,1),box-shadow .35s ease,border-color .35s ease;
        }
        .rm-card::after{
            content:'';position:absolute;inset:0;pointer-events:none;border-radius:12px;z-index:1;
        }
        .rm-img,.rm-body,.rm-badge,.rm-card-main{position:relative;z-index:2}
        .rm-card-main{flex:1;display:flex;flex-direction:column;min-height:0}
        .rm-body{flex:1}
        .rm-card.st-occupee{
            border-color:rgba(69,200,120,.42);
            box-shadow:0 4px 18px rgba(0,0,0,.2),0 0 24px rgba(69,200,120,.28),inset 0 0 40px rgba(69,200,120,.06);
        }
        .rm-card.st-occupee::after{background:radial-gradient(ellipse 90% 55% at 50% 0%,rgba(69,200,120,.16),transparent 68%)}
        .rm-card.st-disponible{
            border-color:rgba(230,199,90,.42);
            box-shadow:0 4px 18px rgba(0,0,0,.2),0 0 24px rgba(230,199,90,.26),inset 0 0 40px rgba(230,199,90,.05);
        }
        .rm-card.st-disponible::after{background:radial-gradient(ellipse 90% 55% at 50% 0%,rgba(230,199,90,.14),transparent 68%)}
        .rm-card.st-reservee{
            border-color:rgba(91,158,245,.42);
            box-shadow:0 4px 18px rgba(0,0,0,.2),0 0 24px rgba(91,158,245,.28),inset 0 0 40px rgba(91,158,245,.06);
        }
        .rm-card.st-reservee::after{background:radial-gradient(ellipse 90% 55% at 50% 0%,rgba(91,158,245,.16),transparent 68%)}
        .rm-card.st-nettoyage{
            border-color:rgba(138,148,168,.38);
            box-shadow:0 4px 18px rgba(0,0,0,.2),0 0 20px rgba(138,148,168,.2),inset 0 0 40px rgba(138,148,168,.04);
        }
        .rm-card.st-nettoyage::after{background:radial-gradient(ellipse 90% 55% at 50% 0%,rgba(138,148,168,.12),transparent 68%)}
        .rm-card.st-maintenance{
            border-color:rgba(224,112,112,.42);
            box-shadow:0 4px 18px rgba(0,0,0,.2),0 0 24px rgba(224,112,112,.28),inset 0 0 40px rgba(224,112,112,.06);
        }
        .rm-card.st-maintenance::after{background:radial-gradient(ellipse 90% 55% at 50% 0%,rgba(224,112,112,.16),transparent 68%)}
        .rm-card::before{
            content:'';position:absolute;left:0;top:0;bottom:0;width:4px;z-index:2;
        }
        .rm-card.st-occupee::before{background:linear-gradient(180deg,#9ee8b8,#45c878);box-shadow:0 0 16px rgba(69,200,120,.6)}
        .rm-card.st-disponible::before{background:linear-gradient(180deg,#f5e6a0,#e6c75a);box-shadow:0 0 16px rgba(230,199,90,.6)}
        .rm-card.st-reservee::before{background:linear-gradient(180deg,#a8c8ff,#5b9ef5);box-shadow:0 0 16px rgba(91,158,245,.6)}
        .rm-card.st-nettoyage::before{background:linear-gradient(180deg,#c0c8d8,#8a94a8);box-shadow:0 0 12px rgba(138,148,168,.5)}
        .rm-card.st-maintenance::before{background:linear-gradient(180deg,#ffc0c0,#e07070);box-shadow:0 0 16px rgba(224,112,112,.6)}
        .rm-card:hover{transform:none!important}
        .rm-card.st-occupee:hover{box-shadow:0 4px 18px rgba(0,0,0,.2),0 0 24px rgba(69,200,120,.28)}
        .rm-card.st-disponible:hover{box-shadow:0 4px 18px rgba(0,0,0,.2),0 0 24px rgba(230,199,90,.28)}
        .rm-card.st-reservee:hover{box-shadow:0 4px 18px rgba(0,0,0,.2),0 0 24px rgba(91,158,245,.28)}
        .rm-card.st-nettoyage:hover{box-shadow:0 4px 18px rgba(0,0,0,.2),0 0 20px rgba(138,148,168,.25)}
        .rm-card.st-maintenance:hover{box-shadow:0 4px 18px rgba(0,0,0,.2),0 0 24px rgba(224,112,112,.28)}
        .rm-img{position:relative;height:118px;overflow:hidden}
        .rm-img img{width:100%;height:100%;object-fit:cover;transform:none!important;transition:none!important}
        .rm-card:hover .rm-img img{transform:none!important}
        .rm-img::after{
            content:'';position:absolute;inset:0;
            background:linear-gradient(180deg,transparent 35%,rgba(26,35,50,.55) 100%);
        }
        .rm-badge{
            display:block;width:100%;margin-top:auto;flex-shrink:0;
            padding:8px 10px;text-align:center;
            font-family:'Montserrat',sans-serif;font-size:9px;font-weight:700;
            letter-spacing:1.2px;text-transform:uppercase;border-top:1px solid rgba(255,255,255,.06);
        }
        .rm-card.st-occupee .rm-badge{background:rgba(69,200,120,.15);color:#9ee8b8;border-top-color:rgba(69,200,120,.25)}
        .rm-card.st-disponible .rm-badge{background:rgba(230,199,90,.12);color:#f3e4a8;border-top-color:rgba(230,199,90,.25)}
        .rm-card.st-reservee .rm-badge{background:rgba(91,158,245,.15);color:#a8c8ff;border-top-color:rgba(91,158,245,.25)}
        .rm-card.st-nettoyage .rm-badge{background:rgba(138,148,168,.12);color:#c0c8d8;border-top-color:rgba(138,148,168,.2)}
        .rm-card.st-maintenance .rm-badge{background:rgba(224,112,112,.15);color:#ffc0c0;border-top-color:rgba(224,112,112,.25)}
        .rm-num{
            position:absolute;bottom:8px;left:10px;z-index:2;
            font-family:'Playfair Display',serif;font-size:17px;font-weight:700;color:#fff;
            text-shadow:0 2px 12px rgba(0,0,0,.5);
        }
        .rm-edit-btn{
            position:absolute;top:8px;right:8px;z-index:3;
            width:32px;height:32px;border-radius:8px;border:1px solid rgba(201,162,39,.45);
            background:rgba(0,0,0,.58);color:var(--gold-light);cursor:pointer;
            display:flex;align-items:center;justify-content:center;
            transition:background .2s,transform .2s,color .2s;
        }
        .rm-edit-btn:hover{background:rgba(201,162,39,.38);color:#fff;transform:scale(1.06)}
        .rm-edit-btn svg{display:block}
        .rm-edit-preview{
            border-radius:10px;overflow:hidden;height:140px;border:1px solid rgba(201,162,39,.2);
            background:rgba(0,0,0,.25);
        }
        .rm-edit-preview img{width:100%;height:100%;object-fit:cover}
        .rm-body{padding:12px 12px 10px 14px}
        .rm-type{
            display:inline-block;font-family:'Montserrat',sans-serif;font-size:8px;font-weight:600;
            letter-spacing:1.2px;text-transform:uppercase;color:var(--gold);margin-bottom:4px;
        }
        .rm-body h4{
            font-family:'Cormorant Garamond',serif;font-size:17px;color:var(--text-dark);margin:0 0 5px;line-height:1.2;
        }
        .rm-desc{
            font-size:11.5px;line-height:1.45;color:var(--muted);margin:0 0 8px;
            display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;
        }
        .rm-foot{display:flex;align-items:baseline;gap:4px;flex-wrap:wrap;margin-bottom:0}
        .rm-price{
            font-family:'Cormorant Garamond',serif;font-size:17px;font-weight:700;color:var(--navy-mid);
        }
        .rm-unit{font-family:'Montserrat',sans-serif;font-size:9px;font-weight:600;letter-spacing:.8px;color:var(--muted);text-transform:uppercase}
        .rm-card.hidden-filter{display:none}

        /* Modal chambres */
        .rm-modal-overlay{
            display:none;position:fixed;inset:0;z-index:60;
            background:rgba(10,23,54,.45);backdrop-filter:blur(8px);
            align-items:center;justify-content:center;padding:24px;
        }
        .rm-modal-overlay.show{display:flex}
        #peModal,#peViewModal{width:min(980px,100%)}
        .pe-copy-row,.pe-docs{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px;margin-top:16px}
        .pe-copy{
            border:1px solid rgba(197,160,89,.45);border-radius:14px;overflow:hidden;
            background:linear-gradient(180deg,#fffdf8,#f6f1e6);
            box-shadow:0 10px 28px rgba(10,23,54,.06);
        }
        .pe-copy-head{
            padding:10px 14px;font-size:11px;font-weight:700;letter-spacing:1.4px;text-transform:uppercase;
            color:#8a6a2f;background:rgba(197,160,89,.12);border-bottom:1px solid rgba(197,160,89,.28);
        }
        .pe-copy-zone{
            display:flex;flex-direction:column;align-items:center;gap:8px;
            width:100%;min-height:188px;padding:14px;border:0;background:transparent;cursor:pointer;
        }
        .pe-copy-zone:hover{background:rgba(197,160,89,.07)}
        .pe-copy-preview{
            width:100%;height:118px;border-radius:10px;overflow:hidden;
            border:1.5px dashed rgba(197,160,89,.6);background:#fff;
            display:flex;align-items:center;justify-content:center;color:#8a6a2f;
        }
        .pe-copy.has-file .pe-copy-preview{border-style:solid;border-color:rgba(197,160,89,.45)}
        .pe-copy-preview img{width:100%;height:100%;object-fit:contain;background:#fff}
        .pe-copy-ph{display:flex;flex-direction:column;align-items:center;gap:6px;font-size:11px;letter-spacing:.8px;text-transform:uppercase}
        .pe-copy-ph em{font-style:normal;font-weight:700}
        .pe-copy-pdf{font-size:18px;font-weight:700;letter-spacing:1.5px}
        .pe-copy-name{max-width:100%;font-size:12px;color:#6d6558;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
        .pe-view-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:12px 16px;margin:14px 0 4px}
        .pe-view-grid b{display:block;font-size:11px;letter-spacing:.6px;text-transform:uppercase;color:var(--gold);margin-bottom:3px}
        .pe-copy-frame{padding:12px;background:#fff}
        .pe-copy-frame img,.pe-copy-frame iframe{width:100%;height:280px;object-fit:contain;border:0;border-radius:10px;background:#f7f4ee}
        .pe-copy-empty{margin:0;min-height:120px;display:flex;align-items:center;justify-content:center;color:var(--muted);font-size:13px}
        .cc-comm-layout{
            display:grid;grid-template-columns:minmax(0,1fr) 200px;gap:16px;align-items:start;
        }
        .cc-comm-docs{display:flex;flex-direction:column;gap:12px;width:200px;max-width:100%}
        .cc-doc{width:100%;min-width:0}
        .cc-doc .pe-copy-zone{min-height:132px;padding:10px}
        .cc-doc .pe-copy-preview{height:88px}
        .cc-doc.has-file .pe-copy-preview{border-style:solid}
        #cfg-commerciaux .form-flex{
            display:grid;
            grid-template-columns:repeat(auto-fill,minmax(158px,1fr));
            gap:12px 14px;
            align-items:end;
            justify-content:stretch;
        }
        #cfg-commerciaux .form-flex .field{min-width:0;margin:0}
        #cfg-commerciaux .form-flex .field input,
        #cfg-commerciaux .form-flex .field select{width:100%;min-width:0;box-sizing:border-box}
        #cfg-commerciaux .field.cc-span-2{grid-column:span 2}
        .cc-comm-actions{
            display:flex;flex-wrap:wrap;align-items:stretch;gap:10px;
            grid-column:1 / -1;margin:2px 0 0;min-width:0;padding-bottom:0;
        }
        .cc-comm-actions .btn{
            flex:1 1 120px;min-width:0;white-space:nowrap;justify-content:center;
            height:42px;padding-top:0;padding-bottom:0;
        }
        #cfg-commerciaux .field.cc-sal-field label{color:#7c3aed}
        #cfg-commerciaux .field.cc-sal-field input{
            border-color:rgba(124,58,237,.45);color:#5b21b6;font-weight:700;
            background:linear-gradient(180deg,#faf5ff,#f3e8ff);
            box-shadow:inset 0 0 0 1px rgba(124,58,237,.08);
        }
        #cfg-commerciaux .field.cc-sal-field input:focus{
            border-color:#7c3aed;box-shadow:0 0 0 3px rgba(124,58,237,.18);
        }
        #cfg-commerciaux .field.cfg-id-field{max-width:120px}
        #cfg-commerciaux .field.cfg-id-field input{
            font-family:'Montserrat',sans-serif;font-weight:700;letter-spacing:.04em;
            color:var(--navy-mid);text-align:center;
        }
        @media(max-width:1280px){
            .cc-comm-layout{grid-template-columns:1fr}
            .cc-comm-docs{flex-direction:row;flex-wrap:wrap;width:100%;max-width:100%}
            .cc-doc{flex:1 1 200px;max-width:280px}
        }
        @media(max-width:700px){
            #cfg-commerciaux .form-flex{grid-template-columns:1fr}
            #cfg-commerciaux .field.cc-span-2,
            #cfg-commerciaux .field.cfg-id-field{grid-column:auto;max-width:none}
            .cc-doc{max-width:none}
        }
        .pe-photo-wrap{display:grid;grid-template-columns:240px minmax(0,1fr);gap:18px;align-items:center;margin:2px 0 18px}
        .pe-photo{width:100%}
        .pe-photo-side{display:flex;flex-direction:column;gap:14px;justify-content:center}
        .pe-photo-side .field{margin-bottom:0}
        .pe-photo-side b{display:block;font-size:11px;letter-spacing:.6px;text-transform:uppercase;color:var(--gold);margin-bottom:4px}
        .pe-photo .pe-copy-preview{height:168px;border-radius:12px}
        .pe-photo.has-file .pe-copy-preview img,.pe-photo-frame img{object-fit:cover}
        .pe-photo-frame{padding:10px}
        .pe-photo-frame img{width:100%;height:200px;border-radius:12px}
        @media(max-width:700px){.pe-view-grid,.pe-copy-row,.pe-docs,.pe-photo-wrap{grid-template-columns:1fr}}
        .rm-modal{
            position:relative;width:min(720px,100%);max-height:90vh;overflow-y:auto;
            background:linear-gradient(165deg,#fff,rgba(247,245,240,.98));
            border:1px solid rgba(197,160,89,.25);border-radius:16px;
            box-shadow:0 24px 64px rgba(0,0,0,.12),0 0 60px rgba(197,160,89,.08);
            padding:28px 28px 24px;animation:fade .3s ease;
        }
        .rm-modal.rm-resa-wide{width:min(920px,100%)}
        .rm-form-sec{margin:0 0 18px}
        .rm-form-sec-title{
            font:700 11px 'Montserrat',sans-serif;letter-spacing:1.4px;text-transform:uppercase;
            color:var(--gold);margin:0 0 10px;padding-bottom:6px;
            border-bottom:1px solid rgba(212,176,106,.28);
        }
        .rm-form-grid.cols-4{grid-template-columns:repeat(4,minmax(0,1fr));gap:12px}
        @media(max-width:820px){.rm-form-grid.cols-4{grid-template-columns:repeat(2,minmax(0,1fr))}}
        @media(max-width:520px){.rm-form-grid.cols-4{grid-template-columns:1fr}}
        .rm-form-grid .field.span2{grid-column:span 2}
        .rm-form-grid .field.span3{grid-column:span 3}
        .rm-form-grid .field.span4,.rm-form-grid .field.span2.full{grid-column:1/-1}
        .rm-form-grid .field.is-off{opacity:.45}
        .rm-form-grid .field.is-off input,
        .rm-form-grid .field.is-off select{
            cursor:not-allowed;background:rgba(120,120,120,.12);filter:grayscale(1);
        }
        .rm-form-grid .field label{
            display:block;font:600 10px 'Montserrat',sans-serif;letter-spacing:.8px;
            text-transform:uppercase;color:#8a6a2c;margin:0 0 6px;
        }
        .rm-pay-doc,.rm-pers-doc{
            display:grid;grid-template-columns:minmax(0,1fr) 240px;
            gap:14px;align-items:start;margin:0 0 18px;
        }
        @media(max-width:720px){.rm-pay-doc,.rm-pers-doc{grid-template-columns:1fr}}
        .rm-pay-doc .rm-form-sec,.rm-pers-doc .rm-form-sec{margin:0;min-width:0}
        .rm-form-grid.pay-compact{grid-template-columns:repeat(2,minmax(0,1fr));gap:10px}
        .rm-form-grid.pers-line{
            grid-template-columns:repeat(2,minmax(0,1fr));gap:10px;
        }
        .rm-form-grid.pers-line .field{min-width:0}
        .rm-form-grid.pers-line .field input,
        .rm-form-grid.pers-line .field select{
            width:100%;min-width:0;max-width:100%;
            overflow:hidden;text-overflow:ellipsis;white-space:nowrap;
        }
        .rm-form-grid.pers-line .field input:focus{
            overflow:visible;text-overflow:clip;white-space:normal;
        }
        .rm-form-grid.pay-compact .field.span2{grid-column:1/-1}
        .rm-form-grid.pay-line{
            grid-template-columns:minmax(100px,.7fr) minmax(90px,.85fr) minmax(90px,.85fr) minmax(140px,1.6fr) minmax(110px,.9fr);
            gap:10px;align-items:end;
        }
        .rm-form-grid.pay-line .field{min-width:0}
        .rm-form-grid.pay-line .field.pay-type{max-width:140px}
        .rm-form-grid.pay-line .field.pay-tire{min-width:0}
        @media(max-width:820px){
            .rm-form-grid.pay-line{grid-template-columns:repeat(2,minmax(0,1fr))}
            .rm-form-grid.pay-line .field.pay-type{max-width:none}
        }
        .rf-pay-pills{
            display:flex;flex-wrap:wrap;gap:8px;margin:0 0 12px;
        }
        .rf-pay-pill{
            appearance:none;border:1px solid rgba(197,160,89,.4);
            background:#fff;color:#1a2332;cursor:pointer;
            padding:9px 14px;border-radius:999px;
            font:700 11px 'Montserrat',sans-serif;letter-spacing:.6px;text-transform:uppercase;
            transition:border-color .2s,background .2s,color .2s,box-shadow .2s;
        }
        .rf-pay-pill:hover{border-color:var(--gold);color:var(--tw-navy)}
        .rf-pay-pill.is-on{
            background:linear-gradient(135deg,var(--gold),var(--gold-light));
            border-color:transparent;color:#1a1304;
            box-shadow:0 6px 16px rgba(197,160,89,.28);
        }
        .rf-pay-pill:disabled{opacity:.45;cursor:default;box-shadow:none}
        .rf-pay-summary{
            display:none;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;
            margin:0 0 10px;padding:10px 12px;border-radius:10px;
            background:rgba(197,160,89,.08);border:1px solid rgba(197,160,89,.22);
            font:600 12px 'Montserrat',sans-serif;color:#3a2a12;
        }
        .rf-pay-summary.is-on{display:flex}
        .rf-pay-summary b{font-weight:700;color:var(--tw-navy)}
        .rf-pay-panel{
            display:none;margin-top:4px;padding:14px 14px 12px;border-radius:12px;
            background:linear-gradient(180deg,#fffdf8,#f7f2e8);
            border:1px solid rgba(197,160,89,.35);
            box-shadow:0 10px 24px rgba(10,23,54,.06);
        }
        .rf-pay-panel.is-open{display:block;animation:fade .2s ease}
        .rf-pay-panel-title{
            margin:0 0 12px;font:700 11px 'Montserrat',sans-serif;
            letter-spacing:1.2px;text-transform:uppercase;color:#8a6a2c;
        }
        .rf-pay-panel-grid{
            display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:10px;
        }
        .rf-pay-panel-grid.is-inst{grid-template-columns:repeat(3,minmax(0,1fr))}
        .rf-pay-panel-grid .field{min-width:0}
        .rf-pay-panel-grid .field input[readonly]{
            opacity:.85;cursor:default;background:rgba(247,245,240,.95);
        }
        .rf-pay-panel-actions{
            display:flex;justify-content:flex-end;gap:8px;margin-top:12px;
        }
        .rf-pay-panel-actions .btn{min-width:110px}
        @media(max-width:720px){
            .rf-pay-panel-grid,.rf-pay-panel-grid.is-inst{grid-template-columns:1fr 1fr}
        }
        @media(max-width:480px){
            .rf-pay-panel-grid,.rf-pay-panel-grid.is-inst{grid-template-columns:1fr}
        }
        .rm-form-head.simple h3{margin:0 0 14px}
        .rm-form-head.simple p{display:none}
        .rf-doc{
            border:1px solid rgba(197,160,89,.4);border-radius:14px;overflow:hidden;
            background:linear-gradient(180deg,#fffdf8,#f6f1e6);
            box-shadow:0 8px 22px rgba(10,23,54,.05);
            width:240px;max-width:100%;height:auto;
            display:flex;flex-direction:column;
        }
        .rf-doc-head{
            padding:9px 12px;font:700 10px 'Montserrat',sans-serif;letter-spacing:1.2px;text-transform:uppercase;
            color:#8a6a2f;background:rgba(197,160,89,.12);border-bottom:1px solid rgba(197,160,89,.28);
        }
        .rf-doc-body{padding:12px;display:flex;flex-direction:column;gap:10px}
        .rf-doc-preview{
            width:100%;height:148px;min-height:148px;max-height:148px;flex:none;
            border-radius:10px;overflow:hidden;
            border:1.5px dashed rgba(197,160,89,.55);background:#fff;
            display:flex;align-items:center;justify-content:center;color:#8a6a2f;text-align:center;
        }
        .rf-doc.has-file .rf-doc-preview{border-style:solid;border-color:rgba(197,160,89,.4)}
        .rf-doc-preview img{
            width:100%;height:100%;max-width:100%;max-height:148px;
            object-fit:contain;object-position:center;background:#fff;display:block;
        }
        .rf-doc-preview .rf-doc-ph{display:flex;flex-direction:column;align-items:center;gap:6px;padding:12px;font:600 10px 'Montserrat',sans-serif;letter-spacing:.7px;text-transform:uppercase}
        .rf-doc-preview .rf-doc-ph span{font-weight:500;text-transform:none;letter-spacing:0;color:var(--muted);font-size:11px}
        .rf-doc-preview .rf-doc-pdf{font:700 16px 'Montserrat',sans-serif;letter-spacing:1px}
        .rf-doc-actions{display:flex;flex-wrap:wrap;gap:8px}
        .rf-doc-actions button{
            flex:1;min-width:0;padding:8px 10px;border-radius:9px;cursor:pointer;
            font:700 10px 'Montserrat',sans-serif;letter-spacing:.5px;text-transform:uppercase;
            border:1px solid rgba(197,160,89,.4);background:#fff;color:var(--text-dark);
        }
        .rf-doc-actions button:hover{border-color:var(--gold);color:var(--tw-navy)}
        .rf-doc-actions button.is-gold{
            background:linear-gradient(135deg,var(--gold),var(--gold-light));color:#1a1304;border-color:transparent;
        }
        .rf-doc-actions button:disabled{opacity:.4;cursor:default}
        .rm-modal-close{
            position:absolute;top:14px;right:16px;width:34px;height:34px;border-radius:8px;
            background:var(--white);border:1px solid var(--border-gold);
            color:var(--text-dark);font-size:22px;line-height:1;cursor:pointer;transition:all .2s;
        }
        .rm-modal-close:hover{border-color:var(--gold);color:var(--gold)}
        .rm-msg h3{
            font-family:'Cormorant Garamond',serif;font-size:32px;color:var(--text-dark);margin:0 0 8px;
        }
        .rm-form-head h3{font-family:'Cormorant Garamond',serif;font-size:26px;color:var(--text-dark);margin:0 0 4px}
        .rm-form-head p{color:var(--muted);font-size:13px;margin:0}
        .rm-form-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px}
        @media(max-width:600px){.rm-form-grid{grid-template-columns:1fr}}
        .rm-form-grid .field input[readonly]{opacity:.75;cursor:default;background:rgba(247,245,240,.9)}
        .rm-form-grid .field textarea,.rm-form-grid .field select{
            width:100%;background:var(--white);border:1px solid var(--border-gold);
            border-radius:8px;padding:10px 12px;color:var(--text-dark);font-size:13px;font-family:inherit;
            resize:vertical;min-height:72px;outline:none;
        }
        .rm-form-grid .field select{min-height:auto;cursor:pointer}
        .rm-form-grid .field input{
            width:100%;background:var(--white);border:1px solid var(--border-gold);
            border-radius:8px;padding:11px 13px;color:var(--text-dark);font-size:14px;outline:none;
        }
        .rm-form-grid .field input:focus,
        .rm-form-grid .field textarea:focus,
        .rm-form-grid .field select:focus{
            border-color:var(--gold);box-shadow:0 0 0 3px rgba(197,160,89,.12);
        }
        .rm-edit-simple .field label{
            color:var(--gold);font-weight:600;font-size:11px;letter-spacing:1px;
            text-transform:uppercase;margin-bottom:6px;display:block;text-align:left;
        }
        .rm-form-totals{
            display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:12px;
            margin:18px 0 20px;padding:16px;background:rgba(0,0,0,.22);
            border:1px solid rgba(201,162,39,.15);border-radius:12px;
        }
        .rm-form-totals .ttl label{display:block;font-size:10px;color:var(--muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:6px}
        .rm-form-totals .ttl input{
            width:100%;background:rgba(0,0,0,.3);border:1px solid rgba(201,162,39,.2);
            border-radius:8px;padding:10px 12px;color:var(--gold-light);font-weight:700;font-size:15px;
        }
        .rm-form-actions{display:flex;flex-wrap:wrap;gap:10px}
        .rm-status-pick{text-align:center;padding:24px 8px 12px}
        .rm-status-pick h4{font-family:'Cormorant Garamond',serif;font-size:26px;color:var(--text-dark);margin:0 0 8px}
        .rm-status-pick .rm-status-sub{color:var(--muted);font-size:14px;margin:0 0 28px}
        .rm-status-btns{display:flex;gap:16px;justify-content:center;flex-wrap:wrap}
        .rm-st-btn{
            flex:1;min-width:150px;padding:20px 22px;border-radius:12px;
            border:2px solid;cursor:pointer;font-family:'Montserrat',sans-serif;
            font-size:12px;font-weight:700;letter-spacing:1.4px;text-transform:uppercase;
            transition:all .25s ease;background:#fff;
        }
        .rm-st-btn.st-occupee{color:#1f7a45;border-color:rgba(47,168,100,.55);box-shadow:0 0 16px rgba(69,200,120,.12)}
        .rm-st-btn.st-occupee:hover{background:rgba(69,200,120,.14);box-shadow:0 0 28px rgba(69,200,120,.28);transform:translateY(-2px)}
        .rm-st-btn.st-reservee{color:#2f5fad;border-color:rgba(91,158,245,.55);box-shadow:0 0 16px rgba(91,158,245,.12)}
        .rm-st-btn.st-reservee:hover{background:rgba(91,158,245,.14);box-shadow:0 0 28px rgba(91,158,245,.28);transform:translateY(-2px)}
        .rm-st-btn:disabled{opacity:.55;cursor:wait;transform:none;pointer-events:none}
        .rm-status-ok{
            text-align:center;padding:28px 12px 10px;
        }
        .rm-status-ok h4{
            font-family:'Cormorant Garamond',serif;font-size:28px;color:var(--text-dark);margin:0 0 8px;
        }
        .rm-status-ok p{color:var(--muted);font-size:14px;margin:0}
        .rm-st-btn.st-disponible{color:#f3e4a8;border-color:rgba(230,199,90,.5);box-shadow:0 0 16px rgba(230,199,90,.12)}
        .rm-st-btn.st-disponible:hover{background:rgba(230,199,90,.15);box-shadow:0 0 28px rgba(230,199,90,.35);transform:translateY(-2px)}
        .rm-st-btn.st-nettoyage{color:#c0c8d8;border-color:rgba(138,148,168,.5);box-shadow:0 0 16px rgba(138,148,168,.12)}
        .rm-st-btn.st-nettoyage:hover{background:rgba(138,148,168,.15);box-shadow:0 0 28px rgba(138,148,168,.3);transform:translateY(-2px)}
        .rm-st-btn.st-maintenance{color:#ffc0c0;border-color:rgba(224,112,112,.5);box-shadow:0 0 16px rgba(224,112,112,.12)}
        .rm-st-btn.st-maintenance:hover{background:rgba(224,112,112,.15);box-shadow:0 0 28px rgba(224,112,112,.35);transform:translateY(-2px)}
        .rm-st-btn.is-current{opacity:.45;pointer-events:none}
        .rm-admin-change{margin-top:24px;padding-top:20px;border-top:1px solid rgba(201,162,39,.15)}
        .rm-admin-label{font-family:'Montserrat',sans-serif;font-size:10px;font-weight:600;letter-spacing:1.5px;text-transform:uppercase;color:var(--gold);margin:0 0 16px}

        .ba-form-head{display:flex;flex-wrap:wrap;gap:14px;margin-bottom:18px;justify-content:center}
        .ba-form-head .field{margin-bottom:0}
        .ba-form-head .field input[readonly]{opacity:.9;cursor:default}
        .ba-lines-wrap{margin:8px 0 16px}
        .ba-lines-table .ba-inp{
            width:100%;min-width:0;background:rgba(0,0,0,.25);border:1px solid rgba(201,162,39,.2);
            border-radius:7px;padding:8px 10px;color:var(--cream);font-size:13px;outline:none;text-align:center;
        }
        .ba-lines-table .ba-inp:focus{border-color:var(--gold)}
        .ba-lines-table .ba-inp.st{background:rgba(0,0,0,.15);color:var(--gold-light);font-weight:600;text-align:center}
        .ba-lines-table tfoot td{text-align:center}
        .ba-lines-table th{font-size:10px;white-space:nowrap}
        .ba-lines-table td{vertical-align:middle}
        .ba-lines-table tfoot td{font-weight:700;color:var(--gold-light);border-top:1px solid rgba(201,162,39,.25)}
        .ba-total-val{font-family:'Playfair Display',serif;font-size:16px}
        .ba-detail-row td{background:rgba(0,0,0,.18);padding:10px 16px 14px}
        .ba-detail-table{width:100%;margin-top:2px}
        .ba-detail-table th,.ba-detail-table td{font-size:12px;padding:7px 10px}
        .ba-detail-row.hidden{display:none}
        .ba-main-row{cursor:pointer;transition:background .2s}
        .ba-main-row:hover td{background:rgba(201,162,39,.06)}
        .ba-main-row.selected td{background:rgba(201,162,39,.14);border-color:rgba(201,162,39,.2)}
        .btn.del{border-color:rgba(230,120,120,.45);color:#e89}
        .btn.del:hover{border-color:#e89;color:#fff;background:rgba(230,120,120,.15)}
        .ba-lines-hint{font-size:12px;color:var(--muted);margin:0 0 10px}
        .cfg-auth-wrap{
            overflow:auto;margin-top:0;max-height:min(560px,calc(100vh - var(--topbar-h) - 220px));
            border:1px solid rgba(197,160,89,.28);border-radius:0 0 12px 12px;background:#fff;
        }
        .cfg-auth-toolbar{
            display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;
            padding:10px 14px;background:linear-gradient(180deg,#fbf8f1,#f4eee2);
            border-bottom:1px solid rgba(197,160,89,.22);
        }
        .cfg-auth-legend{display:flex;flex-wrap:wrap;gap:8px}
        .cfg-auth-legend span{
            display:inline-flex;align-items:center;gap:6px;padding:4px 9px;border-radius:999px;
            background:#fff;border:1px solid rgba(197,160,89,.28);color:#5c4a28;
            font:600 10px 'Montserrat',sans-serif;letter-spacing:.3px;
        }
        .cfg-auth-legend i{font-style:normal;opacity:.85}
        .cfg-auth-stats{
            display:flex;align-items:center;gap:8px;flex-wrap:wrap;
            font:700 10px 'Montserrat',sans-serif;letter-spacing:.6px;text-transform:uppercase;color:#8a6a2c;
        }
        .cfg-auth-stats b{
            display:inline-flex;align-items:center;gap:6px;padding:5px 10px;border-radius:8px;
            background:rgba(15,42,92,.06);border:1px solid rgba(15,42,92,.12);color:#0a1736;
            font:700 11px 'Montserrat',sans-serif;letter-spacing:0;text-transform:none;
        }
        .cfg-auth-stats b em{font-style:normal;color:#8a6a2c}
        .cfg-auth-table{width:100%;border-collapse:separate;border-spacing:0;min-width:720px}
        .cfg-auth-table th,.cfg-auth-table td{text-align:center;vertical-align:middle;background:#fff;padding:10px 8px}
        .cfg-auth-table thead th{
            position:sticky;top:0;z-index:3;padding:12px 8px;
            background:linear-gradient(180deg,#122a58,#0a1736);color:#f3e4a8;
            box-shadow:0 1px 0 rgba(197,160,89,.45);
            font:700 10px 'Montserrat',sans-serif;letter-spacing:.4px;
        }
        .cfg-auth-table th:first-child,.cfg-auth-table td:first-child{
            position:sticky;left:0;z-index:2;text-align:left;min-width:260px;padding-left:14px;padding-right:12px;
            background:#fff;box-shadow:inset -1px 0 0 rgba(197,160,89,.22);
        }
        .cfg-auth-table thead th:first-child{z-index:4;text-align:left;background:linear-gradient(180deg,#122a58,#0a1736)}
        .cfg-auth-table tr.auth-sec td{
            background:linear-gradient(90deg,#f3ead6,#f8f3e8);color:#8a6a2c;font-weight:700;font-size:11px;
            letter-spacing:.8px;text-transform:uppercase;text-align:left;padding:10px 14px;
            border-top:1px solid rgba(197,160,89,.28);border-bottom:1px solid rgba(197,160,89,.18);
        }
        .auth-sec-inner{display:flex;align-items:center;gap:10px;flex-wrap:wrap}
        .auth-sec-title{font:700 11px 'Montserrat',sans-serif;letter-spacing:1px}
        .auth-sec-meta{
            display:inline-flex;align-items:center;gap:6px;margin-left:auto;flex-wrap:wrap;
            font:600 10px 'Montserrat',sans-serif;letter-spacing:.2px;text-transform:none;color:#6b5a3a;
        }
        .auth-sec-meta span{
            padding:3px 8px;border-radius:999px;background:rgba(255,255,255,.7);
            border:1px solid rgba(197,160,89,.3);
        }
        .auth-fold{
            width:30px;height:30px;padding:0;flex:none;
            display:inline-flex;align-items:center;justify-content:center;
            border:1px solid rgba(197,160,89,.5);border-radius:9px;background:#fff;color:#8a6a2f;cursor:pointer;
        }
        .auth-fold:hover{border-color:var(--gold);background:rgba(197,160,89,.1)}
        .auth-fold svg{width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:1.7;stroke-linecap:round;stroke-linejoin:round}
        .auth-fold .eye-off{display:none}
        .auth-sec.is-closed .auth-fold .eye-on{display:none}
        .auth-sec.is-closed .auth-fold .eye-off{display:block}
        .cfg-auth-table tr.auth-row.is-hidden{display:none}
        .cfg-auth-table tr.auth-row td{border-bottom:1px solid rgba(197,160,89,.1)}
        .cfg-auth-table tr.auth-row:nth-child(even) td{background:#fcfaf6}
        .cfg-auth-table tr.auth-row:nth-child(even) td:first-child{background:#fcfaf6}
        .cfg-auth-table tr:hover td{background:#fbf7ef}
        .cfg-auth-table tr:hover td:first-child{background:#f6f0e4}
        .cfg-auth-table tr.auth-sec:hover td{background:linear-gradient(90deg,#efe4cd,#f6f0e4)}
        .auth-item{display:flex;flex-direction:column;align-items:flex-start;gap:3px;text-align:left}
        .auth-item strong{font:700 12.5px 'Montserrat',sans-serif;color:#1a2332;letter-spacing:.1px}
        .auth-item small{font:600 10px 'Montserrat',sans-serif;color:#8a6a2c;letter-spacing:.2px}
        .auth-item .auth-code{
            display:inline-flex;align-items:center;gap:5px;padding:2px 7px;border-radius:6px;
            background:rgba(15,42,92,.05);border:1px solid rgba(15,42,92,.08);
            color:#4a5568;font:600 9.5px ui-monospace,Consolas,monospace;letter-spacing:0;
        }
        .auth-row-count{
            margin-top:2px;font:600 10px 'Montserrat',sans-serif;color:#6b7280;
        }
        .auth-row-count em{font-style:normal;color:#8a6a2c;font-weight:700}
        .cfg-auth-table th .perm-hdr{display:flex;flex-direction:column;align-items:center;gap:5px;line-height:1.15}
        .cfg-auth-table th .perm-ic{font-size:15px;line-height:1;opacity:.95}
        .cfg-auth-table th .perm-name{font:700 10px 'Montserrat',sans-serif;letter-spacing:.7px;text-transform:uppercase;color:#f3e4a8}
        .cfg-auth-table th .perm-hint{font:500 9px 'Montserrat',sans-serif;color:rgba(243,228,168,.72);text-transform:none;letter-spacing:0;font-weight:500}
        .cfg-auth-table th .auth-all-lbl{display:flex;flex-direction:column;align-items:flex-start;gap:6px}
        .cfg-auth-table th .auth-all-lbl .auth-all-title{font:700 10px 'Montserrat',sans-serif;letter-spacing:.8px;text-transform:uppercase;color:#f3e4a8}
        .cfg-auth-table th .auth-all-lbl .auth-all-sub{font:500 9px 'Montserrat',sans-serif;color:rgba(243,228,168,.7);text-transform:none;letter-spacing:0}
        .cfg-auth-table input[type=checkbox]{width:18px;height:18px;accent-color:var(--gold);cursor:pointer}
        .cfg-auth-table td .auth-check{
            width:34px;height:34px;margin:0 auto;display:inline-flex;align-items:center;justify-content:center;
            border-radius:9px;border:1px solid transparent;transition:background .15s,border-color .15s;
        }
        .cfg-auth-table td .auth-check:hover{background:rgba(197,160,89,.1);border-color:rgba(197,160,89,.28)}
        .cfg-auth-table td .auth-check:has(input:checked){background:rgba(197,160,89,.16);border-color:rgba(197,160,89,.4)}

        /* ===== CHAMBRES DISPONIBLES & CARROUSEL ===== */
        .cd-section{margin-bottom:36px}
        .cd-section-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;padding-bottom:10px;border-bottom:1px solid rgba(201,162,39,.12)}
        .cd-section-head h3{font-family:'Cormorant Garamond',serif;font-size:24px;color:var(--text-dark);margin:0}
        .cd-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:14px}
        .cd-card{background:var(--white);border:1px solid var(--border-gold);border-radius:12px;overflow:hidden;box-shadow:var(--shadow-soft);transform:none!important;transition:box-shadow .2s,border-color .2s}
        .cd-card:hover{transform:none!important;box-shadow:0 8px 24px rgba(197,160,89,.1);border-color:rgba(197,160,89,.35)}
        .cd-card-img{position:relative;height:120px;overflow:hidden}
        .cd-card-img img{width:100%;height:100%;object-fit:cover}
        .cd-card-img .cd-num{position:absolute;bottom:8px;left:10px;font-size:11px;color:var(--gold);letter-spacing:1px;font-weight:700;text-shadow:0 2px 8px rgba(0,0,0,.4)}
        .cd-card-body{padding:12px 14px 14px}
        .cd-card-body h4{font-family:'Cormorant Garamond',serif;font-size:17px;color:var(--text-dark);margin:0 0 6px}
        .cd-card-body p{font-size:11px;color:var(--muted);line-height:1.45;margin:0 0 10px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
        .cd-card-foot{display:flex;align-items:center;justify-content:space-between;gap:8px}
        .cd-price{font-size:12px;font-weight:700;color:var(--navy-mid)}
        .cd-edit-btn{width:32px;height:32px;border-radius:8px;border:1px solid rgba(197,160,89,.35);background:var(--white);color:var(--gold);cursor:pointer;transition:all .2s}
        .cd-edit-btn:hover{background:rgba(197,160,89,.12);color:var(--navy-mid)}

        .cfg-car-tabs{display:flex;flex-wrap:wrap;gap:8px;margin-bottom:18px}
        .cfg-car-tab{padding:10px 16px;border-radius:10px;border:1px solid var(--border-gold);background:var(--white);color:var(--muted);cursor:pointer;font-size:12px;font-weight:600;letter-spacing:.6px;text-transform:uppercase;transition:all .2s}
        .cfg-car-tab.active{background:linear-gradient(135deg,rgba(197,160,89,.14),rgba(197,160,89,.06));border-color:rgba(197,160,89,.4);color:var(--navy-mid)}
        .cfg-car-meta{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px;margin-bottom:18px}
        @media(max-width:700px){.cfg-car-meta{grid-template-columns:1fr}}
        .cfg-car-slides{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:14px}
        .cfg-car-slide{background:var(--white);border:1px solid var(--border-gold);border-radius:12px;padding:12px;box-shadow:var(--shadow-soft)}
        .cfg-car-slide-preview{height:120px;border-radius:8px;overflow:hidden;margin-bottom:10px;background:#e5e7eb}
        .cfg-car-slide-preview img{width:100%;height:100%;object-fit:cover}
        .cfg-car-slide .field{margin-bottom:10px}
        .cfg-car-slide .field label{font-size:10px}
        .cfg-car-slide .field input,.cfg-car-slide .field textarea{width:100%;background:var(--white);border:1px solid var(--border-gold);border-radius:8px;padding:8px 10px;color:var(--text-dark);font-size:12px}
        .cfg-car-slide .field textarea{min-height:64px;resize:vertical}
        .cfg-car-slide-actions{display:flex;gap:8px;justify-content:flex-end}
        .cfg-id-field input{font-weight:600;color:var(--navy-mid)}
        .cfg-list-head{display:flex;align-items:center;justify-content:center;gap:12px;flex-wrap:wrap;margin-bottom:14px}
        .field{margin-bottom:14px}
        .field label{display:block;font-size:12px;color:var(--gold);font-weight:600;margin-bottom:6px;text-transform:uppercase;letter-spacing:1px;text-align:center}
        .field input,.field select{width:100%;background:var(--white);border:1px solid var(--border-gold);
            border-radius:8px;padding:11px 13px;color:var(--text-dark);font-family:inherit;font-size:14px;outline:none;text-align:center;transition:border-color .2s,box-shadow .2s}
        .field input:focus,.field select:focus{border-color:var(--gold);box-shadow:0 0 0 3px rgba(197,160,89,.1)}
        .field input[readonly]{background:rgba(247,245,240,.8);opacity:.85}
        .field input.is-locked-comm,
        .field select.is-locked-comm{
            background:rgba(120,120,120,.12)!important;color:#6b7280!important;
            cursor:not-allowed;opacity:.9;filter:grayscale(.15);
        }

        /* ===== FRNS — cadres & tableaux pleine largeur ===== */
        .panel.frns-panel{max-width:100%;width:100%}
        .panel.frns-panel .block{padding:28px 30px 30px;margin-bottom:24px}
        .panel.frns-panel .frns-form-top{
            display:grid;grid-template-columns:minmax(200px,280px) 1fr;gap:18px;align-items:end;
            width:100%;margin-bottom:18px;
        }
        .panel.frns-panel .frns-form-top .actions{justify-content:flex-end;margin:0}
        .panel.frns-panel .frns-form-grid,
        .panel.frns-panel .ba-form-head.frns-form-grid{
            display:grid;grid-template-columns:repeat(5,minmax(0,1fr));gap:16px 18px;
            width:100%;margin-bottom:16px;justify-content:stretch;
        }
        .panel.frns-panel .frns-form-grid .field,
        .panel.frns-panel .ba-form-head .field{margin-bottom:0;min-width:0;width:100%}
        .panel.frns-panel .field input,
        .panel.frns-panel .field select,
        .panel.frns-panel .bal-row input.pay{
            min-height:48px;padding:13px 16px;font-size:14.5px;border-radius:10px;
        }
        .panel.frns-panel .ba-lines-table .ba-inp{min-height:46px;padding:11px 14px;font-size:14px;border-radius:9px}
        .panel.frns-panel .table-wrap{width:100%;margin:0}
        .panel.frns-panel table{table-layout:fixed;width:100%}
        .panel.frns-panel th,
        .panel.frns-panel td{padding:15px 14px;font-size:14px}
        .panel.frns-panel .ba-lines-wrap{width:100%;margin:14px 0 18px}
        .panel.frns-panel .ba-lines-table th:nth-child(1),
        .panel.frns-panel .ba-lines-table td:nth-child(1){width:11%}
        .panel.frns-panel .ba-lines-table th:nth-child(2),
        .panel.frns-panel .ba-lines-table td:nth-child(2){width:36%}
        .panel.frns-panel .ba-lines-table th:nth-child(3),
        .panel.frns-panel .ba-lines-table td:nth-child(3){width:11%}
        .panel.frns-panel .ba-lines-table th:nth-child(4),
        .panel.frns-panel .ba-lines-table td:nth-child(4){width:14%}
        .panel.frns-panel .ba-lines-table th:nth-child(5),
        .panel.frns-panel .ba-lines-table td:nth-child(5){width:14%}
        .panel.frns-panel .ba-lines-table th:nth-child(6),
        .panel.frns-panel .ba-lines-table td:nth-child(6){width:14%}
        .panel.frns-panel .bal-list{width:100%}
        .panel.frns-panel .bal-row{width:100%;justify-content:space-between;padding:16px 22px;gap:18px}
        .panel.frns-panel .bal-row label.chk{flex:1 1 220px;min-width:0}
        .panel.frns-panel .bal-row .mnt,
        .panel.frns-panel .bal-row .sld{flex:0 0 auto}
        .panel.frns-panel .bal-row input.pay{flex:0 1 180px;max-width:220px;width:100%}
        .panel.frns-panel .ra-bons-wrap{width:100%;padding:16px 18px}
        .panel.frns-panel .ra-bons-table th,
        .panel.frns-panel .ra-bons-table td{padding:12px 14px;font-size:13.5px}
        @media(max-width:1200px){
            .panel.frns-panel .frns-form-grid,
            .panel.frns-panel .ba-form-head.frns-form-grid{grid-template-columns:repeat(3,minmax(0,1fr))}
        }
        @media(max-width:768px){
            .panel.frns-panel .frns-form-grid,
            .panel.frns-panel .ba-form-head.frns-form-grid{grid-template-columns:repeat(2,minmax(0,1fr))}
            .panel.frns-panel .frns-form-top{grid-template-columns:1fr}
            .panel.frns-panel .frns-form-top .actions{justify-content:center}
        }
        @media(max-width:480px){
            .panel.frns-panel .frns-form-grid,
            .panel.frns-panel .ba-form-head.frns-form-grid{grid-template-columns:1fr}
        }

        /* ===== Fournisseur — cadre élargi, barres de saisie réduites ===== */
        .panel.frns-panel.frns-compact{max-width:100%}
        .panel.frns-panel.frns-compact .block{padding:26px 32px 28px;margin-bottom:22px;border-radius:14px}
        .panel.frns-panel.frns-compact .block h3{font-size:15px;margin-bottom:14px;letter-spacing:1px;text-transform:uppercase}
        .panel.frns-panel.frns-compact .frns-form-grid,
        .panel.frns-panel.frns-compact .ba-form-head.frns-form-grid{
            gap:10px 14px;margin-bottom:14px;
        }
        .panel.frns-panel.frns-compact .field{margin-bottom:0}
        .panel.frns-panel.frns-compact .field label{font-size:10px;margin-bottom:4px;letter-spacing:1.2px}
        .panel.frns-panel.frns-compact .field input,
        .panel.frns-panel.frns-compact .field select,
        .panel.frns-panel.frns-compact .bal-row input.pay{
            min-height:36px;padding:8px 12px;font-size:13px;border-radius:8px;
            background:rgba(0,0,0,.2);border-color:rgba(201,162,39,.18);
        }
        .panel.frns-panel.frns-compact .field input[readonly]{background:rgba(0,0,0,.12)}
        .panel.frns-panel.frns-compact .ba-lines-wrap{
            margin:14px 0 18px;border:1px solid rgba(201,162,39,.16);border-radius:12px;
            overflow-x:auto;overflow-y:visible;background:rgba(0,0,0,.14);
        }
        .panel.frns-panel.frns-compact .ba-lines-table thead th{
            background:rgba(201,162,39,.09);padding:12px 14px;font-size:11px;letter-spacing:1px;
        }
        .panel.frns-panel.frns-compact .ba-lines-table .ba-inp{
            min-height:34px;padding:7px 10px;font-size:13px;border-radius:7px;
            background:rgba(0,0,0,.18);border-color:rgba(201,162,39,.15);
        }
        .panel.frns-panel.frns-compact .ba-lines-table .ba-inp.st{font-size:13px;font-weight:600}
        .panel.frns-panel.frns-compact .ba-lines-table td{padding:8px 10px;vertical-align:middle}
        .panel.frns-panel.frns-compact .ba-lines-table tfoot td{padding:14px 12px;font-size:13px}
        .panel.frns-panel.frns-compact .ba-total-val{font-size:16px}
        .panel.frns-panel.frns-compact th,
        .panel.frns-panel.frns-compact td{padding:14px 16px;font-size:14px}
        .panel.frns-panel.frns-compact .table-wrap{
            margin:12px 0 0;border:1px solid rgba(201,162,39,.16);border-radius:12px;
            overflow:auto;background:rgba(0,0,0,.14);
        }
        .panel.frns-panel.frns-compact .table-wrap thead th{
            background:rgba(201,162,39,.09);padding:12px 14px;font-size:11px;letter-spacing:1px;
        }
        .panel.frns-panel.frns-compact .actions{gap:10px;margin-top:8px;display:flex;flex-wrap:wrap;align-items:center}
        .panel.frns-panel.frns-compact .actions .btn{padding:10px 18px;font-size:12px;border-radius:8px}
        .panel.frns-panel.frns-compact .actions .ibtn{width:28px;height:28px;font-size:12px}
        .panel.frns-panel.frns-compact .actions{flex-wrap:nowrap}
        .panel.frns-panel.frns-compact .row-head .actions{flex-wrap:nowrap}
        .panel.frns-panel.frns-compact .row-head .actions .ibtn{width:28px;height:28px;font-size:12px}
        .panel.frns-panel.frns-compact .tbl-actions{
            display:inline-flex;align-items:center;justify-content:center;
            gap:3px;flex-wrap:nowrap;white-space:nowrap;
        }
        .panel.frns-panel.frns-compact .tbl-actions .ibtn{
            width:24px;height:24px;min-width:24px;font-size:11px;margin:0;
            border-radius:5px;padding:0;line-height:1;flex-shrink:0;
        }
        .panel.frns-panel.frns-compact #ff_table th.no-print:last-child,
        .panel.frns-panel.frns-compact #ff_table td.no-print:last-child{
            width:106px;min-width:106px;padding:8px 4px;
        }
        .panel.frns-panel.frns-compact .tbtn{padding:6px 10px;font-size:11px}
        .panel.frns-panel.frns-compact .hint{font-size:12px;margin:0 0 12px;opacity:.9}
        .panel.frns-panel.frns-compact .row-head{display:flex;align-items:center;justify-content:space-between;gap:14px;flex-wrap:wrap;margin-bottom:14px}
        .panel.frns-panel.frns-compact .row-head h3{margin-bottom:0}
        .panel.frns-panel.frns-compact .bal-list{margin:10px 0 14px}
        .panel.frns-panel.frns-compact .ra-bons-wrap{padding:8px 0;margin-top:6px}
        .panel.frns-panel.frns-compact .bal-row{padding:10px 0;gap:14px}
        #regl .bal-row{background:transparent;border:none;border-radius:0}
        #regl .ra-bons-wrap{background:transparent;border:none;padding:6px 0 0}
        #regl .ra-bons-wrap .table-wrap{background:transparent;border:none;border-radius:0;margin:0}
        #regl .ra-bons-wrap .table-wrap thead th{background:transparent}
        #fiche .ff-form-one{
            display:grid;
            grid-template-columns:
                minmax(108px,0.78fr)
                minmax(58px,0.48fr)
                minmax(0,1.55fr)
                minmax(0,1fr)
                minmax(0,0.82fr)
                minmax(0,1.25fr)
                minmax(68px,0.58fr)
                minmax(62px,0.52fr)
                minmax(76px,0.62fr);
            gap:8px 10px;margin-bottom:14px;align-items:end;
        }
        #fiche .ff-f-date input{font-size:12px;padding:8px 6px}
        #fiche .ff-f-id input,
        #fiche .ff-f-solde input,
        #fiche .ff-f-ech input{font-size:12.5px}
        #fiche .ff-f-regl select{font-size:12.5px;padding-left:8px;padding-right:8px}
        #bon .ba-form-one{
            display:grid;
            grid-template-columns:
                minmax(108px,0.78fr)
                minmax(52px,0.42fr)
                minmax(58px,0.48fr)
                minmax(0,2.1fr)
                minmax(62px,0.46fr)
                minmax(72px,0.56fr);
            gap:8px 10px;margin-bottom:14px;align-items:end;
        }
        #bon .ba-f-date input{font-size:12px;padding:8px 6px}
        #bon .ba-f-num input,
        #bon .ba-f-frns-id input{font-size:12px;padding:8px 6px}
        #bon .ba-f-type select,
        #bon .ba-f-echeance select{font-size:12px;padding:8px 6px}
        @media(max-width:1200px){
            #bon .ba-form-one{
                grid-template-columns:repeat(3,minmax(0,1fr));
            }
            #bon .ba-form-one .ba-f-frns-nom{grid-column:span 2}
        }
        @media(max-width:900px){
            #bon .ba-form-one{grid-template-columns:repeat(2,minmax(0,1fr))}
            #bon .ba-form-one .field{grid-column:span 1!important}
            #bon .ba-form-one .ba-f-frns-nom{grid-column:span 2!important}
        }
        @media(max-width:1200px){
            #fiche .ff-form-one{
                grid-template-columns:repeat(3,minmax(0,1fr));
            }
            #fiche .ff-form-one .ff-f-nom,
            #fiche .ff-form-one .ff-f-adresse{grid-column:span 2}
        }
        @media(max-width:900px){
            #fiche .ff-form-one{grid-template-columns:repeat(2,minmax(0,1fr))}
            #fiche .ff-form-one .field{grid-column:span 1!important}
            #fiche .ff-form-one .ff-f-nom,
            #fiche .ff-form-one .ff-f-adresse{grid-column:span 2!important}
        }
        #regl .ra-form-row1,
        #regl .ra-form-row2{
            display:grid;grid-template-columns:repeat(8,minmax(0,1fr));
            gap:10px 14px;margin-bottom:14px;
        }
        #regl .ra-form-row1 .ra-f-date{grid-column:span 1}
        #regl .ra-form-row1 .ra-f-ref{grid-column:span 1}
        #regl .ra-form-row1 .ra-f-type{grid-column:span 1}
        #regl .ra-form-row1 .ra-f-num{grid-column:span 1}
        #regl .ra-form-row1 .ra-f-banq{grid-column:span 1}
        #regl .ra-form-row1 .ra-f-tire{grid-column:span 3}
        #regl .ra-form-row2 .ra-f-decaiss{grid-column:span 2}
        #regl .ra-form-row2 .ra-f-frns{grid-column:span 6}
        #regl .field.is-disabled input,
        #regl .field.is-disabled select{
            opacity:.42;cursor:not-allowed;background:rgba(0,0,0,.1);
            border-color:rgba(201,162,39,.1);color:var(--muted);
        }
        #balance .bl-search-bar{
            display:grid;grid-template-columns:minmax(140px,200px) minmax(0,1fr);
            gap:10px 14px;margin-bottom:14px;align-items:end;
        }
        #balance .bl-search-bar .field{margin-bottom:0}
        #balance .bl-search-bar .field label{font-size:10px;margin-bottom:4px}
        #balance .bl-search-bar .field input{
            min-height:36px;padding:8px 12px;font-size:13px;border-radius:8px;
        }
        @media(max-width:900px){
            #balance .bl-search-bar{grid-template-columns:1fr}
            #regl .ra-form-row1,
            #regl .ra-form-row2{grid-template-columns:repeat(2,minmax(0,1fr))}
            #regl .ra-form-row1 .field,
            #regl .ra-form-row2 .field{grid-column:span 1!important}
            #regl .ra-form-row1 .ra-f-tire,
            #regl .ra-form-row2 .ra-f-frns{grid-column:span 2!important}
        }

        .bl-main-row{cursor:pointer;transition:background .2s}
        .bl-main-row:hover td{background:rgba(201,162,39,.06)}
        .bl-modal-overlay{
            display:none;position:fixed;inset:0;z-index:60;
            background:rgba(10,23,54,.45);backdrop-filter:blur(8px);
            align-items:center;justify-content:center;padding:24px;
        }
        .bl-modal-overlay.show{display:flex}
        .bl-modal{
            position:relative;width:min(960px,100%);max-height:90vh;overflow-y:auto;
            background:linear-gradient(165deg,#fff,rgba(247,245,240,.98));
            border:1px solid rgba(197,160,89,.25);border-radius:16px;
            box-shadow:0 24px 64px rgba(0,0,0,.12);padding:26px 28px 24px;
        }
        .bl-modal-close{
            position:absolute;top:14px;right:16px;width:34px;height:34px;border-radius:8px;
            background:var(--white);border:1px solid var(--border-gold);
            color:var(--text-dark);font-size:22px;line-height:1;cursor:pointer;
        }
        .bl-modal-close:hover{border-color:var(--gold);color:var(--gold)}
        .bl-detail-head{margin:0 0 16px;padding-right:40px;text-align:center}
        .bl-detail-head h3{font-family:'Cormorant Garamond',serif;font-size:24px;color:var(--text-dark);margin:0 0 4px}
        .bl-detail-head p{color:var(--muted);font-size:13px;margin:0}
        .bl-detail-summary .bl-sum-item{
            flex:1 1 140px;text-align:center;padding:12px 14px;border-radius:10px;
            background:var(--white);border:1px solid var(--border-gold);box-shadow:var(--shadow-soft);
        }
        .bl-detail-summary .bl-sum-item strong{font-size:15px;color:var(--navy-mid)}
        .bl-detail-section{margin-bottom:20px}
        .bl-detail-section h4{
            font-size:12px;text-transform:uppercase;letter-spacing:1.2px;color:var(--gold);
            margin:0 0 10px;text-align:center;
        }
        .bl-detail-section .table-wrap{margin:0}
        .bl-detail-section table{font-size:13px}
        .bl-detail-section th,.bl-detail-section td{padding:10px 12px}

        /* ===== Mouvement Stock ===== */
        #stock-mouvement .sm-form-one{
            display:grid;
            grid-template-columns:
                minmax(96px,0.68fr)
                minmax(48px,0.4fr)
                minmax(0,1.45fr)
                minmax(58px,0.48fr)
                minmax(48px,0.4fr)
                minmax(58px,0.44fr)
                minmax(50px,0.42fr)
                minmax(68px,0.5fr);
            gap:6px 8px;margin-bottom:14px;align-items:end;
        }
        #stock-mouvement .sm-form-one .field label{font-size:9px;letter-spacing:1px;margin-bottom:3px}
        #stock-mouvement .sm-form-one .sm-f-date input{font-size:11px;padding:8px 4px}
        #stock-mouvement .sm-form-one .sm-f-ref input,
        #stock-mouvement .sm-form-one .sm-f-init input,
        #stock-mouvement .sm-form-one .sm-f-sortie input,
        #stock-mouvement .sm-form-one .sm-f-stock input{font-size:12px;padding:8px 6px;text-align:center}
        #stock-mouvement .sm-form-one .sm-f-stat select{font-size:11.5px;padding:8px 4px}
        #stock-mouvement .sm-f-etat .sm-etat-box{
            min-height:36px;display:flex;align-items:center;justify-content:center;
            background:rgba(0,0,0,.15);border:1px solid rgba(201,162,39,.18);border-radius:8px;padding:4px 6px;
        }
        #stock-mouvement .sm-f-stock input[readonly]{opacity:.95;color:var(--gold-light);font-weight:600;cursor:default}
        #stock-mouvement .sm-form-one input[readonly],
        #stock-mouvement .sm-form-one input[readonly]:focus{opacity:.85;cursor:default;background:rgba(0,0,0,.12)}
        .st-etat{
            display:inline-block;padding:4px 11px;border-radius:20px;font-size:11px;font-weight:600;
            letter-spacing:.3px;text-transform:uppercase;
        }
        .st-etat.dispo{background:rgba(69,200,120,.18);color:#9ee8b8;border:1px solid rgba(69,200,120,.35)}
        .st-etat.faible{background:rgba(230,199,90,.18);color:#f3e4a8;border:1px solid rgba(230,199,90,.35)}
        .st-etat.rupture{background:rgba(224,112,112,.18);color:#ffc0c0;border:1px solid rgba(224,112,112,.35)}
        .st-statut{font-size:12px;font-weight:600;text-transform:capitalize}
        .st-statut.actif{color:#9ee8b8}
        .st-statut.inactif{color:var(--muted)}
        #sm_table .sm-row.selected td{background:rgba(201,162,39,.12)}
        #sm_table th{font-size:10px;white-space:nowrap}
        #sm_table td{font-size:12.5px}
        @media(max-width:1280px){
            #stock-mouvement .sm-form-one{grid-template-columns:repeat(4,minmax(0,1fr))}
            #stock-mouvement .sm-form-one .sm-f-desig{grid-column:span 2}
        }
        @media(max-width:768px){
            #stock-mouvement .sm-form-one{grid-template-columns:repeat(2,minmax(0,1fr))}
            #stock-mouvement .sm-form-one .field{grid-column:span 1!important}
            #stock-mouvement .sm-form-one .sm-f-desig{grid-column:span 2!important}
        }

        /* ===== État Produit ===== */
        #stock-etat .ep-form-one{
            display:grid;
            grid-template-columns:
                minmax(96px,0.68fr)
                minmax(62px,0.52fr)
                minmax(52px,0.42fr)
                minmax(0,1.15fr)
                minmax(50px,0.42fr)
                minmax(58px,0.48fr)
                minmax(0,0.92fr)
                minmax(0,0.9fr);
            gap:6px 8px;margin-bottom:14px;align-items:end;
        }
        #stock-etat .ep-form-one .field label{font-size:9px;letter-spacing:1px;margin-bottom:3px}
        #stock-etat .ep-form-one .ep-f-date input{font-size:11px;padding:8px 4px}
        #stock-etat .ep-form-one .ep-f-num input,
        #stock-etat .ep-form-one .ep-f-ref input,
        #stock-etat .ep-form-one .ep-f-qte input,
        #stock-etat .ep-form-one .ep-f-stock input{font-size:12px;padding:8px 6px;text-align:center}
        #stock-etat .ep-form-one .ep-f-num input[readonly],
        #stock-etat .ep-form-one .ep-f-stock input[readonly]{opacity:.9;cursor:default;color:var(--gold-light);font-weight:600}
        #ep_table .ep-row.selected td{background:rgba(201,162,39,.12)}
        #ep_table th{font-size:10px;white-space:nowrap}
        #ep_table td{font-size:12.5px}
        @media(max-width:1280px){
            #stock-etat .ep-form-one{grid-template-columns:repeat(4,minmax(0,1fr))}
            #stock-etat .ep-form-one .ep-f-desig,
            #stock-etat .ep-form-one .ep-f-dest{grid-column:span 2}
        }
        @media(max-width:768px){
            #stock-etat .ep-form-one{grid-template-columns:repeat(2,minmax(0,1fr))}
            #stock-etat .ep-form-one .field{grid-column:span 1!important}
            #stock-etat .ep-form-one .ep-f-desig,
            #stock-etat .ep-form-one .ep-f-dest,
            #stock-etat .ep-form-one .ep-f-charge{grid-column:span 2!important}
        }

        .overlay{display:none;position:fixed;inset:0;background:rgba(10,23,54,.25);z-index:35}

        /* ===== Gestion des chambres (maquette) ===== */
        .panel#ch-etat{max-width:100%;width:100%}
        .content.ch-view{
            padding-left:16px;padding-right:16px;padding-bottom:24px;
            align-items:stretch;
        }
        .content.ch-view .panel#ch-etat{max-width:100%;margin:0}
        /* ch-kpi hérite de la règle commune .dash-kpi,.ch-kpi,.section-kpi */
        .ch-kpi{
            background:linear-gradient(180deg,rgba(255,255,255,.98) 0%,rgba(240,242,247,.97) 100%);
            padding:16px 32px 18px;
        }
        @media(max-width:900px){.ch-kpi{padding:14px 20px 16px}}
        .ch-manage-wrap{
            display:block;position:relative;width:100%;
            background:transparent;border-radius:0;overflow:visible;
            min-height:auto;
        }
        .ch-manage-main{
            width:100%;min-width:0;padding:16px 356px 28px 12px;
            background:#f0f2f7;border-radius:16px;
            box-sizing:border-box;
        }
        /* Panneau figé — hors flux, ne bouge jamais au filtre */
        .ch-detail-panel,
        .ch-detail-panel.is-open{
            position:fixed!important;
            top:calc(var(--topbar-h) + 132px);
            right:18px;
            bottom:18px;
            left:auto;
            width:340px!important;
            max-width:340px!important;
            min-height:0!important;
            max-height:none!important;
            height:auto;
            margin:0!important;
            flex:none!important;
            align-self:auto!important;
            display:flex!important;
            flex-direction:column;
            background:linear-gradient(165deg,#12182a 0%,#1a2236 48%,#162033 100%);
            border:1px solid rgba(197,160,89,.28);
            border-radius:18px;
            overflow:hidden;
            box-shadow:0 16px 48px rgba(10,23,54,.22),inset 0 1px 0 rgba(255,255,255,.06);
            transform:none!important;
            translate:none!important;
            transition:none!important;
            animation:none!important;
            pointer-events:auto;opacity:1;
            z-index:24;
        }
        .ch-detail-panel.is-open{
            border-color:rgba(197,160,89,.45);
            box-shadow:0 20px 56px rgba(10,23,54,.28),0 0 0 1px rgba(197,160,89,.12),inset 0 1px 0 rgba(255,255,255,.08);
        }
        .admin-wrap.sb-collapsed .ch-detail-panel,
        .admin-wrap.sb-collapsed .ch-detail-panel.is-open{right:18px}
        @media(max-width:1200px){
            .ch-detail-panel,.ch-detail-panel.is-open{top:calc(var(--topbar-h) + 240px)}
            .ch-manage-main{padding-right:320px}
            .ch-detail-panel,.ch-detail-panel.is-open{width:300px!important;max-width:300px!important}
        }
        @media(max-width:900px){
            .ch-manage-main{padding:16px 12px 28px}
            .ch-detail-panel,.ch-detail-panel.is-open{
                position:relative!important;
                top:auto!important;right:auto!important;bottom:auto!important;
                width:100%!important;max-width:100%!important;
                height:auto;max-height:50vh;margin-bottom:14px!important;z-index:2;
            }
        }
        #chDetailContent{min-height:0;flex:1;display:flex;flex-direction:column;overflow-y:auto}
        .ch-detail-panel{display:flex;flex-direction:column}
        .ch-dp-floor-bar{
            flex-shrink:0;padding:14px 14px 12px;
            display:flex;flex-direction:column;gap:8px;
            background:linear-gradient(180deg,rgba(197,160,89,.12),rgba(255,255,255,.03));
            border-bottom:1px solid rgba(197,160,89,.28);
        }
        .ch-dp-floor-bar label{
            font-size:10px;font-weight:600;letter-spacing:1.4px;text-transform:uppercase;
            color:var(--gold);margin:0;
        }
        .ch-dp-floor-bar select{
            width:100%;padding:10px 12px;border-radius:10px;
            border:1px solid rgba(197,160,89,.35);
            background:rgba(10,18,36,.55);color:#f5f1e6;
            font-size:13px;font-weight:500;outline:none;cursor:pointer;
            appearance:auto;
        }
        .ch-dp-floor-bar select:focus{
            border-color:var(--gold);box-shadow:0 0 0 2px rgba(197,160,89,.2);
        }
        .ch-dp-floor-bar select option{background:#1a2236;color:#f5f1e6}
        .ch-dp-empty{
            flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;
            text-align:center;padding:40px 28px;gap:14px;
        }
        .ch-dp-empty-ico{
            width:64px;height:64px;border-radius:18px;
            display:flex;align-items:center;justify-content:center;font-size:28px;
            background:rgba(197,160,89,.12);border:1px solid rgba(197,160,89,.3);
            color:var(--gold-light);box-shadow:0 0 28px rgba(197,160,89,.15);
        }
        .ch-dp-empty h4{
            margin:0;font-family:'Cormorant Garamond',serif;font-size:26px;font-weight:600;
            color:#f5f1e6;letter-spacing:.5px;
        }
        .ch-dp-empty p{margin:0;font-size:13px;line-height:1.55;color:rgba(245,241,230,.55);max-width:22ch}
        .ch-dp-hero{
            position:relative;height:210px;overflow:hidden;flex-shrink:0;
            background:#0a1224;
        }
        .ch-dp-hero img{
            width:100%;height:100%;object-fit:cover;object-position:center;
            display:block;filter:saturate(1.05) brightness(1);
        }
        .ch-dp-hero::after{
            content:'';position:absolute;inset:0;pointer-events:none;
            background:linear-gradient(180deg,rgba(10,18,36,.08) 0%,rgba(10,18,36,0) 46%,rgba(18,24,42,.78) 100%);
        }
        .ch-dp-hero-top{
            position:absolute;top:12px;left:12px;right:12px;z-index:2;
            display:flex;align-items:center;justify-content:space-between;gap:8px;
        }
        .ch-dp-close{
            width:34px;height:34px;border:1px solid rgba(255,255,255,.18);
            background:rgba(10,18,36,.55);backdrop-filter:blur(8px);
            border-radius:10px;cursor:pointer;font-size:18px;color:#f5f1e6;
            display:flex;align-items:center;justify-content:center;line-height:1;
            transition:background .2s,border-color .2s,color .2s;
        }
        .ch-dp-close:hover{background:rgba(197,160,89,.25);border-color:rgba(197,160,89,.5);color:var(--gold-light)}
        .ch-dp-status{
            padding:5px 12px;border-radius:999px;font-size:10px;font-weight:700;
            letter-spacing:.8px;text-transform:uppercase;
            backdrop-filter:blur(8px);border:1px solid transparent;
        }
        .ch-dp-status.st-disponible{background:rgba(209,250,229,.92);color:#047857}
        .ch-dp-status.st-occupee{background:rgba(219,234,254,.92);color:#1d4ed8}
        .ch-dp-status.st-reservee{background:rgba(255,237,213,.92);color:#c2410c}
        .ch-dp-status.st-nettoyage{background:rgba(243,232,255,.92);color:#7c3aed}
        .ch-dp-status.st-maintenance{background:rgba(254,226,226,.92);color:#dc2626}
        .ch-dp-hero-info{
            position:absolute;left:16px;right:16px;bottom:14px;z-index:2;
        }
        .ch-dp-hero-info .ch-dp-num{
            font-family:'Cormorant Garamond',serif;font-size:34px;font-weight:700;
            color:#fff;line-height:1;letter-spacing:.5px;
            text-shadow:0 2px 16px rgba(0,0,0,.45);
        }
        .ch-dp-hero-info .ch-dp-title{
            margin-top:4px;font-size:13px;color:rgba(245,241,230,.82);
            font-family:'Montserrat',sans-serif;letter-spacing:.2px;
        }
        .ch-dp-price-band{
            display:flex;align-items:center;justify-content:space-between;gap:10px;
            margin:-1px 14px 0;padding:12px 14px;position:relative;z-index:3;
            background:linear-gradient(135deg,rgba(197,160,89,.18),rgba(197,160,89,.08));
            border:1px solid rgba(197,160,89,.35);border-radius:12px;
            box-shadow:0 8px 24px rgba(0,0,0,.18);
        }
        .ch-dp-price-band .lbl{
            font-size:10px;letter-spacing:1.4px;text-transform:uppercase;
            color:rgba(245,241,230,.55);font-weight:600;
        }
        .ch-dp-price-band .val{
            font-family:'Cormorant Garamond',serif;font-size:24px;font-weight:700;
            color:var(--gold-light);line-height:1;
        }
        .ch-dp-price-band .val small{font-size:12px;font-weight:500;color:rgba(245,241,230,.5);margin-left:4px}
        .ch-dp-body{padding:16px 16px 18px;flex:1;display:flex;flex-direction:column;gap:14px}
        .ch-dp-specs{
            display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:8px;
            padding:0;border:none;font-size:10px;color:rgba(245,241,230,.55);
        }
        .ch-dp-specs span{
            display:flex;flex-direction:column;align-items:flex-start;gap:4px;
            padding:10px 12px;border-radius:10px;
            background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.07);
        }
        .ch-dp-specs b{font-size:12px;color:#f5f1e6;font-weight:600}
        .ch-dp-attrs{
            padding:0;border:none;display:flex;flex-direction:column;gap:0;
            background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.07);border-radius:12px;
            overflow:hidden;
        }
        .ch-dp-row{
            display:flex;justify-content:space-between;align-items:center;gap:10px;
            padding:11px 14px;font-size:12px;
            border-bottom:1px solid rgba(255,255,255,.06);
        }
        .ch-dp-row:last-child{border-bottom:none}
        .ch-dp-row span{color:rgba(245,241,230,.5)}
        .ch-dp-row strong{color:#f5f1e6;font-weight:600;text-align:right}
        .ch-dp-desc{
            margin:0;padding:0;border:none;font-size:12.5px;line-height:1.65;
            color:rgba(245,241,230,.65);
        }
        .ch-dp-section-lbl{
            display:block;margin-bottom:8px;
            font-size:10px;font-weight:600;letter-spacing:1.6px;text-transform:uppercase;
            color:var(--gold);
        }
        .ch-dp-equip{
            padding:0;border:none;display:flex;flex-wrap:wrap;gap:8px;
        }
        .ch-dp-equip span{
            width:38px;height:38px;border-radius:10px;
            background:rgba(197,160,89,.1);border:1px solid rgba(197,160,89,.22);
            display:flex;align-items:center;justify-content:center;font-size:15px;
            transition:background .2s,border-color .2s;
        }
        .ch-dp-equip span:hover{
            background:rgba(197,160,89,.2);border-color:rgba(197,160,89,.4);
        }
        .ch-dp-actions{
            margin-top:auto;padding-top:4px;
            display:flex;flex-direction:column;gap:8px;
        }
        .ch-dp-actions .ch-btn-primary{
            width:100%;text-align:center;
            background:linear-gradient(135deg,var(--gold),var(--gold-light));
            color:#1a1304;border:none;box-shadow:0 8px 22px rgba(197,160,89,.28);
        }
        .ch-dp-actions .ch-btn-primary:hover{
            background:linear-gradient(135deg,var(--gold-light),#f3e4a8);
            transform:none;filter:brightness(1.03);
        }
        .ch-dp-actions .ch-btn-outline{
            width:100%;text-align:center;
            background:transparent;color:rgba(245,241,230,.85);
            border:1px solid rgba(197,160,89,.35);
        }
        .ch-dp-actions .ch-btn-outline:hover{
            border-color:var(--gold);color:var(--gold-light);background:rgba(197,160,89,.08);
        }
        .ch-dp-danger{
            width:100%;padding:11px;border-radius:8px;
            border:1px solid rgba(224,112,112,.35);
            background:rgba(224,112,112,.08);color:#f0a0a0;
            font-size:12px;font-weight:600;cursor:pointer;transition:background .2s,border-color .2s;
        }
        .ch-dp-danger:hover{background:rgba(224,112,112,.16);border-color:rgba(224,112,112,.55)}
        #ch-etat .ch-detail-panel,
        #ch-etat .ch-detail-panel.is-open{
            position:fixed!important;
            transform:none!important;
            translate:none!important;
            transition:none!important;
            animation:none!important;
        }
        #ch-etat.panel.active{animation:none;transform:none;margin:0}
        .ch-page-head{
            display:flex;align-items:flex-start;justify-content:space-between;
            gap:20px;flex-wrap:wrap;margin-bottom:24px;
        }
        .ch-page-head h2,.ch-breadcrumb{display:none}
        .ch-page-actions{display:flex;align-items:center;gap:10px;flex-wrap:wrap}
        .ch-page-actions-only{display:flex;align-items:center;justify-content:flex-end;gap:10px;flex-wrap:wrap;margin-bottom:22px}
        .ch-btn-primary{
            background:#1a2236;color:#fff;border:none;border-radius:8px;
            padding:11px 18px;font-size:12px;font-weight:600;cursor:pointer;
            letter-spacing:.3px;transition:background .2s,transform .2s;
        }
        .ch-btn-primary:hover{background:#0f1524;transform:translateY(-1px)}
        .ch-btn-outline{
            background:#fff;color:#1a2332;border:1px solid #d1d5db;border-radius:8px;
            padding:11px 18px;font-size:12px;font-weight:600;cursor:pointer;transition:all .2s;
        }
        .ch-btn-outline:hover{border-color:var(--gold);color:var(--gold)}
        .ch-btn-icon{
            position:relative;width:42px;height:42px;border-radius:8px;border:1px solid #e5e7eb;
            background:#fff;cursor:pointer;font-size:18px;display:flex;align-items:center;justify-content:center;
        }
        .ch-notif-badge{
            position:absolute;top:-4px;right:-4px;min-width:18px;height:18px;padding:0 5px;
            background:#dc2626;color:#fff;font-size:10px;font-weight:700;border-radius:10px;
            display:flex;align-items:center;justify-content:center;
        }
        .ch-stats-row{
            display:grid;
            grid-template-columns:repeat(6,minmax(0,1fr));
            gap:12px;margin:0;
            align-items:stretch;
        }
        @media(max-width:1200px){.ch-stats-row{grid-template-columns:repeat(3,minmax(0,1fr))}}
        @media(max-width:640px){.ch-stats-row{grid-template-columns:repeat(2,minmax(0,1fr))}}
        .ch-stat-card,
        .ch-stat-card:hover,
        .ch-stat-card:focus,
        .ch-stat-card:active{
            background:#fff;border-radius:12px;padding:16px 16px 14px;
            box-shadow:0 1px 4px rgba(0,0,0,.06);display:flex;gap:14px;align-items:flex-start;
            min-height:92px;
            border:1px solid #eef0f4;
            transform:none!important;translate:none!important;
            transition:none!important;animation:none!important;
            position:relative;order:0!important;
            will-change:auto;
        }
        .ch-stat-ico{
            width:42px;height:42px;border-radius:10px;flex-shrink:0;
            display:flex;align-items:center;justify-content:center;font-size:18px;
        }
        .ch-stat-card.st-total .ch-stat-ico{background:#dbeafe;color:#2563eb}
        .ch-stat-card.st-dispo .ch-stat-ico{background:#d1fae5;color:#059669}
        .ch-stat-card.st-occu .ch-stat-ico{background:#dbeafe;color:#1d4ed8}
        .ch-stat-card.st-resa .ch-stat-ico{background:#ffedd5;color:#d97706}
        .ch-stat-card.st-nett .ch-stat-ico{background:#f3e8ff;color:#7c3aed}
        .ch-stat-card.st-maint .ch-stat-ico{background:#fee2e2;color:#dc2626}
        .ch-stat-body{min-width:0;flex:1}
        .ch-stat-body b{
            display:block;font-size:22px;font-weight:700;color:#1a2332;line-height:1.1;
            font-variant-numeric:tabular-nums;min-height:1.1em;
        }
        .ch-stat-body span{display:block;font-size:11px;color:#6b7280;margin-top:2px}
        .ch-stat-body small{
            font-size:10px;color:#9ca3af;margin-top:4px;display:block;min-height:1.2em;
        }
        .ch-toolbar{
            display:flex;flex-wrap:wrap;gap:10px;align-items:center;justify-content:center;margin-bottom:14px;
            background:#fff;padding:12px 14px;border-radius:12px;
            box-shadow:0 1px 4px rgba(0,0,0,.05);
        }
        #ch-etat .ch-toolbar{
            position:static!important;top:auto!important;z-index:auto!important;
            backdrop-filter:none!important;width:100%;
        }
        .ch-search-wrap{
            flex:0 1 280px;min-width:200px;max-width:360px;position:relative;display:flex;align-items:center;
        }
        .ch-search-ico{position:absolute;left:12px;font-size:14px;opacity:.45;pointer-events:none}
        .ch-search-wrap input{
            width:100%;padding:10px 12px 10px 36px;border:1px solid #e5e7eb;border-radius:8px;
            font-size:13px;outline:none;background:#f9fafb;
        }
        .ch-search-wrap input:focus{border-color:var(--gold);background:#fff}
        .ch-select{
            padding:10px 14px;border:1px solid #e5e7eb;border-radius:8px;
            font-size:12px;color:#374151;background:#fff;cursor:pointer;outline:none;
        }
        .ch-view-toggle{display:none!important}
        .ch-room-grid{
            display:grid;
            grid-template-columns:repeat(5,minmax(0,1fr));
            gap:14px;
            align-items:start;
            grid-auto-flow:dense;
        }
        @media(max-width:1400px){.ch-room-grid{grid-template-columns:repeat(4,minmax(0,1fr))}}
        @media(max-width:1100px){.ch-room-grid{grid-template-columns:repeat(3,minmax(0,1fr))}}
        @media(max-width:760px){.ch-room-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}
        @media(max-width:480px){.ch-room-grid{grid-template-columns:1fr}}
        .ch-room-card,
        .ch-room-card:hover,
        .ch-room-card:focus,
        .ch-room-card:active,
        .ch-room-card.is-selected,
        .ch-room-card.hidden-filter{
            background:#fff;border-radius:12px;overflow:hidden;cursor:pointer;
            box-shadow:0 2px 8px rgba(0,0,0,.06);border:1px solid #eef0f4;
            display:flex!important;flex-direction:column;position:relative;
            transform:none!important;translate:none!important;
            transition:none!important;animation:none!important;
            will-change:auto;
            height:auto;min-height:0;max-height:none;
            order:0!important;
            margin:0!important;
            top:auto!important;left:auto!important;
        }
        .ch-room-card.is-selected{border-color:var(--gold);box-shadow:0 0 0 2px rgba(197,160,89,.25)}
        /* Case réservée : filtre = invisible, jamais de reflow */
        .ch-room-card.hidden-filter{
            visibility:hidden!important;
            opacity:0!important;
            pointer-events:none!important;
            display:flex!important;
        }
        .ch-rc-img{position:relative;aspect-ratio:4/3;height:auto;overflow:hidden;background:#e5e7eb;flex-shrink:0}
        .ch-rc-img img{
            position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:center;display:block;pointer-events:none;
            transform:none!important;scale:1!important;transition:none!important;animation:none!important;
        }
        .ch-rc-badge{
            position:absolute;top:8px;right:8px;z-index:2;padding:3px 8px;border-radius:20px;
            font-size:9px;font-weight:700;letter-spacing:.3px;text-transform:uppercase;
        }
        .ch-rc-badge.st-disponible{background:#d1fae5;color:#059669}
        .ch-rc-badge.st-occupee{background:#dbeafe;color:#2563eb}
        .ch-rc-badge.st-reservee{background:#ffedd5;color:#d97706}
        .ch-rc-badge.st-nettoyage{background:#f3e8ff;color:#7c3aed}
        .ch-rc-badge.st-maintenance{background:#fee2e2;color:#dc2626}
        .ch-rc-file{
            position:absolute;top:8px;left:8px;z-index:3;
            width:34px;height:34px;border-radius:10px;padding:0;
            border:1px solid rgba(255,255,255,.5);
            background:rgba(12,20,40,.66);color:#f3d38a;cursor:pointer;
            display:flex;align-items:center;justify-content:center;
            backdrop-filter:blur(6px);
            box-shadow:0 4px 14px rgba(0,0,0,.28);
        }
        .ch-rc-file svg{width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;display:block}
        .ch-rc-file:hover{background:#e7b15a;color:#1a1304;border-color:transparent}
        .ch-rc-file-n{
            position:absolute;top:-6px;right:-6px;min-width:16px;height:16px;padding:0 4px;
            border-radius:8px;background:#e7b15a;color:#1a1304;
            font-size:9px;font-weight:700;line-height:16px;text-align:center;
        }
        .ch-inv-overlay{
            display:none;position:fixed;inset:0;z-index:70;
            background:rgba(10,23,54,.48);backdrop-filter:blur(8px);
            align-items:center;justify-content:center;padding:24px;
        }
        .ch-inv-overlay.show{display:flex}
        .ch-inv-panel{
            position:relative;width:min(560px,100%);max-height:min(86vh,760px);overflow:auto;
            background:#fff;border-radius:18px;border:1px solid rgba(197,160,89,.35);
            box-shadow:0 24px 64px rgba(10,23,54,.22);
        }
        .ch-inv-head{
            padding:22px 52px 16px 22px;
            background:linear-gradient(165deg,#12182a 0%,#1a2236 100%);
            color:#f5f1e6;border-radius:18px 18px 0 0;
        }
        .ch-inv-kicker{font-size:10px;font-weight:700;letter-spacing:1.6px;text-transform:uppercase;color:#e7b15a}
        .ch-inv-head h3{margin:6px 0 0;font-family:'Cormorant Garamond',serif;font-size:30px;font-weight:600;color:#fff}
        .ch-inv-head p{margin:4px 0 0;color:rgba(245,241,230,.7);font-size:13px}
        .ch-inv-close{
            position:absolute;top:14px;right:14px;width:34px;height:34px;border-radius:10px;
            border:1px solid rgba(255,255,255,.2);background:rgba(10,18,36,.45);color:#f5f1e6;
            font-size:20px;line-height:1;cursor:pointer;
        }
        .ch-inv-close:hover{border-color:#e7b15a;color:#e7b15a}
        .ch-inv-body{padding:16px 18px 18px;display:flex;flex-direction:column;gap:12px}
        .ch-inv-empty{margin:8px 0;text-align:center;color:#6b7280;font-size:13px;line-height:1.5}
        .ch-inv-piece{border:1px solid #eef0f4;border-radius:12px;overflow:hidden}
        .ch-inv-piece h4{
            margin:0;padding:10px 14px;background:rgba(197,160,89,.12);color:#8a6a2f;
            font-size:11px;font-weight:700;letter-spacing:1.1px;text-transform:uppercase;
        }
        .ch-inv-piece ul{list-style:none;margin:0;padding:0}
        .ch-inv-piece li{
            display:flex;align-items:center;justify-content:space-between;gap:10px;
            padding:11px 14px;border-top:1px solid #f3f4f6;font-size:14px;color:#1a2332;
        }
        .ch-inv-del{border:0;background:transparent;color:#c05050;font-size:11px;font-weight:700;cursor:pointer;letter-spacing:.3px}
        .ch-inv-del:hover{color:#9b2c2c}
        .ch-inv-form{padding:18px 18px 20px;display:grid;gap:12px}
        .ch-inv-form label{font-size:10px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:#8a6a2f}
        .ch-inv-form input,.ch-inv-form select{
            width:100%;margin-top:6px;padding:11px 12px;border-radius:10px;
            border:1px solid rgba(197,160,89,.35);background:#fff;color:#1a2332;font-size:14px;outline:none;
        }
        .ch-inv-form input:focus,.ch-inv-form select:focus{border-color:#c5a059;box-shadow:0 0 0 3px rgba(197,160,89,.15)}
        .ch-inv-custom{display:none}
        .ch-inv-custom.is-on{display:block}
        .ch-inv-note{min-height:1.2em;margin:0;font-size:12px;color:#059669}
        .ch-inv-save{
            justify-self:start;border:0;border-radius:10px;cursor:pointer;
            padding:11px 18px;font-size:12px;font-weight:700;letter-spacing:.4px;
            background:linear-gradient(135deg,#c5a059,#e7b15a);color:#1a1304;
        }
        .ch-inv-save:hover{filter:brightness(1.05)}
        .ch-rc-body{padding:10px 12px 12px;flex:1;display:flex;flex-direction:column;min-height:0}
        .ch-rc-num{font-size:17px;font-weight:700;color:#1a2332;line-height:1;margin-bottom:2px}
        .ch-rc-title{font-family:'Cormorant Garamond',serif;font-size:13px;color:#4b5563;margin-bottom:6px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
        .ch-rc-meta{display:flex;flex-wrap:wrap;gap:6px;font-size:10px;color:#6b7280;margin-bottom:8px}
        .ch-rc-meta span{display:inline-flex;align-items:center;gap:3px}
        .ch-rc-price{margin-top:auto;font-size:13px;font-weight:700;color:#1a2232}
        .ch-rc-price small{font-size:10px;font-weight:500;color:#9ca3af}
        .ch-cat-grid,.ch-etages-grid{
            display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:18px;
        }
        .ch-etages-row{
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(140px,1fr));
            gap:14px;margin:0;
            align-items:stretch;
        }
        .ch-etage-card,
        .ch-etage-card:hover,
        .ch-etage-card:focus{
            background:#fff;border:1px solid var(--border-gold);border-radius:14px;
            padding:16px 14px;cursor:pointer;
            box-shadow:var(--shadow-soft);
            transform:none!important;translate:none!important;
            transition:none!important;animation:none!important;
            min-height:96px;display:flex;flex-direction:column;gap:6px;
            position:relative;overflow:hidden;
        }
        .ch-etage-card::before{
            content:'';position:absolute;left:0;top:12px;bottom:12px;width:3px;border-radius:0 3px 3px 0;
            background:linear-gradient(180deg,var(--gold-light),var(--gold));
        }
        .ch-etage-card h3{
            font-family:'Cormorant Garamond',serif;font-size:22px;color:var(--text-dark);
            margin:0;padding-left:8px;line-height:1.1;
        }
        .ch-etage-card .et-count{
            font-family:'Montserrat',sans-serif;font-size:28px;font-weight:700;
            color:var(--navy-mid);padding-left:8px;line-height:1;
            font-variant-numeric:tabular-nums;
        }
        .ch-etage-card p,.ch-etage-card .et-meta{
            font-size:11px;color:var(--muted);margin:0;padding-left:8px;
        }
        .ch-etage-card:hover{border-color:rgba(197,160,89,.45);box-shadow:0 8px 24px rgba(197,160,89,.12)}
        .ch-etage-card.is-dimmed{opacity:.35;pointer-events:none}
        .ch-etage-card.is-active{border-color:var(--gold);box-shadow:0 0 0 2px rgba(197,160,89,.25)}
        .ch-cat-card{
            background:#fff;border:1px solid var(--border-gold);border-radius:14px;
            padding:22px;cursor:pointer;transition:box-shadow .2s,border-color .2s;
            box-shadow:var(--shadow-soft);
            transform:none!important;
        }
        .ch-cat-card:hover{transform:none!important;box-shadow:0 8px 24px rgba(197,160,89,.12)}
        .ch-cat-card h3{font-family:'Cormorant Garamond',serif;font-size:22px;color:var(--text-dark);margin:0 0 8px}
        .ch-cat-card p{font-size:13px;color:var(--muted);margin:0}
        #ch-etages.panel.active{animation:none!important;transform:none!important}
        #ch-etages .block{margin-top:0}
        .ch-etages-toolbar{
            display:flex;flex-wrap:wrap;gap:10px;align-items:center;justify-content:center;
            margin-bottom:16px;
            position:static!important;top:auto!important;z-index:auto!important;backdrop-filter:none!important;
        }
        .ch-etages-toolbar .ch-search-wrap{flex:0 1 280px;min-width:220px;max-width:360px}
        .ch-etages-toolbar .ch-select{min-width:160px}
        .ch-etages-toolbar .btn-add-et{
            display:inline-flex;align-items:center;gap:8px;margin-left:0;
            padding:10px 16px;border:none;border-radius:10px;cursor:pointer;
            font:700 11px 'Montserrat',sans-serif;letter-spacing:.6px;text-transform:uppercase;
            color:#1a1304;background:linear-gradient(135deg,var(--gold),var(--gold-light));
            box-shadow:0 6px 16px rgba(197,160,89,.28);
        }
        .ch-etages-toolbar .btn-add-et:hover{box-shadow:0 8px 20px rgba(197,160,89,.38)}
        .et-add-mode{display:flex;gap:8px;margin-bottom:14px}
        .et-add-mode button{
            flex:1;padding:10px 12px;border-radius:10px;cursor:pointer;
            border:1px solid rgba(197,160,89,.35);background:#fff;
            font:700 11px 'Montserrat',sans-serif;letter-spacing:.5px;text-transform:uppercase;color:var(--text-dark);
        }
        .et-add-mode button.is-on{
            background:linear-gradient(135deg,var(--tw-navy,#0a1839),var(--tw-indigo,#1a2a5e));
            color:#f3d38a;border-color:transparent;
        }
        .et-add-pane{display:none;flex-direction:column;gap:12px}
        .et-add-pane.is-on{display:flex}
        .et-add-actions{display:flex;gap:10px;margin-top:8px}
        .et-add-actions .btn{flex:1}
        #chEtagesTableBody .et-floor-cell{font-weight:600;color:var(--gold);white-space:nowrap}
        #chEtagesTableBody .et-status{
            display:inline-block;padding:3px 10px;border-radius:20px;font-size:10px;font-weight:700;
            letter-spacing:.3px;text-transform:uppercase;
        }
        #chEtagesTableBody .et-status.st-disponible{background:#d1fae5;color:#059669}
        #chEtagesTableBody .et-status.st-occupee{background:#dbeafe;color:#2563eb}
        #chEtagesTableBody .et-status.st-reservee{background:#ffedd5;color:#d97706}
        #chEtagesTableBody .et-status.st-nettoyage{background:#f3e8ff;color:#7c3aed}
        #chEtagesTableBody .et-status.st-maintenance{background:#fee2e2;color:#dc2626}

        .admin-footer{
            text-align:center;padding:18px 24px;margin-top:auto;
            font-family:'Montserrat',sans-serif;font-size:11px;letter-spacing:.4px;
            color:var(--muted);border-top:1px solid var(--border-gold);
            background:linear-gradient(180deg,rgba(247,245,240,.95),rgba(255,255,255,.98));
        }
        .admin-footer .site-copyright{margin:0;color:var(--muted)}

        /* ===== Harmonisation lumineuse — formulaires & composants restants ===== */
        .rm-msg{text-align:center;padding:28px 16px 12px}
        .rm-msg .rm-msg-dot{
            width:56px;height:56px;border-radius:50%;margin:0 auto 18px;
            display:flex;align-items:center;justify-content:center;font-size:26px;
        }
        .rm-msg.st-occupee .rm-msg-dot{background:rgba(69,200,120,.12);color:#2a9d5c}
        .rm-msg.st-reservee .rm-msg-dot{background:rgba(91,158,245,.12);color:#4a7fd4}
        .rm-msg.st-nettoyage .rm-msg-dot{background:rgba(138,148,168,.12);color:#6b7280}
        .rm-msg.st-maintenance .rm-msg-dot{background:rgba(224,112,112,.12);color:#c05050}
        .rm-form-head{margin-bottom:20px;padding-right:36px}
        .rm-form-grid .field textarea,.rm-form-grid .field select,
        .ba-lines-table .ba-inp,.rm-form-totals .ttl input,
        .bal-row input.pay,.ba-lines-table .ba-inp{
            background:var(--white)!important;color:var(--text-dark)!important;
            border:1px solid var(--border-gold)!important;
        }
        .ba-lines-table .ba-inp.st{color:var(--navy-mid)!important;font-weight:600}
        .rm-form-totals{background:rgba(247,245,240,.8);border:1px solid var(--border-gold)}
        .rm-form-totals .ttl input{color:var(--navy-mid)!important;font-weight:700}
        .rm-status-pick h4{color:var(--text-dark)}
        .rm-st-btn{background:var(--white)}
        .rm-edit-btn{background:var(--white);border:1px solid rgba(197,160,89,.35);color:var(--gold)}
        .rm-edit-btn:hover{background:rgba(197,160,89,.12);color:var(--navy-mid)}
        .rm-edit-preview{background:#e5e7eb;border:1px solid var(--border-gold)}
        .ba-detail-row td{background:rgba(247,245,240,.6)}
        .ba-lines-table tfoot td{color:var(--navy-mid)}
        .ba-total-val{font-family:'Cormorant Garamond',serif;font-size:16px;color:var(--navy-mid)}
        .btn.del:hover{color:#c05050;background:rgba(230,120,120,.08)}
        .panel.frns-panel.frns-compact .field input,
        .panel.frns-panel.frns-compact .field select,
        .panel.frns-panel.frns-compact .bal-row input.pay{
            background:var(--white);border-color:var(--border-gold);color:var(--text-dark);
        }
        .panel.frns-panel.frns-compact .field input[readonly]{background:rgba(247,245,240,.8)}
        .panel.frns-panel.frns-compact .ba-lines-wrap,
        .panel.frns-panel.frns-compact .table-wrap{
            background:var(--white);border:1px solid var(--border-gold);
        }
        .panel.frns-panel.frns-compact .ba-lines-table thead th,
        .panel.frns-panel.frns-compact .table-wrap thead th{
            background:rgba(197,160,89,.08);color:var(--gold);
        }
        .panel.frns-panel.frns-compact .ba-lines-table .ba-inp{
            background:var(--white);border-color:var(--border-gold);color:var(--text-dark);
        }
        #stock-mouvement .sm-f-etat .sm-etat-box{background:var(--white);border:1px solid var(--border-gold)}
        #stock-mouvement .sm-form-one input[readonly]{background:rgba(247,245,240,.8)!important}
        .st-etat.dispo{background:rgba(69,200,120,.12);color:#2a9d5c;border:1px solid rgba(69,200,120,.25)}
        .st-etat.faible{background:rgba(197,160,89,.12);color:var(--gold);border:1px solid rgba(197,160,89,.25)}
        .st-etat.rupture{background:rgba(224,112,112,.12);color:#c05050;border:1px solid rgba(224,112,112,.25)}
        .st-statut.actif{color:#2a9d5c}
        .bl-detail-summary{display:flex;flex-wrap:wrap;gap:12px;justify-content:center;margin-bottom:20px}
        .bl-detail-summary .bl-sum-item span{display:block;font-size:10px;color:var(--muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:4px}

        @media(max-width:900px){
            .sidebar{transform:translateX(-100%)}
            .sidebar.open{transform:translateX(0)}
            .admin-wrap.sb-collapsed .sidebar{transform:translateX(-100%)}
            .main{margin-left:0}
            .admin-wrap.sb-collapsed .main{margin-left:0}
            .dash-kpi,.ch-kpi,.section-kpi{left:0}
            .ech-sticky{left:0;padding:14px 20px 12px}
            .hamb{display:block}
            .sb-toggle{display:none}
            .overlay.show{display:block}
        }

        /* ===== VERROUILLAGE DUR — cartes Gestion Chambres ===== */
        #ch-etat.panel,#ch-etat.panel.active{
            animation:none!important;transform:none!important;opacity:1!important;
        }
        #ch-etat .ch-manage-main .ch-stat-card,
        #ch-etat .ch-manage-main .ch-stat-card:hover,
        #ch-etat .ch-manage-main .ch-stat-card:focus,
        #ch-etat .ch-manage-main .ch-stat-card:active,
        #ch-etat .ch-manage-main .ch-room-card,
        #ch-etat .ch-manage-main .ch-room-card:hover,
        #ch-etat .ch-manage-main .ch-room-card:focus,
        #ch-etat .ch-manage-main .ch-room-card:active,
        #ch-etat .ch-manage-main .ch-room-card.is-selected{
            transform:none!important;
            translate:none!important;
            scale:1!important;
            transition:none!important;
            animation:none!important;
            top:auto!important;
            bottom:auto!important;
        }
        #ch-etat .ch-manage-main .ch-room-card img,
        #ch-etat .ch-manage-main .ch-room-card:hover img{
            transform:none!important;scale:1!important;transition:none!important;
        }
        #ch-etat .ch-manage-main .ch-room-card.hidden-filter{
            visibility:hidden!important;opacity:0!important;
            pointer-events:none!important;display:flex!important;
            height:auto!important;max-height:none!important;
        }
        #ch-etat .ch-detail-panel,
        #ch-etat .ch-detail-panel.is-open{
            position:fixed!important;
            transform:none!important;
            translate:none!important;
            transition:none!important;
            animation:none!important;
            top:calc(var(--topbar-h) + 132px)!important;
            right:18px!important;
            bottom:18px!important;
            left:auto!important;
            width:340px!important;
        }
        @media(max-width:1200px){
            #ch-etat .ch-detail-panel,
            #ch-etat .ch-detail-panel.is-open{
                top:calc(var(--topbar-h) + 240px)!important;
                width:300px!important;
            }
        }
        @media(max-width:900px){
            #ch-etat .ch-detail-panel,
            #ch-etat .ch-detail-panel.is-open{
                position:relative!important;
                top:auto!important;right:auto!important;bottom:auto!important;
                width:100%!important;
            }
        }

        /* ===== THÈME CRÉPUSCULE DORÉ — harmonisé avec le fond d'accueil ===== */
        :root{
            --tw-deep:#081433;
            --tw-navy:#0d1f4a;
            --tw-indigo:#1a2a5e;
            --tw-dusk:#3a2b52;
            --tw-sunset:#e8955a;
            --tw-gold-glow:rgba(232,190,110,.55);
            --tw-line:rgba(212,176,106,.22);
            --tw-text:rgba(255,255,255,.82);
            --tw-text-soft:rgba(226,221,208,.62);
        }
        body{
            background:
                linear-gradient(180deg,rgba(248,244,236,.95) 0%,rgba(246,241,231,.97) 100%),
                url('{{ asset('images/hotel-hero.png') }}') center/cover fixed no-repeat;
            background-color:var(--surface);
        }
        .main,.content{background:transparent}

        /* ---- Panneau latéral ---- */
        .sidebar{
            background:
                radial-gradient(ellipse 120% 40% at 50% 104%,rgba(232,149,90,.30),transparent 62%),
                radial-gradient(ellipse 90% 30% at 100% 0%,rgba(212,176,106,.16),transparent 60%),
                linear-gradient(180deg,var(--tw-deep) 0%,var(--tw-navy) 38%,var(--tw-indigo) 72%,var(--tw-dusk) 100%);
            border-right:1px solid var(--tw-line);
            box-shadow:6px 0 40px rgba(4,10,28,.35);
            overflow:hidden;
        }
        .sidebar::before{
            content:'';position:absolute;inset:0;pointer-events:none;z-index:0;
            background:url('{{ asset('images/hotel-hero.png') }}') 22% center/cover no-repeat;
            opacity:.10;mix-blend-mode:screen;
        }
        .sidebar::after{
            opacity:.9;
            background:linear-gradient(180deg,transparent,rgba(212,176,106,.35),var(--gold-light),rgba(212,176,106,.35),transparent);
            background-size:100% 200%;
        }
        .sb-brand{border-bottom:1px solid var(--tw-line);padding:22px 18px 20px}
        .sb-brand:hover{background:rgba(255,255,255,.04)}
        .sb-logo-wrap{
            background:linear-gradient(145deg,#fffdf8,#f3ead6);
            border:1px solid rgba(232,190,110,.55);
            box-shadow:0 0 0 3px rgba(212,176,106,.12),0 8px 22px rgba(0,0,0,.35);
        }
        .sb-est{color:var(--gold-light);letter-spacing:3px}
        .sb-brand-text b{
            color:#fff;font-size:21px;letter-spacing:1.5px;
            text-shadow:0 0 18px rgba(232,190,110,.35);
        }
        .sb-stars{color:#f0c66e;text-shadow:0 0 8px rgba(240,198,110,.6)}

        .sb-nav{scrollbar-color:rgba(212,176,106,.35) transparent}
        .sb-nav::-webkit-scrollbar-thumb{background:rgba(212,176,106,.4)}
        .sb-section-label{color:var(--gold-light);opacity:1;letter-spacing:2.6px}
        .sb-section-label::before{width:18px;background:linear-gradient(90deg,var(--gold-light),transparent)}

        .sb-group{
            background:linear-gradient(180deg,rgba(255,255,255,.055),rgba(255,255,255,.02));
            border:1px solid rgba(212,176,106,.14);
            box-shadow:inset 0 1px 0 rgba(255,255,255,.05);
            backdrop-filter:blur(6px);
        }
        .sb-group.sb-group-flat{background:linear-gradient(180deg,rgba(255,255,255,.055),rgba(255,255,255,.02))}
        .sb-group:has(.sb-item.active),
        .sb-group:has(.sb-sub.open){
            border-color:rgba(232,190,110,.38);
            box-shadow:0 8px 24px rgba(0,0,0,.25),inset 0 1px 0 rgba(255,255,255,.07);
        }
        .sb-group:has(.sb-item.active) .sb-parent{color:#fff}

        .sb-item,.sb-parent{color:var(--tw-text)}
        .ic-wrap{
            background:rgba(212,176,106,.10);
            border:1px solid rgba(212,176,106,.24);
            color:var(--gold-light);
        }
        .sb-item:hover,.sb-parent:hover{
            background:rgba(255,255,255,.07);color:#fff;
            border-color:rgba(212,176,106,.22);
        }
        .sb-item:hover .ic-wrap,.sb-parent:hover .ic-wrap{
            background:rgba(212,176,106,.2);border-color:rgba(232,190,110,.5);color:#f3d38a;
            box-shadow:0 0 14px rgba(232,190,110,.25);
        }
        .sb-item.active:not(.sb-pilot){
            background:linear-gradient(135deg,rgba(232,190,110,.22),rgba(232,149,90,.10));
            border-color:rgba(232,190,110,.42);color:#fff;
            box-shadow:0 6px 18px rgba(0,0,0,.25),inset 0 1px 0 rgba(255,255,255,.08);
        }
        .sb-item.active:not(.sb-pilot) .lbl{color:#fff}

        .sb-item.sb-pilot{
            background:linear-gradient(135deg,rgba(212,176,106,.14),rgba(255,255,255,.03));
            border:1px solid rgba(212,176,106,.26);
        }
        .sb-item.sb-pilot .lbl{color:#fff}
        .sb-item.sb-pilot:hover{
            background:linear-gradient(135deg,rgba(212,176,106,.22),rgba(255,255,255,.05));
            border-color:rgba(232,190,110,.45);
        }
        .sb-item.sb-pilot.active,
        .sb-item.active:not(.sb-pilot):not(.sb-sub .sb-item){
            background:linear-gradient(135deg,#f0cf85 0%,var(--gold-light) 45%,var(--gold) 100%);
            border-color:rgba(255,236,190,.6);color:#1a1304;
            box-shadow:0 8px 26px rgba(212,176,106,.38),0 0 30px rgba(232,149,90,.18),inset 0 1px 0 rgba(255,255,255,.5);
        }
        .sb-item.sb-pilot.active .lbl,
        .sb-item.active:not(.sb-pilot):not(.sb-sub .sb-item) .lbl{color:#1a1304;font-weight:700}
        .sb-item.sb-pilot.active .ic-wrap,
        .sb-item.active:not(.sb-pilot):not(.sb-sub .sb-item) .ic-wrap{
            background:rgba(26,19,4,.10);border-color:rgba(26,19,4,.18);color:#1a1304;box-shadow:none;
        }

        .sb-parent.expanded{
            background:linear-gradient(135deg,rgba(212,176,106,.16),rgba(255,255,255,.03));
            color:#fff;border-color:rgba(212,176,106,.28);
        }
        .sb-parent.expanded .ic-wrap{background:rgba(212,176,106,.22);border-color:rgba(232,190,110,.5);color:#f3d38a}
        .sb-parent .caret{background:rgba(255,255,255,.06);border-color:rgba(212,176,106,.25);color:var(--gold-light)}
        .sb-parent.expanded .caret{background:rgba(212,176,106,.22);border-color:rgba(232,190,110,.5)}
        .sb-parent .sb-badge{background:rgba(255,255,255,.06);color:var(--tw-text-soft);border-color:rgba(212,176,106,.2)}
        .sb-group:has(.sb-item.active) .sb-parent .sb-badge,
        .sb-parent.expanded .sb-badge{background:rgba(212,176,106,.22);color:#f3d38a;border-color:rgba(232,190,110,.4)}

        .sb-sub::before{background:linear-gradient(180deg,var(--gold-light),rgba(212,176,106,.1));opacity:.7}
        .sb-sub .sb-item{background:transparent;color:var(--tw-text-soft)}
        .sb-sub .sb-item:hover{background:rgba(255,255,255,.06);color:#fff;border-color:rgba(212,176,106,.18)}
        .sb-dot{border-color:rgba(212,176,106,.55)}
        .sb-sub .sb-item.active{
            background:linear-gradient(135deg,rgba(232,190,110,.24),rgba(232,149,90,.08));
            color:#fff;border-color:rgba(232,190,110,.4);
            box-shadow:0 4px 14px rgba(0,0,0,.22);
        }
        .sb-sub .sb-item.active .sb-dot{background:#f0cf85;border-color:#f0cf85;box-shadow:0 0 12px rgba(240,207,133,.7)}

        .sb-foot{
            border-top:1px solid var(--tw-line);
            background:linear-gradient(180deg,rgba(8,20,51,.2),rgba(8,20,51,.55));
        }
        .sb-profile{border-bottom:1px solid var(--tw-line)}
        .sb-profile-av{box-shadow:0 0 0 3px rgba(212,176,106,.18),0 6px 16px rgba(0,0,0,.35)}
        .sb-profile-info b{color:#fff}
        .sb-profile-info span{color:var(--tw-text-soft)}
        .sb-profile-caret{color:var(--gold-light)}
        .logout-btn{
            background:rgba(255,255,255,.05);
            border:1px solid rgba(240,128,128,.35);color:#f3a0a0;
        }
        .logout-btn:hover{background:rgba(240,110,110,.14);border-color:rgba(240,128,128,.6);color:#ffd0d0}

        /* ---- Barre du haut ---- */
        .topbar{
            background:
                radial-gradient(ellipse 50% 140% at 100% 50%,rgba(232,149,90,.22),transparent 60%),
                linear-gradient(90deg,rgba(8,20,51,.96) 0%,rgba(13,31,74,.94) 55%,rgba(40,36,82,.93) 100%);
            backdrop-filter:blur(18px) saturate(1.3);
            box-shadow:0 8px 30px rgba(4,10,28,.28);
        }
        .topbar::after{
            opacity:1;
            background:linear-gradient(90deg,transparent,rgba(212,176,106,.25),#f0cf85,var(--gold),#f0cf85,rgba(212,176,106,.25),transparent);
            background-size:200% 100%;
        }
        .topbar h1{color:#fff;text-shadow:0 0 18px rgba(232,190,110,.25)}
        .topbar-brand:hover{background:rgba(255,255,255,.06);border-color:rgba(212,176,106,.3);box-shadow:0 0 22px rgba(232,190,110,.18)}
        .topbar-brand-text .top-est{color:var(--gold-light)}
        .top-logo-wrap{
            background:linear-gradient(145deg,#fffdf8,#f3ead6);
            border:1px solid rgba(232,190,110,.55);
            box-shadow:0 0 0 3px rgba(212,176,106,.12),0 6px 18px rgba(0,0,0,.35);
        }
        .topbar .who{
            padding:6px 8px 6px 16px;border-radius:40px;
            background:rgba(255,255,255,.06);border:1px solid rgba(212,176,106,.25);
        }
        .topbar .who b{color:#fff}
        .topbar .who > div > span{color:var(--gold-light)}
        .aj-bell{background:rgba(255,255,255,.08);border-color:rgba(212,176,106,.35);color:#f3d38a}
        .aj-bell:hover{background:rgba(212,176,106,.16);border-color:rgba(240,207,133,.55)}
        .aj-bell.is-alert{background:rgba(196,84,84,.18);border-color:#e07070;color:#ffb4a8}
        .aj-bell-panel{background:#122a58;border-color:rgba(212,176,106,.3)}
        .aj-bell-head{background:linear-gradient(180deg,#16305f,#0f234c);border-bottom-color:rgba(212,176,106,.25)}
        .aj-bell-head strong{color:#fff}
        .aj-bell-item{background:rgba(255,255,255,.04);border-color:rgba(212,176,106,.2)}
        .aj-bell-item:hover{background:rgba(255,255,255,.08)}
        .aj-bell-item.is-unread{background:rgba(196,84,84,.12);border-color:rgba(224,112,112,.4)}
        .aj-bell-item b{color:#fff}
        .aj-bell-item span,.aj-bell-empty{color:rgba(255,255,255,.65)}
        .topbar .who img{border-color:#f0cf85;box-shadow:0 0 14px rgba(240,207,133,.35)}
        .sb-toggle{
            background:rgba(255,255,255,.06);border:1px solid rgba(212,176,106,.3);color:var(--gold-light);
            box-shadow:none;
        }
        .sb-toggle:hover{
            background:rgba(212,176,106,.18);border-color:rgba(232,190,110,.6);color:#fff;
            box-shadow:0 0 18px rgba(232,190,110,.3);
        }
        .hamb{color:var(--gold-light)}

        /* ---- Barres d'indicateurs & panneaux : verre clair sur fond crépuscule ---- */
        .dash-kpi,.ch-kpi,.section-kpi{
            background:linear-gradient(180deg,rgba(255,252,245,.94) 0%,rgba(247,241,229,.92) 100%);
            border-bottom:1px solid rgba(212,176,106,.3);
            box-shadow:0 10px 30px rgba(8,20,51,.10);
        }
        .overlay{background:rgba(8,20,51,.45)}

        /* ---- Cartes analytiques — style crépuscule (fallbacks sans color-mix) ---- */
        .dash-kpi .card,
        .section-kpi .card,
        .ch-kpi .ch-stat-card,.ch-kpi .ch-stat-card:hover,.ch-kpi .ch-stat-card:focus,.ch-kpi .ch-stat-card:active,
        .ech-kpi .ek-card{
            --k:#e2bf72;
            --k-a18:rgba(226,191,114,.18);
            --k-a30:rgba(226,191,114,.30);
            --k-a35:rgba(226,191,114,.35);
            --k-a40:rgba(226,191,114,.40);
            --k-a45:rgba(226,191,114,.45);
            --k-a55:rgba(226,191,114,.55);
            --k-a70:rgba(226,191,114,.70);
            position:relative;overflow:hidden;
            border-radius:16px;color:#fff;
            background:
                radial-gradient(120% 95% at 100% 0%,var(--k-a30) 0%,transparent 58%),
                radial-gradient(90% 70% at 0% 100%,rgba(232,149,90,.12) 0%,transparent 60%),
                linear-gradient(150deg,#0a1839 0%,#12275a 58%,#1d2a5e 100%);
            border:1px solid var(--k-a40);
            box-shadow:0 12px 30px rgba(8,20,51,.22),inset 0 1px 0 rgba(255,255,255,.08);
            animation:none;
        }
        .dash-kpi .card:hover,
        .section-kpi .card:hover,
        .ech-kpi .ek-card:hover{
            border-color:var(--k-a70);
            box-shadow:0 16px 38px rgba(8,20,51,.3),0 0 26px var(--k-a35),inset 0 1px 0 rgba(255,255,255,.1);
        }
        .dash-kpi .card::before{display:none}

        .dash-kpi .card.kpi-chambres{--k:#6ea4ff;--k-a18:rgba(110,164,255,.18);--k-a30:rgba(110,164,255,.30);--k-a35:rgba(110,164,255,.35);--k-a40:rgba(110,164,255,.40);--k-a45:rgba(110,164,255,.45);--k-a55:rgba(110,164,255,.55);--k-a70:rgba(110,164,255,.70)}
        .dash-kpi .card.kpi-occupees{--k:#4fd08a;--k-a18:rgba(79,208,138,.18);--k-a30:rgba(79,208,138,.30);--k-a35:rgba(79,208,138,.35);--k-a40:rgba(79,208,138,.40);--k-a45:rgba(79,208,138,.45);--k-a55:rgba(79,208,138,.55);--k-a70:rgba(79,208,138,.70)}
        .dash-kpi .card.kpi-charges{--k:#ff7b7b;--k-a18:rgba(255,123,123,.18);--k-a30:rgba(255,123,123,.30);--k-a35:rgba(255,123,123,.35);--k-a40:rgba(255,123,123,.40);--k-a45:rgba(255,123,123,.45);--k-a55:rgba(255,123,123,.55);--k-a70:rgba(255,123,123,.70)}
        .dash-kpi .card.kpi-soldedu{--k:#b48cff;--k-a18:rgba(180,140,255,.18);--k-a30:rgba(180,140,255,.30);--k-a35:rgba(180,140,255,.35);--k-a40:rgba(180,140,255,.40);--k-a45:rgba(180,140,255,.45);--k-a55:rgba(180,140,255,.55);--k-a70:rgba(180,140,255,.70)}
        .dash-kpi .card.kpi-caisse{--k:#f0c66e;--k-a18:rgba(240,198,110,.18);--k-a30:rgba(240,198,110,.30);--k-a35:rgba(240,198,110,.35);--k-a40:rgba(240,198,110,.40);--k-a45:rgba(240,198,110,.45);--k-a55:rgba(240,198,110,.55);--k-a70:rgba(240,198,110,.70)}
        .section-kpi .card:nth-child(4n+1){--k:#f0c66e;--k-a18:rgba(240,198,110,.18);--k-a30:rgba(240,198,110,.30);--k-a35:rgba(240,198,110,.35);--k-a40:rgba(240,198,110,.40);--k-a45:rgba(240,198,110,.45);--k-a55:rgba(240,198,110,.55);--k-a70:rgba(240,198,110,.70)}
        .section-kpi .card:nth-child(4n+2){--k:#4fd08a;--k-a18:rgba(79,208,138,.18);--k-a30:rgba(79,208,138,.30);--k-a35:rgba(79,208,138,.35);--k-a40:rgba(79,208,138,.40);--k-a45:rgba(79,208,138,.45);--k-a55:rgba(79,208,138,.55);--k-a70:rgba(79,208,138,.70)}
        .section-kpi .card:nth-child(4n+3){--k:#6ea4ff;--k-a18:rgba(110,164,255,.18);--k-a30:rgba(110,164,255,.30);--k-a35:rgba(110,164,255,.35);--k-a40:rgba(110,164,255,.40);--k-a45:rgba(110,164,255,.45);--k-a55:rgba(110,164,255,.55);--k-a70:rgba(110,164,255,.70)}
        .section-kpi .card:nth-child(4n+4){--k:#ff7b7b;--k-a18:rgba(255,123,123,.18);--k-a30:rgba(255,123,123,.30);--k-a35:rgba(255,123,123,.35);--k-a40:rgba(255,123,123,.40);--k-a45:rgba(255,123,123,.45);--k-a55:rgba(255,123,123,.55);--k-a70:rgba(255,123,123,.70)}
        .ch-kpi .ch-stat-card.st-total,.ech-kpi .ek-card.ek-total{--k:#f0c66e;--k-a18:rgba(240,198,110,.18);--k-a30:rgba(240,198,110,.30);--k-a35:rgba(240,198,110,.35);--k-a40:rgba(240,198,110,.40);--k-a45:rgba(240,198,110,.45);--k-a55:rgba(240,198,110,.55);--k-a70:rgba(240,198,110,.70)}
        .ch-kpi .ch-stat-card.st-dispo,.ech-kpi .ek-card.ek-dispo{--k:#f5d04a;--k-a18:rgba(245,208,74,.18);--k-a30:rgba(245,208,74,.30);--k-a35:rgba(245,208,74,.35);--k-a40:rgba(245,208,74,.40);--k-a45:rgba(245,208,74,.45);--k-a55:rgba(245,208,74,.55);--k-a70:rgba(245,208,74,.70)}
        .ch-kpi .ch-stat-card.st-occu,.ech-kpi .ek-card.ek-occu{--k:#4fd08a;--k-a18:rgba(79,208,138,.18);--k-a30:rgba(79,208,138,.30);--k-a35:rgba(79,208,138,.35);--k-a40:rgba(79,208,138,.40);--k-a45:rgba(79,208,138,.45);--k-a55:rgba(79,208,138,.55);--k-a70:rgba(79,208,138,.70)}
        .ch-kpi .ch-stat-card.st-resa,.ech-kpi .ek-card.ek-resa{--k:#6ea4ff;--k-a18:rgba(110,164,255,.18);--k-a30:rgba(110,164,255,.30);--k-a35:rgba(110,164,255,.35);--k-a40:rgba(110,164,255,.40);--k-a45:rgba(110,164,255,.45);--k-a55:rgba(110,164,255,.55);--k-a70:rgba(110,164,255,.70)}
        .ch-kpi .ch-stat-card.st-nett,.ech-kpi .ek-card.ek-nett{--k:#aab3c5;--k-a18:rgba(170,179,197,.18);--k-a30:rgba(170,179,197,.30);--k-a35:rgba(170,179,197,.35);--k-a40:rgba(170,179,197,.40);--k-a45:rgba(170,179,197,.45);--k-a55:rgba(170,179,197,.55);--k-a70:rgba(170,179,197,.70)}
        .ch-kpi .ch-stat-card.st-maint,.ech-kpi .ek-card.ek-maint{--k:#ff7b7b;--k-a18:rgba(255,123,123,.18);--k-a30:rgba(255,123,123,.30);--k-a35:rgba(255,123,123,.35);--k-a40:rgba(255,123,123,.40);--k-a45:rgba(255,123,123,.45);--k-a55:rgba(255,123,123,.55);--k-a70:rgba(255,123,123,.70)}

        /* ligne d'accent lumineuse en bas */
        .dash-kpi .card .kpi-accent,
        .ech-kpi .ek-accent{
            left:18px;right:18px;top:auto;bottom:0;width:auto;height:3px;border-radius:3px 3px 0 0;
            background:linear-gradient(90deg,transparent,var(--k),transparent);
            box-shadow:0 0 14px var(--k);
        }
        .section-kpi .card::after,
        .ch-kpi .ch-stat-card::after{
            content:'';position:absolute;left:18px;right:18px;bottom:0;height:3px;border-radius:3px 3px 0 0;
            background:linear-gradient(90deg,transparent,var(--k),transparent);
            box-shadow:0 0 14px var(--k);pointer-events:none;
        }

        /* icônes */
        .dash-kpi .kpi-icon-wrap,
        .ch-kpi .ch-stat-ico{
            border-radius:12px;color:var(--k);
            background:var(--k-a18);
            border:1px solid var(--k-a45);
            box-shadow:0 0 18px var(--k-a35),inset 0 1px 0 rgba(255,255,255,.12);
        }
        .dash-kpi .card:hover .kpi-icon-wrap{
            color:#fff;background:var(--k-a55);
            border-color:var(--k);
        }

        /* libellés & valeurs */
        .dash-kpi .card .l,
        .section-kpi .card .l,
        .ech-kpi .ek-lbl{
            color:rgba(236,230,214,.72);letter-spacing:1.8px;font-weight:600;
        }
        .dash-kpi .card .n,
        .dash-kpi .card .n.money .amt,
        .section-kpi .card .n,
        .ech-kpi .ek-val,
        .ech-kpi .ek-card.ek-dispo .ek-val,.ech-kpi .ek-card.ek-occu .ek-val,.ech-kpi .ek-card.ek-resa .ek-val{
            color:#fff;
            text-shadow:0 0 18px var(--k-a55);
        }
        .dash-kpi .card .n{font-size:clamp(26px,2.1vw,32px)}
        .dash-kpi .card .n.money .amt{font-size:clamp(24px,1.9vw,30px)}
        .dash-kpi .card .n.money .unit{color:var(--k);opacity:.95}
        .section-kpi .card{padding:18px 20px 20px}
        .section-kpi .card .n{font-size:30px;font-weight:700}
        .section-kpi .card .l{font-size:10px;margin-top:8px}

        .ch-kpi .ch-stat-body b{color:#fff;text-shadow:0 0 16px var(--k-a55)}
        .ch-kpi .ch-stat-body span{color:rgba(236,230,214,.78);font-weight:600;letter-spacing:.4px}
        .ch-kpi .ch-stat-body small{color:var(--k);font-weight:600;opacity:.9}

        /* barres fixes : fond verre crème qui fait ressortir les cartes */
        .dash-kpi,.ch-kpi,.section-kpi{
            background:linear-gradient(180deg,rgba(250,246,237,.95) 0%,rgba(244,237,223,.92) 100%);
        }

        /* ---- Tableau de bord : chambres en photos (4 par ligne) ---- */
        #dashboard{max-width:100%}
        .dash-rooms{width:100%}
        .dr-head{
            display:flex;align-items:center;gap:10px;flex-wrap:nowrap;
            margin:0 0 14px;padding:0 0 10px;
            border-bottom:1px solid rgba(212,176,106,.22);
        }
        .dr-eyebrow{font-size:10px;letter-spacing:3px;text-transform:uppercase;color:var(--gold);font-weight:600}
        #dashboard .dr-title{
            font-family:'Cormorant Garamond',serif;font-size:22px;font-weight:600;color:var(--text-dark);
            letter-spacing:.5px;line-height:1;margin:0;text-align:left;
            flex:0 0 auto;white-space:nowrap;
        }
        #dashboard.panel.active{padding-top:0;margin-top:0}
        #dashboard .dr-head{
            display:grid;grid-template-columns:minmax(0,1fr) auto minmax(0,1fr);
            align-items:center;gap:12px;
        }
        #dashboard .dr-head > .dr-title{justify-self:start;grid-column:1}
        #dashboard .dr-head > .dr-filter-bar{justify-self:center;grid-column:2;max-width:100%}
        #dashboard .dr-head > .dr-tools{justify-self:end;grid-column:3}
        .dr-chips{display:flex;flex-wrap:wrap;gap:8px;align-items:center}
        .dr-filter-bar{
            display:flex;align-items:center;justify-content:center;gap:6px;
            flex:0 1 auto;min-width:0;width:max-content;max-width:100%;
            margin:0;padding:0;border:0;background:transparent;box-shadow:none;
        }
        .dr-filter-bar.is-collapsed{flex:0 0 auto;width:auto}
        .dr-filters{
            display:flex;align-items:center;justify-content:center;gap:5px;flex-wrap:nowrap;
            flex:0 1 auto;min-width:0;margin:0;padding:0;border:0;background:transparent;box-shadow:none;
            overflow-x:auto;-webkit-overflow-scrolling:touch;
        }
        .dr-filters.is-hidden{display:none}
        .dr-filters::-webkit-scrollbar{height:3px}
        .dr-filters::-webkit-scrollbar-thumb{background:rgba(212,176,106,.35);border-radius:4px}
        .dr-sep{
            flex:0 0 auto;width:1px;height:18px;align-self:center;
            background:rgba(212,176,106,.35);
        }
        .dr-chip,.dr-floor-opt,.dr-cat{
            display:inline-flex;align-items:center;justify-content:center;gap:5px;cursor:pointer;
            flex:0 0 auto;min-width:max-content;white-space:nowrap;
            padding:5px 10px;border-radius:999px;font:600 10px 'Montserrat',sans-serif;letter-spacing:.3px;
            color:var(--text-dark);background:#fff;border:1px solid rgba(212,176,106,.28);
            transition:border-color .2s ease,background .2s ease,color .2s ease,box-shadow .2s ease;
        }
        .dr-chip b,.dr-floor-opt b,.dr-cat b{
            min-width:18px;padding:1px 5px;border-radius:20px;font-size:9px;text-align:center;
            background:rgba(212,176,106,.16);color:#8a6a2c;
        }
        .dr-chip:hover,.dr-floor-opt:hover,.dr-cat:hover{border-color:var(--gold);box-shadow:0 4px 12px rgba(212,176,106,.18)}
        .dr-chip.is-on,.dr-floor-opt.is-on,.dr-cat.is-on{
            background:linear-gradient(135deg,var(--tw-navy),var(--tw-indigo));color:#fff;border-color:transparent;
            box-shadow:0 4px 12px rgba(8,20,51,.18);
        }
        .dr-chip.is-on b,.dr-floor-opt.is-on b,.dr-cat.is-on b{background:rgba(240,207,133,.25);color:#f3d38a}
        .dr-reset{
            display:inline-flex;align-items:center;justify-content:center;cursor:pointer;
            flex:0 0 auto;width:30px;height:30px;padding:0;border-radius:10px;
            color:#8a6a2c;background:#fff;border:1px solid rgba(212,176,106,.35);
            transition:border-color .2s ease,background .2s ease,color .2s ease,box-shadow .2s ease;
        }
        .dr-reset svg{width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
        .dr-reset:hover{border-color:var(--gold);color:var(--tw-navy);box-shadow:0 4px 12px rgba(212,176,106,.18)}
        .dr-reset:disabled{opacity:.35;cursor:default;box-shadow:none}

        .dr-grid{display:grid;grid-template-columns:repeat(5,minmax(0,1fr));gap:14px;align-items:stretch}
        @media(max-width:1400px){.dr-grid{grid-template-columns:repeat(4,minmax(0,1fr))}}
        @media(max-width:1100px){.dr-grid{grid-template-columns:repeat(3,minmax(0,1fr))}}
        @media(max-width:760px){.dr-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}
        @media(max-width:480px){.dr-grid{grid-template-columns:1fr}}
        .dr-empty{grid-column:1/-1;text-align:center;color:var(--muted);padding:40px 0}
        .dr-floor-label{
            grid-column:1/-1;margin:2px 0 0;padding:2px 2px 0;
            font:700 10px 'Montserrat',sans-serif;letter-spacing:1.2px;text-transform:uppercase;color:var(--gold);
        }
        .dr-floor-label:first-child{margin-top:0}

        .dr-card{
            --st:#d4b06a;
            background:#fff;border-radius:16px;overflow:hidden;cursor:pointer;
            border:1px solid rgba(212,176,106,.2);
            box-shadow:0 6px 22px rgba(8,20,51,.07);
            transition:transform .28s ease,box-shadow .28s ease,border-color .28s ease;
            display:flex;flex-direction:column;height:100%;min-width:0;
        }
        .dr-card:hover{
            border-color:var(--st);
            box-shadow:0 18px 40px rgba(8,20,51,.14),0 0 0 1px var(--st);
        }
        .dr-card.st-disponible{--st:#e0b43a}
        .dr-card.st-occupee{--st:#2fa864}
        .dr-card.st-reservee{--st:#3b7be0}
        .dr-card.st-nettoyage{--st:#8a93a3}
        .dr-card.st-maintenance{--st:#d9534f}
        .dr-img{position:relative;aspect-ratio:4/3;overflow:hidden;background:#e9e5dc}
        .dr-img img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .5s ease}
        .dr-card:hover .dr-img img{transform:scale(1.06)}
        .dr-img::after{
            content:'';position:absolute;inset:0;pointer-events:none;
            background:linear-gradient(180deg,rgba(8,20,51,0) 55%,rgba(8,20,51,.55) 100%);
        }
        .dr-badge{
            position:absolute;top:12px;left:12px;z-index:1;
            padding:5px 11px;border-radius:30px;font:700 10px 'Montserrat',sans-serif;letter-spacing:.8px;
            text-transform:uppercase;color:#fff;background:var(--st);
            box-shadow:0 0 0 2px rgba(255,255,255,.35),0 4px 14px rgba(0,0,0,.25);
        }
        .dr-card.st-disponible .dr-badge{color:#2a1f05}
        .dr-num{
            position:absolute;left:12px;bottom:10px;z-index:1;
            font:700 13px 'Montserrat',sans-serif;letter-spacing:1px;color:#fff;
            text-shadow:0 2px 8px rgba(0,0,0,.5);
        }
        .dr-body{padding:12px 14px 14px;display:flex;flex-direction:column;gap:8px;flex:1;border-top:3px solid var(--st)}
        .dr-body h3{
            font-family:'Cormorant Garamond',serif;font-size:19px;font-weight:600;color:var(--text-dark);
            line-height:1.2;margin:0;
            display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;
            min-height:2.4em;
        }
        .dr-cat-tag{
            font:600 10px 'Montserrat',sans-serif;letter-spacing:.7px;text-transform:uppercase;color:#8a6a2c;
        }
        .dr-foot{display:flex;align-items:center;justify-content:space-between;gap:8px;margin-top:auto}
        .dr-floor{font-size:11px;color:var(--muted);letter-spacing:.4px}
        .dr-price{font-size:14px;font-weight:700;color:var(--tw-navy);white-space:nowrap}
        .dr-price small{font-size:10px;font-weight:500;color:var(--muted)}

        /* ---- Calendrier : affichage seul (pas de clic) ---- */
        .cal-block{padding-top:18px}
        .cal-head{display:flex;align-items:center;justify-content:center;margin:0 0 16px}
        .cal-chips{display:flex;flex-wrap:wrap;gap:8px;justify-content:center}
        .cal-chip{
            display:inline-flex;align-items:center;gap:6px;cursor:pointer;
            padding:6px 12px;border-radius:999px;font:600 11px 'Montserrat',sans-serif;letter-spacing:.3px;
            color:var(--text-dark);background:#fff;border:1px solid rgba(212,176,106,.28);
        }
        .cal-chip b{min-width:18px;padding:1px 6px;border-radius:20px;font-size:10px;text-align:center;background:rgba(212,176,106,.16);color:#8a6a2c}
        .cal-chip.is-on{background:linear-gradient(135deg,var(--tw-navy),var(--tw-indigo));color:#fff;border-color:transparent}
        .cal-chip.is-on b{background:rgba(240,207,133,.25);color:#f3d38a}
        .cal-chip.st-occupee.is-on{background:#2fa864}
        .cal-chip.st-reservee.is-on{background:#3b7be0}
        .cal-grid{display:grid;grid-template-columns:repeat(5,minmax(0,1fr));gap:12px;align-items:stretch}
        @media(max-width:1400px){.cal-grid{grid-template-columns:repeat(4,minmax(0,1fr))}}
        @media(max-width:1100px){.cal-grid{grid-template-columns:repeat(3,minmax(0,1fr))}}
        @media(max-width:760px){.cal-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}
        @media(max-width:480px){.cal-grid{grid-template-columns:1fr}}
        .cal-empty{grid-column:1/-1;text-align:center;color:var(--muted);padding:48px 12px;font-size:14px}
        .cal-card{
            --st:#3b7be0;
            position:relative;border-radius:14px;overflow:hidden;cursor:default;
            border:1px solid rgba(212,176,106,.22);
            box-shadow:0 8px 22px rgba(8,20,51,.09);
            min-width:0;aspect-ratio:3/4;background:#1a1520;
        }
        .cal-card.st-occupee{--st:#2fa864}
        .cal-card.st-reservee{--st:#3b7be0}
        .cal-card::before{
            content:'';position:absolute;left:0;top:0;bottom:0;width:3px;z-index:3;background:var(--st);
        }
        .cal-img{position:absolute;inset:0;pointer-events:none}
        .cal-img img{width:100%;height:100%;object-fit:cover;display:block;filter:saturate(1.05)}
        .cal-img::after{
            content:'';position:absolute;inset:0;
            background:
                linear-gradient(180deg,rgba(8,20,51,.18) 0%,rgba(8,20,51,.1) 30%,rgba(8,20,51,.62) 62%,rgba(8,20,51,.94) 100%);
        }
        .cal-badge{
            position:absolute;top:10px;left:10px;z-index:2;pointer-events:none;
            padding:4px 9px;border-radius:999px;font:700 9px 'Montserrat',sans-serif;letter-spacing:.8px;
            text-transform:uppercase;color:#fff;background:var(--st);
            box-shadow:0 3px 10px rgba(0,0,0,.25);
        }
        .cal-num{
            position:absolute;top:10px;right:10px;z-index:2;pointer-events:none;
            padding:4px 8px;border-radius:8px;
            font:700 10px 'Montserrat',sans-serif;letter-spacing:.6px;color:#fff;
            background:rgba(8,20,51,.45);backdrop-filter:blur(6px);
            border:1px solid rgba(255,255,255,.18);
        }
        .cal-fiche,.dr-fiche{
            position:absolute;z-index:4;pointer-events:auto;cursor:pointer;
            width:32px;height:32px;border-radius:10px;border:1px solid rgba(255,255,255,.28);
            background:rgba(8,20,51,.55);color:#f3d38a;backdrop-filter:blur(8px);
            display:inline-flex;align-items:center;justify-content:center;padding:0;
            box-shadow:0 4px 12px rgba(0,0,0,.25);transition:background .2s,border-color .2s,transform .15s;
        }
        .cal-fiche{bottom:10px;right:10px}
        .dr-fiche{top:10px;right:10px}
        .cal-fiche svg,.dr-fiche svg{width:15px;height:15px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;display:block}
        .cal-fiche:hover,.dr-fiche:hover{background:var(--gold);color:#1a1304;border-color:transparent;transform:translateY(-1px)}
        .cal-fiche .ch-rc-file-n,.dr-fiche .ch-rc-file-n{
            position:absolute;top:-5px;right:-5px;min-width:16px;height:16px;padding:0 4px;
            border-radius:999px;background:#c05050;color:#fff;font:700 9px 'Montserrat',sans-serif;
            display:inline-flex;align-items:center;justify-content:center;
        }
        .cal-body{
            position:absolute;left:0;right:0;bottom:0;z-index:2;pointer-events:none;
            padding:12px 12px 44px;display:flex;flex-direction:column;gap:7px;
            color:#fff;
        }
        .cal-body h3{
            font-family:'Cormorant Garamond',serif;font-size:17px;font-weight:600;color:#fff;
            line-height:1.15;margin:0;text-shadow:0 2px 10px rgba(0,0,0,.35);
            display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;
        }
        .cal-meta{
            display:grid;grid-template-columns:1fr 1fr;gap:5px 8px;
            padding:7px 0 0;border-top:1px solid rgba(240,207,133,.28);
        }
        .cal-meta div{min-width:0}
        .cal-meta span{
            display:block;font:700 8px 'Montserrat',sans-serif;letter-spacing:.7px;
            text-transform:uppercase;color:rgba(240,207,133,.9);margin-bottom:2px;
        }
        .cal-meta b{display:block;font-size:11px;font-weight:600;color:#fff;line-height:1.2;word-break:break-word}
        .cal-meta .cal-price{grid-column:1/-1}
        .cal-meta .cal-price b{font-size:12px;color:#f3d38a}
        .cal-meta .cal-price small{font-size:9px;font-weight:500;color:rgba(255,255,255,.65)}
        .cal-dates{
            display:grid;grid-template-columns:1fr 1fr;gap:6px;
            padding:7px;border-radius:10px;
            background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.12);
        }
        .cal-dates span{
            display:block;font:700 8px 'Montserrat',sans-serif;letter-spacing:.7px;
            text-transform:uppercase;color:rgba(240,207,133,.85);margin-bottom:2px;
        }
        .cal-dates b{display:block;font-size:11px;font-weight:700;color:#fff;letter-spacing:.2px}

        /* ---- Tableau de bord : afficher/masquer + analyses ---- */
        .dr-tools{display:flex;flex-direction:row;align-items:center;justify-content:flex-end;gap:10px;flex:0 0 auto}
        .dr-toggle{
            display:inline-flex;align-items:center;justify-content:center;cursor:pointer;
            width:40px;height:40px;padding:0;border-radius:12px;flex:0 0 auto;position:relative;
            color:#f3d38a;background:linear-gradient(135deg,var(--tw-navy),var(--tw-indigo));
            border:1px solid rgba(240,207,133,.45);box-shadow:0 6px 18px rgba(8,20,51,.2);
            transition:box-shadow .2s ease,border-color .2s ease,transform .15s ease,background .2s ease,color .2s ease;
        }
        .dr-toggle:hover{border-color:#f0cf85;box-shadow:0 8px 22px rgba(8,20,51,.3),0 0 16px rgba(240,207,133,.3)}
        .dr-toggle[aria-pressed="true"]{background:linear-gradient(135deg,#1a2a52,#2a3f78)}
        .dr-toggle svg{width:18px;height:18px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
        .dr-toggle-filt{
            flex:0 0 auto;width:30px;height:30px;border-radius:10px;
            color:#f3d38a;background:linear-gradient(135deg,var(--tw-navy),var(--tw-indigo));
            border:1px solid rgba(240,207,133,.45);box-shadow:0 4px 12px rgba(8,20,51,.16);
        }
        .dr-toggle-filt:hover{border-color:#f0cf85;box-shadow:0 6px 14px rgba(8,20,51,.22)}
        .dr-toggle-filt[aria-pressed="true"]{
            color:#8a6a2c;background:#fff;border-color:rgba(212,176,106,.45);
            box-shadow:0 2px 8px rgba(212,176,106,.12);
        }
        .dr-toggle-filt.has-active::after{
            content:'';position:absolute;top:5px;right:5px;width:6px;height:6px;border-radius:50%;
            background:var(--gold);box-shadow:0 0 0 2px #fff;
        }
        .dr-toggle-filt[aria-pressed="true"].has-active::after{box-shadow:0 0 0 2px #1a2a52}
        .dr-toggle-filt svg{width:14px;height:14px}
        .dr-tools .dr-toggle{width:34px;height:34px;border-radius:10px}
        .dr-tools .dr-toggle svg{width:16px;height:16px}
        @media(max-width:1100px){
            #dashboard .dr-head{
                grid-template-columns:1fr auto;grid-template-rows:auto auto;gap:8px 10px;
            }
            #dashboard .dr-head > .dr-title{grid-column:1;grid-row:1}
            #dashboard .dr-head > .dr-tools{grid-column:2;grid-row:1}
            #dashboard .dr-head > .dr-filter-bar{
                grid-column:1/-1;grid-row:2;justify-self:center;width:100%;
            }
            #dashboard .dr-filters{justify-content:center;width:100%}
        }

        .dash-analytics{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:20px}
        @media(max-width:1100px){.dash-analytics{grid-template-columns:minmax(0,1fr)}}
        .da-card{
            background:#fff;border:1px solid rgba(212,176,106,.22);border-radius:16px;
            box-shadow:0 6px 22px rgba(8,20,51,.07);padding:18px 20px 16px;min-width:0;
        }
        .da-head{display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;margin-bottom:12px}
        #dashboard .da-head h3{
            font-family:'Cormorant Garamond',serif;font-size:22px;font-weight:600;color:var(--text-dark);
            margin:0;text-align:left;
        }
        .da-tabs{display:inline-flex;gap:2px;padding:3px;border-radius:30px;background:rgba(13,31,74,.06)}
        .da-tab{
            border:0;background:transparent;cursor:pointer;padding:6px 14px;border-radius:30px;
            font:600 11px 'Montserrat',sans-serif;color:var(--muted);transition:background .2s ease,color .2s ease;
        }
        .da-tab:hover{color:var(--text-dark)}
        .da-tab.is-on{background:linear-gradient(135deg,var(--tw-navy),var(--tw-indigo));color:#f3d38a}
        .da-legend{display:flex;flex-wrap:wrap;gap:16px;margin-bottom:6px;font:500 11px 'Montserrat',sans-serif;color:var(--muted)}
        .da-legend i{display:inline-block;width:10px;height:10px;border-radius:3px;margin-right:6px;vertical-align:-1px}
        .da-legend i.line{width:16px;height:3px;border-radius:2px;vertical-align:3px}
        .da-chart svg{display:block;width:100%;height:auto}
        .da-chart .da-grid{stroke:rgba(13,31,74,.08);stroke-width:1}
        .da-chart .da-ax{font:500 11px 'Montserrat',sans-serif;fill:#8a8f9c}
        .da-chart .da-ax-r{fill:#3b7be0}
        .da-note{font-size:11px;color:var(--muted);margin:8px 0 0}
        .da-table-wrap{overflow-x:auto}
        #dashboard .da-table{width:100%;border-collapse:collapse;margin:0}
        #dashboard .da-table th{
            padding:10px 8px;background:var(--tw-navy);color:#f3d38a;
            font:600 10px 'Montserrat',sans-serif;letter-spacing:1px;text-transform:uppercase;text-align:center;
        }
        #dashboard .da-table th:first-child{border-radius:10px 0 0 10px}
        #dashboard .da-table th:last-child{border-radius:0 10px 10px 0}
        #dashboard .da-table td{
            padding:11px 8px;border-bottom:1px solid rgba(212,176,106,.18);
            font-size:13px;color:var(--text-dark);text-align:center;white-space:nowrap;
        }
        #dashboard .da-table tbody tr:hover td{background:rgba(212,176,106,.07)}
        #dashboard .da-table td.amt{font-weight:600}
        #dashboard .da-table td.solde.due{color:#c0392b}
        #dashboard .da-table td.solde.ok{color:#2fa864}
        #dashboard .da-table .da-empty td{color:var(--muted);padding:26px 8px;font-style:italic}

        /* ---- Réservations : statut ---- */
        .resa-st{
            display:inline-block;padding:4px 10px;border-radius:20px;font:700 10px 'Montserrat',sans-serif;
            letter-spacing:.6px;text-transform:uppercase;color:#fff;background:#8a93a3;
        }
        .resa-st.st-reservee{background:#3b7be0}
        .resa-st.st-occupee{background:#2fa864}
        .resa-st.st-terminee{background:#aab3c5}
        tr.resa-row:hover td{background:rgba(197,160,89,.06)}

        /* ---- Config Chambres ---- */
        #ch-dispo{max-width:100%}
        #ch-dispo .dr-head{
            display:flex;flex-direction:column;align-items:stretch;gap:12px;
            position:static!important;top:auto!important;z-index:auto!important;
            background:transparent!important;backdrop-filter:none!important;box-shadow:none!important;
            margin:0 0 14px;padding:0 0 12px;
        }
        #ch-dispo .cc-title{
            font-family:'Cormorant Garamond',serif;font-size:28px;font-weight:600;color:var(--text-dark);
            letter-spacing:1px;line-height:1.1;margin:2px 0 4px;text-align:left;
        }
        .cc-sub{font-size:12px;color:var(--muted);margin:0}
        .cc-tools{
            display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px;width:100%;
            position:static!important;top:auto!important;z-index:auto!important;
            background:transparent!important;backdrop-filter:none!important;box-shadow:none!important;
            padding:0!important;margin:0;
        }
        .cc-filters{
            display:flex;flex-wrap:wrap;gap:10px;justify-content:center;align-items:center;width:100%;
        }
        #ch-dispo .dr-chips{
            display:flex;flex-wrap:wrap;gap:8px;align-items:center;justify-content:center;width:100%;
        }
        .cc-filters .cc-select{
            min-width:160px;padding:10px 14px;border-radius:12px;outline:none;cursor:pointer;
            border:1px solid rgba(212,176,106,.35);background:rgba(255,255,255,.95);
            font:600 12px 'Montserrat',sans-serif;color:var(--text-dark);
        }
        .cc-filters .cc-select:focus{border-color:var(--gold);box-shadow:0 0 0 3px rgba(212,176,106,.15)}
        .cc-card{
            --st:#d4b06a;
            display:flex;flex-direction:column;background:#fff;border-radius:14px;overflow:hidden;cursor:pointer;
            border:1px solid rgba(212,176,106,.22);box-shadow:0 6px 22px rgba(8,20,51,.07);
            transition:box-shadow .2s ease,border-color .2s ease;
        }
        .cc-card:hover{border-color:var(--st);box-shadow:0 14px 32px rgba(8,20,51,.14),0 0 0 1px var(--st)}
        .cc-card.st-disponible{--st:#e0b43a}
        .cc-card.st-occupee{--st:#2fa864}
        .cc-card.st-reservee{--st:#3b7be0}
        .cc-card.st-nettoyage{--st:#8a93a3}
        .cc-card.st-maintenance{--st:#d9534f}
        .cc-img{position:relative;aspect-ratio:4/3;background:#e9e5dc;overflow:hidden}
        .cc-img img{width:100%;height:100%;object-fit:cover;display:block}
        .cc-img::after{
            content:'';position:absolute;inset:0;pointer-events:none;
            background:linear-gradient(180deg,rgba(8,20,51,.08) 0%,rgba(8,20,51,.15) 40%,rgba(8,20,51,.72) 100%);
        }
        .cc-img-title{
            position:absolute;left:12px;right:12px;bottom:12px;z-index:1;margin:0;text-align:center;
            font-family:'Cormorant Garamond',serif;font-weight:600;font-size:clamp(15px,1.7vw,20px);
            letter-spacing:.06em;line-height:1.15;color:#fff6d8;
            text-shadow:0 2px 10px rgba(0,0,0,.55),0 0 18px rgba(240,198,110,.35);
        }
        .cc-img-title span{
            display:block;font:600 9px 'Montserrat',sans-serif;letter-spacing:.28em;text-transform:uppercase;
            color:rgba(240,198,110,.95);margin-bottom:4px;text-shadow:0 1px 6px rgba(0,0,0,.45);
        }
        .cc-info{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));border-top:1px solid rgba(212,176,106,.2)}
        .cc-info>div{padding:6px 4px;text-align:center;min-width:0}
        .cc-info>div+div{border-left:1px solid rgba(212,176,106,.18)}
        .cc-info small{display:block;font:600 8.5px 'Montserrat',sans-serif;letter-spacing:.8px;text-transform:uppercase;color:var(--muted)}
        .cc-info b{display:block;font:700 11.5px 'Montserrat',sans-serif;color:var(--tw-navy);white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
        .cc-status{
            padding:6px 8px;text-align:center;font:700 10px 'Montserrat',sans-serif;letter-spacing:1.2px;
            text-transform:uppercase;color:#fff;background:var(--st);
        }
        .cc-card.st-disponible .cc-status{color:#2a1f05}
        @media(max-width:860px){
            .cc-tools{align-items:center;width:100%}
            .cc-filters .cc-select{min-width:0;flex:1 1 140px}
        }

        .cc-form-head{margin-bottom:0}
        .cc-edit-modal{
            width:min(460px,100%);padding:0;overflow:hidden;
            background:#fff;border:1px solid rgba(197,160,89,.28);
            box-shadow:0 28px 70px rgba(8,20,51,.18),0 0 0 1px rgba(255,255,255,.4) inset;
        }
        .cc-edit-hero{
            position:relative;height:148px;overflow:hidden;
            background:linear-gradient(145deg,#0a1839,#1a2a5e);
        }
        .cc-edit-hero img{width:100%;height:100%;object-fit:cover;display:block}
        .cc-edit-hero::after{
            content:'';position:absolute;inset:0;
            background:linear-gradient(180deg,rgba(8,20,51,.25) 0%,rgba(8,20,51,.7) 100%);
        }
        .cc-edit-hero-cap{
            position:absolute;left:22px;right:48px;bottom:16px;z-index:1;color:#fff6d8;
            font-family:'Cormorant Garamond',serif;font-size:22px;font-weight:600;letter-spacing:.04em;
            text-shadow:0 2px 12px rgba(0,0,0,.45);
        }
        .cc-edit-hero-cap small{
            display:block;margin-bottom:4px;font:600 9px 'Montserrat',sans-serif;
            letter-spacing:.28em;text-transform:uppercase;color:rgba(240,198,110,.95);
        }
        .cc-edit-body{padding:22px 24px 24px}
        .cc-edit-kicker{
            margin:0 0 16px;font:600 10px 'Montserrat',sans-serif;letter-spacing:.22em;
            text-transform:uppercase;color:var(--gold);
        }
        .cc-edit-form{display:flex;flex-direction:column;gap:14px}
        .cc-edit-form .field{display:flex;flex-direction:column;gap:7px;margin:0}
        .cc-edit-form .field label{
            margin:0;color:#8a6a2f;font:700 10px 'Montserrat',sans-serif;
            letter-spacing:.16em;text-transform:uppercase;
        }
        .cc-edit-form .field input,
        .cc-edit-form .field select{
            width:100%;padding:12px 14px;border-radius:10px;outline:none;
            border:1px solid rgba(197,160,89,.32);background:#fcfbf8;
            font:500 14px 'Montserrat',sans-serif;color:#1a2332;
            transition:border-color .2s,box-shadow .2s,background .2s;
        }
        .cc-edit-form .field select{cursor:pointer;appearance:none;
            background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath fill='%238a6a2f' d='M1 1l5 5 5-5'/%3E%3C/svg%3E");
            background-repeat:no-repeat;background-position:right 14px center;padding-right:36px;
        }
        .cc-edit-form .field input:focus,
        .cc-edit-form .field select:focus{
            border-color:var(--gold);background:#fff;box-shadow:0 0 0 3px rgba(197,160,89,.14);
        }
        .cc-edit-actions{
            display:flex;gap:10px;margin-top:18px;padding-top:16px;
            border-top:1px solid rgba(197,160,89,.18);
        }
        .cc-edit-actions .btn{flex:1;padding:12px 16px;border-radius:10px;letter-spacing:.08em}
        .cc-edit-actions .btn.gold{box-shadow:0 8px 20px rgba(197,160,89,.28)}
        .cc-edit-actions .btn.ghost{background:#fff;border:1px solid rgba(197,160,89,.4)}
        .cc-edit-status{margin:0 0 16px;padding-bottom:16px;border-bottom:1px solid rgba(197,160,89,.16)}
        .cc-edit-status > label{
            display:block;margin:0 0 10px;color:#8a6a2f;font:700 10px 'Montserrat',sans-serif;
            letter-spacing:.16em;text-transform:uppercase;
        }
        .cc-st-row{display:grid;grid-template-columns:repeat(5,minmax(0,1fr));gap:8px}
        @media(max-width:560px){.cc-st-row{grid-template-columns:repeat(2,minmax(0,1fr))}}
        .cc-st-opt{
            --st:#d4b06a;
            display:flex;align-items:center;justify-content:center;gap:6px;cursor:pointer;
            padding:11px 6px;border-radius:10px;font:700 10px 'Montserrat',sans-serif;
            letter-spacing:.5px;text-transform:uppercase;color:var(--st);
            background:rgba(212,176,106,.08);border:1.5px solid rgba(212,176,106,.35);
            transition:background .2s,color .2s,box-shadow .2s,border-color .2s;
        }
        .cc-st-opt .cc-dot{width:8px;height:8px;border-radius:50%;background:var(--st);flex-shrink:0}
        .cc-st-opt:hover{background:rgba(212,176,106,.16)}
        .cc-st-opt.is-on{color:#fff;background:var(--st);border-color:var(--st);box-shadow:0 6px 16px rgba(8,20,51,.12)}
        .cc-st-opt.is-on .cc-dot{background:#fff}
        .cc-st-opt.st-disponible{--st:#e0b43a}
        .cc-st-opt.st-disponible.is-on{color:#2a1f05}
        .cc-st-opt.st-disponible.is-on .cc-dot{background:#2a1f05}
        .cc-st-opt.st-occupee{--st:#2fa864}
        .cc-st-opt.st-reservee{--st:#3b7be0}
        .cc-st-opt.st-nettoyage{--st:#8a93a3}
        .cc-st-opt.st-maintenance{--st:#d9534f}
        #rmModal.cc-edit-modal{width:min(520px,100%)}
        #rmModal.cc-edit-modal .rm-modal-close{
            top:12px;right:12px;z-index:2;background:rgba(255,255,255,.92);backdrop-filter:blur(6px);
        }

        /* ---- Signature AL JAZEERA HOTEL (sans logo) ---- */
        .aj-mark{display:flex;flex-direction:column;align-items:center;gap:6px;line-height:1;user-select:none;position:relative;z-index:1}
        .aj-name{
            font-family:'Cinzel',serif;font-weight:800;font-size:24px;letter-spacing:3.5px;text-transform:uppercase;
            white-space:nowrap;padding-left:3.5px;
            background:linear-gradient(100deg,#b8862f 0%,#f7e2a6 20%,#d4a94f 38%,#fff6d8 50%,#d4a94f 62%,#f7e2a6 80%,#b8862f 100%);
            background-size:220% 100%;
            -webkit-background-clip:text;background-clip:text;color:transparent;-webkit-text-fill-color:transparent;
            filter:drop-shadow(0 0 10px rgba(240,198,110,.35)) drop-shadow(0 2px 2px rgba(0,0,0,.45));
            animation:ajShine 7s linear infinite;
        }
        @keyframes ajShine{from{background-position:120% 0}to{background-position:-100% 0}}
        .aj-sub{
            display:flex;align-items:center;gap:10px;
            font:600 10px 'Montserrat',sans-serif;letter-spacing:7px;text-transform:uppercase;color:#f3e4b8;
            text-shadow:0 0 10px rgba(240,198,110,.45);
        }
        .aj-sub i{display:block;width:28px;height:1px;background:linear-gradient(90deg,transparent,#e8be6e);box-shadow:0 0 6px rgba(232,190,110,.6)}
        .aj-sub i:first-child{margin-right:7px}
        .aj-sub i:last-child{background:linear-gradient(90deg,#e8be6e,transparent)}
        .aj-stars{font-size:9px;letter-spacing:4px;padding-left:4px;color:#f0c66e;text-shadow:0 0 8px rgba(240,198,110,.75)}

        .sb-brand{justify-content:center;padding:26px 14px 22px;position:relative}
        .sb-brand::before{
            content:'';position:absolute;inset:8px 20px;pointer-events:none;border-radius:50%;
            background:radial-gradient(ellipse at center,rgba(240,198,110,.18),transparent 70%);
        }

        .topbar-brand{gap:16px}
        .aj-mark-top{gap:4px;align-items:center}
        .aj-mark-top .aj-name{font-size:20px;letter-spacing:3px;padding-left:3px}
        .aj-mark-top .aj-sub{font-size:8.5px;letter-spacing:6px}
        .aj-mark-top .aj-sub i{width:20px}
        .aj-mark-top .aj-sub i:first-child{margin-right:6px}
        .tb-sep{
            width:1px;height:34px;flex-shrink:0;
            background:linear-gradient(180deg,transparent,rgba(232,190,110,.7),transparent);
            box-shadow:0 0 8px rgba(232,190,110,.4);
        }
        @media(max-width:600px){.aj-mark-top,.tb-sep{display:none}}
        .topbar-left{flex:1}
        .topbar-brand-text h1{max-width:none}
        .topbar-brand-text h1.is-slogan{
            font-family:'Cormorant Garamond',serif;font-style:italic;font-weight:500;
            font-size:clamp(17px,1.6vw,23px);letter-spacing:.4px;color:#f6efdd;
            text-shadow:0 0 16px rgba(232,190,110,.25);
        }
        .topbar-brand-text h1.is-slogan em{
            font-family:'Cinzel',serif;font-style:normal;font-weight:700;font-size:.9em;letter-spacing:2px;
            background:linear-gradient(100deg,#d4a94f,#fff3cf 50%,#d4a94f);
            -webkit-background-clip:text;background-clip:text;color:transparent;-webkit-text-fill-color:transparent;
        }

        /* ---- Panneau latéral : sections lumineuses ---- */
        .sb-nav{--sec:#f0c66e;--sec-a08:rgba(240,198,110,.08);--sec-a12:rgba(240,198,110,.12);--sec-a14:rgba(240,198,110,.14);--sec-a16:rgba(240,198,110,.16);--sec-a18:rgba(240,198,110,.18);--sec-a20:rgba(240,198,110,.20);--sec-a22:rgba(240,198,110,.22);--sec-a25:rgba(240,198,110,.25);--sec-a26:rgba(240,198,110,.26);--sec-a28:rgba(240,198,110,.28);--sec-a30:rgba(240,198,110,.30);--sec-a32:rgba(240,198,110,.32);--sec-a34:rgba(240,198,110,.34);--sec-a35:rgba(240,198,110,.35);--sec-a40:rgba(240,198,110,.40);--sec-a42:rgba(240,198,110,.42);--sec-a45:rgba(240,198,110,.45);--sec-a50:rgba(240,198,110,.50);--sec-a55:rgba(240,198,110,.55);--sec-a60:rgba(240,198,110,.60);--sec-a65:rgba(240,198,110,.65);--sec-a70:rgba(240,198,110,.70);--sec-a80:rgba(240,198,110,.80);--sec-soft:#f6dba0}
        .sb-nav .sec-pilot{--sec:#f0c66e;--sec-a08:rgba(240,198,110,.08);--sec-a12:rgba(240,198,110,.12);--sec-a14:rgba(240,198,110,.14);--sec-a16:rgba(240,198,110,.16);--sec-a18:rgba(240,198,110,.18);--sec-a20:rgba(240,198,110,.20);--sec-a22:rgba(240,198,110,.22);--sec-a25:rgba(240,198,110,.25);--sec-a26:rgba(240,198,110,.26);--sec-a28:rgba(240,198,110,.28);--sec-a30:rgba(240,198,110,.30);--sec-a32:rgba(240,198,110,.32);--sec-a34:rgba(240,198,110,.34);--sec-a35:rgba(240,198,110,.35);--sec-a40:rgba(240,198,110,.40);--sec-a42:rgba(240,198,110,.42);--sec-a45:rgba(240,198,110,.45);--sec-a50:rgba(240,198,110,.50);--sec-a55:rgba(240,198,110,.55);--sec-a60:rgba(240,198,110,.60);--sec-a65:rgba(240,198,110,.65);--sec-a70:rgba(240,198,110,.70);--sec-a80:rgba(240,198,110,.80);--sec-soft:#f6dba0}
        .sb-nav .sec-admin{--sec:#e7b15a;--sec-a08:rgba(231,177,90,.08);--sec-a12:rgba(231,177,90,.12);--sec-a14:rgba(231,177,90,.14);--sec-a16:rgba(231,177,90,.16);--sec-a18:rgba(231,177,90,.18);--sec-a20:rgba(231,177,90,.20);--sec-a22:rgba(231,177,90,.22);--sec-a25:rgba(231,177,90,.25);--sec-a26:rgba(231,177,90,.26);--sec-a28:rgba(231,177,90,.28);--sec-a30:rgba(231,177,90,.30);--sec-a32:rgba(231,177,90,.32);--sec-a34:rgba(231,177,90,.34);--sec-a35:rgba(231,177,90,.35);--sec-a40:rgba(231,177,90,.40);--sec-a42:rgba(231,177,90,.42);--sec-a45:rgba(231,177,90,.45);--sec-a50:rgba(231,177,90,.50);--sec-a55:rgba(231,177,90,.55);--sec-a60:rgba(231,177,90,.60);--sec-a65:rgba(231,177,90,.65);--sec-a70:rgba(231,177,90,.70);--sec-a80:rgba(231,177,90,.80);--sec-soft:#f0c98a}
        .sb-nav .sec-heberg{--sec:#6ea4ff;--sec-a08:rgba(110,164,255,.08);--sec-a12:rgba(110,164,255,.12);--sec-a14:rgba(110,164,255,.14);--sec-a16:rgba(110,164,255,.16);--sec-a18:rgba(110,164,255,.18);--sec-a20:rgba(110,164,255,.20);--sec-a22:rgba(110,164,255,.22);--sec-a25:rgba(110,164,255,.25);--sec-a26:rgba(110,164,255,.26);--sec-a28:rgba(110,164,255,.28);--sec-a30:rgba(110,164,255,.30);--sec-a32:rgba(110,164,255,.32);--sec-a34:rgba(110,164,255,.34);--sec-a35:rgba(110,164,255,.35);--sec-a40:rgba(110,164,255,.40);--sec-a42:rgba(110,164,255,.42);--sec-a45:rgba(110,164,255,.45);--sec-a50:rgba(110,164,255,.50);--sec-a55:rgba(110,164,255,.55);--sec-a60:rgba(110,164,255,.60);--sec-a65:rgba(110,164,255,.65);--sec-a70:rgba(110,164,255,.70);--sec-a80:rgba(110,164,255,.80);--sec-soft:#a6c6ff}
        .sb-nav .sec-achats{--sec:#4fd08a;--sec-a08:rgba(79,208,138,.08);--sec-a12:rgba(79,208,138,.12);--sec-a14:rgba(79,208,138,.14);--sec-a16:rgba(79,208,138,.16);--sec-a18:rgba(79,208,138,.18);--sec-a20:rgba(79,208,138,.20);--sec-a22:rgba(79,208,138,.22);--sec-a25:rgba(79,208,138,.25);--sec-a26:rgba(79,208,138,.26);--sec-a28:rgba(79,208,138,.28);--sec-a30:rgba(79,208,138,.30);--sec-a32:rgba(79,208,138,.32);--sec-a34:rgba(79,208,138,.34);--sec-a35:rgba(79,208,138,.35);--sec-a40:rgba(79,208,138,.40);--sec-a42:rgba(79,208,138,.42);--sec-a45:rgba(79,208,138,.45);--sec-a50:rgba(79,208,138,.50);--sec-a55:rgba(79,208,138,.55);--sec-a60:rgba(79,208,138,.60);--sec-a65:rgba(79,208,138,.65);--sec-a70:rgba(79,208,138,.70);--sec-a80:rgba(79,208,138,.80);--sec-soft:#8fe0b3}
        .sb-nav .sec-fact{--sec:#b48cff;--sec-a08:rgba(180,140,255,.08);--sec-a12:rgba(180,140,255,.12);--sec-a14:rgba(180,140,255,.14);--sec-a16:rgba(180,140,255,.16);--sec-a18:rgba(180,140,255,.18);--sec-a20:rgba(180,140,255,.20);--sec-a22:rgba(180,140,255,.22);--sec-a25:rgba(180,140,255,.25);--sec-a26:rgba(180,140,255,.26);--sec-a28:rgba(180,140,255,.28);--sec-a30:rgba(180,140,255,.30);--sec-a32:rgba(180,140,255,.32);--sec-a34:rgba(180,140,255,.34);--sec-a35:rgba(180,140,255,.35);--sec-a40:rgba(180,140,255,.40);--sec-a42:rgba(180,140,255,.42);--sec-a45:rgba(180,140,255,.45);--sec-a50:rgba(180,140,255,.50);--sec-a55:rgba(180,140,255,.55);--sec-a60:rgba(180,140,255,.60);--sec-a65:rgba(180,140,255,.65);--sec-a70:rgba(180,140,255,.70);--sec-a80:rgba(180,140,255,.80);--sec-soft:#d0b8ff}
        .sb-nav .sec-pers{--sec:#4fd6d0;--sec-a08:rgba(79,214,208,.08);--sec-a12:rgba(79,214,208,.12);--sec-a14:rgba(79,214,208,.14);--sec-a16:rgba(79,214,208,.16);--sec-a18:rgba(79,214,208,.18);--sec-a20:rgba(79,214,208,.20);--sec-a22:rgba(79,214,208,.22);--sec-a25:rgba(79,214,208,.25);--sec-a26:rgba(79,214,208,.26);--sec-a28:rgba(79,214,208,.28);--sec-a30:rgba(79,214,208,.30);--sec-a32:rgba(79,214,208,.32);--sec-a34:rgba(79,214,208,.34);--sec-a35:rgba(79,214,208,.35);--sec-a40:rgba(79,214,208,.40);--sec-a42:rgba(79,214,208,.42);--sec-a45:rgba(79,214,208,.45);--sec-a50:rgba(79,214,208,.50);--sec-a55:rgba(79,214,208,.55);--sec-a60:rgba(79,214,208,.60);--sec-a65:rgba(79,214,208,.65);--sec-a70:rgba(79,214,208,.70);--sec-a80:rgba(79,214,208,.80);--sec-soft:#8fe5e1}
        .sb-nav .sec-fin{--sec:#ff9f6e;--sec-a08:rgba(255,159,110,.08);--sec-a12:rgba(255,159,110,.12);--sec-a14:rgba(255,159,110,.14);--sec-a16:rgba(255,159,110,.16);--sec-a18:rgba(255,159,110,.18);--sec-a20:rgba(255,159,110,.20);--sec-a22:rgba(255,159,110,.22);--sec-a25:rgba(255,159,110,.25);--sec-a26:rgba(255,159,110,.26);--sec-a28:rgba(255,159,110,.28);--sec-a30:rgba(255,159,110,.30);--sec-a32:rgba(255,159,110,.32);--sec-a34:rgba(255,159,110,.34);--sec-a35:rgba(255,159,110,.35);--sec-a40:rgba(255,159,110,.40);--sec-a42:rgba(255,159,110,.42);--sec-a45:rgba(255,159,110,.45);--sec-a50:rgba(255,159,110,.50);--sec-a55:rgba(255,159,110,.55);--sec-a60:rgba(255,159,110,.60);--sec-a65:rgba(255,159,110,.65);--sec-a70:rgba(255,159,110,.70);--sec-a80:rgba(255,159,110,.80);--sec-soft:#ffc0a0}
        .sb-nav .sec-sys{--sec:#c9d3e6;--sec-a08:rgba(201,211,230,.08);--sec-a12:rgba(201,211,230,.12);--sec-a14:rgba(201,211,230,.14);--sec-a16:rgba(201,211,230,.16);--sec-a18:rgba(201,211,230,.18);--sec-a20:rgba(201,211,230,.20);--sec-a22:rgba(201,211,230,.22);--sec-a25:rgba(201,211,230,.25);--sec-a26:rgba(201,211,230,.26);--sec-a28:rgba(201,211,230,.28);--sec-a30:rgba(201,211,230,.30);--sec-a32:rgba(201,211,230,.32);--sec-a34:rgba(201,211,230,.34);--sec-a35:rgba(201,211,230,.35);--sec-a40:rgba(201,211,230,.40);--sec-a42:rgba(201,211,230,.42);--sec-a45:rgba(201,211,230,.45);--sec-a50:rgba(201,211,230,.50);--sec-a55:rgba(201,211,230,.55);--sec-a60:rgba(201,211,230,.60);--sec-a65:rgba(201,211,230,.65);--sec-a70:rgba(201,211,230,.70);--sec-a80:rgba(201,211,230,.80);--sec-soft:#e2e8f2}

        .sb-nav .sb-section-label{
            color:var(--sec);opacity:1;font-weight:700;letter-spacing:2.6px;
            padding:16px 10px 8px;
            text-shadow:0 0 12px var(--sec-a70);
        }
        .sb-nav .sb-section-label::before{
            width:8px;height:8px;border-radius:50%;background:var(--sec);
            box-shadow:0 0 0 3px var(--sec-a22),0 0 14px var(--sec);
        }
        .sb-nav .sb-section-label::after{
            content:'';flex:1;height:1px;margin-left:4px;
            background:linear-gradient(90deg,var(--sec-a65),transparent);
        }

        .sb-nav .sb-group,
        .sb-nav .sb-section-label{flex-shrink:0}
        .sb-nav .sb-group{
            position:relative;
            background:
                radial-gradient(130% 90% at 0% 0%,var(--sec-a20),transparent 62%),
                linear-gradient(180deg,rgba(255,255,255,.07),rgba(255,255,255,.02));
            border:1px solid var(--sec-a30);
            box-shadow:0 0 18px var(--sec-a12),inset 0 1px 0 rgba(255,255,255,.07);
        }
        .sb-nav .sb-group::before{
            content:'';position:absolute;left:0;top:12px;bottom:12px;width:3px;border-radius:0 3px 3px 0;
            background:linear-gradient(180deg,transparent,var(--sec),transparent);
            box-shadow:0 0 12px var(--sec);opacity:.75;pointer-events:none;
        }
        .sb-nav .sb-group::after{
            content:'';position:absolute;left:14px;right:14px;top:0;height:1px;pointer-events:none;
            background:linear-gradient(90deg,transparent,var(--sec-a80),transparent);
        }
        .sb-nav .sb-group:has(.sb-item.active),
        .sb-nav .sb-group:has(.sb-sub.open){
            border-color:var(--sec-a60);
            box-shadow:0 0 28px var(--sec-a28),0 8px 24px rgba(0,0,0,.25),inset 0 1px 0 rgba(255,255,255,.1);
        }
        .sb-nav .sb-group:has(.sb-item.active)::before,
        .sb-nav .sb-group:has(.sb-sub.open)::before{opacity:1}

        .sb-nav .ic-wrap{
            color:var(--sec);
            background:var(--sec-a14);
            border-color:var(--sec-a42);
            box-shadow:0 0 12px var(--sec-a25);
        }
        .sb-nav .sb-item:hover,.sb-nav .sb-parent:hover{
            background:var(--sec-a12);color:#fff;
            border-color:var(--sec-a32);
        }
        .sb-nav .sb-item:hover .ic-wrap,.sb-nav .sb-parent:hover .ic-wrap{
            color:#fff;background:var(--sec-a32);border-color:var(--sec);
            box-shadow:0 0 18px var(--sec-a55);
        }
        .sb-nav .sb-item.sb-pilot{
            background:linear-gradient(135deg,var(--sec-a16),rgba(255,255,255,.03));
            border-color:var(--sec-a30);
        }

        .sb-nav .sb-item.sb-pilot.active,
        .sb-nav .sb-item.active:not(.sb-pilot):not(.sb-sub .sb-item){
            background:linear-gradient(135deg,var(--sec-soft) 0%,var(--sec) 100%);
            border-color:var(--sec-soft);color:#0b1530;
            box-shadow:0 6px 22px var(--sec-a45),0 0 30px var(--sec-a30),inset 0 1px 0 rgba(255,255,255,.5);
        }
        .sb-nav .sb-item.sb-pilot.active .lbl,
        .sb-nav .sb-item.active:not(.sb-pilot):not(.sb-sub .sb-item) .lbl{color:#0b1530;font-weight:700}
        .sb-nav .sb-item.sb-pilot.active .ic-wrap,
        .sb-nav .sb-item.active:not(.sb-pilot):not(.sb-sub .sb-item) .ic-wrap{
            color:#0b1530;background:rgba(11,21,48,.12);border-color:rgba(11,21,48,.2);box-shadow:none;
        }

        .sb-nav .sb-parent.expanded{
            background:linear-gradient(135deg,var(--sec-a18),rgba(255,255,255,.03));
            border-color:var(--sec-a35);color:#fff;
        }
        .sb-nav .sb-parent.expanded .ic-wrap{color:#fff;background:var(--sec-a34);border-color:var(--sec)}
        .sb-nav .sb-parent .caret{color:var(--sec);border-color:var(--sec-a35)}
        .sb-nav .sb-parent.expanded .caret{background:var(--sec-a25);border-color:var(--sec)}
        .sb-nav .sb-group:has(.sb-item.active) .sb-parent .sb-badge,
        .sb-nav .sb-parent.expanded .sb-badge{
            color:#fff;background:var(--sec-a35);border-color:var(--sec);
        }

        .sb-nav .sb-sub::before{background:linear-gradient(180deg,var(--sec),transparent);box-shadow:0 0 8px var(--sec);opacity:.8}
        .sb-nav .sb-dot{border-color:var(--sec-a70)}
        .sb-nav .sb-sub .sb-item:hover .sb-dot{border-color:var(--sec);background:var(--sec-a45);box-shadow:0 0 8px var(--sec)}
        .sb-nav .sb-sub .sb-item.active{
            background:linear-gradient(135deg,var(--sec-a26),var(--sec-a08));
            color:#fff;border-color:var(--sec-a50);
            box-shadow:0 0 16px var(--sec-a25);
        }
        .sb-nav .sb-sub .sb-item.active .sb-dot{background:var(--sec);border-color:var(--sec);box-shadow:0 0 12px var(--sec)}

        /* ---- Panneau latéral : lisibilité (fond sombre uni, textes contrastés) ---- */
        .sidebar{
            background:linear-gradient(180deg,#07122e 0%,#0a1a42 50%,#0d1f4a 100%);
        }
        .sidebar::before{display:none}
        .sidebar .sb-nav{padding:12px 12px 16px;gap:4px}

        .sidebar .sb-nav .sb-section-label{
            font-size:11px;font-weight:700;letter-spacing:2.2px;
            padding:18px 6px 8px;text-shadow:none;
            color:var(--sec-soft);
        }
        .sidebar .sb-nav .sb-section-label:first-child{padding-top:6px}

        .sidebar .sb-nav .sb-group{
            background:rgba(255,255,255,.045);
            border:1px solid var(--sec-a28);
            box-shadow:none;padding:6px;
        }
        .sidebar .sb-nav .sb-group::after{opacity:.6}

        .sidebar .sb-nav .sb-item,
        .sidebar .sb-nav .sb-parent{color:#f4f1ea}
        .sidebar .sb-nav .sb-item .lbl,
        .sidebar .sb-nav .sb-parent .lbl{color:#f4f1ea;font-size:13.5px;font-weight:500;letter-spacing:.2px}
        .sidebar .sb-nav .sb-parent .lbl{font-weight:600}
        .sidebar .sb-nav .sb-item.sb-pilot .lbl{font-weight:600}

        .sidebar .sb-nav .ic-wrap{
            color:var(--sec);background:var(--sec-a16);
            border-color:var(--sec-a45);box-shadow:none;
        }

        .sidebar .sb-nav .sb-sub{padding:4px 6px 8px 44px}
        .sidebar .sb-nav .sb-sub .sb-item{
            color:#e6e1d4;background:transparent;min-height:36px;
        }
        .sidebar .sb-nav .sb-sub .sb-item .lbl{color:#e6e1d4;font-size:13px;font-weight:500}
        .sidebar .sb-nav .sb-dot{border-color:var(--sec);border-width:2px}
        .sidebar .sb-nav .sb-sub::before{opacity:.9;box-shadow:none}

        .sidebar .sb-nav .sb-item:not(.active):hover,
        .sidebar .sb-nav .sb-parent:hover{background:rgba(255,255,255,.09);border-color:var(--sec-a40)}
        .sidebar .sb-nav .sb-item:not(.active):hover .lbl,
        .sidebar .sb-nav .sb-parent:hover .lbl{color:#fff}

        .sidebar .sb-nav .sb-parent .sb-badge{color:#f4f1ea;background:rgba(255,255,255,.1);border-color:rgba(255,255,255,.18)}
        .sidebar .sb-nav .sb-parent .caret{color:#f4f1ea;background:rgba(255,255,255,.08)}

        .sidebar .sb-nav .sb-sub .sb-item.active{
            background:var(--sec-a25);
            border-color:var(--sec-a60);box-shadow:none;
        }
        .sidebar .sb-nav .sb-sub .sb-item.active .lbl{color:#fff;font-weight:700}

        .sidebar .sb-nav .sb-item.sb-pilot.active .lbl,
        .sidebar .sb-nav .sb-item.active:not(.sb-pilot):not(.sb-sub .sb-item) .lbl{color:#0b1530;font-weight:700}

        /* Fiche utilisateur : champs emploi grisés pour le profil Direction */
        #cfg-users .field.is-off{opacity:.45;transition:opacity .2s}
        #cfg-users .field.is-off input,#cfg-users .field.is-off select{cursor:not-allowed;background:rgba(120,120,120,.12);filter:grayscale(1)}
        .cfg-inline-msg{
            display:none;margin:10px 0 0;padding:10px 12px;border-radius:8px;font-size:13px;line-height:1.35;
            border:1px solid transparent;
        }
        .cfg-inline-msg.is-on{display:block}
        .cfg-inline-msg.is-ok{background:#ecfdf5;border-color:#6ee7b7;color:#065f46}
        .cfg-inline-msg.is-err{background:#fef2f2;border-color:#fca5a5;color:#991b1b}
        .cfg-inline-msg.is-info{background:#fffbeb;border-color:#fcd34d;color:#92400e}
        #cuSaveBtn[disabled]{opacity:.65;cursor:wait;transform:none;box-shadow:none}
        #cuModal.cu-modal{width:min(1080px,100%);max-height:94vh;overflow-y:auto;padding:18px 18px 16px}
        #cuModal .rm-form-head{margin-bottom:10px;padding-right:36px}
        #cuModal .rm-form-head h3{font-size:22px;margin:0 0 2px}
        #cuModal .rm-form-head p{font-size:12px}
        #cuModal .pe-photo-wrap{
            grid-template-columns:150px minmax(0,1fr);gap:12px;margin:0 0 8px;align-items:stretch;
        }
        #cuModal .pe-photo .pe-copy-preview{height:96px;border-radius:8px}
        #cuModal .pe-copy-head{padding:6px 10px;font-size:9px}
        #cuModal .pe-copy-zone{padding:8px;min-height:0}
        #cuModal .pe-copy-name{font-size:10px}
        #cuModal .pe-photo-side .field{margin-bottom:8px}
        #cuModal .pe-photo-side .field label{margin-bottom:4px;font-size:9px}
        #cuModal .pe-photo-side .field input{padding:7px 10px;font-size:12px}
        .cu-sec{margin:8px 0 0;padding:8px 10px 4px;border:1px solid rgba(197,160,89,.2);border-radius:10px;background:rgba(247,245,240,.45)}
        .cu-sec h4{
            margin:0 0 6px;font:700 10px 'Montserrat',sans-serif;letter-spacing:1px;
            text-transform:uppercase;color:#8a6a2c;
        }
        #cuModal .cu-sec .rm-form-grid{gap:8px}
        #cuModal .cu-sec .field{margin-bottom:6px}
        #cuModal .cu-sec .field label{
            margin-bottom:3px;font-size:9px;letter-spacing:.7px;
        }
        #cuModal .cu-sec .field input,
        #cuModal .cu-sec .field select{
            padding:7px 9px;font-size:12px;border-radius:7px;min-height:0;
        }
        .cu-sec .rm-form-grid .field.span2{grid-column:span 2}
        @media(max-width:700px){.cu-sec .rm-form-grid .field.span2{grid-column:auto}}
        .cu-auth-sec{padding:0;overflow:hidden;border:1px solid rgba(197,160,89,.28);border-radius:12px;background:#fff;margin-top:10px}
        .cu-auth-sec .cu-auth-head{
            display:flex;align-items:flex-start;justify-content:space-between;gap:12px;flex-wrap:wrap;
            padding:10px 12px;background:linear-gradient(135deg,#122a58,#0a1736);color:#fff;
        }
        .cu-auth-sec .cu-auth-head h4{margin:0 0 2px;color:#f3e4a8;font:700 11px 'Montserrat',sans-serif;letter-spacing:1.1px;text-transform:uppercase}
        .cu-auth-sec .cu-auth-head .hint{margin:0;color:rgba(255,255,255,.78);font-size:11px;max-width:560px;line-height:1.35}
        .cu-auth-sec .cfg-auth-wrap{
            margin:0;border:0;border-radius:0;
            max-height:min(520px,calc(94vh - 300px));
            min-height:280px;
        }
        #cuModal .rm-form-actions{
            display:flex;flex-wrap:wrap;gap:10px;align-items:center;
            margin:14px 0 0;padding:12px 0 2px;
            border-top:1px solid rgba(197,160,89,.22);
            background:#fff;position:relative;z-index:2;
        }
        #cuModal .rm-form-actions .btn{min-width:120px}
        .cu-list-block{padding:0;overflow:hidden}
        .cu-list-head{
            display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;
            padding:16px 18px;border-bottom:1px solid rgba(197,160,89,.18);
            background:linear-gradient(180deg,rgba(247,245,240,.9),#fff);
        }
        .cu-list-head h3{margin:0;font-size:15px;letter-spacing:.4px}
        .cu-list-head .cu-count{
            font-size:11px;font-weight:700;letter-spacing:.8px;text-transform:uppercase;
            color:#8a6a2c;background:rgba(197,160,89,.12);border:1px solid rgba(197,160,89,.28);
            padding:5px 10px;border-radius:999px;
        }
        .cu-table-wrap{border:0;border-radius:0;overflow:auto}
        .cu-table{width:100%;border-collapse:separate;border-spacing:0;min-width:640px}
        .cu-table thead th{
            position:sticky;top:0;z-index:1;
            background:linear-gradient(180deg,#0f2a5c,#0a1736);color:#f3e4a8;
            font:700 10px 'Montserrat',sans-serif;letter-spacing:1.1px;text-transform:uppercase;
            padding:12px 14px;border:0;text-align:left;white-space:nowrap;
        }
        .cu-table tbody td{
            padding:13px 14px;border-bottom:1px solid rgba(197,160,89,.12);
            font-size:13px;color:var(--text-dark);vertical-align:middle;background:#fff;
        }
        .cu-table tbody tr:hover td{background:#fbf7ef}
        .cu-table tbody tr.is-active td{
            background:linear-gradient(90deg,rgba(197,160,89,.14),rgba(255,255,255,.9));
            box-shadow:inset 3px 0 0 var(--gold);
        }
        .cu-table .cu-date{color:var(--muted);font-variant-numeric:tabular-nums;white-space:nowrap}
        .cu-table .cu-nom{font-weight:700;color:var(--navy-mid)}
        .cu-table .cu-login{
            font-family:'Montserrat',sans-serif;font-size:12px;font-weight:600;letter-spacing:.3px;
            color:#0f2a5c;background:rgba(15,42,92,.06);border:1px solid rgba(15,42,92,.1);
            padding:4px 8px;border-radius:7px;display:inline-block;
        }
        .cu-pill{
            display:inline-flex;align-items:center;gap:6px;
            padding:4px 10px;border-radius:999px;font-size:11px;font-weight:700;
            letter-spacing:.4px;text-transform:uppercase;border:1px solid transparent;white-space:nowrap;
        }
        .cu-pill::before{content:'';width:7px;height:7px;border-radius:50%;background:currentColor;opacity:.9}
        .cu-pill.p-direction{color:#8a6a2c;background:rgba(224,180,58,.16);border-color:rgba(224,180,58,.35)}
        .cu-pill.p-administration{color:#1d4ed8;background:rgba(91,141,239,.14);border-color:rgba(91,141,239,.35)}
        .cu-pill.p-reception{color:#047857;background:rgba(47,168,100,.14);border-color:rgba(47,168,100,.35)}
        .cu-pill.p-commercial{color:#c2410c;background:rgba(224,122,59,.14);border-color:rgba(224,122,59,.35)}
        .cu-pill.p-maintenance,.cu-pill.p-housekeeping{color:#5b21b6;background:rgba(139,124,246,.14);border-color:rgba(139,124,246,.35)}
        .cu-pill.p-restauration{color:#9a3412;background:rgba(234,88,12,.12);border-color:rgba(234,88,12,.3)}
        .cu-pill.p-comptabilite{color:#0f766e;background:rgba(45,212,191,.12);border-color:rgba(20,184,166,.3)}
        .cu-pill.p-technique{color:#0e7490;background:rgba(46,183,201,.14);border-color:rgba(46,183,201,.35)}
        .cu-pill.p-default{color:#475569;background:rgba(100,116,139,.1);border-color:rgba(100,116,139,.25)}
        .cu-actions{display:flex;gap:6px;flex-wrap:wrap}
        .cu-actions .ibtn{
            width:34px;height:34px;border-radius:9px;margin:0;
            display:inline-flex;align-items:center;justify-content:center;
            border:1px solid rgba(197,160,89,.3);background:#fff;color:#8a6a2c;
        }
        .cu-actions .ibtn:hover{background:rgba(197,160,89,.12);border-color:var(--gold);color:var(--navy-mid)}
        .cu-actions .ibtn.auth{color:#1d4ed8;border-color:rgba(91,141,239,.35)}
        .cu-actions .ibtn.auth:hover{background:rgba(91,141,239,.12);color:#1e3a8a}
        .cu-actions .ibtn.del{color:#b45309;border-color:rgba(245,158,11,.35)}
        .cu-actions .ibtn.del:hover{background:rgba(239,68,68,.1);border-color:rgba(239,68,68,.4);color:#b91c1c}
        .cu-auth-block{
            margin-top:16px;border:1px solid rgba(197,160,89,.22);border-radius:14px;overflow:hidden;
            background:#fff;box-shadow:0 10px 28px rgba(10,23,54,.05);
        }
        .cu-auth-block .cu-auth-head{
            display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;
            padding:14px 16px;background:linear-gradient(135deg,#0f2a5c,#0a1736);color:#fff;
        }
        .cu-auth-block .cu-auth-head h3{margin:0;font-size:14px;letter-spacing:.4px;color:#f3e4a8}
        .cu-auth-block .cu-auth-head .hint{margin:0;color:rgba(255,255,255,.75);font-size:12px}
        .cu-auth-block .cfg-auth-wrap{margin:0;border:0;border-radius:0;max-height:420px}
        .cu-auth-block .actions{padding:12px 16px 16px;margin:0;justify-content:flex-end}

        /* Balance Clients — occupe toute la zone de travail */
        .content:has(#adm-balance-clients.active),
        .content:has(#adm-balance-paiement.active){
            align-items:stretch;padding:18px 22px 22px;
        }
        #adm-balance-clients.panel.active,
        #adm-balance-paiement.panel.active{
            display:flex;flex-direction:column;
            width:100%;max-width:none;
            min-height:calc(100vh - var(--topbar-h) - 40px);
        }
        #adm-balance-clients .bc-head{text-align:center;margin-bottom:16px}
        #adm-balance-clients .bc-kicker{
            display:inline-flex;align-items:center;gap:8px;
            font-size:11px;font-weight:700;letter-spacing:2.4px;text-transform:uppercase;color:var(--gold);
        }
        #adm-balance-clients .bc-kicker::before,#adm-balance-clients .bc-kicker::after{
            content:'';width:28px;height:1px;background:linear-gradient(90deg,transparent,var(--gold));
        }
        #adm-balance-clients .bc-kicker::after{background:linear-gradient(90deg,var(--gold),transparent)}
        #adm-balance-clients h2{margin:8px 0 4px}
        .bc-cards{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:18px;margin-bottom:16px;width:100%}
        #adm-balance-paiement .bc-cards{grid-template-columns:repeat(2,minmax(0,1fr))}
        .bc-card{
            position:relative;overflow:hidden;padding:18px 18px 16px 20px;border-radius:16px;
            background:linear-gradient(165deg,#fff 0%,#fbf8f1 100%);
            border:1px solid var(--border-gold);box-shadow:var(--shadow-soft);
        }
        .bc-card::after{
            content:'';position:absolute;right:-20px;top:-24px;width:90px;height:90px;border-radius:50%;
            background:radial-gradient(circle,rgba(197,160,89,.18),transparent 70%);
        }
        .bc-card .bc-accent{position:absolute;left:0;top:14px;bottom:14px;width:3px;border-radius:0 3px 3px 0}
        .bc-card.total .bc-accent{background:linear-gradient(180deg,#f3e4a8,#c5a059)}
        .bc-card.paid .bc-accent{background:linear-gradient(180deg,#b7ebc9,#2a9d5c)}
        .bc-card.due .bc-accent{background:linear-gradient(180deg,#f6c7c7,#c45454)}
        .bc-card .bc-lbl{font-size:11px;font-weight:700;letter-spacing:1.4px;text-transform:uppercase;color:var(--muted)}
        .bc-card .bc-val{font-family:'Cormorant Garamond',serif;font-size:34px;line-height:1.05;color:var(--navy-mid);margin-top:6px}
        .bc-card .bc-val small{font-family:'Montserrat',sans-serif;font-size:12px;letter-spacing:1px;color:var(--gold);margin-left:4px}
        .bc-filters{
            display:grid;grid-template-columns:repeat(3,minmax(0,1fr)) auto;gap:14px;align-items:end;
            width:100%;padding:16px 18px;margin-bottom:16px;border-radius:16px;
            background:#fff;border:1px solid var(--border-gold);box-shadow:var(--shadow-soft);
        }
        .bc-filters label{display:flex;flex-direction:column;gap:6px;font-size:10px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;color:var(--gold)}
        .bc-filters input{
            height:42px;border:1px solid rgba(197,160,89,.35);border-radius:10px;padding:0 12px;
            font-family:inherit;font-size:14px;color:var(--text-dark);background:#fff;
        }
        .bc-filters input:focus{outline:none;border-color:var(--gold);box-shadow:0 0 0 3px rgba(197,160,89,.15)}
        .bc-reset{
            height:42px;padding:0 16px;border-radius:10px;cursor:pointer;
            border:1px solid rgba(197,160,89,.4);background:#fff;color:var(--navy-mid);
            font-weight:600;font-size:12px;letter-spacing:.4px;
        }
        .bc-reset:hover{background:rgba(197,160,89,.1)}
        .bc-table-card{
            flex:1;display:flex;flex-direction:column;
            width:100%;min-height:280px;margin-bottom:0;padding:0;overflow:hidden;
        }
        #adm-balance-clients .table-wrap,
        #adm-balance-paiement .table-wrap{
            flex:1;width:100%;min-height:0;border-radius:16px;
        }
        #adm-balance-clients table,
        #adm-balance-paiement table{width:100%;height:100%;table-layout:fixed}
        #adm-balance-clients th:last-child,#adm-balance-clients td:last-child,
        #adm-balance-paiement th:last-child,#adm-balance-paiement td:last-child{width:176px}
        #adm-balance-clients td,#adm-balance-clients th,
        #adm-balance-paiement td,#adm-balance-paiement th{padding:16px 10px}
        #adm-balance-clients table:has(.empty-row),
        #adm-balance-paiement table:has(.empty-row){height:100%}
        #adm-balance-clients .empty-row td,
        #adm-balance-paiement .empty-row td{height:100%;vertical-align:middle}
        .bp-filters{grid-template-columns:repeat(5,minmax(0,1fr)) auto}
        /* ===== C-Occupées — layout page (scopé, sans sticky) ===== */
        #ch-occupees.panel > h2.serif{
            text-align:left;margin:0 0 12px;padding:0;
            font-size:28px;letter-spacing:.4px;line-height:1.15;color:var(--navy-mid);
        }
        #ch-occupees .occ-filters{
            display:grid;
            grid-template-columns:repeat(5,minmax(140px,1fr)) auto;
            gap:12px;align-items:end;
            position:static !important;top:auto !important;z-index:auto !important;
            width:100%;margin:0 0 28px;padding:14px 16px;
            background:#fff !important;
            border:1px solid var(--border-gold);
            border-radius:14px;
            box-shadow:0 8px 22px rgba(8,20,51,.08);
            backdrop-filter:none !important;
        }
        #ch-occupees .occ-filters label{
            display:flex;flex-direction:column;gap:6px;min-width:0;
            font-size:10px;font-weight:700;letter-spacing:1.2px;
            text-transform:uppercase;color:var(--gold);
        }
        #ch-occupees .occ-filters input,
        #ch-occupees .occ-filters select{
            height:42px;width:100%;box-sizing:border-box;
            border:1px solid rgba(197,160,89,.35);border-radius:10px;padding:0 12px;
            font-family:inherit;font-size:14px;color:var(--text-dark);background:#fff;
        }
        #ch-occupees .occ-filters input:focus,
        #ch-occupees .occ-filters select:focus{
            outline:none;border-color:var(--gold);box-shadow:0 0 0 3px rgba(197,160,89,.15);
        }
        #ch-occupees .occ-filters .bc-reset{flex-shrink:0;white-space:nowrap}
        @media(max-width:1200px){
            #ch-occupees .occ-filters{grid-template-columns:repeat(3,minmax(140px,1fr)) auto}
        }
        @media(max-width:800px){
            #ch-occupees .occ-filters{grid-template-columns:repeat(2,minmax(0,1fr))}
            #ch-occupees .occ-filters .bc-reset{grid-column:1 / -1;width:100%}
        }
        @media(max-width:560px){
            #ch-occupees .occ-filters{grid-template-columns:1fr}
        }
        #ch-occupees .occ-table-panel{
            display:block;width:100%;margin:0 0 22px;padding:0;
            background:#fff;border:1px solid rgba(197,160,89,.4);
            border-radius:16px;box-shadow:var(--shadow-soft);
            overflow-x:auto;overflow-y:visible;
        }
        #ch-occupees .occ-table-panel .table-wrap{
            width:100%;margin:0;padding:0;
            overflow:visible !important;
            border:none;border-radius:0;background:transparent;box-shadow:none;
        }
        #ch-occupees table.occ-table{
            width:100%;min-width:1180px;height:auto;
            table-layout:fixed;border-collapse:collapse !important;border-spacing:0;
        }
        #ch-occupees table.occ-table thead{
            display:table-header-group !important;
            visibility:visible !important;
            opacity:1 !important;
        }
        #ch-occupees.panel table.occ-table thead th,
        #ch-occupees .table-wrap table.occ-table thead th,
        #ch-occupees.panel table thead th{
            display:table-cell !important;
            visibility:visible !important;
            opacity:1 !important;
            position:static !important;top:auto !important;left:auto !important;z-index:auto !important;
            white-space:nowrap;padding:14px 10px;height:auto !important;min-height:48px;
            max-height:none !important;line-height:1.3;
            font-family:'Montserrat',sans-serif;font-size:10.5px;font-weight:700;
            letter-spacing:1.1px;text-transform:uppercase;text-align:center;
            color:#f3e6c4 !important;
            background:#0a1736 !important;
            border-bottom:2px solid var(--gold) !important;
            border-right:1px solid rgba(243,230,196,.14);
            box-shadow:none !important;transform:none !important;
        }
        #ch-occupees.panel table.occ-table thead th:last-child{border-right:none}
        #ch-occupees table.occ-table td{
            white-space:nowrap;padding:13px 10px;font-size:12.5px;vertical-align:middle;
            border-bottom:1px solid rgba(10,23,54,.06);
            border-right:1px solid rgba(10,23,54,.035);
            background:#fff;
            position:static !important;
        }
        #ch-occupees table.occ-table td:last-child{border-right:none}
        #ch-occupees table.occ-table tbody tr:last-child td{border-bottom:none}
        #ch-occupees table.occ-table tbody tr:hover td{background:rgba(197,160,89,.05)}
        #ch-occupees table.occ-table th:last-child,
        #ch-occupees table.occ-table td:last-child{width:132px}
        #adm-balance-clients th{white-space:nowrap}
        .bc-money{font-variant-numeric:tabular-nums;font-weight:600}
        .bc-solde.ok{color:#1f8a4c}
        .bc-solde.due{color:#b45309}
        .bc-type{
            display:inline-block;padding:3px 10px;border-radius:999px;font-size:11px;font-weight:600;
            background:rgba(197,160,89,.12);color:#8a6a2f;
        }
        .bc-type.empty{background:rgba(107,114,128,.1);color:var(--muted);font-weight:500}
        .bc-actions{display:flex;justify-content:center;gap:6px}
        .bc-ico{
            width:32px;height:32px;border-radius:9px;border:1px solid rgba(197,160,89,.35);
            background:#fff;color:var(--navy-mid);cursor:pointer;
            display:inline-flex;align-items:center;justify-content:center;
        }
        .bc-ico svg{width:15px;height:15px;stroke:currentColor;fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round}
        .bc-ico:hover{background:var(--navy-mid);color:#f6efdd;border-color:var(--navy-mid)}
        .bc-ico.danger:hover{background:#9b2c2c;border-color:#9b2c2c;color:#fff}
        .bc-modal{
            position:fixed;inset:0;z-index:80;display:none;align-items:center;justify-content:center;
            background:rgba(6,15,36,.45);padding:20px;
        }
        .bc-modal.show{display:flex}
        .bc-dialog{
            width:min(560px,100%);background:#fff;border-radius:18px;padding:22px 22px 18px;
            border:1px solid var(--border-gold);box-shadow:0 24px 60px rgba(6,15,36,.25);
        }
        .bc-dialog h3{font-family:'Cormorant Garamond',serif;font-size:28px;text-align:center;color:var(--navy-mid)}
        .bc-dialog .bc-sub{text-align:center;color:var(--muted);font-size:13px;margin-bottom:16px}
        .bc-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px 16px}
        .bc-grid div{padding:10px 12px;border-radius:10px;background:#f8f5ee}
        .bc-grid span{display:block;font-size:10px;letter-spacing:1px;text-transform:uppercase;color:var(--gold);font-weight:700}
        .bc-grid b{font-weight:600;font-size:14px}
        .bc-form{display:grid;gap:12px;margin-top:8px}
        .bc-form label{display:flex;flex-direction:column;gap:6px;font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--gold)}
        .bc-form input,.bc-form select{
            height:42px;border:1px solid rgba(197,160,89,.35);border-radius:10px;padding:0 12px;
            font-family:inherit;font-size:14px;color:var(--text-dark);
        }
        .bc-dialog-actions{display:flex;justify-content:center;gap:10px;margin-top:16px}
        @media(max-width:1100px){
            .bc-cards,.bc-filters,.bp-filters{grid-template-columns:1fr}
            .bc-grid{grid-template-columns:1fr}
        }
    </style>
    @include('partials.data-center-styles')
</head>
<body>
<script>
(function(){
    var V='aj_reset_v5';
    if(localStorage.getItem('aj_data_version')!==V){
        for(var i=localStorage.length-1;i>=0;i--){
            var k=localStorage.key(i);
            if(k&&k.indexOf('aj_')===0)localStorage.removeItem(k);
        }
        localStorage.setItem('aj_data_version',V);
    }
})();
</script>
@php
    $adminLogin = session('space_admin_login', 'Direction');
    if (strcasecmp($adminLogin, 'khadija@gds.com') === 0) {
        $adminLogin = 'Direction';
        session(['space_admin_login' => 'Direction']);
    }
    $managerLogins = config('admin_spaces.admin.manager_logins', ['Direction']);
    $adminProfil = session('space_admin_profil');
    $adminNom = session('space_admin_nom');
    $adminUser = $adminLogin ? \App\Models\HotelUser::where('login', $adminLogin)->first() : null;
    if ($adminUser) {
        $adminNom = $adminNom ?: $adminUser->nom;
        $adminProfil = $adminProfil ?: $adminUser->profil;
    }
    $adminPhoto = $adminUser?->photo;
    $adminLabel = $adminNom ?: ($adminProfil ?: $adminLogin ?: 'Direction');
    $adminRoleLabel = $adminProfil ?: (in_array($adminLogin, $managerLogins, true) ? 'Direction' : 'Utilisateur');
    $adminInitial = mb_strtoupper(mb_substr(trim($adminLabel), 0, 1, 'UTF-8'), 'UTF-8');
    $canManageRooms = $adminProfil !== null
        ? in_array($adminProfil, ['Direction', 'Administration'], true)
        : in_array($adminLogin, $managerLogins, true);
    // Profil Direction : accès total. Sinon, toujours recharger les droits depuis la BDD
    // (évite une session figée quand la Direction met à jour les autorisations).
    if ($adminProfil === 'Direction' || ($adminProfil === null && ! $adminUser)) {
        $menuAuth = null;
        session(['space_admin_auth' => null]);
    } else {
        $menuAuth = is_array($adminUser?->autorisations) ? $adminUser->autorisations : [];
        session(['space_admin_auth' => $menuAuth]);
        if ($adminUser) {
            session([
                'space_admin_profil' => $adminUser->profil,
                'space_admin_nom' => $adminUser->nom,
            ]);
            $adminProfil = $adminUser->profil;
            $adminNom = $adminUser->nom;
            $adminRoleLabel = $adminProfil ?: $adminRoleLabel;
            $adminLabel = $adminNom ?: ($adminProfil ?: $adminLogin ?: 'Direction');
        }
    }
    $adminSession = [
        'nom' => $adminNom ?: $adminLabel,
        'profil' => $adminRoleLabel,
        'kind' => $adminUser?->kind ?: 'user',
        'login' => $adminLogin,
    ];
@endphp
<script>
window.AJ_MENU_AUTH=@json($menuAuth);
window.AJ_SESSION=@json($adminSession);
</script>
<div class="admin-wrap sb-collapsed">
    <aside class="sidebar" id="sidebar">
        <div class="sb-brand">
            <div class="aj-mark">
                <span class="aj-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</span>
                <span class="aj-name">Al Jazeera</span>
                <span class="aj-sub"><i></i>Hotel<i></i></span>
            </div>
        </div>
        <nav class="sb-nav" id="sbNav">
            <div class="sb-section-label sec-pilot">Pilotage</div>
            <div class="sb-group sb-group-flat sec-pilot">
            <div class="sb-item sb-pilot active" data-target="dashboard">
                <span class="ic-wrap">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                </span>
                <span class="lbl">Tableau de bord</span>
            </div>
            <div class="sb-item" data-target="ch-reservations">
                <span class="ic-wrap"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg></span>
                <span class="lbl">Réservations</span>
            </div>
            <div class="sb-item" data-target="ch-occupees">
                <span class="ic-wrap"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 21h18"/><path d="M5 21V8h4v13M15 21V8h4v13"/><path d="M9 8V5h6v3"/><path d="M7 12h2M15 12h2M7 16h2M15 16h2"/></svg></span>
                <span class="lbl">C-Occupées</span>
            </div>
            <div class="sb-item" data-target="ch-calendrier">
                <span class="ic-wrap"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M3 10h18M8 14h.01M12 14h.01M16 14h.01M8 18h.01M12 18h.01"/></svg></span>
                <span class="lbl">Calendrier</span>
            </div>
            </div>

            <div class="sb-section-label sec-admin">Administration</div>
            <div class="sb-group sec-admin">
                <div class="sb-parent" id="admParent">
                    <span class="ic-wrap"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 21h16"/><path d="M6 21V10M10 21V10M14 21V10M18 21V10"/><path d="M3 10h18"/><path d="M12 3l9 7H3l9-7z"/><path d="M12 10v4"/><circle cx="12" cy="16.5" r="1.2"/></svg></span>
                    <span class="lbl">Administration</span>
                    <span class="sb-badge">4</span>
                    <span class="caret">&#9662;</span>
                </div>
                <div class="sb-sub" id="admSub">
                    <div class="sb-item" data-target="adm-balance-clients"><span class="sb-dot"></span><span class="lbl">Balance Clients</span></div>
                    <div class="sb-item" data-target="adm-balance-paiement"><span class="sb-dot"></span><span class="lbl">Balance Paiement</span></div>
                    <div class="sb-item" data-target="adm-archive"><span class="sb-dot"></span><span class="lbl">Archive</span></div>
                    <div class="sb-item" data-target="adm-chambres"><span class="sb-dot"></span><span class="lbl">Gestion Chambres</span></div>
                </div>
            </div>

            <div class="sb-section-label sec-heberg">Hébergement</div>
            <div class="sb-group sb-group-flat sec-heberg">
                <div class="sb-item" data-target="ch-etat">
                    <span class="ic-wrap"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 4v16"/><path d="M2 8h18a2 2 0 012 2v10"/><path d="M2 17h20"/><path d="M6 8v9"/></svg></span>
                    <span class="lbl">Chambres</span>
                </div>
                <div class="sb-item" data-target="ch-etages">
                    <span class="ic-wrap"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3l9 5v13H3V8l9-5z"/><path d="M9 21V12h6v9"/></svg></span>
                    <span class="lbl">Étages</span>
                </div>
                <div class="sb-item" data-target="ch-dispo">
                    <span class="ic-wrap"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 6h10M18 6h2M4 12h4M12 12h8M4 18h12M20 18h0"/><circle cx="16" cy="6" r="2"/><circle cx="10" cy="12" r="2"/><circle cx="18" cy="18" r="2"/></svg></span>
                    <span class="lbl">Config Chambres</span>
                </div>
            </div>

            <div class="sb-section-label sec-achats">Achats &amp; Stock</div>
            <div class="sb-group sec-achats">
                <div class="sb-parent" id="frnsParent">
                    <span class="ic-wrap"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 9l9-6 9 6v11a1 1 0 01-1 1H4a1 1 0 01-1-1V9z"/><path d="M9 22V12h6v10"/></svg></span>
                    <span class="lbl">Fournisseurs</span>
                    <span class="sb-badge">4</span>
                    <span class="caret">&#9662;</span>
                </div>
                <div class="sb-sub" id="frnsSub">
                    <div class="sb-item" data-target="fiche"><span class="sb-dot"></span><span class="lbl">Fiche fournisseur</span></div>
                    <div class="sb-item" data-target="bon"><span class="sb-dot"></span><span class="lbl">Bon d'achat</span></div>
                    <div class="sb-item" data-target="regl"><span class="sb-dot"></span><span class="lbl">Règlement achats</span></div>
                    <div class="sb-item" data-target="balance"><span class="sb-dot"></span><span class="lbl">Balance</span></div>
                </div>
            </div>
            <div class="sb-group sec-achats">
                <div class="sb-parent" id="stockParent">
                    <span class="ic-wrap"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/><path d="M3.27 6.96L12 12.01l8.73-5.05M12 22.08V12"/></svg></span>
                    <span class="lbl">Stock</span>
                    <span class="sb-badge">3</span>
                    <span class="caret">&#9662;</span>
                </div>
                <div class="sb-sub" id="stockSub">
                    <div class="sb-item" data-target="stock-mouvement"><span class="sb-dot"></span><span class="lbl">Mouvement stock</span></div>
                    <div class="sb-item" data-target="stock-etat"><span class="sb-dot"></span><span class="lbl">État produit</span></div>
                    <div class="sb-item" data-target="stock-fiscal"><span class="sb-dot"></span><span class="lbl">Stock fiscal</span></div>
                </div>
            </div>

            <div class="sb-section-label sec-fact">Facturation</div>
            <div class="sb-group sec-fact">
                <div class="sb-parent" id="factParent">
                    <span class="ic-wrap"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/></svg></span>
                    <span class="lbl">Facturation</span>
                    <span class="sb-badge">6</span>
                    <span class="caret">&#9662;</span>
                </div>
                <div class="sb-sub" id="factSub">
                    <div class="sb-item" data-target="fact-frns"><span class="sb-dot"></span><span class="lbl">Facture fournisseur</span></div>
                    <div class="sb-item" data-target="regl-frns"><span class="sb-dot"></span><span class="lbl">Règlement fournisseur</span></div>
                    <div class="sb-item" data-target="releve-frns"><span class="sb-dot"></span><span class="lbl">Relevé compte frns</span></div>
                    <div class="sb-item" data-target="fact-clt"><span class="sb-dot"></span><span class="lbl">Facture client</span></div>
                    <div class="sb-item" data-target="regl-clt"><span class="sb-dot"></span><span class="lbl">Règlement client</span></div>
                    <div class="sb-item" data-target="releve-clt"><span class="sb-dot"></span><span class="lbl">Relevé compte clt</span></div>
                </div>
            </div>

            <div class="sb-section-label sec-pers">Personnel</div>
            <div class="sb-group sec-pers">
                <div class="sb-parent" id="persParent">
                    <span class="ic-wrap"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg></span>
                    <span class="lbl">Personnel</span>
                    <span class="sb-badge">4</span>
                    <span class="caret">&#9662;</span>
                </div>
                <div class="sb-sub" id="persSub">
                    <div class="sb-item" data-target="pers-fiche"><span class="sb-dot"></span><span class="lbl">Fiche personnel</span></div>
                    <div class="sb-item" data-target="pers-taches"><span class="sb-dot"></span><span class="lbl">Gestion des tâches</span></div>
                    <div class="sb-item" data-target="pers-suivi"><span class="sb-dot"></span><span class="lbl">Suivi journalier</span></div>
                    <div class="sb-item" data-target="pers-paiement"><span class="sb-dot"></span><span class="lbl">État paiement</span></div>
                </div>
            </div>

            <div class="sb-section-label sec-fin">Finance</div>
            <div class="sb-group sec-fin">
                <div class="sb-parent" id="monParent">
                    <span class="ic-wrap"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="2" y="6" width="20" height="12" rx="2"/><path d="M12 12h.01M17 12h.01M7 12h.01"/></svg></span>
                    <span class="lbl">Trésorerie</span>
                    <span class="sb-badge">4</span>
                    <span class="caret">&#9662;</span>
                </div>
                <div class="sb-sub" id="monSub">
                    <div class="sb-item" data-target="mon-caisse"><span class="sb-dot"></span><span class="lbl">Caisse</span></div>
                    <div class="sb-item" data-target="mon-tresorerie"><span class="sb-dot"></span><span class="lbl">Trésorerie</span></div>
                    <div class="sb-item" data-target="mon-salaires"><span class="sb-dot"></span><span class="lbl">Salaires</span></div>
                    <div class="sb-item" data-target="mon-charges"><span class="sb-dot"></span><span class="lbl">Charges</span></div>
                </div>
            </div>

            <div class="sb-section-label sec-sys">Système</div>
            <div class="sb-group sec-sys">
                <div class="sb-parent" id="cfgParent">
                    <span class="ic-wrap"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="3"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg></span>
                    <span class="lbl">Configuration</span>
                    <span class="sb-badge">4</span>
                    <span class="caret">&#9662;</span>
                </div>
                <div class="sb-sub" id="cfgSub">
                    <div class="sb-item" data-target="configuration" data-cfg="hotel"><span class="sb-dot"></span><span class="lbl">Fiche hôtel</span></div>
                    <div class="sb-item" data-target="configuration" data-cfg="carrousel"><span class="sb-dot"></span><span class="lbl">Carrousel</span></div>
                    <div class="sb-item" data-target="configuration" data-cfg="habillage"><span class="sb-dot"></span><span class="lbl">Habillage</span></div>
                    <div class="sb-item" data-target="configuration" data-cfg="users"><span class="sb-dot"></span><span class="lbl">Utilisateurs</span></div>
                </div>
            </div>
        </nav>
        <div class="sb-foot">
            <div class="sb-profile">
                <div class="sb-profile-av">
                    @if($adminPhoto)
                        <img src="{{ $adminPhoto }}" alt="{{ $adminLabel }}">
                    @else
                        {{ $adminInitial }}
                    @endif
                </div>
                <div class="sb-profile-info">
                    <b>{{ $adminLabel }}</b>
                    <span>{{ $adminRoleLabel }}</span>
                </div>
                <span class="sb-profile-caret">&#9662;</span>
            </div>
            <form method="POST" action="{{ route('space.logout', 'admin') }}">
                @csrf
                <button type="submit" class="logout-btn">&#10132; Déconnexion</button>
            </form>
        </div>
    </aside>

    <div class="overlay" id="overlay"></div>

    <div class="main">
        <div class="topbar">
            <div class="topbar-left">
                <button class="hamb" id="hamb" type="button" aria-label="Ouvrir le menu">&#9776;</button>
                <button class="sb-toggle" id="sbToggle" type="button" aria-label="Fermer le menu latéral" aria-expanded="true" title="Fermer le menu">
                    <svg class="ico-collapse" viewBox="0 0 24 24" aria-hidden="true">
                        <rect x="3" y="4" width="7" height="16" rx="1.5"/>
                        <path d="M14 8l5 4-5 4"/>
                    </svg>
                    <svg class="ico-expand" viewBox="0 0 24 24" aria-hidden="true">
                        <rect x="14" y="4" width="7" height="16" rx="1.5"/>
                        <path d="M10 8l-5 4 5 4"/>
                    </svg>
                </button>
                <div class="topbar-brand" id="goDashboard" title="Retour au tableau de bord">
                    <div class="aj-mark aj-mark-top">
                        <span class="aj-name">Al Jazeera</span>
                        <span class="aj-sub"><i></i>Hotel<i></i></span>
                    </div>
                    <span class="tb-sep" aria-hidden="true"></span>
                    <div class="topbar-brand-text">
                        <h1 id="pageTitle" class="is-slogan">Découvrez Laâyoune, vivez l’expérience <em>AL JAZZERA</em>.</h1>
                    </div>
                </div>
            </div>
            <div class="who">
                <div class="aj-bell-wrap" id="ajBellWrap">
                    <button type="button" class="aj-bell" id="ajBellBtn" aria-label="Notifications" aria-expanded="false" title="Notifications">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2c0 .5-.2 1-.6 1.4L4 17h5"/>
                            <path d="M9.5 17a2.5 2.5 0 005 0"/>
                        </svg>
                        <span class="aj-bell-dot" id="ajBellDot" hidden>0</span>
                    </button>
                    <div class="aj-bell-panel" id="ajBellPanel" hidden>
                        <div class="aj-bell-head">
                            <strong>Alertes réservations web</strong>
                            <button type="button" class="aj-bell-mark" id="ajBellMarkAll">Tout lu</button>
                        </div>
                        <div class="aj-bell-list" id="ajBellList">
                            <p class="aj-bell-empty">Aucune alerte.</p>
                        </div>
                    </div>
                </div>
                <div style="text-align:right"><b>{{ $adminLabel }}</b><span>{{ $adminRoleLabel }}</span></div>
                @if($adminPhoto)
                    <img src="{{ $adminPhoto }}" alt="{{ $adminLabel }}">
                @elseif(file_exists(public_path('images/profile.png')))
                    <img src="{{ asset('images/profile.png') }}" alt="profil">
                @else
                    <div class="sb-profile-av" style="width:42px;height:42px;font-size:16px">{{ $adminInitial }}</div>
                @endif
            </div>
        </div>

        <div class="dash-kpi" id="dashKpiBar">
            <div class="cards">
                <div class="card kpi-chambres">
                    <span class="kpi-accent"></span>
                    <span class="kpi-shine"></span>
                    <div class="kpi-icon-wrap">
                        <svg viewBox="0 0 24 24"><path d="M3 10h18v10H3z"/><path d="M5 10V7a2 2 0 012-2h10a2 2 0 012 2v3"/><path d="M7 14h4"/><path d="M13 14h4"/></svg>
                    </div>
                    <div class="kpi-body">
                        <span class="l">Total Chambres</span>
                        <div class="n" id="kpiChambres">0</div>
                    </div>
                </div>
                <div class="card kpi-occupees">
                    <span class="kpi-accent"></span>
                    <span class="kpi-shine"></span>
                    <div class="kpi-icon-wrap">
                        <svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                    </div>
                    <div class="kpi-body">
                        <span class="l">Chambres Occupées</span>
                        <div class="n" id="kpiOccupees">0</div>
                    </div>
                </div>
                <div class="card kpi-charges">
                    <span class="kpi-accent"></span>
                    <span class="kpi-shine"></span>
                    <div class="kpi-icon-wrap">
                        <svg viewBox="0 0 24 24"><path d="M12 2v20"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
                    </div>
                    <div class="kpi-body">
                        <span class="l">Total Charges</span>
                        <div class="n money"><span class="amt" id="kpiCharges">0.00</span><span class="unit">DH</span></div>
                    </div>
                </div>
                <div class="card kpi-soldedu">
                    <span class="kpi-accent"></span>
                    <span class="kpi-shine"></span>
                    <div class="kpi-icon-wrap">
                        <svg viewBox="0 0 24 24"><path d="M12 3v18"/><path d="M5 7h14"/><path d="M8 7l2-4h4l2 4"/><path d="M7 17h10"/><path d="M9 21h6"/></svg>
                    </div>
                    <div class="kpi-body">
                        <span class="l">Total Solde Du</span>
                        <div class="n money"><span class="amt" id="kpiSoldeDu">0.00</span><span class="unit">DH</span></div>
                    </div>
                </div>
                <div class="card kpi-caisse">
                    <span class="kpi-accent"></span>
                    <span class="kpi-shine"></span>
                    <div class="kpi-icon-wrap">
                        <svg viewBox="0 0 24 24"><rect x="2" y="6" width="20" height="14" rx="2"/><path d="M2 10h20"/><path d="M6 14h.01"/><path d="M10 14h4"/></svg>
                    </div>
                    <div class="kpi-body">
                        <span class="l">Total Caisse</span>
                        <div class="n money"><span class="amt" id="kpiCaisse">0.00</span><span class="unit">DH</span></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Cartes analytiques Chambres — fixed comme le dashboard --}}
        <div class="ch-kpi hidden" id="chKpiBar" aria-hidden="true">
            <div class="ch-stats-row" id="chStatsRow">
                <div class="ch-stat-card st-total" data-stat="total">
                    <div class="ch-stat-ico">&#128719;</div>
                    <div class="ch-stat-body">
                        <span>Total chambres</span>
                        <b id="statTotal">0</b>
                        <small id="statTotalPct">Toutes catégories</small>
                    </div>
                </div>
                <div class="ch-stat-card st-dispo" data-stat="disponible">
                    <div class="ch-stat-ico">&#10003;</div>
                    <div class="ch-stat-body">
                        <span>Disponibles</span>
                        <b id="statDispo">0</b>
                        <small id="statDispoPct">0%</small>
                    </div>
                </div>
                <div class="ch-stat-card st-occu" data-stat="occupee">
                    <div class="ch-stat-ico">&#128100;</div>
                    <div class="ch-stat-body">
                        <span>Occupées</span>
                        <b id="statOccu">0</b>
                        <small id="statOccuPct">0%</small>
                    </div>
                </div>
                <div class="ch-stat-card st-resa" data-stat="reservee">
                    <div class="ch-stat-ico">&#128467;</div>
                    <div class="ch-stat-body">
                        <span>Réservées</span>
                        <b id="statResa">0</b>
                        <small id="statResaPct">0%</small>
                    </div>
                </div>
                <div class="ch-stat-card st-nett" data-stat="nettoyage">
                    <div class="ch-stat-ico">&#128736;</div>
                    <div class="ch-stat-body">
                        <span>Nettoyage</span>
                        <b id="statNett">0</b>
                        <small id="statNettPct">0%</small>
                    </div>
                </div>
                <div class="ch-stat-card st-maint" data-stat="maintenance">
                    <div class="ch-stat-ico">&#9881;</div>
                    <div class="ch-stat-body">
                        <span>Maintenance</span>
                        <b id="statMaint">0</b>
                        <small id="statMaintPct">0%</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- KPI fixes — Facturation client --}}
        <div class="section-kpi hidden" data-for="fact-clt" aria-hidden="true">
            <div class="cards">
                <div class="card"><div class="n">284 500 DH</div><div class="l">Chiffre du mois</div></div>
                <div class="card"><div class="n">112</div><div class="l">Factures payées</div></div>
                <div class="card"><div class="n">9</div><div class="l">Impayées</div></div>
                <div class="card"><div class="n">18 200 DH</div><div class="l">En attente</div></div>
            </div>
        </div>

        {{-- KPI fixes — Réservations --}}
        <div class="section-kpi hidden" data-for="ch-reservations" aria-hidden="true">
            <div class="cards">
                <div class="card"><div class="n" id="resaKpiActive">0</div><div class="l">Réservations actives</div></div>
                <div class="card"><div class="n" id="resaKpiArr">0</div><div class="l">Arrivées aujourd'hui</div></div>
                <div class="card"><div class="n" id="resaKpiDep">0</div><div class="l">Départs aujourd'hui</div></div>
                <div class="card"><div class="n" id="resaKpiTotal">0</div><div class="l">Total réservations</div></div>
            </div>
        </div>

        {{-- KPI fixes — C-Occupées --}}
        <div class="section-kpi hidden" data-for="ch-occupees" aria-hidden="true">
            <div class="cards">
                <div class="card"><div class="n" id="occKpiActive">0</div><div class="l">Chambres occupées</div></div>
                <div class="card"><div class="n" id="occKpiMontant">0 DH</div><div class="l">Montant total</div></div>
                <div class="card"><div class="n" id="occKpiPaye">0 DH</div><div class="l">Montant payé</div></div>
                <div class="card"><div class="n" id="occKpiSolde">0 DH</div><div class="l">Solde dû</div></div>
            </div>
        </div>

        {{-- KPI fixes — Personnel --}}
        <div class="section-kpi hidden" data-for="pers-fiche" aria-hidden="true">
            <div class="cards">
                <div class="card"><div class="n">48</div><div class="l">Employés</div></div>
                <div class="card"><div class="n">41</div><div class="l">Présents</div></div>
                <div class="card"><div class="n">5</div><div class="l">En congé</div></div>
                <div class="card"><div class="n">2</div><div class="l">Absents</div></div>
            </div>
        </div>

        {{-- KPI fixes — Caisse --}}
        <div class="section-kpi hidden" data-for="mon-caisse" data-cols="3" aria-hidden="true">
            <div class="cards">
                <div class="card"><div class="n">24 800 DH</div><div class="l">Solde caisse</div></div>
                <div class="card"><div class="n">+15 200 DH</div><div class="l">Entrées (jour)</div></div>
                <div class="card"><div class="n">-8 600 DH</div><div class="l">Sorties (jour)</div></div>
            </div>
        </div>

        {{-- KPI fixes — Trésorerie --}}
        <div class="section-kpi hidden" data-for="mon-tresorerie" aria-hidden="true">
            <div class="cards">
                <div class="card"><div class="n">486 000 DH</div><div class="l">Solde actuel</div></div>
                <div class="card"><div class="n">+312 500 DH</div><div class="l">Entrées (mois)</div></div>
                <div class="card"><div class="n">-198 700 DH</div><div class="l">Sorties (mois)</div></div>
                <div class="card"><div class="n">+113 800 DH</div><div class="l">Résultat net</div></div>
            </div>
        </div>

        {{-- KPI fixes — Salaires --}}
        <div class="section-kpi hidden" data-for="mon-salaires" aria-hidden="true">
            <div class="cards">
                <div class="card"><div class="n">48</div><div class="l">Bulletins</div></div>
                <div class="card"><div class="n">312 000 DH</div><div class="l">Masse salariale</div></div>
                <div class="card"><div class="n">44</div><div class="l">Payés</div></div>
                <div class="card"><div class="n">4</div><div class="l">En attente</div></div>
            </div>
        </div>

        {{-- KPI fixes — Charges --}}
        <div class="section-kpi hidden" data-for="mon-charges" aria-hidden="true">
            <div class="cards">
                <div class="card"><div class="n">198 700 DH</div><div class="l">Charges du mois</div></div>
                <div class="card"><div class="n">62%</div><div class="l">Charges fixes</div></div>
                <div class="card"><div class="n">38%</div><div class="l">Charges variables</div></div>
                <div class="card"><div class="n">3</div><div class="l">Échéances proches</div></div>
            </div>
        </div>

        {{-- KPI fixes — Étages (cartes figées en ligne) --}}
        <div class="section-kpi etages-kpi hidden" data-for="ch-etages" aria-hidden="true">
            <div class="ch-etages-row" id="chEtagesGrid"></div>
        </div>

        <div class="ech-sticky hidden" id="echStickyBar" aria-hidden="true"></div>

        <div class="content">

            {{-- TABLEAU DE BORD --}}
            <section class="panel active" id="dashboard"></section>

            {{-- FOURNISSEUR (FICHE) --}}
            <section class="panel frns-panel frns-compact" id="fiche">
                <div class="panel-stack">
                    <div class="block">
                        <h3>Fiche fournisseur</h3>
                        <div class="ff-form-one">
                            <div class="field ff-f-date"><label>Date Création</label><input type="text" class="js-date" placeholder="jj/mm/aaaa" maxlength="10" inputmode="numeric" autocomplete="off" id="ff_date"></div>
                            <div class="field ff-f-id"><label>ID</label><input type="text" id="ff_id" placeholder="FR0001"></div>
                            <div class="field ff-f-nom"><label>Nom</label><input type="text" id="ff_nom" placeholder="Nom fournisseur"></div>
                            <div class="field ff-f-contact"><label>Contact</label><input type="text" id="ff_contact" placeholder="Téléphone / email"></div>
                            <div class="field ff-f-ville"><label>Ville</label><input type="text" id="ff_ville" placeholder="Ville"></div>
                            <div class="field ff-f-adresse"><label>Adresse</label><input type="text" id="ff_adresse" placeholder="Adresse"></div>
                            <div class="field ff-f-regl"><label>Règlement</label>
                                <select id="ff_reglement"><option>Espèces</option><option>Chèque</option><option>Effet</option><option>Virement</option><option>Versement</option></select>
                            </div>
                            <div class="field ff-f-ech"><label>Echéance</label><input type="text" id="ff_echeance" placeholder="Ex: 30 jours"></div>
                            <div class="field ff-f-solde"><label>Solde Initial</label><input type="number" id="ff_solde" placeholder="0" step="0.01"></div>
                        </div>
                        <div class="actions ff-form-actions">
                            <button type="button" class="btn gold" onclick="FRNS.saveFiche()">Valider</button>
                            <button type="button" class="btn ghost" onclick="FRNS.newFiche()">Ajouter</button>
                            <button type="button" class="ibtn" title="Fermer" aria-label="Fermer" onclick="FRNS.closeFiche()">&#10005;</button>
                        </div>
                    </div>
                    <div class="block">
                        <h3>Liste des fournisseurs</h3>
                        <div class="table-wrap">
                            <table id="ff_table">
                                <thead><tr><th>ID</th><th>Nom</th><th>Contact</th><th>Ville</th><th>Adresse</th><th>Règlement</th><th>Echéance</th><th>Solde Init.</th><th class="no-print">Actions</th></tr></thead>
                                <tbody id="ff_tbody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

            {{-- BON ACHATS --}}
            <section class="panel frns-panel frns-compact ba-panel" id="bon">
                <div class="panel-stack">
                    <div class="block">
                        <h3>Bon d'achat</h3>
                        <div class="ba-form-one">
                            <div class="field ba-f-date"><label>Date</label><input type="text" class="js-date" placeholder="jj/mm/aaaa" maxlength="10" inputmode="numeric" autocomplete="off" id="ba_date"></div>
                            <div class="field ba-f-num"><label>N° Bon</label><input type="text" id="ba_num" placeholder="N° bon"></div>
                            <div class="field ba-f-frns-id"><label>ID Fournisseur</label><input type="text" id="ba_frns_id" list="ba_frns_list" placeholder="FR0001" oninput="FRNS.syncBonFrns()"></div>
                            <div class="field ba-f-frns-nom"><label>Nom Fournisseur</label><input type="text" id="ba_frns_nom" readonly placeholder="—"></div>
                            <div class="field ba-f-type"><label>Type Règl</label>
                                <select id="ba_type_regl">
                                    <option value="Esp">Esp</option>
                                    <option value="Chq">Chq</option>
                                    <option value="Eff">Eff</option>
                                    <option value="Vir">Vir</option>
                                    <option value="Vers">Vers</option>
                                </select>
                            </div>
                            <div class="field ba-f-echeance"><label>Échéance</label>
                                <select id="ba_echeance">
                                    <option value="30jrs">30jrs</option>
                                    <option value="45jrs">45jrs</option>
                                    <option value="60jrs">60jrs</option>
                                    <option value="75jrs">75jrs</option>
                                    <option value="90jrs">90jrs</option>
                                </select>
                            </div>
                        </div>
                        <datalist id="ba_frns_list"></datalist>

                        <div class="table-wrap ba-lines-wrap">
                            <table class="ba-lines-table" id="ba_lines_table">
                                <thead>
                                    <tr>
                                        <th>Réf</th>
                                        <th>Désignation</th>
                                        <th>Qté</th>
                                        <th>Prix U</th>
                                        <th>Sous-Total</th>
                                        <th class="no-print">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="ba_lines_tbody"></tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4">Total bon</td>
                                        <td><span class="ba-total-val" id="ba_total">0.00 DH</span></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="actions">
                            <button type="button" class="btn ghost" onclick="FRNS.addBonLine()">+ Ligne produit</button>
                            <button type="button" class="btn gold" id="ba_save_btn" onclick="FRNS.saveBon()">Valider le bon</button>
                            <button type="button" class="btn ghost" onclick="FRNS.newBon()">Nouveau bon</button>
                            <button type="button" class="btn ghost del" id="ba_del_btn" style="display:none" onclick="FRNS.delBonCurrent()">Supprimer ce bon</button>
                            <button type="button" class="btn ghost" onclick="FRNS.printBon()">Imprimer le bon</button>
                            <button type="button" class="btn ghost" onclick="FRNS.csv('ba_table','bons_achats.csv')">Exporter</button>
                            <button type="button" class="ibtn" title="Fermer" aria-label="Fermer" onclick="FRNS.closeBon()">&#10005;</button>
                        </div>
                    </div>
                    <div class="block">
                        <h3>Liste des bons d'achats</h3>
                        <p class="ba-lines-hint">Cliquez sur un bon pour l'afficher et le modifier dans le formulaire ci-dessus.</p>
                        <div class="table-wrap">
                            <table id="ba_table">
                                <thead><tr><th>Date</th><th>N° Bon</th><th>ID Fournisseur</th><th>Nom Fournisseur</th><th>Type Règl</th><th>Échéance</th><th>Nb prod.</th><th>Total</th><th class="no-print">Actions</th></tr></thead>
                                <tbody id="ba_tbody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

            {{-- REGLEMENT ACHATS --}}
            <section class="panel frns-panel frns-compact" id="regl">
                <div class="panel-stack">
                    <div class="block">
                        <h3>Règlement achats</h3>
                        <div class="ra-form-row1">
                            <div class="field ra-f-date"><label>Date</label><input type="text" class="js-date" placeholder="jj/mm/aaaa" maxlength="10" inputmode="numeric" autocomplete="off" id="ra_date"></div>
                            <div class="field ra-f-ref"><label>Réf</label><input type="text" id="ra_ref" placeholder="Auto" readonly></div>
                            <div class="field ra-f-type"><label>Type</label>
                                <select id="ra_type" onchange="FRNS.syncReglTypeFields()"><option value="Esp">Espèces</option><option value="Chq">Chèque</option><option value="Eff">Effet</option><option value="Vir">Virement</option><option value="Vers">Versement</option></select>
                            </div>
                            <div class="field ra-f-num"><label>N° Règl</label><input type="text" id="ra_num" placeholder="N°"></div>
                            <div class="field ra-f-banq"><label>Banque</label>
                                <select id="ra_banq"><option value="">—</option><option value="AWB">AWB</option><option value="BP">BP</option><option value="BMCE">BMCE</option><option value="BMCI">BMCI</option><option value="CIH">CIH</option><option value="SG">SG</option><option value="AKHDAR BNQ">AKHDAR BNQ</option><option value="OUMNIA">OUMNIA</option><option value="BARID">BARID</option></select>
                            </div>
                            <div class="field ra-f-tire"><label>Nom Tiré</label><input type="text" id="ra_tire" placeholder="Nom tiré"></div>
                        </div>
                        <div class="ra-form-row2">
                            <div class="field ra-f-decaiss"><label>Échéance</label><input type="text" class="js-date" placeholder="jj/mm/aaaa" maxlength="10" inputmode="numeric" autocomplete="off" id="ra_decaiss"></div>
                            <div class="field ra-f-frns"><label>Fournisseur</label><select id="ra_frns" data-frns-select><option value="">— Tous —</option></select></div>
                        </div>
                        <p class="hint">Sélectionnez un fournisseur pour afficher les bons non soldés, puis saisissez le montant payé.</p>
                        <div class="bal-list" id="ra_balances"></div>
                        <div class="actions">
                            <button type="button" class="btn gold" onclick="FRNS.addReglement()">Valider le règlement</button>
                            <button type="button" class="btn ghost" onclick="FRNS.newReglement()">Ajouter Règl</button>
                            <button type="button" class="btn ghost" onclick="FRNS.print('ra_table','Règlements achats')">Imprimer</button>
                            <button type="button" class="btn ghost" onclick="FRNS.csv('ra_table','reglements.csv')">Exporter</button>
                            <button type="button" class="ibtn" title="Fermer" aria-label="Fermer" onclick="FRNS.closeRegl()">&#10005;</button>
                        </div>
                    </div>
                    <div class="block">
                        <h3>Liste des règlements</h3>
                        <div class="table-wrap">
                            <table id="ra_table">
                                <thead><tr><th>Date</th><th>Réf</th><th>Nom Fournisseur</th><th>Mnt Bon</th><th>Règlement</th><th>Échéance</th><th>Mnt Payé</th><th>Solde</th><th class="no-print">Actions</th></tr></thead>
                                <tbody id="ra_tbody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

            {{-- BALANCE --}}
            <section class="panel frns-panel frns-compact" id="balance">
                <div class="panel-stack">
                    <div class="block">
                        <div class="row-head">
                            <h3>Balance fournisseurs</h3>
                            <div class="actions" style="margin:0">
                                <button type="button" class="ibtn" title="Imprimer" aria-label="Imprimer" onclick="FRNS.printBalance()">&#128424;</button>
                                <button type="button" class="ibtn" title="Exporter PDF" aria-label="Exporter PDF" onclick="FRNS.exportBalancePdf()">&#128196;</button>
                                <button type="button" class="ibtn" title="Fermer" aria-label="Fermer" onclick="FRNS.closeBalance()">&#10005;</button>
                            </div>
                        </div>
                        <div class="bl-search-bar">
                            <div class="field bl-f-date"><label>Date</label><input type="text" class="js-date" placeholder="jj/mm/aaaa" maxlength="10" inputmode="numeric" autocomplete="off" id="bl_search_date" oninput="FRNS.renderBalance()"></div>
                            <div class="field bl-f-nom"><label>Nom Fournisseur</label><input type="text" id="bl_search_nom" placeholder="Rechercher un fournisseur…" oninput="FRNS.renderBalance()"></div>
                        </div>
                        <div class="table-wrap">
                            <table id="bl_table">
                                <thead><tr><th>Date</th><th>ID Fournisseur</th><th>Nom Fournisseur</th><th>Total Bons</th><th>Total Payé</th><th>Solde</th></tr></thead>
                                <tbody id="bl_tbody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

            {{-- STOCK — MOUVEMENT --}}
            <section class="panel frns-panel frns-compact" id="stock-mouvement">
                <div class="panel-stack">
                    <div class="block">
                        <div class="row-head">
                            <h3>Mouvement stock</h3>
                            <div class="actions" style="margin:0">
                                <button type="button" class="ibtn" title="Imprimer" aria-label="Imprimer" onclick="STOCK.print()">&#128424;</button>
                                <button type="button" class="ibtn" title="Exporter PDF" aria-label="Exporter PDF" onclick="STOCK.exportPdf()">&#128196;</button>
                            </div>
                        </div>
                        <div class="sm-form-one">
                            <div class="field sm-f-date"><label>Date achat</label><input type="text" class="js-date" placeholder="jj/mm/aaaa" maxlength="10" inputmode="numeric" autocomplete="off" id="sm_date" readonly></div>
                            <div class="field sm-f-ref"><label>Réf pro</label><input type="text" id="sm_ref" placeholder="—" readonly></div>
                            <div class="field sm-f-desig"><label>Désignation</label><input type="text" id="sm_desig" placeholder="—" readonly></div>
                            <div class="field sm-f-init"><label>Stock initial</label><input type="number" id="sm_init" placeholder="0" readonly></div>
                            <div class="field sm-f-sortie"><label>Sortie/jour</label><input type="number" id="sm_sortie" placeholder="0" step="1" min="0" oninput="STOCK.previewCalc()"></div>
                            <div class="field sm-f-stat"><label>Statut</label>
                                <select id="sm_statut"><option value="actif">Actif</option><option value="inactif">Inactif</option></select>
                            </div>
                            <div class="field sm-f-stock"><label>En stock</label><input type="text" id="sm_preview_stock" readonly value="0"></div>
                            <div class="field sm-f-etat"><label>État</label><div class="sm-etat-box" id="sm_preview_etat">—</div></div>
                        </div>
                        <p class="hint" style="margin:0 0 12px">Produits alimentés automatiquement depuis les <strong>bons d'achat</strong>. Cliquez sur une ligne pour saisir la sortie/jour et le statut.</p>
                        <div class="actions">
                            <button type="button" class="btn gold" id="sm_save_btn" onclick="STOCK.save()">Enregistrer mouvement</button>
                            <button type="button" class="btn ghost" onclick="STOCK.newItem()">Annuler</button>
                        </div>
                    </div>
                    <div class="block">
                        <h3>Liste des produits</h3>
                        <div class="table-wrap">
                            <table id="sm_table">
                                <thead><tr>
                                    <th>Date d'achat</th><th>Réf produit</th><th>Désignation</th>
                                    <th>Stock initial</th><th>Sortie/jour</th><th>Produit en stock</th>
                                    <th>Statut</th><th>État</th><th class="no-print">Actions</th>
                                </tr></thead>
                                <tbody id="sm_tbody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

            <section class="panel frns-panel frns-compact" id="stock-etat">
                <div class="panel-stack">
                    <div class="block">
                        <h3>État produit</h3>
                        <div class="ep-form-one">
                            <div class="field ep-f-date"><label>Date</label><input type="text" class="js-date" placeholder="jj/mm/aaaa" maxlength="10" inputmode="numeric" autocomplete="off" id="ep_date"></div>
                            <div class="field ep-f-num"><label>N° État</label><input type="text" id="ep_num" placeholder="Auto" readonly></div>
                            <div class="field ep-f-ref"><label>Réf produit</label><input type="text" id="ep_ref" list="ep_ref_list" placeholder="Réf" oninput="ETAT.syncProduct()"></div>
                            <div class="field ep-f-desig"><label>Désignation</label><input type="text" id="ep_desig" placeholder="Désignation" oninput="ETAT.syncProduct()"></div>
                            <div class="field ep-f-stock"><label>En stock</label><input type="text" id="ep_stock" readonly value="0"></div>
                            <div class="field ep-f-qte"><label>Qté demandée</label><input type="number" id="ep_qte" placeholder="0" step="1" min="0" oninput="ETAT.syncProduct()"></div>
                            <div class="field ep-f-dest"><label>Destination</label><input type="text" id="ep_dest" placeholder="Destination"></div>
                            <div class="field ep-f-charge"><label>Chargé</label><input type="text" id="ep_charge" placeholder="Nom du chargé"></div>
                        </div>
                        <datalist id="ep_ref_list"></datalist>
                        <div class="actions">
                            <button type="button" class="btn gold" id="ep_save_btn" onclick="ETAT.save()">Valider</button>
                            <button type="button" class="btn ghost del" id="ep_del_btn" style="display:none" onclick="ETAT.delCurrent()">Supprimer</button>
                        </div>
                    </div>
                    <div class="block">
                        <h3>Liste des états produit</h3>
                        <div class="table-wrap">
                            <table id="ep_table">
                                <thead><tr>
                                    <th>Date</th><th>N° État</th><th>Désignation</th><th>Qté</th><th>Chargé</th>
                                    <th class="no-print">Actions</th>
                                </tr></thead>
                                <tbody id="ep_tbody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

            <section class="panel" id="stock-fiscal">
                <h2 class="serif">Stock Fiscal</h2>
                <p class="sub">Valorisation fiscale et inventaire comptable</p>
                <div class="block">
                    <div class="row-head"><h3>Inventaire fiscal</h3><button class="btn-gold">Exporter</button></div>
                    <table>
                        <thead><tr><th>Article</th><th>Qté</th><th>Prix unitaire</th><th>Valeur HT</th><th>TVA</th><th>Valeur TTC</th></tr></thead>
                        <tbody>
                            <tr class="empty-row"><td colspan="6">Aucune donnée.</td></tr>
                        </tbody>
                    </table>
                </div>
            </section>

            {{-- FACTURATION --}}
            <section class="panel" id="fact-frns">
                <h2 class="serif">Facture Fournisseur</h2>
                <p class="sub">Factures reçues des fournisseurs</p>
                <div class="block">
                    <div class="row-head"><h3>Factures fournisseurs</h3><button class="btn-gold">+ Nouvelle facture</button></div>
                    <table>
                        <thead><tr><th>N°</th><th>Fournisseur</th><th>Date</th><th>Montant</th><th>Statut</th></tr></thead>
                        <tbody>
                            <tr class="empty-row"><td colspan="6">Aucune donnée.</td></tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="panel" id="regl-frns">
                <h2 class="serif">Règl Fournisseur</h2>
                <p class="sub">Règlements des factures fournisseurs</p>
                <div class="block">
                    <div class="row-head"><h3>Règlements fournisseurs</h3><button class="btn-gold">+ Nouveau règlement</button></div>
                    <table>
                        <thead><tr><th>Date</th><th>Réf</th><th>Fournisseur</th><th>Type</th><th>Montant</th></tr></thead>
                        <tbody>
                            <tr class="empty-row"><td colspan="6">Aucune donnée.</td></tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="panel" id="releve-frns">
                <h2 class="serif">Relevé Compte Frns</h2>
                <p class="sub">Relevé de compte fournisseurs</p>
                <div class="block">
                    <div class="row-head"><h3>Relevés fournisseurs</h3><button class="btn-gold">Imprimer</button></div>
                    <table>
                        <thead><tr><th>Fournisseur</th><th>Facturé</th><th>Réglé</th><th>Solde</th></tr></thead>
                        <tbody>
                            <tr class="empty-row"><td colspan="6">Aucune donnée.</td></tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="panel" id="fact-clt">
                <h2 class="serif">Facture client</h2>
                <p class="sub">Factures clients et encaissements</p>
                <div class="block">
                    <div class="row-head"><h3>Dernières factures clients</h3><button class="btn-gold">+ Nouvelle facture</button></div>
                    <table>
                        <thead><tr><th>N°</th><th>Client</th><th>Date</th><th>Montant</th><th>Statut</th></tr></thead>
                        <tbody>
                            <tr class="empty-row"><td colspan="6">Aucune donnée.</td></tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="panel" id="regl-clt">
                <h2 class="serif">Règl Client</h2>
                <p class="sub">Règlements des factures clients</p>
                <div class="block">
                    <div class="row-head"><h3>Règlements clients</h3><button class="btn-gold">+ Nouveau règlement</button></div>
                    <table>
                        <thead><tr><th>Date</th><th>Réf</th><th>Client</th><th>Type</th><th>Montant</th></tr></thead>
                        <tbody>
                            <tr class="empty-row"><td colspan="6">Aucune donnée.</td></tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="panel" id="releve-clt">
                <h2 class="serif">Relevé Compte Clt</h2>
                <p class="sub">Relevé de compte clients</p>
                <div class="block">
                    <div class="row-head"><h3>Relevés clients</h3><button class="btn-gold">Imprimer</button></div>
                    <table>
                        <thead><tr><th>Client</th><th>Facturé</th><th>Réglé</th><th>Solde</th></tr></thead>
                        <tbody>
                            <tr class="empty-row"><td colspan="6">Aucune donnée.</td></tr>
                        </tbody>
                    </table>
                </div>
            </section>

            {{-- ADMINISTRATION --}}
            <section class="panel" id="adm-balance-clients">
                <div class="bc-head">
                    <div class="bc-kicker">Administration</div>
                    <h2 class="serif">Balance Clients</h2>
                    <p class="sub">Réservations validées — soldes, paiements et recherches</p>
                </div>
                <div class="bc-cards">
                    <article class="bc-card total"><span class="bc-accent"></span><div class="bc-lbl">Montant Total</div><div class="bc-val" id="bcTotal">0 <small>DH</small></div></article>
                    <article class="bc-card paid"><span class="bc-accent"></span><div class="bc-lbl">Montant Payé</div><div class="bc-val" id="bcPaid">0 <small>DH</small></div></article>
                    <article class="bc-card due"><span class="bc-accent"></span><div class="bc-lbl">Solde</div><div class="bc-val" id="bcDue">0 <small>DH</small></div></article>
                </div>
                <div class="bc-filters">
                    <label>Mois<input type="month" id="bcMonth"></label>
                    <label>Nom Client<input type="search" id="bcNom" placeholder="Rechercher un client" autocomplete="off"></label>
                    <label>N° Chambre<input type="search" id="bcChambre" placeholder="Ex. 201" autocomplete="off"></label>
                    <button type="button" class="bc-reset" id="bcReset">Effacer</button>
                </div>
                <div class="block bc-table-card">
                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>Date</th><th>ID Client</th><th>Nom Client</th><th>N° Chambre</th>
                                    <th>Nbrs Jours</th><th>Paie/Jr</th><th>Total</th><th>Paiement</th>
                                    <th>Type</th><th>Solde</th><th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="bcBody">
                                <tr class="empty-row"><td colspan="11">Aucune réservation validée.</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="bc-modal" id="bcModal" aria-hidden="true">
                    <div class="bc-dialog" id="bcDialog" role="dialog" aria-modal="true"></div>
                </div>
            </section>
            <section class="panel" id="adm-balance-paiement">
                <div class="bc-head">
                    <div class="bc-kicker">Administration</div>
                    <h2 class="serif">Balance Paiement</h2>
                    <p class="sub">Encaissements issus des réservations validées</p>
                </div>
                <div class="bc-cards">
                    <article class="bc-card paid"><span class="bc-accent"></span><div class="bc-lbl">Total Payé</div><div class="bc-val" id="bpPaid">0 <small>DH</small></div></article>
                    <article class="bc-card due"><span class="bc-accent"></span><div class="bc-lbl">Total Solde</div><div class="bc-val" id="bpDue">0 <small>DH</small></div></article>
                </div>
                <div class="bc-filters bp-filters">
                    <label>Mois<input type="month" id="bpMonth"></label>
                    <label>Mnt<input type="search" id="bpMnt" placeholder="Montant" autocomplete="off"></label>
                    <label>N° Rég<input type="search" id="bpNreg" placeholder="N° de règlement" autocomplete="off"></label>
                    <label>Bnq<input type="search" id="bpBnq" placeholder="Banque" autocomplete="off"></label>
                    <label>Nom Tiré<input type="search" id="bpTire" placeholder="Nom du tiré" autocomplete="off"></label>
                    <button type="button" class="bc-reset" id="bpReset">Effacer</button>
                </div>
                <div class="block bc-table-card">
                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>Date</th><th>Réf° Rég</th><th>Nom Client</th><th>Mnt</th><th>Type</th>
                                    <th>N° Rég</th><th>Bnq</th><th>Nom Tiré</th><th>Date Encaissement</th><th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="bpBody">
                                <tr class="empty-row"><td colspan="10">Aucun paiement issu d'une réservation validée.</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="bc-modal" id="bpModal" aria-hidden="true">
                    <div class="bc-dialog" id="bpDialog" role="dialog" aria-modal="true"></div>
                </div>
            </section>
            <section class="panel" id="adm-archive">
                <h2 class="serif">Archive</h2>
                <p class="sub">Documents et dossiers archivés</p>
                <div class="block">
                    <div class="row-head"><h3>Archives</h3></div>
                    <table>
                        <thead><tr><th>Date</th><th>Dossier</th><th>Type</th><th>Statut</th></tr></thead>
                        <tbody><tr class="empty-row"><td colspan="4">Aucune donnée.</td></tr></tbody>
                    </table>
                </div>
            </section>
            <section class="panel" id="adm-chambres">
                <h2 class="serif">Gestion Chambres</h2>
                <p class="sub">Pilotage administratif des chambres</p>
                <div class="block">
                    <div class="row-head"><h3>Chambres</h3></div>
                    <table>
                        <thead><tr><th>N°</th><th>Catégorie</th><th>Étage</th><th>Statut</th></tr></thead>
                        <tbody><tr class="empty-row"><td colspan="4">Aucune donnée.</td></tr></tbody>
                    </table>
                </div>
            </section>

            {{-- GESTION CHAMBRES --}}
            <section class="panel" id="ch-suivi">
                <h2 class="serif">Suivi Opérationnel</h2>
                <p class="sub">Suivi quotidien des opérations chambres</p>
                <div class="block">
                    <div class="row-head"><h3>Opérations du jour</h3><button class="btn-gold">+ Nouvelle opération</button></div>
                    <table>
                        <thead><tr><th>Heure</th><th>Chambre</th><th>Opération</th><th>Agent</th><th>Statut</th></tr></thead>
                        <tbody>
                            <tr class="empty-row"><td colspan="6">Aucune donnée.</td></tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="panel" id="ch-reservations">
                <h2 class="serif">Gestion des Réservations</h2>
                <p class="sub">Réservations clients — arrivées, séjours et départs</p>
                <div class="block">
                    <div class="row-head"><h3>Liste des réservations</h3></div>
                    <table>
                        <thead><tr><th>N° Résa</th><th>Client</th><th>Responsable</th><th>Chambre</th><th>Arrivée</th><th>Départ</th><th>Nuits</th><th>Montant</th><th>Statut</th><th class="no-print">Actions</th></tr></thead>
                        <tbody id="resaTbody">
                            <tr class="empty-row"><td colspan="10">Aucune réservation.</td></tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="panel" id="ch-occupees">
                <h2 class="serif">C-Occupées</h2>
                <div class="occ-filters" role="search" aria-label="Filtres C-Occupées">
                    <label>Mois
                        <select id="occMonth">
                            <option value="">Tous les mois</option>
                        </select>
                    </label>
                    <label>N° Chambre<input type="search" id="occChambre" placeholder="Ex. 201" autocomplete="off"></label>
                    <label>Nom Client<input type="search" id="occNom" placeholder="Rechercher un client" autocomplete="off"></label>
                    <label>N° Identité<input type="search" id="occCin" placeholder="CIN / Passeport" autocomplete="off"></label>
                    <label>Responsable
                        <select id="occResp">
                            <option value="">Tous</option>
                        </select>
                    </label>
                    <button type="button" class="bc-reset" id="occReset">Effacer</button>
                </div>
                <div class="occ-table-panel">
                    <div class="table-wrap" id="occBodyWrap">
                        <table class="occ-table">
                            <thead>
                                <tr>
                                    <th scope="col">Date Rés</th>
                                    <th scope="col">Réf Rés</th>
                                    <th scope="col">Nom Client</th>
                                    <th scope="col">N° Identité</th>
                                    <th scope="col">Arrivée</th>
                                    <th scope="col">Départ</th>
                                    <th scope="col">Nuits</th>
                                    <th scope="col">Tarifs</th>
                                    <th scope="col">Montant</th>
                                    <th scope="col">Payé</th>
                                    <th scope="col">Solde</th>
                                    <th scope="col">Responsable</th>
                                    <th scope="col" class="no-print">Action</th>
                                </tr>
                            </thead>
                            <tbody id="occTbody">
                                <tr class="empty-row"><td colspan="13">Aucune chambre occupée.</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section class="panel" id="ch-calendrier">
                <h2 class="serif">Calendrier</h2>
                <p class="sub">Chambres occupées et réservées — occupation et disponibilité</p>
                <div class="block cal-block">
                    <div class="cal-head">
                        <div class="cal-chips" id="calChips" role="toolbar" aria-label="Filtre calendrier"></div>
                    </div>
                    <div class="cal-grid" id="calGrid"></div>
                </div>
            </section>

            <section class="panel" id="ch-etat">
                <div class="ch-manage-wrap">
                    <div class="ch-manage-main">
                        <div class="ch-toolbar">
                            <div class="ch-search-wrap">
                                <span class="ch-search-ico">&#128269;</span>
                                <input type="search" id="chSearch" placeholder="Rechercher une chambre..." autocomplete="off">
                            </div>
                            <select id="chFilterFloor" class="ch-select" aria-label="Étage">
                                <option value="">Étage : Tous</option>
                            </select>
                            <select id="chFilterCat" class="ch-select" aria-label="Catégorie">
                                <option value="">Catégorie : Toutes</option>
                                <option value="grand-suite">Grand Suite</option>
                                <option value="suite-junior">Suite Junior</option>
                                <option value="single">Single</option>
                                <option value="double">Double</option>
                            </select>
                            <select id="chFilterStatus" class="ch-select" aria-label="Statut">
                                <option value="">Statut : Tous</option>
                                <option value="disponible">Disponible</option>
                                <option value="occupee">Occupée</option>
                                <option value="reservee">Réservée</option>
                                <option value="nettoyage">Nettoyage</option>
                                <option value="maintenance">Maintenance</option>
                            </select>
                        </div>
                        <div id="echSections" class="ch-rooms-area"></div>
                    </div>
                </div>
                <aside class="ch-detail-panel" id="chDetailPanel" aria-hidden="false">
                    <div class="ch-dp-floor-bar">
                        <label for="chDpFloorSelect">Étage</label>
                        <select id="chDpFloorSelect" aria-label="Sélectionner un étage">
                            <option value="">Choisir un étage…</option>
                        </select>
                        <label for="chDpRoomSelect">Chambre</label>
                        <select id="chDpRoomSelect" aria-label="Sélectionner une chambre">
                            <option value="">Choisir une chambre…</option>
                        </select>
                    </div>
                    <div id="chDetailContent">
                        <div class="ch-dp-empty">
                            <div class="ch-dp-empty-ico">&#128719;</div>
                            <h4>Fiche chambre</h4>
                            <p>Sélectionnez un étage puis une chambre, ou cliquez le texte d'une carte.</p>
                        </div>
                    </div>
                </aside>
            </section>

            <section class="panel" id="ch-etages">
                <div class="block">
                    <div class="ch-etages-toolbar">
                        <div class="ch-search-wrap">
                            <span class="ch-search-ico">&#128269;</span>
                            <input type="search" id="etFloorSearch" placeholder="Rechercher par étage (ex: 1, 2e étage...)" autocomplete="off">
                        </div>
                        <select id="etFloorFilter" class="ch-select" aria-label="Filtrer par étage">
                            <option value="">Étage : Tous</option>
                        </select>
                        <button type="button" class="btn-add-et" id="etAddBtn" title="Ajouter un étage ou une chambre">+ Ajouter</button>
                    </div>
                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>Étage</th>
                                    <th>N° Chambre</th>
                                    <th>Titre</th>
                                    <th>Catégorie</th>
                                    <th>Statut</th>
                                    <th>Prix / nuit</th>
                                </tr>
                            </thead>
                            <tbody id="chEtagesTableBody">
                                <tr class="empty-row"><td colspan="6">Aucune donnée.</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section class="panel" id="ch-dispo">
                <div class="dr-head">
                    <div>
                        <div class="dr-eyebrow">Hébergement</div>
                        <h2 class="dr-title cc-title">Config Chambres</h2>
                        <p class="cc-sub">Cliquez sur une chambre pour modifier son statut, sa photo, ses descriptions, son prix et ses caractéristiques.</p>
                    </div>
                    <div class="cc-tools">
                        <div class="cc-filters">
                            <select id="ccFloor" class="cc-select" aria-label="Filtrer par étage">
                                <option value="">Étage : Tous</option>
                            </select>
                            <select id="ccType" class="cc-select" aria-label="Filtrer par catégorie">
                                <option value="">Catégorie : Toutes</option>
                                <option value="grand-suite">Grand Suite</option>
                                <option value="suite-junior">Suite Junior</option>
                                <option value="single">Single</option>
                                <option value="double">Double</option>
                            </select>
                        </div>
                        <div class="dr-chips" id="ccChips"></div>
                    </div>
                </div>
                <div class="dr-grid cc-grid" id="ccGrid"></div>
            </section>

            {{-- PERSONNELS --}}
            <section class="panel" id="pers-fiche">
                <h2 class="serif">Fiche Personnel</h2>
                <p class="sub">Les employés saisis ici alimentent la fiche Utilisateur</p>
                <div class="block">
                    <div class="row-head"><h3>Liste du personnel</h3><button type="button" class="btn-gold" id="peAdd">Ajouter</button></div>
                    <div class="table-wrap">
                        <table>
                            <thead><tr>
                                <th>Date</th><th>ID</th><th>Nom complet</th><th>CIN N°</th><th>Ville</th><th>Adresse</th><th>N° mobile</th>
                                <th>Formation</th><th>Section</th><th>Profil</th><th>Type contrat</th><th>Rémunération</th>
                                <th>Date début</th><th>Date fin</th><th class="no-print">Actions</th>
                            </tr></thead>
                            <tbody id="pe_tbody"></tbody>
                        </table>
                    </div>
                </div>
            </section>
            <div class="rm-modal-overlay" id="peModalOverlay">
                <div class="rm-modal" id="peModal" role="dialog" aria-modal="true" aria-labelledby="peTitle">
                    <button type="button" class="rm-modal-close" id="peClose" aria-label="Fermer">&times;</button>
                    <div class="rm-form-head"><h3 id="peTitle">Fiche personnel</h3><p>Saisie d'un employé</p></div>
                    <div class="pe-photo-wrap">
                        <div class="pe-copy pe-photo" id="pePhotoCard">
                            <div class="pe-copy-head">Photo</div>
                            <button type="button" class="pe-copy-zone" id="pePhotoBtn" title="Importer la photo">
                                <span class="pe-copy-preview" id="pePhotoPreview"></span>
                                <span class="pe-copy-name" id="pePhotoName">Importer une photo</span>
                            </button>
                            <input type="file" id="pePhotoFile" accept="image/*" hidden>
                        </div>
                        <div class="pe-photo-side">
                            <div class="field"><label>Date</label><input type="text" class="js-date" placeholder="jj/mm/aaaa" maxlength="10" inputmode="numeric" autocomplete="off" id="pe_date"></div>
                            <div class="field"><label>ID</label><input type="text" id="pe_id" readonly></div>
                        </div>
                    </div>
                    <div class="rm-form-grid rm-edit-simple">
                        <div class="field"><label>Nom complet</label><input type="text" id="pe_nom" placeholder="Nom et prénom" autocomplete="off"></div>
                        <div class="field"><label>CIN N°</label><input type="text" id="pe_cin" placeholder="AB123456" autocomplete="off"></div>
                        <div class="field"><label>Ville</label><input type="text" id="pe_ville" autocomplete="off"></div>
                        <div class="field"><label>Adresse</label><input type="text" id="pe_adresse" autocomplete="off"></div>
                        <div class="field"><label>N° mobile / WhatsApp</label><input type="tel" id="pe_mobile" inputmode="tel" placeholder="06XXXXXXXX" autocomplete="off"></div>
                        <div class="field"><label>Formation</label><input type="text" id="pe_formation" autocomplete="off"></div>
                        <div class="field"><label>Section</label>
                            <select id="pe_section">
                                <option value="">— Sélectionner —</option>
                                <option>Direction</option><option>Facturation</option><option>Commercial</option><option>Administration</option>
                            </select>
                        </div>
                        <div class="field"><label>Profil</label>
                            <select id="pe_profil">
                                <option value="">— Sélectionner —</option>
                                <option>Direction</option><option>Administration</option><option>Réception</option>
                                <option>Comptabilité</option><option>Commercial</option><option>Maintenance</option><option>Restauration</option>
                            </select>
                        </div>
                        <div class="field"><label>Type contrat</label>
                            <select id="pe_contrat">
                                <option value="">— Sélectionner —</option>
                                <option>CDI</option><option>CDD</option><option>Vacataire</option>
                            </select>
                        </div>
                        <div class="field"><label>Rémunération (DH)</label><input type="text" id="pe_remu" inputmode="decimal" placeholder="0.00" autocomplete="off"></div>
                        <div class="field"><label>Date début</label><input type="text" class="js-date" placeholder="jj/mm/aaaa" maxlength="10" inputmode="numeric" autocomplete="off" id="pe_debut"></div>
                        <div class="field"><label>Date fin</label><input type="text" class="js-date" placeholder="jj/mm/aaaa" maxlength="10" inputmode="numeric" autocomplete="off" id="pe_fin"></div>
                    </div>
                    <div class="pe-copy-row">
                        <div class="pe-copy" id="peCinCard">
                            <div class="pe-copy-head">Copie CIN</div>
                            <button type="button" class="pe-copy-zone" id="peCinBtn" title="Importer la copie CIN">
                                <span class="pe-copy-preview" id="peCinPreview"></span>
                                <span class="pe-copy-name" id="peCinName">Importer une image ou un PDF</span>
                            </button>
                            <input type="file" id="peCinFile" accept="image/*,.pdf,application/pdf" hidden>
                        </div>
                        <div class="pe-copy" id="peDipCard">
                            <div class="pe-copy-head">Copie diplôme</div>
                            <button type="button" class="pe-copy-zone" id="peDipBtn" title="Importer le diplôme">
                                <span class="pe-copy-preview" id="peDipPreview"></span>
                                <span class="pe-copy-name" id="peDipName">Importer une image ou un PDF</span>
                            </button>
                            <input type="file" id="peDipFile" accept="image/*,.pdf,application/pdf" hidden>
                        </div>
                    </div>
                    <div class="rm-form-actions" style="margin-top:16px">
                        <button type="button" class="btn gold" id="peSave">Valider</button>
                        <button type="button" class="btn ghost" id="peCancel">Fermer</button>
                    </div>
                </div>
            </div>
            <div class="rm-modal-overlay" id="peViewOverlay">
                <div class="rm-modal" id="peViewModal" role="dialog" aria-modal="true" aria-labelledby="peViewTitle">
                    <button type="button" class="rm-modal-close" id="peViewClose" aria-label="Fermer">&times;</button>
                    <div class="rm-form-head"><h3 id="peViewTitle">Fiche personnel</h3><p id="peViewSub"></p></div>
                    <div id="peViewPhoto"></div>
                    <div class="pe-view-grid" id="peViewInfo"></div>
                    <div class="pe-docs" id="peViewDocs"></div>
                    <div class="rm-form-actions" style="margin-top:16px">
                        <button type="button" class="btn ghost" id="peViewCancel">Fermer</button>
                    </div>
                </div>
            </div>

            <section class="panel" id="pers-taches">
                <h2 class="serif">Gestion des Taches</h2>
                <p class="sub">Affectation et suivi des tâches</p>
                <div class="block">
                    <div class="row-head"><h3>Tâches en cours</h3><button class="btn-gold">+ Nouvelle tâche</button></div>
                    <table>
                        <thead><tr><th>Tâche</th><th>Assigné à</th><th>Service</th><th>Échéance</th><th>Priorité</th></tr></thead>
                        <tbody>
                            <tr class="empty-row"><td colspan="6">Aucune donnée.</td></tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="panel" id="pers-suivi">
                <h2 class="serif">Suivi Journalier</h2>
                <p class="sub">Présence et activité quotidienne</p>
                <div class="block">
                    <div class="row-head"><h3>Suivi du jour</h3><button class="btn-gold">Valider la journée</button></div>
                    <table>
                        <thead><tr><th>Employé</th><th>Arrivée</th><th>Départ</th><th>Heures</th><th>Statut</th></tr></thead>
                        <tbody>
                            <tr class="empty-row"><td colspan="6">Aucune donnée.</td></tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="panel" id="pers-paiement">
                <h2 class="serif">Etat Paiement</h2>
                <p class="sub">État des paiements du personnel</p>
                <div class="block">
                    <div class="row-head"><h3>Paiements personnel</h3><button class="btn-gold">Exporter</button></div>
                    <table>
                        <thead><tr><th>Employé</th><th>Période</th><th>Montant</th><th>Date paiement</th><th>Statut</th></tr></thead>
                        <tbody>
                            <tr class="empty-row"><td colspan="6">Aucune donnée.</td></tr>
                        </tbody>
                    </table>
                </div>
            </section>

            {{-- GESTION MONETAIRE --}}
            <section class="panel" id="mon-caisse">
                <h2 class="serif">Caisse</h2>
                <p class="sub">Mouvements de caisse journaliers</p>
                <div class="block">
                    <div class="row-head"><h3>Mouvements caisse</h3><button class="btn-gold">+ Mouvement</button></div>
                    <table>
                        <thead><tr><th>Date</th><th>Libellé</th><th>Type</th><th>Montant</th></tr></thead>
                        <tbody>
                            <tr class="empty-row"><td colspan="6">Aucune donnée.</td></tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="panel" id="mon-tresorerie">
                <h2 class="serif">Trésorerie</h2>
                <p class="sub">Suivi des flux financiers</p>
                <div class="block">
                    <div class="row-head"><h3>Derniers mouvements</h3><button class="btn-gold">+ Mouvement</button></div>
                    <table>
                        <thead><tr><th>Date</th><th>Libellé</th><th>Type</th><th>Montant</th><th>Compte</th></tr></thead>
                        <tbody>
                            <tr class="empty-row"><td colspan="6">Aucune donnée.</td></tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="panel" id="mon-salaires">
                <h2 class="serif">Salaires</h2>
                <p class="sub">Bulletins de salaire et versements</p>
                <div class="block">
                    <div class="row-head"><h3>Paies du mois</h3><button class="btn-gold">Générer les bulletins</button></div>
                    <table>
                        <thead><tr><th>Employé</th><th>Poste</th><th>Salaire brut</th><th>Net à payer</th><th>Statut</th></tr></thead>
                        <tbody>
                            <tr class="empty-row"><td colspan="6">Aucune donnée.</td></tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="panel" id="mon-charges">
                <h2 class="serif">Charges</h2>
                <p class="sub">Dépenses et charges fixes / variables</p>
                <div class="block">
                    <div class="row-head"><h3>Détail des charges</h3><button class="btn-gold">+ Ajouter une charge</button></div>
                    <table>
                        <thead><tr><th>Charge</th><th>Type</th><th>Montant</th><th>Échéance</th><th>Statut</th></tr></thead>
                        <tbody>
                            <tr class="empty-row"><td colspan="6">Aucune donnée.</td></tr>
                        </tbody>
                    </table>
                </div>
            </section>

            {{-- CONFIGURATION --}}
            <section class="panel" id="configuration">

                <div class="subpanel active" id="cfg-hotel">
                    <div class="block">
                        <h3>Fiche Hôtel</h3>
                        <div class="form-grid">
                            <div class="field"><label>Raison Sociale</label><input type="text" id="cfg_raison" placeholder="Raison sociale"></div>
                            <div class="field"><label>Nom Gérant</label><input type="text" id="cfg_gerant" placeholder="Nom du gérant"></div>
                            <div class="field"><label>Ville</label><input type="text" id="cfg_ville" placeholder="Laâyoune"></div>
                            <div class="field"><label>Adresse</label><input type="text" id="cfg_adresse" placeholder="Av. Mohammed V"></div>
                            <div class="field"><label>N° Contact</label><input type="tel" id="cfg_contact" placeholder="06 XX XX XX XX"></div>
                            <div class="field"><label>N° Fixe</label><input type="tel" id="cfg_fixe" placeholder="05 XX XX XX XX"></div>
                            <div class="field"><label>E-mail</label><input type="email" id="cfg_email" placeholder="contact@hotel.com"></div>
                            <div class="field"><label>Site web</label><input type="text" id="cfg_siteweb" placeholder="www.aljazeera-hotel.com"></div>
                            <div class="field"><label>Statut</label>
                                <select id="cfg_statut">
                                    <option value="3">3 étoiles</option>
                                    <option value="4">4 étoiles</option>
                                    <option value="5">5 étoiles</option>
                                </select>
                            </div>
                        </div>
                        <div class="actions">
                            <button type="button" class="btn gold" onclick="CFG.saveHotel()">Enregistrer</button>
                        </div>
                    </div>
                </div>

                <div class="subpanel" id="cfg-habillage">
                    <div class="block">
                        <div class="hb-head-row">
                            <div>
                                <h3>Habillage du site</h3>
                                <p class="hint" style="margin:0">Bouton Enregistrer : barre dorée fixée en bas de l'écran.</p>
                            </div>
                        </div>
                        <div class="hb-parts" id="hbParts">
                            <button type="button" class="hb-part is-on" data-hb-part="photo"><b>1. Photo d'accueil</b><span>Image, lumière, voile</span></button>
                            <button type="button" class="hb-part" data-hb-part="offres"><b>2. Offres</b><span>Bandeau et écritures</span></button>
                            <button type="button" class="hb-part" data-hb-part="chambres"><b>3. Chambres</b><span>Bloc chambres</span></button>
                            <button type="button" class="hb-part" data-hb-part="bas"><b>4. Bas de page</b><span>Services, à propos</span></button>
                        </div>
                        <div class="hb-workspace">
                            <div class="hb-liveview" id="hbLive">
                                <img id="hbLiveImg" alt="">
                                <div class="hb-live-veil" id="hbLiveVeil"></div>
                                <div class="hb-live-layer" id="hbLiveLayer"></div>
                            </div>
                            <iframe class="hb-frame" id="hbFrame" title="Aperçu de l'accueil" src="/?hb-edit=1"></iframe>
                            <div class="hb-tools">
                            <div class="hb-tools-scroll">
                                <div class="hb-part-panel is-on" data-hb-panel="photo">
                                    <div class="hb-card">
                                        <div class="hb-card-head"><h4>Ambiance</h4><p>Presets, lumière, voile</p></div>
                                        <div class="hb-presets" style="margin-bottom:12px">
                                            <button type="button" data-hb-preset="crepuscule">Crépuscule</button>
                                            <button type="button" data-hb-preset="nuit">Nuit dorée</button>
                                            <button type="button" data-hb-preset="jour">Jour clair</button>
                                        </div>
                                        <div class="hb-fields">
                                            <div>
                                                <label for="hb_color">Couleur de fond</label>
                                                <input type="color" id="hb_color" value="#1a1520">
                                            </div>
                                            <div>
                                                <label for="hb_veil">Voile</label>
                                                <select id="hb_veil">
                                                    <option value="none">Aucun</option>
                                                    <option value="navy">Marine</option>
                                                    <option value="gold">Doré</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label for="hb_light">Lumière <b id="hb_light_val">100</b></label>
                                                <div class="hb-range"><input type="range" id="hb_light" min="40" max="140" value="100"></div>
                                            </div>
                                            <div>
                                                <label for="hb_veil_opacity">Force du voile <b id="hb_veil_val">40</b></label>
                                                <div class="hb-range"><input type="range" id="hb_veil_opacity" min="0" max="80" value="40"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hb-card" style="margin-top:12px">
                                        <div class="hb-card-head"><h4>Archive photos</h4><p>Toutes les images restent sauvegardées</p></div>
                                        <div class="hb-fields">
                                            <div class="span2">
                                                <label>Photos disponibles <b id="hb_photo_count">0</b></label>
                                                <div class="hb-picks" id="hbPicks"></div>
                                                <input type="hidden" id="hb_image" value="/images/hotel-hero.png">
                                            </div>
                                            <div class="span2">
                                                <label for="hb_file">Ajouter une photo</label>
                                                <input type="file" id="hb_file" accept="image/jpeg,image/png,image/webp">
                                                <p class="hb-write-empty" style="margin-top:8px">L'image s'ajoute à l'archive à l'enregistrement. Les anciennes restent.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="hb-part-panel" data-hb-panel="offres">
                                    <div class="hb-card"><p class="hb-write-empty">Outils propres aux offres. Pour l'instant : écritures sur ce bandeau.</p></div>
                                </div>
                                <div class="hb-part-panel" data-hb-panel="chambres">
                                    <div class="hb-card"><p class="hb-write-empty">Outils propres aux chambres. Pour l'instant : écritures sur ce bloc.</p></div>
                                </div>
                                <div class="hb-part-panel" data-hb-panel="bas">
                                    <div class="hb-card">
                                        <div class="hb-card-head">
                                            <div>
                                                <h4>Services</h4>
                                                <p>Masquer ou afficher chaque catégorie</p>
                                            </div>
                                        </div>
                                        <div class="hb-svc-list" id="hbSvcList"></div>
                                    </div>
                                    <div class="hb-card" style="margin-top:12px">
                                        <div class="hb-card-head">
                                            <div>
                                                <h4>Cadre À propos</h4>
                                                <p>Texte, style et couleurs du fond</p>
                                            </div>
                                        </div>
                                        <div class="hb-fields" id="hbAboutBox">
                                            <div class="span2">
                                                <label for="hb_about_title">Titre</label>
                                                <input type="text" id="hb_about_title" maxlength="80" placeholder="À propos d'">
                                            </div>
                                            <div class="span2">
                                                <label for="hb_about_brand">Mot en or</label>
                                                <input type="text" id="hb_about_brand" maxlength="40" placeholder="ALJAZEERA">
                                            </div>
                                            <div class="span2">
                                                <label for="hb_about_text">Texte</label>
                                                <textarea id="hb_about_text" rows="4" maxlength="500" placeholder="Un hôtel <em>5 étoiles</em> ..."></textarea>
                                                <p class="hb-write-empty" style="margin-top:6px">Pour un mot en couleur : &lt;em&gt;5 étoiles&lt;/em&gt;</p>
                                            </div>
                                            <div class="span2">
                                                <label>Style du titre</label>
                                                <div class="hb-modes" id="hbAboutStyles">
                                                    <button type="button" data-hb-about-style="serif">Serif</button>
                                                    <button type="button" data-hb-about-style="moderne">Moderne</button>
                                                    <button type="button" data-hb-about-style="signature">Signature</button>
                                                    <button type="button" data-hb-about-style="enseigne">Enseigne</button>
                                                </div>
                                            </div>
                                            <div>
                                                <label for="hb_about_bg">Fond</label>
                                                <input type="color" id="hb_about_bg" value="#0a1736">
                                            </div>
                                            <div>
                                                <label for="hb_about_title_color">Titre</label>
                                                <input type="color" id="hb_about_title_color" value="#8b93a3">
                                            </div>
                                            <div>
                                                <label for="hb_about_accent">Accent / or</label>
                                                <input type="color" id="hb_about_accent" value="#c5a059">
                                            </div>
                                            <div>
                                                <label for="hb_about_text_color">Paragraphe</label>
                                                <input type="color" id="hb_about_text_color" value="#c5cbd6">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="hb-card">
                                    <div class="hb-card-head">
                                        <div>
                                            <h4>Écriture</h4>
                                            <p>Écrire, puis glisser sur la photo</p>
                                        </div>
                                        <div class="hb-actions">
                                            <button type="button" class="btn gold" id="hbAdd">+ Écriture</button>
                                            <button type="button" class="btn ghost" id="hbRemove">Retirer</button>
                                        </div>
                                    </div>
                                    <p class="hb-write-empty" id="hbWriteEmpty">Aucune écriture sélectionnée. Cliquez + Écriture, ou un texte sur l'aperçu.</p>
                                    <div class="hb-fields" id="hbWriteBox" hidden>
                                        <div class="span2">
                                            <label for="hb_w_text">Texte</label>
                                            <input type="text" id="hb_w_text" maxlength="80" placeholder="HOTEL">
                                        </div>
                                        <div class="span2">
                                            <label for="hb_w_text2">Deuxième ligne</label>
                                            <input type="text" id="hb_w_text2" maxlength="140" placeholder="AL JAZZERA">
                                        </div>
                                        <div class="span2">
                                            <label>Style</label>
                                            <div class="hb-styles" id="hbStyles">
                                                <button type="button" data-hb-style="enseigne">Enseigne</button>
                                                <button type="button" data-hb-style="classique">Classique</button>
                                                <button type="button" data-hb-style="signature">Signature</button>
                                                <button type="button" data-hb-style="moderne">Moderne</button>
                                                <button type="button" data-hb-style="lisere">Liseré</button>
                                                <button type="button" data-hb-style="contour">Contour</button>
                                                <button type="button" data-hb-style="neon">Néon</button>
                                            </div>
                                        </div>
                                        <div class="span2">
                                            <label>Mode</label>
                                            <div class="hb-modes" id="hbModes">
                                                <button type="button" data-hb-mode="libre">Libre</button>
                                                <button type="button" data-hb-mode="lignes">Deux lignes</button>
                                                <button type="button" data-hb-mode="bandeau">Bandeau</button>
                                                <button type="button" data-hb-mode="encadre">Encadré</button>
                                                <button type="button" data-hb-mode="incline">Incliné</button>
                                                <button type="button" data-hb-mode="vertical">Vertical</button>
                                            </div>
                                        </div>
                                        <div class="span2">
                                            <label for="hb_w_color">Couleur de l'écriture</label>
                                            <div class="hb-color-row">
                                                <input type="color" id="hb_w_color" value="#e2b65a">
                                                <div class="hb-color-swatches" id="hbColorSwatches">
                                                    <button type="button" data-hb-swatch="#e2b65a" title="Or" style="background:#e2b65a"></button>
                                                    <button type="button" data-hb-swatch="#ffffff" title="Blanc" style="background:#ffffff"></button>
                                                    <button type="button" data-hb-swatch="#f6e7b8" title="Champagne" style="background:#f6e7b8"></button>
                                                    <button type="button" data-hb-swatch="#1a2332" title="Nuit" style="background:#1a2332"></button>
                                                    <button type="button" data-hb-swatch="#c5a059" title="Bronze" style="background:#c5a059"></button>
                                                    <button type="button" data-hb-swatch="#d4af37" title="Doré" style="background:#d4af37"></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <label for="hb_w_size">Taille <b id="hb_w_size_val">100</b></label>
                                            <div class="hb-range"><input type="range" id="hb_w_size" min="50" max="220" value="100"></div>
                                        </div>
                                        <div class="span2">
                                            <label>Effet lumière</label>
                                            <div class="hb-lights" id="hbLights">
                                                <button type="button" data-hb-light="none">Aucun</button>
                                                <button type="button" data-hb-light="soft" class="is-on">Doux</button>
                                                <button type="button" data-hb-light="glow">Lueur</button>
                                                <button type="button" data-hb-light="forte">Forte</button>
                                                <button type="button" data-hb-light="neon">Néon</button>
                                                <button type="button" data-hb-light="or">Or</button>
                                                <button type="button" data-hb-light="relief">Relief</button>
                                                <button type="button" data-hb-light="halo">Halo</button>
                                            </div>
                                        </div>
                                        <div class="span2">
                                            <label class="hb-check" for="hb_w_stars">
                                                <input type="checkbox" id="hb_w_stars" checked>
                                                <span class="hb-check-box" aria-hidden="true"></span>
                                                <span class="hb-check-txt">Étoiles et tirets</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="hb-save-bar">
                            <p class="hb-note" id="hb_note"></p>
                            <div class="hb-actions">
                                <button type="button" class="btn ghost" id="hbReset">Revenir à l'origine</button>
                                <button type="button" class="btn gold" id="hbSave">Enregistrer</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="subpanel" id="cfg-carrousel">
                    <div class="block">
                        <h3>Carrousel — page Chambres</h3>
                        <p class="hint">Gérez les photos, titres et descriptions des carrousels par catégorie (Suites, Familiales, Singles).</p>
                        <div class="cfg-car-tabs" id="cfgCarTabs"></div>
                        <div id="cfgCarContent"></div>
                        <div class="actions" style="margin-top:16px">
                            <button type="button" class="btn gold" onclick="CFG.addCarouselSlide()">+ Ajouter une photo</button>
                            <button type="button" class="btn ghost" onclick="CFG.saveCarousel()">Enregistrer le carrousel</button>
                        </div>
                    </div>
                </div>

                <div class="subpanel" id="cfg-users">
                    <div class="block cu-list-block">
                        <div class="cu-list-head">
                            <div>
                                <h3>Utilisateurs enregistrés</h3>
                                <p class="hint" id="cu_hint" style="margin:6px 0 0">Ajoutez un compte, puis réglez ses autorisations dans le panneau.</p>
                            </div>
                            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap">
                                <span class="cu-count" id="cu_count">0 compte</span>
                                <button type="button" class="btn gold" id="cuNewBtn">+ Ajouter</button>
                            </div>
                        </div>
                        <p class="cfg-inline-msg" id="cu_msg" role="status" aria-live="polite" style="margin:12px 18px 0"></p>
                        <div class="table-wrap cu-table-wrap">
                            <table class="cu-table">
                                <thead><tr>
                                    <th>ID</th><th>Date</th><th>Nom complet</th><th>Profil</th><th>Login</th><th class="no-print">Actions</th>
                                </tr></thead>
                                <tbody id="cu_tbody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

            <div class="rm-modal-overlay" id="cuModalOverlay">
                <div class="rm-modal cu-modal" id="cuModal" role="dialog" aria-modal="true" aria-labelledby="cuTitle">
                    <button type="button" class="rm-modal-close" id="cuClose" aria-label="Fermer">&times;</button>
                    <div class="rm-form-head">
                        <h3 id="cuTitle">Nouvel utilisateur</h3>
                        <p id="cuSub">Fiche complète · connexion · autorisations</p>
                    </div>
                    <div class="pe-photo-wrap">
                        <div class="pe-copy pe-photo" id="cuPhotoCard">
                            <div class="pe-copy-head">Photo</div>
                            <button type="button" class="pe-copy-zone" id="cuPhotoBtn" title="Importer la photo">
                                <span class="pe-copy-preview" id="cuPhotoPreview"></span>
                                <span class="pe-copy-name" id="cuPhotoName">Importer une photo</span>
                            </button>
                            <input type="file" id="cuPhotoFile" accept="image/*" hidden>
                        </div>
                        <div class="pe-photo-side">
                            <div class="field"><label>Date</label><input type="text" class="js-date" placeholder="jj/mm/aaaa" maxlength="10" inputmode="numeric" autocomplete="off" id="cu_date" readonly></div>
                            <div class="field"><label>ID</label><input type="text" id="cu_id" readonly placeholder="Ut0001"></div>
                        </div>
                    </div>

                    <div class="cu-sec">
                        <h4>Infos personnelles &amp; formation</h4>
                        <div class="rm-form-grid rm-edit-simple">
                            <div class="field"><label>Nom complet</label><input type="text" id="cu_nom" list="cu_nom_list" placeholder="Nom et prénom" autocomplete="off"></div>
                            <datalist id="cu_nom_list"></datalist>
                            <div class="field"><label>CIN</label><input type="text" id="cu_cin" placeholder="AB123456" autocomplete="off"></div>
                            <div class="field"><label>Contact</label><input type="tel" id="cu_tel" placeholder="06 XX XX XX XX" inputmode="tel" autocomplete="off"></div>
                            <div class="field"><label>Adresse</label><input type="text" id="cu_adresse" placeholder="Adresse" autocomplete="off"></div>
                            <div class="field span2"><label>Type formation</label><input type="text" id="cu_formation" placeholder="Formation / diplôme" autocomplete="off"></div>
                        </div>
                    </div>

                    <div class="cu-sec">
                        <h4>Infos professionnelles</h4>
                        <div class="rm-form-grid rm-edit-simple">
                            <div class="field"><label>Profil</label>
                                <select id="cu_profil">
                                    <option value="">— Statut —</option>
                                    @foreach(\App\Models\HotelUser::USER_PROFILS as $profilOpt)
                                        <option value="{{ $profilOpt }}">{{ $profilOpt }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="field"><label>Type contrat</label>
                                <select id="cu_contrat">
                                    <option value="">— Sélectionner —</option>
                                    @foreach(\App\Models\HotelUser::CONTRATS as $contratOpt)
                                        <option value="{{ $contratOpt }}">{{ $contratOpt }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="field"><label>Date début</label><input type="text" class="js-date" placeholder="jj/mm/aaaa" maxlength="10" inputmode="numeric" autocomplete="off" id="cu_debut"></div>
                            <div class="field"><label>Date fin</label><input type="text" class="js-date" placeholder="jj/mm/aaaa" maxlength="10" inputmode="numeric" autocomplete="off" id="cu_fin"></div>
                            <div class="field"><label>Type rémunération</label>
                                <select id="cu_remu_type">
                                    <option value="">— Sélectionner —</option>
                                    @foreach(\App\Models\HotelUser::REMU_TYPES as $remuOpt)
                                        <option value="{{ $remuOpt }}">{{ $remuOpt }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="field"><label>Rémunération</label><input type="number" id="cu_salaire" placeholder="0.00" step="0.01" min="0"></div>
                        </div>
                    </div>

                    <div class="cu-sec">
                        <h4>Connexion</h4>
                        <div class="rm-form-grid rm-edit-simple">
                            <div class="field"><label>Login</label><input type="text" id="cu_login" value="" placeholder="Identifiant de connexion" autocomplete="off" data-lpignore="true" data-1p-ignore></div>
                            <div class="field"><label>Mot de passe</label><input type="password" id="cu_password" value="" placeholder="Saisie manuelle" autocomplete="new-password" data-lpignore="true" data-1p-ignore spellcheck="false"></div>
                        </div>
                    </div>

                    <div class="cu-sec cu-auth-sec">
                        <div class="cu-auth-head">
                            <div>
                                <h4>Matrice des autorisations</h4>
                                <p class="hint" id="cfg_auth_who">Définissez les droits par module : saisir, modifier, supprimer, imprimer et voir.</p>
                            </div>
                            <div class="cfg-auth-stats" id="cfg_auth_stats" aria-live="polite">
                                <b><em id="cfg_auth_on">0</em> / <span id="cfg_auth_total">0</span> droits</b>
                                <b><em id="cfg_auth_modules">0</em> modules actifs</b>
                            </div>
                        </div>
                        <div class="cfg-auth-wrap">
                            <table class="cfg-auth-table" id="cfg_auth_table">
                                <thead>
                                    <tr>
                                        <th>
                                            <label class="auth-all-lbl" title="Cocher ou décocher toutes les cases">
                                                <span class="auth-all-title">Modules / écrans</span>
                                                <span class="auth-all-sub">Tout cocher · <input type="checkbox" id="auth_check_all" aria-label="Tout cocher"></span>
                                            </label>
                                        </th>
                                        <th><span class="perm-hdr"><span class="perm-ic">&#9998;</span><span class="perm-name">Saisir</span><span class="perm-hint">Créer</span><input type="checkbox" class="auth-col-all" data-perm="saisir" title="Tout saisir" aria-label="Tout saisir"></span></th>
                                        <th><span class="perm-hdr"><span class="perm-ic">&#128394;</span><span class="perm-name">Modifier</span><span class="perm-hint">Éditer</span><input type="checkbox" class="auth-col-all" data-perm="modifier" title="Tout modifier" aria-label="Tout modifier"></span></th>
                                        <th><span class="perm-hdr"><span class="perm-ic">&#128465;</span><span class="perm-name">Supprimer</span><span class="perm-hint">Effacer</span><input type="checkbox" class="auth-col-all" data-perm="supprimer" title="Tout supprimer" aria-label="Tout supprimer"></span></th>
                                        <th><span class="perm-hdr"><span class="perm-ic">&#128424;</span><span class="perm-name">Imprimer</span><span class="perm-hint">Export</span><input type="checkbox" class="auth-col-all" data-perm="imprimer" title="Tout imprimer" aria-label="Tout imprimer"></span></th>
                                        <th><span class="perm-hdr"><span class="perm-ic">&#128065;</span><span class="perm-name">Voir</span><span class="perm-hint">Lecture</span><input type="checkbox" class="auth-col-all" data-perm="voir" title="Tout voir" aria-label="Tout voir"></span></th>
                                    </tr>
                                </thead>
                                <tbody id="cfg_auth_tbody"></tbody>
                            </table>
                        </div>
                    </div>

                    <p class="cfg-inline-msg" id="cu_modal_msg" role="status" aria-live="polite"></p>
                    <div class="rm-form-actions" style="margin-top:18px">
                        <button type="button" class="btn gold" id="cuSaveBtn">Valider</button>
                        <button type="button" class="btn ghost" id="cuCancelBtn">Fermer</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<footer class="admin-footer">
    @include('partials.copyright')
</footer>

<div class="rm-modal-overlay" id="rmModalOverlay">
    <div class="rm-modal" id="rmModal">
        <button type="button" class="rm-modal-close" id="rmModalClose" aria-label="Fermer">&times;</button>
        <div id="rmModalContent"></div>
    </div>
</div>

<div class="ch-inv-overlay" id="chInvOverlay">
    <div class="ch-inv-panel" role="dialog" aria-modal="true" aria-labelledby="chInvTitle">
        <button type="button" class="ch-inv-close" data-close="inv" aria-label="Fermer">&times;</button>
        <div class="ch-inv-head">
            <span class="ch-inv-kicker">Contenu de la chambre</span>
            <h3 id="chInvTitle">Chambre</h3>
            <p id="chInvSub"></p>
        </div>
        <div class="ch-inv-body" id="chInvBody"></div>
    </div>
</div>

<div class="ch-inv-overlay" id="chInvAddOverlay">
    <div class="ch-inv-panel" role="dialog" aria-modal="true" aria-labelledby="chInvAddTitle">
        <button type="button" class="ch-inv-close" data-close="add" aria-label="Fermer">&times;</button>
        <div class="ch-inv-head">
            <span class="ch-inv-kicker">Ajouter un contenu</span>
            <h3 id="chInvAddTitle">Chambre</h3>
            <p id="chInvAddSub"></p>
        </div>
        <form class="ch-inv-form" id="chInvForm">
            <div>
                <label for="chInvPiece">Pièce</label>
                <select id="chInvPiece" required></select>
            </div>
            <div class="ch-inv-custom" id="chInvPieceCustomWrap">
                <label for="chInvPieceCustom">Nom de la pièce</label>
                <input type="text" id="chInvPieceCustom" placeholder="Ex. Terrasse" autocomplete="off">
            </div>
            <div>
                <label for="chInvItem">Équipement</label>
                <input type="text" id="chInvItem" list="chInvItems" placeholder="TV, téléphone, routeur…" required autocomplete="off">
                <datalist id="chInvItems">
                    <option value="TV"></option>
                    <option value="Téléphone"></option>
                    <option value="Routeur"></option>
                    <option value="Climatiseur"></option>
                    <option value="Mini-bar"></option>
                    <option value="Coffre-fort"></option>
                </datalist>
            </div>
            <p class="ch-inv-note" id="chInvNote"></p>
            <button type="submit" class="ch-inv-save">Ajouter</button>
        </form>
    </div>
</div>

<div class="bl-modal-overlay" id="blDetailOverlay">
    <div class="bl-modal">
        <button type="button" class="bl-modal-close" onclick="FRNS.closeBalanceDetail()" aria-label="Fermer">&times;</button>
        <div id="blDetailContent"></div>
    </div>
</div>

<script>
    window.ajMenuOn=function(id){
        const auth=window.AJ_MENU_AUTH;
        if(auth==null)return true;
        const row=auth[id];
        return !!(row&&['saisir','modifier','supprimer','imprimer','voir'].some(k=>row[k]));
    };
    window.ajDashOn=function(id){
        const auth=window.AJ_MENU_AUTH;
        if(auth==null)return true;
        if(!Object.prototype.hasOwnProperty.call(auth,id))return window.ajMenuOn('dashboard');
        return window.ajMenuOn(id);
    };
    if(!window.ajDashOn('dash-cartes'))document.getElementById('dashKpiBar')?.classList.add('hidden');
    (function(){
        const auth=window.AJ_MENU_AUTH;
        if(auth==null)return;
        const cfg={hotel:'cfg-hotel',carrousel:'cfg-carrousel',habillage:'cfg-habillage',users:'cfg-users'};
        const dashParts=['dashboard','dash-cartes','dash-tableaux','dash-rooms'];
        document.querySelectorAll('.sb-item[data-target]').forEach(el=>{
            const id=el.dataset.target==='configuration'?(cfg[el.dataset.cfg]||''):el.dataset.target;
            const allowed=id==='dashboard'?dashParts.some(window.ajMenuOn):window.ajMenuOn(id);
            if(!allowed)el.remove();
        });
        document.querySelectorAll('.sb-group').forEach(g=>{if(!g.querySelector('.sb-item'))g.remove();});
        document.querySelectorAll('.sb-section-label').forEach(label=>{
            let n=label.nextElementSibling, any=false;
            while(n&&!n.classList.contains('sb-section-label')){
                if(n.classList.contains('sb-group')&&n.querySelector('.sb-item'))any=true;
                n=n.nextElementSibling;
            }
            if(!any)label.remove();
        });
        document.querySelectorAll('.sb-badge').forEach(b=>{
            const sub=b.parentElement?.nextElementSibling;
            if(sub&&sub.classList.contains('sb-sub'))b.textContent=String(sub.querySelectorAll('.sb-item').length);
        });
    })();
    const items=document.querySelectorAll('.sb-item');
    const panels=document.querySelectorAll('.panel');
    const title=document.getElementById('pageTitle');
    const DASH_SLOGAN=title?title.innerHTML:'';
    const sidebar=document.getElementById('sidebar');
    const overlay=document.getElementById('overlay');
    const adminWrap=document.querySelector('.admin-wrap');
    const sbToggle=document.getElementById('sbToggle');
    const dashKpiBar=document.getElementById('dashKpiBar');
    const chKpiBar=document.getElementById('chKpiBar');
    const echStickyBar=document.getElementById('echStickyBar');
    const contentEl=document.querySelector('.content');
    function expandSubForItem(item){
        if(!item)return;
        const sub=item.parentElement;
        if(!sub||!sub.classList.contains('sb-sub'))return;
        const parent=sub.previousElementSibling;
        if(parent&&parent.classList.contains('sb-parent')){
            parent.classList.add('expanded');
            sub.classList.add('open');
        }
    }
    function activatePanel(targetId,label,cfgTab){
        if(window.AJ_MENU_AUTH!=null){
            const cfg={hotel:'cfg-hotel',carrousel:'cfg-carrousel',habillage:'cfg-habillage',users:'cfg-users',auth:'cfg-users'};
            const id=targetId==='configuration'?(cfg[cfgTab]||''):targetId;
            const dashParts=['dashboard','dash-cartes','dash-tableaux','dash-rooms'];
            const allowed=id==='dashboard'?dashParts.some(window.ajMenuOn):window.ajMenuOn(id);
            if(!allowed)return;
        }
        items.forEach(x=>x.classList.remove('active'));
        document.querySelectorAll('.sb-parent').forEach(p=>p.classList.remove('active'));
        let match;
        if(targetId==='configuration'&&cfgTab){
            match=[...items].find(x=>x.dataset.target===targetId&&x.dataset.cfg===cfgTab);
            const cfgParent=document.getElementById('cfgParent');
            const cfgSub=document.getElementById('cfgSub');
            if(cfgParent){cfgParent.classList.add('expanded');}
            if(cfgSub){cfgSub.classList.add('open');}
        }else{
            match=[...items].find(x=>x.dataset.target===targetId);
        }
        if(match){
            match.classList.add('active');
            expandSubForItem(match);
        }
        panels.forEach(p=>p.classList.toggle('active',p.id===targetId));
        if(targetId==='dashboard'){
            title.innerHTML=DASH_SLOGAN;
            title.classList.add('is-slogan');
        }else{
            title.textContent=label||(match?(match.querySelector('.lbl')||match).textContent.trim():'');
            title.classList.remove('is-slogan');
        }
        if(dashKpiBar)dashKpiBar.classList.toggle('hidden',targetId!=='dashboard'||!window.ajDashOn('dash-cartes'));
        if(chKpiBar){
            const showCh=targetId==='ch-etat';
            chKpiBar.classList.toggle('hidden',!showCh);
            chKpiBar.setAttribute('aria-hidden',showCh?'false':'true');
        }
        let sectionKpiShown=false;
        document.querySelectorAll('.section-kpi').forEach(bar=>{
            const show=bar.dataset.for===targetId;
            bar.classList.toggle('hidden',!show);
            bar.setAttribute('aria-hidden',show?'false':'true');
            if(show)sectionKpiShown=true;
        });
        if(echStickyBar)echStickyBar.classList.add('hidden');
        if(contentEl){
            contentEl.classList.toggle('dash-view',targetId==='dashboard'&&window.ajDashOn('dash-cartes'));
            contentEl.classList.toggle('ech-view',false);
            contentEl.classList.toggle('ch-view',targetId==='ch-etat');
            contentEl.classList.toggle('kpi-view',sectionKpiShown);
        }
        const pageLabels={
            'ch-etat':'Chambres',
            'ch-etages':'Étages',
            'ch-dispo':'Config Chambres',
            'ch-reservations':'Réservations',
            'ch-occupees':'C-Occupées',
            'ch-calendrier':'Calendrier'
        };
        if(pageLabels[targetId])title.textContent=pageLabels[targetId];
        if(typeof FRNS!=='undefined'){
            if(targetId==='dashboard')FRNS.renderDashboard();
            if(targetId==='bon'||targetId==='regl')FRNS.renderSelects();
            if(targetId==='regl')FRNS.renderReglBalances();
            if(targetId==='balance')FRNS.renderBalance();
        }
        if(targetId==='dashboard'&&window.DASH)window.DASH.render();
        if(targetId==='stock-mouvement'&&typeof STOCK!=='undefined')STOCK.syncFromBons();
        if(targetId==='stock-etat'&&typeof ETAT!=='undefined')ETAT.render();
        if(targetId==='ch-etat'&&typeof CHETAT!=='undefined')CHETAT.render();
        if(targetId==='ch-etages'&&typeof CHETAT!=='undefined')CHETAT.renderEtages();
        if(targetId==='ch-dispo'&&typeof CHDISPO!=='undefined')CHDISPO.render();
        if((targetId==='ch-reservations'||targetId==='ch-occupees')&&window.RESA)window.RESA.render();
        if(targetId==='ch-calendrier'&&window.CALEND)window.CALEND.render();
        if(targetId==='adm-balance-clients'&&window.BCL)window.BCL.render();
        if(targetId==='adm-balance-paiement'&&window.BPY)window.BPY.render();
        if(targetId==='configuration'&&typeof CFG!=='undefined'){
            CFG.render();
            CFG.switchTab(cfgTab||'hotel');
        }else{
            document.body.classList.remove('hb-lock');
        }
        sidebar.classList.remove('open');overlay.classList.remove('show');
        if(targetId!=='configuration' || cfgTab!=='habillage'){
            window.scrollTo({top:0,behavior:'smooth'});
        }else{
            window.scrollTo(0,0);
        }
    }
    items.forEach(it=>it.addEventListener('click',()=>{
        const lbl=(it.querySelector('.lbl')||it).textContent.trim();
        activatePanel(it.dataset.target,lbl,it.dataset.cfg||null);
        if(window.innerWidth>900&&typeof setSidebarCollapsed==='function')setSidebarCollapsed(true);
    }));
    if(window.AJ_MENU_AUTH!=null){
        setTimeout(function(){
            const first=document.querySelector('#sbNav .sb-item');
            if(first)first.click();
            else{
                panels.forEach(p=>p.classList.remove('active'));
                if(title){title.textContent='Aucune section autorisée';title.classList.remove('is-slogan');}
                if(dashKpiBar)dashKpiBar.classList.add('hidden');
            }
        },0);
    }
    document.getElementById('goDashboard')?.addEventListener('click',()=>activatePanel('dashboard','Tableau de bord'));
    document.querySelector('.sb-brand')?.addEventListener('click',()=>activatePanel('dashboard','Tableau de bord'));
    const hamb=document.getElementById('hamb');
    hamb.addEventListener('click',()=>{sidebar.classList.add('open');overlay.classList.add('show')});
    overlay.addEventListener('click',()=>{sidebar.classList.remove('open');overlay.classList.remove('show')});
    function setSidebarCollapsed(collapsed){
        if(!adminWrap)return;
        adminWrap.classList.toggle('sb-collapsed',collapsed);
        if(sbToggle){
            sbToggle.classList.toggle('is-collapsed',collapsed);
            sbToggle.setAttribute('aria-expanded',collapsed?'false':'true');
            sbToggle.setAttribute('aria-label',collapsed?'Ouvrir le menu latéral':'Fermer le menu latéral');
            sbToggle.title=collapsed?'Ouvrir le menu':'Fermer le menu';
        }
        try{localStorage.setItem('aj_sb_collapsed',collapsed?'1':'0');}catch(e){}
    }
    sbToggle?.addEventListener('click',()=>{
        if(window.innerWidth<=900)return;
        setSidebarCollapsed(!adminWrap.classList.contains('sb-collapsed'));
    });
    if(adminWrap){
        if(window.innerWidth>900)setSidebarCollapsed(true);
        else adminWrap.classList.remove('sb-collapsed');
    }
    window.addEventListener('resize',()=>{
        if(window.innerWidth<=900)adminWrap?.classList.remove('sb-collapsed');
        else if(!adminWrap?.classList.contains('sb-collapsed')&&!sidebar.classList.contains('open'))setSidebarCollapsed(true);
    });
    document.querySelectorAll('.sb-parent').forEach(parent=>{
        parent.addEventListener('click',()=>{
            const sub=parent.nextElementSibling;
            if(!sub||!sub.classList.contains('sb-sub'))return;
            const willOpen=!sub.classList.contains('open');
            parent.classList.toggle('expanded',willOpen);
            sub.classList.toggle('open',willOpen);
        });
    });
    if(contentEl)contentEl.classList.add('dash-view');
</script>

<script>
/* ===== Module Fournisseur (achats) — persistance localStorage ===== */
const FRNS = (function(){
    const K={f:'aj_frns',b:'aj_bons',r:'aj_regls'};
    const get=k=>JSON.parse(localStorage.getItem(k)||'[]');
    const set=(k,v)=>localStorage.setItem(k,JSON.stringify(v));
    const uid=()=>Date.now().toString(36)+Math.random().toString(36).slice(2,6);
    const num=v=>Number(v)||0;
    const fmt=v=>ajMoneyDH(v);
    const fmtKpi=v=>{
        const n=num(v).toFixed(2).split('.');
        n[0]=n[0].replace(/\B(?=(\d{3})+(?!\d))/g,' ');
        return n.join('.');
    };
    const esc=s=>{let t=s==null?'':String(s);const m=t.match(/^(\d{4})-(\d{2})-(\d{2})$/);if(m)t=m[3]+'/'+m[2]+'/'+m[1];return t.replace(/[&<>"]/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c]));};
    let editFiche=null;

    /* ---- calculs ---- */
    const frnsById=id=>get(K.f).find(f=>f.id===id);
    const frnsName=id=>{const f=frnsById(id);return f?f.nom:'—';};
    const totalBons=id=>getBons().filter(b=>b.frnsId===id).reduce((s,b)=>s+num(b.total),0);
    const duTotal=f=>num(f.solde)+totalBons(f.id);
    const totalPaye=id=>get(K.r).filter(r=>r.frnsId===id).reduce((s,r)=>s+num(r.montant),0);
    const soldeFrns=f=>duTotal(f)-totalPaye(f.id);

    /* ---- selects ---- */
    function renderSelects(){
        const list=get(K.f);
        document.querySelectorAll('select[data-frns-select]').forEach(sel=>{
            const keepEmpty=sel.id==='ra_frns';
            const cur=sel.value;
            sel.innerHTML=(keepEmpty?'<option value="">— Tous —</option>':'<option value="">— Choisir —</option>')
                +list.map(f=>`<option value="${f.id}">${esc(f.nom)}</option>`).join('');
            sel.value=cur;
        });
        renderBonFrnsList();
    }

    function renderBonFrnsList(){
        const dl=document.getElementById('ba_frns_list');
        if(!dl)return;
        dl.innerHTML=get(K.f).map(f=>`<option value="${esc(f.id)}">${esc(f.nom)}</option>`).join('');
    }

    const reglToShort=r=>({Espèces:'Esp',Chèque:'Chq',Effet:'Eff',Virement:'Vir',Versement:'Vers'}[r]||r||'Esp');
    const BA_ECHEANCES=['30jrs','45jrs','60jrs','75jrs','90jrs'];
    function echeanceBonFromFrns(f){
        if(!f)return '30jrs';
        const m=String(f.echeance||'').match(/(\d+)/);
        if(!m)return '30jrs';
        const n=parseInt(m[1],10);
        const opts=[30,45,60,75,90];
        let best=opts[0];
        opts.forEach(o=>{if(Math.abs(n-o)<Math.abs(n-best))best=o;});
        return best+'jrs';
    }

    /* ---- FICHE FOURNISSEUR ---- */
    function nextId(){
        const nums=get(K.f).map(f=>{const m=/(\d+)/.exec(f.id||'');return m?parseInt(m[1],10):0;});
        const max=nums.length?Math.max(...nums):0;
        return 'FR'+String(max+1).padStart(4,'0');
    }
    function nextReglRef(){
        const nums=get(K.r).map(r=>{const m=/(\d+)/.exec(r.ref||'');return m?parseInt(m[1],10):0;});
        const max=nums.length?Math.max(...nums):0;
        return 'RG'+String(max+1).padStart(4,'0');
    }
    function saveFiche(){
        const nom=document.getElementById('ff_nom').value.trim();
        if(!nom){alert('Le nom du fournisseur est obligatoire.');return;}
        const list=get(K.f);
        let id=document.getElementById('ff_id').value.trim();
        const data={
            id: editFiche || (id || nextId()),
            date:ajIso(document.getElementById('ff_date').value),
            nom, contact:document.getElementById('ff_contact').value.trim(),
            ville:document.getElementById('ff_ville').value.trim(),
            adresse:document.getElementById('ff_adresse').value.trim(),
            reglement:document.getElementById('ff_reglement').value,
            echeance:document.getElementById('ff_echeance').value.trim(),
            solde:num(document.getElementById('ff_solde').value)
        };
        if(editFiche){
            const i=list.findIndex(f=>f.id===editFiche); if(i>-1)list[i]=data;
        }else{ list.push(data); }
        set(K.f,list); editFiche=null; newFiche(); renderFiche(); renderSelects();
    }
    function newFiche(){
        ['ff_date','ff_nom','ff_contact','ff_ville','ff_adresse','ff_echeance','ff_solde'].forEach(i=>document.getElementById(i).value='');
        document.getElementById('ff_reglement').selectedIndex=0; editFiche=null;
        document.getElementById('ff_id').value=nextId();
    }
    function editFicheRow(id){
        const f=frnsById(id); if(!f)return; editFiche=id;
        document.getElementById('ff_date').value=ajDate(f.date||'');
        document.getElementById('ff_id').value=f.id;
        document.getElementById('ff_nom').value=f.nom||'';
        document.getElementById('ff_contact').value=f.contact||'';
        document.getElementById('ff_ville').value=f.ville||'';
        document.getElementById('ff_adresse').value=f.adresse||'';
        document.getElementById('ff_reglement').value=f.reglement||'Espèces';
        document.getElementById('ff_echeance').value=f.echeance||'';
        document.getElementById('ff_solde').value=f.solde||0;
        window.scrollTo({top:0,behavior:'smooth'});
    }
    function delFiche(id){
        if(!confirm('Supprimer ce fournisseur ?'))return;
        set(K.f,get(K.f).filter(f=>f.id!==id)); renderFiche(); renderSelects();
    }
    function renderFiche(){
        const tb=document.getElementById('ff_tbody'); const list=get(K.f);
        tb.innerHTML=list.length?list.map(f=>`<tr>
            <td>${esc(f.id)}</td><td>${esc(f.nom)}</td><td>${esc(f.contact)}</td>
            <td>${esc(f.ville)}</td><td>${esc(f.adresse)}</td><td>${esc(f.reglement)}</td><td>${esc(f.echeance)}</td>
            <td>${fmt(f.solde)}</td>
            <td class="no-print"><span class="tbl-actions">
                <button class="ibtn" title="Modifier" onclick="FRNS.edit('${f.id}')">&#9998;</button>
                <button class="ibtn del" title="Supprimer" onclick="FRNS.del('${f.id}')">&#128465;</button>
                <button class="ibtn" title="Imprimer" onclick="FRNS.printRow('${f.id}')">&#128424;</button>
                <button class="ibtn" title="Exporter" onclick="FRNS.csvRow('${f.id}')">&#11015;</button>
            </span></td>
        </tr>`).join(''):'<tr class="empty-row"><td colspan="9">Aucun fournisseur enregistré.</td></tr>';
    }
    function printRow(id){
        const f=frnsById(id); if(!f)return;
        const rows=[['ID',f.id],['Nom',f.nom],['Date',f.date],['Contact',f.contact],['Ville',f.ville],['Adresse',f.adresse],['Règlement',f.reglement],['Echéance',f.echeance],['Solde Initial',fmt(f.solde)]];
        const w=window.open('','','width=700,height=600');
        w.document.write('<html><head><title>Fournisseur '+esc(f.nom)+'</title><style>body{font-family:Arial;padding:24px}h2{font-family:Georgia}table{border-collapse:collapse;margin-top:14px}td{border:1px solid #888;padding:9px 12px;font-size:13px}td:first-child{font-weight:bold;background:#0a1736;color:#fff}</style></head><body><h2>Fiche fournisseur</h2><table>'+rows.map(r=>'<tr><td>'+r[0]+'</td><td>'+esc(r[1])+'</td></tr>').join('')+'</table></body></html>');
        w.document.close();w.focus();setTimeout(()=>w.print(),250);
    }
    function csvRow(id){
        const f=frnsById(id); if(!f)return;
        const head=['ID','Nom','Date','Contact','Ville','Adresse','Règlement','Echéance','Solde Initial'];
        const vals=[f.id,f.nom,f.date,f.contact,f.ville,f.adresse,f.reglement,f.echeance,f.solde];
        const rows=[head.map(h=>'"'+h+'"').join(';'),vals.map(v=>'"'+String(v==null?'':v).replace(/"/g,'""')+'"').join(';')];
        const blob=new Blob(["\ufeff"+rows.join('\n')],{type:'text/csv;charset=utf-8;'});
        const a=document.createElement('a');a.href=URL.createObjectURL(blob);a.download='fournisseur_'+f.id+'.csv';a.click();
    }

    /* ---- BON ACHATS ---- */
    let editBonId=null,baLineSeed=0;

    function getBons(){
        let list=get(K.b);
        if(!list.length)return list;
        if(!list[0].lines){
            list=list.map(b=>({
                id:b.id,date:b.date,frnsId:b.frnsId,frnsNom:frnsName(b.frnsId),
                num:b.ref||'',typeRegl:'Esp',echeance:'30jrs',
                lines:[{ref:'',desig:b.desig||'',qte:num(b.qte),prix:num(b.prix),st:num(b.st)}],
                total:num(b.st)
            }));
            set(K.b,list);
            return list;
        }
        return list.map(b=>({
            ...b,
            num:b.num||b.ref||'',
            frnsNom:b.frnsNom||frnsName(b.frnsId),
            typeRegl:b.typeRegl||'Esp',
            echeance:BA_ECHEANCES.includes(b.echeance)?b.echeance:'30jrs',
            lines:(b.lines||[]).map(l=>({ref:l.ref||'',desig:l.desig||'',qte:num(l.qte),prix:num(l.prix),st:num(l.st)}))
        }));
    }

    function syncBonFrns(){
        const id=document.getElementById('ba_frns_id')?.value.trim();
        const nomEl=document.getElementById('ba_frns_nom');
        const typeEl=document.getElementById('ba_type_regl');
        const echEl=document.getElementById('ba_echeance');
        if(!nomEl)return;
        const f=frnsById(id);
        if(f){
            nomEl.value=f.nom||'';
            if(typeEl)typeEl.value=reglToShort(f.reglement);
            if(echEl)echEl.value=echeanceBonFromFrns(f);
        }else{
            nomEl.value='';
        }
    }

    function calcLineRow(tr){
        const q=num(tr.querySelector('.qte').value),p=num(tr.querySelector('.prix').value);
        tr.querySelector('.st').value=(q*p).toFixed(2);
        calcBonTotal();
    }

    function calcBonTotal(){
        let tot=0;
        document.querySelectorAll('#ba_lines_tbody tr').forEach(tr=>{tot+=num(tr.querySelector('.st')?.value);});
        const el=document.getElementById('ba_total');
        if(el)el.textContent=fmt(tot);
        return tot;
    }

    function addBonLine(data){
        const tb=document.getElementById('ba_lines_tbody');
        if(!tb)return;
        const tr=document.createElement('tr');
        tr.dataset.lineId=++baLineSeed;
        const d=data||{};
        tr.innerHTML=`
            <td><input type="text" class="ba-inp ref" placeholder="Réf" value="${esc(d.ref||'')}"></td>
            <td><input type="text" class="ba-inp desig" placeholder="Désignation" value="${esc(d.desig||'')}"></td>
            <td><input type="number" class="ba-inp qte" placeholder="0" step="1" min="0" value="${d.qte!=null&&d.qte!==''?d.qte:''}"></td>
            <td><input type="number" class="ba-inp prix" placeholder="0.00" step="0.01" min="0" value="${d.prix!=null&&d.prix!==''?d.prix:''}"></td>
            <td><input type="text" class="ba-inp st" readonly value="${d.st!=null?num(d.st).toFixed(2):''}"></td>
            <td class="no-print"><button type="button" class="tbtn del" onclick="FRNS.delBonLine(this)">Suppr.</button></td>`;
        tr.querySelectorAll('.qte,.prix').forEach(inp=>inp.addEventListener('input',()=>calcLineRow(tr)));
        tr.querySelector('.prix').addEventListener('blur',()=>{const el=tr.querySelector('.prix');if(el.value!=='')el.value=num(el.value).toFixed(2);calcLineRow(tr);});
        tb.appendChild(tr);
        calcLineRow(tr);
    }

    function delBonLine(btn){
        const tr=btn.closest('tr');
        if(tr)tr.remove();
        calcBonTotal();
        if(!document.querySelectorAll('#ba_lines_tbody tr').length)addBonLine();
    }

    function readBonLines(){
        const lines=[];
        document.querySelectorAll('#ba_lines_tbody tr').forEach(tr=>{
            const ref=tr.querySelector('.ref').value.trim();
            const desig=tr.querySelector('.desig').value.trim();
            const qte=num(tr.querySelector('.qte').value);
            const prix=num(tr.querySelector('.prix').value);
            const st=num(tr.querySelector('.st').value);
            if(ref||desig||qte||prix)lines.push({ref,desig,qte,prix,st:st||qte*prix});
        });
        return lines;
    }

    function saveBon(){
        const frnsId=document.getElementById('ba_frns_id').value.trim();
        if(!frnsId){alert('Saisissez l\'ID fournisseur.');return;}
        const f=frnsById(frnsId);
        if(!f){alert('ID fournisseur introuvable. Créez d\'abord la fiche fournisseur.');return;}
        const lines=readBonLines();
        if(!lines.length){alert('Ajoutez au moins un produit au bon.');return;}
        const total=lines.reduce((s,l)=>s+num(l.st),0);
        let list=getBons();
        const data={
            id:editBonId||uid(),
            date:ajIso(document.getElementById('ba_date').value),
            num:document.getElementById('ba_num').value.trim(),
            frnsId,
            frnsNom:document.getElementById('ba_frns_nom').value.trim()||f.nom,
            typeRegl:document.getElementById('ba_type_regl').value,
            echeance:document.getElementById('ba_echeance').value,
            lines,total
        };
        if(editBonId){
            const i=list.findIndex(b=>b.id===editBonId);
            if(i>-1)list[i]=data;
        }else{
            list.push(data);
        }
        const wasEdit=!!editBonId;
        set(K.b,list);
        editBonId=null;
        newBon();
        renderBons();
        renderBalance();
        renderReglBalances();
        if(typeof STOCK!=='undefined')STOCK.syncFromBons();
        alert(wasEdit?'Bon d\'achat mis à jour.':'Bon d\'achat enregistré.');
    }

    function updateBonFormUI(){
        const delBtn=document.getElementById('ba_del_btn');
        const saveBtn=document.getElementById('ba_save_btn');
        if(editBonId){
            if(delBtn)delBtn.style.display='';
            if(saveBtn)saveBtn.textContent='Enregistrer les modifications';
        }else{
            if(delBtn)delBtn.style.display='none';
            if(saveBtn)saveBtn.textContent='Valider le bon';
        }
    }

    function delBonCurrent(){
        if(!editBonId)return;
        delBon(editBonId);
    }

    function newBon(){
        editBonId=null;
        baLineSeed=0;
        const today=new Date().toISOString().slice(0,10);
        if(document.getElementById('ba_date'))document.getElementById('ba_date').value=ajDate(today);
        if(document.getElementById('ba_num'))document.getElementById('ba_num').value='';
        if(document.getElementById('ba_frns_id'))document.getElementById('ba_frns_id').value='';
        if(document.getElementById('ba_frns_nom'))document.getElementById('ba_frns_nom').value='';
        if(document.getElementById('ba_type_regl'))document.getElementById('ba_type_regl').selectedIndex=0;
        if(document.getElementById('ba_echeance'))document.getElementById('ba_echeance').value='30jrs';
        const tb=document.getElementById('ba_lines_tbody');
        if(tb){
            tb.innerHTML='';
            for(let i=0;i<3;i++)addBonLine();
            calcBonTotal();
        }
        updateBonFormUI();
        renderBons();
    }

    function closeBon(){
        newBon();
    }

    function closeFiche(){
        newFiche();
    }

    function editBon(id){
        const b=getBons().find(x=>x.id===id);
        if(!b)return;
        editBonId=id;
        document.getElementById('ba_date').value=ajDate(b.date||'');
        document.getElementById('ba_num').value=b.num||'';
        document.getElementById('ba_frns_id').value=b.frnsId||'';
        document.getElementById('ba_frns_nom').value=b.frnsNom||frnsName(b.frnsId);
        document.getElementById('ba_type_regl').value=b.typeRegl||'Esp';
        document.getElementById('ba_echeance').value=BA_ECHEANCES.includes(b.echeance)?b.echeance:'30jrs';
        document.getElementById('ba_lines_tbody').innerHTML='';
        baLineSeed=0;
        (b.lines||[]).forEach(l=>addBonLine(l));
        if(!(b.lines||[]).length)for(let i=0;i<3;i++)addBonLine();
        calcBonTotal();
        updateBonFormUI();
        renderBons();
        const formBlock=document.querySelector('#bon .block');
        if(formBlock)formBlock.scrollIntoView({behavior:'smooth',block:'start'});
    }

    function delBon(id){
        if(!confirm('Supprimer ce bon d\'achat ?'))return;
        set(K.b,getBons().filter(b=>b.id!==id));
        if(editBonId===id){
            editBonId=null;
            newBon();
        }
        renderBons();
        renderBalance();
        renderReglBalances();
        if(typeof STOCK!=='undefined')STOCK.syncFromBons();
        updateBonFormUI();
    }

    function bindBonList(){
        const tb=document.getElementById('ba_tbody');
        if(!tb||tb.dataset.bound)return;
        tb.addEventListener('click',e=>{
            const row=e.target.closest('.ba-main-row');
            if(!row||e.target.closest('button'))return;
            editBon(row.dataset.bonId);
        });
        tb.addEventListener('keydown',e=>{
            if(e.key!=='Enter'&&e.key!==' ')return;
            const row=e.target.closest('.ba-main-row');
            if(!row)return;
            e.preventDefault();
            editBon(row.dataset.bonId);
        });
        tb.dataset.bound='1';
    }

    function renderBons(){
        const tb=document.getElementById('ba_tbody');
        if(!tb)return;
        const list=getBons();
        tb.innerHTML=list.length?list.map(b=>{
            const nb=(b.lines||[]).length;
            const sel=editBonId===b.id?' selected':'';
            return `<tr class="ba-main-row${sel}" data-bon-id="${b.id}" role="button" tabindex="0" title="Cliquer pour modifier">
                <td>${esc(b.date)}</td><td>${esc(b.num)}</td><td>${esc(b.frnsId)}</td>
                <td>${esc(b.frnsNom||frnsName(b.frnsId))}</td><td>${esc(b.typeRegl||'Esp')}</td>
                <td>${esc(b.echeance||'30jrs')}</td>
                <td>${nb}</td><td>${fmt(b.total)}</td>
                <td class="no-print" onclick="event.stopPropagation()">
                    <button type="button" class="tbtn" onclick="FRNS.printBon('${b.id}')">Imprimer</button>
                    <button type="button" class="tbtn del" onclick="FRNS.delBon('${b.id}')">Supprimer</button>
                </td>
            </tr>`;
        }).join(''):'<tr class="empty-row"><td colspan="9">Aucun bon d\'achat enregistré.</td></tr>';
        bindBonList();
    }

    /* ---- REGLEMENT ACHATS ---- */
    function getUnpaidBons(frnsId){
        const f=frnsById(frnsId);
        if(!f)return [];
        const bons=getBons().filter(b=>b.frnsId===frnsId).sort((a,b)=>(a.date||'').localeCompare(b.date||''));
        let paid=totalPaye(frnsId);
        paid=Math.max(0,paid-num(f.solde));
        const unpaid=[];
        bons.forEach(bon=>{
            const total=num(bon.total);
            if(paid>=total){paid-=total;return;}
            const reste=total-paid;
            paid=0;
            if(reste>0)unpaid.push({bon,total,reste});
        });
        return unpaid;
    }

    function renderReglBalances(){
        const box=document.getElementById('ra_balances');
        if(!box)return;
        const list=get(K.f);
        const filter=document.getElementById('ra_frns')?.value||'';
        const shown=list.filter(f=>!filter||f.id===filter);

        if(!shown.length){
            box.innerHTML='<p class="hint">Aucun fournisseur. Créez d\'abord une fiche fournisseur.</p>';
            return;
        }

        if(!filter){
            box.innerHTML='<p class="hint">Choisissez un fournisseur dans la liste pour voir ses bons non soldés.</p>';
            return;
        }

        box.innerHTML=shown.map(f=>{
            const s=soldeFrns(f);
            const unpaid=getUnpaidBons(f.id);
            const paid=totalPaye(f.id);
            const initRem=Math.max(0,num(f.solde)-Math.min(paid,num(f.solde)));
            const payVal=s>0?s.toFixed(2):'';
            let bonsHtml='';
            if(unpaid.length||initRem>0){
                let rows='';
                if(initRem>0){
                    rows+=`<tr><td>—</td><td>Solde initial</td><td>—</td><td>${fmt(f.solde)}</td><td>${fmt(initRem)}</td></tr>`;
                }
                rows+=unpaid.map(u=>`<tr>
                    <td>${esc(u.bon.date)}</td>
                    <td>${esc(u.bon.num||'—')}</td>
                    <td>${esc(u.bon.typeRegl||'—')}</td>
                    <td>${fmt(u.total)}</td>
                    <td>${fmt(u.reste)}</td>
                </tr>`).join('');
                const count=unpaid.length+(initRem>0?1:0);
                bonsHtml=`<div class="ra-bons-wrap">
                    <p class="hint">Bons / charges non soldés (${count})</p>
                    <div class="table-wrap">
                        <table class="ra-bons-table">
                            <thead><tr><th>Date</th><th>N° Bon</th><th>Type Règl</th><th>Total bon</th><th>Reste à payer</th></tr></thead>
                            <tbody>${rows}</tbody>
                        </table>
                    </div>
                </div>`;
            }else if(s<=0){
                bonsHtml='<p class="hint">Tous les bons sont soldés pour ce fournisseur.</p>';
            }else{
                bonsHtml='<p class="hint">Aucun bon d\'achat enregistré pour ce fournisseur.</p>';
            }
            return `<div class="bal-block" data-frns-block="${f.id}">
                <div class="bal-row" data-frns="${f.id}" data-mnt="${s}">
                    <label class="chk"><input type="checkbox" class="bal-chk" ${s>0?'checked':''}> ${esc(f.nom)} <small style="opacity:.7">(${esc(f.id)})</small></label>
                    <span class="mnt">Solde dû : ${fmt(s)}</span>
                    <input class="pay" type="number" step="0.01" placeholder="MNT Payé" value="${payVal}" oninput="FRNS.calcSolde(this)">
                    <span class="sld">Solde : ${fmt(s>0&&payVal?Math.max(0,s-num(payVal)):s)}</span>
                </div>
                ${bonsHtml}
            </div>`;
        }).join('');
    }
    function calcSolde(inp){
        const row=inp.closest('.bal-row');
        const mnt=num(row.dataset.mnt), paye=num(inp.value);
        row.querySelector('.sld').textContent='Solde : '+fmt(mnt-paye);
    }
    function syncReglTypeFields(){
        const isEsp=document.getElementById('ra_type')?.value==='Esp';
        ['ra_num','ra_banq'].forEach(id=>{
            const el=document.getElementById(id);
            if(!el)return;
            el.disabled=isEsp;
            if(isEsp){
                if(el.tagName==='SELECT')el.selectedIndex=0;
                else el.value='';
            }
            el.closest('.field')?.classList.toggle('is-disabled',isEsp);
        });
        const ech=document.getElementById('ra_decaiss');
        if(ech){
            ech.disabled=false;
            ech.closest('.field')?.classList.remove('is-disabled');
        }
    }
    function addReglement(){
        const rows=[...document.querySelectorAll('#ra_balances .bal-row')].filter(r=>r.querySelector('.bal-chk').checked);
        if(!rows.length){alert('Cochez au moins un fournisseur à solder.');return;}
        let ref=document.getElementById('ra_ref').value.trim(); if(!ref)ref=nextReglRef();
        const date=ajIso(document.getElementById('ra_date').value),
              type=document.getElementById('ra_type').value, num_=document.getElementById('ra_num').value.trim(),
              banq=document.getElementById('ra_banq').value.trim(), tire=document.getElementById('ra_tire').value.trim(),
              decaiss=ajIso(document.getElementById('ra_decaiss').value);
        const list=get(K.r);
        rows.forEach(r=>{
            const frnsId=r.dataset.frns, montant=num(r.querySelector('.pay').value);
            if(montant<=0)return;
            list.push({id:uid(),date,ref,type,num:num_,banq,tire,decaiss,frnsId,montant});
        });
        set(K.r,list);
        ['ra_date','ra_num','ra_banq','ra_tire','ra_decaiss'].forEach(i=>document.getElementById(i).value='');
        document.getElementById('ra_ref').value=nextReglRef();
        renderRegls(); renderReglBalances(); renderBalance();
        alert('Règlement enregistré.');
    }
    function newReglement(){
        ['ra_date','ra_num','ra_banq','ra_tire','ra_decaiss'].forEach(i=>document.getElementById(i).value='');
        document.getElementById('ra_ref').value=nextReglRef();
        document.getElementById('ra_type').selectedIndex=0;
        document.getElementById('ra_frns').selectedIndex=0;
        syncReglTypeFields();
        renderReglBalances();
    }
    function closeRegl(){
        newReglement();
    }
    function closeBalance(){
        activatePanel('dashboard','Tableau de bord');
    }
    function delRegl(id){ if(!confirm('Supprimer ce règlement ?'))return; set(K.r,get(K.r).filter(r=>r.id!==id)); renderRegls(); renderReglBalances(); renderBalance(); }
    function renderRegls(){
        const tb=document.getElementById('ra_tbody'); const list=get(K.r);
        tb.innerHTML=list.length?list.map(r=>{
            const f=frnsById(r.frnsId);
            const mntBon=f?duTotal(f):0; const solde=f?soldeFrns(f):0;
            return `<tr>
            <td>${esc(r.date)}</td><td>${esc(r.ref)}</td><td>${esc(frnsName(r.frnsId))}</td>
            <td>${fmt(mntBon)}</td><td>${esc(r.type)}</td><td>${esc(r.decaiss)}</td>
            <td>${fmt(r.montant)}</td><td>${fmt(solde)}</td>
            <td class="no-print"><button class="tbtn del" onclick="FRNS.delRegl('${r.id}')">Supprimer</button></td>
        </tr>`;}).join(''):'<tr class="empty-row"><td colspan="9">Aucun règlement enregistré.</td></tr>';
    }

    /* ---- BALANCE ---- */
    function getBalanceRows(){
        const dateQ=ajIso(document.getElementById('bl_search_date')?.value||'');
        const nomQ=(document.getElementById('bl_search_nom')?.value||'').trim().toLowerCase();
        return get(K.f).map(f=>{
            const bons=getBons().filter(b=>b.frnsId===f.id);
            const montantBon=bons.reduce((s,b)=>s+num(b.total),0);
            const paye=totalPaye(f.id);
            const solde=montantBon-paye;
            const dates=bons.map(b=>b.date).filter(Boolean).sort();
            const date=dates.length?dates[dates.length-1]:f.date||'—';
            return{date,frnsId:f.id,frnsNom:f.nom,montantBon,paye,solde,bons};
        }).filter(r=>{
            if(nomQ&&!(r.frnsNom||'').toLowerCase().includes(nomQ))return false;
            if(dateQ&&!r.bons.some(b=>b.date===dateQ))return false;
            return true;
        }).map(({bons,...rest})=>rest)
        .sort((a,b)=>(a.frnsNom||'').localeCompare(b.frnsNom||'','fr'));
    }

    function getBalanceDetail(frnsId){
        const f=frnsById(frnsId);
        if(!f)return null;
        const bons=getBons().filter(b=>b.frnsId===frnsId).sort((a,b)=>(a.date||'').localeCompare(b.date||''));
        let paidPool=totalPaye(frnsId);
        const bonDetails=bons.map(bon=>{
            const montant=num(bon.total);
            const paye=Math.min(paidPool,montant);
            paidPool=Math.max(0,paidPool-montant);
            return{date:bon.date||'—',num:bon.num||'—',typeRegl:bon.typeRegl||'—',echeance:bon.echeance||'—',montant,paye,solde:montant-paye};
        });
        const regls=get(K.r).filter(r=>r.frnsId===frnsId).sort((a,b)=>(a.date||'').localeCompare(b.date||''));
        return{f,bonDetails,regls};
    }

    function openBalanceDetail(frnsId){
        const data=getBalanceDetail(frnsId);
        if(!data)return;
        const {f,bonDetails,regls}=data;
        const totBon=bonDetails.reduce((s,b)=>s+b.montant,0);
        const totPaye=regls.reduce((s,r)=>s+num(r.montant),0);
        const solde=totBon-totPaye;
        const bonsHtml=bonDetails.length
            ?`<div class="table-wrap"><table><thead><tr><th>Date</th><th>N° Bon</th><th>Type Règl</th><th>Échéance</th><th>Montant</th><th>Payé</th><th>Solde</th></tr></thead><tbody>${
                bonDetails.map(b=>`<tr>
                    <td>${esc(b.date)}</td><td>${esc(b.num)}</td><td>${esc(b.typeRegl)}</td><td>${esc(b.echeance)}</td>
                    <td>${fmt(b.montant)}</td><td>${fmt(b.paye)}</td><td>${fmt(b.solde)}</td>
                </tr>`).join('')
            }</tbody></table></div>`
            :'<p class="hint">Aucun bon d\'achat pour ce fournisseur.</p>';
        const reglsHtml=regls.length
            ?`<div class="table-wrap"><table><thead><tr><th>Date</th><th>Réf</th><th>Type</th><th>N° Règl</th><th>Échéance</th><th>Montant</th></tr></thead><tbody>${
                regls.map(r=>`<tr>
                    <td>${esc(r.date)}</td><td>${esc(r.ref)}</td><td>${esc(r.type)}</td>
                    <td>${esc(r.num||'—')}</td><td>${esc(r.decaiss||'—')}</td><td>${fmt(r.montant)}</td>
                </tr>`).join('')
            }</tbody></table></div>`
            :'<p class="hint">Aucun règlement pour ce fournisseur.</p>';
        const box=document.getElementById('blDetailContent');
        const overlay=document.getElementById('blDetailOverlay');
        if(!box||!overlay)return;
        box.innerHTML=`
            <div class="bl-detail-head">
                <h3>${esc(f.nom)}</h3>
                <p>${esc(f.id)}</p>
            </div>
            <div class="bl-detail-summary">
                <div class="bl-sum-item"><span>Total Bons</span><strong>${fmt(totBon)}</strong></div>
                <div class="bl-sum-item"><span>Total Payé</span><strong>${fmt(totPaye)}</strong></div>
                <div class="bl-sum-item"><span>Solde</span><strong>${fmt(solde)}</strong></div>
            </div>
            <div class="bl-detail-section">
                <h4>Bons d'achat</h4>
                ${bonsHtml}
            </div>
            <div class="bl-detail-section">
                <h4>Règlements</h4>
                ${reglsHtml}
            </div>`;
        overlay.classList.add('show');
    }

    function closeBalanceDetail(){
        document.getElementById('blDetailOverlay')?.classList.remove('show');
    }

    function bindBalanceList(){
        const tb=document.getElementById('bl_tbody');
        if(!tb||tb.dataset.bound)return;
        tb.addEventListener('dblclick',e=>{
            const row=e.target.closest('.bl-main-row');
            if(!row)return;
            openBalanceDetail(row.dataset.frnsId);
        });
        tb.dataset.bound='1';
    }

    function renderBalance(){
        const tb=document.getElementById('bl_tbody');
        const list=getBalanceRows();
        tb.innerHTML=list.length?list.map(r=>`<tr class="bl-main-row" data-frns-id="${esc(r.frnsId)}" title="Double-cliquer pour voir le détail">
            <td>${esc(r.date)}</td><td>${esc(r.frnsId)}</td><td>${esc(r.frnsNom)}</td>
            <td>${fmt(r.montantBon)}</td><td>${fmt(r.paye)}</td><td>${fmt(r.solde)}</td>
        </tr>`).join(''):'<tr class="empty-row"><td colspan="6">Aucun fournisseur trouvé.</td></tr>';
    }

    function printBalance(){
        print('bl_table','Balance fournisseurs');
    }

    function exportBalancePdf(){
        const t=document.getElementById('bl_table');
        if(!t)return;
        const clone=t.cloneNode(true);
        clone.querySelectorAll('.no-print').forEach(e=>e.remove());
        const w=window.open('','','width=1000,height=700');
        w.document.write('<!DOCTYPE html><html><head><meta charset="utf-8"><title>Balance fournisseurs</title><style>body{font-family:Arial,sans-serif;padding:24px;color:#111}h1{font-family:Georgia,serif;font-size:22px;text-align:center;margin:0 0 6px}p.sub{text-align:center;color:#555;margin:0 0 20px;font-size:13px}table{width:100%;border-collapse:collapse}th,td{border:1px solid #888;padding:8px;font-size:12px;text-align:center;vertical-align:middle}th{background:#0a1736;color:#fff}@media print{body{padding:12px}}</style></head><body><h1>Balance fournisseurs</h1><p class="sub">Al Jazeera Hotel</p>'+clone.outerHTML+'</body></html>');
        w.document.close();w.focus();setTimeout(()=>w.print(),300);
    }

    /* ---- TABLEAU DE BORD ---- */
    function renderDashboard(){
        const frns=get(K.f);
        const soldeGlobal=frns.reduce((s,f)=>s+soldeFrns(f),0);
        document.getElementById('kpiChambres').textContent='22';
        document.getElementById('kpiOccupees').textContent='0';
        document.getElementById('kpiCharges').textContent=fmtKpi(0);
        document.getElementById('kpiSoldeDu').textContent=fmtKpi(soldeGlobal);
        document.getElementById('kpiCaisse').textContent=fmtKpi(0);
    }

    /* ---- IMPRIMER / EXPORTER ---- */
    function bonFromForm(){
        const lines=readBonLines();
        if(!lines.length)return null;
        return{
            date:ajIso(document.getElementById('ba_date').value),
            num:document.getElementById('ba_num').value.trim(),
            frnsId:document.getElementById('ba_frns_id').value.trim(),
            frnsNom:document.getElementById('ba_frns_nom').value.trim(),
            typeRegl:document.getElementById('ba_type_regl').value,
            echeance:document.getElementById('ba_echeance').value,
            lines,
            total:lines.reduce((s,l)=>s+num(l.st),0)
        };
    }

    function printBon(id){
        let b=null;
        if(id)b=getBons().find(x=>x.id===id);
        else if(editBonId)b=getBons().find(x=>x.id===editBonId);
        if(!b)b=bonFromForm();
        if(!b||!(b.lines||[]).length){
            alert('Sélectionnez un bon dans la liste ou saisissez des articles à imprimer.');
            return;
        }
        const lines=b.lines||[];
        const total=num(b.total)||lines.reduce((s,l)=>s+num(l.st),0);
        const rows=lines.map(l=>`<tr>
            <td>${esc(l.ref)}</td><td>${esc(l.desig)}</td>
            <td style="text-align:center">${l.qte}</td>
            <td style="text-align:center">${fmt(l.prix)}</td>
            <td style="text-align:center">${fmt(l.st)}</td>
        </tr>`).join('');
        const info=[
            ['Date',b.date||'—'],['N° Bon',b.num||'—'],
            ['ID Fournisseur',b.frnsId||'—'],['Nom Fournisseur',b.frnsNom||frnsName(b.frnsId)],
            ['Type Règlement',b.typeRegl||'—'],['Échéance',b.echeance||'30jrs']
        ];
        const infoHtml='<table class="info">'+info.map(r=>`<tr><td>${r[0]}</td><td>${esc(r[1])}</td></tr>`).join('')+'</table>';
        const css='body{font-family:Arial,sans-serif;padding:28px;color:#111}h1{font-family:Georgia,serif;font-size:22px;text-align:center;margin:0 0 4px}.sub{text-align:center;color:#555;margin:0 0 22px;font-size:13px}.info{border-collapse:collapse;margin:0 auto 22px;width:100%;max-width:560px}.info td{border:1px solid #bbb;padding:8px 12px;font-size:13px;text-align:center}.info td:first-child{font-weight:bold;background:#0a1736;color:#fff;width:40%}table.lines{width:100%;border-collapse:collapse}table.lines th,table.lines td{border:1px solid #888;padding:9px 10px;font-size:12px;text-align:center}table.lines th{background:#0a1736;color:#fff}.total{margin-top:16px;text-align:center;font-size:16px;font-weight:bold}@media print{body{padding:12px}}';
        const w=window.open('','','width=860,height=760');
        w.document.write('<!DOCTYPE html><html><head><meta charset="utf-8"><title>Bon d\'achat '+(b.num||'')+'</title><style>'+css+'</style></head><body><h1>Bon d\'achat</h1><p class="sub">Al Jazeera Hotel</p>'+infoHtml+'<table class="lines"><thead><tr><th>Réf</th><th>Désignation</th><th>Qté</th><th>Prix U</th><th>Sous-Total</th></tr></thead><tbody>'+rows+'</tbody></table><p class="total">Total bon : '+fmt(total)+'</p></body></html>');
        w.document.close();w.focus();setTimeout(()=>w.print(),300);
    }

    function print(tableId,title){
        const t=document.getElementById(tableId).cloneNode(true);
        t.querySelectorAll('.no-print').forEach(e=>e.remove());
        const w=window.open('','','width=1000,height=700');
        w.document.write('<html><head><title>'+title+'</title><style>body{font-family:Arial;padding:24px}h2{font-family:Georgia;text-align:center}table{width:100%;border-collapse:collapse;margin-top:14px}th,td{border:1px solid #888;padding:8px;font-size:12px;text-align:center;vertical-align:middle}th{background:#0a1736;color:#fff}</style></head><body><h2>'+title+'</h2>'+t.outerHTML+'</body></html>');
        w.document.close();w.focus();setTimeout(()=>w.print(),250);
    }
    function csv(tableId,filename){
        const t=document.getElementById(tableId); const rows=[];
        t.querySelectorAll('tr').forEach(tr=>{
            const cells=[...tr.querySelectorAll('th,td')].filter(c=>!c.classList.contains('no-print'));
            if(cells.length)rows.push(cells.map(c=>'"'+c.innerText.replace(/"/g,'""')+'"').join(';'));
        });
        const blob=new Blob(["\ufeff"+rows.join('\n')],{type:'text/csv;charset=utf-8;'});
        const a=document.createElement('a');a.href=URL.createObjectURL(blob);a.download=filename;a.click();
    }

    function init(){ renderSelects(); renderFiche(); newBon(); bindBonList(); bindBalanceList(); renderBons(); renderRegls(); renderBalance(); renderDashboard(); document.getElementById('ff_id').value=nextId(); document.getElementById('ra_ref').value=nextReglRef(); syncReglTypeFields(); }

    return {init,renderSelects,renderReglBalances,renderBalance,renderDashboard,calcSolde,
        saveFiche,newFiche,edit:editFicheRow,del:delFiche,printRow,csvRow,closeFiche,
        addBonLine,saveBon,editBon,newBon,closeBon,delBon,delBonCurrent,delBonLine,syncBonFrns,printBon,
        addReglement,newReglement,closeRegl,closeBalance,delRegl,syncReglTypeFields,openBalanceDetail,closeBalanceDetail,print,csv,printBalance,exportBalancePdf};
})();

window.FRNS=FRNS;
document.getElementById('ra_frns')?.addEventListener('change',()=>FRNS.renderReglBalances());
document.getElementById('blDetailOverlay')?.addEventListener('click',e=>{if(e.target.id==='blDetailOverlay')FRNS.closeBalanceDetail();});
document.addEventListener('keydown',e=>{if(e.key==='Escape')FRNS.closeBalanceDetail();});
FRNS.init();
</script>

<script>
/* ===== Module Mouvement Stock (synchronisé bons d'achat) ===== */
const STOCK=(function(){
    const K='aj_stock_mv';
    const K_BONS='aj_bons';
    const K_ETAT='aj_stock_etat';
    const getOverrides=()=>JSON.parse(localStorage.getItem(K)||'[]');
    const setOverrides=v=>localStorage.setItem(K,JSON.stringify(v));
    const num=v=>Math.max(0,Math.floor(Number(v)||0));
    const esc=s=>{let t=s==null?'':String(s);const m=t.match(/^(\d{4})-(\d{2})-(\d{2})$/);if(m)t=m[3]+'/'+m[2]+'/'+m[1];return t.replace(/[&<>"]/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c]));};
    let editId=null;
    let etatPreview=null;

    const ETAT_LABEL={dispo:'Dispo',faible:'Faible',rupture:'Rupture'};

    function productKey(ref,desig){
        const r=(ref||'').trim().toLowerCase();
        const d=(desig||'').trim().toLowerCase();
        if(!r&&!d)return '';
        return r+'|'+d;
    }

    function matchProduct(ref,desig,ref2,desig2){
        const k1=productKey(ref,desig);
        const k2=productKey(ref2,desig2);
        if(k1&&k2&&k1===k2)return true;
        const r=(ref||'').trim().toLowerCase();
        const r2=(ref2||'').trim().toLowerCase();
        if(r&&r2&&r===r2)return true;
        const d=(desig||'').trim().toLowerCase();
        const d2=(desig2||'').trim().toLowerCase();
        return !!(d&&d2&&d===d2);
    }

    function totalEtatDemand(ref,desig,opts={}){
        const excludeId=opts.excludeId;
        const previewQte=opts.previewQte!=null?num(opts.previewQte):null;
        const list=JSON.parse(localStorage.getItem(K_ETAT)||'[]');
        let total=0;
        let previewApplied=false;
        list.forEach(e=>{
            if(!matchProduct(e.ref,e.desig,ref,desig))return;
            if(excludeId&&e.id===excludeId){
                if(previewQte!=null){total+=previewQte;previewApplied=true;}
                return;
            }
            total+=num(e.qteDemandee);
        });
        if(previewQte!=null&&!excludeId&&!previewApplied)total+=previewQte;
        return total;
    }

    function getEtatOptsForProduct(ref,desig){
        if(!etatPreview)return{};
        if(!matchProduct(ref,desig,etatPreview.ref,etatPreview.desig))return{};
        return{excludeId:etatPreview.excludeId,previewQte:etatPreview.previewQte};
    }

    function setEtatPreview(p){
        etatPreview=p||null;
        render();
    }

    function readBonsForStock(){
        let list=JSON.parse(localStorage.getItem(K_BONS)||'[]');
        if(!list.length)return [];
        if(!list[0].lines){
            list=list.map(b=>({
                date:b.date,
                lines:[{ref:'',desig:b.desig||'',qte:num(b.qte)}]
            }));
        }
        return list;
    }

    function buildFromBons(){
        const overrides={};
        getOverrides().forEach(o=>{
            const key=o.productKey||o.id;
            if(key)overrides[key]=o;
        });
        const map=new Map();
        readBonsForStock().forEach(bon=>{
            (bon.lines||[]).forEach(line=>{
                const ref=(line.ref||'').trim();
                const desig=(line.desig||'').trim();
                if(!ref&&!desig)return;
                const key=productKey(ref,desig);
                const cur=map.get(key)||{productKey:key,ref,desig,stockInitial:0,dateAchat:''};
                cur.stockInitial+=num(line.qte);
                if(bon.date&&(!cur.dateAchat||bon.date<cur.dateAchat))cur.dateAchat=bon.date;
                map.set(key,cur);
            });
        });
        return[...map.values()].map(p=>{
            const ov=overrides[p.productKey]||{};
            return enrich({
                id:p.productKey,
                productKey:p.productKey,
                dateAchat:p.dateAchat,
                ref:p.ref,
                desig:p.desig,
                stockInitial:p.stockInitial,
                sortieJour:ov.sortieJour!=null?ov.sortieJour:0,
                statut:ov.statut||'actif'
            });
        });
    }

    function calcStock(init,sortie){return Math.max(0,num(init)-num(sortie));}
    function calcEtat(init,stock){
        if(stock<=0)return'rupture';
        if(num(init)>0&&stock<=Math.max(1,Math.ceil(num(init)*0.25)))return'faible';
        if(num(init)===0&&stock<=5)return'faible';
        return'dispo';
    }
    function enrich(row){
        const stockInitial=num(row.stockInitial);
        const sortieJour=num(row.sortieJour);
        const etatDemand=totalEtatDemand(row.ref,row.desig,getEtatOptsForProduct(row.ref,row.desig));
        const produitStock=calcStock(stockInitial,sortieJour+etatDemand);
        const etat=calcEtat(stockInitial,produitStock);
        return{...row,stockInitial,sortieJour,etatDemand,produitStock,etat};
    }
    function etatBadge(etat){return`<span class="st-etat ${etat}">${ETAT_LABEL[etat]||etat}</span>`;}
    function statutBadge(s){return`<span class="st-statut ${s}">${s==='inactif'?'Inactif':'Actif'}</span>`;}

    function previewCalc(){
        const init=num(document.getElementById('sm_init')?.value);
        const sortie=num(document.getElementById('sm_sortie')?.value);
        const stock=calcStock(init,sortie);
        const etat=calcEtat(init,stock);
        const stockEl=document.getElementById('sm_preview_stock');
        const etatEl=document.getElementById('sm_preview_etat');
        if(stockEl)stockEl.value=stock;
        if(etatEl)etatEl.innerHTML=etatBadge(etat);
    }

    function newItem(){
        editId=null;
        ['sm_date','sm_ref','sm_desig','sm_init','sm_sortie'].forEach(id=>{const el=document.getElementById(id);if(el)el.value='';});
        if(document.getElementById('sm_statut'))document.getElementById('sm_statut').value='actif';
        const etatEl=document.getElementById('sm_preview_etat');
        if(etatEl)etatEl.textContent='—';
        if(document.getElementById('sm_preview_stock'))document.getElementById('sm_preview_stock').value='0';
        render();
    }

    function save(){
        if(!editId){alert('Sélectionnez un produit dans la liste (issu d\'un bon d\'achat).');return;}
        const row=buildFromBons().find(x=>x.id===editId);
        if(!row){alert('Ce produit n\'existe plus dans les bons d\'achat.');newItem();return;}
        const entry={
            productKey:editId,
            sortieJour:document.getElementById('sm_sortie').value,
            statut:document.getElementById('sm_statut').value||'actif'
        };
        let list=getOverrides();
        const i=list.findIndex(x=>(x.productKey||x.id)===editId);
        if(i>-1)list[i]=entry;else list.push(entry);
        setOverrides(list);
        editId=null;
        newItem();
        alert('Mouvement enregistré.');
    }

    function edit(id){
        const row=buildFromBons().find(x=>x.id===id);
        if(!row)return;
        editId=id;
        document.getElementById('sm_date').value=ajDate(row.dateAchat||'');
        document.getElementById('sm_ref').value=row.ref||'';
        document.getElementById('sm_desig').value=row.desig||'';
        document.getElementById('sm_init').value=row.stockInitial;
        document.getElementById('sm_sortie').value=row.sortieJour;
        document.getElementById('sm_statut').value=row.statut||'actif';
        previewCalc();
        render();
        document.querySelector('#stock-mouvement .block')?.scrollIntoView({behavior:'smooth',block:'start'});
    }

    function bindList(){
        const tb=document.getElementById('sm_tbody');
        if(!tb||tb.dataset.bound)return;
        tb.addEventListener('click',e=>{
            const row=e.target.closest('.sm-row');
            if(!row||e.target.closest('button'))return;
            edit(row.dataset.id);
        });
        tb.dataset.bound='1';
    }

    function render(){
        const tb=document.getElementById('sm_tbody');
        if(!tb)return;
        const list=buildFromBons().sort((a,b)=>(a.ref||a.desig||'').localeCompare(b.ref||b.desig||'','fr'));
        tb.innerHTML=list.length?list.map(r=>{
            const sel=editId===r.id?' selected':'';
            return `<tr class="sm-row${sel}" data-id="${esc(r.id)}" title="Cliquer pour saisir sortie/jour et statut">
            <td>${esc(r.dateAchat||'—')}</td>
            <td>${esc(r.ref||'—')}</td><td>${esc(r.desig)}</td>
            <td>${r.stockInitial}</td><td>${r.sortieJour}</td><td>${r.produitStock}</td>
            <td>${statutBadge(r.statut)}</td>
            <td>${etatBadge(r.etat)}</td>
            <td class="no-print" onclick="event.stopPropagation()">
                <button type="button" class="tbtn" onclick="STOCK.edit(${JSON.stringify(r.id)})">Modifier</button>
            </td>
        </tr>`;
        }).join(''):'<tr class="empty-row"><td colspan="9">Aucun produit. Saisissez des articles dans les bons d\'achat.</td></tr>';
        bindList();
    }

    function syncFromBons(){
        if(editId&&!buildFromBons().find(x=>x.id===editId))newItem();
        else render();
    }

    function getStockQty(ref,desig){
        const r=(ref||'').trim().toLowerCase();
        const d=(desig||'').trim().toLowerCase();
        const list=buildFromBons();
        let row=list.find(x=>x.productKey===r+'|'+d);
        if(!row&&r)row=list.find(x=>(x.ref||'').trim().toLowerCase()===r);
        if(!row&&d)row=list.find(x=>(x.desig||'').trim().toLowerCase()===d);
        return row?row.produitStock:0;
    }

    function printDoc(){
        const t=document.getElementById('sm_table');
        if(!t)return;
        const clone=t.cloneNode(true);
        clone.querySelectorAll('.no-print').forEach(e=>e.remove());
        const w=window.open('','','width=1100,height=760');
        w.document.write('<!DOCTYPE html><html><head><meta charset="utf-8"><title>Mouvement stock</title><style>body{font-family:Arial,sans-serif;padding:24px;color:#111}h1{font-family:Georgia,serif;font-size:22px;text-align:center;margin:0 0 6px}p.sub{text-align:center;color:#555;margin:0 0 20px;font-size:13px}table{width:100%;border-collapse:collapse}th,td{border:1px solid #888;padding:8px;font-size:11px;text-align:center;vertical-align:middle}th{background:#0a1736;color:#fff}.st-etat.dispo{color:#1a7a3a;font-weight:bold}.st-etat.faible{color:#b8860b;font-weight:bold}.st-etat.rupture{color:#c0392b;font-weight:bold}@media print{body{padding:12px}}</style></head><body><h1>Mouvement stock</h1><p class="sub">Al Jazeera Hotel — issu des bons d\'achat</p>'+clone.outerHTML+'</body></html>');
        w.document.close();w.focus();setTimeout(()=>w.print(),300);
    }
    function exportPdf(){printDoc();}

    function init(){newItem();}
    return{init,render,syncFromBons,setEtatPreview,save,newItem,edit,previewCalc,getStockQty,print:printDoc,exportPdf};
})();
window.STOCK=STOCK;
STOCK.init();
</script>

<script>
/* ===== Module État Produit ===== */
const ETAT=(function(){
    const K='aj_stock_etat';
    const K_BONS='aj_bons';
    const get=()=>JSON.parse(localStorage.getItem(K)||'[]');
    const set=v=>localStorage.setItem(K,JSON.stringify(v));
    const uid=()=>Date.now().toString(36)+Math.random().toString(36).slice(2,6);
    const num=v=>Math.max(0,Math.floor(Number(v)||0));
    const esc=s=>{let t=s==null?'':String(s);const m=t.match(/^(\d{4})-(\d{2})-(\d{2})$/);if(m)t=m[3]+'/'+m[2]+'/'+m[1];return t.replace(/[&<>"]/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c]));};
    let editId=null;

    function nextNum(){
        const nums=get().map(r=>{const m=/(\d+)/.exec(r.numEtat||'');return m?parseInt(m[1],10):0;});
        const max=nums.length?Math.max(...nums):0;
        return 'EP'+String(max+1).padStart(4,'0');
    }

    function getProductsFromBons(){
        const map=new Map();
        let list=JSON.parse(localStorage.getItem(K_BONS)||'[]');
        if(!list.length)return map;
        if(!list[0].lines){
            list=list.map(b=>({lines:[{ref:'',desig:b.desig||'',qte:num(b.qte)}]}));
        }
        list.forEach(bon=>{
            (bon.lines||[]).forEach(line=>{
                const ref=(line.ref||'').trim();
                const desig=(line.desig||'').trim();
                if(!ref&&!desig)return;
                const key=ref.toLowerCase()||desig.toLowerCase();
                if(!map.has(key))map.set(key,{ref,desig});
            });
        });
        return map;
    }

    function renderRefList(){
        const dl=document.getElementById('ep_ref_list');
        if(!dl)return;
        const prods=[...getProductsFromBons().values()];
        dl.innerHTML=prods.map(p=>`<option value="${esc(p.ref)}">${esc(p.desig)}</option>`).join('');
    }

    function syncProduct(){
        const ref=document.getElementById('ep_ref')?.value.trim();
        const desigEl=document.getElementById('ep_desig');
        const stockEl=document.getElementById('ep_stock');
        const qteEl=document.getElementById('ep_qte');
        if(ref&&desigEl){
            const refLow=ref.toLowerCase();
            for(const p of getProductsFromBons().values()){
                if((p.ref||'').trim().toLowerCase()===refLow){
                    desigEl.value=p.desig||'';
                    break;
                }
            }
        }
        const desig=desigEl?.value||'';
        const demandee=num(qteEl?.value);
        if(typeof STOCK!=='undefined'){
            STOCK.setEtatPreview({ref,desig,excludeId:editId,previewQte:demandee});
            if(stockEl)stockEl.value=STOCK.getStockQty(ref,desig);
        }else if(stockEl)stockEl.value=0;
    }

    function updateFormUI(){
        const delBtn=document.getElementById('ep_del_btn');
        const saveBtn=document.getElementById('ep_save_btn');
        if(editId){
            if(delBtn)delBtn.style.display='';
            if(saveBtn)saveBtn.textContent='Enregistrer';
        }else{
            if(delBtn)delBtn.style.display='none';
            if(saveBtn)saveBtn.textContent='Valider';
        }
    }

    function newItem(){
        editId=null;
        const today=new Date().toISOString().slice(0,10);
        if(document.getElementById('ep_date'))document.getElementById('ep_date').value=ajDate(today);
        if(document.getElementById('ep_num'))document.getElementById('ep_num').value=nextNum();
        ['ep_ref','ep_desig','ep_qte','ep_dest','ep_charge'].forEach(id=>{const el=document.getElementById(id);if(el)el.value='';});
        if(document.getElementById('ep_stock'))document.getElementById('ep_stock').value='0';
        if(typeof STOCK!=='undefined')STOCK.setEtatPreview(null);
        updateFormUI();
        render();
    }

    function save(){
        const desig=document.getElementById('ep_desig').value.trim();
        const ref=document.getElementById('ep_ref').value.trim();
        if(!desig&&!ref){alert('Saisissez la référence ou la désignation du produit.');return;}
        let numEtat=document.getElementById('ep_num').value.trim();
        if(!numEtat)numEtat=nextNum();
        const data={
            id:editId||uid(),
            date:ajIso(document.getElementById('ep_date').value),
            numEtat,
            ref,
            desig,
            qteDemandee:num(document.getElementById('ep_qte').value),
            destination:document.getElementById('ep_dest').value.trim(),
            charge:document.getElementById('ep_charge').value.trim()
        };
        let list=get();
        if(editId){
            const i=list.findIndex(x=>x.id===editId);
            if(i>-1)list[i]=data;
        }else list.push(data);
        set(list);
        const wasEdit=!!editId;
        editId=null;
        if(typeof STOCK!=='undefined')STOCK.setEtatPreview(null);
        newItem();
        alert(wasEdit?'État produit mis à jour.':'État produit enregistré.');
    }

    function edit(id){
        const row=get().find(x=>x.id===id);
        if(!row)return;
        editId=id;
        document.getElementById('ep_date').value=ajDate(row.date||'');
        document.getElementById('ep_num').value=row.numEtat||'';
        document.getElementById('ep_ref').value=row.ref||'';
        document.getElementById('ep_desig').value=row.desig||'';
        document.getElementById('ep_qte').value=row.qteDemandee!=null?row.qteDemandee:'';
        document.getElementById('ep_dest').value=row.destination||'';
        document.getElementById('ep_charge').value=row.charge||'';
        syncProduct();
        updateFormUI();
        render();
        document.querySelector('#stock-etat .block')?.scrollIntoView({behavior:'smooth',block:'start'});
    }

    function del(id){
        if(!confirm('Supprimer cet état produit ?'))return;
        set(get().filter(x=>x.id!==id));
        if(editId===id)editId=null;
        if(typeof STOCK!=='undefined')STOCK.setEtatPreview(null);
        newItem();
    }
    function delCurrent(){if(editId)del(editId);}

    function bindList(){
        const tb=document.getElementById('ep_tbody');
        if(!tb||tb.dataset.bound)return;
        tb.addEventListener('click',e=>{
            const row=e.target.closest('.ep-row');
            if(!row||e.target.closest('button'))return;
            edit(row.dataset.id);
        });
        tb.dataset.bound='1';
    }

    function render(){
        renderRefList();
        const tb=document.getElementById('ep_tbody');
        if(!tb)return;
        const list=get().sort((a,b)=>(b.date||'').localeCompare(a.date||'')||(b.numEtat||'').localeCompare(a.numEtat||''));
        tb.innerHTML=list.length?list.map(r=>{
            const sel=editId===r.id?' selected':'';
            return `<tr class="ep-row${sel}" data-id="${esc(r.id)}" title="Cliquer pour modifier">
                <td>${esc(r.date||'—')}</td>
                <td>${esc(r.numEtat)}</td>
                <td>${esc(r.desig||'—')}</td>
                <td>${r.qteDemandee!=null?r.qteDemandee:0}</td>
                <td>${esc(r.charge||'—')}</td>
                <td class="no-print" onclick="event.stopPropagation()">
                    <button type="button" class="tbtn" onclick="ETAT.edit(${JSON.stringify(r.id)})">Modifier</button>
                    <button type="button" class="tbtn" onclick="ETAT.printRow(${JSON.stringify(r.id)})">Imprimer</button>
                    <button type="button" class="tbtn" onclick="ETAT.exportRowPdf(${JSON.stringify(r.id)})">PDF</button>
                </td>
            </tr>`;
        }).join(''):'<tr class="empty-row"><td colspan="6">Aucun état produit enregistré.</td></tr>';
        bindList();
    }

    function rowPrintHtml(r){
        const rows=[
            ['Date',r.date||'—'],['N° État',r.numEtat||'—'],
            ['Réf produit',r.ref||'—'],['Désignation',r.desig||'—'],
            ['Qté demandée',r.qteDemandee!=null?r.qteDemandee:0],
            ['Destination',r.destination||'—'],['Chargé',r.charge||'—']
        ];
        return '<table class="info"><tbody>'+rows.map(x=>`<tr><td>${esc(x[0])}</td><td>${esc(x[1])}</td></tr>`).join('')+'</tbody></table>';
    }

    function printRow(id){
        const r=get().find(x=>x.id===id);
        if(!r)return;
        const css='body{font-family:Arial,sans-serif;padding:28px;color:#111}h1{font-family:Georgia,serif;font-size:22px;text-align:center;margin:0 0 4px}.sub{text-align:center;color:#555;margin:0 0 22px;font-size:13px}.info{width:100%;max-width:560px;margin:0 auto;border-collapse:collapse}.info td{border:1px solid #bbb;padding:9px 12px;font-size:13px;text-align:center}.info td:first-child{font-weight:bold;background:#0a1736;color:#fff;width:40%}@media print{body{padding:12px}}';
        const w=window.open('','','width=720,height=640');
        w.document.write('<!DOCTYPE html><html><head><meta charset="utf-8"><title>État produit '+esc(r.numEtat)+'</title><style>'+css+'</style></head><body><h1>État produit</h1><p class="sub">Al Jazeera Hotel</p>'+rowPrintHtml(r)+'</body></html>');
        w.document.close();w.focus();setTimeout(()=>w.print(),300);
    }
    function exportRowPdf(id){printRow(id);}

    function init(){newItem();render();}
    return{init,render,save,newItem,edit,del,delCurrent,syncProduct,printRow,exportRowPdf};
})();
window.ETAT=ETAT;
ETAT.init();
</script>

<script>window.AJ_HOTEL_DEFAULTS=@json(config('hotel_rooms'));</script>
<script src="{{ asset('js/hotel-content.js') }}?v={{ filemtime(public_path('js/hotel-content.js')) }}"></script>
<script>
/* ===== Liste du personnel (source de la fiche Utilisateur) ===== */
const PERS=(function(){
    const K='aj_pers';
    const esc=s=>{let t=s==null?'':String(s);const m=t.match(/^(\d{4})-(\d{2})-(\d{2})$/);if(m)t=m[3]+'/'+m[2]+'/'+m[1];return t.replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));};
    const load=()=>{try{return JSON.parse(localStorage.getItem(K)||'[]')||[];}catch(e){return[];}};
    const store=list=>localStorage.setItem(K,JSON.stringify(list));
    const today=()=>new Date().toISOString().slice(0,10);
    const val=id=>document.getElementById(id)?.value.trim()||'';
    const money=v=>{const n=Number(v);return v===''||v==null||Number.isNaN(n)?'—':ajMoney(n);};
    let editId=null, cinCopy=null, dipCopy=null, photoCopy=null;
    function nextId(list){
        let max=0;
        list.forEach(p=>{const m=String(p.id||'').match(/^Pe(\d+)$/i);if(m)max=Math.max(max,parseInt(m[1],10));});
        return 'Pe'+String(max+1).padStart(4,'0');
    }
    function overlay(){return document.getElementById('peModalOverlay');}
    function viewOverlay(){return document.getElementById('peViewOverlay');}
    function close(){editId=null;overlay()?.classList.remove('show');}
    function closeView(){viewOverlay()?.classList.remove('show');}
    const copyPh='<span class="pe-copy-ph"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M12 16V6M8 9l4-4 4 4"/><path d="M4 16.5V18a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-1.5"/></svg><em>Importer</em></span>';
    const photoPh='<span class="pe-copy-ph"><svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><circle cx="12" cy="8" r="3.2"/><path d="M5 19.2c1.4-2.8 3.6-4.2 7-4.2s5.6 1.4 7 4.2"/></svg><em>Photo</em></span>';
    function paintCopy(cardId,previewId,nameId,file,emptyLabel,emptyHtml){
        const card=document.getElementById(cardId);
        const preview=document.getElementById(previewId);
        const name=document.getElementById(nameId);
        if(card)card.classList.toggle('has-file',!!file?.data);
        if(name)name.textContent=file?.name||emptyLabel||'Importer une image ou un PDF';
        if(!preview)return;
        if(file?.data&&String(file.type||'').startsWith('image/')) preview.innerHTML=`<img src="${file.data}" alt="">`;
        else if(file?.data) preview.innerHTML='<span class="pe-copy-pdf">PDF</span>';
        else preview.innerHTML=emptyHtml||copyPh;
    }
    function setCopyLabels(){
        paintCopy('pePhotoCard','pePhotoPreview','pePhotoName',photoCopy,'Importer une photo',photoPh);
        paintCopy('peCinCard','peCinPreview','peCinName',cinCopy);
        paintCopy('peDipCard','peDipPreview','peDipName',dipCopy);
    }
    function readCopy(file){
        return new Promise((resolve,reject)=>{
            if(!file){resolve(null);return;}
            if(file.size>8*1024*1024){reject(new Error('Fichier trop lourd (8 Mo maximum).'));return;}
            if(file.type.startsWith('image/')){
                const img=new Image();
                const url=URL.createObjectURL(file);
                img.onload=()=>{
                    const max=1400, scale=Math.min(1,max/Math.max(img.width,img.height));
                    const canvas=document.createElement('canvas');
                    canvas.width=Math.max(1,Math.round(img.width*scale));
                    canvas.height=Math.max(1,Math.round(img.height*scale));
                    canvas.getContext('2d').drawImage(img,0,0,canvas.width,canvas.height);
                    URL.revokeObjectURL(url);
                    resolve({name:file.name,type:'image/jpeg',data:canvas.toDataURL('image/jpeg',0.72)});
                };
                img.onerror=()=>{URL.revokeObjectURL(url);reject(new Error('Image illisible.'));};
                img.src=url;
                return;
            }
            const reader=new FileReader();
            reader.onload=()=>resolve({name:file.name,type:file.type||'application/pdf',data:reader.result});
            reader.onerror=()=>reject(new Error('Lecture impossible.'));
            reader.readAsDataURL(file);
        });
    }
    function bindImport(btnId,fileId,assign){
        document.getElementById(btnId)?.addEventListener('click',()=>document.getElementById(fileId)?.click());
        document.getElementById(fileId)?.addEventListener('change',async e=>{
            const file=e.target.files?.[0];
            e.target.value='';
            if(!file)return;
            try{ assign(await readCopy(file)); setCopyLabels(); }
            catch(err){ alert(err.message||'Import impossible.'); }
        });
    }
    function docHtml(file,title){
        const body=!file?.data
            ? '<p class="pe-copy-empty">Aucune copie importée.</p>'
            : String(file.type||'').startsWith('image/')
                ? `<img src="${file.data}" alt="${esc(title)}">`
                : `<iframe src="${file.data}" title="${esc(title)}"></iframe>`;
        const sub=file?.name?`<div class="pe-copy-name" style="padding:0 12px 12px">${esc(file.name)}</div>`:'';
        return `<article class="pe-copy"><div class="pe-copy-head">${esc(title)}</div><div class="pe-copy-frame">${body}</div>${sub}</article>`;
    }
    function show(person){
        if(!person)return;
        document.getElementById('peViewTitle').textContent=person.nom||'Fiche personnel';
        document.getElementById('peViewSub').textContent=(person.id||'')+(person.profil?' · '+person.profil:'');
        const rows=[
            ['Nom complet',person.nom],['CIN N°',person.cin],
            ['Ville',person.ville],['Adresse',person.adresse],['N° mobile / WhatsApp',person.mobile],['Formation',person.formation],['Section',person.section],
            ['Profil',person.profil],['Type contrat',person.contrat],['Rémunération',person.remu!==''&&person.remu!=null?money(person.remu):''],
            ['Date début',person.debut],['Date fin',person.fin]
        ];
        document.getElementById('peViewInfo').innerHTML=rows.map(([k,v])=>`<div><b>${esc(k)}</b><span>${esc(v||'—')}</span></div>`).join('');
        const photoBox=document.getElementById('peViewPhoto');
        if(photoBox)photoBox.innerHTML=`<div class="pe-photo-wrap"><article class="pe-copy pe-photo"><div class="pe-copy-head">Photo</div><div class="pe-copy-frame pe-photo-frame">${person.photo?.data?`<img src="${person.photo.data}" alt="Photo">`:'<p class="pe-copy-empty">Aucune photo</p>'}</div></article><div class="pe-photo-side"><div><b>Date</b><span>${esc(person.date||'—')}</span></div><div><b>ID</b><span>${esc(person.id||'—')}</span></div></div></div>`;
        document.getElementById('peViewDocs').innerHTML=docHtml(person.cinCopy,'Copie CIN')+docHtml(person.dipCopy,'Copie diplôme');
        viewOverlay()?.classList.add('show');
    }
    function open(person){
        editId=person?.id||null;
        const list=load();
        document.getElementById('pe_date').value=ajDate(person?.date||today());
        document.getElementById('pe_id').value=person?.id||nextId(list);
        document.getElementById('pe_nom').value=person?.nom||'';
        document.getElementById('pe_cin').value=person?.cin||'';
        document.getElementById('pe_ville').value=person?.ville||'';
        document.getElementById('pe_adresse').value=person?.adresse||'';
        document.getElementById('pe_mobile').value=person?.mobile||'';
        document.getElementById('pe_formation').value=person?.formation||'';
        document.getElementById('pe_section').value=person?.section||'';
        document.getElementById('pe_profil').value=person?.profil||'';
        document.getElementById('pe_contrat').value=person?.contrat||'';
        document.getElementById('pe_remu').value=person?.remu!==''&&person?.remu!=null?Number(person.remu).toFixed(2):'';
        document.getElementById('pe_debut').value=ajDate(person?.debut||'');
        document.getElementById('pe_fin').value=ajDate(person?.fin||'');
        photoCopy=person?.photo||null;
        cinCopy=person?.cinCopy||null;
        dipCopy=person?.dipCopy||null;
        setCopyLabels();
        overlay()?.classList.add('show');
        document.getElementById('pe_nom')?.focus();
    }
    function render(){
        const tb=document.getElementById('pe_tbody');
        if(!tb)return;
        const list=load();
        const cell=v=>esc(v||'—');
        tb.innerHTML=list.length?list.map(p=>`<tr>
            <td>${cell(p.date)}</td><td>${cell(p.id)}</td><td>${cell(p.nom)}</td><td>${cell(p.cin)}</td>
            <td>${cell(p.ville)}</td><td>${cell(p.adresse)}</td><td>${cell(p.mobile)}</td><td>${cell(p.formation)}</td><td>${cell(p.section)}</td>
            <td>${cell(p.profil)}</td><td>${cell(p.contrat)}</td><td>${money(p.remu)}</td>
            <td>${cell(p.debut)}</td><td>${cell(p.fin)}</td>
            <td class="no-print">
                <button type="button" class="ibtn" title="Voir" data-pe-view="${esc(p.id)}">&#128065;</button>
                <button type="button" class="ibtn" title="Modifier" data-pe-edit="${esc(p.id)}">&#9998;</button>
                <button type="button" class="ibtn del" title="Supprimer" data-pe-del="${esc(p.id)}">&#128465;</button>
            </td>
        </tr>`).join(''):'<tr class="empty-row"><td colspan="15">Aucun employé. Cliquez sur Ajouter.</td></tr>';
    }
    function save(){
        const data={
            date:ajIso(val('pe_date'))||today(),
            id:val('pe_id'),
            nom:val('pe_nom'),
            cin:val('pe_cin'),
            ville:val('pe_ville'),
            adresse:val('pe_adresse'),
            mobile:val('pe_mobile'),
            formation:val('pe_formation'),
            section:document.getElementById('pe_section')?.value||'',
            profil:document.getElementById('pe_profil')?.value||'',
            contrat:document.getElementById('pe_contrat')?.value||'',
            remu:val('pe_remu')===''?'':Number(String(val('pe_remu')).replace(',','.')).toFixed(2),
            debut:ajIso(val('pe_debut')),
            fin:ajIso(val('pe_fin'))
        };
        if(val('pe_date')&&!ajIso(val('pe_date'))){alert('Date invalide. Saisissez jj/mm/aaaa.');return;}
        if(val('pe_debut')&&!data.debut){alert('Date début invalide. Saisissez jj/mm/aaaa.');return;}
        if(val('pe_fin')&&!data.fin){alert('Date fin invalide. Saisissez jj/mm/aaaa.');return;}
        if(!data.nom){alert('Le nom complet est obligatoire.');return;}
        if(!data.profil){alert('Le profil est obligatoire.');return;}
        if(data.remu==='NaN'){alert('Rémunération invalide.');return;}
        if(data.debut&&data.fin&&data.fin<data.debut){alert('La date de fin doit être après la date de début.');return;}
        const list=load();
        if(editId){
            const i=list.findIndex(p=>p.id===editId);
            if(i>=0)list[i]={...list[i],...data,id:editId,photo:photoCopy,cinCopy,dipCopy};
        }else{
            if(!data.id)data.id=nextId(list);
            if(list.some(p=>p.id===data.id)){alert('Cet ID existe déjà.');return;}
            list.push({...data,photo:photoCopy,cinCopy,dipCopy});
        }
        try{ store(list); }
        catch(e){ alert('Les copies sont trop volumineuses pour ce navigateur. Importez des fichiers plus légers.'); return; }
        render();
        window.CFG?.refreshUserSources?.();
        close();
    }
    function init(){
        render();
        document.getElementById('pe_remu')?.addEventListener('blur',()=>{
            const el=document.getElementById('pe_remu');
            if(!el||!el.value.trim())return;
            const n=Number(el.value.replace(',','.'));
            el.value=Number.isNaN(n)?'':n.toFixed(2);
        });
        bindImport('pePhotoBtn','pePhotoFile',file=>{
            if(file&&!String(file.type||'').startsWith('image/')){alert('La photo doit être une image.');return;}
            photoCopy=file;
        });
        bindImport('peCinBtn','peCinFile',file=>{cinCopy=file;});
        bindImport('peDipBtn','peDipFile',file=>{dipCopy=file;});
        document.getElementById('peAdd')?.addEventListener('click',()=>open(null));
        document.getElementById('peSave')?.addEventListener('click',save);
        document.getElementById('peCancel')?.addEventListener('click',close);
        document.getElementById('peClose')?.addEventListener('click',close);
        document.getElementById('peViewClose')?.addEventListener('click',closeView);
        document.getElementById('peViewCancel')?.addEventListener('click',closeView);
        overlay()?.addEventListener('click',e=>{if(e.target===overlay())close();});
        viewOverlay()?.addEventListener('click',e=>{if(e.target===viewOverlay())closeView();});
        document.addEventListener('keydown',e=>{
            if(e.key!=='Escape')return;
            if(viewOverlay()?.classList.contains('show')){closeView();return;}
            if(overlay()?.classList.contains('show'))close();
        });
        document.getElementById('pe_tbody')?.addEventListener('click',e=>{
            const view=e.target.closest('[data-pe-view]');
            const edit=e.target.closest('[data-pe-edit]');
            const del=e.target.closest('[data-pe-del]');
            const list=load();
            if(view){
                const p=list.find(x=>x.id===view.dataset.peView);
                if(p)show(p);
            }
            if(edit){
                const p=list.find(x=>x.id===edit.dataset.peEdit);
                if(p)open(p);
            }
            if(del){
                if(!confirm('Retirer cet employé de la liste ?'))return;
                store(list.filter(x=>x.id!==del.dataset.peDel));
                if(editId===del.dataset.peDel)close();
                render();
                window.CFG?.refreshUserSources?.();
            }
        });
    }
    return{list:load,render,init};
})();
window.PERS=PERS;
</script>
<script>
/* ===== Module Configuration ===== */
window.AJ_HABILLAGE=@json($habillage ?? null);
const CFG=(function(){
    const K_HOTEL='aj_cfg_hotel';
    let carTab='suite';
    const PERMS=['saisir','modifier','supprimer','imprimer','voir'];
    const PERM_HINT={saisir:'Créer / ajouter',modifier:'Éditer les fiches',supprimer:'Retirer des données',imprimer:'Imprimer / PDF',voir:'Accès en lecture'};
    const MENUS=[
        {id:'dashboard',label:'Tableau de bord',section:'Pilotage',hint:'Vue synthétique de l’activité'},
        {id:'dash-cartes',label:'Cartes analytiques',section:'Tableau de bord',hint:'Indicateurs KPI'},
        {id:'dash-tableaux',label:'Tableaux',section:'Tableau de bord',hint:'Synthèses tabulaires'},
        {id:'dash-rooms',label:'Cadres chambres',section:'Tableau de bord',hint:'Aperçu visuel des chambres'},
        {id:'ch-reservations',label:'Réservations',section:'Pilotage',hint:'Liste et suivi des réservations'},
        {id:'ch-occupees',label:'C-Occupées',section:'Pilotage',hint:'Chambres actuellement occupées'},
        {id:'fiche',label:'Fiche fournisseur',section:'Achats & Stock',hint:'Fiches fournisseurs'},
        {id:'bon',label:'Bon Achats',section:'Achats & Stock',hint:'Bons de commande / achat'},
        {id:'regl',label:'Règlement Achats',section:'Achats & Stock',hint:'Paiements fournisseurs'},
        {id:'balance',label:'Balance',section:'Achats & Stock',hint:'Soldes achats'},
        {id:'stock-mouvement',label:'Mouvement Stock',section:'Achats & Stock',hint:'Entrées / sorties stock'},
        {id:'stock-etat',label:'Etat Produit',section:'Achats & Stock',hint:'État des produits'},
        {id:'stock-fiscal',label:'Stock Fiscal',section:'Achats & Stock',hint:'Stock à valeur fiscale'},
        {id:'fact-frns',label:'Facture Fournisseur',section:'Facturation',hint:'Factures reçues'},
        {id:'regl-frns',label:'Règl Fournisseur',section:'Facturation',hint:'Règlements fournisseurs'},
        {id:'releve-frns',label:'Relevé Compte Frns',section:'Facturation',hint:'Relevé compte fournisseur'},
        {id:'fact-clt',label:'Facture client',section:'Facturation',hint:'Factures clients'},
        {id:'regl-clt',label:'Règl Client',section:'Facturation',hint:'Encaissements clients'},
        {id:'releve-clt',label:'Relevé Compte Clt',section:'Facturation',hint:'Relevé compte client'},
        {id:'adm-balance-clients',label:'Balance Clients',section:'Administration',hint:'Soldes clients'},
        {id:'adm-balance-paiement',label:'Balance Paiement',section:'Administration',hint:'Suivi des encaissements'},
        {id:'adm-archive',label:'Archive',section:'Administration',hint:'Archives documentaires'},
        {id:'adm-chambres',label:'Gestion Chambres',section:'Administration',hint:'Administration du parc'},
        {id:'ch-etat',label:'Chambres',section:'Hébergement',hint:'État opérationnel des chambres'},
        {id:'ch-etages',label:'Étages',section:'Hébergement',hint:'Organisation par étage'},
        {id:'ch-dispo',label:'Config Chambres',section:'Hébergement',hint:'Paramétrage chambres'},
        {id:'ch-calendrier',label:'Calendrier',section:'Pilotage',hint:'Planning d’occupation'},
        {id:'pers-fiche',label:'Fiche Personnel',section:'Exploitation',hint:'Dossiers du personnel'},
        {id:'pers-taches',label:'Gestion des Taches',section:'Exploitation',hint:'Affectation des tâches'},
        {id:'pers-suivi',label:'Suivi Journalier',section:'Exploitation',hint:'Suivi quotidien'},
        {id:'pers-paiement',label:'Etat Paiement',section:'Exploitation',hint:'Paiements du personnel'},
        {id:'mon-caisse',label:'Caisse',section:'Finance',hint:'Mouvements de caisse'},
        {id:'mon-tresorerie',label:'Trésorerie',section:'Finance',hint:'Suivi trésorerie'},
        {id:'mon-salaires',label:'Salaires',section:'Finance',hint:'Paie et salaires'},
        {id:'mon-charges',label:'Charges',section:'Finance',hint:'Charges d’exploitation'},
        {id:'cfg-hotel',label:'Fiche hôtel',section:'Système',hint:'Identité et contacts hôtel'},
        {id:'cfg-carrousel',label:'Carrousel',section:'Système',hint:'Photos du site'},
        {id:'cfg-habillage',label:'Habillage',section:'Système',hint:'Apparence du site'},
        {id:'cfg-users',label:'Utilisateurs',section:'Système',hint:'Comptes et droits d’accès'}
    ];
    let editUserId=null;

    const esc=s=>{let t=s==null?'':String(s);const m=t.match(/^(\d{4})-(\d{2})-(\d{2})$/);if(m)t=m[3]+'/'+m[2]+'/'+m[1];return t.replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));};
    const load=k=>{try{return JSON.parse(localStorage.getItem(k)||'null');}catch(e){return null;}};
    const save=(k,v)=>localStorage.setItem(k,JSON.stringify(v));
    const fmtSal=v=>ajMoney(v||0);

    function nextId(list,prefix){
        let max=0;
        list.forEach(x=>{
            const m=String(x.id||'').match(new RegExp('^'+prefix+'(\\d+)$','i'));
            if(m)max=Math.max(max,parseInt(m[1],10));
        });
        return prefix+String(max+1).padStart(4,'0');
    }

    const HB_PRESETS={
        crepuscule:{color:'#1a1520',light:92,veil:'navy',veil_opacity:28,title_color:'#ffffff'},
        nuit:{color:'#081018',light:72,veil:'gold',veil_opacity:22,title_color:'#f3d38a'},
        jour:{color:'#e8e4dc',light:118,veil:'none',veil_opacity:0,title_color:'#1a2332'}
    };
    let hbDraft='',hbBound=false,hbWritings=[],hbPhotos=[],hbServices=[],hbAbout={},hbSelected='',hbPart='photo';
    const HB_SERVICES_DEFAULT=[
        {id:'piscine',label:'Piscine',icon:'🏊',visible:true},
        {id:'spa',label:'Spa & Bien-être',icon:'💖',visible:true},
        {id:'restaurant',label:'Restaurant',icon:'🍽️',visible:true},
        {id:'cafe',label:'Café & Lounge',icon:'☕',visible:true},
        {id:'sport',label:'Salle de Sport',icon:'🏋️',visible:true},
        {id:'wifi',label:'Wi-Fi Gratuit',icon:'📶',visible:true},
        {id:'parking',label:'Parking',icon:'🚌',visible:true},
        {id:'roomservice',label:'Room Service',icon:'🍽️',visible:true}
    ];
    const HB_ABOUT_DEFAULT={
        bg:'#0a1736',
        title:"À propos d'",
        brand:'ALJAZEERA',
        title_color:'#8b93a3',
        accent:'#c5a059',
        text:"Un hôtel <em>5 étoiles</em> qui allie élégance marocaine et confort international. Piscine, spa, gastronomie raffinée et un service attentionné pour un séjour d'exception au cœur de la ville.",
        text_color:'#c5cbd6',
        style:'serif'
    };
    function normalizeHbServices(list){
        const byId={};
        (Array.isArray(list)?list:[]).forEach(s=>{if(s&&s.id)byId[s.id]=s.visible!==false;});
        return HB_SERVICES_DEFAULT.map(s=>({...s,visible:Object.prototype.hasOwnProperty.call(byId,s.id)?!!byId[s.id]:true}));
    }
    function normalizeHbAbout(data){
        const d=Object.assign({}, HB_ABOUT_DEFAULT, data&&typeof data==='object'?data:{});
        const styles=['serif','moderne','signature','enseigne'];
        d.style=styles.includes(d.style)?d.style:'serif';
        d.title=String(d.title||HB_ABOUT_DEFAULT.title).slice(0,80);
        d.brand=String(d.brand||HB_ABOUT_DEFAULT.brand).slice(0,40);
        d.text=String(d.text||HB_ABOUT_DEFAULT.text).slice(0,500);
        d.bg=d.bg||HB_ABOUT_DEFAULT.bg;
        d.title_color=d.title_color||HB_ABOUT_DEFAULT.title_color;
        d.accent=d.accent||HB_ABOUT_DEFAULT.accent;
        d.text_color=d.text_color||HB_ABOUT_DEFAULT.text_color;
        return d;
    }
    function syncAboutForm(){
        const set=(id,v)=>{const el=document.getElementById(id);if(el&&document.activeElement!==el)el.value=v;};
        set('hb_about_title', hbAbout.title||'');
        set('hb_about_brand', hbAbout.brand||'');
        set('hb_about_text', hbAbout.text||'');
        set('hb_about_bg', hbAbout.bg||'#0a1736');
        set('hb_about_title_color', hbAbout.title_color||'#8b93a3');
        set('hb_about_accent', hbAbout.accent||'#c5a059');
        set('hb_about_text_color', hbAbout.text_color||'#c5cbd6');
        document.querySelectorAll('#hbAboutStyles button').forEach(b=>b.classList.toggle('is-on', b.dataset.hbAboutStyle===hbAbout.style));
    }
    function readAboutForm(){
        hbAbout=normalizeHbAbout({
            title:document.getElementById('hb_about_title')?.value||'',
            brand:document.getElementById('hb_about_brand')?.value||'',
            text:document.getElementById('hb_about_text')?.value||'',
            bg:document.getElementById('hb_about_bg')?.value||'#0a1736',
            title_color:document.getElementById('hb_about_title_color')?.value||'#8b93a3',
            accent:document.getElementById('hb_about_accent')?.value||'#c5a059',
            text_color:document.getElementById('hb_about_text_color')?.value||'#c5cbd6',
            style:document.querySelector('#hbAboutStyles button.is-on')?.dataset.hbAboutStyle||hbAbout.style||'serif'
        });
        return hbAbout;
    }
    function renderHbServices(){
        const box=document.getElementById('hbSvcList');
        if(!box)return;
        box.innerHTML=hbServices.map(s=>`
            <div class="hb-svc-row${s.visible?'':' is-off'}" data-svc-id="${s.id}">
                <div class="hb-svc-meta"><span class="hb-svc-ico">${s.icon}</span><b>${esc(s.label)}</b></div>
                <button type="button" class="hb-svc-toggle" data-svc-toggle="${s.id}" title="${s.visible?'Masquer':'Afficher'}" aria-label="${s.visible?'Masquer':'Afficher'}">${s.visible?'👁':'🙈'}</button>
            </div>
        `).join('');
    }
    function toggleHbService(id){
        const s=hbServices.find(x=>x.id===id);
        if(!s)return;
        s.visible=!s.visible;
        renderHbServices();
        paintHabillagePreview();
    }
    const HB_LIBRARY=['/images/hotel-hero.png','/images/hotel-facade.png','/images/hotel.png'];
    function renderHbPhotos(active){
        const box=document.getElementById('hbPicks');
        const count=document.getElementById('hb_photo_count');
        if(!box)return;
        const list=(hbPhotos.length?hbPhotos:HB_LIBRARY).slice();
        HB_LIBRARY.forEach(p=>{if(!list.includes(p))list.unshift(p);});
        hbPhotos=list;
        box.innerHTML=list.map(src=>`<button type="button" data-hb-image="${src}" style="background-image:url('${src}')" title="${src.split('/').pop()}"></button>`).join('');
        if(count)count.textContent=String(list.length);
        box.querySelectorAll('button').forEach(b=>b.classList.toggle('is-on', !hbDraft && b.dataset.hbImage===active));
    }
    const HB_PARTS={
        photo:{zones:['hero'],focus:'hero',label:'Photo d\'accueil'},
        offres:{zones:['offres'],focus:'offres',label:'Offres'},
        chambres:{zones:['chambres'],focus:'chambres',label:'Chambres'},
        bas:{zones:['services','promos','confiance','apropos'],focus:'services',label:'Bas de page'}
    };
    const hbPartOfZone=zone=>{
        for(const [key,part] of Object.entries(HB_PARTS)){
            if(part.zones.includes(zone))return key;
        }
        return 'photo';
    };
    const hbVeil=(veil,opacity)=>{
        const a=(Math.max(0,Math.min(80,Number(opacity)||0))/100).toFixed(2);
        if(veil==='navy')return 'rgba(6,15,36,'+a+')';
        if(veil==='gold')return 'rgba(120,78,18,'+a+')';
        return 'transparent';
    };
    const softCleanHbText=(s)=>String(s||'').replace(/[\s\u00A0\u2000-\u200B\u202F\u205F\u3000]+/g,' ');
    const cleanHbText=(s)=>softCleanHbText(s).trim();
    function hbRead(){
        return {
            image:document.getElementById('hb_image')?.value||'/images/hotel-hero.png',
            color:document.getElementById('hb_color')?.value||'#1a1520',
            light:Number(document.getElementById('hb_light')?.value||100),
            veil:document.getElementById('hb_veil')?.value||'none',
            veil_opacity:Number(document.getElementById('hb_veil_opacity')?.value||0)
        };
    }
    function hbSelectedWriting(){
        return hbWritings.find(w=>w.id===hbSelected)||null;
    }
    function normalizeHbLight(v){
        if(v===false||v===0||v==='0'||v==='false')return 'none';
        if(v===true||v===1||v==='1'||v==='true')return 'soft';
        const ok=['none','soft','glow','forte','neon','or','relief','halo'];
        return ok.includes(String(v))?String(v):'soft';
    }
    function ensureWriting(){
        let w=hbSelectedWriting();
        if(w)return w;
        const id='w'+Math.random().toString(36).slice(2,8);
        const zone=(HB_PARTS[hbPart]?.focus)||'hero';
        w={id,text:'',text2:'',style:'enseigne',mode:'lignes',color:'#e2b65a',size:120,light:'soft',stars:true,zone,x:50,y:45};
        hbWritings.push(w);
        hbSelected=id;
        return w;
    }
    function syncWritingForm(){
        const box=document.getElementById('hbWriteBox');
        const empty=document.getElementById('hbWriteEmpty');
        const w=hbSelectedWriting();
        if(box)box.hidden=!w;
        if(empty)empty.hidden=!!w;
        if(!w)return;
        const text=document.getElementById('hb_w_text');
        const text2=document.getElementById('hb_w_text2');
        const color=document.getElementById('hb_w_color');
        const size=document.getElementById('hb_w_size');
        const sizeVal=document.getElementById('hb_w_size_val');
        const stars=document.getElementById('hb_w_stars');
        if(text&&document.activeElement!==text)text.value=w.text||'';
        if(text2&&document.activeElement!==text2)text2.value=w.text2||'';
        if(color)color.value=w.color||'#e2b65a';
        if(size)size.value=String(w.size||100);
        if(sizeVal)sizeVal.textContent=String(w.size||100);
        if(stars)stars.checked=w.stars!==false;
        w.light=normalizeHbLight(w.light);
        document.querySelectorAll('#hbStyles button').forEach(b=>b.classList.toggle('is-on', b.dataset.hbStyle===w.style));
        document.querySelectorAll('#hbModes button').forEach(b=>b.classList.toggle('is-on', b.dataset.hbMode===w.mode));
        document.querySelectorAll('#hbLights button').forEach(b=>b.classList.toggle('is-on', b.dataset.hbLight===w.light));
        const cur=(w.color||'#e2b65a').toLowerCase();
        document.querySelectorAll('#hbColorSwatches button').forEach(b=>b.classList.toggle('is-on', (b.dataset.hbSwatch||'').toLowerCase()===cur));
    }
    function pushHbFrame(){
        const frame=document.getElementById('hbFrame');
        if(!frame||!frame.classList.contains('is-on')||!frame.contentWindow)return;
        const part=HB_PARTS[hbPart]||HB_PARTS.photo;
        const d=hbRead();
        frame.contentWindow.postMessage({
            type:'hb-state',
            image:hbDraft||d.image,
            color:d.color,
            light:d.light/100,
            veil:hbVeil(d.veil, d.veil_opacity),
            writings:hbWritings,
            services:hbServices,
            about:hbAbout,
            selected:hbSelected,
            zones:part.zones,
            focus:part.focus,
            solo:true
        }, '*');
    }
    function focusHbPart(){
        const live=document.getElementById('hbLive');
        const frame=document.getElementById('hbFrame');
        // Toujours la vraie page : même rendu que le PC
        if(live)live.classList.add('is-off');
        if(frame)frame.classList.add('is-on');
        pushHbFrame();
    }
    function setHbPart(part){
        if(!HB_PARTS[part])part='photo';
        hbPart=part;
        document.querySelectorAll('#hbParts .hb-part').forEach(b=>b.classList.toggle('is-on', b.dataset.hbPart===part));
        document.querySelectorAll('.hb-part-panel').forEach(p=>p.classList.toggle('is-on', p.dataset.hbPanel===part));
        const zones=HB_PARTS[part].zones;
        if(!hbSelected || !zones.includes(hbSelectedWriting()?.zone)){
            const first=hbWritings.find(w=>zones.includes(w.zone));
            hbSelected=first?.id||'';
        }
        focusHbPart();
        paintHabillagePreview();
    }
    function renderLiveWritings(){
        const layer=document.getElementById('hbLiveLayer');
        if(!layer)return;
        const zones=HB_PARTS[hbPart]?.zones||['hero'];
        const list=hbWritings.filter(w=>zones.includes(w.zone));
        layer.innerHTML=list.map(w=>{
            const style=['enseigne','classique','signature','moderne','lisere','contour','neon'].includes(w.style)?w.style:'classique';
            const mode=['libre','lignes','bandeau','encadre','incline','vertical'].includes(w.mode)?w.mode:'libre';
            const on=w.id===hbSelected?' is-on':'';
            const light=' hb-light-'+normalizeHbLight(w.light);
            const stars=w.stars===false?' hb-nostars':'';
            return `<div class="hb-writing hb-style-${style} hb-mode-${mode}${on}${light}${stars}" data-id="${w.id}" style="left:${Number(w.x)||50}%;top:${Number(w.y)||50}%;--hb-wsize:${(Number(w.size)||100)/100};--hb-wcolor:${w.color||'#ffffff'}">
                <span class="hb-w-1"></span>
                <span class="hb-w-stars" aria-hidden="true"><span></span><b>★★★★★</b><span></span></span>
                <span class="hb-w-2"></span>
                <span class="hb-w-orn" aria-hidden="true"><span></span><i>◆</i><span></span></span>
                <span class="hb-resize" title="Agrandir"></span>
            </div>`;
        }).join('');
        list.forEach(w=>{
            const el=layer.querySelector('[data-id="'+w.id+'"]');
            if(!el)return;
            const a=el.querySelector('.hb-w-1');
            const b=el.querySelector('.hb-w-2');
            if(a)a.textContent=cleanHbText(w.text||'');
            if(b)b.textContent=cleanHbText(w.text2||'');
        });
    }
    function sendHb(){
        const d=hbRead();
        const live=document.getElementById('hbLive');
        const img=document.getElementById('hbLiveImg');
        const lv=document.getElementById('hb_light_val');
        const vv=document.getElementById('hb_veil_val');
        if(lv)lv.textContent=String(d.light);
        if(vv)vv.textContent=String(d.veil_opacity);
        if(live){
            live.style.setProperty('--hb-color', d.color);
            live.style.setProperty('--hb-light', String(d.light/100));
            live.style.setProperty('--hb-veil', hbVeil(d.veil, d.veil_opacity));
        }
        if(img){
            const next=hbDraft||d.image;
            if(img.getAttribute('src')!==next)img.src=next;
        }
        if(document.getElementById('hbPicks')&&!document.getElementById('hbPicks').children.length)renderHbPhotos(d.image);
        else document.querySelectorAll('#hbPicks button').forEach(b=>b.classList.toggle('is-on', !hbDraft && b.dataset.hbImage===d.image));
        readAboutForm();
        pushHbFrame();
    }
    function paintHabillagePreview(){
        syncWritingForm();
        sendHb();
    }
    function fillHabillage(data){
        const set=(id,v)=>{const el=document.getElementById(id);if(el&&v!=null)el.value=v;};
        set('hb_image', data.image||'/images/hotel-hero.png');
        set('hb_color', data.color||'#1a1520');
        set('hb_light', data.light??100);
        set('hb_veil', data.veil||'none');
        set('hb_veil_opacity', data.veil_opacity??40);
        hbWritings=Array.isArray(data.writings)?data.writings.map(w=>{
            const copy=Object.assign({}, w);
            copy.light=normalizeHbLight(copy.light);
            return copy;
        }):[];
        hbServices=normalizeHbServices(data.services);
        hbAbout=normalizeHbAbout(data.about);
        hbPhotos=Array.isArray(data.photos)?data.photos.slice():HB_LIBRARY.slice();
        if(data.image&&!hbPhotos.includes(data.image))hbPhotos.push(data.image);
        renderHbServices();
        syncAboutForm();
        const zones=HB_PARTS[hbPart]?.zones||['hero'];
        const inPart=hbWritings.find(w=>zones.includes(w.zone));
        hbSelected=hbWritings.some(w=>w.id===hbSelected)?hbSelected:(inPart?.id||hbWritings[0]?.id||'');
        hbDraft='';
        const file=document.getElementById('hb_file');
        if(file)file.value='';
        renderHbPhotos(data.image||'/images/hotel-hero.png');
        setHbPart(hbPart);
    }
    function syncFormIntoWriting(){
        const w=hbSelectedWriting();
        if(!w)return null;
        w.text=cleanHbText(document.getElementById('hb_w_text')?.value||'');
        w.text2=cleanHbText(document.getElementById('hb_w_text2')?.value||'');
        w.color=document.getElementById('hb_w_color')?.value||'#e2b65a';
        w.size=Number(document.getElementById('hb_w_size')?.value||100);
        const lightBtn=document.querySelector('#hbLights button.is-on');
        w.light=normalizeHbLight(lightBtn?.dataset.hbLight||w.light||'soft');
        w.stars=!!document.getElementById('hb_w_stars')?.checked;
        return w;
    }
    function pruneEmptyWritings(){
        hbWritings=hbWritings.filter(w=>cleanHbText(w.text||'')!==''||cleanHbText(w.text2||'')!=='');
        if(hbSelected&&!hbWritings.some(w=>w.id===hbSelected))hbSelected=hbWritings[0]?.id||'';
    }
    async function saveHabillage(){
        const note=document.getElementById('hb_note');
        syncFormIntoWriting();
        readAboutForm();
        pruneEmptyWritings();
        const fd=new FormData();
        const d=hbRead();
        Object.entries(d).forEach(([k,v])=>fd.append(k,v));
        fd.append('writings', JSON.stringify(hbWritings));
        fd.append('services', JSON.stringify(hbServices));
        fd.append('about', JSON.stringify(hbAbout));
        fd.append('photos', JSON.stringify(hbPhotos));
        const file=document.getElementById('hb_file')?.files?.[0];
        if(file)fd.append('image_file', file);
        try{
            const res=await fetch('/admin/api/habillage',{method:'POST',headers:{'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]')?.content||'','Accept':'application/json'},body:fd});
            const json=await res.json().catch(()=>({}));
            if(!res.ok){
                const first=json.errors?Object.values(json.errors)[0]:null;
                throw new Error((first&&first[0])||json.message||'Enregistrement impossible.');
            }
            window.AJ_HABILLAGE=json;
            fillHabillage(json);
            if(note){note.style.color='#059669';note.textContent='Habillage enregistré.';}
        }catch(err){
            if(note){note.style.color='#c05050';note.textContent=err.message||'Enregistrement impossible.';}
        }
    }
    async function resetHabillage(){
        const note=document.getElementById('hb_note');
        try{
            const res=await fetch('/admin/api/habillage',{method:'DELETE',headers:{'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]')?.content||'','Accept':'application/json'}});
            const json=await res.json().catch(()=>({}));
            if(!res.ok)throw new Error(json.message||'Réinitialisation impossible.');
            window.AJ_HABILLAGE=json;
            document.querySelectorAll('[data-hb-preset]').forEach(b=>b.classList.remove('is-on'));
            fillHabillage(json);
            if(note){note.style.color='#059669';note.textContent='Habillage d\'origine rétabli. L\'archive photos est conservée.';}
        }catch(err){
            if(note){note.style.color='#c05050';note.textContent=err.message||'Réinitialisation impossible.';}
        }
    }
    function bindHabillage(){
        if(hbBound)return;
        hbBound=true;
        const patchWriting=(partial)=>{
            const w=ensureWriting();
            if(partial.text!=null)partial.text=softCleanHbText(partial.text);
            if(partial.text2!=null)partial.text2=softCleanHbText(partial.text2);
            Object.assign(w, partial);
            if(partial.text2!=null&&partial.text2!==''&&w.mode==='libre')w.mode='lignes';
            syncWritingForm();
            sendHb();
        };
        document.getElementById('cfg-habillage')?.addEventListener('input', e=>{
            const id=e.target.id;
            if(id==='hb_w_text')patchWriting({text:e.target.value});
            else if(id==='hb_w_text2')patchWriting({text2:e.target.value});
            else if(id==='hb_w_color')patchWriting({color:e.target.value});
            else if(id==='hb_w_stars')patchWriting({stars:!!e.target.checked});
            else if(id==='hb_w_size'){
                const size=Number(e.target.value);
                ensureWriting().size=size;
                const lab=document.getElementById('hb_w_size_val');
                if(lab)lab.textContent=String(size);
                sendHb();
            }else if(e.target.closest('.hb-fields'))paintHabillagePreview();
        });
        let hbDrag=null;
        document.getElementById('hbLiveLayer')?.addEventListener('pointerdown', e=>{
            const node=e.target.closest('.hb-writing');
            if(!node)return;
            e.preventDefault();
            hbSelected=node.dataset.id;
            syncWritingForm();
            renderLiveWritings();
            const w=hbSelectedWriting();
            if(!w)return;
            if(e.target.closest('.hb-resize')){
                hbDrag={mode:'size',id:w.id,x:e.clientX,size:Number(w.size)||100};
            }else{
                hbDrag={mode:'move',id:w.id};
            }
            node.setPointerCapture(e.pointerId);
        });
        document.addEventListener('pointermove', e=>{
            if(!hbDrag)return;
            const w=hbWritings.find(item=>item.id===hbDrag.id);
            const live=document.getElementById('hbLive');
            const node=document.querySelector('#hbLiveLayer [data-id="'+hbDrag.id+'"]');
            if(!w||!live||!node)return;
            if(hbDrag.mode==='size'){
                w.size=Math.min(220, Math.max(50, Math.round(hbDrag.size+(e.clientX-hbDrag.x))));
                node.style.setProperty('--hb-wsize', String(w.size/100));
                const size=document.getElementById('hb_w_size');
                const lab=document.getElementById('hb_w_size_val');
                if(size)size.value=String(w.size);
                if(lab)lab.textContent=String(w.size);
            }else{
                const r=live.getBoundingClientRect();
                w.x=Math.min(96, Math.max(4, (e.clientX-r.left)/r.width*100));
                w.y=Math.min(96, Math.max(4, (e.clientY-r.top)/r.height*100));
                w.zone=(HB_PARTS[hbPart]?.focus)||'hero';
                node.style.left=w.x+'%';
                node.style.top=w.y+'%';
            }
        });
        const stopDrag=()=>{hbDrag=null;};
        document.addEventListener('pointerup', stopDrag);
        document.addEventListener('pointercancel', stopDrag);
        document.getElementById('hbParts')?.addEventListener('click', e=>{
            const btn=e.target.closest('[data-hb-part]');
            if(!btn)return;
            e.preventDefault();
            setHbPart(btn.dataset.hbPart);
        });
        document.getElementById('hbSvcList')?.addEventListener('click', e=>{
            const btn=e.target.closest('[data-svc-toggle]');
            if(!btn)return;
            e.preventDefault();
            toggleHbService(btn.dataset.svcToggle);
        });
        document.getElementById('hbAboutBox')?.addEventListener('input', e=>{
            if(!e.target.closest('#hbAboutBox'))return;
            readAboutForm();
            paintHabillagePreview();
        });
        document.getElementById('hbAboutStyles')?.addEventListener('click', e=>{
            const btn=e.target.closest('[data-hb-about-style]');
            if(!btn)return;
            hbAbout.style=btn.dataset.hbAboutStyle;
            syncAboutForm();
            paintHabillagePreview();
        });
        document.getElementById('hbAdd')?.addEventListener('click', ()=>{
            const id='w'+Math.random().toString(36).slice(2,8);
            const zone=(HB_PARTS[hbPart]?.focus)||'hero';
            hbWritings.push({id,text:'HOTEL',text2:'AL JAZEERA',style:'enseigne',mode:'lignes',color:'#e2b65a',size:120,light:'soft',stars:true,zone,x:50,y:45});
            hbSelected=id;
            paintHabillagePreview();
            const input=document.getElementById('hb_w_text');
            if(input){input.focus();input.select();}
        });
        document.getElementById('hbRemove')?.addEventListener('click', ()=>{
            if(!hbSelected)return;
            const zones=HB_PARTS[hbPart]?.zones||['hero'];
            hbWritings=hbWritings.filter(w=>w.id!==hbSelected);
            const next=hbWritings.find(w=>zones.includes(w.zone));
            hbSelected=next?.id||'';
            paintHabillagePreview();
        });
        document.getElementById('hb_file')?.addEventListener('change', e=>{
            const f=e.target.files&&e.target.files[0];
            if(!f){hbDraft='';paintHabillagePreview();return;}
            const reader=new FileReader();
            reader.onload=()=>{hbDraft=String(reader.result||'');paintHabillagePreview();};
            reader.readAsDataURL(f);
        });
        document.getElementById('hbPicks')?.addEventListener('click', e=>{
            const btn=e.target.closest('[data-hb-image]');
            if(!btn)return;
            hbDraft='';
            const file=document.getElementById('hb_file');
            if(file)file.value='';
            const hidden=document.getElementById('hb_image');
            if(hidden)hidden.value=btn.dataset.hbImage;
            document.querySelectorAll('[data-hb-preset]').forEach(b=>b.classList.remove('is-on'));
            paintHabillagePreview();
        });
        document.querySelectorAll('[data-hb-preset]').forEach(btn=>{
            btn.addEventListener('click', ()=>{
                const preset=HB_PRESETS[btn.dataset.hbPreset];
                if(!preset)return;
                document.querySelectorAll('[data-hb-preset]').forEach(b=>b.classList.toggle('is-on', b===btn));
                const set=(id,v)=>{const el=document.getElementById(id);if(el&&v!=null)el.value=v;};
                set('hb_color', preset.color);
                set('hb_light', preset.light);
                set('hb_veil', preset.veil);
                set('hb_veil_opacity', preset.veil_opacity);
                paintHabillagePreview();
            });
        });
        document.getElementById('hbStyles')?.addEventListener('click', e=>{
            const btn=e.target.closest('[data-hb-style]');
            if(!btn)return;
            patchWriting({style:btn.dataset.hbStyle});
        });
        document.getElementById('hbModes')?.addEventListener('click', e=>{
            const btn=e.target.closest('[data-hb-mode]');
            if(!btn)return;
            patchWriting({mode:btn.dataset.hbMode});
        });
        document.getElementById('hbLights')?.addEventListener('click', e=>{
            const btn=e.target.closest('[data-hb-light]');
            if(!btn)return;
            patchWriting({light:normalizeHbLight(btn.dataset.hbLight)});
        });
        document.getElementById('hbColorSwatches')?.addEventListener('click', e=>{
            const btn=e.target.closest('[data-hb-swatch]');
            if(!btn)return;
            const hex=btn.dataset.hbSwatch;
            const input=document.getElementById('hb_w_color');
            if(input)input.value=hex;
            patchWriting({color:hex});
        });
        document.getElementById('hbSave')?.addEventListener('click', saveHabillage);
        document.getElementById('hbReset')?.addEventListener('click', resetHabillage);
        window.addEventListener('message', e=>{
            if(e.origin!==location.origin||!e.data)return;
            const data=e.data;
            if(data.type==='hb-ready'){
                if(hbPart!=='photo')pushHbFrame();
                return;
            }
            if(data.type==='hb-svc-toggle'){
                if(data.id)toggleHbService(data.id);
                return;
            }
            if(data.type==='hb-select'){
                if(!data.id)return;
                hbSelected=data.id;
                const w=hbSelectedWriting();
                if(w)hbPart=hbPartOfZone(w.zone);
                focusHbPart();
                paintHabillagePreview();
                return;
            }
            if(data.type==='hb-move'){
                const w=hbWritings.find(x=>x.id===data.id);
                if(!w)return;
                w.x=Number(data.x)||w.x;
                w.y=Number(data.y)||w.y;
                if(data.zone)w.zone=data.zone;
                paintHabillagePreview();
                return;
            }
            if(data.type==='hb-size'){
                const w=hbWritings.find(x=>x.id===data.id);
                if(!w)return;
                w.size=Math.min(220, Math.max(50, Number(data.size)||w.size||100));
                const size=document.getElementById('hb_w_size');
                const lab=document.getElementById('hb_w_size_val');
                if(size)size.value=String(w.size);
                if(lab)lab.textContent=String(w.size);
                paintHabillagePreview();
            }
        });
        fillHabillage(window.AJ_HABILLAGE||{});
        setHbPart('photo');
    }

    function switchTab(key){
        if(!key)return;
        document.querySelectorAll('#configuration .subpanel').forEach(p=>p.classList.toggle('active',p.id==='cfg-'+key));
        const sbItem=document.querySelector(`.sb-item[data-target="configuration"][data-cfg="${key}"]`);
        if(sbItem){
            document.querySelectorAll('.sb-item').forEach(x=>x.classList.remove('active'));
            sbItem.classList.add('active');
            const cfgParent=document.getElementById('cfgParent');
            const cfgSub=document.getElementById('cfgSub');
            if(cfgParent)cfgParent.classList.add('expanded');
            if(cfgSub)cfgSub.classList.add('open');
            const lbl=sbItem.querySelector('.lbl');
            const pageTitle=document.getElementById('pageTitle');
            if(lbl&&pageTitle)pageTitle.textContent=lbl.textContent.trim();
        }else if(key==='auth'){
            const pageTitle=document.getElementById('pageTitle');
            if(pageTitle)pageTitle.textContent='Autorisations';
        }
        if(key==='carrousel')renderCarousel();
        document.body.classList.toggle('hb-lock', key==='habillage');
        if(key==='habillage'){
            bindHabillage();
            window.scrollTo(0,0);
            requestAnimationFrame(()=>paintHabillagePreview());
        }
    }

    function loadHotelForm(){
        const h=load(K_HOTEL)||{
            raison:'Al Jazeera Hotel',gerant:'',ville:'',adresse:'',contact:'',fixe:'',email:'contact@aljazeerahotel.com',siteweb:'',statut:'5'
        };
        document.getElementById('cfg_raison').value=h.raison||'';
        document.getElementById('cfg_gerant').value=h.gerant||'';
        document.getElementById('cfg_ville').value=h.ville||'';
        document.getElementById('cfg_adresse').value=h.adresse||'';
        document.getElementById('cfg_contact').value=h.contact||'';
        document.getElementById('cfg_fixe').value=h.fixe||'';
        document.getElementById('cfg_email').value=h.email||'';
        document.getElementById('cfg_siteweb').value=h.siteweb||'';
        document.getElementById('cfg_statut').value=h.statut||'5';
    }

    function saveHotel(){
        save(K_HOTEL,{
            raison:document.getElementById('cfg_raison').value.trim(),
            gerant:document.getElementById('cfg_gerant').value.trim(),
            ville:document.getElementById('cfg_ville').value.trim(),
            adresse:document.getElementById('cfg_adresse').value.trim(),
            contact:document.getElementById('cfg_contact').value.trim(),
            fixe:document.getElementById('cfg_fixe').value.trim(),
            email:document.getElementById('cfg_email').value.trim(),
            siteweb:document.getElementById('cfg_siteweb').value.trim(),
            statut:document.getElementById('cfg_statut').value
        });
        alert('Fiche hôtel enregistrée.');
    }

    let authUserId=null;
    const todayISO=()=>new Date().toISOString().slice(0,10);
    function personnelList(){return window.PERS?window.PERS.list():[];}

    function refreshUserNameList(){
        const dl=document.getElementById('cu_nom_list');
        if(!dl)return;
        const noms=[...new Set(personnelList().map(p=>p.nom).filter(Boolean))];
        dl.innerHTML=noms.map(n=>`<option value="${esc(n)}"></option>`).join('');
    }

    let cuPhotoData=null;
    function cuOverlay(){return document.getElementById('cuModalOverlay');}
    function openUserModal(){cuOverlay()?.classList.add('show');}
    function closeUserModal(){cuOverlay()?.classList.remove('show');}

    function previewUserId(){
        return nextId(staffUsers().map(u=>({id:u.id})),'Ut');
    }

    function setCuPhotoPreview(data){
        const preview=document.getElementById('cuPhotoPreview');
        const name=document.getElementById('cuPhotoName');
        const card=document.getElementById('cuPhotoCard');
        if(!preview)return;
        if(data?.data){
            preview.innerHTML=`<img src="${data.data}" alt="">`;
            if(name)name.textContent=data.name||'Photo';
            card?.classList.add('has-file');
        }else{
            preview.innerHTML='';
            if(name)name.textContent='Importer une photo';
            card?.classList.remove('has-file');
        }
    }

    function bindCuPhotoUpload(){
        const btn=document.getElementById('cuPhotoBtn');
        const file=document.getElementById('cuPhotoFile');
        if(!btn||!file||btn.dataset.bound)return;
        btn.dataset.bound='1';
        btn.addEventListener('click',()=>{file.value='';file.click();});
        file.addEventListener('change',()=>{
            const f=file.files&&file.files[0];
            if(!f)return;
            if(f.size>5*1024*1024){userMsg('Photo trop volumineuse (max 5 Mo).','err');return;}
            const reader=new FileReader();
            reader.onload=()=>{
                cuPhotoData={data:String(reader.result||''),name:f.name||''};
                setCuPhotoPreview(cuPhotoData);
            };
            reader.readAsDataURL(f);
        });
    }

    function readAuthForm(){
        const auth={};
        MENUS.forEach(m=>{
            auth[m.id]={};
            PERMS.forEach(k=>{
                const cb=document.querySelector(`#cfg_auth_tbody input[data-menu="${m.id}"][data-perm="${k}"]`);
                auth[m.id][k]=!!(cb&&cb.checked);
            });
        });
        return auth;
    }

    function onUserName(){
        const nom=document.getElementById('cu_nom')?.value.trim()||'';
        const person=personnelList().find(p=>p.nom===nom);
        if(!person)return;
        const set=(id,val)=>{const el=document.getElementById(id);if(el&&val!=null&&val!=='')el.value=val;};
        set('cu_cin',person.cin);
        set('cu_tel',person.mobile);
        set('cu_adresse',person.adresse);
        set('cu_formation',person.formation);
        const profil=document.getElementById('cu_profil');
        if(person.profil&&profil&&[...profil.options].some(o=>o.value===person.profil))profil.value=person.profil;
        if(person.contrat)set('cu_contrat',person.contrat);
        if(person.debut)set('cu_debut',typeof ajDate==='function'?ajDate(person.debut):person.debut);
        if(person.fin)set('cu_fin',typeof ajDate==='function'?ajDate(person.fin):person.fin);
        if(person.remu!=null&&person.remu!=='')set('cu_salaire',person.remu);
    }

    function readUserForm(){
        const rawDate=document.getElementById('cu_date')?.value||'';
        const parsed=typeof ajIso==='function'?ajIso(rawDate):'';
        const photoData=cuPhotoData?.data||(typeof cuPhotoData==='string'?cuPhotoData:'');
        const payload={
            kind:'user',
            fiche_date:parsed||todayISO(),
            nom:(document.getElementById('cu_nom')?.value||'').trim(),
            cin:(document.getElementById('cu_cin')?.value||'').trim()||null,
            tel:(document.getElementById('cu_tel')?.value||'').trim()||null,
            adresse:(document.getElementById('cu_adresse')?.value||'').trim()||null,
            formation:(document.getElementById('cu_formation')?.value||'').trim()||null,
            profil:document.getElementById('cu_profil')?.value||'',
            contrat:document.getElementById('cu_contrat')?.value||null,
            debut:(typeof ajIso==='function'?ajIso(document.getElementById('cu_debut')?.value||''):'')||null,
            fin:(typeof ajIso==='function'?ajIso(document.getElementById('cu_fin')?.value||''):'')||null,
            remu_type:document.getElementById('cu_remu_type')?.value||null,
            salaire:document.getElementById('cu_salaire')?.value===''||document.getElementById('cu_salaire')?.value==null
                ?null:document.getElementById('cu_salaire').value,
            login:(document.getElementById('cu_login')?.value||'').trim(),
            password:document.getElementById('cu_password')?.value||'',
            autorisations:readAuthForm()
        };
        if(photoData&&photoData.length<=180000)payload.photo=photoData;
        return payload;
    }

    const USERS_API=@json(url('admin/api/users'));
    let usersCache=[];
    async function usersApi(method,path,body){
        let res;
        try{
            res=await fetch(USERS_API+(path||''),{
                method,
                credentials:'same-origin',
                headers:{
                    'Accept':'application/json',
                    'Content-Type':'application/json',
                    'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]')?.content||''
                },
                body:body?JSON.stringify(body):undefined
            });
        }catch(e){
            throw new Error('Réseau indisponible. Vérifiez la connexion.');
        }
        const data=await res.json().catch(()=>({}));
        if(!res.ok){
            if(res.status===419)throw new Error('Session expirée. Rechargez la page (Ctrl+F5) puis réessayez.');
            if(res.status===403)throw new Error(data.message||'Gestion réservée à la Direction / Administration.');
            const msg=data.errors?Object.values(data.errors).flat().join('\n'):(data.message||'Erreur serveur ('+res.status+').');
            throw new Error(msg);
        }
        if(Array.isArray(data.users))usersCache=data.users;
        return data;
    }

    function fillUserForm(u){
        refreshUserNameList();
        bindCuPhotoUpload();
        const set=(id,val)=>{const el=document.getElementById(id);if(el)el.value=val??'';};
        set('cu_id',u?.id||previewUserId());
        set('cu_date',typeof ajDate==='function'?ajDate(u?.date||todayISO()):(u?.date||todayISO()));
        set('cu_nom',u?.nom||'');
        set('cu_cin',u?.cin||'');
        set('cu_tel',u?.tel||'');
        set('cu_adresse',u?.adresse||'');
        set('cu_formation',u?.formation||'');
        set('cu_profil',u?.profil||'');
        set('cu_contrat',u?.contrat||'');
        set('cu_debut',u?.debut?(typeof ajDate==='function'?ajDate(u.debut):u.debut):'');
        set('cu_fin',u?.fin?(typeof ajDate==='function'?ajDate(u.fin):u.fin):'');
        set('cu_remu_type',u?.remu_type||'');
        set('cu_salaire',u?.salaire!=null&&u?.salaire!==''?u.salaire:'');
        set('cu_login',u?.login||'');
        const pwd=document.getElementById('cu_password');
        if(pwd){pwd.value='';pwd.placeholder=u?'Laisser vide pour conserver':'Saisie manuelle';}
        cuPhotoData=u?.photo?{data:u.photo,name:'Photo'}:null;
        setCuPhotoPreview(cuPhotoData);
        const title=document.getElementById('cuTitle');
        const sub=document.getElementById('cuSub');
        if(title)title.textContent=u?'Modifier utilisateur':'Nouvel utilisateur';
        if(sub)sub.textContent=u?(u.nom+' · '+(u.profil||'')):'Fiche complète · connexion · autorisations';
        const who=document.getElementById('cfg_auth_who');
        if(who)who.textContent=u
            ?('Autorisations de '+u.nom+' ('+(u.profil||'')+').')
            :'Cochez les droits du nouveau compte.';
        renderAuth(u?.autorisations||{});
    }

    function staffUsers(){return usersCache.slice();}

    function profilPillClass(profil){
        const p=String(profil||'').toLowerCase()
            .normalize('NFD').replace(/[\u0300-\u036f]/g,'')
            .replace(/[^a-z0-9]+/g,'-').replace(/^-|-$/g,'');
        const map={
            direction:'direction',administration:'administration',reception:'reception',
            's-commercial':'commercial',commercial:'commercial',
            'house-keeping':'housekeeping',maintenance:'maintenance',
            's-technique':'technique',restauration:'restauration',comptabilite:'comptabilite'
        };
        return 'cu-pill p-'+(map[p]||'default');
    }

    function drawUsers(){
        const tb=document.getElementById('cu_tbody');
        const count=document.getElementById('cu_count');
        const list=staffUsers();
        if(count)count.textContent=list.length+(list.length>1?' comptes':' compte');
        try{localStorage.setItem('aj_cfg_users_noms',JSON.stringify(list.map(u=>({id:u.id,nom:u.nom,profil:u.profil}))));}catch(e){}
        if(!tb)return;
        if(!list.length){tb.innerHTML='<tr class="empty-row"><td colspan="6">Aucun utilisateur enregistré</td></tr>';return;}
        tb.innerHTML=list.map(u=>{
            const dateTxt=u.date?(typeof ajDate==='function'?ajDate(u.date):u.date):'—';
            return`<tr data-user-id="${esc(u.id)}">
            <td><span class="cu-login">${esc(u.id)}</span></td>
            <td class="cu-date">${esc(dateTxt)}</td>
            <td class="cu-nom">${esc(u.nom)}</td>
            <td><span class="${profilPillClass(u.profil)}">${esc(u.profil||'—')}</span></td>
            <td><span class="cu-login">${esc(u.login)}</span></td>
            <td class="no-print">
                <div class="cu-actions">
                    <button type="button" class="ibtn" title="Modifier" onclick="CFG.editUser('${esc(u.id)}')">&#9998;</button>
                    <button type="button" class="ibtn auth" title="Autorisations" onclick="CFG.openAuth('${esc(u.id)}')">&#128065;</button>
                    <button type="button" class="ibtn del" title="Supprimer" onclick="CFG.delUser('${esc(u.id)}')">&#128465;</button>
                </div>
            </td>
        </tr>`;
        }).join('');
    }

    async function renderUsers(){
        const tb=document.getElementById('cu_tbody');
        try{
            await usersApi('GET');
            drawUsers();
        }catch(e){
            if(tb)tb.innerHTML=`<tr class="empty-row"><td colspan="6">${esc(e.message)}</td></tr>`;
        }
    }

    function newUser(){
        editUserId=null;
        authUserId=null;
        fillUserForm(null);
        userMsg('');
        openUserModal();
        document.getElementById('cu_nom')?.focus();
    }

    function openAuth(id){
        const u=usersCache.find(x=>x.id===id);
        if(!u)return;
        editUser(id);
    }

    function userMsg(text,kind){
        const open=!!cuOverlay()?.classList.contains('show');
        const el=document.getElementById(open?'cu_modal_msg':'cu_msg')||document.getElementById('cu_msg');
        const other=document.getElementById(open?'cu_msg':'cu_modal_msg');
        if(other){other.className='cfg-inline-msg';other.textContent='';}
        if(!el){if(text)console.warn('[Utilisateur]',text);return;}
        el.className='cfg-inline-msg'+(text?' is-on is-'+(kind||'info'):'');
        el.textContent=text||'';
    }

    async function saveUser(){
        const btn=document.getElementById('cuSaveBtn');
        if(btn?.dataset.busy==='1')return;
        try{
            if(btn){btn.dataset.busy='1';btn.disabled=true;btn.textContent='Enregistrement…';}
            const data=readUserForm();
            if(!data.nom){userMsg('Le nom est obligatoire.','err');return;}
            if(!data.profil){userMsg('Choisissez un profil / statut.','err');return;}
            if(!data.login){userMsg('Le login est obligatoire.','err');return;}
            if(data.login.length<3){userMsg('Le login doit contenir au moins 3 caractères.','err');return;}
            if(!editUserId&&!data.password){userMsg('Le mot de passe est obligatoire.','err');return;}
            if(data.password&&data.password.length<6){userMsg('Le mot de passe doit contenir au moins 6 caractères.','err');return;}
            const editing=editUserId;
            const authPayload=data.autorisations||readAuthForm();
            const payload={...data,edit:editUserId||undefined,autorisations:authPayload};
            if(!payload.password)delete payload.password;
            const res=await usersApi('POST','',payload);
            const saved=(res.users||[]).find(u=>String(u.login).toLowerCase()===String(data.login).toLowerCase())
                ||(editing?(res.users||[]).find(u=>u.id===editing):null);
            /* Double filet : enregistre aussi via l’endpoint dédié aux autorisations */
            if(saved?.id){
                try{
                    await usersApi('POST','/'+encodeURIComponent(saved.id)+'/auth',{autorisations:authPayload});
                }catch(authErr){
                    userMsg(authErr.message||'Utilisateur enregistré, mais autorisations non appliquées.','err');
                    drawUsers();
                    return;
                }
            }
            editUserId=null;
            authUserId=null;
            closeUserModal();
            drawUsers();
            const rights=Object.values(authPayload||{}).reduce((n,row)=>n+PERMS.filter(k=>row&&row[k]).length,0);
            userMsg((editing?'Utilisateur modifié.':'Utilisateur ajouté.')+' '+rights+' droit(s) enregistré(s).','ok');
        }catch(e){
            userMsg(e.message||'Enregistrement impossible.','err');
        }finally{
            if(btn){btn.dataset.busy='';btn.disabled=false;btn.textContent='Valider';}
        }
    }

    function editUser(id){
        const u=usersCache.find(x=>x.id===id);
        if(!u)return;
        editUserId=id;
        authUserId=id;
        fillUserForm(u);
        userMsg('');
        openUserModal();
        document.getElementById('cu_nom')?.focus();
    }

    async function delUser(id){
        if(!confirm('Supprimer cet utilisateur ?'))return;
        try{
            await usersApi('DELETE','/'+encodeURIComponent(id));
        }catch(e){userMsg(e.message||'Suppression impossible.','err');return;}
        if(editUserId===id||authUserId===id){
            editUserId=null;
            authUserId=null;
            closeUserModal();
        }
        drawUsers();
        userMsg('Utilisateur supprimé.','ok');
    }

    /* Sections ouvertes par défaut pour pouvoir cocher / vérifier avant Valider */
    const closedSecs=new Set();
    const eyeOn='<svg class="eye-on" viewBox="0 0 24 24" aria-hidden="true"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>';
    const eyeOff='<svg class="eye-off" viewBox="0 0 24 24" aria-hidden="true"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19"/><path d="M1 1l22 22"/></svg>';
    function authBoxes(){
        return [...document.querySelectorAll('#cfg_auth_tbody input[type=checkbox][data-menu]')];
    }
    function syncAuthStats(){
        const boxes=authBoxes();
        const total=boxes.length;
        const on=boxes.filter(b=>b.checked).length;
        const byMenu={};
        boxes.forEach(b=>{
            if(!byMenu[b.dataset.menu])byMenu[b.dataset.menu]={on:0,total:0};
            byMenu[b.dataset.menu].total++;
            if(b.checked)byMenu[b.dataset.menu].on++;
        });
        const modules=Object.values(byMenu).filter(x=>x.on>0).length;
        const elOn=document.getElementById('cfg_auth_on');
        const elTotal=document.getElementById('cfg_auth_total');
        const elMod=document.getElementById('cfg_auth_modules');
        if(elOn)elOn.textContent=String(on);
        if(elTotal)elTotal.textContent=String(total);
        if(elMod)elMod.textContent=String(modules);
        document.querySelectorAll('#cfg_auth_tbody tr.auth-row').forEach(tr=>{
            const id=tr.dataset.menu;
            const meta=byMenu[id]||{on:0,total:PERMS.length};
            const count=tr.querySelector('.auth-row-count');
            if(count)count.innerHTML=`<em>${meta.on}</em> / ${meta.total} droits`;
        });
        document.querySelectorAll('#cfg_auth_tbody tr.auth-sec').forEach(sec=>{
            const name=sec.dataset.sec;
            const rows=[...document.querySelectorAll(`#cfg_auth_tbody tr.auth-row[data-sec="${CSS.escape(name)}"]`)];
            let secOn=0,secTotal=0;
            rows.forEach(tr=>{
                tr.querySelectorAll('input[type=checkbox][data-menu]').forEach(cb=>{
                    secTotal++;
                    if(cb.checked)secOn++;
                });
            });
            const meta=sec.querySelector('.auth-sec-meta');
            if(meta)meta.innerHTML=`<span>${rows.length} écran${rows.length>1?'s':''}</span><span>${secOn}/${secTotal} droits</span>`;
        });
    }
    function syncAuthMasters(){
        const boxes=authBoxes();
        const all=document.getElementById('auth_check_all');
        if(all){
            const n=boxes.length, on=boxes.filter(b=>b.checked).length;
            all.checked=n>0&&on===n;
            all.indeterminate=on>0&&on<n;
        }
        document.querySelectorAll('.auth-col-all').forEach(col=>{
            const list=boxes.filter(b=>b.dataset.perm===col.dataset.perm);
            const on=list.filter(b=>b.checked).length;
            col.checked=list.length>0&&on===list.length;
            col.indeterminate=on>0&&on<list.length;
        });
        syncAuthStats();
    }
    function setAllAuth(on){
        authBoxes().forEach(b=>{b.checked=!!on;});
        syncAuthMasters();
    }
    function setAuthColumn(perm,on){
        authBoxes().filter(b=>b.dataset.perm===perm).forEach(b=>{b.checked=!!on;});
        syncAuthMasters();
    }
    function renderAuth(stored){
        const source=stored&&typeof stored==='object'&&!Array.isArray(stored)?stored:{};
        let lastSection='';
        const rows=MENUS.map(m=>{
            let sectionRow='';
            if(m.section!==lastSection){
                lastSection=m.section;
                const closed=closedSecs.has(m.section);
                const count=MENUS.filter(x=>x.section===m.section).length;
                sectionRow=`<tr class="auth-sec${closed?' is-closed':''}" data-sec="${esc(m.section)}"><td colspan="6"><div class="auth-sec-inner"><button type="button" class="auth-fold" data-sec="${esc(m.section)}" aria-expanded="${closed?'false':'true'}" title="${closed?'Afficher le module':'Masquer le module'}">${eyeOn}${eyeOff}</button><span class="auth-sec-title">${esc(m.section)}</span><span class="auth-sec-meta"><span>${count} écran${count>1?'s':''}</span><span>0/${count*PERMS.length} droits</span></span></div></td></tr>`;
            }
            const p=source[m.id]||{};
            const onCount=PERMS.reduce((n,k)=>n+(p[k]?1:0),0);
            const cells=PERMS.map(k=>`<td><label class="auth-check" title="${esc(PERM_HINT[k]||k)}"><input type="checkbox" data-menu="${m.id}" data-perm="${k}" ${p[k]?'checked':''} aria-label="${esc(m.label)} — ${esc(k)}"></label></td>`).join('');
            const hidden=closedSecs.has(m.section)?' is-hidden':'';
            return sectionRow+`<tr class="auth-row${hidden}" data-sec="${esc(m.section)}" data-menu="${esc(m.id)}"><td><div class="auth-item"><strong>${esc(m.label)}</strong><span class="auth-code">${esc(m.id)}</span>${m.hint?`<small>${esc(m.hint)}</small>`:''}<span class="auth-row-count"><em>${onCount}</em> / ${PERMS.length} droits</span></div></td>${cells}</tr>`;
        }).join('');
        document.getElementById('cfg_auth_tbody').innerHTML=rows;
        syncAuthMasters();
    }

    async function saveAuth(){
        if(!authUserId){userMsg('Sélectionnez d’abord un utilisateur (icône œil).','err');return;}
        const auth={};
        MENUS.forEach(m=>{
            auth[m.id]={};
            PERMS.forEach(k=>{
                const cb=document.querySelector(`#cfg_auth_tbody input[data-menu="${m.id}"][data-perm="${k}"]`);
                auth[m.id][k]=!!(cb&&cb.checked);
            });
        });
        const targetId=authUserId;
        try{
            await usersApi('POST','/'+encodeURIComponent(targetId)+'/auth',{autorisations:auth});
        }catch(e){userMsg(e.message||'Enregistrement des autorisations impossible.','err');return;}
        const who=document.getElementById('cfg_auth_who');
        const u=usersCache.find(x=>x.id===targetId);
        if(who)who.textContent=u
            ?('Autorisations de '+u.nom+' enregistrées.')
            :'Autorisations enregistrées.';
        userMsg('Autorisations enregistrées.','ok');
        drawUsers();
    }

    function getCarouselData(){
        return window.AJ_HOTEL?window.AJ_HOTEL.getCarousel():{};
    }

    function setCarouselData(data){
        if(window.AJ_HOTEL)window.AJ_HOTEL.saveCarousel(data);
    }

    function renderCarouselTabs(){
        const tabs=document.getElementById('cfgCarTabs');
        if(!tabs||!window.AJ_HOTEL)return;
        const cats=window.AJ_HOTEL.getCategories();
        tabs.innerHTML=cats.map(c=>`<button type="button" class="cfg-car-tab${c.key===carTab?' active':''}" data-key="${c.key}">${esc(c.title)}</button>`).join('');
        tabs.querySelectorAll('.cfg-car-tab').forEach(btn=>{
            btn.addEventListener('click',()=>{carTab=btn.dataset.key;renderCarousel();});
        });
    }

    function renderCarousel(){
        if(!window.AJ_HOTEL)return;
        renderCarouselTabs();
        const box=document.getElementById('cfgCarContent');
        if(!box)return;
        const data=getCarouselData();
        const cat=window.AJ_HOTEL.getCategories().find(c=>c.key===carTab);
        const block=data[carTab]||{title:cat?.title||'',subtitle:cat?.subtitle||'',slides:[]};
        if(!data[carTab]){
            data[carTab]=block;
            setCarouselData(data);
        }
        const slides=block.slides||[];
        box.innerHTML=`
            <div class="cfg-car-meta">
                <div class="field"><label>Titre catégorie</label><input type="text" id="car_title" value="${esc(block.title||'')}"></div>
                <div class="field"><label>Sous-titre</label><input type="text" id="car_subtitle" value="${esc(block.subtitle||'')}"></div>
            </div>
            <div class="cfg-car-slides" id="cfgCarSlides">${slides.map((s,i)=>carouselSlideHtml(s,i)).join('')}</div>`;
        box.querySelectorAll('[data-car-del]').forEach(btn=>{
            btn.addEventListener('click',()=>deleteCarouselSlide(+btn.dataset.carDel));
        });
        box.querySelectorAll('[data-car-file]').forEach(inp=>{
            inp.addEventListener('change',e=>{
                const i=+inp.dataset.carFile;
                const file=e.target.files?.[0];
                if(!file)return;
                const reader=new FileReader();
                reader.onload=()=>{
                    const el=document.getElementById('car_img_'+i);
                    const prev=document.getElementById('car_prev_'+i);
                    if(el)el.value=reader.result;
                    if(prev)prev.src=reader.result;
                };
                reader.readAsDataURL(file);
            });
        });
        box.querySelectorAll('[data-car-img]').forEach(inp=>{
            inp.addEventListener('input',()=>{
                const i=+inp.dataset.carImg;
                const prev=document.getElementById('car_prev_'+i);
                if(prev&&inp.value.trim())prev.src=inp.value.trim();
            });
        });
    }

    function carouselSlideHtml(s,i){
        return`<div class="cfg-car-slide" data-i="${i}">
            <div class="cfg-car-slide-preview"><img id="car_prev_${i}" src="${esc(s.img||'')}" alt=""></div>
            <div class="field"><label>URL photo</label><input type="text" id="car_img_${i}" data-car-img="${i}" value="${esc(s.img||'')}"></div>
            <div class="field"><label>Importer image</label><input type="file" data-car-file="${i}" accept="image/*"></div>
            <div class="field"><label>Titre</label><input type="text" id="car_stitle_${i}" value="${esc(s.title||'')}"></div>
            <div class="field"><label>Description</label><textarea id="car_sdesc_${i}" rows="2">${esc(s.desc||'')}</textarea></div>
            <div class="cfg-car-slide-actions"><button type="button" class="ibtn del" data-car-del="${i}" title="Supprimer">&#128465;</button></div>
        </div>`;
    }

    function readCarouselForm(){
        const data=getCarouselData();
        const block=data[carTab]||{slides:[]};
        block.title=document.getElementById('car_title')?.value.trim()||block.title;
        block.subtitle=document.getElementById('car_subtitle')?.value.trim()||block.subtitle;
        block.slides=(block.slides||[]).map((s,i)=>({
            id:s.id||carTab+'-'+(i+1),
            img:document.getElementById('car_img_'+i)?.value.trim()||s.img||'',
            title:document.getElementById('car_stitle_'+i)?.value.trim()||'',
            desc:document.getElementById('car_sdesc_'+i)?.value.trim()||'',
            roomNum:s.roomNum||''
        }));
        data[carTab]=block;
        return data;
    }

    function saveCarousel(){
        if(!window.AJ_HOTEL)return;
        setCarouselData(readCarouselForm());
        alert('Carrousel enregistré.');
        renderCarousel();
    }

    function addCarouselSlide(){
        if(!window.AJ_HOTEL)return;
        const data=readCarouselForm();
        const block=data[carTab]||{title:'',subtitle:'',slides:[]};
        block.slides=block.slides||[];
        block.slides.push({id:carTab+'-'+Date.now(),img:'',title:'',desc:'',roomNum:''});
        data[carTab]=block;
        setCarouselData(data);
        renderCarousel();
    }

    function deleteCarouselSlide(index){
        if(!confirm('Supprimer cette photo du carrousel ?'))return;
        const data=readCarouselForm();
        const block=data[carTab];
        if(!block?.slides)return;
        block.slides.splice(index,1);
        setCarouselData(data);
        renderCarousel();
    }

    function render(){
        loadHotelForm();
        renderUsers();
        renderCarousel();
        bindHabillage();
    }

    function init(){
        loadHotelForm();
        document.getElementById('cu_nom')?.addEventListener('change',onUserName);
        document.getElementById('cuSaveBtn')?.addEventListener('click',e=>{e.preventDefault();saveUser();});
        document.getElementById('cuNewBtn')?.addEventListener('click',e=>{e.preventDefault();userMsg('');newUser();});
        document.getElementById('cuCancelBtn')?.addEventListener('click',e=>{e.preventDefault();closeUserModal();});
        document.getElementById('cuClose')?.addEventListener('click',e=>{e.preventDefault();closeUserModal();});
        cuOverlay()?.addEventListener('click',e=>{if(e.target===cuOverlay())closeUserModal();});
        document.addEventListener('keydown',e=>{
            if(e.key==='Escape'&&cuOverlay()?.classList.contains('show'))closeUserModal();
        });
        window.PERS?.init();
        renderUsers();
        renderAuth();
        document.getElementById('auth_check_all')?.addEventListener('change',e=>setAllAuth(e.target.checked));
        document.querySelectorAll('.auth-col-all').forEach(col=>{
            col.addEventListener('change',e=>setAuthColumn(col.dataset.perm,e.target.checked));
        });
        document.getElementById('cfg_auth_tbody')?.addEventListener('change',e=>{
            if(e.target.matches('input[type=checkbox][data-menu]'))syncAuthMasters();
        });
        document.getElementById('cfg_auth_tbody')?.addEventListener('click',e=>{
            const btn=e.target.closest('.auth-fold');
            if(!btn)return;
            const sec=btn.dataset.sec;
            const closed=closedSecs.has(sec)?(closedSecs.delete(sec),false):(closedSecs.add(sec),true);
            const head=btn.closest('tr');
            head.classList.toggle('is-closed',closed);
            btn.setAttribute('aria-expanded',closed?'false':'true');
            btn.title=closed?'Afficher le module':'Masquer le module';
            document.querySelectorAll('#cfg_auth_tbody tr.auth-row').forEach(tr=>{
                if(tr.dataset.sec===sec)tr.classList.toggle('is-hidden',closed);
            });
        });
    }

    return{
        init,render,switchTab,
        saveHotel,
        saveUser,newUser,editUser,delUser,openAuth,refreshUserSources:()=>{
            if(editUserId)fillUserForm(usersCache.find(u=>u.id===editUserId)||null);
        },
        saveAuth,
        renderCarousel,saveCarousel,addCarouselSlide
    };
})();
window.CFG=CFG;
CFG.init();
</script>

<script>
/* ===== Module Config Chambres ===== */
const CHDISPO=(function(){
    const STATUS={disponible:'Disponible',occupee:'Occupée',reservee:'Réservée',nettoyage:'Nettoyage',maintenance:'Maintenance'};
    const ALL_STATUS=['disponible','occupee','reservee','nettoyage','maintenance'];
    const FILTERS=[['','Toutes'],['disponible','Disponibles'],['occupee','Occupées'],['reservee','Réservées'],['nettoyage','Nettoyage'],['maintenance','Maintenance']];
    const TYPE_LBL={'grand-suite':'Grand Suite','suite-junior':'Suite Junior',single:'Single',double:'Double',suite:'Grand Suite',familiale:'Double'};
    const TYPE_OPTS=[['grand-suite','Grand Suite'],['suite-junior','Suite Junior'],['single','Single'],['double','Double']];
    const FLOOR_OPTS=()=>window.AJ_HOTEL?.getFloors?.()?.length?window.AJ_HOTEL.getFloors():[1,2,3];
    const META_DEF={
        'grand-suite':{guests:4,size:'55 m²',view:'Vue panoramique',bed:'Lit King Size'},
        'suite-junior':{guests:3,size:'45 m²',view:'Vue mer',bed:'Lit King Size'},
        double:{guests:2,size:'32 m²',view:'Vue jardin',bed:'Lit double'},
        single:{guests:1,size:'28 m²',view:'Vue ville',bed:'Lit Queen'},
        suite:{guests:4,size:'55 m²',view:'Vue panoramique',bed:'Lit King Size'},
        familiale:{guests:2,size:'32 m²',view:'Vue jardin',bed:'Lit double'}
    };
    function normalizeType(t){
        if(t==='suite')return 'grand-suite';
        if(t==='familiale')return 'double';
        return TYPE_LBL[t]?t:'single';
    }
    const K_STATUS='aj_ch_status',K_RESA='aj_ch_resa';
    let filter='',floorFilter='',typeFilter='',bound=false;
    const esc=s=>{let t=s==null?'':String(s);const m=t.match(/^(\d{4})-(\d{2})-(\d{2})$/);if(m)t=m[3]+'/'+m[2]+'/'+m[1];return t.replace(/[&<>"]/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c]));};
    const fmtP=n=>ajMoneyDH(n);
    const load=k=>{try{return JSON.parse(localStorage.getItem(k)||'{}')||{};}catch(e){return{};}};
    const store=(k,v)=>localStorage.setItem(k,JSON.stringify(v));
    const floorLbl=f=>!f?'—':(Number(f)===1?'1er étage':f+'e étage');

    function statusOf(r){
        const resa=load(K_RESA)[r.num];
        let st=r.status||'disponible';
        if(resa?.validated)st=resa.statusChambre||'reservee';
        else{const s=load(K_STATUS)[r.num];if(s)st=s;}
        return STATUS[st]?st:'disponible';
    }

    function saveStatus(num,st){
        const statuses=load(K_STATUS);
        statuses[num]=st;
        store(K_STATUS,statuses);
        const resas=load(K_RESA);
        if(resas[num]){
            if(st==='occupee'||st==='reservee'){
                resas[num]={...resas[num],statusChambre:st,validated:true};
            }else delete resas[num];
            store(K_RESA,resas);
        }
        window.RESA?.render();
        window.CALEND?.render();
        window.DASH?.render();
        window.AJ_RESA_SYNC?.syncToServer();
        if((st==='occupee'||st==='reservee')&&typeof activatePanel==='function'){
            activatePanel(st==='occupee'?'ch-occupees':'ch-reservations',st==='occupee'?'C-Occupées':'Réservations');
        }
    }

    function rooms(){
        const base=window.AJ_HOTEL?window.AJ_HOTEL.getCatalog():[];
        return base.map(r=>({...r,status:statusOf(r)}));
    }

    function cardHtml(r){
        return`<article class="cc-card st-${r.status}" data-num="${esc(r.num)}" role="button" tabindex="0" title="Modifier la chambre ${esc(r.num)}">
            <div class="cc-img">
                <img src="${esc(r.img)}" alt="${esc(r.title)}" loading="lazy">
                <h3 class="cc-img-title"><span>Chambre ${esc(r.num)}</span>${esc(r.title)}</h3>
            </div>
            <div class="cc-info">
                <div><small>N°</small><b>${esc(r.num)}</b></div>
                <div><small>Type</small><b>${TYPE_LBL[r.type]||esc(r.type)}</b></div>
                <div><small>Étage</small><b>${floorLbl(r.floor)}</b></div>
                <div><small>Prix</small><b>${fmtP(r.price)}</b></div>
            </div>
            <div class="cc-status">${STATUS[r.status]}</div>
        </article>`;
    }

    function openModal(){
        const modal=document.getElementById('rmModal');
        modal?.classList.add('cc-edit-modal');
        document.getElementById('rmModalOverlay')?.classList.add('show');
    }
    function closeModal(){
        document.getElementById('rmModalOverlay')?.classList.remove('show');
        document.getElementById('rmModal')?.classList.remove('cc-edit-modal');
    }

    function showEdit(room){
        const box=document.getElementById('rmModalContent');
        if(!box)return;
        const type=normalizeType(room.type);
        const floors=FLOOR_OPTS();
        const floor=floors.includes(Number(room.floor))?Number(room.floor):(floors[0]||1);
        const meta=META_DEF[type]||META_DEF.single;
        let pickedStatus=STATUS[room.status]?room.status:'disponible';
        box.innerHTML=`<div class="cc-edit-hero">
            <img src="${esc(room.img)}" alt="${esc(room.title)}">
            <div class="cc-edit-hero-cap"><small>Chambre ${esc(room.num)}</small>${esc(room.title)}</div>
        </div>
        <div class="cc-edit-body">
            <p class="cc-edit-kicker">Fiche chambre</p>
            <div class="cc-edit-status">
                <label>Statut</label>
                <div class="cc-st-row" role="radiogroup">${ALL_STATUS.map(st=>`
                    <button type="button" class="cc-st-opt st-${st}${st===pickedStatus?' is-on':''}" data-st="${st}" role="radio" aria-checked="${st===pickedStatus}">
                        <span class="cc-dot"></span>${STATUS[st]}
                    </button>`).join('')}
                </div>
            </div>
            <form class="cc-edit-form" id="ccForm" onsubmit="return false" autocomplete="off">
                <div class="field"><label for="cc_title">Titre</label><input type="text" id="cc_title" value="${esc(room.title)}" placeholder="Nom de la chambre"></div>
                <div class="field"><label for="cc_type">Catégorie</label>
                    <select id="cc_type">${TYPE_OPTS.map(([k,l])=>`<option value="${k}"${k===type?' selected':''}>${l}</option>`).join('')}</select>
                </div>
                <div class="field"><label for="cc_floor">Étage</label>
                    <select id="cc_floor">${floors.map(f=>`<option value="${f}"${f===floor?' selected':''}>Étage ${f}</option>`).join('')}</select>
                </div>
                <div class="field"><label for="cc_price">Prix / nuit (DH)</label><input type="number" id="cc_price" min="0" step="0.01" value="${Number(room.price||0).toFixed(2)}"></div>
            </form>
            <div class="cc-edit-actions">
                <button type="button" class="btn gold" id="ccSave">Enregistrer</button>
                <button type="button" class="btn ghost" id="ccCancel">Annuler</button>
            </div>
        </div>`;

        box.querySelectorAll('.cc-st-opt').forEach(btn=>{
            btn.addEventListener('click',()=>{
                pickedStatus=btn.dataset.st;
                box.querySelectorAll('.cc-st-opt').forEach(b=>{
                    const on=b===btn;
                    b.classList.toggle('is-on',on);
                    b.setAttribute('aria-checked',on?'true':'false');
                });
            });
        });
        document.getElementById('ccSave')?.addEventListener('click',()=>{
            const title=(document.getElementById('cc_title')?.value||'').trim();
            if(!title){alert('Le titre est obligatoire.');return;}
            const nextType=normalizeType(document.getElementById('cc_type')?.value||type);
            const nextMeta=META_DEF[nextType]||meta;
            const data={
                title,
                type:nextType,
                floor:Number(document.getElementById('cc_floor')?.value)||floor,
                price:Number(document.getElementById('cc_price')?.value)||0,
                guests:room.guests||nextMeta.guests,
                size:room.size||nextMeta.size,
                view:room.view||nextMeta.view,
                bed:room.bed||nextMeta.bed,
                desc:room.desc||'',
                longDesc:room.longDesc||room.desc||'',
                img:room.hasPhoto?room.img:''
            };
            if(window.AJ_HOTEL)window.AJ_HOTEL.saveRoom(room.num,data);
            if(pickedStatus!==room.status)saveStatus(room.num,pickedStatus);
            closeModal();
            render();
            window.DASH?.render();
            window.CHETAT?.render();
        });
        document.getElementById('ccCancel')?.addEventListener('click',closeModal);
        openModal();
    }

    function render(){
        const grid=document.getElementById('ccGrid');
        const chipsBox=document.getElementById('ccChips');
        const floorSel=document.getElementById('ccFloor');
        const typeSel=document.getElementById('ccType');
        if(!grid||!window.AJ_HOTEL)return;
        const all=rooms().sort((a,b)=>String(a.num).localeCompare(String(b.num),undefined,{numeric:true}));
        const floors=[...new Set(all.map(r=>r.floor).filter(f=>f!=null&&f!==''))].sort((a,b)=>Number(a)-Number(b));
        if(floorSel){
            const cur=floorFilter||floorSel.value;
            floorSel.innerHTML='<option value="">Étage : Tous</option>'+floors.map(f=>`<option value="${esc(f)}">${floorLbl(f)}</option>`).join('');
            if(cur&&floors.some(f=>String(f)===String(cur))){floorSel.value=cur;floorFilter=String(cur);}
            else{floorSel.value='';floorFilter='';}
        }
        if(typeSel&&typeFilter)typeSel.value=typeFilter;
        const count={};
        all.forEach(r=>{count[r.status]=(count[r.status]||0)+1;});
        if(chipsBox){
            chipsBox.innerHTML=FILTERS.map(([k,l])=>{
                const n=k?(count[k]||0):all.length;
                return`<button type="button" class="dr-chip${filter===k?' is-on':''}${k?' st-'+k:''}" data-f="${k}">${l}<b>${n}</b></button>`;
            }).join('');
        }
        const list=all.filter(r=>
            (!filter||r.status===filter)&&
            (!floorFilter||String(r.floor)===String(floorFilter))&&
            (!typeFilter||r.type===typeFilter)
        );
        grid.innerHTML=list.length?list.map(cardHtml).join(''):'<p class="dr-empty">Aucune chambre ne correspond.</p>';
        if(!bound){
            const open=el=>{
                const card=el.closest('.cc-card');
                if(!card)return;
                const room=rooms().find(r=>r.num===card.dataset.num);
                if(room)showEdit(room);
            };
            grid.addEventListener('click',e=>open(e.target));
            grid.addEventListener('keydown',e=>{if(e.key==='Enter'||e.key===' '){e.preventDefault();open(e.target);}});
            chipsBox?.addEventListener('click',e=>{
                const chip=e.target.closest('.dr-chip');
                if(!chip)return;
                filter=chip.dataset.f||'';
                render();
            });
            floorSel?.addEventListener('change',e=>{floorFilter=e.target.value;render();});
            typeSel?.addEventListener('change',e=>{typeFilter=e.target.value;render();});
            bound=true;
        }
    }
    return{render};
})();
window.CHDISPO=CHDISPO;
</script>

<script>
window.ADMIN_CAN_MANAGE_ROOMS={{ $canManageRooms ? 'true' : 'false' }};
window.AJ_RESA_API=@json(url('admin/api/reservations'));
window.AJ_WEB_RESA_API=@json(url('admin/api/web-reservations'));
window.AJ_BELL=(function(){
    const API=window.AJ_WEB_RESA_API;
    const csrf=()=>document.querySelector('meta[name="csrf-token"]')?.content||'';
    const btn=document.getElementById('ajBellBtn');
    const dot=document.getElementById('ajBellDot');
    const panel=document.getElementById('ajBellPanel');
    const list=document.getElementById('ajBellList');
    const markAll=document.getElementById('ajBellMarkAll');
    let items=[];
    let open=false;
    let lastUnread=-1;
    let pollTimer=null;
    let busy=false;
    const esc=s=>String(s??'').replace(/[&<>"']/g,c=>({ '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;' }[c]));
    const frDate=iso=>{
        if(typeof ajDate==='function'){const d=ajDate(iso);if(d)return d;}
        const m=String(iso||'').match(/^(\d{4})-(\d{2})-(\d{2})/);
        return m?`${m[3]}/${m[2]}/${m[1]}`:(iso||'—');
    };
    function unread(){return items.filter(i=>!i.read).length;}
    function paintBell(n){
        const count=typeof n==='number'?n:unread();
        if(!btn||!dot)return;
        if(count>0){
            btn.classList.add('is-alert');
            dot.hidden=false;
            dot.textContent=String(count>99?'99+':count);
        }else{
            btn.classList.remove('is-alert');
            dot.hidden=true;
            dot.textContent='0';
        }
        lastUnread=count;
    }
    function paintList(){
        if(!list)return;
        const pending=items.filter(i=>!i.transferred);
        if(!pending.length){
            list.innerHTML='<p class="aj-bell-empty">Aucune alerte.</p>';
            return;
        }
        list.innerHTML=pending.slice(0,40).map(i=>`
            <article class="aj-bell-item${!i.read?' is-unread':''}" data-id="${esc(i.id)}" title="Transférer vers Réservations">
                <b>${esc(i.ref||'Demande web')} · Ch. ${esc(i.num)}</b>
                <span>${esc(i.nom||'Client')} · ${esc(i.tel||'—')}</span>
                <span>Arrivée ${esc(frDate(i.arrivee))} · ${esc(String(i.nuits||1))} nuit(s)</span>
                <span style="margin-top:4px;color:var(--gold);font-weight:700">Transférer → Réservations</span>
            </article>`).join('');
        list.querySelectorAll('.aj-bell-item').forEach(el=>{
            el.addEventListener('click',()=>transferToResa(el.dataset.id));
        });
    }
    function readLS(k,d){try{return JSON.parse(localStorage.getItem(k)||'null')||d;}catch(e){return d;}}
    function writeLS(k,v){localStorage.setItem(k,JSON.stringify(v));}
    async function transferToResa(id){
        const item=items.find(i=>i.id===id);
        if(!item)return;
        const num=String(item.num||'').trim();
        if(!num){alert('Chambre manquante sur cette demande.');return;}
        const nuits=Math.max(1,Number(item.nuits)||1);
        const tarif=Number(item.price)||0;
        const montant=tarif*nuits;
        const arrivee=String(item.arrivee||item.date||'').slice(0,10);
        const resas=readLS('aj_ch_resa',{});
        const cur=resas[num];
        if(cur?.validated&&(cur.statusChambre==='occupee'||cur.statusChambre==='reservee')){
            if(!confirm('La chambre '+num+' est déjà '+(cur.statusChambre==='occupee'?'occupée':'réservée')+'. Remplacer par cette demande web ?'))return;
        }
        const payload={
            num,
            date:arrivee,
            nom:item.nom||'',
            nationalite:item.nationalite||'',
            idType:item.idType||'CIN',
            cin:item.cin||'',
            personnes:Math.max(1,Number(item.personnes)||1),
            nuits,
            tarif,
            ttc:montant,
            montant,
            sous:montant,
            ht:montant,
            mnt:0,
            paye:0,
            tel:item.tel||'',
            email:item.email||'',
            commercial:'Web',
            ref:item.ref||'',
            title:item.title||'',
            validated:true,
            statusChambre:'reservee',
            source:'web',
            webId:item.id,
            pendingArrival:true,
            at:Date.now()
        };
        resas[num]={...(cur||{}),...payload};
        writeLS('aj_ch_resa',resas);
        const statuses=readLS('aj_ch_status',{});
        statuses[num]='reservee';
        writeLS('aj_ch_status',statuses);
        let log=readLS('aj_resa_log',[]);
        if(!Array.isArray(log))log=[];
        const seq=log.reduce((m,x)=>Math.max(m,parseInt(String(x.id).replace(/\D/g,''),10)||0),0)+1;
        const logId=item.ref||('R'+String(seq).padStart(4,'0'));
        const existing=log.findIndex(x=>String(x.num)===num&&!x.cancelled&&(x.ref===item.ref||x.webId===item.id));
        const row={
            id:existing>=0?(log[existing].id||logId):logId,
            ref:item.ref||logId,
            date:arrivee,
            num,
            floor:'',
            commercial:'Web',
            nom:payload.nom,
            nationalite:payload.nationalite,
            idType:payload.idType,
            cin:payload.cin,
            personnes:payload.personnes,
            nuits,
            tarif,
            montant,
            paye:0,
            type:'',
            tel:payload.tel,
            email:payload.email,
            statusChambre:'reservee',
            source:'web',
            webId:item.id,
            pendingArrival:true,
            at:Date.now()
        };
        if(existing>=0)log[existing]={...log[existing],...row};
        else log.push(row);
        writeLS('aj_resa_log',log);
        window.AJ_RESA_SYNC?.touchLocal?.();
        window.AJ_RESA_SYNC?.syncToServer?.();
        try{
            await fetch(API+'/remove',{
                method:'POST',credentials:'same-origin',
                headers:{
                    Accept:'application/json',
                    'Content-Type':'application/json',
                    'X-CSRF-TOKEN':csrf()
                },
                body:JSON.stringify({ids:[id]})
            });
        }catch(e){}
        items=items.filter(i=>i.id!==id);
        paintBell(unread());
        paintList();
        toggle(false);
        window.RESA?.render?.();
        window.CHETAT?.render?.();
        window.DASH?.render?.();
        window.CALEND?.render?.();
        window.BCL?.render?.();
        if(typeof activatePanel==='function')activatePanel('ch-reservations','Réservations');
    }
    async function refresh(){
        if(busy)return;
        busy=true;
        try{
            const res=await fetch(API,{credentials:'same-origin',headers:{Accept:'application/json'},cache:'no-store'});
            if(!res.ok)return;
            const data=await res.json();
            items=Array.isArray(data.items)?data.items:[];
            paintBell(typeof data.unread==='number'?data.unread:unread());
            if(open)paintList();
        }catch(e){}
        finally{busy=false;}
    }
    async function mark(ids){
        try{
            await fetch(API+'/read',{
                method:'POST',credentials:'same-origin',
                headers:{
                    Accept:'application/json',
                    'Content-Type':'application/json',
                    'X-CSRF-TOKEN':csrf()
                },
                body:JSON.stringify(ids?{ids}:{})
            });
        }catch(e){}
        await refresh();
    }
    function toggle(force){
        open=typeof force==='boolean'?force:!open;
        if(!panel||!btn)return;
        panel.hidden=!open;
        btn.setAttribute('aria-expanded',open?'true':'false');
        if(open)refresh();
    }
    function schedulePoll(){
        clearInterval(pollTimer);
        const ms=document.hidden?10000:2500;
        pollTimer=setInterval(refresh,ms);
    }
    btn?.addEventListener('click',e=>{e.stopPropagation();toggle();});
    markAll?.addEventListener('click',e=>{e.stopPropagation();mark(null);});
    document.addEventListener('click',e=>{
        if(!open)return;
        if(e.target.closest('#ajBellWrap'))return;
        toggle(false);
    });
    window.addEventListener('storage',e=>{
        if(e.key==='aj_web_resa_ping')refresh();
    });
    document.addEventListener('visibilitychange',()=>{
        schedulePoll();
        if(!document.hidden)refresh();
    });
    window.addEventListener('focus',()=>refresh());
    try{
        if(typeof BroadcastChannel!=='undefined'){
            const ch=new BroadcastChannel('aj_web_resa');
            ch.onmessage=()=>refresh();
        }
    }catch(e){}
    refresh();
    schedulePoll();
    return{refresh,toggle};
})();
window.AJ_RESA_SYNC=(function(){
    const API=window.AJ_RESA_API;
    const csrf=()=>document.querySelector('meta[name="csrf-token"]')?.content||'';
    const read=(k,d)=>{try{return JSON.parse(localStorage.getItem(k)||'null')||d;}catch(e){return d;}};
    let localWriteAt=0;
    const touchLocal=()=>{localWriteAt=Date.now();};
    async function pull(){
        const startedAt=Date.now();
        try{
            const res=await fetch(API,{credentials:'same-origin',headers:{Accept:'application/json'}});
            if(!res.ok)return false;
            const data=await res.json();
            /* Ne pas écraser une saisie locale faite pendant le fetch */
            if(localWriteAt>startedAt)return false;
            if(data.resas&&typeof data.resas==='object')localStorage.setItem('aj_ch_resa',JSON.stringify(data.resas));
            if(Array.isArray(data.log))localStorage.setItem('aj_resa_log',JSON.stringify(data.log));
            if(data.statuses&&typeof data.statuses==='object')localStorage.setItem('aj_ch_status',JSON.stringify(data.statuses));
            return true;
        }catch(e){return false;}
    }
    async function push(){
        try{
            const body={
                resas:read('aj_ch_resa',{}),
                log:read('aj_resa_log',[]),
                statuses:read('aj_ch_status',{})
            };
            const res=await fetch(API,{
                method:'POST',credentials:'same-origin',
                headers:{
                    Accept:'application/json',
                    'Content-Type':'application/json',
                    'X-CSRF-TOKEN':csrf()
                },
                body:JSON.stringify(body)
            });
            return res.ok;
        }catch(e){return false;}
    }
    function refreshUi(){
        window.DASH?.render();
        window.RESA?.render();
        window.CALEND?.render();
        window.CHETAT?.render();
        window.CHDISPO?.render();
        window.BCL?.render();
        window.BPY?.render();
    }
    async function syncFromServer(){
        const ok=await pull();
        if(ok)refreshUi();
        return ok;
    }
    async function syncToServer(){
        return push();
    }
    return{pull,push,syncFromServer,syncToServer,refreshUi,touchLocal};
})();
window.ADMIN_ROLE='{{ $adminLogin }}';
/* ===== Module État Chambres ===== */
const CHETAT=(function(){
    const CAN_MANAGE=window.ADMIN_CAN_MANAGE_ROOMS===true;
    const STATUS={occupee:'Occupée',disponible:'Disponible',reservee:'Réservée',nettoyage:'Nettoyage',maintenance:'Maintenance'};
    const ALL_STATUS=['disponible','occupee','reservee','nettoyage','maintenance'];
    const MSG={
        occupee:'Occupée',
        reservee:'Réservée',
        nettoyage:'Veuillez Attendre',
        maintenance:'DSL ! la chambre est en maintenance'
    };
    const MSG_ICON={occupee:'&#128719;',reservee:'&#128467;',nettoyage:'&#128736;',maintenance:'&#9888;'};
    const TYPE_LBL={'grand-suite':'Grand Suite','suite-junior':'Suite Junior',single:'Single',double:'Double',suite:'Grand Suite',familiale:'Double'};
    const CAT_LBL={'grand-suite':'Grand Suite','suite-junior':'Suite Junior',single:'Single',double:'Double',suite:'Grand Suite',familiale:'Double'};
    const CAT_TITLE={'grand-suite':'Grand Suites','suite-junior':'Suites Junior',single:'Chambres Singles',double:'Chambres Doubles',suite:'Grand Suites',familiale:'Chambres Doubles'};
    const ROOM_META={
        'grand-suite':{guests:4,size:'55 m²',view:'Vue panoramique',bed:'Lit King Size'},
        'suite-junior':{guests:3,size:'45 m²',view:'Vue mer',bed:'Lit King Size'},
        double:{guests:2,size:'32 m²',view:'Vue jardin',bed:'Lit double'},
        single:{guests:1,size:'28 m²',view:'Vue ville',bed:'Lit Queen'},
        suite:{guests:4,size:'55 m²',view:'Vue panoramique',bed:'Lit King Size'},
        familiale:{guests:2,size:'32 m²',view:'Vue jardin',bed:'Lit double'}
    };
    const STAT_ICO={total:'&#128719;',disponible:'&#10003;',occupee:'&#128100;',reservee:'&#128467;',nettoyage:'&#128736;',maintenance:'&#9881;'};
    const TVA_RATE=.10;
    const K_RESA='aj_ch_resa';
    const K_STATUS='aj_ch_status';
    const K_CONTENU='aj_ch_contenu';
    const PIECES=['Salon','Chambre à coucher','Cuisine','Salle de bain','Dressing'];
    const FILE_ICO='<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="8" y1="13" x2="16" y2="13"/><line x1="8" y1="17" x2="13" y2="17"/></svg>';
    let invNum=null;
    let ROOMS=[],currentFilter={q:'',floor:'',cat:'',status:''},viewMode='grid',selectedNum=null,bound=false,currentRoom=null;

    const esc=s=>{let t=s==null?'':String(s);const m=t.match(/^(\d{4})-(\d{2})-(\d{2})$/);if(m)t=m[3]+'/'+m[2]+'/'+m[1];return t.replace(/[&<>"]/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c]));};
    const fmtP=n=>ajMoneyDH(n);
    const num=v=>Number(v)||0;
    const fmtAmt=v=>ajMoney(v);
    const today=()=>new Date().toISOString().slice(0,10);
    const pct=(n,t)=>t?((n/t)*100).toFixed(1)+'%':'0%';
    const floorLbl=f=>f===1?'1er étage':f+'e étage';

    function loadCatalogRooms(){
        const base=window.AJ_HOTEL?window.AJ_HOTEL.getCatalog():[];
        return base.map(r=>({...r,status:r.status||'disponible',longDesc:r.longDesc||r.desc}));
    }
    const getResas=()=>{try{return JSON.parse(localStorage.getItem(K_RESA)||'{}')||{};}catch(e){return{};}};
    const setResas=o=>{
        localStorage.setItem(K_RESA,JSON.stringify(o));
        window.AJ_RESA_SYNC?.touchLocal?.();
    };
    const getStatuses=()=>{try{return JSON.parse(localStorage.getItem(K_STATUS)||'{}')||{};}catch(e){return{};}};
    const setStatuses=o=>{
        localStorage.setItem(K_STATUS,JSON.stringify(o));
        window.AJ_RESA_SYNC?.touchLocal?.();
    };
    const saveRoomStatus=(n,st)=>{const s=getStatuses();s[String(n)]=st;setStatuses(s);};
    const saveRoomData=(n,d)=>{if(window.AJ_HOTEL)window.AJ_HOTEL.saveRoom(n,d);};
    const roomByNum=n=>ROOMS.find(r=>r.num===n);
    const metaFor=r=>{
        const m={...(ROOM_META[r.type]||ROOM_META.single)};
        ['guests','size','view','bed'].forEach(k=>{if(r[k]!=null&&r[k]!=='')m[k]=r[k];});
        return m;
    };

    function syncFromStorage(){
        const statuses=getStatuses(),resas=getResas(),statusMap={};
        ROOMS.forEach(r=>{statusMap[String(r.num)]=r.status;});
        ROOMS=loadCatalogRooms();
        ROOMS.forEach(r=>{
            const key=String(r.num);
            const resa=resas[key]||resas[r.num];
            const st=statuses[key]||statuses[r.num];
            if(resa?.validated)r.status=resa.statusChambre||'reservee';
            else if(st)r.status=st;
            else if(statusMap[key])r.status=statusMap[key];
        });
    }

    function loadContenu(){
        try{const o=JSON.parse(localStorage.getItem(K_CONTENU)||'{}');return o&&typeof o==='object'?o:{};}
        catch(e){return {};}
    }
    function saveContenu(all){localStorage.setItem(K_CONTENU,JSON.stringify(all));}
    function itemsOf(num){
        const list=loadContenu()[num];
        return Array.isArray(list)?list.filter(it=>it&&it.item&&it.piece):[];
    }
    function fileBtnHtml(num){
        const n=itemsOf(num).length;
        return `<button type="button" class="ch-rc-file" title="Contenu de la chambre" aria-label="Contenu de la chambre ${esc(num)}">${FILE_ICO}${n?`<span class="ch-rc-file-n">${n}</span>`:''}</button>`;
    }
    function paintFileBadge(num){
        const n=itemsOf(num).length;
        document.querySelectorAll(`.ch-room-card[data-num="${num}"] .ch-rc-file, .cal-fiche[data-num="${num}"], .dr-fiche[data-num="${num}"]`).forEach(btn=>{
            let badge=btn.querySelector('.ch-rc-file-n');
            if(!n){badge?.remove();return;}
            if(!badge){badge=document.createElement('span');badge.className='ch-rc-file-n';btn.appendChild(badge);}
            badge.textContent=String(n);
        });
    }

    function openRoomFiche(num){
        syncFromStorage();
        const room=roomByNum(num)||(window.AJ_HOTEL?window.AJ_HOTEL.getRoom(num):null);
        if(!room)return;
        openContenu({...room,num:String(num)});
    }
    function groupItems(list){
        const map=new Map();
        list.forEach(it=>{
            const label=String(it.piece).trim();
            const key=label.toLocaleLowerCase('fr');
            if(!map.has(key))map.set(key,{label,items:[]});
            map.get(key).items.push(it);
        });
        const rank=label=>{const i=PIECES.findIndex(p=>p.toLocaleLowerCase('fr')===label.toLocaleLowerCase('fr'));return i<0?1000:i;};
        return [...map.values()].sort((a,b)=>rank(a.label)-rank(b.label)||a.label.localeCompare(b.label,'fr'));
    }
    function pieceOptions(num){
        const known=new Set(PIECES.map(p=>p.toLocaleLowerCase('fr')));
        const extra=[];
        itemsOf(num).forEach(it=>{
            const label=String(it.piece).trim();
            if(!known.has(label.toLocaleLowerCase('fr'))&&!extra.some(p=>p.toLocaleLowerCase('fr')===label.toLocaleLowerCase('fr')))extra.push(label);
        });
        return PIECES.concat(extra);
    }
    function paintContenu(room){
        const title=document.getElementById('chInvTitle');
        const sub=document.getElementById('chInvSub');
        const body=document.getElementById('chInvBody');
        if(!body)return;
        if(title)title.textContent='Chambre '+room.num;
        if(sub)sub.textContent=room.title||'';
        const groups=groupItems(itemsOf(room.num));
        if(!groups.length){
            body.innerHTML='<p class="ch-inv-empty">Aucun contenu enregistré pour cette chambre.<br>Les équipements seront saisis ultérieurement.</p>';
            return;
        }
        body.innerHTML=groups.map(g=>`<section class="ch-inv-piece"><h4>${esc(g.label)}</h4><ul>${g.items.map(it=>`<li><span>${esc(it.item)}</span><button type="button" class="ch-inv-del" data-id="${esc(it.id)}">Retirer</button></li>`).join('')}</ul></section>`).join('');
    }
    function openContenu(room){
        invNum=room.num;
        paintContenu(room);
        document.getElementById('chInvOverlay')?.classList.add('show');
    }
    function closeContenu(){
        document.getElementById('chInvOverlay')?.classList.remove('show');
        invNum=null;
    }
    function openAdd(room){
        invNum=room.num;
        const title=document.getElementById('chInvAddTitle');
        const sub=document.getElementById('chInvAddSub');
        const sel=document.getElementById('chInvPiece');
        const note=document.getElementById('chInvNote');
        const item=document.getElementById('chInvItem');
        const custom=document.getElementById('chInvPieceCustom');
        if(title)title.textContent='Chambre '+room.num;
        if(sub)sub.textContent=room.title||'';
        if(sel){
            sel.innerHTML=pieceOptions(room.num).map(p=>`<option value="${esc(p)}">${esc(p)}</option>`).join('')+'<option value="__autre">Autre…</option>';
        }
        document.getElementById('chInvPieceCustomWrap')?.classList.remove('is-on');
        if(custom)custom.value='';
        if(item)item.value='';
        if(note)note.textContent='';
        document.getElementById('chInvAddOverlay')?.classList.add('show');
        setTimeout(()=>item?.focus(),30);
    }
    function closeAdd(){document.getElementById('chInvAddOverlay')?.classList.remove('show');}
    function addContenu(room){
        const sel=document.getElementById('chInvPiece');
        const custom=document.getElementById('chInvPieceCustom');
        const itemEl=document.getElementById('chInvItem');
        const note=document.getElementById('chInvNote');
        let piece=sel?sel.value:'';
        if(piece==='__autre')piece=(custom?.value||'').trim();
        else piece=String(piece||'').trim();
        const item=(itemEl?.value||'').trim();
        if(!piece){if(note){note.style.color='#c05050';note.textContent='Indiquez la pièce.';}return;}
        if(!item){if(note){note.style.color='#c05050';note.textContent='Indiquez l\'équipement.';}return;}
        const all=loadContenu();
        const list=Array.isArray(all[room.num])?all[room.num]:[];
        list.push({id:'c'+Date.now().toString(36)+Math.random().toString(36).slice(2,6),piece,item});
        all[room.num]=list;
        saveContenu(all);
        paintFileBadge(room.num);
        if(itemEl)itemEl.value='';
        if(note){note.style.color='#059669';note.textContent=item+' ajouté — '+piece+'.';}
        if(sel&&piece&&![...sel.options].some(o=>o.value.toLocaleLowerCase('fr')===piece.toLocaleLowerCase('fr'))){
            const opt=document.createElement('option');
            opt.value=piece;opt.textContent=piece;
            sel.insertBefore(opt,sel.querySelector('option[value="__autre"]'));
            sel.value=piece;
            document.getElementById('chInvPieceCustomWrap')?.classList.remove('is-on');
            if(custom)custom.value='';
        }
        itemEl?.focus();
    }
    function removeContenu(num,id){
        const all=loadContenu();
        all[num]=(Array.isArray(all[num])?all[num]:[]).filter(it=>it.id!==id);
        if(!all[num].length)delete all[num];
        saveContenu(all);
        paintFileBadge(num);
        const room=roomByNum(num);
        if(room)paintContenu(room);
    }

    function cardHtml(r,idx){
        const m=metaFor(r);
        return`<article class="ch-room-card st-${r.status}${selectedNum===r.num?' is-selected':''}" data-num="${r.num}" data-type="${r.type}" data-status="${r.status}" data-floor="${r.floor}" data-slot="${idx}" style="--ch-slot:${idx}" role="button" tabindex="0">
            <div class="ch-rc-img" title="Ajouter un contenu">
                <img src="${esc(r.img)}" alt="${esc(r.title)}" loading="eager" decoding="async">
                ${fileBtnHtml(r.num)}
                <span class="ch-rc-badge st-${r.status}">${STATUS[r.status]}</span>
            </div>
            <div class="ch-rc-body">
                <div class="ch-rc-num">${esc(r.num)}</div>
                <div class="ch-rc-title">${esc(r.title)}</div>
                <div class="ch-rc-meta">
                    <span>&#128101; ${m.guests}</span>
                    <span>&#9632; ${m.size}</span>
                    <span>&#127749; ${m.view}</span>
                </div>
                <div class="ch-rc-price">${fmtP(r.price)} <small>/ nuit</small></div>
            </div>
        </article>`;
    }

    function renderStats(){
        const c={total:ROOMS.length,disponible:0,occupee:0,reservee:0,nettoyage:0,maintenance:0};
        ROOMS.forEach(r=>{if(c[r.status]!=null)c[r.status]++;});
        const set=(id,val)=>{const el=document.getElementById(id);if(el)el.textContent=val;};
        set('statTotal',c.total);
        set('statDispo',c.disponible);
        set('statOccu',c.occupee);
        set('statResa',c.reservee);
        set('statNett',c.nettoyage);
        set('statMaint',c.maintenance);
        set('statDispoPct',pct(c.disponible,c.total));
        set('statOccuPct',pct(c.occupee,c.total));
        set('statResaPct',pct(c.reservee,c.total));
        set('statNettPct',pct(c.nettoyage,c.total));
        set('statMaintPct',pct(c.maintenance,c.total));
    }

    function refreshCardDom(room){
        const card=document.querySelector(`.ch-room-card[data-num="${room.num}"]`);
        if(!card)return;
        const wasHidden=card.classList.contains('hidden-filter');
        const slot=card.dataset.slot||'0';
        card.dataset.status=room.status;
        card.dataset.type=room.type;
        card.dataset.floor=String(room.floor);
        card.className=`ch-room-card st-${room.status}${selectedNum===room.num?' is-selected':''}${wasHidden?' hidden-filter':''}`;
        card.dataset.slot=slot;
        card.style.setProperty('--ch-slot',slot);
        card.style.transform='none';
        card.style.translate='none';
        const badge=card.querySelector('.ch-rc-badge');
        if(badge){badge.className=`ch-rc-badge st-${room.status}`;badge.textContent=STATUS[room.status];}
        const title=card.querySelector('.ch-rc-title');
        if(title)title.textContent=room.title;
        const price=card.querySelector('.ch-rc-price');
        if(price)price.innerHTML=`${fmtP(room.price)} <small>/ nuit</small>`;
        const img=card.querySelector('.ch-rc-img img');
        if(img&&room.img)img.src=room.img;
    }

    function applyFilters(){
        document.querySelectorAll('.ch-room-card').forEach(card=>{
            const r=roomByNum(card.dataset.num);
            const show=!!(r&&matchesFilter(r));
            card.classList.toggle('hidden-filter',!show);
            card.setAttribute('aria-hidden',show?'false':'true');
            /* Verrouillage dur : jamais display:none (évite le reflow) */
            card.style.display='flex';
            card.style.visibility=show?'visible':'hidden';
            card.style.opacity=show?'1':'0';
            card.style.pointerEvents=show?'auto':'none';
            card.style.transform='none';
            card.style.translate='none';
            card.style.position='relative';
            card.style.top='auto';
            card.style.left='auto';
            card.style.order='0';
        });
    }

    function populateFloorFilter(){
        const sel=document.getElementById('chFilterFloor');
        if(!sel)return;
        const floors=[...new Set(ROOMS.map(r=>r.floor))].sort((a,b)=>a-b);
        const cur=sel.value;
        sel.innerHTML='<option value="">Étage : Tous</option>'+floors.map(f=>`<option value="${f}">${floorLbl(f)}</option>`).join('');
        if(cur)sel.value=cur;
    }

    function matchesFilter(r){
        const q=currentFilter.q.toLowerCase();
        if(q&&!(`${r.num} ${r.title} ${r.desc}`.toLowerCase().includes(q)))return false;
        if(currentFilter.floor&&String(r.floor)!==currentFilter.floor)return false;
        if(currentFilter.cat&&r.type!==currentFilter.cat)return false;
        if(currentFilter.status&&r.status!==currentFilter.status)return false;
        return true;
    }

    function openModal(wide){
        const modal=document.getElementById('rmModal');
        modal?.classList.toggle('rm-resa-wide',!!wide);
        document.getElementById('rmModalOverlay')?.classList.add('show');
    }
    function closeModal(){
        document.getElementById('rmModalOverlay')?.classList.remove('show');
        document.getElementById('rmModal')?.classList.remove('rm-resa-wide','cc-edit-modal');
        currentRoom=null;
    }

    function populateDetailFloorSelects(activeRoom){
        const floorSel=document.getElementById('chDpFloorSelect');
        const roomSel=document.getElementById('chDpRoomSelect');
        if(!floorSel||!roomSel)return;
        const floors=[...new Set(ROOMS.map(r=>r.floor))].sort((a,b)=>a-b);
        const curFloor=activeRoom?String(activeRoom.floor):(floorSel.value||'');
        floorSel.innerHTML='<option value="">Choisir un étage…</option>'+
            floors.map(f=>`<option value="${f}">${floorLbl(f)}</option>`).join('');
        if(curFloor&&floors.some(f=>String(f)===curFloor))floorSel.value=curFloor;
        const floor=floorSel.value;
        const roomsOnFloor=floor
            ?ROOMS.filter(r=>String(r.floor)===String(floor)).slice().sort((a,b)=>String(a.num).localeCompare(String(b.num),undefined,{numeric:true}))
            :[];
        roomSel.innerHTML='<option value="">Choisir une chambre…</option>'+
            roomsOnFloor.map(r=>`<option value="${esc(r.num)}">${esc(r.num)} — ${esc(r.title)}</option>`).join('');
        roomSel.disabled=!floor;
        if(activeRoom&&roomsOnFloor.some(r=>r.num===activeRoom.num))roomSel.value=activeRoom.num;
    }

    function bindDetailFloorSelects(){
        const floorSel=document.getElementById('chDpFloorSelect');
        const roomSel=document.getElementById('chDpRoomSelect');
        if(!floorSel||floorSel.dataset.bound==='1')return;
        floorSel.dataset.bound='1';
        floorSel.addEventListener('change',()=>{
            const floor=floorSel.value;
            if(!floor){
                selectedNum=null;
                document.querySelectorAll('.ch-room-card.is-selected').forEach(c=>c.classList.remove('is-selected'));
                populateDetailFloorSelects(null);
                renderDetailEmpty();
                return;
            }
            const first=ROOMS.filter(r=>String(r.floor)===String(floor))
                .sort((a,b)=>String(a.num).localeCompare(String(b.num),undefined,{numeric:true}))[0];
            if(first)showDetail(first);
            else{
                selectedNum=null;
                populateDetailFloorSelects({floor:Number(floor)});
                const box=document.getElementById('chDetailContent');
                if(box)box.innerHTML=`<div class="ch-dp-empty"><div class="ch-dp-empty-ico">&#128719;</div><h4>Aucune chambre</h4><p>Pas de chambre sur cet étage.</p></div>`;
            }
        });
        roomSel.addEventListener('change',()=>{
            const num=roomSel.value;
            if(!num){
                selectedNum=null;
                document.querySelectorAll('.ch-room-card.is-selected').forEach(c=>c.classList.remove('is-selected'));
                const box=document.getElementById('chDetailContent');
                if(box)box.innerHTML=`<div class="ch-dp-empty"><div class="ch-dp-empty-ico">&#128719;</div><h4>Fiche chambre</h4><p>Choisissez une chambre dans la liste.</p></div>`;
                return;
            }
            const room=roomByNum(num);
            if(room)showDetail(room);
        });
    }

    function renderDetailEmpty(){
        const box=document.getElementById('chDetailContent');
        if(!box)return;
        box.innerHTML=`<div class="ch-dp-empty">
            <div class="ch-dp-empty-ico">&#128719;</div>
            <h4>Fiche chambre</h4>
            <p>Sélectionnez un étage puis une chambre, ou cliquez le texte d'une carte.</p>
        </div>`;
    }

    function closeDetail(){
        selectedNum=null;
        document.getElementById('chDetailPanel')?.classList.remove('is-open');
        document.querySelector('.ch-manage-wrap')?.classList.remove('is-detail-open');
        document.getElementById('chDetailPanel')?.setAttribute('aria-hidden','true');
        document.querySelectorAll('.ch-room-card.is-selected').forEach(c=>c.classList.remove('is-selected'));
        populateDetailFloorSelects(null);
        const floorSel=document.getElementById('chDpFloorSelect');
        const roomSel=document.getElementById('chDpRoomSelect');
        if(floorSel)floorSel.value='';
        if(roomSel){roomSel.innerHTML='<option value="">Choisir une chambre…</option>';roomSel.disabled=true;}
        renderDetailEmpty();
    }

    function showDetail(room){
        selectedNum=room.num;
        const panel=document.getElementById('chDetailPanel');
        const box=document.getElementById('chDetailContent');
        if(!panel||!box)return;
        document.querySelectorAll('.ch-room-card').forEach(c=>c.classList.toggle('is-selected',c.dataset.num===room.num));
        populateDetailFloorSelects(room);
        const m=metaFor(room);
        box.innerHTML=`
            <div class="ch-dp-hero">
                <img src="${esc(room.img)}" alt="${esc(room.title)}">
                <div class="ch-dp-hero-top">
                    <span class="ch-dp-status st-${room.status}">${STATUS[room.status]}</span>
                    <button type="button" class="ch-dp-close" id="chDpClose" aria-label="Fermer">&times;</button>
                </div>
                <div class="ch-dp-hero-info">
                    <div class="ch-dp-num">${esc(room.num)}</div>
                    <div class="ch-dp-title">${esc(room.title)}</div>
                </div>
            </div>
            <div class="ch-dp-price-band">
                <div>
                    <div class="lbl">Tarif nuit</div>
                    <div class="val">${fmtP(room.price)} <small>/ nuit</small></div>
                </div>
            </div>
            <div class="ch-dp-body">
                <div class="ch-dp-specs">
                    <span>&#128101;<b>${m.guests} Pers.</b></span>
                    <span>&#9632;<b>${m.size}</b></span>
                    <span>&#128719;<b>${m.bed}</b></span>
                    <span>&#127749;<b>${m.view}</b></span>
                </div>
                <div class="ch-dp-attrs">
                    <div class="ch-dp-row"><span>Catégorie</span><strong>${esc(CAT_LBL[room.type]||room.title)}</strong></div>
                    <div class="ch-dp-row"><span>Étage</span><strong>${floorLbl(room.floor)}</strong></div>
                    <div class="ch-dp-row"><span>Statut</span><strong>${STATUS[room.status]}</strong></div>
                </div>
                <div>
                    <span class="ch-dp-section-lbl">Description</span>
                    <p class="ch-dp-desc">${esc(room.longDesc||room.desc)}</p>
                </div>
                <div>
                    <span class="ch-dp-section-lbl">Équipements</span>
                    <div class="ch-dp-equip">
                        <span title="Wi-Fi">&#128246;</span><span title="TV">&#128250;</span><span title="Parking">&#127359;</span>
                        <span title="Coffre">&#128274;</span><span title="Café">&#9749;</span><span title="Climatisation">&#10052;</span>
                    </div>
                </div>
                <div class="ch-dp-actions">
                    <button type="button" class="ch-btn-primary" id="chDpEdit">Modifier</button>
                    <button type="button" class="ch-btn-outline" id="chDpDetails">Détails</button>
                    <button type="button" class="ch-dp-danger" id="chDpHors">Mettre hors service</button>
                </div>
            </div>`;
        panel.classList.add('is-open');
        panel.setAttribute('aria-hidden','false');
        document.querySelector('.ch-manage-wrap')?.classList.add('is-detail-open');
        document.getElementById('chDpClose')?.addEventListener('click',closeDetail);
        document.getElementById('chDpEdit')?.addEventListener('click',()=>showEditRoom(room));
        document.getElementById('chDpDetails')?.addEventListener('click',()=>onRoomClick(room));
        document.getElementById('chDpHors')?.addEventListener('click',()=>{
            if(confirm('Mettre la chambre '+room.num+' hors service (maintenance) ?')){
                changeRoomStatus(room,'maintenance');
                showDetail(roomByNum(room.num)||room);
            }
        });
    }

    function showMessage(room,status){
        const box=document.getElementById('rmModalContent');
        if(!box)return;
        box.innerHTML=`<div class="rm-msg st-${status}">
            <div class="rm-msg-dot">${MSG_ICON[status]||'&#9432;'}</div>
            <h3>${esc(MSG[status]||STATUS[status])}</h3>
            <p style="color:var(--muted);font-size:14px;margin:0">Chambre ${esc(room.num)} — ${esc(room.title)}</p>
        </div>`;
        openModal();
    }

    const PAY_PILLS=[
        {id:'Esp',label:'Esp',mode:'simple'},
        {id:'Carte Visa',label:'Carte Visa',mode:'simple'},
        {id:'Vir mobile',label:'Vir mobile',mode:'simple'},
        {id:'Chq',label:'Chq',mode:'inst'},
        {id:'Eff',label:'Eff',mode:'inst'},
        {id:'Vers',label:'Vers',mode:'inst'}
    ];
    const PAY_TYPES=PAY_PILLS.map(p=>p.id);
    const ID_TYPES=['CIN','Passport','Carte séjour'];
    const PAY_EXTRA=['rf_nreg','rf_bnq','rf_tire','rf_encaisse'];
    const normalizePayType=t=>{
        const v=String(t||'').trim();
        if(!v)return '';
        if(PAY_TYPES.includes(v))return v;
        const low=v.toLowerCase();
        if(low==='espèces'||low==='especes'||low==='esp')return 'Esp';
        if(low==='carte visa'||low==='carte bancaire'||low==='carte'||low==='visa')return 'Carte Visa';
        if(low==='vir mobile'||low==='virmobile'||low==='mobile')return 'Vir mobile';
        if(low==='chq'||low==='chèque'||low==='cheque')return 'Chq';
        if(low==='eff'||low==='effet')return 'Eff';
        if(low==='vers'||low==='versement'||low==='vir'||low==='virement')return 'Vers';
        return v;
    };
    const payModeOf=t=>{
        const id=normalizePayType(t);
        return PAY_PILLS.find(p=>p.id===id)?.mode||'simple';
    };
    const isCashPay=t=>payModeOf(t)==='simple';
    const dateFr=v=>{
        if(!v)return typeof ajDate==='function'?ajDate(today()):today();
        if(typeof ajDate==='function'&&/^\d{4}-\d{2}-\d{2}/.test(String(v)))return ajDate(v);
        return String(v);
    };
    function commercialNames(){
        let list=[];
        try{list=JSON.parse(localStorage.getItem('aj_cfg_users_noms')||localStorage.getItem('aj_cfg_commerciaux')||'[]')||[];}catch(e){}
        return [...new Set((list||[]).map(c=>c&&String(c.nom||'').trim()).filter(Boolean))]
            .sort((a,b)=>String(a).localeCompare(String(b),'fr',{sensitivity:'base'}));
    }
    function sessionCommercialName(){
        const s=window.AJ_SESSION||{};
        return String(s.nom||s.login||'').trim();
    }

    function commercialFieldHtml(selected){
        const me=sessionCommercialName()||selected||'';
        return`<input type="text" id="rf_commercial" class="is-locked-comm" value="${esc(me)}" readonly tabindex="-1" title="Responsable connecté (login)">`;
    }

    function formHtml(room,data){
        const d=data||{};
        const typeVal=normalizePayType(d.type||'');
        const idType=ID_TYPES.includes(d.idType)?d.idType:(d.idType||'CIN');
        const commercial=d.commercial||sessionCommercialName()||'';
        const mntVal=d.mnt!=null?d.mnt:(d.paye!=null?d.paye:'');
        const docPreview=d.idDoc
            ?(String(d.idDoc).startsWith('data:application/pdf')||String(d.idDocName||'').toLowerCase().endsWith('.pdf')
                ?`<div class="rf-doc-pdf">PDF · ${esc(d.idDocName||'document.pdf')}</div>`
                :`<img src="${esc(d.idDoc)}" alt="Pièce d'identité">`)
            :`<div class="rf-doc-ph"><em>Importer</em><span>Photo ou PDF du document</span></div>`;
        return`<div class="rm-form-head simple"><h3>Réservation — Chambre ${esc(room.num)}</h3></div>
        <form id="rfForm" onsubmit="return false">
            <div class="rm-form-sec">
                <h4 class="rm-form-sec-title">Info technique</h4>
                <div class="rm-form-grid cols-4">
                    <div class="field"><label>N° Chambre</label><input type="text" id="rf_num" value="${esc(room.num)}" readonly></div>
                    <div class="field"><label>N° Étage</label><input type="text" id="rf_floor" value="${esc(floorLbl(room.floor))}" readonly></div>
                    <div class="field"><label>Date saisie</label><input type="text" id="rf_date" value="${esc(dateFr(d.date||today()))}" readonly></div>
                    <div class="field"><label>Responsable</label>${commercialFieldHtml(commercial)}</div>
                </div>
            </div>
            <div class="rm-pers-doc">
                <div class="rm-form-sec">
                    <h4 class="rm-form-sec-title">Infos personnel</h4>
                    <div class="rm-form-grid pers-line">
                        <div class="field"><label>Nom complet</label><input type="text" id="rf_nom" value="${esc(d.nom||'')}" placeholder="Nom et prénom"></div>
                        <div class="field"><label>Nationalité</label><input type="text" id="rf_nationalite" value="${esc(d.nationalite||'')}" placeholder="Marocaine"></div>
                        <div class="field"><label>Identifiant</label>
                            <select id="rf_idType">${ID_TYPES.map(t=>`<option value="${esc(t)}"${idType===t?' selected':''}>${esc(t)}</option>`).join('')}</select>
                        </div>
                        <div class="field"><label>N°</label><input type="text" id="rf_cin" value="${esc(d.cin||'')}" placeholder="N° document"></div>
                    </div>
                </div>
                <div class="rm-form-sec">
                    <h4 class="rm-form-sec-title">Cadre photo</h4>
                    <div class="rf-doc${d.idDoc?' has-file':''}" id="rfDocBox">
                        <div class="rf-doc-head">CIN / Passport / Carte séjour</div>
                        <div class="rf-doc-body">
                            <div class="rf-doc-preview" id="rfDocPreview">${docPreview}</div>
                            <input type="hidden" id="rf_idDoc" value="${d.idDoc?esc(d.idDoc):''}">
                            <input type="hidden" id="rf_idDocName" value="${esc(d.idDocName||'')}">
                            <input type="file" id="rf_doc" accept="image/*,application/pdf,.pdf" hidden>
                            <div class="rf-doc-actions">
                                <button type="button" class="is-gold" id="rfDocImport">Importer</button>
                                <button type="button" id="rfDocClear"${d.idDoc?'':' disabled'}>Retirer</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="rm-form-sec">
                <h4 class="rm-form-sec-title">Hébergement</h4>
                <div class="rm-form-grid cols-4">
                    <div class="field"><label>Nbrs Personnes</label><input type="number" id="rf_personnes" min="1" value="${esc(d.personnes||1)}"></div>
                    <div class="field"><label>Nbrs Nuités</label><input type="number" id="rf_nuits" min="1" value="${esc(d.nuits||1)}"></div>
                    <div class="field"><label>Tarif / Nuité</label><input type="number" id="rf_tarif" min="0" step="0.01" value="${esc(d.tarif!=null?d.tarif:room.price)}"></div>
                    <div class="field"><label>Sous-total</label><input type="text" id="rf_sous" readonly></div>
                </div>
            </div>
            <div class="rm-form-sec">
                <h4 class="rm-form-sec-title">Paiement</h4>
                <div class="rf-pay-pills" id="rfPayPills" role="group" aria-label="Type de paiement">
                    ${PAY_PILLS.map(p=>`<button type="button" class="rf-pay-pill${typeVal===p.id?' is-on':''}" data-pay="${esc(p.id)}" data-mode="${p.mode}">${esc(p.label)}</button>`).join('')}
                </div>
                <div class="rf-pay-summary${typeVal?' is-on':''}" id="rfPaySummary">
                    <span>Type : <b id="rfPaySumType">${esc(typeVal||'—')}</b></span>
                    <span>Payé : <b id="rfPaySumMnt">${mntVal!==''?esc(fmtAmt(num(mntVal)))+' DH':'—'}</b></span>
                </div>
                <div class="rf-pay-panel" id="rfPayPanel" aria-hidden="true">
                    <p class="rf-pay-panel-title" id="rfPayPanelTitle">Paiement</p>
                    <div class="rf-pay-panel-grid" id="rfPayPanelGrid">
                        <div class="field"><label>Total Du</label><input type="text" id="pp_total" readonly></div>
                        <div class="field"><label>Montant payé</label><input type="number" id="pp_paye" min="0" step="0.01" placeholder="0.00"></div>
                        <div class="field" data-simple-only><label>Solde</label><input type="text" id="pp_solde" readonly></div>
                        <div class="field" data-inst-only hidden><label>N° Rég</label><input type="text" id="pp_nreg" placeholder="N° règlement"></div>
                        <div class="field" data-inst-only hidden><label>Nom Tiré</label><input type="text" id="pp_tire" placeholder="Nom du tiré"></div>
                        <div class="field" data-inst-only hidden><label>Bnq</label><input type="text" id="pp_bnq" placeholder="Banque"></div>
                        <div class="field" data-inst-only hidden><label>Date Encaiss</label><input type="text" class="js-date" id="pp_encaisse" placeholder="jj/mm/aaaa" maxlength="10" inputmode="numeric" autocomplete="off"></div>
                    </div>
                    <div class="rf-pay-panel-actions">
                        <button type="button" class="btn ghost" id="ppClose">Fermer</button>
                        <button type="button" class="btn gold" id="ppValider">Valider</button>
                    </div>
                </div>
                <input type="hidden" id="rf_type" value="${esc(typeVal)}">
                <input type="hidden" id="rf_ref" value="${esc(d.ref||'')}">
                <input type="hidden" id="rf_mnt" value="${esc(mntVal!==''?mntVal:0)}"${mntVal!==''?' data-manual="1"':''}>
                <input type="hidden" id="rf_nreg" value="${esc(d.nreg||'')}">
                <input type="hidden" id="rf_bnq" value="${esc(d.bnq||'')}">
                <input type="hidden" id="rf_tire" value="${esc(d.tire||'')}">
                <input type="hidden" id="rf_encaisse" value="${esc(d.encaisse?dateFr(d.encaisse):'')}">
            </div>
        </form>
        <div class="rm-form-totals">
            <div class="ttl"><label>Total Du</label><input type="text" id="rf_total_du" readonly></div>
            <div class="ttl"><label>Mnt Payé</label><input type="text" id="rf_mnt_paye" readonly></div>
            <div class="ttl"><label>Solde</label><input type="text" id="rf_solde" readonly></div>
        </div>
        <div class="rm-form-actions">
            <button type="button" class="btn gold" id="rfValider">Valider</button>
            <button type="button" class="btn ghost" id="rfAnnuler">Annuler</button>
            <button type="button" class="btn ghost" id="rfImprimer">Imprimer</button>
            <button type="button" class="btn ghost" id="rfPdf">PDF</button>
        </div>`;
    }

    function calcTotals(){
        const nuits=num(document.getElementById('rf_nuits')?.value);
        const tarif=num(document.getElementById('rf_tarif')?.value);
        const sous=nuits*tarif;
        const total=sous;
        const mntEl=document.getElementById('rf_mnt');
        if(mntEl&&!mntEl.dataset.manual)mntEl.value=String(total);
        const paye=num(mntEl?.value);
        const solde=Math.max(0,total-paye);
        const sousEl=document.getElementById('rf_sous');
        const duEl=document.getElementById('rf_total_du');
        const payeEl=document.getElementById('rf_mnt_paye');
        const soldeEl=document.getElementById('rf_solde');
        if(sousEl)sousEl.value=fmtAmt(sous)+' DH';
        if(duEl)duEl.value=fmtAmt(total)+' DH';
        if(payeEl)payeEl.value=fmtAmt(paye)+' DH';
        if(soldeEl)soldeEl.value=fmtAmt(solde)+' DH';
        /* Compat : ht/ttc = total dû (sans TVA) */
        return{sous,ht:total,tva:0,ttc:total,total,paye,solde};
    }

    function updatePaySummary(){
        const type=normalizePayType(document.getElementById('rf_type')?.value||'');
        const mnt=num(document.getElementById('rf_mnt')?.value);
        const sum=document.getElementById('rfPaySummary');
        const tEl=document.getElementById('rfPaySumType');
        const mEl=document.getElementById('rfPaySumMnt');
        if(tEl)tEl.textContent=type||'—';
        if(mEl)mEl.textContent=type?fmtAmt(mnt)+' DH':'—';
        sum?.classList.toggle('is-on',!!type);
        document.querySelectorAll('.rf-pay-pill').forEach(btn=>{
            btn.classList.toggle('is-on',btn.dataset.pay===type);
        });
        calcTotals();
    }

    function syncPayPanelSolde(){
        const total=num(calcTotals().ttc);
        const paye=num(document.getElementById('pp_paye')?.value);
        const soldeEl=document.getElementById('pp_solde');
        if(soldeEl)soldeEl.value=fmtAmt(Math.max(0,total-paye))+' DH';
        const totalEl=document.getElementById('pp_total');
        if(totalEl)totalEl.value=fmtAmt(total)+' DH';
    }

    function closePayPanel(){
        const panel=document.getElementById('rfPayPanel');
        if(!panel)return;
        panel.classList.remove('is-open');
        panel.setAttribute('aria-hidden','true');
    }

    function openPayPanel(type,opts){
        const id=normalizePayType(type);
        if(!id)return;
        const mode=payModeOf(id);
        const panel=document.getElementById('rfPayPanel');
        const grid=document.getElementById('rfPayPanelGrid');
        const title=document.getElementById('rfPayPanelTitle');
        if(!panel||!grid)return;
        const totals=calcTotals();
        const typeEl=document.getElementById('rf_type');
        if(typeEl)typeEl.value=id;
        if(title)title.textContent='Paiement — '+id;
        grid.classList.toggle('is-inst',mode==='inst');
        grid.querySelectorAll('[data-simple-only]').forEach(el=>{
            el.hidden=mode!=='simple';
        });
        grid.querySelectorAll('[data-inst-only]').forEach(el=>{
            el.hidden=mode!=='inst';
        });
        const totalEl=document.getElementById('pp_total');
        const payeEl=document.getElementById('pp_paye');
        if(totalEl)totalEl.value=fmtAmt(totals.ttc)+' DH';
        if(payeEl){
            const cur=num(document.getElementById('rf_mnt')?.value);
            payeEl.value=String(cur>0?cur:totals.ttc);
        }
        const nreg=document.getElementById('pp_nreg');
        const tire=document.getElementById('pp_tire');
        const bnq=document.getElementById('pp_bnq');
        const enc=document.getElementById('pp_encaisse');
        if(mode==='inst'){
            if(nreg)nreg.value=document.getElementById('rf_nreg')?.value||'';
            if(tire)tire.value=document.getElementById('rf_tire')?.value||'';
            if(bnq)bnq.value=document.getElementById('rf_bnq')?.value||'';
            if(enc)enc.value=document.getElementById('rf_encaisse')?.value||'';
        }else{
            if(nreg)nreg.value='';
            if(tire)tire.value='';
            if(bnq)bnq.value='';
            if(enc)enc.value='';
        }
        syncPayPanelSolde();
        updatePaySummary();
        panel.classList.add('is-open');
        panel.setAttribute('aria-hidden','false');
        if(!(opts&&opts.focus===false))payeEl?.focus();
    }

    function validatePayPanel(){
        const type=normalizePayType(document.getElementById('rf_type')?.value||'');
        if(!type){alert('Veuillez choisir un type de paiement.');return false;}
        const mode=payModeOf(type);
        const totals=calcTotals();
        const paye=num(document.getElementById('pp_paye')?.value);
        if(paye<0){alert('Le montant payé est invalide.');return false;}
        const mntEl=document.getElementById('rf_mnt');
        if(mntEl){mntEl.value=String(paye||totals.ttc);mntEl.dataset.manual='1';}
        if(mode==='inst'){
            const nreg=(document.getElementById('pp_nreg')?.value||'').trim();
            const tire=(document.getElementById('pp_tire')?.value||'').trim();
            const bnq=(document.getElementById('pp_bnq')?.value||'').trim();
            const enc=(document.getElementById('pp_encaisse')?.value||'').trim();
            document.getElementById('rf_nreg').value=nreg;
            document.getElementById('rf_tire').value=tire;
            document.getElementById('rf_bnq').value=bnq;
            document.getElementById('rf_encaisse').value=enc;
        }else{
            document.getElementById('rf_nreg').value='';
            document.getElementById('rf_tire').value='';
            document.getElementById('rf_bnq').value='';
            document.getElementById('rf_encaisse').value='';
        }
        updatePaySummary();
        closePayPanel();
        return true;
    }

    function syncPayFields(){
        const type=normalizePayType(document.getElementById('rf_type')?.value||'');
        const cash=isCashPay(type);
        if(cash){
            PAY_EXTRA.forEach(id=>{
                const el=document.getElementById(id);
                if(el)el.value='';
            });
        }
        updatePaySummary();
    }

    function bindPayPills(ro){
        document.querySelectorAll('.rf-pay-pill').forEach(btn=>{
            btn.disabled=!!ro;
            btn.addEventListener('click',()=>{
                if(ro)return;
                openPayPanel(btn.dataset.pay);
            });
        });
        document.getElementById('pp_paye')?.addEventListener('input',syncPayPanelSolde);
        document.getElementById('ppValider')?.addEventListener('click',()=>{if(!ro)validatePayPanel();});
        document.getElementById('ppClose')?.addEventListener('click',closePayPanel);
        if(ro)closePayPanel();
        else updatePaySummary();
    }

    function getFormData(){
        const totals=calcTotals();
        const type=normalizePayType(document.getElementById('rf_type')?.value||'');
        const cash=isCashPay(type);
        const encRaw=document.getElementById('rf_encaisse')?.value||'';
        return{
            num:document.getElementById('rf_num')?.value,
            floor:document.getElementById('rf_floor')?.value||'',
            date:typeof ajIso==='function'?ajIso(document.getElementById('rf_date')?.value):today(),
            commercial:sessionCommercialName()||document.getElementById('rf_commercial')?.value.trim()||'',
            nom:document.getElementById('rf_nom')?.value.trim(),
            nationalite:document.getElementById('rf_nationalite')?.value.trim()||'',
            idType:document.getElementById('rf_idType')?.value||'CIN',
            cin:document.getElementById('rf_cin')?.value.trim(),
            personnes:num(document.getElementById('rf_personnes')?.value),
            nuits:num(document.getElementById('rf_nuits')?.value),
            tarif:num(document.getElementById('rf_tarif')?.value),
            mnt:num(document.getElementById('rf_mnt')?.value)||totals.ttc,
            type,
            ref:document.getElementById('rf_ref')?.value.trim()||'',
            nreg:cash?'':(document.getElementById('rf_nreg')?.value.trim()||''),
            bnq:cash?'':(document.getElementById('rf_bnq')?.value.trim()||''),
            tire:cash?'':(document.getElementById('rf_tire')?.value.trim()||''),
            encaisse:cash?'':(typeof ajIso==='function'?ajIso(encRaw):encRaw),
            idDoc:document.getElementById('rf_idDoc')?.value||'',
            idDocName:document.getElementById('rf_idDocName')?.value||'',
            ...totals
        };
    }

    function renderIdDocPreview(dataUrl,name){
        const box=document.getElementById('rfDocBox');
        const preview=document.getElementById('rfDocPreview');
        const clearBtn=document.getElementById('rfDocClear');
        if(!preview)return;
        const isPdf=!!(dataUrl&&(dataUrl.startsWith('data:application/pdf')||/\.pdf$/i.test(name||'')));
        if(dataUrl){
            preview.innerHTML=isPdf?`<div class="rf-doc-pdf">PDF · ${esc(name||'document.pdf')}</div>`:`<img src="${dataUrl}" alt="Pièce d'identité">`;
            box?.classList.add('has-file');
            if(clearBtn)clearBtn.disabled=false;
        }else{
            preview.innerHTML=`<div class="rf-doc-ph"><em>Importer</em><span>Photo ou PDF du document</span></div>`;
            box?.classList.remove('has-file');
            if(clearBtn)clearBtn.disabled=true;
        }
    }

    function bindIdDocUpload(ro){
        const file=document.getElementById('rf_doc');
        const hidden=document.getElementById('rf_idDoc');
        const nameEl=document.getElementById('rf_idDocName');
        const setDoc=(data,name)=>{
            if(hidden)hidden.value=data||'';
            if(nameEl)nameEl.value=name||'';
            renderIdDocPreview(data,name);
        };
        document.getElementById('rfDocImport')?.addEventListener('click',()=>{
            if(ro||!file)return;
            file.removeAttribute('capture');
            file.accept='image/*,application/pdf,.pdf';
            file.value='';
            file.click();
        });
        document.getElementById('rfDocClear')?.addEventListener('click',()=>{if(!ro)setDoc('','');});
        file?.addEventListener('change',()=>{
            const f=file.files&&file.files[0];
            if(!f)return;
            if(f.size>5*1024*1024){alert('Fichier trop volumineux (max 5 Mo).');file.value='';return;}
            const reader=new FileReader();
            reader.onload=()=>setDoc(String(reader.result||''),f.name||'');
            reader.readAsDataURL(f);
        });
        ['rfDocImport','rfDocClear'].forEach(id=>{
            const btn=document.getElementById(id);
            if(btn)btn.disabled=!!ro||(id==='rfDocClear'&&!(hidden&&hidden.value));
        });
    }

    function setFormReadonly(ro){
        ['rf_nom','rf_nationalite','rf_cin','rf_personnes','rf_nuits','rf_tarif'].forEach(id=>{
            const el=document.getElementById(id);if(el)el.readOnly=ro;
        });
        ['rf_idType'].forEach(id=>{
            const el=document.getElementById(id);if(el)el.disabled=ro;
        });
        const comm=document.getElementById('rf_commercial');
        if(comm){
            if(comm.classList.contains('is-locked-comm')){comm.readOnly=true;comm.disabled=false;}
            else comm.disabled=ro;
        }
        ['rfDocImport','rfDocClear'].forEach(id=>{
            const btn=document.getElementById(id);
            if(btn)btn.disabled=!!ro||(id==='rfDocClear'&&!document.getElementById('rf_idDoc')?.value);
        });
        document.querySelectorAll('.rf-pay-pill').forEach(btn=>{btn.disabled=!!ro;});
        ['pp_paye','pp_nreg','pp_tire','pp_bnq','pp_encaisse'].forEach(id=>{
            const el=document.getElementById(id);if(el)el.readOnly=!!ro;
        });
        const ppVal=document.getElementById('ppValider');
        if(ppVal)ppVal.disabled=!!ro;
        if(ro)closePayPanel();
        else syncPayFields();
    }

    function logReservation(room,d,status){
        let log=[];
        try{log=JSON.parse(localStorage.getItem('aj_resa_log')||'[]')||[];}catch(e){}
        const key=String(room.num);
        const payload={
            date:d.date||today(),num:key,floor:d.floor||floorLbl(room.floor),
            commercial:d.commercial||'',nom:d.nom,nationalite:d.nationalite||'',
            idType:d.idType||'CIN',cin:d.cin||'',
            personnes:num(d.personnes)||1,nuits:num(d.nuits)||1,tarif:num(d.tarif),
            sous:num(d.sous||d.ht),montant:num(d.ttc),
            paye:num(d.mnt)||num(d.ttc),type:d.type||'',
            nreg:d.nreg||'',bnq:d.bnq||'',tire:d.tire||'',encaisse:d.encaisse||'',
            idDoc:d.idDoc||'',idDocName:d.idDocName||'',
            statusChambre:status||d.statusChambre||'reservee',
            at:Date.now()
        };
        let idx=-1;
        for(let i=log.length-1;i>=0;i--){
            if(String(log[i].num)===key&&!log[i].cancelled){idx=i;break;}
        }
        const commit=list=>{
            localStorage.setItem('aj_resa_log',JSON.stringify(list));
            window.AJ_RESA_SYNC?.touchLocal?.();
        };
        const apply=p=>{
            const next=log.slice();
            if(idx>=0)next[idx]={...next[idx],...p,id:next[idx].id,ref:next[idx].ref||d.ref||next[idx].ref};
            else{
                const seq=next.reduce((m,x)=>Math.max(m,parseInt(String(x.id).replace(/\D/g,''),10)||0),0)+1;
                next.push({...p,id:'R'+String(seq).padStart(4,'0'),ref:d.ref||('RG'+String(seq).padStart(4,'0'))});
            }
            commit(next);
        };
        try{
            apply(payload);
        }catch(e){
            apply({...payload,idDoc:'',idDocName:''});
        }
    }

    function syncResaLists(status){
        window.DASH?.render();
        window.RESA?.render();
        window.CALEND?.render();
        window.BCL?.render();
        window.BPY?.render();
        window.AJ_RESA_SYNC?.syncToServer();
        if(typeof activatePanel==='function'){
            if(status==='occupee')activatePanel('ch-occupees','C-Occupées');
            else if(status==='reservee')activatePanel('ch-reservations','Réservations');
        }
    }

    function persistReservation(room,d,status){
        const key=String(room.num);
        const payload={...d,num:key,validated:true,title:room.title,statusChambre:status};
        const write=(data)=>{
            const resas=getResas();
            resas[key]=data;
            setResas(resas);
            logReservation(room,data,status);
            saveRoomStatus(key,status);
        };
        try{
            write(payload);
        }catch(e){
            /* Photo trop lourde pour localStorage : on réessaie sans le document */
            const light={...payload,idDoc:'',idDocName:''};
            write(light);
            return{ok:true,strippedDoc:true};
        }
        return{ok:true,strippedDoc:false};
    }

    function confirmReservation(room,d,status){
        const box=document.getElementById('rmModalContent');
        box?.querySelectorAll('.rm-st-btn').forEach(btn=>{btn.disabled=true;});
        let result;
        try{
            result=persistReservation(room,d,status);
        }catch(err){
            box?.querySelectorAll('.rm-st-btn').forEach(btn=>{btn.disabled=false;});
            alert('Impossible d\'enregistrer la réservation (stockage plein ou erreur locale). Retirez la photo du document puis réessayez.');
            return;
        }
        const roomRef=roomByNum(room.num)||room;
        roomRef.status=status;
        if(box){
            box.innerHTML=`<div class="rm-status-ok">
                <div class="rm-msg-dot" style="width:56px;height:56px;border-radius:50%;margin:0 auto 16px;display:flex;align-items:center;justify-content:center;font-size:26px;background:rgba(69,200,120,.12);color:#2a9d5c">✓</div>
                <h4>Réservation validée</h4>
                <p>Chambre ${esc(room.num)} — ${esc(STATUS[status]||status)}${result.strippedDoc?' · document non stocké (fichier trop lourd)':''}</p>
            </div>`;
        }
        render();
        syncResaLists(status);
        setTimeout(()=>closeModal(),900);
    }

    function changeRoomStatus(room,newStatus){
        if(newStatus===room.status){closeModal();return;}
        room.status=newStatus;
        saveRoomStatus(room.num,newStatus);
        const resas=getResas();
        if(newStatus==='occupee'||newStatus==='reservee'){
            if(resas[room.num]){
                resas[room.num]={...resas[room.num],statusChambre:newStatus,validated:true};
                setResas(resas);
                let log=[];
                try{log=JSON.parse(localStorage.getItem('aj_resa_log')||'[]')||[];}catch(e){}
                const i=log.findIndex(x=>String(x.num)===String(room.num)&&!x.cancelled);
                if(i>=0){log[i]={...log[i],statusChambre:newStatus};localStorage.setItem('aj_resa_log',JSON.stringify(log));}
            }
        }else if(newStatus==='disponible'||newStatus==='nettoyage'||newStatus==='maintenance'){
            delete resas[room.num];
            setResas(resas);
        }
        closeModal();
        render();
        syncResaLists(newStatus);
    }

    function showAdminStatusPanel(room){
        const box=document.getElementById('rmModalContent');
        if(!box)return;
        const status=room.status;
        box.innerHTML=`<div class="rm-msg st-${status}">
            <div class="rm-msg-dot">${MSG_ICON[status]||'&#9432;'}</div>
            <h3>${esc(MSG[status]||STATUS[status])}</h3>
            <p style="color:var(--muted);font-size:14px;margin:0">Chambre ${esc(room.num)} — ${esc(room.title)}</p>
            <div class="rm-admin-change">
                <p class="rm-admin-label">Changer le statut (Direction)</p>
                <div class="rm-status-btns">${ALL_STATUS.map(st=>`
                    <button type="button" class="rm-st-btn st-${st}${st===status?' is-current':''}" data-st="${st}">${STATUS[st]}</button>
                `).join('')}</div>
            </div>
        </div>`;
        box.querySelectorAll('.rm-st-btn:not(.is-current)').forEach(btn=>{
            btn.addEventListener('click',()=>changeRoomStatus(room,btn.dataset.st));
        });
        openModal();
    }

    function showStatusChoice(room,d){
        const box=document.getElementById('rmModalContent');
        if(!box)return;
        box.innerHTML=`<div class="rm-status-pick">
            <h4>Choisir le statut de la chambre</h4>
            <p class="rm-status-sub">Chambre ${esc(room.num)} — ${esc(d.nom)} · ${d.nuits} nuit(s) · ${fmtAmt(d.total!=null?d.total:d.ttc)} DH</p>
            <div class="rm-status-btns">
                <button type="button" class="rm-st-btn st-occupee" data-st="occupee">Occupée</button>
                <button type="button" class="rm-st-btn st-reservee" data-st="reservee">Réservée</button>
            </div>
            <button type="button" class="btn ghost" id="rfRetour" style="margin-top:22px">Retour au formulaire</button>
        </div>`;
        box.querySelectorAll('.rm-st-btn').forEach(btn=>{
            btn.addEventListener('click',e=>{
                e.preventDefault();
                e.stopPropagation();
                const st=btn.getAttribute('data-st');
                if(!st)return;
                confirmReservation(room,d,st);
            });
        });
        document.getElementById('rfRetour')?.addEventListener('click',e=>{
            e.preventDefault();
            e.stopPropagation();
            showForm(room,d,{edit:true});
        });
        openModal(true);
    }

    function showForm(room,prefill,opts){
        currentRoom=room;
        const saved=getResas()[room.num],data=prefill||saved;
        const box=document.getElementById('rmModalContent');
        if(!box)return;
        box.innerHTML=formHtml(room,data);
        calcTotals();
        syncPayFields();
        const locked=!!(saved?.validated&&!prefill&&!(opts&&opts.edit))||!!(opts&&opts.view);
        bindIdDocUpload(locked);
        bindPayPills(locked);
        if(locked)setFormReadonly(true);
        if(opts&&opts.view){
            const valBtn=document.getElementById('rfValider');
            if(valBtn)valBtn.disabled=true;
        }
        ['rf_nuits','rf_tarif','rf_personnes'].forEach(id=>document.getElementById(id)?.addEventListener('input',()=>{
            calcTotals();
            if(document.getElementById('rfPayPanel')?.classList.contains('is-open')){
                const totalEl=document.getElementById('pp_total');
                if(totalEl)totalEl.value=fmtAmt(calcTotals().ttc)+' DH';
                syncPayPanelSolde();
            }
        }));
        document.getElementById('rfValider')?.addEventListener('click',()=>{
            if(document.getElementById('rfPayPanel')?.classList.contains('is-open')){
                if(!validatePayPanel())return;
            }
            const d=getFormData();
            if(!d.nom){alert('Veuillez saisir le nom complet.');return;}
            if(!d.cin){alert('Veuillez saisir le N° '+((d.idType||'CIN'))+'.');return;}
            if(d.nuits<1){alert('Le nombre de nuités doit être au moins 1.');return;}
            if(!d.type){alert('Veuillez choisir le type de paiement.');return;}
            showStatusChoice(room,d);
        });
        document.getElementById('rfAnnuler')?.addEventListener('click',closeModal);
        document.getElementById('rfImprimer')?.addEventListener('click',()=>printForm(room,false));
        document.getElementById('rfPdf')?.addEventListener('click',()=>printForm(room,true));
        openModal(true);
    }

    function printHotelMeta(){
        let h={raison:'Al Jazeera Hotel',gerant:'',ville:'',adresse:'',contact:'',fixe:'',email:'',siteweb:'',statut:'4'};
        try{h={...h,...(JSON.parse(localStorage.getItem('aj_cfg_hotel')||'{}')||{})};}catch(e){}
        return h;
    }

    function nextFicheNo(){
        const year=String(new Date().getFullYear());
        const key='aj_fiche_seq_'+year;
        let n=0;
        try{n=parseInt(localStorage.getItem(key)||'0',10)||0;}catch(e){}
        n+=1;
        try{localStorage.setItem(key,String(n));}catch(e){}
        return String(n).padStart(4,'0')+'/'+year;
    }

    function printAddDays(isoDate,days){
        const raw=String(isoDate||today()).slice(0,10);
        const dt=new Date(raw+'T00:00:00');
        if(Number.isNaN(dt.getTime()))return raw;
        dt.setDate(dt.getDate()+(num(days)||0));
        const y=dt.getFullYear();
        const m=String(dt.getMonth()+1).padStart(2,'0');
        const day=String(dt.getDate()).padStart(2,'0');
        return y+'-'+m+'-'+day;
    }

    function printForm(room,isPdf){
        const d=getFormData();
        const hotel=printHotelMeta();
        const total=num(d.total!=null?d.total:(d.ttc!=null?d.ttc:d.ht));
        const paye=num(d.mnt!=null?d.mnt:d.paye);
        const solde=Math.max(0,total-paye);
        const ficheNo=d.ficheNo||nextFicheNo();
        const year=String(new Date().getFullYear());
        const seq=String(ficheNo).split('/')[0]||'0001';
        const recNo=d.ref||('REC-'+year+'-'+seq);
        const dossier=d.ref||('RES-'+year+'-'+seq);
        const checkIn=d.checkIn||d.date||today();
        const checkOut=d.checkOut||printAddDays(checkIn,d.nuits||1);
        const cash=isCashPay(d.type);
        const stars=Math.max(3,Math.min(5,parseInt(hotel.statut||'4',10)||4));
        const starStr='★'.repeat(stars);
        const now=new Date();
        const timeStr=String(now.getHours()).padStart(2,'0')+':'+String(now.getMinutes()).padStart(2,'0');
        const logoUrl=(document.querySelector('.login-logo')?.src)
            ||(document.querySelector('.top-logo-wrap img')?.src)
            ||((window.location.origin||'')+'/apple-touch-icon.png');
        const phone=hotel.contact||hotel.fixe||'';
        const email=hotel.email||'';
        const qrData=encodeURIComponent(recNo+'|'+String(d.nom||'')+'|CH'+String(room.num));
        const qrUrl='https://api.qrserver.com/v1/create-qr-code/?size=110x110&margin=0&data='+qrData;
        const payModeLabel=({Esp:'Espèces','Carte Visa':'Carte Visa','Vir mobile':'Virement mobile',Chq:'Chèque',Eff:'Effet',Vers:'Versement'})[d.type]||(d.type||'—');
        const payExtraRows=cash?'':`
            <tr><td>N° règlement</td><td colspan="2">${esc(d.nreg||'—')}</td><td>${esc(d.bnq||'—')}</td></tr>
            <tr><td>Nom tiré / Date encaiss.</td><td colspan="2">${esc(d.tire||'—')}</td><td>${esc(d.encaisse?dateFr(d.encaisse):'—')}</td></tr>`;
        const ville=hotel.ville||'Laâyoune';
        const adresse=hotel.adresse||'Av. Mohammed V, El Ayoun, Maroc';
        const tele=hotel.contact||'+212 6 12 34 56 78';
        const fixe=hotel.fixe||'+212 5 28 98 76 54';
        const mail=hotel.email||'contact@aljazeera-hotel.com';
        const site=hotel.siteweb||'www.aljazeera-hotel.com';
        const footBits=[
            `Ville : ${ville}`,
            `Adresse : ${adresse}`,
            `Tél. : ${tele}`,
            `Fixe : ${fixe}`,
            `E-mail : ${mail}`,
            `Site web : ${site}`
        ];
        const html=`<!DOCTYPE html><html lang="fr"><head><meta charset="utf-8">
        <title>&nbsp;</title>
        <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;0,700;1,600&family=Great+Vibes&family=Montserrat:wght@500;600;700&display=swap" rel="stylesheet">
        <style>
            @page{size:A4;margin:8mm 10mm 10mm}
            :root{--navy:#0b1c3f;--gold:#c5a059;--gold2:#e0c07a;--ink:#1a2332;--muted:#6b7280;--line:#e8dfcc;--soft:#faf7f0;--ok:#1f7a45;--due:#b42318}
            *{box-sizing:border-box}
            html,body{margin:0;padding:0;background:#fff;color:var(--ink);font:500 11px/1.4 'Montserrat',Arial,sans-serif;min-height:100%}
            .sheet{
                max-width:190mm;margin:0 auto;padding:2mm;
                min-height:277mm;display:flex;flex-direction:column;
            }
            .sheet-end{margin-top:auto;padding-top:10px}
            .topbar{height:5px;background:linear-gradient(90deg,var(--gold),var(--gold2),var(--gold));margin-bottom:10px}
            .head{display:grid;grid-template-columns:1.15fr .95fr;gap:14px;align-items:start;margin-bottom:10px}
            .brand{display:flex;gap:10px;align-items:center}
            .brand img{width:52px;height:52px;object-fit:contain;border-radius:10px;border:1px solid var(--line);padding:3px}
            .brand h1{margin:0;font:700 28px/1 'Cormorant Garamond',Georgia,serif;color:var(--navy)}
            .stars{margin:2px 0 0;color:var(--gold);font-size:12px;letter-spacing:1px}
            .coords{margin:6px 0 0;color:var(--muted);font-size:10px;line-height:1.45}
            .coords b{color:var(--ink);font-weight:600}
            .meta{text-align:right}
            .meta h2{margin:0 0 6px;font:700 16px/1.2 'Cormorant Garamond',Georgia,serif;color:var(--navy)}
            .meta .pill{display:inline-block;padding:4px 9px;border:1px solid var(--gold);color:var(--navy);
                font:700 9px 'Montserrat',sans-serif;letter-spacing:1px;text-transform:uppercase;background:var(--soft)}
            .meta p{margin:5px 0 0;color:var(--muted);font-size:10.5px}
            .meta p b{color:var(--ink)}
            .sec{margin:0 0 9px;border:1px solid var(--line);background:#fff}
            .sec-h{display:flex;justify-content:space-between;align-items:center;gap:10px;
                padding:6px 10px;background:linear-gradient(90deg,rgba(197,160,89,.16),rgba(197,160,89,.04));
                border-bottom:1px solid var(--line)}
            .sec-h h3{margin:0;font:700 10px 'Montserrat',sans-serif;letter-spacing:1.2px;text-transform:uppercase;color:var(--gold)}
            .sec-h .tag{font:700 10px 'Montserrat',sans-serif;color:var(--navy)}
            .sec-b{padding:8px 10px}
            .client{display:grid;grid-template-columns:1fr 92px;gap:12px;align-items:center}
            .grid2{display:grid;grid-template-columns:1fr 1fr;gap:4px 18px}
            .kv{display:flex;gap:8px;padding:3px 0;border-bottom:1px dotted #eee}
            .kv:last-child{border-bottom:0}
            .kv span{min-width:108px;color:var(--muted);font:600 9.5px 'Montserrat',sans-serif}
            .kv b{font:700 11.5px 'Montserrat',sans-serif;color:var(--ink)}
            .qr{width:88px;height:88px;border:1px solid var(--line);padding:4px;background:#fff}
            .qr img{width:100%;height:100%;display:block}
            .stay{display:grid;grid-template-columns:1fr 1fr 1fr;gap:6px 14px}
            table.pay{width:100%;border-collapse:collapse}
            table.pay th,table.pay td{padding:6px 8px;border-bottom:1px solid var(--line);text-align:left;font-size:10.5px}
            table.pay th{background:var(--soft);color:var(--muted);font:700 9px 'Montserrat',sans-serif;letter-spacing:.7px;text-transform:uppercase}
            table.pay td:nth-child(2),table.pay td:nth-child(3),table.pay td:nth-child(4),
            table.pay th:nth-child(2),table.pay th:nth-child(3),table.pay th:nth-child(4){text-align:right}
            table.pay tr.total td{border-bottom:0;background:rgba(197,160,89,.08);font-weight:700;color:var(--navy)}
            .sums{display:grid;grid-template-columns:1fr 1fr 1fr;gap:8px;margin-top:8px}
            .sum{padding:8px 9px;border:1px solid var(--line);background:var(--soft);text-align:center}
            .sum span{display:block;margin-bottom:3px;font:700 8.5px 'Montserrat',sans-serif;letter-spacing:.8px;text-transform:uppercase;color:var(--muted)}
            .sum b{font:700 16px/1.1 'Cormorant Garamond',Georgia,serif}
            .sum.ok{border-color:rgba(31,122,69,.35);background:rgba(31,122,69,.06)}
            .sum.ok b{color:var(--ok)}
            .sum.due{border-color:rgba(180,35,24,.3);background:rgba(180,35,24,.05)}
            .sum.due b{color:var(--due)}
            .mode{margin-top:7px;font-size:10.5px;color:var(--muted)}
            .mode b{color:var(--ink)}
            .foot{display:grid;grid-template-columns:1.4fr auto;gap:14px;align-items:center;margin:0 0 10px}
            .thanks{font:600 22px/1.1 'Great Vibes',cursive;color:var(--navy)}
            .thanks small{display:block;margin-top:4px;font:600 9.5px 'Montserrat',sans-serif;color:var(--muted)}
            .seal{
                width:72px;height:72px;margin:0;border:2px solid #2f5fad;border-radius:50%;
                display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;
                color:#2f5fad;transform:rotate(-8deg);opacity:.9;
            }
            .seal b{font:700 8px 'Montserrat',sans-serif;letter-spacing:.6px}
            .seal span{font:700 14px/1 'Cormorant Garamond',Georgia,serif;margin:2px 0}
            .seal i{font-style:normal;font-size:9px;color:var(--gold)}
            .signs{display:grid;grid-template-columns:1fr 1fr;gap:40px;margin:0 0 12px}
            .signs .sig{
                min-height:52px;border-top:1px solid var(--navy);padding-top:7px;text-align:center;
                font:700 9px 'Montserrat',sans-serif;letter-spacing:.8px;text-transform:uppercase;color:var(--muted);
            }
            .page-foot{
                margin:0;padding-top:8px;border-top:1.5px solid var(--gold);
                text-align:center;color:var(--muted);font:600 9.5px/1.55 'Montserrat',sans-serif;
            }
            .page-foot b{color:var(--navy);font-weight:700}
            .print-hint{
                margin:0 0 8px;padding:7px 10px;border:1px dashed var(--gold);background:#fff8e8;
                font:600 10px 'Montserrat',sans-serif;color:#7a5a18;text-align:center;
            }
            @media print{
                .sheet{padding:0;max-width:none;min-height:277mm}
                .print-hint{display:none!important}
                .sec,.head,.sums,.foot,.signs,.page-foot,.sheet-end{break-inside:avoid;page-break-inside:avoid}
            }
        </style></head><body>
        <div class="sheet">
            <div class="topbar"></div>
            <header class="head">
                <div>
                    <div class="brand">
                        <img src="${esc(logoUrl)}" alt="Logo">
                        <div>
                            <h1>${esc(hotel.raison||'Al Jazeera Hotel')}</h1>
                            <div class="stars">${starStr}</div>
                        </div>
                    </div>
                    <div class="coords">
                        ${phone?`<div><b>Tél.</b> ${esc(phone)}</div>`:''}
                        ${email?`<div><b>E-mail</b> ${esc(email)}</div>`:''}
                        ${hotel.gerant?`<div><b>Gérant</b> ${esc(hotel.gerant)}</div>`:''}
                    </div>
                </div>
                <div class="meta">
                    <h2>Reçu d’Enregistrement<br>et de Paiement</h2>
                    <div class="pill">Fiche client N° ${esc(ficheNo)}</div>
                    <p>N° Reçu <b>${esc(recNo)}</b></p>
                    <p>Date <b>${esc(dateFr(today()))} – ${esc(timeStr)}</b></p>
                </div>
            </header>

            <section class="sec">
                <div class="sec-h"><h3>Informations du Client</h3><span class="tag">Dossier ${esc(dossier)}</span></div>
                <div class="sec-b client">
                    <div class="grid2">
                        <div class="kv"><span>Nom complet</span><b>${esc(d.nom||'—')}</b></div>
                        <div class="kv"><span>${esc(d.idType||'CIN')}</span><b>${esc(d.cin||'—')}</b></div>
                        <div class="kv"><span>Nationalité</span><b>${esc(d.nationalite||'—')}</b></div>
                        <div class="kv"><span>Responsable</span><b>${esc(d.commercial||'—')}</b></div>
                    </div>
                    <div class="qr"><img src="${qrUrl}" alt="QR" crossorigin="anonymous"></div>
                </div>
            </section>

            <section class="sec">
                <div class="sec-h"><h3>Détails du Séjour</h3></div>
                <div class="sec-b stay">
                    <div class="kv"><span>Chambre</span><b>${esc(d.num||room.num)}</b></div>
                    <div class="kv"><span>Type</span><b>${esc(room.title||'—')}</b></div>
                    <div class="kv"><span>Nuitées</span><b>${esc(d.nuits||1)}</b></div>
                    <div class="kv"><span>Date Check-IN</span><b>${esc(dateFr(checkIn))}</b></div>
                    <div class="kv"><span>Date Check-OUT</span><b>${esc(dateFr(checkOut))}</b></div>
                    <div class="kv"><span>Personnes</span><b>${esc(d.personnes||1)}</b></div>
                </div>
            </section>

            <section class="sec">
                <div class="sec-h"><h3>Détail du Paiement</h3></div>
                <div class="sec-b">
                    <table class="pay">
                        <thead>
                            <tr><th>Désignation</th><th>Tarif / Nuité</th><th>Nuits</th><th>Montant (DH)</th></tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Hébergement — ${esc(room.title||('Chambre '+room.num))}</td>
                                <td>${esc(fmtAmt(d.tarif))} DH</td>
                                <td>${esc(d.nuits||1)}</td>
                                <td>${esc(fmtAmt(total))} DH</td>
                            </tr>
                            ${payExtraRows}
                            <tr class="total"><td colspan="3">Montant Du</td><td>${esc(fmtAmt(total))} DH</td></tr>
                        </tbody>
                    </table>
                    <div class="sums">
                        <div class="sum ok"><span>Montant payé</span><b>${esc(fmtAmt(paye))} DH</b></div>
                        <div class="sum due"><span>Reste à payer</span><b>${esc(fmtAmt(solde))} DH</b></div>
                        <div class="sum"><span>Mode de paiement</span><b>${esc(payModeLabel)}</b></div>
                    </div>
                </div>
            </section>

            <div class="sheet-end">
                <footer class="foot">
                    <div class="thanks">Merci pour votre confiance !
                        <small>Nous serons heureux de vous accueillir à nouveau.</small>
                    </div>
                    <div class="seal">
                        <b>AL JAZEERA</b>
                        <span>HOTEL</span>
                        <i>${starStr}</i>
                    </div>
                </footer>
                <div class="signs">
                    <div class="sig">Signature client</div>
                    <div class="sig">Signature Responsable</div>
                </div>
                <div class="page-foot">
                    ${footBits.map(x=>esc(x)).join(' &nbsp;·&nbsp; ')}
                </div>
            </div>
        </div>
        </body></html>`;
        const fileBase='Recu-'+recNo.replace(/[^\w.-]+/g,'_');
        if(isPdf)exportReceiptPdf(html,fileBase);
        else printReceiptHtml(html);
    }

    function printReceiptHtml(html){
        /* iframe même origine : pas de blob:... dans le pied Chrome */
        let frame=document.getElementById('rfPrintFrame');
        if(!frame){
            frame=document.createElement('iframe');
            frame.id='rfPrintFrame';
            frame.setAttribute('aria-hidden','true');
            frame.style.cssText='position:fixed;right:0;bottom:0;width:0;height:0;border:0;opacity:0;pointer-events:none';
            document.body.appendChild(frame);
        }
        const doc=frame.contentDocument||frame.contentWindow?.document;
        if(!doc){alert('Impression impossible.');return;}
        const hinted=html.replace('<div class="sheet">','<div class="sheet"><div class="print-hint">Dans la fenêtre d’impression : décochez « En-têtes et pieds de page » pour retirer l’URL et 1/1.</div>');
        doc.open();
        doc.write(hinted);
        doc.close();
        try{doc.title=' ';}catch(e){}
        const win=frame.contentWindow;
        const go=()=>{
            try{win.focus();}catch(e){}
            setTimeout(()=>{
                try{win.print();}catch(e){alert('Impression impossible.');}
            },350);
        };
        if(doc.fonts&&doc.fonts.ready)doc.fonts.ready.then(go).catch(go);
        else go();
    }

    function loadHtml2Pdf(){
        if(window.html2pdf)return Promise.resolve(window.html2pdf);
        return new Promise((resolve,reject)=>{
            const s=document.createElement('script');
            s.src='https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js';
            s.onload=()=>window.html2pdf?resolve(window.html2pdf):reject(new Error('html2pdf indisponible'));
            s.onerror=()=>reject(new Error('Impossible de charger le moteur PDF'));
            document.head.appendChild(s);
        });
    }

    async function exportReceiptPdf(html,filename){
        let host=document.getElementById('rfPdfHost');
        if(host)host.remove();
        host=document.createElement('div');
        host.id='rfPdfHost';
        host.style.cssText='position:fixed;left:0;top:0;width:794px;max-width:210mm;background:#fff;z-index:2147483646;padding:12px;box-sizing:border-box;';
        const parsed=new DOMParser().parseFromString(html,'text/html');
        parsed.querySelectorAll('style').forEach(st=>host.appendChild(st.cloneNode(true)));
        const sheet=parsed.querySelector('.sheet');
        if(sheet)host.appendChild(sheet.cloneNode(true));
        else host.appendChild(parsed.body.cloneNode(true));
        document.body.appendChild(host);
        try{
            await loadHtml2Pdf();
            if(document.fonts&&document.fonts.ready)await document.fonts.ready.catch(()=>{});
            await new Promise(r=>setTimeout(r,700));
            const el=host.querySelector('.sheet')||host;
            const opt={
                margin:[8,8,8,8],
                filename:(filename||'Recu')+'.pdf',
                image:{type:'jpeg',quality:.98},
                html2canvas:{scale:2,useCORS:true,logging:false,backgroundColor:'#ffffff',scrollX:0,scrollY:0},
                jsPDF:{unit:'mm',format:'a4',orientation:'portrait'},
                pagebreak:{mode:['avoid-all']}
            };
            await window.html2pdf().set(opt).from(el).save();
        }catch(err){
            console.error(err);
            printReceiptHtml(html);
            alert('PDF indisponible : ouverture de l\'impression classique.');
        }finally{
            setTimeout(()=>host?.remove(),800);
        }
    }

    function onRoomClick(room){
        if(room.status==='disponible')showForm(room);
        else if((room.status==='nettoyage'||room.status==='maintenance')&&CAN_MANAGE)showAdminStatusPanel(room);
        else if(MSG[room.status])showMessage(room,room.status);
    }

    function showEditRoom(room){
        currentRoom=room;
        const box=document.getElementById('rmModalContent');
        if(!box)return;
        const statusOpts=[
            ['disponible','Disponible'],
            ['occupee','Occupée'],
            ['reservee','Réservée'],
            ['maintenance','Maintenance'],
            ['nettoyage','Nettoyage']
        ];
        box.innerHTML=`
        <div class="rm-form-head">
            <h3>Modifier — Chambre ${esc(room.num)}</h3>
            <p>Titre, description, prix et état</p>
        </div>
        <form class="rm-form-grid rm-edit-simple" id="reForm" onsubmit="return false">
            <div class="field span2">
                <label>Titre</label>
                <input type="text" id="re_title" value="${esc(room.title)}" placeholder="Titre de la chambre" required>
            </div>
            <div class="field span2">
                <label>Description</label>
                <textarea id="re_desc" rows="4" placeholder="Description de la chambre">${esc(room.desc)}</textarea>
            </div>
            <div class="field">
                <label>Prix</label>
                <input type="number" id="re_price" min="0" step="0.01" value="${Number(room.price||0).toFixed(2)}" placeholder="Prix / nuit (DH)">
            </div>
            <div class="field">
                <label>État</label>
                <select id="re_status">
                    ${statusOpts.map(([v,l])=>`<option value="${v}"${room.status===v?' selected':''}>${l}</option>`).join('')}
                </select>
            </div>
        </form>
        <div class="rm-form-actions">
            <button type="button" class="btn gold" id="reSave">Enregistrer</button>
            <button type="button" class="btn ghost" id="reCancel">Annuler</button>
        </div>`;
        document.getElementById('reSave')?.addEventListener('click',()=>saveRoomEdit(room));
        document.getElementById('reCancel')?.addEventListener('click',closeModal);
        openModal();
    }

    function saveRoomEdit(room){
        const title=document.getElementById('re_title')?.value.trim();
        const desc=document.getElementById('re_desc')?.value.trim();
        const price=num(document.getElementById('re_price')?.value);
        const status=document.getElementById('re_status')?.value;
        if(!title){alert('Veuillez saisir un titre.');return;}
        if(!ALL_STATUS.includes(status)){alert('État invalide.');return;}
        room.title=title;
        room.desc=desc;
        room.price=price;
        saveRoomData(room.num,{title:room.title,desc:room.desc,price:room.price});
        const old=room.status;
        room.status=status;
        saveRoomStatus(room.num,status);
        if(status!==old){
            const resas=getResas();
            if(status==='occupee'||status==='reservee'){
                if(resas[room.num]){
                    resas[room.num]={...resas[room.num],statusChambre:status,validated:true};
                    setResas(resas);
                }
            }else if(status==='disponible'||status==='nettoyage'||status==='maintenance'){
                delete resas[room.num];
                setResas(resas);
            }
        }
        closeModal();
        refreshCardDom(room);
        renderStats();
        applyFilters();
        if(selectedNum===room.num)showDetail(room);
        window.RESA?.render();
        window.CALEND?.render();
        window.DASH?.render();
        if(status!==old&&(status==='occupee'||status==='reservee')&&typeof activatePanel==='function'){
            activatePanel(status==='occupee'?'ch-occupees':'ch-reservations',status==='occupee'?'C-Occupées':'Réservations');
        }
        alert('Chambre mise à jour.');
    }

    function bindOnce(){
        if(bound)return;
        const area=document.getElementById('echSections');
        document.getElementById('chSearch')?.addEventListener('input',e=>{currentFilter.q=e.target.value.trim();applyFilters();});
        document.getElementById('chFilterFloor')?.addEventListener('change',e=>{currentFilter.floor=e.target.value;applyFilters();});
        document.getElementById('chFilterCat')?.addEventListener('change',e=>{currentFilter.cat=e.target.value;applyFilters();});
        document.getElementById('chFilterStatus')?.addEventListener('change',e=>{currentFilter.status=e.target.value;applyFilters();});
        document.querySelectorAll('.ch-view-btn').forEach(btn=>{
            btn.addEventListener('click',e=>{
                e.preventDefault();
                /* Mode liste désactivé : la grille reste verrouillée */
                viewMode='grid';
                document.querySelectorAll('.ch-view-btn').forEach(b=>b.classList.toggle('active',b.dataset.view==='grid'));
                area?.classList.remove('ch-view-list');
            });
        });
        area?.addEventListener('click',e=>{
            const card=e.target.closest('.ch-room-card');
            if(!card)return;
            const room=roomByNum(card.dataset.num);
            if(!room)return;
            if(e.target.closest('.ch-rc-file')){e.preventDefault();e.stopPropagation();openContenu(room);return;}
            if(e.target.closest('.ch-rc-img')){e.preventDefault();e.stopPropagation();openAdd(room);return;}
            showDetail(room);
        });
        document.getElementById('chInvOverlay')?.addEventListener('click',e=>{
            if(e.target.id==='chInvOverlay'||e.target.closest('[data-close="inv"]')){closeContenu();return;}
            const del=e.target.closest('.ch-inv-del');
            if(del&&invNum)removeContenu(invNum,del.dataset.id);
        });
        document.getElementById('chInvAddOverlay')?.addEventListener('click',e=>{
            if(e.target.id==='chInvAddOverlay'||e.target.closest('[data-close="add"]'))closeAdd();
        });
        document.getElementById('chInvPiece')?.addEventListener('change',e=>{
            document.getElementById('chInvPieceCustomWrap')?.classList.toggle('is-on',e.target.value==='__autre');
            if(e.target.value==='__autre')document.getElementById('chInvPieceCustom')?.focus();
        });
        document.getElementById('chInvForm')?.addEventListener('submit',e=>{
            e.preventDefault();
            const room=invNum?roomByNum(invNum):null;
            if(room)addContenu(room);
        });
        document.addEventListener('keydown',e=>{
            if(e.key!=='Escape')return;
            if(document.getElementById('chInvAddOverlay')?.classList.contains('show')){closeAdd();return;}
            if(document.getElementById('chInvOverlay')?.classList.contains('show'))closeContenu();
        });
        area?.addEventListener('keydown',e=>{
            if(e.key!=='Enter'&&e.key!==' ')return;
            const card=e.target.closest('.ch-room-card');
            if(!card)return;
            e.preventDefault();
            const room=roomByNum(card.dataset.num);
            if(room)showDetail(room);
        });
        document.getElementById('rmModalClose')?.addEventListener('click',closeModal);
        document.getElementById('rmModalOverlay')?.addEventListener('click',e=>{if(e.target.id==='rmModalOverlay')closeModal();});
        bound=true;
    }

    function render(){
        const box=document.getElementById('echSections');
        if(!box)return;
        syncFromStorage();
        ROOMS=ROOMS.slice().sort((a,b)=>String(a.num).localeCompare(String(b.num),undefined,{numeric:true}));
        const grid=document.getElementById('chRoomGrid');
        const existing=grid?grid.querySelectorAll('.ch-room-card').length:0;
        if(grid&&existing===ROOMS.length){
            ROOMS.forEach(r=>refreshCardDom(r));
            renderStats();
            applyFilters();
        }else{
            box.className='ch-rooms-area';
            box.innerHTML=`<div class="ch-room-grid" id="chRoomGrid">${ROOMS.map((r,i)=>cardHtml(r,i)).join('')}</div>`;
            renderStats();
            populateFloorFilter();
            applyFilters();
            document.querySelectorAll('#chRoomGrid .ch-room-card').forEach(card=>{
                card.style.transform='none';
                card.style.translate='none';
                card.style.order='0';
            });
        }
        bindOnce();
        bindDetailFloorSelects();
        populateDetailFloorSelects(selectedNum?roomByNum(selectedNum):null);
        if(selectedNum){
            const r=roomByNum(selectedNum);
            if(r)showDetail(r);else closeDetail();
        }else{
            renderDetailEmpty();
        }
    }

    let etagesFloorFilter='',etagesFloorQ='',etagesBound=false;

    function listFloors(){
        if(window.AJ_HOTEL?.getFloors)return window.AJ_HOTEL.getFloors();
        return [...new Set(ROOMS.map(r=>Number(r.floor)).filter(f=>f>0))].sort((a,b)=>a-b);
    }

    function refreshAfterCatalogChange(){
        syncFromStorage();
        try{renderEtages();}catch(e){console.error(e);}
        try{render();}catch(e){console.error(e);}
        try{window.CHDISPO?.render?.();}catch(e){console.error(e);}
        try{window.DASH?.render?.();}catch(e){console.error(e);}
    }

    function matchesEtageSearch(floor){
        const f=Number(floor);
        const q=etagesFloorQ.trim().toLowerCase();
        if(etagesFloorFilter!==''&&etagesFloorFilter!=null&&Number(etagesFloorFilter)!==f)return false;
        if(!q)return true;
        const lbl=floorLbl(f).toLowerCase();
        return lbl.includes(q)||String(f).includes(q)||`${f}e`.includes(q)||`${f}er`.includes(q);
    }

    function clearEtageSearch(){
        etagesFloorQ='';
        const search=document.getElementById('etFloorSearch');
        if(search)search.value='';
    }

    function renderEtagesTable(){
        const tbody=document.getElementById('chEtagesTableBody');
        if(!tbody)return;
        const sorted=ROOMS.slice()
            .filter(r=>matchesEtageSearch(r.floor))
            .sort((a,b)=>{
                const fa=Number(a.floor)||0,fb=Number(b.floor)||0;
                if(fa!==fb)return fa-fb;
                return String(a.num).localeCompare(String(b.num),undefined,{numeric:true});
            });
        if(!sorted.length){
            const emptyMsg=etagesFloorFilter
                ?`Aucune chambre pour le ${esc(floorLbl(etagesFloorFilter))}.`
                :'Aucune chambre pour cet étage.';
            tbody.innerHTML=`<tr class="empty-row"><td colspan="6">${emptyMsg}</td></tr>`;
            return;
        }
        tbody.innerHTML=sorted.map(r=>`<tr>
            <td class="et-floor-cell">${floorLbl(r.floor)}</td>
            <td><strong>${esc(r.num)}</strong></td>
            <td>${esc(r.title)}</td>
            <td>${esc(CAT_LBL[r.type]||r.type)}</td>
            <td><span class="et-status st-${r.status}">${STATUS[r.status]}</span></td>
            <td>${fmtP(r.price)}</td>
        </tr>`).join('');
    }

    function showAddModal(){
        const box=document.getElementById('rmModalContent');
        const modal=document.getElementById('rmModal');
        const overlay=document.getElementById('rmModalOverlay');
        if(!box||!modal||!overlay){
            alert('Fenêtre d\'ajout indisponible. Rechargez la page.');
            return;
        }
        if(!window.AJ_HOTEL||typeof window.AJ_HOTEL.addRoom!=='function'||typeof window.AJ_HOTEL.addFloor!=='function'){
            alert('Module chambres non chargé. Rechargez la page (Ctrl+F5).');
            return;
        }
        const floors=listFloors();
        const nextFloor=(floors[floors.length-1]||0)+1;
        const preferredFloor=etagesFloorFilter&&floors.some(f=>Number(f)===Number(etagesFloorFilter))
            ?Number(etagesFloorFilter)
            :nextFloor;
        const typeOpts=[['grand-suite','Grand Suite'],['suite-junior','Suite Junior'],['single','Single'],['double','Double']];
        modal.classList.add('cc-edit-modal');
        let mode='room';
        const floorOptions=[...floors];
        if(!floorOptions.some(f=>Number(f)===Number(nextFloor)))floorOptions.push(nextFloor);
        box.innerHTML=`
            <div class="cc-edit-body" style="padding-top:22px">
                <p class="cc-edit-kicker">Hébergement</p>
                <h3 style="margin:0 0 14px;font-family:'Cormorant Garamond',serif;font-size:24px;color:var(--text-dark)">Ajouter</h3>
                <div class="et-add-mode" role="tablist">
                    <button type="button" class="is-on" data-et-mode="room" aria-selected="true">Chambre</button>
                    <button type="button" data-et-mode="floor" aria-selected="false">Étage</button>
                </div>
                <div class="et-add-pane is-on" data-et-pane="room">
                    <div class="field"><label for="et_room_num">N° chambre</label><input type="text" id="et_room_num" placeholder="Ex. 401" autocomplete="off"></div>
                    <div class="field"><label for="et_room_title">Titre</label><input type="text" id="et_room_title" placeholder="Nom de la chambre"></div>
                    <div class="field"><label for="et_room_type">Catégorie</label>
                        <select id="et_room_type">${typeOpts.map(([k,l])=>`<option value="${k}">${l}</option>`).join('')}</select>
                    </div>
                    <div class="field"><label for="et_room_floor">Étage</label>
                        <select id="et_room_floor">
                            ${floorOptions.map(f=>`<option value="${f}"${Number(f)===Number(preferredFloor)?' selected':''}>${floorLbl(f)}${Number(f)===Number(nextFloor)&&!floors.includes(Number(f))?' (nouveau)':''}</option>`).join('')}
                        </select>
                    </div>
                    <div class="field"><label for="et_room_price">Prix / nuit (DH)</label><input type="number" id="et_room_price" min="0" step="0.01" value="0.00"></div>
                </div>
                <div class="et-add-pane" data-et-pane="floor">
                    <div class="field"><label for="et_floor_num">N° d'étage</label><input type="number" id="et_floor_num" min="1" step="1" value="${nextFloor}" placeholder="Ex. 4"></div>
                    <p class="hint" style="text-align:left;margin:0">L'étage apparaîtra même sans chambre. Vous pourrez y ajouter des chambres ensuite.</p>
                </div>
                <p id="etAddErr" class="hint" style="display:none;text-align:left;color:#c0392b;margin:8px 0 0"></p>
                <div class="et-add-actions">
                    <button type="button" class="btn gold" id="etAddSave">Enregistrer</button>
                    <button type="button" class="btn ghost" id="etAddCancel">Annuler</button>
                </div>
            </div>`;
        const showErr=msg=>{
            const el=box.querySelector('#etAddErr');
            if(!el){alert(msg);return;}
            el.style.display='block';
            el.textContent=msg;
        };
        const setMode=m=>{
            mode=m==='floor'?'floor':'room';
            box.querySelectorAll('[data-et-mode]').forEach(b=>{
                const on=b.getAttribute('data-et-mode')===mode;
                b.classList.toggle('is-on',on);
                b.setAttribute('aria-selected',on?'true':'false');
            });
            box.querySelectorAll('[data-et-pane]').forEach(p=>{
                p.classList.toggle('is-on',p.getAttribute('data-et-pane')===mode);
            });
        };
        const close=()=>{
            overlay.classList.remove('show');
            modal.classList.remove('cc-edit-modal');
        };
        box.onclick=e=>{
            const modeBtn=e.target.closest('[data-et-mode]');
            if(modeBtn){
                e.preventDefault();
                setMode(modeBtn.getAttribute('data-et-mode'));
                return;
            }
            if(e.target.closest('#etAddCancel')){
                e.preventDefault();
                close();
                return;
            }
            if(!e.target.closest('#etAddSave'))return;
            e.preventDefault();
            e.stopPropagation();
            try{
                if(mode==='floor'){
                    const f=Number(box.querySelector('#et_floor_num')?.value);
                    if(!(f>0)){showErr('Indiquez un numéro d\'étage valide.');return;}
                    window.AJ_HOTEL.addFloor(f);
                    clearEtageSearch();
                    etagesFloorFilter=String(f);
                    close();
                    refreshAfterCatalogChange();
                    alert(floorLbl(f)+' ajouté.');
                }else{
                    const num=(box.querySelector('#et_room_num')?.value||'').trim();
                    const title=(box.querySelector('#et_room_title')?.value||'').trim();
                    const type=box.querySelector('#et_room_type')?.value||'single';
                    const floor=Number(box.querySelector('#et_room_floor')?.value)||1;
                    const price=Number(box.querySelector('#et_room_price')?.value)||0;
                    if(!num){showErr('Indiquez le numéro de chambre.');return;}
                    if(!title){showErr('Indiquez le titre.');return;}
                    const created=window.AJ_HOTEL.addRoom({num,title,type,floor,price});
                    if(!created||!window.AJ_HOTEL.getRoom(num)){
                        showErr('Chambre enregistrée mais introuvable au rechargement.');
                        return;
                    }
                    clearEtageSearch();
                    etagesFloorFilter=String(created.floor||floor);
                    close();
                    refreshAfterCatalogChange();
                    alert('Chambre '+num+' ajoutée — '+floorLbl(created.floor||floor)+'.');
                }
            }catch(err){
                console.error(err);
                showErr(err&&err.message?err.message:'Impossible d\'enregistrer.');
            }
        };
        overlay.classList.add('show');
        setTimeout(()=>box.querySelector('#et_room_num')?.focus(),50);
    }

    function renderEtages(){
        const box=document.getElementById('chEtagesGrid');
        const tbody=document.getElementById('chEtagesTableBody');
        if(!box&&!tbody)return;
        syncFromStorage();
        const floors=listFloors();
        const floorSel=document.getElementById('etFloorFilter');
        if(floorSel){
            const cur=etagesFloorFilter!==''&&etagesFloorFilter!=null?String(etagesFloorFilter):(floorSel.value||'');
            floorSel.innerHTML='<option value="">Étage : Tous</option>'+floors.map(f=>`<option value="${f}">${floorLbl(f)}</option>`).join('');
            if(cur&&floors.some(f=>Number(f)===Number(cur))){
                floorSel.value=String(Number(cur));
                etagesFloorFilter=String(Number(cur));
            }else{
                floorSel.value='';
                etagesFloorFilter='';
            }
        }
        if(box){
            box.innerHTML=floors.map(f=>{
                const list=ROOMS.filter(r=>Number(r.floor)===Number(f));
                const dispo=list.filter(r=>r.status==='disponible').length;
                const occu=list.filter(r=>r.status==='occupee').length;
                const active=matchesEtageSearch(f);
                const selected=etagesFloorFilter!==''&&Number(etagesFloorFilter)===Number(f);
                return`<article class="ch-etage-card${active?'':' is-dimmed'}${selected?' is-active':''}" data-floor="${f}" role="button" tabindex="0">
                    <h3>${floorLbl(f)}</h3>
                    <div class="et-count">${list.length}</div>
                    <p class="et-meta">${list.length?`${dispo} dispo · ${occu} occupée(s)`:'Aucune chambre'}</p>
                </article>`;
            }).join('');
            box.querySelectorAll('.ch-etage-card').forEach(el=>{
                const pick=()=>{
                    etagesFloorFilter=String(el.dataset.floor||'');
                    clearEtageSearch();
                    const sel=document.getElementById('etFloorFilter');
                    if(sel)sel.value=etagesFloorFilter;
                    renderEtages();
                };
                el.addEventListener('click',pick);
                el.addEventListener('keydown',e=>{if(e.key==='Enter'||e.key===' '){e.preventDefault();pick();}});
            });
        }
        renderEtagesTable();
        if(!etagesBound){
            document.getElementById('etFloorSearch')?.addEventListener('input',e=>{
                etagesFloorQ=e.target.value;
                renderEtages();
            });
            document.getElementById('etFloorFilter')?.addEventListener('change',e=>{
                etagesFloorFilter=e.target.value||'';
                clearEtageSearch();
                renderEtages();
            });
            etagesBound=true;
        }
    }

    document.getElementById('etAddBtn')?.addEventListener('click',e=>{
        e.preventDefault();
        showAddModal();
    });

    function select(num){
        const r=roomByNum(num);
        if(r)showDetail(r);
    }

    function reserve(num){
        syncFromStorage();
        const r=roomByNum(num);
        if(r)showForm(r);
    }

    function goResaPanel(status){
        const occ=status==='occupee';
        if(typeof activatePanel==='function'){
            activatePanel(occ?'ch-occupees':'ch-reservations',occ?'C-Occupées':'Réservations');
        }
    }

    /** Clic photo : formulaire rempli + transfert Réservations / C-Occupées */
    function openDashRoom(num){
        syncFromStorage();
        const r=roomByNum(num);
        if(!r)return;
        const saved=getResas()[r.num];
        if(r.status==='disponible'&&!saved?.validated){
            showForm(r);
            return;
        }
        if(saved?.validated){
            const st=saved.statusChambre||r.status||'reservee';
            goResaPanel(st);
            showForm(r,saved,{edit:true});
            return;
        }
        if(r.status==='reservee'||r.status==='occupee'){
            goResaPanel(r.status);
            showForm(r,saved||null,{edit:true});
            return;
        }
        if(r.status==='nettoyage'||r.status==='maintenance'){
            if(CAN_MANAGE)showAdminStatusPanel(r);
            else if(MSG[r.status])showMessage(r,r.status);
            else showForm(r);
            return;
        }
        showForm(r,null,{edit:true});
    }

    function viewRoom(num){
        syncFromStorage();
        const r=roomByNum(num);
        if(!r)return;
        const saved=getResas()[r.num];
        showForm(r,saved||null,{view:true});
    }

    function printRoom(num,isPdf){
        syncFromStorage();
        const r=roomByNum(num);
        if(!r)return;
        const saved=getResas()[r.num];
        showForm(r,saved||null,{edit:true});
        printForm(r,!!isPdf);
    }

    return{render,renderEtages,select,reserve,openDashRoom,viewRoom,printRoom,showAddModal,openContenu,openRoomFiche};
})();
window.CHETAT=CHETAT;

/* ===== Tableau de bord — chambres en photos ===== */
const DASH=(function(){
    const STATUS={disponible:'Disponible',occupee:'Occupée',reservee:'Réservée',nettoyage:'Nettoyage',maintenance:'Maintenance'};
    const FILTERS=[['','Toutes'],['disponible','Disponibles'],['occupee','Occupées'],['reservee','Réservées'],['nettoyage','Nettoyage'],['maintenance','Maintenance']];
    const CAT_CARDS=[['suite','Suites','Grand Suite & Junior'],['single','Single','Chambres singles'],['double','Double','Chambres doubles']];
    const CAT_LBL={suite:'Suite',single:'Single',double:'Double'};
    const K_HIDDEN='aj_dash_rooms_hidden',K_FILT='aj_dash_filters_hidden',K_HIST='aj_ch_hist',K_LOG='aj_resa_log';
    const MOIS=['janv.','févr.','mars','avr.','mai','juin','juil.','août','sept.','oct.','nov.','déc.'];
    const PERIODS=[['jour','Jour'],['mois','Mois'],['annee','Année']];
    let filter='',catFilter='',floorFilter='',roomsHidden=localStorage.getItem(K_HIDDEN)==='1',filtersHidden=localStorage.getItem(K_FILT)==='1',pRooms='jour',pFin='mois';
    const eyeOn='<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>';
    const eyeOff='<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19"/><path d="M1 1l22 22"/></svg>';
    const esc=s=>{let t=s==null?'':String(s);const m=t.match(/^(\d{4})-(\d{2})-(\d{2})$/);if(m)t=m[3]+'/'+m[2]+'/'+m[1];return t.replace(/[&<>"]/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c]));};
    const catOf=t=>t==='grand-suite'||t==='suite-junior'||t==='suite'?'suite':(t==='familiale'||t==='double'?'double':'single');
    const floorLbl=f=>Number(f)===1?'1er étage':`${f}e étage`;
    const sortRooms=(a,b)=>{
        const fa=Number(a.floor)||0,fb=Number(b.floor)||0;
        if(fa!==fb)return fa-fb;
        return String(a.num).localeCompare(String(b.num),undefined,{numeric:true});
    };
    const load=k=>{try{return JSON.parse(localStorage.getItem(k)||'{}')||{};}catch(e){return{};}};
    const loadArr=k=>{try{const v=JSON.parse(localStorage.getItem(k)||'[]');return Array.isArray(v)?v:[];}catch(e){return[];}};
    const num=v=>Number(v)||0;
    const fmtDH=v=>ajMoneyDH(v);
    const iso=d=>`${d.getFullYear()}-${String(d.getMonth()+1).padStart(2,'0')}-${String(d.getDate()).padStart(2,'0')}`;
    const frDate=s=>s&&/^\d{4}-\d{2}-\d{2}/.test(s)?`${s.slice(8,10)}/${s.slice(5,7)}/${s.slice(0,4)}`:(s||'—');
    const keyOf=(date,p)=>!date?'':p==='jour'?date.slice(0,10):p==='mois'?date.slice(0,7):date.slice(0,4);

    function recordSnapshot(count){
        const hist=load(K_HIST);
        hist[iso(new Date())]={disponible:count.disponible||0,occupee:count.occupee||0,reservee:count.reservee||0,nettoyage:count.nettoyage||0,maintenance:count.maintenance||0};
        const keys=Object.keys(hist).sort();
        while(keys.length>800)delete hist[keys.shift()];
        localStorage.setItem(K_HIST,JSON.stringify(hist));
        return hist;
    }

    function reservations(){
        const log=loadArr(K_LOG),resas=load('aj_ch_resa');
        let changed=false;
        Object.entries(resas).forEach(([n,r])=>{
            if(!r||!r.validated)return;
            if(log.some(x=>x.num===n&&x.date===r.date&&x.nom===r.nom))return;
            const seq=log.reduce((m,x)=>Math.max(m,parseInt(String(x.id).replace(/\D/g,''),10)||0),0)+1;
            log.push({id:'R'+String(seq).padStart(4,'0'),date:r.date||'',num:n,nom:r.nom||'',montant:num(r.ttc),paye:0,at:Date.now()});
            changed=true;
        });
        if(changed)localStorage.setItem(K_LOG,JSON.stringify(log));
        return log;
    }

    function bons(){
        const frns=loadArr('aj_frns'),regls=loadArr('aj_regls');
        const list=loadArr('aj_bons').map(b=>({
            id:b.id,date:b.date||'',num:b.num||b.ref||'',frnsId:b.frnsId||'',
            frnsNom:b.frnsNom||(frns.find(f=>f.id===b.frnsId)||{}).nom||'—',
            total:num(b.total!=null?b.total:b.montant)
        }));
        const byF={};
        list.forEach(b=>{(byF[b.frnsId]=byF[b.frnsId]||[]).push(b);});
        Object.entries(byF).forEach(([fid,arr])=>{
            const f=frns.find(x=>x.id===fid);
            let pay=regls.filter(r=>r.frnsId===fid).reduce((s,r)=>s+num(r.montant),0)-num(f&&f.solde);
            if(pay<0)pay=0;
            arr.slice().sort((a,b)=>a.date.localeCompare(b.date)).forEach(b=>{
                const used=Math.min(b.total,pay);pay-=used;b.solde=b.total-used;
            });
        });
        return list;
    }

    function buckets(p){
        const now=new Date(),out=[];
        if(p==='jour'){
            for(let i=13;i>=0;i--){const d=new Date(now.getFullYear(),now.getMonth(),now.getDate()-i);const k=iso(d);out.push({k,label:k.slice(8,10)+'/'+k.slice(5,7)});}
        }else if(p==='mois'){
            for(let i=11;i>=0;i--){const d=new Date(now.getFullYear(),now.getMonth()-i,1);out.push({k:iso(d).slice(0,7),label:MOIS[d.getMonth()]});}
        }else{
            for(let i=4;i>=0;i--){const y=String(now.getFullYear()-i);out.push({k:y,label:y});}
        }
        return out;
    }

    function niceMax(v){
        if(!(v>0))return 4;
        const p=Math.pow(10,Math.floor(Math.log10(v)));
        for(const m of [1,2,2.5,5,10])if(m*p>=v)return m*p;
        return 10*p;
    }
    function short(n){
        n=num(n);const a=Math.abs(n);
        if(a>=1e6)return (n/1e6).toFixed(1).replace('.0','')+'M';
        if(a>=1e4)return Math.round(n/1e3)+'k';
        return (Math.round(n*10)/10).toLocaleString('fr-FR');
    }

    function chartSvg(labels,series){
        const bars=series.filter(s=>s.type!=='line'),lines=series.filter(s=>s.type==='line');
        const W=820,H=290,L=58,R=lines.length?46:16,T=14,B=34,iw=W-L-R,ih=H-T-B;
        const maxL=niceMax(Math.max(0,...bars.flatMap(s=>s.values)));
        const maxR=lines.length?niceMax(Math.max(0,...lines.flatMap(s=>s.values))):1;
        const y=(v,m)=>T+ih-(v/m)*ih;
        const n=labels.length,gw=iw/n,bw=bars.length?Math.min(24,(gw*0.74)/bars.length):0;
        let out='';
        for(let i=0;i<=4;i++){
            const yy=y(maxL*i/4,maxL);
            out+=`<line x1="${L}" x2="${W-R}" y1="${yy}" y2="${yy}" class="da-grid"/>`;
            out+=`<text x="${L-8}" y="${yy+4}" class="da-ax" text-anchor="end">${short(maxL*i/4)}</text>`;
            if(lines.length)out+=`<text x="${W-R+8}" y="${yy+4}" class="da-ax da-ax-r">${short(maxR*i/4)}</text>`;
        }
        const step=Math.ceil(n/12);
        labels.forEach((lab,i)=>{
            const x0=L+i*gw+(gw-bw*bars.length)/2;
            bars.forEach((s,j)=>{
                const v=num(s.values[i]),h=(v/maxL)*ih;
                out+=`<rect x="${x0+j*bw+1}" y="${T+ih-h}" width="${Math.max(1,bw-2)}" height="${h}" rx="3" fill="${s.color}"><title>${esc(lab)} — ${esc(s.label)} : ${s.fmt?s.fmt(v):v}</title></rect>`;
            });
            if(i%step===0)out+=`<text x="${L+i*gw+gw/2}" y="${H-10}" class="da-ax" text-anchor="middle">${esc(lab)}</text>`;
        });
        lines.forEach(s=>{
            const pts=s.values.map((v,i)=>[L+i*gw+gw/2,y(num(v),maxR)]);
            out+=`<polyline points="${pts.map(p=>p[0].toFixed(1)+','+p[1].toFixed(1)).join(' ')}" fill="none" stroke="${s.color}" stroke-width="2.5" stroke-linejoin="round"/>`;
            out+=pts.map((p,i)=>`<circle cx="${p[0].toFixed(1)}" cy="${p[1].toFixed(1)}" r="4" fill="#fff" stroke="${s.color}" stroke-width="2"><title>${esc(labels[i])} — ${esc(s.label)} : ${num(s.values[i])}</title></circle>`).join('');
        });
        return`<svg viewBox="0 0 ${W} ${H}" role="img" aria-label="Diagramme">${out}</svg>`;
    }

    function legend(series){
        return`<div class="da-legend">${series.map(s=>`<span><i class="${s.type==='line'?'line':''}" style="background:${s.color}"></i>${esc(s.label)}</span>`).join('')}</div>`;
    }
    function tabs(chart,cur){
        return`<div class="da-tabs" role="tablist">${PERIODS.map(([k,l])=>`<button type="button" class="da-tab${cur===k?' is-on':''}" data-chart="${chart}" data-p="${k}">${l}</button>`).join('')}</div>`;
    }

    function roomsChart(hist){
        const bk=buckets(pRooms);
        const defs=[['disponible','Disponibles','#e0b43a'],['occupee','Occupées','#2fa864'],['reservee','Réservées','#3b7be0'],['maintenance','Maintenance','#d9534f']];
        const series=defs.map(([k,l,c])=>({label:l,color:c,values:bk.map(b=>{
            const days=Object.keys(hist).filter(d=>keyOf(d,pRooms)===b.k);
            return days.length?Math.round(days.reduce((s,d)=>s+num(hist[d][k]),0)/days.length):0;
        })}));
        return{labels:bk.map(b=>b.label),series};
    }

    function financeChart(resaList,bonList){
        const bk=buckets(pFin);
        const inB=(date,b)=>keyOf(date,pFin)===b.k;
        const series=[
            {label:'Revenus (DH)',color:'#2fa864',fmt:fmtDH,values:bk.map(b=>resaList.filter(r=>inB(r.date,b)).reduce((s,r)=>s+num(r.montant),0))},
            {label:'Charges (DH)',color:'#d9534f',fmt:fmtDH,values:bk.map(b=>bonList.filter(x=>inB(x.date,b)).reduce((s,x)=>s+x.total,0))},
            {label:'Clients (axe de droite)',color:'#3b7be0',type:'line',values:bk.map(b=>resaList.filter(r=>inB(r.date,b)).length)}
        ];
        return{labels:bk.map(b=>b.label),series};
    }

    const byRecent=(a,b)=>(b.date||'').localeCompare(a.date||'')||num(b.at)-num(a.at)||String(b.id).localeCompare(String(a.id));
    const soldeCell=v=>`<td class="amt solde ${v>0.004?'due':'ok'}">${fmtDH(v)}</td>`;

    function analyticsHtml(hist){
        const resaList=reservations(),bonList=bons();
        const rc=roomsChart(hist),fc=financeChart(resaList,bonList);
        const lastBons=bonList.slice().sort(byRecent).slice(0,5);
        const lastResas=resaList.slice().sort(byRecent).slice(0,5);
        const emptyRow=t=>`<tr class="da-empty"><td colspan="5">${t}</td></tr>`;
        const charts=window.ajDashOn('dash-cartes')?`
            <section class="da-card" data-dash="cartes">
                <div class="da-head"><h3>Occupation des chambres</h3>${tabs('rooms',pRooms)}</div>
                ${legend(rc.series)}
                <div class="da-chart">${chartSvg(rc.labels,rc.series)}</div>
                <p class="da-note">Moyenne des statuts relevés chaque jour à l'ouverture du tableau de bord.</p>
            </section>
            <section class="da-card" data-dash="cartes">
                <div class="da-head"><h3>Clients, revenus &amp; charges</h3>${tabs('fin',pFin)}</div>
                ${legend(fc.series)}
                <div class="da-chart">${chartSvg(fc.labels,fc.series)}</div>
                <p class="da-note">Revenus et clients : réservations validées · Charges : bons d'achat.</p>
            </section>`:'';
        const tables=window.ajDashOn('dash-tableaux')?`
            <section class="da-card" data-dash="tableaux">
                <div class="da-head"><h3>5 derniers bons de commande</h3></div>
                <div class="da-table-wrap"><table class="da-table">
                    <thead><tr><th>Date</th><th>Bon N°</th><th>Fournisseur</th><th>Montant</th><th>Solde</th></tr></thead>
                    <tbody>${lastBons.length?lastBons.map(b=>`<tr><td>${frDate(b.date)}</td><td>${esc(b.num||'—')}</td><td>${esc(b.frnsNom)}</td><td class="amt">${fmtDH(b.total)}</td>${soldeCell(b.solde)}</tr>`).join(''):emptyRow('Aucun bon de commande.')}</tbody>
                </table></div>
            </section>
            <section class="da-card" data-dash="tableaux">
                <div class="da-head"><h3>5 dernières réservations</h3></div>
                <div class="da-table-wrap"><table class="da-table">
                    <thead><tr><th>Date</th><th>ID</th><th>Nom client</th><th>Montant</th><th>Solde</th></tr></thead>
                    <tbody>${lastResas.length?lastResas.map(r=>`<tr><td>${frDate(r.date)}</td><td>${esc(r.id)}</td><td>${esc(r.nom||'—')}</td><td class="amt">${fmtDH(r.montant)}</td>${soldeCell(num(r.montant)-num(r.paye))}</tr>`).join(''):emptyRow('Aucune réservation.')}</tbody>
                </table></div>
            </section>`:'';
        return charts||tables?`<div class="dash-analytics">${charts}${tables}</div>`:'';
    }

    function rooms(){
        const base=window.AJ_HOTEL?window.AJ_HOTEL.getCatalog():[];
        const statuses=load('aj_ch_status'),resas=load('aj_ch_resa');
        return base.map(r=>{
            let st=r.status||'disponible';
            if(resas[r.num]?.validated)st=resas[r.num].statusChambre||'reservee';
            else if(statuses[r.num])st=statuses[r.num];
            return{...r,status:STATUS[st]?st:'disponible'};
        });
    }

    function render(){
        const box=document.getElementById('dashboard');
        if(!box)return;
        const all=rooms();
        const count={};
        all.forEach(r=>{count[r.status]=(count[r.status]||0)+1;});
        const set=(id,v)=>{const el=document.getElementById(id);if(el)el.textContent=v;};
        set('kpiChambres',all.length);
        set('kpiOccupees',count.occupee||0);
        const hist=recordSnapshot(count);
        const canRooms=window.ajDashOn('dash-rooms');
        const canAnalytics=window.ajDashOn('dash-cartes')||window.ajDashOn('dash-tableaux');
        const showRooms=canRooms&&(!canAnalytics||!roomsHidden);
        const filtActive=!!(filter||catFilter||floorFilter);
        const filtToggle=`<button type="button" class="dr-toggle dr-toggle-filt${filtActive?' has-active':''}" id="drFiltToggle" aria-pressed="${filtersHidden}" title="${filtersHidden?'Afficher les pastilles de recherche':'Masquer les pastilles de recherche'}" aria-label="${filtersHidden?'Afficher les pastilles de recherche':'Masquer les pastilles de recherche'}">${filtersHidden?eyeOn:eyeOff}</button>`;
        const roomsToggle=canRooms&&canAnalytics?`<button type="button" class="dr-toggle" id="drToggle" aria-pressed="${roomsHidden}" title="${roomsHidden?'Afficher les chambres':'Masquer les chambres'}" aria-label="${roomsHidden?'Afficher les chambres':'Masquer les chambres'}">${roomsHidden?eyeOn:eyeOff}</button>`:'';
        const toggle=roomsToggle;

        if(!canRooms&&!canAnalytics){
            box.innerHTML='<p class="dr-empty">Aucune partie du tableau de bord n\'est autorisée.</p>';
            return;
        }

        if(!showRooms){
            box.innerHTML=`
            <div class="dash-rooms">
                <div class="dr-head">
                    <div>
                        <span class="dr-eyebrow">Pilotage</span>
                        <h2 class="dr-title">Activité de l'hôtel</h2>
                    </div>
                    <div class="dr-tools">${toggle}</div>
                </div>
                ${analyticsHtml(hist)}
            </div>`;
            box.querySelector('#drToggle')?.addEventListener('click',()=>{roomsHidden=false;localStorage.setItem(K_HIDDEN,'0');render();});
            box.querySelectorAll('.da-tab').forEach(t=>t.addEventListener('click',()=>{
                if(t.dataset.chart==='rooms')pRooms=t.dataset.p;else pFin=t.dataset.p;
                render();
            }));
            return;
        }

        const sorted=all.slice().sort(sortRooms);
        const floors=[...new Set(sorted.map(r=>Number(r.floor)).filter(f=>f>0))].sort((a,b)=>a-b);
        if(floorFilter&&!floors.some(f=>String(f)===String(floorFilter)))floorFilter='';
        const floorCount={};
        floors.forEach(f=>{floorCount[f]=sorted.filter(r=>Number(r.floor)===f).length;});
        const catCount={suite:0,single:0,double:0};
        sorted.forEach(r=>{catCount[catOf(r.type)]=(catCount[catOf(r.type)]||0)+1;});
        const list=sorted.filter(r=>
            (!filter||r.status===filter)&&
            (!catFilter||catOf(r.type)===catFilter)&&
            (!floorFilter||String(r.floor)===String(floorFilter))
        );
        const floorPills=`
            <button type="button" class="dr-floor-opt${!floorFilter?' is-on':''}" data-floor="" aria-pressed="${!floorFilter}">Tous<b>${all.length}</b></button>
            ${floors.map(f=>`<button type="button" class="dr-floor-opt${String(floorFilter)===String(f)?' is-on':''}" data-floor="${f}" aria-pressed="${String(floorFilter)===String(f)}">${esc(floorLbl(f))}<b>${floorCount[f]||0}</b></button>`).join('')}
        `;
        const catPills=`
            <button type="button" class="dr-cat${!catFilter?' is-on':''}" data-cat="" aria-pressed="${!catFilter}">Toutes<b>${all.length}</b></button>
            ${CAT_CARDS.map(([k,l])=>`
            <button type="button" class="dr-cat${catFilter===k?' is-on':''}" data-cat="${k}" aria-pressed="${catFilter===k}">${esc(l)}<b>${catCount[k]||0}</b></button>
            `).join('')}
        `;
        const statusPills=FILTERS.map(([k,l])=>{
            const n=k?(count[k]||0):all.length;
            return`<button type="button" class="dr-chip${filter===k?' is-on':''}${k?' st-'+k:''}" data-f="${k}">${l}<b>${n}</b></button>`;
        }).join('');
        let cards='';
        const ficheIco='<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="8" y1="13" x2="16" y2="13"/><line x1="8" y1="17" x2="13" y2="17"/></svg>';
        list.forEach(r=>{
            const cat=catOf(r.type);
            let contenuN=0;
            try{const c=JSON.parse(localStorage.getItem('aj_ch_contenu')||'{}');contenuN=Array.isArray(c[r.num])?c[r.num].length:0;}catch(e){}
            cards+=`
            <article class="dr-card st-${r.status}" data-num="${esc(r.num)}" role="button" tabindex="0">
                <div class="dr-img">
                    <img src="${esc(r.img)}" alt="${esc(r.title)}" loading="lazy">
                    <span class="dr-badge st-${r.status}">${STATUS[r.status]}</span>
                    <span class="dr-num">N° ${esc(r.num)}</span>
                    <button type="button" class="dr-fiche" data-num="${esc(r.num)}" title="Fiche contenu" aria-label="Fiche contenu chambre ${esc(r.num)}">${ficheIco}${contenuN?`<span class="ch-rc-file-n">${contenuN}</span>`:''}</button>
                </div>
                <div class="dr-body">
                    <span class="dr-cat-tag">${esc(CAT_LBL[cat]||cat)}</span>
                    <h3>${esc(r.title)}</h3>
                    <div class="dr-foot">
                        <span class="dr-floor">${esc(floorLbl(r.floor))}</span>
                        <span class="dr-price">${ajMoneyDH(r.price||0)} <small>/ nuit</small></span>
                    </div>
                </div>
            </article>`;
        });

        box.innerHTML=`
            <div class="dash-rooms">
                <div class="dr-head">
                    <h2 class="dr-title">Nos chambres</h2>
                    <div class="dr-filter-bar${filtersHidden?' is-collapsed':''}">
                        ${filtToggle}
                        <div class="dr-filters${filtersHidden?' is-hidden':''}" role="toolbar" aria-label="Filtres chambres"${filtersHidden?' hidden':''}>
                            ${floorPills}
                            <span class="dr-sep" aria-hidden="true"></span>
                            ${catPills}
                            <span class="dr-sep" aria-hidden="true"></span>
                            ${statusPills}
                            <button type="button" class="dr-reset" id="drReset" title="Réinitialiser les filtres" aria-label="Réinitialiser les filtres"${(!filter&&!catFilter&&!floorFilter)?' disabled':''}>
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 12a9 9 0 019-9 9.75 9.75 0 016.74 2.74L21 8"/><path d="M21 3v5h-5"/><path d="M21 12a9 9 0 01-9 9 9.75 9.75 0 01-6.74-2.74L3 16"/><path d="M8 16H3v5"/></svg>
                            </button>
                        </div>
                    </div>
                    <div class="dr-tools">${toggle||''}</div>
                </div>
                <div class="dr-grid">${cards||'<p class="dr-empty">Aucune chambre pour ce filtre.</p>'}</div>
            </div>`;

        box.querySelector('#drToggle')?.addEventListener('click',()=>{roomsHidden=true;localStorage.setItem(K_HIDDEN,'1');render();});
        box.querySelector('#drFiltToggle')?.addEventListener('click',()=>{
            filtersHidden=!filtersHidden;localStorage.setItem(K_FILT,filtersHidden?'1':'0');render();
        });
        box.querySelector('#drReset')?.addEventListener('click',()=>{
            filter='';catFilter='';floorFilter='';
            render();
        });
        box.querySelectorAll('.dr-chip').forEach(b=>b.addEventListener('click',()=>{filter=b.dataset.f;render();}));
        box.querySelectorAll('.dr-floor-opt').forEach(b=>b.addEventListener('click',()=>{floorFilter=b.dataset.floor||'';render();}));
        box.querySelectorAll('.dr-cat').forEach(b=>b.addEventListener('click',()=>{
            catFilter=b.dataset.cat||'';
            render();
        }));
        box.querySelectorAll('.dr-fiche').forEach(btn=>{
            btn.addEventListener('click',e=>{
                e.preventDefault();e.stopPropagation();
                window.CHETAT?.openRoomFiche?.(btn.dataset.num);
            });
        });
        box.querySelectorAll('.dr-card').forEach(c=>{
            const open=()=>{
                const num=c.dataset.num;
                if(window.CHETAT?.openDashRoom)window.CHETAT.openDashRoom(num);
                else if(window.CHETAT?.reserve)window.CHETAT.reserve(num);
            };
            c.addEventListener('click',e=>{if(e.target.closest('.dr-fiche'))return;open();});
            c.addEventListener('keydown',e=>{if(e.key==='Enter'||e.key===' '){e.preventDefault();open();}});
        });
    }

    return{render};
})();
window.DASH=DASH;
DASH.render();

/* ===== Réservations — liste et nouvelle réservation ===== */
const RESA=(function(){
    const STATUS={disponible:'Disponible',occupee:'Occupée',reservee:'Réservée',nettoyage:'Nettoyage',maintenance:'Maintenance'};
    const esc=s=>{let t=s==null?'':String(s);const m=t.match(/^(\d{4})-(\d{2})-(\d{2})$/);if(m)t=m[3]+'/'+m[2]+'/'+m[1];return t.replace(/[&<>"]/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c]));};
    const num=v=>Number(v)||0;
    const load=(k,d)=>{try{return JSON.parse(localStorage.getItem(k)||'null')||d;}catch(e){return d;}};
    const iso=d=>`${d.getFullYear()}-${String(d.getMonth()+1).padStart(2,'0')}-${String(d.getDate()).padStart(2,'0')}`;
    const frDate=s=>s&&/^\d{4}-\d{2}-\d{2}/.test(s)?`${s.slice(8,10)}/${s.slice(5,7)}/${s.slice(0,4)}`:'—';
    const fmtDH=v=>ajMoneyDH(v);
    const addDays=(s,n)=>{if(!s)return'';const d=new Date(s+'T00:00:00');d.setDate(d.getDate()+n);return iso(d);};
    const floorLbl=f=>Number(f)===1?'1er étage':f+'e étage';

    function rooms(){
        const base=window.AJ_HOTEL?window.AJ_HOTEL.getCatalog():[];
        const statuses=load('aj_ch_status',{}),resas=load('aj_ch_resa',{});
        return base.map(r=>{
            let st=r.status||'disponible';
            if(resas[r.num]?.validated)st=resas[r.num].statusChambre||'reservee';
            else if(statuses[r.num])st=statuses[r.num];
            return{...r,status:STATUS[st]?st:'disponible'};
        });
    }

    function bcMeta(){try{return JSON.parse(localStorage.getItem('aj_bc_meta')||'{}')||{};}catch(e){return{};}}
    function payeOf(row){
        const m=bcMeta()[row.id];
        if(m&&m.paye!=null)return num(m.paye);
        if(row.mnt!=null&&row.mnt!=='')return num(row.mnt);
        return num(row.paye);
    }
    function enrich(row){
        const nuits=num(row.nuits)||1;
        const montant=num(row.montant!=null?row.montant:(row.ttc!=null?row.ttc:0));
        const tarif=row.tarif!=null&&row.tarif!==''?num(row.tarif):(nuits?montant/nuits:0);
        const paye=payeOf(row);
        const dateRes=row.at?iso(new Date(num(row.at))):(row.date||'');
        return{
            ...row,
            nuits,
            montant,
            tarif,
            paye,
            solde:Math.max(0,montant-paye),
            cin:row.cin||'',
            ref:row.ref||row.id||('R-'+row.num),
            dateRes,
            depart:row.depart||addDays(row.date,nuits),
            commercial:row.commercial||'—'
        };
    }

    function list(){
        const log=load('aj_resa_log',[]);
        const resas=load('aj_ch_resa',{});
        const rows=[];
        const activeNums=new Set();
        Object.keys(resas).forEach(roomNum=>{
            const cur=resas[roomNum];
            if(!cur?.validated)return;
            const st=cur.statusChambre||'reservee';
            if(st!=='occupee'&&st!=='reservee')return;
            const match=[...log].reverse().find(x=>String(x.num)===String(roomNum)&&!x.cancelled)||{};
            const nuits=num(cur.nuits)||num(match.nuits)||1;
            rows.push(enrich({
                ...match,
                ...cur,
                id:match.id||('R-'+roomNum),
                ref:match.ref||cur.ref||match.id||('R-'+roomNum),
                num:roomNum,
                nom:cur.nom||match.nom||'—',
                commercial:cur.commercial||match.commercial||'—',
                cin:cur.cin||match.cin||'',
                date:cur.date||match.date||'',
                at:match.at||cur.at||Date.now(),
                nuits,
                tarif:cur.tarif!=null?cur.tarif:match.tarif,
                montant:(cur.ttc!=null&&cur.ttc!=='')?num(cur.ttc):num(match.montant),
                mnt:cur.mnt!=null?cur.mnt:match.paye,
                paye:cur.mnt!=null?cur.mnt:match.paye,
                depart:addDays(cur.date||match.date,nuits),
                active:true,
                statut:st
            }));
            activeNums.add(String(roomNum));
        });
        log.forEach(x=>{
            if(x.cancelled)return;
            const cur=resas[x.num];
            if(cur?.validated&&activeNums.has(String(x.num))){
                if(cur.date===x.date&&cur.nom===x.nom)return;
            }
            if(activeNums.has(String(x.num))&&cur?.validated)return;
            const nuits=num(x.nuits)||1;
            rows.push(enrich({...x,nuits,depart:addDays(x.date,nuits),active:false,statut:'terminee'}));
        });
        return rows.sort((a,b)=>(b.date||'').localeCompare(a.date||'')||num(b.at)-num(a.at));
    }

    function editRow(num){
        if(num&&window.CHETAT?.openDashRoom)window.CHETAT.openDashRoom(num);
    }

    function viewRow(num){
        if(num&&window.CHETAT?.viewRoom)window.CHETAT.viewRoom(num);
        else editRow(num);
    }

    function printRow(num){
        if(num&&window.CHETAT?.printRoom)window.CHETAT.printRoom(num,false);
    }

    function cancelRow(num){
        if(!num)return;
        if(!confirm('Annuler cette réservation / occupation et libérer la chambre '+num+' ?'))return;
        const resas=load('aj_ch_resa',{});
        delete resas[num];
        localStorage.setItem('aj_ch_resa',JSON.stringify(resas));
        const statuses=load('aj_ch_status',{});
        statuses[num]='disponible';
        localStorage.setItem('aj_ch_status',JSON.stringify(statuses));
        let log=load('aj_resa_log',[]);
        log=log.map(x=>{
            if(String(x.num)===String(num)&&!x.cancelled)return{...x,cancelled:true,cancelledAt:Date.now()};
            return x;
        });
        localStorage.setItem('aj_resa_log',JSON.stringify(log));
        render();
        window.DASH?.render();
        window.CALEND?.render();
        window.CHETAT?.render();
        window.BCL?.render();
        window.BPY?.render();
        window.AJ_RESA_SYNC?.syncToServer();
    }

    const OCC_ICO={
        voir:'<svg viewBox="0 0 24 24"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>',
        edit:'<svg viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 013 3L8 18l-4 1 1-4 11.5-11.5z"/></svg>',
        print:'<svg viewBox="0 0 24 24"><path d="M6 9V3h12v6"/><path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"/><rect x="6" y="14" width="12" height="7"/></svg>'
    };

    function rowHtml(r){
        const actions=r.active?`<td class="no-print">
                <button type="button" class="ibtn" data-resa-edit="${esc(r.num)}" title="Modifier" aria-label="Modifier">&#9998;</button>
                <button type="button" class="ibtn del" data-resa-cancel="${esc(r.num)}" title="Annuler" aria-label="Annuler">&#10005;</button>
            </td>`:`<td class="no-print">—</td>`;
        return`<tr class="resa-row" data-num="${esc(r.num)}" data-statut="${esc(r.statut)}">
            <td>${esc(r.id)}</td><td>${esc(r.nom||'—')}</td><td>${esc(r.commercial||'—')}</td><td>${esc(r.num)}</td>
            <td>${frDate(r.date)}</td><td>${frDate(r.depart)}</td><td>${r.nuits}</td>
            <td>${fmtDH(r.montant)}</td>
            <td><span class="resa-st st-${esc(r.statut)}">${r.active?STATUS[r.statut]||'Réservée':'Terminée'}</span></td>
            ${actions}
        </tr>`;
    }

    function occRowHtml(r){
        return`<tr class="resa-row" data-num="${esc(r.num)}" data-statut="${esc(r.statut)}">
            <td>${frDate(r.dateRes||r.date)}</td>
            <td>${esc(r.ref||r.id)}</td>
            <td>${esc(r.nom||'—')}</td>
            <td>${esc(r.cin||'—')}</td>
            <td>${frDate(r.date)}</td>
            <td>${frDate(r.depart)}</td>
            <td>${r.nuits}</td>
            <td class="bc-money">${fmtDH(r.tarif)}</td>
            <td class="bc-money">${fmtDH(r.montant)}</td>
            <td class="bc-money">${fmtDH(r.paye)}</td>
            <td class="bc-money bc-solde ${r.solde<=0.009?'ok':'due'}">${fmtDH(r.solde)}</td>
            <td>${esc(r.commercial||'—')}</td>
            <td class="no-print"><div class="bc-actions">
                <button type="button" class="bc-ico" data-occ="voir" data-num="${esc(r.num)}" title="Voir">${OCC_ICO.voir}</button>
                <button type="button" class="bc-ico" data-occ="edit" data-num="${esc(r.num)}" title="Modifier">${OCC_ICO.edit}</button>
                <button type="button" class="bc-ico" data-occ="print" data-num="${esc(r.num)}" title="Imprimer">${OCC_ICO.print}</button>
            </div></td>
        </tr>`;
    }

    const OCC_MOIS=['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];
    function occMonthKey(r){
        const raw=String(r.date||r.dateRes||'').slice(0,7);
        return /^\d{4}-\d{2}$/.test(raw)?raw:'';
    }
    function occMonthLabel(ym){
        const m=parseInt(String(ym).slice(5,7),10);
        const y=String(ym).slice(0,4);
        if(!m||m<1||m>12)return ym;
        return OCC_MOIS[m-1]+' '+y;
    }
    function fillOccSelects(occupied){
        const monthEl=document.getElementById('occMonth');
        const respEl=document.getElementById('occResp');
        if(monthEl){
            const cur=monthEl.value;
            const keys=[...new Set(occupied.map(occMonthKey).filter(Boolean))].sort().reverse();
            monthEl.innerHTML='<option value="">Tous les mois</option>'+keys.map(k=>`<option value="${esc(k)}">${esc(occMonthLabel(k))}</option>`).join('');
            if(keys.includes(cur))monthEl.value=cur;
        }
        if(respEl){
            const cur=respEl.value;
            const names=[...new Set(occupied.map(r=>String(r.commercial||'').trim()).filter(n=>n&&n!=='—'))]
                .sort((a,b)=>a.localeCompare(b,'fr',{sensitivity:'base'}));
            respEl.innerHTML='<option value="">Tous</option>'+names.map(n=>`<option value="${esc(n)}">${esc(n)}</option>`).join('');
            if(names.includes(cur))respEl.value=cur;
        }
    }
    function occFiltered(occupied){
        const month=document.getElementById('occMonth')?.value||'';
        const chambre=(document.getElementById('occChambre')?.value||'').trim().toLowerCase();
        const nom=(document.getElementById('occNom')?.value||'').trim().toLowerCase();
        const cin=(document.getElementById('occCin')?.value||'').trim().toLowerCase();
        const resp=(document.getElementById('occResp')?.value||'').trim().toLowerCase();
        return occupied.filter(r=>{
            if(month&&occMonthKey(r)!==month)return false;
            if(chambre&&!String(r.num).toLowerCase().includes(chambre))return false;
            if(nom&&!String(r.nom||'').toLowerCase().includes(nom))return false;
            if(cin&&!String(r.cin||'').toLowerCase().includes(cin))return false;
            if(resp&&String(r.commercial||'').trim().toLowerCase()!==resp)return false;
            return true;
        });
    }

    function bindRows(tb){
        if(!tb)return;
        tb.querySelectorAll('[data-resa-edit]').forEach(btn=>{
            btn.addEventListener('click',e=>{e.stopPropagation();editRow(btn.dataset.resaEdit);});
        });
        tb.querySelectorAll('[data-resa-cancel]').forEach(btn=>{
            btn.addEventListener('click',e=>{e.stopPropagation();cancelRow(btn.dataset.resaCancel);});
        });
    }

    function bindOccRows(tb){
        if(!tb||tb.dataset.occBound)return;
        tb.dataset.occBound='1';
        tb.addEventListener('click',e=>{
            const btn=e.target.closest('[data-occ]');
            if(!btn)return;
            e.stopPropagation();
            const n=btn.dataset.num;
            if(btn.dataset.occ==='voir')viewRow(n);
            if(btn.dataset.occ==='edit')editRow(n);
            if(btn.dataset.occ==='print')printRow(n);
        });
    }

    function render(){
        const all=list();
        const reserved=all.filter(r=>r.statut==='reservee'||r.statut==='terminee');
        const occupied=all.filter(r=>r.statut==='occupee');
        fillOccSelects(occupied);
        const occList=occFiltered(occupied);
        const resaTb=document.getElementById('resaTbody');
        const occTb=document.getElementById('occTbody');
        if(resaTb){
            resaTb.innerHTML=reserved.length?reserved.map(rowHtml).join(''):'<tr class="empty-row"><td colspan="10">Aucune réservation.</td></tr>';
            bindRows(resaTb);
        }
        if(occTb){
            occTb.innerHTML=occList.length?occList.map(occRowHtml).join(''):'<tr class="empty-row"><td colspan="13">Aucune chambre occupée.</td></tr>';
            bindOccRows(occTb);
        }
        const today=iso(new Date());
        const set=(id,v)=>{const el=document.getElementById(id);if(el)el.textContent=v;};
        const resaActive=reserved.filter(r=>r.active);
        set('resaKpiActive',resaActive.length);
        set('resaKpiArr',resaActive.filter(r=>r.date===today).length);
        set('resaKpiDep',resaActive.filter(r=>r.depart===today).length);
        set('resaKpiTotal',reserved.length);
        const mTotal=occList.reduce((s,r)=>s+num(r.montant),0);
        const mPaye=occList.reduce((s,r)=>s+num(r.paye),0);
        set('occKpiActive',occList.length);
        set('occKpiMontant',fmtDH(mTotal));
        set('occKpiPaye',fmtDH(mPaye));
        set('occKpiSolde',fmtDH(Math.max(0,mTotal-mPaye)));
    }

    function initOccFilters(){
        ['occChambre','occNom','occCin'].forEach(id=>{
            document.getElementById(id)?.addEventListener('input',render);
        });
        ['occMonth','occResp'].forEach(id=>{
            document.getElementById(id)?.addEventListener('change',render);
        });
        document.getElementById('occReset')?.addEventListener('click',()=>{
            ['occMonth','occChambre','occNom','occCin','occResp'].forEach(id=>{const el=document.getElementById(id);if(el)el.value='';});
            render();
        });
    }
    initOccFilters();

    function openPicker(){
        const box=document.getElementById('rmModalContent');
        if(!box)return;
        const free=rooms().filter(r=>r.status==='disponible')
            .sort((a,b)=>String(a.num).localeCompare(String(b.num),undefined,{numeric:true}));
        const floors=[...new Set(free.map(r=>r.floor))].sort((a,b)=>a-b);
        box.innerHTML=`<div class="rm-form-head"><h3>Nouvelle réservation</h3><p>Choisissez une chambre disponible (${free.length} libre${free.length>1?'s':''})</p></div>
        ${free.length?`<form class="rm-form-grid" onsubmit="return false" autocomplete="off">
            <div class="field span2"><label>Chambre</label>
                <select id="resaPickRoom">${floors.map(f=>`<optgroup label="${floorLbl(f)}">${free.filter(r=>r.floor===f).map(r=>`<option value="${esc(r.num)}">${esc(r.num)} — ${esc(r.title)} · ${ajMoneyDH(r.price)} / nuit</option>`).join('')}</optgroup>`).join('')}</select>
            </div>
        </form>
        <div class="rm-form-actions" style="margin-top:18px">
            <button type="button" class="btn gold" id="resaPickGo">Continuer</button>
            <button type="button" class="btn ghost" id="resaPickCancel">Annuler</button>
        </div>`:`<p class="hint" style="margin:18px 0">Aucune chambre disponible pour le moment.</p>
        <div class="rm-form-actions"><button type="button" class="btn ghost" id="resaPickCancel">Fermer</button></div>`}`;
        document.getElementById('resaPickGo')?.addEventListener('click',()=>{
            const n=document.getElementById('resaPickRoom')?.value;
            if(n&&window.CHETAT)window.CHETAT.reserve(n);
        });
        document.getElementById('resaPickCancel')?.addEventListener('click',()=>document.getElementById('rmModalOverlay')?.classList.remove('show'));
        document.getElementById('rmModalOverlay')?.classList.add('show');
    }

    const overlay=document.getElementById('rmModalOverlay');
    const closeAnyModal=()=>overlay?.classList.remove('show');
    document.getElementById('rmModalClose')?.addEventListener('click',closeAnyModal);
    overlay?.addEventListener('click',e=>{if(e.target===overlay)closeAnyModal();});
    document.addEventListener('keydown',e=>{if(e.key==='Escape'&&overlay?.classList.contains('show'))closeAnyModal();});
    render();
    return{render,openPicker};
})();
window.RESA=RESA;
</script>
<script>
/* Balance Clients — import des réservations validées */
const BCL=(function(){
    const K_LOG='aj_resa_log';
    const K_META='aj_bc_meta';
    const TYPES=['','Espèces','Carte bancaire','Virement','Chèque'];
    const esc=s=>String(s==null?'':s).replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
    const num=v=>{const n=Number(v);return Number.isFinite(n)?n:0;};
    const money=v=>ajMoney(v);
    const load=k=>{try{return JSON.parse(localStorage.getItem(k)||'null');}catch(e){return null;}};
    const save=(k,v)=>localStorage.setItem(k,JSON.stringify(v));
    const showDate=iso=>{
        if(typeof ajDate==='function'){const d=ajDate(iso);if(d)return d;}
        const m=String(iso||'').match(/^(\d{4})-(\d{2})-(\d{2})/);
        return m?m[3]+'/'+m[2]+'/'+m[1]:(iso||'—');
    };
    function meta(){return load(K_META)||{};}
    function setMeta(m){save(K_META,m);}
    function syncLog(){
        let log=[];
        try{log=JSON.parse(localStorage.getItem(K_LOG)||'[]')||[];}catch(e){log=[];}
        let resas={};
        try{resas=JSON.parse(localStorage.getItem('aj_ch_resa')||'{}')||{};}catch(e){}
        let changed=false;
        Object.keys(resas).forEach(numKey=>{
            const r=resas[numKey];
            if(!r||!r.validated)return;
            const hit=log.find(x=>String(x.num)===String(r.num||numKey)&&x.date===r.date&&x.nom===r.nom);
            if(hit){
                if(!hit.cin&&r.cin){hit.cin=r.cin;changed=true;}
                if((hit.tarif==null||hit.tarif==='')&&r.tarif!=null){hit.tarif=num(r.tarif);changed=true;}
            }else{
                const seq=log.reduce((m,x)=>Math.max(m,parseInt(String(x.id).replace(/\D/g,''),10)||0),0)+1;
                log.push({id:'R'+String(seq).padStart(4,'0'),date:r.date||'',num:r.num||numKey,nom:r.nom||'',cin:r.cin||'',nuits:num(r.nuits)||1,tarif:num(r.tarif),montant:num(r.ttc!=null?r.ttc:r.montant),paye:0,type:'',at:Date.now()});
                changed=true;
            }
        });
        if(changed)localStorage.setItem(K_LOG,JSON.stringify(log));
        return log;
    }
    function rows(){
        const extra=meta();
        return syncLog().filter(r=>!(extra[r.id]&&extra[r.id].deleted)).map(r=>{
            const m=extra[r.id]||{};
            const jours=num(r.nuits)||1;
            const total=num(r.montant);
            const tarif=r.tarif!=null&&r.tarif!==''?num(r.tarif):(jours?total/jours:0);
            const paye=m.paye!=null?num(m.paye):num(r.paye);
            const type=m.type!=null?m.type:(r.type||'');
            return{id:r.id,date:r.date||'',cin:r.cin||'',nom:r.nom||'',num:r.num||'',jours,tarif,total,paye,type,solde:total-paye};
        }).sort((a,b)=>String(b.date).localeCompare(String(a.date))||String(b.id).localeCompare(String(a.id)));
    }
    function filtered(){
        const month=document.getElementById('bcMonth')?.value||'';
        const nom=(document.getElementById('bcNom')?.value||'').trim().toLowerCase();
        const chambre=(document.getElementById('bcChambre')?.value||'').trim().toLowerCase();
        return rows().filter(r=>{
            if(month&&String(r.date).slice(0,7)!==month)return false;
            if(nom&&!String(r.nom).toLowerCase().includes(nom))return false;
            if(chambre&&!String(r.num).toLowerCase().includes(chambre))return false;
            return true;
        });
    }
    const ico={
        voir:'<svg viewBox="0 0 24 24"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>',
        edit:'<svg viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 013 3L8 18l-4 1 1-4 11.5-11.5z"/></svg>',
        print:'<svg viewBox="0 0 24 24"><path d="M6 9V3h12v6"/><path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"/><rect x="6" y="14" width="12" height="7"/></svg>',
        del:'<svg viewBox="0 0 24 24"><path d="M4 7h16"/><path d="M9 7V4h6v3"/><path d="M8 7l1 13h6l1-13"/></svg>'
    };
    function paintMoney(id,value){
        const el=document.getElementById(id);
        if(el)el.innerHTML=money(value)+' <small>DH</small>';
    }
    function closeModal(){
        const modal=document.getElementById('bcModal');
        if(!modal)return;
        modal.classList.remove('show');
        modal.setAttribute('aria-hidden','true');
    }
    function openModal(html){
        const modal=document.getElementById('bcModal');
        const box=document.getElementById('bcDialog');
        if(!modal||!box)return;
        box.innerHTML=html;
        modal.classList.add('show');
        modal.setAttribute('aria-hidden','false');
    }
    function find(id){return rows().find(r=>r.id===id);}
    function view(id){
        const r=find(id);if(!r)return;
        openModal(`<h3>Réservation ${esc(r.id)}</h3><p class="bc-sub">${esc(r.nom||'Client')} · Chambre ${esc(r.num)}</p>
            <div class="bc-grid">
                <div><span>Date</span><b>${esc(showDate(r.date))}</b></div>
                <div><span>ID Client</span><b>${esc(r.cin||'—')}</b></div>
                <div><span>Nom Client</span><b>${esc(r.nom||'—')}</b></div>
                <div><span>N° Chambre</span><b>${esc(r.num)}</b></div>
                <div><span>Nbrs Jours</span><b>${r.jours}</b></div>
                <div><span>Paie/Jr</span><b>${money(r.tarif)} DH</b></div>
                <div><span>Total</span><b>${money(r.total)} DH</b></div>
                <div><span>Paiement</span><b>${money(r.paye)} DH</b></div>
                <div><span>Type</span><b>${esc(r.type||'—')}</b></div>
                <div><span>Solde</span><b>${money(r.solde)} DH</b></div>
            </div>
            <div class="bc-dialog-actions"><button type="button" class="btn-gold" id="bcClose">Fermer</button></div>`);
        document.getElementById('bcClose')?.addEventListener('click',closeModal);
    }
    function edit(id){
        const r=find(id);if(!r)return;
        openModal(`<h3>Modifier le paiement</h3><p class="bc-sub">${esc(r.nom||'Client')} · Chambre ${esc(r.num)} · Total ${money(r.total)} DH</p>
            <form class="bc-form" id="bcEditForm">
                <label>Paiement (DH)<input type="number" id="bcPaye" min="0" step="0.01" value="${esc(r.paye)}"></label>
                <label>Type<select id="bcType">${TYPES.map(t=>`<option value="${esc(t)}"${t===r.type?' selected':''}>${t||'— Non précisé —'}</option>`).join('')}</select></label>
            </form>
            <div class="bc-dialog-actions">
                <button type="button" class="btn-gold" id="bcSave">Enregistrer</button>
                <button type="button" class="bc-reset" id="bcCancel">Annuler</button>
            </div>`);
        document.getElementById('bcCancel')?.addEventListener('click',closeModal);
        document.getElementById('bcSave')?.addEventListener('click',()=>{
            const paye=num(document.getElementById('bcPaye')?.value);
            const type=document.getElementById('bcType')?.value||'';
            const m=meta();
            m[id]={...(m[id]||{}),paye,type,deleted:false};
            setMeta(m);
            closeModal();
            render();
        });
    }
    function printRow(id){
        const r=find(id);if(!r)return;
        const w=window.open('','_blank','width=720,height=640');
        if(!w)return;
        const lines=[
            ['Date',showDate(r.date)],['ID Client',r.cin||'—'],['Nom Client',r.nom||'—'],
            ['N° Chambre',r.num],['Nbrs Jours',String(r.jours)],['Paie/Jr',money(r.tarif)+' DH'],
            ['Total',money(r.total)+' DH'],['Paiement',money(r.paye)+' DH'],['Type',r.type||'—'],['Solde',money(r.solde)+' DH']
        ];
        w.document.write('<!DOCTYPE html><html><head><meta charset="utf-8"><title>Balance '+esc(r.id)+'</title><style>body{font-family:Georgia,serif;padding:32px;color:#1a2332}h1{text-align:center;font-size:26px;margin:0}p{text-align:center;color:#6b7280}table{width:100%;border-collapse:collapse;margin-top:18px}td{border:1px solid #d9d0bc;padding:10px 12px}td:first-child{width:34%;background:#0a1736;color:#f6efdd;font-family:Arial,sans-serif;font-size:12px;letter-spacing:1px;text-transform:uppercase}</style></head><body><h1>Al Jazeera Hotel</h1><p>Balance client · '+esc(r.id)+'</p><table>'+lines.map(l=>'<tr><td>'+esc(l[0])+'</td><td>'+esc(l[1])+'</td></tr>').join('')+'</table></body></html>');
        w.document.close();
        w.focus();
        w.print();
    }
    function remove(id){
        const r=find(id);if(!r)return;
        if(!confirm('Retirer la réservation '+r.id+' de la balance clients ?'))return;
        const m=meta();
        m[id]={...(m[id]||{}),deleted:true};
        setMeta(m);
        closeModal();
        render();
    }
    function render(){
        const list=filtered();
        const body=document.getElementById('bcBody');
        if(!body)return;
        const total=list.reduce((s,r)=>s+r.total,0);
        const paid=list.reduce((s,r)=>s+r.paye,0);
        paintMoney('bcTotal',total);
        paintMoney('bcPaid',paid);
        paintMoney('bcDue',total-paid);
        body.innerHTML=list.length?list.map(r=>`<tr>
            <td>${esc(showDate(r.date))}</td>
            <td>${esc(r.cin||'—')}</td>
            <td>${esc(r.nom||'—')}</td>
            <td>${esc(r.num)}</td>
            <td>${r.jours}</td>
            <td class="bc-money">${money(r.tarif)}</td>
            <td class="bc-money">${money(r.total)}</td>
            <td class="bc-money">${money(r.paye)}</td>
            <td>${r.type?`<span class="bc-type">${esc(r.type)}</span>`:'<span class="bc-type empty">—</span>'}</td>
            <td class="bc-money bc-solde ${r.solde<=0.009?'ok':'due'}">${money(r.solde)}</td>
            <td><div class="bc-actions">
                <button type="button" class="bc-ico" data-bc="voir" data-id="${esc(r.id)}" title="Voir">${ico.voir}</button>
                <button type="button" class="bc-ico" data-bc="edit" data-id="${esc(r.id)}" title="Modifier">${ico.edit}</button>
                <button type="button" class="bc-ico" data-bc="print" data-id="${esc(r.id)}" title="Imprimer">${ico.print}</button>
                <button type="button" class="bc-ico danger" data-bc="del" data-id="${esc(r.id)}" title="Supprimer">${ico.del}</button>
            </div></td>
        </tr>`).join(''):'<tr class="empty-row"><td colspan="11">Aucune réservation validée pour cette recherche.</td></tr>';
    }
    function init(){
        ['bcMonth','bcNom','bcChambre'].forEach(id=>document.getElementById(id)?.addEventListener('input',render));
        document.getElementById('bcReset')?.addEventListener('click',()=>{
            ['bcMonth','bcNom','bcChambre'].forEach(id=>{const el=document.getElementById(id);if(el)el.value='';});
            render();
        });
        document.getElementById('bcBody')?.addEventListener('click',e=>{
            const btn=e.target.closest('[data-bc]');
            if(!btn)return;
            const id=btn.dataset.id;
            if(btn.dataset.bc==='voir')view(id);
            if(btn.dataset.bc==='edit')edit(id);
            if(btn.dataset.bc==='print')printRow(id);
            if(btn.dataset.bc==='del')remove(id);
        });
        document.getElementById('bcModal')?.addEventListener('click',e=>{if(e.target.id==='bcModal')closeModal();});
        document.addEventListener('keydown',e=>{if(e.key==='Escape')closeModal();});
        render();
    }
    if(document.readyState==='loading')document.addEventListener('DOMContentLoaded',init);
    else init();
    return{render};
})();
window.BCL=BCL;
</script>
<script>
/* Balance Paiement — encaissements des réservations validées */
const BPY=(function(){
    const K_LOG='aj_resa_log';
    const K_HIDE='aj_bp_meta';
    const K_PAY='aj_bc_meta';
    const esc=s=>String(s==null?'':s).replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
    const num=v=>{const n=Number(v);return Number.isFinite(n)?n:0;};
    const money=v=>ajMoney(v);
    const load=k=>{try{return JSON.parse(localStorage.getItem(k)||'null');}catch(e){return null;}};
    const showDate=iso=>{
        if(!iso)return '—';
        if(typeof ajDate==='function'){const d=ajDate(iso);if(d)return d;}
        const m=String(iso).match(/^(\d{4})-(\d{2})-(\d{2})/);
        return m?m[3]+'/'+m[2]+'/'+m[1]:String(iso);
    };
    function rows(){
        let log=[];
        try{log=JSON.parse(localStorage.getItem(K_LOG)||'[]')||[];}catch(e){log=[];}
        const hide=load(K_HIDE)||{};
        const pay=load(K_PAY)||{};
        return log.filter(r=>!(hide[r.id]&&hide[r.id].deleted)).map(r=>{
            const p=pay[r.id]||{};
            const total=num(r.montant);
            const mnt=p.paye!=null?num(p.paye):num(r.paye);
            const type=p.type!=null?p.type:(r.type||'');
            return{
                id:r.id,date:r.date||'',ref:r.ref||r.id,nom:r.nom||'',
                mnt,type,nreg:r.nreg||'',bnq:r.bnq||'',tire:r.tire||'',
                encaisse:r.encaisse||'',total,solde:total-mnt
            };
        }).sort((a,b)=>String(b.date).localeCompare(String(a.date))||String(b.ref).localeCompare(String(a.ref)));
    }
    function filtered(){
        const month=document.getElementById('bpMonth')?.value||'';
        const mnt=(document.getElementById('bpMnt')?.value||'').trim().replace(',','.');
        const nreg=(document.getElementById('bpNreg')?.value||'').trim().toLowerCase();
        const bnq=(document.getElementById('bpBnq')?.value||'').trim().toLowerCase();
        const tire=(document.getElementById('bpTire')?.value||'').trim().toLowerCase();
        return rows().filter(r=>{
            if(month&&String(r.date).slice(0,7)!==month&&String(r.encaisse).slice(0,7)!==month)return false;
            if(mnt && String(r.mnt).indexOf(mnt)===-1 && money(r.mnt).replace(/\s/g,'').indexOf(mnt.replace(/\s/g,''))===-1)return false;
            if(nreg&&!String(r.nreg).toLowerCase().includes(nreg))return false;
            if(bnq&&!String(r.bnq).toLowerCase().includes(bnq))return false;
            if(tire&&!String(r.tire).toLowerCase().includes(tire))return false;
            return true;
        });
    }
    const ico={
        voir:'<svg viewBox="0 0 24 24"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>',
        print:'<svg viewBox="0 0 24 24"><path d="M6 9V3h12v6"/><path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"/><rect x="6" y="14" width="12" height="7"/></svg>',
        pdf:'<svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><path d="M14 2v6h6"/><path d="M8 13h8M8 17h5"/></svg>',
        del:'<svg viewBox="0 0 24 24"><path d="M4 7h16"/><path d="M9 7V4h6v3"/><path d="M8 7l1 13h6l1-13"/></svg>'
    };
    function paint(id,value){
        const el=document.getElementById(id);
        if(el)el.innerHTML=money(value)+' <small>DH</small>';
    }
    function closeModal(){
        const modal=document.getElementById('bpModal');
        if(!modal)return;
        modal.classList.remove('show');
        modal.setAttribute('aria-hidden','true');
    }
    function openModal(html){
        const modal=document.getElementById('bpModal');
        const box=document.getElementById('bpDialog');
        if(!modal||!box)return;
        box.innerHTML=html;
        modal.classList.add('show');
        modal.setAttribute('aria-hidden','false');
    }
    function find(id){return rows().find(r=>r.id===id);}
    function sheet(r){
        const lines=[
            ['Date',showDate(r.date)],['Réf° Rég',r.ref||'—'],['Nom Client',r.nom||'—'],
            ['Mnt',money(r.mnt)+' DH'],['Type',r.type||'—'],['N° Rég',r.nreg||'—'],
            ['Bnq',r.bnq||'—'],['Nom Tiré',r.tire||'—'],['Date Encaissement',showDate(r.encaisse)],
            ['Total séjour',money(r.total)+' DH'],['Solde',money(r.solde)+' DH']
        ];
        return '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Règlement '+esc(r.ref)+'</title><style>body{font-family:Georgia,serif;padding:32px;color:#1a2332}h1{text-align:center;font-size:26px;margin:0}p{text-align:center;color:#6b7280}table{width:100%;border-collapse:collapse;margin-top:18px}td{border:1px solid #d9d0bc;padding:10px 12px}td:first-child{width:38%;background:#0a1736;color:#f6efdd;font-family:Arial,sans-serif;font-size:12px;letter-spacing:1px;text-transform:uppercase}</style></head><body><h1>Al Jazeera Hotel</h1><p>Balance paiement · '+esc(r.ref)+'</p><table>'+lines.map(l=>'<tr><td>'+esc(l[0])+'</td><td>'+esc(l[1])+'</td></tr>').join('')+'</table></body></html>';
    }
    function openDoc(r){
        const w=window.open('','_blank','width=760,height=680');
        if(!w)return null;
        w.document.write(sheet(r));
        w.document.close();
        w.focus();
        return w;
    }
    function view(id){
        const r=find(id);if(!r)return;
        openModal(`<h3>${esc(r.ref)}</h3><p class="bc-sub">${esc(r.nom||'Client')}</p>
            <div class="bc-grid">
                <div><span>Date</span><b>${esc(showDate(r.date))}</b></div>
                <div><span>Réf° Rég</span><b>${esc(r.ref||'—')}</b></div>
                <div><span>Nom Client</span><b>${esc(r.nom||'—')}</b></div>
                <div><span>Mnt</span><b>${money(r.mnt)} DH</b></div>
                <div><span>Type</span><b>${esc(r.type||'—')}</b></div>
                <div><span>N° Rég</span><b>${esc(r.nreg||'—')}</b></div>
                <div><span>Bnq</span><b>${esc(r.bnq||'—')}</b></div>
                <div><span>Nom Tiré</span><b>${esc(r.tire||'—')}</b></div>
                <div><span>Date Encaissement</span><b>${esc(showDate(r.encaisse))}</b></div>
                <div><span>Solde</span><b>${money(r.solde)} DH</b></div>
            </div>
            <div class="bc-dialog-actions"><button type="button" class="btn-gold" id="bpClose">Fermer</button></div>`);
        document.getElementById('bpClose')?.addEventListener('click',closeModal);
    }
    function remove(id){
        const r=find(id);if(!r)return;
        if(!confirm('Retirer le règlement '+r.ref+' de la balance paiement ?'))return;
        const hide=load(K_HIDE)||{};
        hide[id]={deleted:true};
        localStorage.setItem(K_HIDE,JSON.stringify(hide));
        closeModal();
        render();
    }
    function render(){
        const list=filtered();
        const body=document.getElementById('bpBody');
        if(!body)return;
        paint('bpPaid',list.reduce((s,r)=>s+r.mnt,0));
        paint('bpDue',list.reduce((s,r)=>s+r.solde,0));
        body.innerHTML=list.length?list.map(r=>`<tr>
            <td>${esc(showDate(r.date))}</td>
            <td>${esc(r.ref||'—')}</td>
            <td>${esc(r.nom||'—')}</td>
            <td class="bc-money">${money(r.mnt)}</td>
            <td>${r.type?`<span class="bc-type">${esc(r.type)}</span>`:'<span class="bc-type empty">—</span>'}</td>
            <td>${esc(r.nreg||'—')}</td>
            <td>${esc(r.bnq||'—')}</td>
            <td>${esc(r.tire||'—')}</td>
            <td>${esc(showDate(r.encaisse))}</td>
            <td><div class="bc-actions">
                <button type="button" class="bc-ico" data-bp="voir" data-id="${esc(r.id)}" title="Voir">${ico.voir}</button>
                <button type="button" class="bc-ico" data-bp="print" data-id="${esc(r.id)}" title="Imprimer">${ico.print}</button>
                <button type="button" class="bc-ico" data-bp="pdf" data-id="${esc(r.id)}" title="PDF">${ico.pdf}</button>
                <button type="button" class="bc-ico danger" data-bp="del" data-id="${esc(r.id)}" title="Supprimer">${ico.del}</button>
            </div></td>
        </tr>`).join(''):'<tr class="empty-row"><td colspan="10">Aucun paiement pour cette recherche.</td></tr>';
    }
    function init(){
        ['bpMonth','bpMnt','bpNreg','bpBnq','bpTire'].forEach(id=>document.getElementById(id)?.addEventListener('input',render));
        document.getElementById('bpReset')?.addEventListener('click',()=>{
            ['bpMonth','bpMnt','bpNreg','bpBnq','bpTire'].forEach(id=>{const el=document.getElementById(id);if(el)el.value='';});
            render();
        });
        document.getElementById('bpBody')?.addEventListener('click',e=>{
            const btn=e.target.closest('[data-bp]');
            if(!btn)return;
            const id=btn.dataset.id;
            const r=find(id);
            if(btn.dataset.bp==='voir')view(id);
            if(btn.dataset.bp==='print'&&r){const w=openDoc(r);if(w)setTimeout(()=>w.print(),250);}
            if(btn.dataset.bp==='pdf'&&r){const w=openDoc(r);if(w)setTimeout(()=>w.print(),250);}
            if(btn.dataset.bp==='del')remove(id);
        });
        document.getElementById('bpModal')?.addEventListener('click',e=>{if(e.target.id==='bpModal')closeModal();});
        document.addEventListener('keydown',e=>{if(e.key==='Escape')closeModal();});
        render();
    }
    if(document.readyState==='loading')document.addEventListener('DOMContentLoaded',init);
    else init();
    return{render};
})();
window.BPY=BPY;

/* ===== Calendrier — cadres occupées / réservées ===== */
const CALEND=(function(){
    const STATUS={occupee:'Occupée',reservee:'Réservée'};
    const CAT_LBL={'grand-suite':'Grand Suite','suite-junior':'Suite Junior',single:'Single',double:'Double',suite:'Grand Suite',familiale:'Double'};
    const esc=s=>{let t=s==null?'':String(s);const m=t.match(/^(\d{4})-(\d{2})-(\d{2})$/);if(m)t=m[3]+'/'+m[2]+'/'+m[1];return t.replace(/[&<>"]/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c]));};
    const load=(k,d)=>{try{return JSON.parse(localStorage.getItem(k)||'null')||d;}catch(e){return d;}};
    const num=v=>Number(v)||0;
    const iso=d=>`${d.getFullYear()}-${String(d.getMonth()+1).padStart(2,'0')}-${String(d.getDate()).padStart(2,'0')}`;
    const frDate=s=>s&&/^\d{4}-\d{2}-\d{2}/.test(String(s))?`${String(s).slice(8,10)}/${String(s).slice(5,7)}/${String(s).slice(0,4)}`:(s||'—');
    const addDays=(s,n)=>{if(!s)return'';const d=new Date(String(s).slice(0,10)+'T00:00:00');if(Number.isNaN(d.getTime()))return'';d.setDate(d.getDate()+(num(n)||0));return iso(d);};
    const floorLbl=f=>!f&&f!==0?'—':(Number(f)===1?'1er étage':Number(f)+'e étage');
    const money=v=>typeof ajMoneyDH==='function'?ajMoneyDH(v||0):(Number(v||0).toFixed(2)+' DH');
    let filter='';

    function rooms(){
        const base=window.AJ_HOTEL?window.AJ_HOTEL.getCatalog():[];
        const statuses=load('aj_ch_status',{});
        const resas=load('aj_ch_resa',{});
        return base.map(r=>{
            const resa=resas[r.num];
            let st=r.status||'disponible';
            if(resa?.validated)st=resa.statusChambre||'reservee';
            else if(statuses[r.num])st=statuses[r.num];
            if(st!=='occupee'&&st!=='reservee')return null;
            const nuits=num(resa?.nuits)||1;
            const occupation=resa?.date||'';
            const disponibilite=occupation?addDays(occupation,nuits):'';
            const tarif=resa?.tarif!=null&&resa.tarif!==''?resa.tarif:r.price;
            return{
                ...r,
                status:st,
                occupation,
                disponibilite,
                tarif,
                cat:CAT_LBL[r.type]||r.type||'—'
            };
        }).filter(Boolean).sort((a,b)=>num(a.floor)-num(b.floor)||String(a.num).localeCompare(String(b.num),'fr',{numeric:true}));
    }

    function render(){
        const grid=document.getElementById('calGrid');
        const chips=document.getElementById('calChips');
        if(!grid)return;
        const all=rooms();
        const count={occupee:0,reservee:0};
        all.forEach(r=>{if(count[r.status]!=null)count[r.status]++;});
        const list=filter?all.filter(r=>r.status===filter):all;
        if(chips){
            chips.innerHTML=`
                <button type="button" class="cal-chip${!filter?' is-on':''}" data-f="">Toutes<b>${all.length}</b></button>
                <button type="button" class="cal-chip st-occupee${filter==='occupee'?' is-on':''}" data-f="occupee">Occupées<b>${count.occupee}</b></button>
                <button type="button" class="cal-chip st-reservee${filter==='reservee'?' is-on':''}" data-f="reservee">Réservées<b>${count.reservee}</b></button>
            `;
            chips.querySelectorAll('.cal-chip').forEach(btn=>{
                btn.addEventListener('click',()=>{filter=btn.dataset.f||'';render();});
            });
        }
        if(!list.length){
            grid.innerHTML=`<p class="cal-empty">${filter==='occupee'?'Aucune chambre occupée.':filter==='reservee'?'Aucune chambre réservée.':'Aucune chambre occupée ou réservée.'}</p>`;
            return;
        }
        const ficheIco='<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="8" y1="13" x2="16" y2="13"/><line x1="8" y1="17" x2="13" y2="17"/></svg>';
        grid.innerHTML=list.map(r=>{
            let contenuN=0;
            try{const c=JSON.parse(localStorage.getItem('aj_ch_contenu')||'{}');contenuN=Array.isArray(c[r.num])?c[r.num].length:0;}catch(e){}
            return`
            <article class="cal-card st-${esc(r.status)}" data-num="${esc(r.num)}" aria-label="${esc(r.title)}">
                <div class="cal-img">
                    <img src="${esc(r.img||'')}" alt="${esc(r.title)}" loading="lazy" onerror="this.style.opacity=.35">
                </div>
                <span class="cal-badge">${STATUS[r.status]||r.status}</span>
                <span class="cal-num">N° ${esc(r.num)}</span>
                <button type="button" class="cal-fiche" data-num="${esc(r.num)}" title="Fiche contenu" aria-label="Fiche contenu chambre ${esc(r.num)}">${ficheIco}${contenuN?`<span class="ch-rc-file-n">${contenuN}</span>`:''}</button>
                <div class="cal-body">
                    <h3>${esc(r.title)}</h3>
                    <div class="cal-meta">
                        <div><span>Étage</span><b>${esc(floorLbl(r.floor))}</b></div>
                        <div><span>Catégorie</span><b>${esc(r.cat)}</b></div>
                        <div class="cal-price"><span>Tarif / nuitée</span><b>${money(r.tarif)} <small>/ nuit</small></b></div>
                    </div>
                    <div class="cal-dates">
                        <div><span>Occupation</span><b>${esc(frDate(r.occupation))}</b></div>
                        <div><span>Disponibilité</span><b>${esc(frDate(r.disponibilite))}</b></div>
                    </div>
                </div>
            </article>`;
        }).join('');
        grid.querySelectorAll('.cal-fiche').forEach(btn=>{
            btn.addEventListener('click',e=>{
                e.preventDefault();e.stopPropagation();
                window.CHETAT?.openRoomFiche?.(btn.dataset.num);
            });
        });
    }

    return{render};
})();
window.CALEND=CALEND;
window.AJ_RESA_SYNC?.syncFromServer();
</script>
</body>
</html>
