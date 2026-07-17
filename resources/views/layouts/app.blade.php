<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Al Jazeera Hotel') — Al Jazeera Hotel</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root{
            --navy:#0a1736;
            --navy-deep:#060f24;
            --navy-mid:#0f2a5c;
            --gold:#c5a059;
            --gold-light:#d4b06a;
            --cream:#f5f1e6;
            --text-muted:#6b7280;
            --text-dark:#1a2332;
            --surface:#f7f5f0;
            --white:#ffffff;
            --content-max:1280px;
        }
        *{margin:0;padding:0;box-sizing:border-box}
        html{scroll-behavior:smooth}
        body{
            font-family:'Montserrat',sans-serif;
            background:var(--surface);
            color:var(--text-dark);
            line-height:1.6;
        }
        body.page-home{background:var(--white)}
        a{text-decoration:none;color:inherit}
        .serif{font-family:'Cormorant Garamond',serif}

        /* ---------- NAVBAR LUMINEUX ---------- */
        @keyframes navShimmer{
            0%{background-position:200% center}
            100%{background-position:-200% center}
        }
        @keyframes brandPulse{
            0%,100%{box-shadow:0 0 12px rgba(197,160,89,.35),0 0 28px rgba(197,160,89,.15)}
            50%{box-shadow:0 0 22px rgba(212,176,106,.65),0 0 48px rgba(197,160,89,.35)}
        }
        @keyframes reserveGlow{
            0%,100%{box-shadow:0 4px 18px rgba(197,160,89,.35),inset 0 1px 0 rgba(255,255,255,.35)}
            50%{box-shadow:0 8px 32px rgba(212,176,106,.55),0 0 40px rgba(197,160,89,.25),inset 0 1px 0 rgba(255,255,255,.45)}
        }
        @keyframes linkGlow{
            0%,100%{opacity:.4;transform:scale(1)}
            50%{opacity:.85;transform:scale(1.08)}
        }
        .navbar{
            position:fixed;top:0;left:0;right:0;z-index:50;
            display:flex;align-items:center;justify-content:space-between;
            padding:12px clamp(20px,4vw,48px);
            background:linear-gradient(180deg,rgba(255,255,255,.97) 0%,rgba(255,255,255,.92) 100%);
            backdrop-filter:blur(18px) saturate(1.4);
            border-bottom:1px solid transparent;
            transition:padding .35s ease,box-shadow .35s ease,background .35s ease;
        }
        .navbar::after{
            content:'';position:absolute;left:0;right:0;bottom:0;height:1px;
            background:linear-gradient(90deg,transparent,rgba(197,160,89,.15),var(--gold),rgba(212,176,106,.8),var(--gold),rgba(197,160,89,.15),transparent);
            background-size:200% 100%;
            animation:navShimmer 6s linear infinite;
            opacity:.85;
        }
        .navbar.scrolled{
            padding:10px clamp(20px,4vw,48px);
            box-shadow:0 8px 40px rgba(10,23,54,.08),0 0 60px rgba(197,160,89,.06);
            background:linear-gradient(180deg,rgba(255,255,255,.99),rgba(247,245,240,.96));
        }
        .brand{
            display:flex;align-items:center;gap:14px;flex-shrink:0;
            padding:6px 12px 6px 6px;border-radius:12px;
            transition:background .3s ease,box-shadow .3s ease;
        }
        .brand:hover{background:rgba(197,160,89,.06);box-shadow:0 0 24px rgba(197,160,89,.12)}
        .brand-mark-wrap{
            position:relative;width:54px;height:54px;display:flex;align-items:center;justify-content:center;
        }
        .brand-mark-wrap::before{
            content:'';position:absolute;inset:-4px;border-radius:14px;
            background:radial-gradient(circle,rgba(212,176,106,.35),transparent 70%);
            animation:brandPulse 3.5s ease-in-out infinite;
        }
        .brand-mark{height:48px;width:auto;display:block;object-fit:contain;position:relative;z-index:1}
        .brand-text{display:flex;flex-direction:column;line-height:1.1}
        .brand-text b{
            font-size:15px;letter-spacing:3px;color:var(--text-dark);font-weight:700;
            text-shadow:0 0 20px rgba(197,160,89,.15);
        }
        .brand-text span{font-size:9px;letter-spacing:2.5px;color:var(--gold);text-transform:uppercase;font-weight:600}
        .brand-stars{
            font-size:8px;color:var(--gold-light);letter-spacing:3px;margin-top:3px;
            text-shadow:0 0 8px rgba(212,176,106,.5);
        }
        .nav-links{
            display:flex;gap:4px;list-style:none;justify-content:center;align-items:center;
            flex:1;padding:6px 10px;margin:0 16px;
            background:linear-gradient(135deg,rgba(255,255,255,.85),rgba(247,245,240,.7));
            border:1px solid rgba(197,160,89,.18);
            border-radius:50px;
            box-shadow:inset 0 1px 0 rgba(255,255,255,.9),0 4px 24px rgba(197,160,89,.08),0 0 40px rgba(197,160,89,.04);
        }
        .nav-item{position:relative}
        .nav-links .nav-link{
            display:inline-flex;align-items:center;gap:7px;
            font-size:11px;letter-spacing:1px;text-transform:uppercase;
            color:#5c6478;font-weight:600;position:relative;overflow:hidden;
            padding:10px 16px;border-radius:40px;
            transition:color .3s ease,transform .25s ease,box-shadow .3s ease,background .3s ease;
        }
        .nav-ico{
            font-size:13px;line-height:1;opacity:.75;
            transition:opacity .3s,transform .3s,filter .3s;
            filter:grayscale(.2);
        }
        .nav-shine{
            position:absolute;inset:0;border-radius:inherit;pointer-events:none;
            background:linear-gradient(105deg,transparent 40%,rgba(255,255,255,.55) 50%,transparent 60%);
            transform:translateX(-120%);transition:transform .6s ease;
        }
        .nav-links .nav-link::before{
            content:'';position:absolute;inset:0;border-radius:inherit;opacity:0;
            background:radial-gradient(circle at 50% 50%,rgba(212,176,106,.28),transparent 72%);
            transition:opacity .35s ease;
        }
        .nav-links .nav-link:hover{
            color:var(--text-dark);transform:translateY(-1px);
            box-shadow:0 4px 20px rgba(197,160,89,.18),0 0 30px rgba(197,160,89,.1);
            background:rgba(255,255,255,.75);
        }
        .nav-links .nav-link:hover .nav-ico{opacity:1;transform:scale(1.12);filter:grayscale(0) drop-shadow(0 0 6px rgba(197,160,89,.5))}
        .nav-links .nav-link:hover .nav-shine{transform:translateX(120%)}
        .nav-links .nav-link:hover::before{opacity:1}
        .nav-links .nav-link.active{
            color:#1a1304;
            background:linear-gradient(135deg,var(--gold-light),var(--gold));
            box-shadow:0 4px 22px rgba(197,160,89,.45),0 0 36px rgba(212,176,106,.3),inset 0 1px 0 rgba(255,255,255,.4);
        }
        .nav-links .nav-link.active .nav-ico{opacity:1;filter:drop-shadow(0 0 4px rgba(26,19,4,.2))}
        .nav-links .nav-link.active::after{
            content:'';position:absolute;bottom:3px;left:50%;transform:translateX(-50%);
            width:20px;height:2px;border-radius:2px;
            background:rgba(26,19,4,.25);
            box-shadow:0 0 8px rgba(255,255,255,.5);
        }
        .nav-txt{position:relative;z-index:1}

        /* ---- MEGA-MENU ADMIN ---- */
        .has-mega{position:static}
        .mega{
            position:fixed;top:78px;right:clamp(20px,4vw,48px);left:auto;transform:translateY(-16px) scale(.98);
            width:min(880px,92vw);z-index:60;
            background:linear-gradient(165deg,rgba(255,255,255,.98),rgba(247,245,240,.95));
            border:1px solid rgba(197,160,89,.3);border-radius:20px;
            padding:28px;
            box-shadow:0 28px 70px rgba(10,23,54,.12),0 0 80px rgba(197,160,89,.12),inset 0 1px 0 rgba(255,255,255,.9);
            opacity:0;visibility:hidden;pointer-events:none;
            transition:opacity .35s ease,transform .35s cubic-bezier(.34,1.4,.64,1),visibility .35s;
        }
        .mega.open{opacity:1;visibility:visible;pointer-events:auto;transform:translateY(0) scale(1)}
        .mega-head{text-align:center;margin-bottom:24px;position:relative}
        .mega-head::after{
            content:'';display:block;width:60px;height:2px;margin:14px auto 0;
            background:linear-gradient(90deg,transparent,var(--gold),transparent);
            box-shadow:0 0 12px rgba(197,160,89,.5);
        }
        .mega-head h4{
            font-family:'Cormorant Garamond',serif;font-size:28px;color:var(--text-dark);letter-spacing:1px;
            text-shadow:0 0 30px rgba(197,160,89,.15);
        }
        .mega-head p{font-size:13px;color:var(--text-muted);margin-top:6px}
        .mega-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:18px}
        .mega-card{
            display:flex;flex-direction:column;align-items:center;gap:12px;
            background:linear-gradient(165deg,#fff,rgba(247,245,240,.9));
            border:1px solid rgba(197,160,89,.15);border-radius:16px;padding:24px 20px;
            transition:transform .3s ease,border-color .3s ease,box-shadow .3s ease;
            box-shadow:0 4px 16px rgba(0,0,0,.04);
        }
        .mega-card:hover{
            transform:translateY(-6px);
            border-color:rgba(197,160,89,.45);
            box-shadow:0 16px 40px rgba(197,160,89,.15),0 0 50px rgba(197,160,89,.08);
        }
        .mega-icon{
            font-size:28px;width:62px;height:62px;border-radius:50%;
            display:flex;align-items:center;justify-content:center;
            background:radial-gradient(circle at 40% 35%,rgba(212,176,106,.35),rgba(197,160,89,.08) 70%);
            border:1px solid rgba(197,160,89,.35);
            box-shadow:0 0 24px rgba(197,160,89,.35),inset 0 0 20px rgba(255,255,255,.5);
        }
        .mega-card h5{font-size:15px;letter-spacing:2px;text-transform:uppercase;color:var(--gold);font-weight:600}
        .mega-error{
            width:100%;background:rgba(230,80,80,.14);border:1px solid rgba(230,80,80,.4);
            color:#f0a3a3;font-size:12px;padding:8px 10px;border-radius:8px;text-align:center;
        }
        .mega-card .field{
            display:flex;align-items:center;gap:8px;width:100%;
            background:rgba(247,245,240,.8);border:1px solid rgba(197,160,89,.2);
            border-radius:10px;padding:10px 14px;transition:border-color .25s ease,box-shadow .25s ease;
        }
        .mega-card .field:focus-within{
            border-color:var(--gold);
            box-shadow:0 0 0 3px rgba(197,160,89,.12),0 0 20px rgba(197,160,89,.2);
        }
        .mega-card .field .fi{font-size:15px;opacity:.85}
        .mega-card .field input{
            flex:1;background:transparent;border:none;outline:none;
            color:var(--text-dark);font-size:13px;font-family:'Montserrat',sans-serif;
        }
        .mega-card .field input::placeholder{color:#9ca3af}
        .mega-btn{
            width:100%;margin-top:4px;border:none;cursor:pointer;position:relative;overflow:hidden;
            background:linear-gradient(135deg,var(--gold),var(--gold-light));
            color:#1a1304;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;font-size:12px;
            padding:12px;border-radius:10px;transition:transform .25s ease,box-shadow .3s ease;
            box-shadow:0 4px 18px rgba(197,160,89,.35);
        }
        .mega-btn:hover{transform:translateY(-2px);box-shadow:0 10px 28px rgba(197,160,89,.5),0 0 40px rgba(212,176,106,.25)}
        .btn-reserve{
            display:inline-flex;align-items:center;gap:8px;position:relative;overflow:hidden;
            background:linear-gradient(135deg,var(--gold-light),var(--gold),#b8924a);
            color:#1a1304;font-weight:700;font-size:11px;letter-spacing:1.3px;
            text-transform:uppercase;padding:12px 24px;border-radius:50px;border:none;
            cursor:pointer;white-space:nowrap;
            animation:reserveGlow 3s ease-in-out infinite;
            transition:transform .25s ease;
        }
        .btn-reserve::before{
            content:'';position:absolute;inset:0;
            background:linear-gradient(105deg,transparent 35%,rgba(255,255,255,.4) 50%,transparent 65%);
            transform:translateX(-100%);transition:transform .55s ease;
        }
        .btn-reserve:hover{transform:translateY(-3px) scale(1.02)}
        .btn-reserve:hover::before{transform:translateX(100%)}
        .btn-reserve svg{width:16px;height:16px;position:relative;z-index:1}
        .btn-reserve span,.btn-reserve{position:relative;z-index:1}

        .nav-lang{
            display:flex;align-items:center;gap:6px;font-size:11px;font-weight:700;
            color:var(--text-dark);padding:9px 14px;border-radius:50px;
            border:1px solid rgba(197,160,89,.22);
            background:linear-gradient(135deg,#fff,rgba(247,245,240,.9));
            box-shadow:0 2px 12px rgba(197,160,89,.08),inset 0 1px 0 rgba(255,255,255,.8);
            transition:box-shadow .3s,border-color .3s,transform .25s;
            letter-spacing:.5px;
        }
        .nav-lang:hover{
            border-color:rgba(197,160,89,.45);
            box-shadow:0 4px 20px rgba(197,160,89,.18),0 0 30px rgba(197,160,89,.1);
            transform:translateY(-1px);
        }
        .nav-user-btn{
            width:42px;height:42px;border-radius:50%;
            border:1px solid rgba(197,160,89,.25);
            background:linear-gradient(145deg,#fff,rgba(247,245,240,.95));
            color:var(--gold);cursor:pointer;
            display:flex;align-items:center;justify-content:center;font-size:17px;
            transition:border-color .3s,box-shadow .3s,transform .25s,color .3s;
            box-shadow:0 2px 14px rgba(197,160,89,.1),inset 0 1px 0 rgba(255,255,255,.9);
        }
        .nav-user-btn:hover,.nav-user-btn.is-open{
            border-color:var(--gold);color:var(--text-dark);
            box-shadow:0 0 0 4px rgba(197,160,89,.12),0 8px 28px rgba(197,160,89,.25),0 0 40px rgba(212,176,106,.15);
            transform:translateY(-1px);
        }

        /* ---- PROFIL ---- */
        .nav-right{flex-shrink:0;display:flex;align-items:center;justify-content:flex-end;gap:10px}
        .profile{display:none}
        .burger{display:none;flex-direction:column;gap:5px;cursor:pointer}
        .burger span{width:26px;height:2px;background:var(--text-dark)}

        /* ---------- FOOTER ---------- */
        footer{
            background:var(--navy-deep);border-top:1px solid rgba(197,160,89,.15);
            padding:40px 48px;text-align:center;color:#b9bfd0;font-size:13px;
        }
        footer .gold{color:var(--gold)}
        footer .site-copyright{margin-top:14px;font-size:13px;letter-spacing:.3px;color:#b9bfd0}
        body.page-home footer{display:none}

        @media(max-width:1024px){
            .nav-links .nav-link{padding:9px 12px;font-size:10px}
            .nav-ico{display:none}
        }
        @media(max-width:860px){
            .navbar{padding:10px 16px}
            .navbar::after{animation:none;background:linear-gradient(90deg,transparent,var(--gold),transparent)}
            .nav-links{
                position:fixed;top:76px;right:0;height:calc(100vh - 76px);width:300px;
                flex-direction:column;gap:6px;padding:28px 20px;align-items:stretch;
                background:linear-gradient(180deg,rgba(255,255,255,.98),rgba(247,245,240,.96));
                transform:translateX(100%);margin:0;
                border:none;border-left:1px solid rgba(197,160,89,.2);
                border-radius:0;box-shadow:-8px 0 40px rgba(10,23,54,.1),0 0 60px rgba(197,160,89,.06);
                transition:transform .35s cubic-bezier(.4,0,.2,1);flex:none;
            }
            .nav-links .nav-link{
                justify-content:flex-start;padding:14px 18px;border-radius:12px;
                border:1px solid transparent;
            }
            .nav-ico{display:inline;font-size:16px}
            .nav-links .nav-link:hover,.nav-links .nav-link.active{
                border-color:rgba(197,160,89,.25);
            }
            .nav-links .nav-link.active::after{display:none}
            .nav-links.open{transform:translateX(0)}
            .burger{
                display:flex;align-items:center;justify-content:center;
                width:42px;height:42px;border-radius:50%;
                border:1px solid rgba(197,160,89,.25);
                background:linear-gradient(145deg,#fff,rgba(247,245,240,.9));
                box-shadow:0 2px 14px rgba(197,160,89,.1);
            }
            .burger span{width:20px;height:2px;background:var(--text-dark);border-radius:2px;transition:transform .3s,opacity .3s}
            .nav-lang{display:none}
            .brand-text b{font-size:13px}
            .mega{top:76px;right:0;left:0;width:100%;border-radius:0;max-height:70vh;overflow-y:auto}
            .mega-grid{grid-template-columns:1fr}
        }
    </style>
    @include('partials.data-center-styles')
    @stack('styles')
</head>
<body class="@if(request()->routeIs('home')) page-home @elseif(request()->routeIs('chambres')) page-chambres @endif">
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
    <nav class="navbar" id="navbar">
        <a href="{{ route('home') }}" class="brand">
            <span class="brand-mark-wrap">
                <img src="{{ asset('images/logo.png') }}" alt="ALJAZEERA Hotel & Resort" class="brand-mark" onerror="this.style.display='none'">
            </span>
            <span class="brand-text">
                <b>ALJAZEERA</b>
                <span>Hotel &amp; Resort</span>
                <span class="brand-stars">&#9733; &#9733; &#9733; &#9733; &#9733;</span>
            </span>
        </a>
        <ul class="nav-links" id="navLinks">
            <li class="nav-item"><a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"><span class="nav-ico">&#127968;</span><span class="nav-txt">Accueil</span><span class="nav-shine"></span></a></li>
            <li class="nav-item"><a href="{{ route('chambres') }}" class="nav-link {{ request()->routeIs('chambres') ? 'active' : '' }}"><span class="nav-ico">&#128719;</span><span class="nav-txt">Chambres</span><span class="nav-shine"></span></a></li>
            <li class="nav-item"><a href="{{ route('restaurant') }}" class="nav-link {{ request()->routeIs('restaurant') ? 'active' : '' }}"><span class="nav-ico">&#127869;</span><span class="nav-txt">Restaurant</span><span class="nav-shine"></span></a></li>
            <li class="nav-item"><a href="{{ route('services') }}" class="nav-link {{ request()->routeIs('services') ? 'active' : '' }}"><span class="nav-ico">&#10024;</span><span class="nav-txt">Services</span><span class="nav-shine"></span></a></li>
            <li class="nav-item"><a href="{{ route('chambres') }}#chambres-list" class="nav-link"><span class="nav-ico">&#128247;</span><span class="nav-txt">Galerie</span><span class="nav-shine"></span></a></li>
            <li class="nav-item"><a href="{{ route('home') }}#apropos" class="nav-link"><span class="nav-ico">&#9432;</span><span class="nav-txt">À propos</span><span class="nav-shine"></span></a></li>
            <li class="nav-item"><a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}"><span class="nav-ico">&#9993;</span><span class="nav-txt">Contact</span><span class="nav-shine"></span></a></li>
        </ul>
        <div class="nav-right">
            <span class="nav-lang" aria-label="Langue">&#127760; FR</span>
            <button type="button" class="nav-user-btn" id="adminToggle" title="Espace administration" aria-label="Connexion">&#128100;</button>
            <a href="{{ route('chambres') }}"><button type="button" class="btn-reserve"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg> Réserver</button></a>
            <div class="burger" id="burger"><span></span><span></span><span></span></div>
        </div>
        <div class="mega {{ session('login_error') ? 'open' : '' }}" id="adminMega">
            <div class="mega-head">
                <h4>Espace d'administration</h4>
                <p>Connectez-vous à votre espace dédié</p>
            </div>
            <div class="mega-grid">
                @foreach([['Direction','admin','&#128081;'],['Facturation','facturation','&#129534;'],['Commercial','commercial','&#128188;']] as $space)
                <form class="mega-card" method="POST" action="{{ route('space.login', $space[1]) }}">
                    @csrf
                    <div class="mega-icon">{!! $space[2] !!}</div>
                    <h5>{{ $space[0] }}</h5>
                    @if(session('login_error') && session('login_space') === $space[1])
                        <p class="mega-error">{{ session('login_error') }}</p>
                    @endif
                    <label class="field">
                        <span class="fi">&#128100;</span>
                        <input type="text" name="login" placeholder="{{ $space[0] }}" autocomplete="username" required>
                    </label>
                    <label class="field">
                        <span class="fi">&#128274;</span>
                        <input type="password" name="password" placeholder="Mot de passe" autocomplete="current-password" required>
                    </label>
                    <button type="submit" class="mega-btn">Se connecter</button>
                </form>
                @endforeach
            </div>
        </div>
    </nav>

    @yield('content')

    <footer>
        <p class="serif" style="font-size:22px;color:#fff;margin-bottom:8px">Al Jazeera Hotel</p>
        <p>Luxe, confort et élégance au cœur de la ville.</p>
        @include('partials.copyright')
    </footer>

    <script>
        const navbar=document.getElementById('navbar');
        window.addEventListener('scroll',()=>navbar.classList.toggle('scrolled',window.scrollY>40));
        document.getElementById('burger').addEventListener('click',()=>{
            document.getElementById('navLinks').classList.toggle('open');
        });
        const adminToggle=document.getElementById('adminToggle');
        const adminMega=document.getElementById('adminMega');
        if(adminToggle&&adminMega){
            adminToggle.addEventListener('click',(e)=>{
                e.preventDefault();
                e.stopPropagation();
                const open=adminMega.classList.toggle('open');
                adminToggle.classList.toggle('is-open',open);
            });
            document.addEventListener('click',(e)=>{
                if(!adminMega.contains(e.target)&&!adminToggle.contains(e.target)){
                    adminMega.classList.remove('open');
                    adminToggle.classList.remove('is-open');
                }
            });
            document.addEventListener('keydown',(e)=>{
                if(e.key==='Escape'){
                    adminMega.classList.remove('open');
                    adminToggle.classList.remove('is-open');
                }
            });
        }
    </script>
    @stack('scripts')
</body>
</html>
