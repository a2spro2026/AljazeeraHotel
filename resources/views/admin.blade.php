<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Direction — Al Jazeera Hotel</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;0,700;1,500&family=Montserrat:wght@300;400;500;600&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        :root{
            --navy:#0a1736;--navy-deep:#060f24;--navy-mid:#0f2a5c;
            --gold:#c5a059;--gold-light:#d4b06a;--gold-pale:#f3e4a8;
            --cream:#f5f1e6;--muted:#6b7280;--text-dark:#1a2332;
            --surface:#f7f5f0;--white:#ffffff;--panel:var(--white);
            --sb-w:280px;--topbar-h:74px;--content-max:1280px;
            --border-gold:rgba(197,160,89,.18);
            --shadow-soft:0 4px 20px rgba(0,0,0,.06);
            --shadow-card:0 8px 32px rgba(197,160,89,.1);
        }
        *{margin:0;padding:0;box-sizing:border-box}
        html{scroll-behavior:smooth}
        body{font-family:'Montserrat',sans-serif;background:var(--surface);color:var(--text-dark)}
        a{text-decoration:none;color:inherit}
        .serif{font-family:'Cormorant Garamond',serif}
        .admin-wrap{display:flex;min-height:100vh}

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
            width:36px;height:36px;border-radius:50%;flex-shrink:0;
            background:linear-gradient(135deg,var(--gold),var(--gold-light));
            color:#1a1304;font-weight:700;font-size:14px;
            display:flex;align-items:center;justify-content:center;
            box-shadow:0 4px 12px rgba(197,160,89,.3);
        }
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

        /* MAIN */
        .main{flex:1;margin-left:var(--sb-w);display:flex;flex-direction:column;min-width:0;transition:margin-left .35s cubic-bezier(.4,0,.2,1);background:var(--surface)}
        .admin-wrap.sb-collapsed .main{margin-left:0}
        .topbar{
            display:flex;align-items:center;justify-content:space-between;gap:16px;
            padding:12px 28px;
            background:linear-gradient(180deg,rgba(255,255,255,.99) 0%,rgba(247,245,240,.96) 100%);
            backdrop-filter:blur(18px) saturate(1.4);
            border-bottom:1px solid transparent;
            box-shadow:0 4px 24px rgba(10,23,54,.05);
            position:sticky;top:0;z-index:30;
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
        .topbar .who span{font-size:11px;color:var(--gold);text-transform:uppercase;letter-spacing:1px}
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
        .content{padding:30px;flex:1;display:flex;flex-direction:column;align-items:center;background:var(--surface)}
        .panel{width:100%;max-width:var(--content-max);margin-left:auto;margin-right:auto}
        .panel#ch-etat{max-width:100%}
        .content.dash-view,.content.kpi-view,.content.ch-view{padding-top:150px}
        .content.ech-view{padding-top:12px}
        @media(max-width:1200px){
            .content.ch-view{padding-top:260px}
            .content.kpi-view{padding-top:150px}
            .content.ech-view{padding-top:12px}
        }
        @media(max-width:640px){
            .content.ch-view{padding-top:360px}
            .content.kpi-view{padding-top:260px}
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
            padding:18px 32px 20px;
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
        /* Aucune carte ne bascule au survol */
        .card,.card:hover,
        .section-kpi .card,.dash-kpi .card,
        .cd-card,.cd-card:hover,
        .ch-cat-card,.ch-cat-card:hover,
        .ch-etage-card,.ch-etage-card:hover,
        .rm-card,.rm-card:hover,
        .ech-kpi .ek-card,.ech-kpi .ek-card:hover{
            transform:none!important;translate:none!important;
        }

        /* KPI — cartes lumineuses */
        @keyframes kpiGlow{
            0%,100%{box-shadow:var(--shadow-soft),0 0 16px rgba(197,160,89,.06)}
            50%{box-shadow:0 8px 28px rgba(197,160,89,.12),0 0 24px rgba(197,160,89,.08)}
        }
        .dash-kpi .card{
            position:relative;overflow:hidden;
            padding:18px 16px 16px 18px;border-radius:14px;
            background:var(--white);
            border:1px solid var(--border-gold);
            box-shadow:var(--shadow-soft);
            transition:transform .35s cubic-bezier(.4,0,.2,1),box-shadow .35s ease,border-color .35s ease;
            min-height:100px;
            animation:kpiGlow 4s ease-in-out infinite;
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
        .dash-kpi .card .kpi-shine{
            position:absolute;inset:0;pointer-events:none;
            background:linear-gradient(105deg,transparent 35%,rgba(255,255,255,.4) 50%,transparent 65%);
            transform:translateX(-100%);transition:transform .7s ease;
        }
        .dash-kpi .card:hover .kpi-shine{transform:translateX(100%)}
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
        .table-wrap{overflow-x:auto;border-radius:12px;border:1px solid var(--border-gold);background:var(--white)}
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
        .rm-modal{
            position:relative;width:min(720px,100%);max-height:90vh;overflow-y:auto;
            background:linear-gradient(165deg,#fff,rgba(247,245,240,.98));
            border:1px solid rgba(197,160,89,.25);border-radius:16px;
            box-shadow:0 24px 64px rgba(0,0,0,.12),0 0 60px rgba(197,160,89,.08);
            padding:28px 28px 24px;animation:fade .3s ease;
        }
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
        .rm-form-grid .field.span2{grid-column:1/-1}
        .rm-form-grid .field input[readonly]{opacity:.75;cursor:default}
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
        .rm-status-pick h4{font-family:'Cormorant Garamond',serif;font-size:26px;color:#fff;margin:0 0 8px}
        .rm-status-pick .rm-status-sub{color:var(--muted);font-size:14px;margin:0 0 28px}
        .rm-status-btns{display:flex;gap:16px;justify-content:center;flex-wrap:wrap}
        .rm-st-btn{
            flex:1;min-width:150px;max-width:220px;padding:20px 22px;border-radius:12px;
            border:2px solid;cursor:pointer;font-family:'Montserrat',sans-serif;
            font-size:12px;font-weight:700;letter-spacing:1.4px;text-transform:uppercase;
            transition:all .25s ease;background:rgba(0,0,0,.25);
        }
        .rm-st-btn.st-occupee{color:#9ee8b8;border-color:rgba(69,200,120,.5);box-shadow:0 0 16px rgba(69,200,120,.15)}
        .rm-st-btn.st-occupee:hover{background:rgba(69,200,120,.18);box-shadow:0 0 28px rgba(69,200,120,.4);transform:translateY(-2px)}
        .rm-st-btn.st-reservee{color:#a8c8ff;border-color:rgba(91,158,245,.5);box-shadow:0 0 16px rgba(91,158,245,.15)}
        .rm-st-btn.st-reservee:hover{background:rgba(91,158,245,.18);box-shadow:0 0 28px rgba(91,158,245,.4);transform:translateY(-2px)}
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
        .cfg-auth-wrap{overflow-x:auto;margin-top:8px}
        .cfg-auth-table th,.cfg-auth-table td{text-align:center;vertical-align:middle}
        .cfg-auth-table th:first-child,.cfg-auth-table td:first-child{text-align:center;min-width:200px}
        .cfg-auth-table th .perm-hdr{display:flex;flex-direction:column;align-items:center;gap:4px;font-size:10px;line-height:1.2}
        .cfg-auth-table th .perm-ic{font-size:16px;line-height:1}
        .cfg-auth-table input[type=checkbox]{width:18px;height:18px;accent-color:var(--gold);cursor:pointer}
        .cfg-auth-table tr:hover td{background:rgba(201,162,39,.04)}

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

        /* ===== FRNS — cadres & tableaux pleine largeur ===== */
        .panel.frns-panel{max-width:min(100%,1480px);width:100%}
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
        .panel.frns-panel.frns-compact{max-width:min(100%,1480px)}
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
            overflow:hidden;background:rgba(0,0,0,.14);
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
            overflow:hidden;background:rgba(0,0,0,.14);
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
            flex:1 1 140px;max-width:220px;text-align:center;padding:12px 14px;border-radius:10px;
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
            position:relative;height:168px;overflow:hidden;flex-shrink:0;
            background:#0a1224;
        }
        .ch-dp-hero img{
            width:100%;height:100%;object-fit:cover;object-position:center;
            display:block;filter:saturate(1.05) brightness(.92);
        }
        .ch-dp-hero::after{
            content:'';position:absolute;inset:0;
            background:linear-gradient(180deg,rgba(10,18,36,.15) 0%,rgba(10,18,36,.35) 40%,rgba(18,24,42,.96) 100%);
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
            display:flex;flex-wrap:wrap;gap:10px;align-items:center;margin-bottom:14px;
            background:#fff;padding:12px 14px;border-radius:12px;
            box-shadow:0 1px 4px rgba(0,0,0,.05);
        }
        .ch-search-wrap{
            flex:1;min-width:200px;position:relative;display:flex;align-items:center;
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
            grid-template-columns:repeat(3,minmax(0,1fr));
            gap:14px;
            align-items:start;
            grid-auto-flow:dense;
            grid-auto-rows:210px;
        }
        @media(max-width:1400px){.ch-room-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}
        @media(max-width:1000px){.ch-room-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}
        @media(max-width:600px){.ch-room-grid{grid-template-columns:1fr}}
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
            will-change:auto;backface-visibility:hidden;
            height:210px;min-height:210px;max-height:210px;
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
            height:210px!important;min-height:210px!important;max-height:210px!important;
        }
        .ch-rc-img{position:relative;height:88px;aspect-ratio:auto;overflow:hidden;background:#e5e7eb;flex-shrink:0}
        .ch-rc-img img{
            width:100%;height:100%;object-fit:cover;object-position:center top;display:block;pointer-events:none;
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
            display:flex;flex-wrap:wrap;gap:10px;align-items:center;
            margin-bottom:16px;
        }
        .ch-etages-toolbar .ch-search-wrap{flex:1;min-width:220px}
        .ch-etages-toolbar .ch-select{min-width:160px}
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
            height:210px!important;min-height:210px!important;
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
    </style>
    @include('partials.data-center-styles')
</head>
<body>
<script>
(function(){
    var V='aj_reset_v3';
    if(localStorage.getItem('aj_data_version')!==V){
        ['aj_frns','aj_bons','aj_regls','aj_cfg_hotel','aj_cfg_users','aj_cfg_commerciaux','aj_cfg_auth','aj_ch_resa','aj_ch_status','aj_public_resa'].forEach(function(k){localStorage.removeItem(k);});
        for(var i=localStorage.length-1;i>=0;i--){
            var k=localStorage.key(i);
            var v=localStorage.getItem(k);
            if(v&&/khadija@gds\.com/i.test(v)){
                localStorage.setItem(k,v.replace(/khadija@gds\.com/gi,'Direction'));
            }
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
    $canManageRooms = in_array($adminLogin, $managerLogins, true);
    $adminLabel = 'Direction';
@endphp
<div class="admin-wrap">
    <aside class="sidebar" id="sidebar">
        <div class="sb-brand">
            <div class="sb-logo-wrap">
                <img src="{{ asset('images/logo.png') }}" alt="logo">
            </div>
            <div class="sb-brand-text">
                <span class="sb-est">Hotel &amp; Resort</span>
                <b>ALJAZEERA</b>
                <span class="sb-stars">&#9733; &#9733; &#9733; &#9733; &#9733;</span>
            </div>
        </div>
        <nav class="sb-nav" id="sbNav">
            <div class="sb-section-label">Pilotage</div>
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
            <div class="sb-item" data-target="ch-calendrier">
                <span class="ic-wrap"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M3 10h18M8 14h.01M12 14h.01M16 14h.01M8 18h.01M12 18h.01"/></svg></span>
                <span class="lbl">Calendrier</span>
            </div>

            <div class="sb-section-label">Hébergement</div>
            <div class="sb-group sb-group-flat">
                <div class="sb-item" data-target="ch-etat">
                    <span class="ic-wrap"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 4v16"/><path d="M2 8h18a2 2 0 012 2v10"/><path d="M2 17h20"/><path d="M6 8v9"/></svg></span>
                    <span class="lbl">Chambres</span>
                </div>
                <div class="sb-item" data-target="ch-categories">
                    <span class="ic-wrap"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 4h7v7H4zM13 4h7v7h-7zM4 13h7v7H4zM13 13h7v7h-7z"/></svg></span>
                    <span class="lbl">Catégories de chambres</span>
                </div>
                <div class="sb-item" data-target="ch-etages">
                    <span class="ic-wrap"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3l9 5v13H3V8l9-5z"/><path d="M9 21V12h6v9"/></svg></span>
                    <span class="lbl">Étages</span>
                </div>
                <div class="sb-item" data-target="ch-dispo">
                    <span class="ic-wrap"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg></span>
                    <span class="lbl">Disponibilités</span>
                </div>
            </div>

            <div class="sb-section-label">Achats &amp; Stock</div>
            <div class="sb-group">
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
            <div class="sb-group">
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

            <div class="sb-section-label">Facturation</div>
            <div class="sb-group">
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

            <div class="sb-section-label">Personnel</div>
            <div class="sb-group">
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

            <div class="sb-section-label">Finance</div>
            <div class="sb-group">
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

            <div class="sb-section-label">Système</div>
            <div class="sb-group">
                <div class="sb-parent" id="cfgParent">
                    <span class="ic-wrap"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="3"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg></span>
                    <span class="lbl">Configuration</span>
                    <span class="sb-badge">4</span>
                    <span class="caret">&#9662;</span>
                </div>
                <div class="sb-sub" id="cfgSub">
                    <div class="sb-item" data-target="configuration" data-cfg="hotel"><span class="sb-dot"></span><span class="lbl">Fiche hôtel</span></div>
                    <div class="sb-item" data-target="configuration" data-cfg="carrousel"><span class="sb-dot"></span><span class="lbl">Carrousel</span></div>
                    <div class="sb-item" data-target="configuration" data-cfg="users"><span class="sb-dot"></span><span class="lbl">Utilisateurs</span></div>
                    <div class="sb-item" data-target="configuration" data-cfg="commerciaux"><span class="sb-dot"></span><span class="lbl">Commerciaux</span></div>
                </div>
            </div>
        </nav>
        <div class="sb-foot">
            <div class="sb-profile">
                <div class="sb-profile-av">{{ strtoupper(substr($adminLabel, 0, 1)) }}</div>
                <div class="sb-profile-info">
                    <b>{{ $adminLabel }}</b>
                    <span>Administrateur</span>
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
                    <div class="top-logo-wrap">
                        <img src="{{ asset('images/logo.png') }}" alt="Al Jazeera Hotel">
                    </div>
                    <div class="topbar-brand-text">
                        <span class="top-est">Al Jazeera Hotel</span>
                        <h1 id="pageTitle">Tableau de bord</h1>
                    </div>
                </div>
            </div>
            <div class="who">
                <div style="text-align:right"><b>{{ $adminLabel }}</b><span>Général</span></div>
                @if(file_exists(public_path('images/profile.png')))
                    <img src="{{ asset('images/profile.png') }}" alt="profil">
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
                <div class="card"><div class="n">28</div><div class="l">Réservations actives</div></div>
                <div class="card"><div class="n">6</div><div class="l">Arrivées aujourd'hui</div></div>
                <div class="card"><div class="n">4</div><div class="l">Départs aujourd'hui</div></div>
                <div class="card"><div class="n">3</div><div class="l">En attente</div></div>
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
                            <div class="field ff-f-date"><label>Date Création</label><input type="date" id="ff_date"></div>
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
                            <div class="field ba-f-date"><label>Date</label><input type="date" id="ba_date"></div>
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
                                        <td><span class="ba-total-val" id="ba_total">0,00 DH</span></td>
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
                            <div class="field ra-f-date"><label>Date</label><input type="date" id="ra_date"></div>
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
                            <div class="field ra-f-decaiss"><label>Échéance</label><input type="date" id="ra_decaiss"></div>
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
                            <div class="field bl-f-date"><label>Date</label><input type="date" id="bl_search_date" oninput="FRNS.renderBalance()"></div>
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
                            <div class="field sm-f-date"><label>Date achat</label><input type="date" id="sm_date" readonly></div>
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
                            <div class="field ep-f-date"><label>Date</label><input type="date" id="ep_date"></div>
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
                    <div class="row-head"><h3>Liste des réservations</h3><button class="btn-gold">+ Nouvelle réservation</button></div>
                    <table>
                        <thead><tr><th>N° Résa</th><th>Client</th><th>Chambre</th><th>Arrivée</th><th>Départ</th><th>Nuits</th><th>Montant</th><th>Statut</th></tr></thead>
                        <tbody>
                            <tr class="empty-row"><td colspan="6">Aucune donnée.</td></tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="panel" id="ch-calendrier">
                <h2 class="serif">Calendrier</h2>
                <p class="sub">Vue calendrier des réservations et disponibilités</p>
                <div class="block"><p class="hint">Calendrier des arrivées, départs et occupation — à venir.</p></div>
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
                                <option value="suite">Suites</option>
                                <option value="familiale">Familiales</option>
                                <option value="single">Singles</option>
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
                            <p>Sélectionnez un étage puis une chambre, ou cliquez une carte.</p>
                        </div>
                    </div>
                </aside>
            </section>

            <section class="panel" id="ch-categories">
                <h2 class="serif">Catégories de chambres</h2>
                <p class="sub">Suites, Familiales et Singles — répartition du parc</p>
                <div id="chCategoriesGrid" class="ch-cat-grid"></div>
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
                <h2 class="serif">Disponibilités</h2>
                <p class="sub">Catalogue public — photos, titres et descriptions affichés sur le site</p>
                <div id="cdSections"></div>
            </section>

            {{-- PERSONNELS --}}
            <section class="panel" id="pers-fiche">
                <h2 class="serif">Fiche Personnel</h2>
                <p class="sub">Gestion des employés de l'hôtel</p>
                <div class="block">
                    <div class="row-head"><h3>Liste du personnel</h3><button class="btn-gold">+ Ajouter</button></div>
                    <table>
                        <thead><tr><th>Nom</th><th>Poste</th><th>Service</th><th>Téléphone</th><th>Statut</th></tr></thead>
                        <tbody>
                            <tr class="empty-row"><td colspan="6">Aucune donnée.</td></tr>
                        </tbody>
                    </table>
                </div>
            </section>

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
                            <div class="field"><label>N° Contact</label><input type="tel" id="cfg_contact" placeholder="06 XX XX XX XX"></div>
                            <div class="field"><label>N° Fixe</label><input type="tel" id="cfg_fixe" placeholder="05 XX XX XX XX"></div>
                            <div class="field"><label>E-mail</label><input type="email" id="cfg_email" placeholder="contact@hotel.com"></div>
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
                    <div class="block">
                        <h3>Utilisateur</h3>
                        <div class="form-flex">
                            <div class="field cfg-id-field" style="flex:0 0 100px"><label>ID</label><input type="text" id="cu_id" readonly></div>
                            <div class="field" style="flex:2 1 200px"><label>Nom et Prénom</label><input type="text" id="cu_nom" placeholder="Nom complet"></div>
                            <div class="field" style="flex:1 1 140px"><label>N° CIN</label><input type="text" id="cu_cin" placeholder="AB123456"></div>
                            <div class="field" style="flex:1 1 140px"><label>N° Téléphone</label><input type="tel" id="cu_tel" placeholder="06 XX XX XX XX"></div>
                            <div class="field" style="flex:2 1 220px"><label>Adresse</label><input type="text" id="cu_adresse" placeholder="Adresse"></div>
                            <div class="field" style="flex:1 1 150px"><label>Profil</label>
                                <select id="cu_profil">
                                    <option>Direction</option><option>Réception</option><option>Comptabilité</option>
                                    <option>Commercial</option><option>Maintenance</option><option>Restauration</option>
                                </select>
                            </div>
                            <div class="field" style="flex:1 1 150px"><label>Type Contrat</label>
                                <select id="cu_contrat">
                                    <option>CDI</option><option>CDD</option><option>Stage</option><option>Formation</option><option>Vacataire</option>
                                </select>
                            </div>
                            <div class="field" style="flex:0 0 140px"><label>Date Début</label><input type="date" id="cu_debut"></div>
                            <div class="field" style="flex:0 0 140px"><label>Date Fin</label><input type="date" id="cu_fin"></div>
                            <div class="field" style="flex:1 1 180px"><label>Formation</label><input type="text" id="cu_formation" placeholder="Formation / diplôme"></div>
                            <div class="field" style="flex:0 0 120px"><label>Salaire (DH)</label><input type="number" id="cu_salaire" placeholder="0" step="0.01" min="0"></div>
                        </div>
                        <div class="actions">
                            <button type="button" class="btn gold" onclick="CFG.saveUser()">Valider</button>
                            <button type="button" class="btn ghost" onclick="CFG.newUser()">Ajouter</button>
                        </div>
                    </div>
                    <div class="block">
                        <div class="cfg-list-head"><h3>Liste des utilisateurs</h3></div>
                        <div class="table-wrap">
                            <table>
                                <thead><tr>
                                    <th>ID</th><th>Nom et Prénom</th><th>CIN</th><th>Téléphone</th><th>Profil</th><th>Contrat</th><th>Salaire</th><th class="no-print">Actions</th>
                                </tr></thead>
                                <tbody id="cu_tbody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="subpanel" id="cfg-auth">
                    <div class="block">
                        <h3>Tableau des autorisations</h3>
                        <p class="hint">Cochez les droits accordés pour chaque module du menu latéral.</p>
                        <div class="cfg-auth-wrap">
                            <table class="cfg-auth-table" id="cfg_auth_table">
                                <thead>
                                    <tr>
                                        <th>Module / Menu</th>
                                        <th><span class="perm-hdr"><span class="perm-ic">&#9998;</span>Saisir</span></th>
                                        <th><span class="perm-hdr"><span class="perm-ic">&#128394;</span>Modifier</span></th>
                                        <th><span class="perm-hdr"><span class="perm-ic">&#128465;</span>Supprimer</span></th>
                                        <th><span class="perm-hdr"><span class="perm-ic">&#128424;</span>Imprimer</span></th>
                                        <th><span class="perm-hdr"><span class="perm-ic">&#128065;</span>Voir</span></th>
                                    </tr>
                                </thead>
                                <tbody id="cfg_auth_tbody"></tbody>
                            </table>
                        </div>
                        <div class="actions" style="margin-top:16px">
                            <button type="button" class="btn gold" onclick="CFG.saveAuth()">Enregistrer les autorisations</button>
                        </div>
                    </div>
                </div>

                <div class="subpanel" id="cfg-commerciaux">
                    <div class="block">
                        <h3>Commercial</h3>
                        <div class="form-flex">
                            <div class="field cfg-id-field" style="flex:0 0 100px"><label>ID</label><input type="text" id="cc_id" readonly></div>
                            <div class="field" style="flex:2 1 200px"><label>Nom et Prénom</label><input type="text" id="cc_nom" placeholder="Nom complet"></div>
                            <div class="field" style="flex:1 1 140px"><label>N° CIN</label><input type="text" id="cc_cin" placeholder="AB123456"></div>
                            <div class="field" style="flex:1 1 140px"><label>N° Téléphone</label><input type="tel" id="cc_tel" placeholder="06 XX XX XX XX"></div>
                            <div class="field" style="flex:2 1 220px"><label>Adresse</label><input type="text" id="cc_adresse" placeholder="Adresse"></div>
                            <div class="field" style="flex:1 1 150px"><label>Profil</label>
                                <select id="cc_profil">
                                    <option>Commercial junior</option><option>Commercial senior</option><option>Responsable commercial</option>
                                </select>
                            </div>
                            <div class="field" style="flex:1 1 150px"><label>Type Contrat</label>
                                <select id="cc_contrat">
                                    <option>CDI</option><option>CDD</option><option>Stage</option><option>Formation</option><option>Vacataire</option>
                                </select>
                            </div>
                            <div class="field" style="flex:0 0 140px"><label>Date Début</label><input type="date" id="cc_debut"></div>
                            <div class="field" style="flex:0 0 140px"><label>Date Fin</label><input type="date" id="cc_fin"></div>
                            <div class="field" style="flex:1 1 180px"><label>Formation</label><input type="text" id="cc_formation" placeholder="Formation / diplôme"></div>
                            <div class="field" style="flex:0 0 120px"><label>Salaire (DH)</label><input type="number" id="cc_salaire" placeholder="0" step="0.01" min="0"></div>
                        </div>
                        <div class="actions">
                            <button type="button" class="btn gold" onclick="CFG.saveCommercial()">Valider</button>
                            <button type="button" class="btn ghost" onclick="CFG.newCommercial()">Ajouter</button>
                        </div>
                    </div>
                    <div class="block">
                        <div class="cfg-list-head"><h3>Liste des commerciaux</h3></div>
                        <div class="table-wrap">
                            <table>
                                <thead><tr>
                                    <th>ID</th><th>Nom et Prénom</th><th>CIN</th><th>Téléphone</th><th>Profil</th><th>Contrat</th><th>Salaire</th><th class="no-print">Actions</th>
                                </tr></thead>
                                <tbody id="cc_tbody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

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

<div class="bl-modal-overlay" id="blDetailOverlay">
    <div class="bl-modal">
        <button type="button" class="bl-modal-close" onclick="FRNS.closeBalanceDetail()" aria-label="Fermer">&times;</button>
        <div id="blDetailContent"></div>
    </div>
</div>

<script>
    const items=document.querySelectorAll('.sb-item');
    const panels=document.querySelectorAll('.panel');
    const title=document.getElementById('pageTitle');
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
        title.textContent=label||(match?(match.querySelector('.lbl')||match).textContent.trim():'');
        if(dashKpiBar)dashKpiBar.classList.toggle('hidden',targetId!=='dashboard');
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
            contentEl.classList.toggle('dash-view',targetId==='dashboard');
            contentEl.classList.toggle('ech-view',false);
            contentEl.classList.toggle('ch-view',targetId==='ch-etat');
            contentEl.classList.toggle('kpi-view',sectionKpiShown);
        }
        const pageLabels={
            'ch-etat':'Chambres',
            'ch-categories':'Catégories de chambres',
            'ch-etages':'Étages',
            'ch-dispo':'Disponibilités',
            'ch-reservations':'Réservations',
            'ch-calendrier':'Calendrier'
        };
        if(pageLabels[targetId])title.textContent=pageLabels[targetId];
        if(typeof FRNS!=='undefined'){
            if(targetId==='dashboard')FRNS.renderDashboard();
            if(targetId==='bon'||targetId==='regl')FRNS.renderSelects();
            if(targetId==='regl')FRNS.renderReglBalances();
            if(targetId==='balance')FRNS.renderBalance();
        }
        if(targetId==='stock-mouvement'&&typeof STOCK!=='undefined')STOCK.syncFromBons();
        if(targetId==='stock-etat'&&typeof ETAT!=='undefined')ETAT.render();
        if(targetId==='ch-etat'&&typeof CHETAT!=='undefined')CHETAT.render();
        if(targetId==='ch-categories'&&typeof CHETAT!=='undefined')CHETAT.renderCategories();
        if(targetId==='ch-etages'&&typeof CHETAT!=='undefined')CHETAT.renderEtages();
        if(targetId==='ch-dispo'&&typeof CHDISPO!=='undefined')CHDISPO.render();
        if(targetId==='configuration'&&typeof CFG!=='undefined'){
            CFG.render();
            CFG.switchTab(cfgTab||'hotel');
        }
        sidebar.classList.remove('open');overlay.classList.remove('show');
        window.scrollTo({top:0,behavior:'smooth'});
    }
    items.forEach(it=>it.addEventListener('click',()=>{
        const lbl=(it.querySelector('.lbl')||it).textContent.trim();
        activatePanel(it.dataset.target,lbl,it.dataset.cfg||null);
    }));
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
    if(adminWrap&&window.innerWidth>900){
        try{if(localStorage.getItem('aj_sb_collapsed')==='1')setSidebarCollapsed(true);}catch(e){}
    }
    window.addEventListener('resize',()=>{
        if(window.innerWidth<=900)adminWrap?.classList.remove('sb-collapsed');
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
    const fmt=v=>num(v).toLocaleString('fr-FR',{minimumFractionDigits:2,maximumFractionDigits:2})+' DH';
    const fmtKpi=v=>{
        const n=num(v).toFixed(2).split('.');
        n[0]=n[0].replace(/\B(?=(\d{3})+(?!\d))/g,' ');
        return n.join('.');
    };
    const esc=s=>(s==null?'':String(s)).replace(/[&<>"]/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c]));
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
            date:document.getElementById('ff_date').value,
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
        document.getElementById('ff_date').value=f.date||'';
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
            date:document.getElementById('ba_date').value,
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
        if(document.getElementById('ba_date'))document.getElementById('ba_date').value=today;
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
        document.getElementById('ba_date').value=b.date||'';
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
        const date=document.getElementById('ra_date').value,
              type=document.getElementById('ra_type').value, num_=document.getElementById('ra_num').value.trim(),
              banq=document.getElementById('ra_banq').value.trim(), tire=document.getElementById('ra_tire').value.trim(),
              decaiss=document.getElementById('ra_decaiss').value;
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
        const dateQ=document.getElementById('bl_search_date')?.value||'';
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
            date:document.getElementById('ba_date').value,
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
    const esc=s=>(s==null?'':String(s)).replace(/[&<>"]/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c]));
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
        document.getElementById('sm_date').value=row.dateAchat||'';
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
    const esc=s=>(s==null?'':String(s)).replace(/[&<>"]/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c]));
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
        if(document.getElementById('ep_date'))document.getElementById('ep_date').value=today;
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
            date:document.getElementById('ep_date').value,
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
        document.getElementById('ep_date').value=row.date||'';
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
<script src="{{ asset('js/hotel-content.js') }}"></script>
<script>
/* ===== Module Configuration ===== */
const CFG=(function(){
    const K_HOTEL='aj_cfg_hotel';
    const K_USERS='aj_cfg_users';
    const K_COMM='aj_cfg_commerciaux';
    const K_AUTH='aj_cfg_auth';
    let carTab='suite';
    const PERMS=['saisir','modifier','supprimer','imprimer','voir'];
    const MENUS=[
        {id:'dashboard',label:'Tableau de bord',section:'Pilotage'},
        {id:'fiche',label:'Fiche fournisseur',section:'Achats & Stock'},
        {id:'bon',label:'Bon Achats',section:'Achats & Stock'},
        {id:'regl',label:'Règlement Achats',section:'Achats & Stock'},
        {id:'balance',label:'Balance',section:'Achats & Stock'},
        {id:'stock-mouvement',label:'Mouvement Stock',section:'Achats & Stock'},
        {id:'stock-etat',label:'Etat Produit',section:'Achats & Stock'},
        {id:'stock-fiscal',label:'Stock Fiscal',section:'Achats & Stock'},
        {id:'fact-frns',label:'Facture Fournisseur',section:'Facturation'},
        {id:'regl-frns',label:'Règl Fournisseur',section:'Facturation'},
        {id:'releve-frns',label:'Relevé Compte Frns',section:'Facturation'},
        {id:'fact-clt',label:'Facture client',section:'Facturation'},
        {id:'regl-clt',label:'Règl Client',section:'Facturation'},
        {id:'releve-clt',label:'Relevé Compte Clt',section:'Facturation'},
        {id:'ch-etat',label:'Chambres',section:'Hébergement'},
        {id:'ch-categories',label:'Catégories de chambres',section:'Hébergement'},
        {id:'ch-etages',label:'Étages',section:'Hébergement'},
        {id:'ch-dispo',label:'Disponibilités',section:'Hébergement'},
        {id:'ch-calendrier',label:'Calendrier',section:'Pilotage'},
        {id:'pers-fiche',label:'Fiche Personnel',section:'Exploitation'},
        {id:'pers-taches',label:'Gestion des Taches',section:'Exploitation'},
        {id:'pers-suivi',label:'Suivi Journalier',section:'Exploitation'},
        {id:'pers-paiement',label:'Etat Paiement',section:'Exploitation'},
        {id:'mon-caisse',label:'Caisse',section:'Finance'},
        {id:'mon-tresorerie',label:'Trésorerie',section:'Finance'},
        {id:'mon-salaires',label:'Salaires',section:'Finance'},
        {id:'mon-charges',label:'Charges',section:'Finance'},
        {id:'configuration',label:'Configuration',section:'Système'}
    ];
    let editUserId=null,editCommId=null;

    const esc=s=>String(s??'').replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
    const load=k=>{try{return JSON.parse(localStorage.getItem(k)||'null');}catch(e){return null;}};
    const save=(k,v)=>localStorage.setItem(k,JSON.stringify(v));
    const fmtSal=v=>Number(v||0).toLocaleString('fr-FR',{minimumFractionDigits:2,maximumFractionDigits:2});

    function nextId(list,prefix){
        let max=0;
        list.forEach(x=>{
            const m=String(x.id||'').match(new RegExp('^'+prefix+'(\\d+)$','i'));
            if(m)max=Math.max(max,parseInt(m[1],10));
        });
        return prefix+String(max+1).padStart(4,'0');
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
    }

    function loadHotelForm(){
        const h=load(K_HOTEL)||{
            raison:'Al Jazeera Hotel',gerant:'',contact:'',fixe:'',email:'contact@aljazeerahotel.com',statut:'5'
        };
        document.getElementById('cfg_raison').value=h.raison||'';
        document.getElementById('cfg_gerant').value=h.gerant||'';
        document.getElementById('cfg_contact').value=h.contact||'';
        document.getElementById('cfg_fixe').value=h.fixe||'';
        document.getElementById('cfg_email').value=h.email||'';
        document.getElementById('cfg_statut').value=h.statut||'5';
    }

    function saveHotel(){
        save(K_HOTEL,{
            raison:document.getElementById('cfg_raison').value.trim(),
            gerant:document.getElementById('cfg_gerant').value.trim(),
            contact:document.getElementById('cfg_contact').value.trim(),
            fixe:document.getElementById('cfg_fixe').value.trim(),
            email:document.getElementById('cfg_email').value.trim(),
            statut:document.getElementById('cfg_statut').value
        });
        alert('Fiche hôtel enregistrée.');
    }

    function readUserForm(){
        return{
            id:document.getElementById('cu_id').value.trim(),
            nom:document.getElementById('cu_nom').value.trim(),
            cin:document.getElementById('cu_cin').value.trim(),
            tel:document.getElementById('cu_tel').value.trim(),
            adresse:document.getElementById('cu_adresse').value.trim(),
            profil:document.getElementById('cu_profil').value,
            contrat:document.getElementById('cu_contrat').value,
            debut:document.getElementById('cu_debut').value,
            fin:document.getElementById('cu_fin').value,
            formation:document.getElementById('cu_formation').value.trim(),
            salaire:document.getElementById('cu_salaire').value
        };
    }

    function fillUserForm(u){
        document.getElementById('cu_id').value=u?.id||'';
        document.getElementById('cu_nom').value=u?.nom||'';
        document.getElementById('cu_cin').value=u?.cin||'';
        document.getElementById('cu_tel').value=u?.tel||'';
        document.getElementById('cu_adresse').value=u?.adresse||'';
        document.getElementById('cu_profil').value=u?.profil||'Direction';
        document.getElementById('cu_contrat').value=u?.contrat||'CDI';
        document.getElementById('cu_debut').value=u?.debut||'';
        document.getElementById('cu_fin').value=u?.fin||'';
        document.getElementById('cu_formation').value=u?.formation||'';
        document.getElementById('cu_salaire').value=u?.salaire||'';
    }

    function renderUsers(){
        const list=load(K_USERS)||[];
        const tb=document.getElementById('cu_tbody');
        if(!list.length){tb.innerHTML='<tr class="empty-row"><td colspan="8">Aucun utilisateur enregistré</td></tr>';return;}
        tb.innerHTML=list.map(u=>`<tr>
            <td>${esc(u.id)}</td><td>${esc(u.nom)}</td><td>${esc(u.cin)}</td><td>${esc(u.tel)}</td>
            <td>${esc(u.profil)}</td><td>${esc(u.contrat)}</td><td>${fmtSal(u.salaire)}</td>
            <td class="no-print">
                <button class="ibtn" title="Modifier" onclick="CFG.editUser('${u.id}')">&#9998;</button>
                <button class="ibtn del" title="Supprimer" onclick="CFG.delUser('${u.id}')">&#128465;</button>
            </td>
        </tr>`).join('');
    }

    function newUser(){
        editUserId=null;
        const list=load(K_USERS)||[];
        fillUserForm({id:nextId(list,'Ut')});
    }

    function saveUser(){
        const data=readUserForm();
        if(!data.nom){alert('Le nom est obligatoire.');return;}
        let list=load(K_USERS)||[];
        if(editUserId){
            const i=list.findIndex(x=>x.id===editUserId);
            if(i>=0)list[i]={...data,id:editUserId};
        }else{
            if(!data.id)data.id=nextId(list,'Ut');
            if(list.some(x=>x.id===data.id)){alert('Cet ID existe déjà.');return;}
            list.push(data);
        }
        save(K_USERS,list);
        editUserId=null;
        newUser();
        renderUsers();
        alert('Utilisateur enregistré.');
    }

    function editUser(id){
        const u=(load(K_USERS)||[]).find(x=>x.id===id);
        if(!u)return;
        editUserId=id;
        fillUserForm(u);
    }

    function delUser(id){
        if(!confirm('Supprimer cet utilisateur ?'))return;
        save(K_USERS,(load(K_USERS)||[]).filter(x=>x.id!==id));
        if(editUserId===id)newUser();
        renderUsers();
    }

    function readCommForm(){
        return{
            id:document.getElementById('cc_id').value.trim(),
            nom:document.getElementById('cc_nom').value.trim(),
            cin:document.getElementById('cc_cin').value.trim(),
            tel:document.getElementById('cc_tel').value.trim(),
            adresse:document.getElementById('cc_adresse').value.trim(),
            profil:document.getElementById('cc_profil').value,
            contrat:document.getElementById('cc_contrat').value,
            debut:document.getElementById('cc_debut').value,
            fin:document.getElementById('cc_fin').value,
            formation:document.getElementById('cc_formation').value.trim(),
            salaire:document.getElementById('cc_salaire').value
        };
    }

    function fillCommForm(u){
        document.getElementById('cc_id').value=u?.id||'';
        document.getElementById('cc_nom').value=u?.nom||'';
        document.getElementById('cc_cin').value=u?.cin||'';
        document.getElementById('cc_tel').value=u?.tel||'';
        document.getElementById('cc_adresse').value=u?.adresse||'';
        document.getElementById('cc_profil').value=u?.profil||'Commercial junior';
        document.getElementById('cc_contrat').value=u?.contrat||'CDI';
        document.getElementById('cc_debut').value=u?.debut||'';
        document.getElementById('cc_fin').value=u?.fin||'';
        document.getElementById('cc_formation').value=u?.formation||'';
        document.getElementById('cc_salaire').value=u?.salaire||'';
    }

    function renderCommerciaux(){
        const list=load(K_COMM)||[];
        const tb=document.getElementById('cc_tbody');
        if(!list.length){tb.innerHTML='<tr class="empty-row"><td colspan="8">Aucun commercial enregistré</td></tr>';return;}
        tb.innerHTML=list.map(u=>`<tr>
            <td>${esc(u.id)}</td><td>${esc(u.nom)}</td><td>${esc(u.cin)}</td><td>${esc(u.tel)}</td>
            <td>${esc(u.profil)}</td><td>${esc(u.contrat)}</td><td>${fmtSal(u.salaire)}</td>
            <td class="no-print">
                <button class="ibtn" title="Modifier" onclick="CFG.editCommercial('${u.id}')">&#9998;</button>
                <button class="ibtn del" title="Supprimer" onclick="CFG.delCommercial('${u.id}')">&#128465;</button>
            </td>
        </tr>`).join('');
    }

    function newCommercial(){
        editCommId=null;
        const list=load(K_COMM)||[];
        fillCommForm({id:nextId(list,'Co')});
    }

    function saveCommercial(){
        const data=readCommForm();
        if(!data.nom){alert('Le nom est obligatoire.');return;}
        let list=load(K_COMM)||[];
        if(editCommId){
            const i=list.findIndex(x=>x.id===editCommId);
            if(i>=0)list[i]={...data,id:editCommId};
        }else{
            if(!data.id)data.id=nextId(list,'Co');
            if(list.some(x=>x.id===data.id)){alert('Cet ID existe déjà.');return;}
            list.push(data);
        }
        save(K_COMM,list);
        editCommId=null;
        newCommercial();
        renderCommerciaux();
        alert('Commercial enregistré.');
    }

    function editCommercial(id){
        const u=(load(K_COMM)||[]).find(x=>x.id===id);
        if(!u)return;
        editCommId=id;
        fillCommForm(u);
    }

    function delCommercial(id){
        if(!confirm('Supprimer ce commercial ?'))return;
        save(K_COMM,(load(K_COMM)||[]).filter(x=>x.id!==id));
        if(editCommId===id)newCommercial();
        renderCommerciaux();
    }

    function getAuth(){
        const stored=load(K_AUTH)||{};
        const out={};
        MENUS.forEach(m=>{
            out[m.id]=stored[m.id]||{saisir:false,modifier:false,supprimer:false,imprimer:false,voir:true};
        });
        return out;
    }

    function renderAuth(){
        const auth=getAuth();
        let lastSection='';
        const rows=MENUS.map(m=>{
            let sectionRow='';
            if(m.section!==lastSection){
                lastSection=m.section;
                sectionRow=`<tr><td colspan="6" style="background:rgba(201,162,39,.08);color:var(--gold);font-weight:600;font-size:11px;letter-spacing:1px;text-transform:uppercase;text-align:left">${esc(m.section)}</td></tr>`;
            }
            const p=auth[m.id];
            const cells=PERMS.map(k=>`<td><input type="checkbox" data-menu="${m.id}" data-perm="${k}" ${p[k]?'checked':''}></td>`).join('');
            return sectionRow+`<tr><td style="text-align:left">${esc(m.label)}</td>${cells}</tr>`;
        }).join('');
        document.getElementById('cfg_auth_tbody').innerHTML=rows;
    }

    function saveAuth(){
        const auth={};
        MENUS.forEach(m=>{
            auth[m.id]={};
            PERMS.forEach(k=>{
                const cb=document.querySelector(`#cfg_auth_tbody input[data-menu="${m.id}"][data-perm="${k}"]`);
                auth[m.id][k]=cb?cb.checked:false;
            });
        });
        save(K_AUTH,auth);
        alert('Autorisations enregistrées.');
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
        if(!editUserId)newUser();
        if(!editCommId)newCommercial();
        renderUsers();
        renderCommerciaux();
        renderAuth();
        renderCarousel();
    }

    function init(){
        loadHotelForm();
        newUser();
        newCommercial();
        renderUsers();
        renderCommerciaux();
        renderAuth();
    }

    return{
        init,render,switchTab,
        saveHotel,
        saveUser,newUser,editUser,delUser,
        saveCommercial,newCommercial,editCommercial,delCommercial,
        saveAuth,
        renderCarousel,saveCarousel,addCarouselSlide
    };
})();
window.CFG=CFG;
CFG.init();
</script>

<script>
/* ===== Module Chambres Disponibles ===== */
const CHDISPO=(function(){
    const TYPE_LBL={suite:'Suite',familiale:'Familiale',single:'Single'};
    const SECTIONS=window.AJ_HOTEL?window.AJ_HOTEL.getCategories():[];
    let bound=false;
    const esc=s=>(s==null?'':String(s)).replace(/[&<>"]/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c]));
    const fmtP=n=>Number(n).toLocaleString('fr-FR')+' DH';

    function cardHtml(r){
        return`<article class="cd-card" data-num="${r.num}">
            <div class="cd-card-img"><img src="${esc(r.img)}" alt="${esc(r.title)}" loading="lazy"><span class="cd-num">Ch. ${r.num}</span></div>
            <div class="cd-card-body">
                <span class="rm-type" style="font-size:9px">${TYPE_LBL[r.type]||r.type} · Étage ${r.floor||'—'}</span>
                <h4>${esc(r.title)}</h4>
                <p>${esc(r.desc)}</p>
                <div class="cd-card-foot"><span class="cd-price">${fmtP(r.price)}</span><button type="button" class="cd-edit-btn" title="Modifier">&#9998;</button></div>
            </div>
        </article>`;
    }

    function openModal(){document.getElementById('rmModalOverlay')?.classList.add('show');}
    function closeModal(){document.getElementById('rmModalOverlay')?.classList.remove('show');}

    function showEdit(room){
        const box=document.getElementById('rmModalContent');
        if(!box)return;
        box.innerHTML=`<div class="rm-form-head"><h3>Chambre ${esc(room.num)} — Site public</h3><p>Photo, titre, descriptions et prix affichés sur la page Chambres</p></div>
        <form class="rm-form-grid" id="cdForm" onsubmit="return false">
            <div class="field span2"><label>Aperçu photo</label><div class="rm-edit-preview"><img id="cd_preview" src="${esc(room.img)}" alt=""></div></div>
            <div class="field span2"><label>URL de la photo</label><input type="text" id="cd_img" value="${esc(room.img)}"></div>
            <div class="field span2"><label>Importer une image</label><input type="file" id="cd_img_file" accept="image/*"></div>
            <div class="field span2"><label>Titre</label><input type="text" id="cd_title" value="${esc(room.title)}"></div>
            <div class="field span2"><label>Description courte</label><textarea id="cd_desc" rows="2">${esc(room.desc)}</textarea></div>
            <div class="field span2"><label>Description longue</label><textarea id="cd_long" rows="4">${esc(room.longDesc||room.desc)}</textarea></div>
            <div class="field"><label>Prix / nuit (DH)</label><input type="number" id="cd_price" min="0" step="1" value="${room.price}"></div>
        </form>
        <div class="rm-form-actions">
            <button type="button" class="btn gold" id="cdSave">Enregistrer</button>
            <button type="button" class="btn ghost" id="cdCancel">Annuler</button>
        </div>`;
        const preview=document.getElementById('cd_preview');
        const imgInput=document.getElementById('cd_img');
        imgInput?.addEventListener('input',()=>{if(preview&&imgInput.value.trim())preview.src=imgInput.value.trim();});
        document.getElementById('cd_img_file')?.addEventListener('change',e=>{
            const file=e.target.files?.[0];
            if(!file)return;
            const reader=new FileReader();
            reader.onload=()=>{if(imgInput)imgInput.value=reader.result;if(preview)preview.src=reader.result;};
            reader.readAsDataURL(file);
        });
        document.getElementById('cdSave')?.addEventListener('click',()=>{
            const title=document.getElementById('cd_title')?.value.trim();
            const desc=document.getElementById('cd_desc')?.value.trim();
            const longDesc=document.getElementById('cd_long')?.value.trim();
            const price=Number(document.getElementById('cd_price')?.value)||0;
            const img=document.getElementById('cd_img')?.value.trim();
            if(!title){alert('Le titre est obligatoire.');return;}
            const data={title,desc,longDesc:longDesc||desc,price,img:img||room.img};
            if(window.AJ_HOTEL)window.AJ_HOTEL.saveRoom(room.num,data);
            closeModal();
            render();
            alert('Chambre mise à jour — visible sur le site public.');
        });
        document.getElementById('cdCancel')?.addEventListener('click',closeModal);
        openModal();
    }

    function render(){
        const box=document.getElementById('cdSections');
        if(!box||!window.AJ_HOTEL)return;
        const rooms=window.AJ_HOTEL.getCatalog();
        box.innerHTML=SECTIONS.map(s=>{
            const list=rooms.filter(r=>r.type===s.key);
            return`<div class="cd-section"><div class="cd-section-head"><h3>${esc(s.title)}</h3><span class="ech-count">${list.length} chambres</span></div><div class="cd-grid">${list.map(cardHtml).join('')}</div></div>`;
        }).join('');
        if(!bound){
            box.addEventListener('click',e=>{
                const btn=e.target.closest('.cd-edit-btn');
                if(!btn)return;
                const card=btn.closest('.cd-card');
                const room=window.AJ_HOTEL.getRoom(card?.dataset.num);
                if(room)showEdit(room);
            });
            bound=true;
        }
    }
    return{render};
})();
window.CHDISPO=CHDISPO;
</script>

<script>
window.ADMIN_CAN_MANAGE_ROOMS={{ $canManageRooms ? 'true' : 'false' }};
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
    const TYPE_LBL={suite:'Suite',familiale:'Familiale',single:'Single'};
    const CAT_LBL={suite:'Suite',familiale:'Chambre Familiale',single:'Chambre Single'};
    const CAT_TITLE={suite:'Suites',familiale:'Chambres Familiales',single:'Chambres Singles'};
    const ROOM_META={
        suite:{guests:3,size:'45 m²',view:'Vue panoramique',bed:'Lit King Size'},
        familiale:{guests:4,size:'38 m²',view:'Vue jardin',bed:'2 lits doubles'},
        single:{guests:2,size:'28 m²',view:'Vue ville',bed:'Lit Queen'}
    };
    const STAT_ICO={total:'&#128719;',disponible:'&#10003;',occupee:'&#128100;',reservee:'&#128467;',nettoyage:'&#128736;',maintenance:'&#9881;'};
    const TVA_RATE=.10;
    const K_RESA='aj_ch_resa';
    const K_STATUS='aj_ch_status';
    let ROOMS=[],currentFilter={q:'',floor:'',cat:'',status:''},viewMode='grid',selectedNum=null,bound=false,currentRoom=null;

    const esc=s=>(s==null?'':String(s)).replace(/[&<>"]/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c]));
    const fmtP=n=>Number(n).toLocaleString('fr-FR')+' DH';
    const num=v=>Number(v)||0;
    const fmtAmt=v=>num(v).toLocaleString('fr-FR',{minimumFractionDigits:2,maximumFractionDigits:2});
    const today=()=>new Date().toISOString().slice(0,10);
    const pct=(n,t)=>t?((n/t)*100).toFixed(1)+'%':'0%';
    const floorLbl=f=>f===1?'1er étage':f+'e étage';

    function loadCatalogRooms(){
        const base=window.AJ_HOTEL?window.AJ_HOTEL.getCatalog():[];
        return base.map(r=>({...r,status:r.status||'disponible',longDesc:r.longDesc||r.desc}));
    }
    const getResas=()=>JSON.parse(localStorage.getItem(K_RESA)||'{}');
    const setResas=o=>localStorage.setItem(K_RESA,JSON.stringify(o));
    const getStatuses=()=>JSON.parse(localStorage.getItem(K_STATUS)||'{}');
    const setStatuses=o=>localStorage.setItem(K_STATUS,JSON.stringify(o));
    const saveRoomStatus=(n,st)=>{const s=getStatuses();s[n]=st;setStatuses(s);};
    const saveRoomData=(n,d)=>{if(window.AJ_HOTEL)window.AJ_HOTEL.saveRoom(n,d);};
    const roomByNum=n=>ROOMS.find(r=>r.num===n);
    const metaFor=r=>ROOM_META[r.type]||ROOM_META.single;

    function syncFromStorage(){
        const statuses=getStatuses(),resas=getResas(),statusMap={};
        ROOMS.forEach(r=>{statusMap[r.num]=r.status;});
        ROOMS=loadCatalogRooms();
        ROOMS.forEach(r=>{
            if(resas[r.num]?.validated)r.status=resas[r.num].statusChambre||'reservee';
            else if(statuses[r.num])r.status=statuses[r.num];
            else if(statusMap[r.num])r.status=statusMap[r.num];
        });
    }

    function cardHtml(r,idx){
        const m=metaFor(r);
        return`<article class="ch-room-card st-${r.status}${selectedNum===r.num?' is-selected':''}" data-num="${r.num}" data-type="${r.type}" data-status="${r.status}" data-floor="${r.floor}" data-slot="${idx}" style="--ch-slot:${idx}" role="button" tabindex="0">
            <div class="ch-rc-img">
                <img src="${esc(r.img)}" alt="${esc(r.title)}" loading="lazy">
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

    function openModal(){document.getElementById('rmModalOverlay')?.classList.add('show');}
    function closeModal(){document.getElementById('rmModalOverlay')?.classList.remove('show');currentRoom=null;}

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
            <p>Sélectionnez un étage puis une chambre, ou cliquez une carte.</p>
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

    function formHtml(room,data){
        const d=data||{};
        return`<div class="rm-form-head"><h3>Réservation — Chambre ${esc(room.num)}</h3><p>${esc(room.title)} · Tarif ${fmtP(room.price)} / nuit</p></div>
        <form id="rfForm" class="rm-form-grid" onsubmit="return false">
            <div class="field"><label>N° Chambre</label><input type="text" id="rf_num" value="${esc(room.num)}" readonly></div>
            <div class="field"><label>Date</label><input type="date" id="rf_date" value="${esc(d.date||today())}"></div>
            <div class="field span2"><label>Nom Client</label><input type="text" id="rf_nom" value="${esc(d.nom||'')}" placeholder="Nom complet du client"></div>
            <div class="field span2"><label>N° CIN / Passport</label><input type="text" id="rf_cin" value="${esc(d.cin||'')}" placeholder="AB123456"></div>
            <div class="field"><label>Nbrs Personnes</label><input type="number" id="rf_personnes" min="1" value="${esc(d.personnes||1)}"></div>
            <div class="field"><label>Nbrs Nuités</label><input type="number" id="rf_nuits" min="1" value="${esc(d.nuits||1)}"></div>
            <div class="field span2"><label>Tarif Nuités (DH)</label><input type="number" id="rf_tarif" min="0" step="0.01" value="${esc(d.tarif!=null?d.tarif:room.price)}"></div>
        </form>
        <div class="rm-form-totals">
            <div class="ttl"><label>Total HT</label><input type="text" id="rf_ht" readonly></div>
            <div class="ttl"><label>Total TVA (10%)</label><input type="text" id="rf_tva" readonly></div>
            <div class="ttl"><label>Total TTC</label><input type="text" id="rf_ttc" readonly></div>
        </div>
        <div class="rm-form-actions">
            <button type="button" class="btn gold" id="rfValider">Valider</button>
            <button type="button" class="btn ghost" id="rfModifier">Modifier</button>
            <button type="button" class="btn ghost" id="rfImprimer">Imprimer</button>
            <button type="button" class="btn ghost" id="rfPdf">Exporter PDF</button>
        </div>`;
    }

    function calcTotals(){
        const nuits=num(document.getElementById('rf_nuits')?.value);
        const tarif=num(document.getElementById('rf_tarif')?.value);
        const ht=nuits*tarif,tva=ht*TVA_RATE,ttc=ht+tva;
        const htEl=document.getElementById('rf_ht'),tvaEl=document.getElementById('rf_tva'),ttcEl=document.getElementById('rf_ttc');
        if(htEl)htEl.value=fmtAmt(ht)+' DH';
        if(tvaEl)tvaEl.value=fmtAmt(tva)+' DH';
        if(ttcEl)ttcEl.value=fmtAmt(ttc)+' DH';
        return{ht,tva,ttc};
    }

    function getFormData(){
        return{
            num:document.getElementById('rf_num')?.value,
            date:document.getElementById('rf_date')?.value,
            nom:document.getElementById('rf_nom')?.value.trim(),
            cin:document.getElementById('rf_cin')?.value.trim(),
            personnes:num(document.getElementById('rf_personnes')?.value),
            nuits:num(document.getElementById('rf_nuits')?.value),
            tarif:num(document.getElementById('rf_tarif')?.value),
            ...calcTotals()
        };
    }

    function setFormReadonly(ro){
        ['rf_date','rf_nom','rf_cin','rf_personnes','rf_nuits','rf_tarif'].forEach(id=>{
            const el=document.getElementById(id);if(el)el.readOnly=ro;
        });
    }

    function confirmReservation(room,d,status){
        const resas=getResas();
        resas[room.num]={...d,validated:true,title:room.title,statusChambre:status};
        setResas(resas);
        room.status=status;
        saveRoomStatus(room.num,status);
        closeModal();
        render();
        alert('Réservation validée — Statut : '+STATUS[status]);
    }

    function changeRoomStatus(room,newStatus){
        if(newStatus===room.status){closeModal();return;}
        room.status=newStatus;
        saveRoomStatus(room.num,newStatus);
        const resas=getResas();
        if(newStatus==='disponible'||newStatus==='nettoyage'||newStatus==='maintenance'){delete resas[room.num];setResas(resas);}
        closeModal();
        render();
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
            <p class="rm-status-sub">Chambre ${esc(room.num)} — ${esc(d.nom)} · ${d.nuits} nuit(s) · ${fmtAmt(d.ttc)} DH TTC</p>
            <div class="rm-status-btns">
                <button type="button" class="rm-st-btn st-occupee" data-st="occupee">Occupée</button>
                <button type="button" class="rm-st-btn st-reservee" data-st="reservee">Réservée</button>
            </div>
            <button type="button" class="btn ghost" id="rfRetour" style="margin-top:22px">Retour au formulaire</button>
        </div>`;
        box.querySelectorAll('.rm-st-btn').forEach(btn=>{
            btn.addEventListener('click',()=>confirmReservation(room,d,btn.dataset.st));
        });
        document.getElementById('rfRetour')?.addEventListener('click',()=>showForm(room,d));
        openModal();
    }

    function showForm(room,prefill){
        currentRoom=room;
        const saved=getResas()[room.num],data=prefill||saved;
        const box=document.getElementById('rmModalContent');
        if(!box)return;
        box.innerHTML=formHtml(room,data);
        calcTotals();
        if(saved?.validated&&!prefill)setFormReadonly(true);
        ['rf_nuits','rf_tarif','rf_personnes'].forEach(id=>document.getElementById(id)?.addEventListener('input',calcTotals));
        document.getElementById('rfValider')?.addEventListener('click',()=>{
            const d=getFormData();
            if(!d.nom){alert('Veuillez saisir le nom du client.');return;}
            if(!d.cin){alert('Veuillez saisir le N° CIN / Passport.');return;}
            if(d.nuits<1){alert('Le nombre de nuités doit être au moins 1.');return;}
            showStatusChoice(room,d);
        });
        document.getElementById('rfModifier')?.addEventListener('click',()=>setFormReadonly(false));
        document.getElementById('rfImprimer')?.addEventListener('click',()=>printForm(room,false));
        document.getElementById('rfPdf')?.addEventListener('click',()=>printForm(room,true));
        openModal();
    }

    function printForm(room,isPdf){
        const d=getFormData();
        const html=`<!DOCTYPE html><html><head><meta charset="utf-8"><title>Réservation Chambre ${esc(room.num)}</title>
        <style>body{font-family:Georgia,serif;padding:32px;color:#111}h1{font-size:22px}table{width:100%;border-collapse:collapse}td,th{padding:10px;border:1px solid #ccc;font-size:13px}th{background:#1a2236;color:#fff}</style></head><body>
        <h1>Al Jazeera Hotel — Réservation</h1>
        <h2>Chambre ${esc(room.num)} — ${esc(room.title)}</h2>
        <table><tr><th>Champ</th><th>Valeur</th></tr>
        <tr><td>Date</td><td>${esc(d.date)}</td></tr><tr><td>Nom</td><td>${esc(d.nom)}</td></tr>
        <tr><td>CIN</td><td>${esc(d.cin)}</td></tr><tr><td>Nuitées</td><td>${d.nuits}</td></tr>
        <tr><td>TTC</td><td>${fmtAmt(d.ttc)} DH</td></tr></table></body></html>`;
        const w=window.open('','',isPdf?'width=800,height=700':'width=800,height=700');
        w.document.write(html);w.document.close();w.focus();setTimeout(()=>w.print(),300);
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
                <input type="number" id="re_price" min="0" step="1" value="${room.price}" placeholder="Prix / nuit (DH)">
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
            if(status==='disponible'||status==='nettoyage'||status==='maintenance'){
                delete resas[room.num];
                setResas(resas);
            }
        }
        closeModal();
        refreshCardDom(room);
        renderStats();
        applyFilters();
        if(selectedNum===room.num)showDetail(room);
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
            if(room)showDetail(room);
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

    function renderCategories(){
        const box=document.getElementById('chCategoriesGrid');
        if(!box)return;
        syncFromStorage();
        box.innerHTML=['suite','familiale','single'].map(key=>{
            const list=ROOMS.filter(r=>r.type===key);
            const disp=list.filter(r=>r.status==='disponible').length;
            return`<article class="ch-cat-card" data-cat="${key}">
                <h3>${CAT_TITLE[key]}</h3>
                <p>${list.length} chambre(s) · ${disp} disponible(s)</p>
            </article>`;
        }).join('');
        box.querySelectorAll('.ch-cat-card').forEach(el=>{
            el.addEventListener('click',()=>{
                currentFilter.cat=el.dataset.cat;
                const sel=document.getElementById('chFilterCat');
                if(sel)sel.value=el.dataset.cat;
                document.querySelector('.sb-item[data-target="ch-etat"]')?.click();
            });
        });
    }

    let etagesFloorFilter='',etagesFloorQ='',etagesBound=false;

    function matchesEtageSearch(floor){
        const q=etagesFloorQ.trim().toLowerCase();
        if(etagesFloorFilter&&String(floor)!==String(etagesFloorFilter))return false;
        if(!q)return true;
        const lbl=floorLbl(floor).toLowerCase();
        return lbl.includes(q)||String(floor).includes(q)||`${floor}e`.includes(q)||`${floor}er`.includes(q);
    }

    function renderEtagesTable(){
        const tbody=document.getElementById('chEtagesTableBody');
        if(!tbody)return;
        const sorted=ROOMS.slice()
            .filter(r=>matchesEtageSearch(r.floor))
            .sort((a,b)=>{
                if(a.floor!==b.floor)return a.floor-b.floor;
                return String(a.num).localeCompare(String(b.num),undefined,{numeric:true});
            });
        if(!sorted.length){
            tbody.innerHTML='<tr class="empty-row"><td colspan="6">Aucune chambre pour cet étage.</td></tr>';
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

    function renderEtages(){
        const box=document.getElementById('chEtagesGrid');
        const tbody=document.getElementById('chEtagesTableBody');
        if(!box&&!tbody)return;
        syncFromStorage();
        const floors=[...new Set(ROOMS.map(r=>r.floor))].sort((a,b)=>a-b);
        const floorSel=document.getElementById('etFloorFilter');
        if(floorSel){
            const cur=etagesFloorFilter||floorSel.value;
            floorSel.innerHTML='<option value="">Étage : Tous</option>'+floors.map(f=>`<option value="${f}">${floorLbl(f)}</option>`).join('');
            if(cur&&floors.some(f=>String(f)===String(cur)))floorSel.value=cur;
            else{floorSel.value='';etagesFloorFilter='';}
        }
        if(box){
            box.innerHTML=floors.map(f=>{
                const list=ROOMS.filter(r=>r.floor===f);
                const dispo=list.filter(r=>r.status==='disponible').length;
                const occu=list.filter(r=>r.status==='occupee').length;
                const active=matchesEtageSearch(f);
                return`<article class="ch-etage-card${active?'':' is-dimmed'}${String(etagesFloorFilter)===String(f)?' is-active':''}" data-floor="${f}" role="button" tabindex="0">
                    <h3>${floorLbl(f)}</h3>
                    <div class="et-count">${list.length}</div>
                    <p class="et-meta">${dispo} dispo · ${occu} occupée(s)</p>
                </article>`;
            }).join('');
            box.querySelectorAll('.ch-etage-card').forEach(el=>{
                const pick=()=>{
                    etagesFloorFilter=el.dataset.floor;
                    etagesFloorQ='';
                    const sel=document.getElementById('etFloorFilter');
                    const search=document.getElementById('etFloorSearch');
                    if(sel)sel.value=el.dataset.floor;
                    if(search)search.value='';
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
                etagesFloorFilter=e.target.value;
                renderEtages();
            });
            etagesBound=true;
        }
    }

    return{render,renderCategories,renderEtages};
})();
window.CHETAT=CHETAT;
</script>
</body>
</html>
