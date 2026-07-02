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
            --gold:#c9a227;
            --gold-light:#e6c75a;
            --cream:#f5f1e6;
            --text-muted:#b9bfd0;
            --content-max:1140px;
        }
        *{margin:0;padding:0;box-sizing:border-box}
        html{scroll-behavior:smooth}
        body{
            font-family:'Montserrat',sans-serif;
            background:var(--navy-deep);
            color:var(--cream);
            line-height:1.6;
        }
        a{text-decoration:none;color:inherit}
        .serif{font-family:'Cormorant Garamond',serif}

        /* ---------- NAVBAR ---------- */
        .navbar{
            position:fixed;top:0;left:0;right:0;z-index:50;
            display:flex;align-items:center;justify-content:space-between;
            padding:18px 48px;
            background:rgba(6,15,36,.55);
            backdrop-filter:blur(10px);
            border-bottom:1px solid rgba(201,162,39,.15);
            transition:background .3s ease;
        }
        .navbar.scrolled{background:rgba(6,15,36,.95)}
        .brand{display:flex;align-items:center;gap:16px;flex:1}
        .brand-mark{
            height:68px;width:auto;display:block;object-fit:contain;
            border-radius:12px;
            box-shadow:0 0 18px rgba(201,162,39,.6),0 0 40px rgba(201,162,39,.35);
            filter:drop-shadow(0 0 10px rgba(201,162,39,.65)) drop-shadow(0 0 22px rgba(201,162,39,.4));
            animation:brandGlow 3s ease-in-out infinite;
        }
        @keyframes brandGlow{
            0%,100%{
                box-shadow:0 0 14px rgba(201,162,39,.45),0 0 30px rgba(201,162,39,.25);
                filter:drop-shadow(0 0 8px rgba(201,162,39,.5)) drop-shadow(0 0 16px rgba(201,162,39,.3));
            }
            50%{
                box-shadow:0 0 26px rgba(230,199,90,.85),0 0 60px rgba(201,162,39,.55);
                filter:drop-shadow(0 0 14px rgba(201,162,39,.85)) drop-shadow(0 0 30px rgba(201,162,39,.55));
            }
        }
        .brand-text{display:flex;flex-direction:column;line-height:1.15}
        .brand-text b{
            font-size:28px;letter-spacing:4px;color:#fff;font-weight:700;
            animation:brandTextGlow 3s ease-in-out infinite;
        }
        .brand-text span{
            font-size:13px;letter-spacing:6px;color:var(--gold);
            animation:brandSubGlow 3s ease-in-out infinite;
        }
        @keyframes brandTextGlow{
            0%,100%{text-shadow:0 0 8px rgba(255,255,255,.4),0 0 16px rgba(201,162,39,.3)}
            50%{text-shadow:0 0 14px rgba(255,255,255,.7),0 0 30px rgba(201,162,39,.6),0 0 50px rgba(201,162,39,.4)}
        }
        @keyframes brandSubGlow{
            0%,100%{text-shadow:0 0 6px rgba(201,162,39,.5)}
            50%{text-shadow:0 0 12px rgba(201,162,39,.85),0 0 24px rgba(201,162,39,.55)}
        }
        .nav-links{
            display:flex;gap:8px;list-style:none;justify-content:center;align-items:center;
            padding:6px 10px;border-radius:40px;
            background:linear-gradient(120deg,rgba(201,162,39,.10),rgba(255,255,255,.04),rgba(201,162,39,.10));
            border:1px solid rgba(201,162,39,.25);
            box-shadow:0 0 18px rgba(201,162,39,.25),inset 0 0 14px rgba(201,162,39,.08);
            animation:navGlow 4s ease-in-out infinite;
        }
        @keyframes navGlow{
            0%,100%{box-shadow:0 0 14px rgba(201,162,39,.2),inset 0 0 12px rgba(201,162,39,.06)}
            50%{box-shadow:0 0 28px rgba(201,162,39,.4),inset 0 0 18px rgba(201,162,39,.12)}
        }
        .nav-links a{
            font-size:13px;letter-spacing:1.5px;text-transform:uppercase;
            color:var(--cream);font-weight:500;position:relative;
            padding:9px 16px;border-radius:30px;
            transition:color .25s ease,background .3s ease,box-shadow .3s ease;
        }
        .nav-links a:hover,.nav-links a.active{
            color:#1a1304;font-weight:600;
            background:linear-gradient(135deg,var(--gold),var(--gold-light));
            box-shadow:0 0 16px rgba(230,199,90,.7),0 0 32px rgba(201,162,39,.45);
        }

        /* ---- MEGA-MENU ADMIN ---- */
        .has-mega{position:static}
        .mega{
            position:fixed;top:88px;left:50%;transform:translateX(-50%) translateY(-12px);
            width:min(880px,92vw);z-index:60;
            background:linear-gradient(160deg,rgba(10,23,54,.98),rgba(6,15,36,.98));
            border:1px solid rgba(201,162,39,.35);border-radius:18px;
            padding:26px;
            box-shadow:0 24px 60px rgba(0,0,0,.55),0 0 40px rgba(201,162,39,.25);
            opacity:0;visibility:hidden;pointer-events:none;
            transition:opacity .3s ease,transform .3s ease,visibility .3s;
        }
        .mega.open{opacity:1;visibility:visible;pointer-events:auto;transform:translateX(-50%) translateY(0)}
        .mega-head{text-align:center;margin-bottom:22px}
        .mega-head h4{font-family:'Cormorant Garamond',serif;font-size:26px;color:#fff;letter-spacing:1px}
        .mega-head p{font-size:13px;color:var(--text-muted);margin-top:4px}
        .mega-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:18px}
        .mega-card{
            display:flex;flex-direction:column;align-items:center;gap:12px;
            background:rgba(255,255,255,.03);border:1px solid rgba(201,162,39,.15);
            border-radius:14px;padding:22px 18px;transition:transform .25s ease,border-color .25s ease,box-shadow .25s ease;
        }
        .mega-card:hover{transform:translateY(-5px);border-color:rgba(201,162,39,.5);box-shadow:0 0 24px rgba(201,162,39,.25)}
        .mega-icon{
            font-size:30px;width:58px;height:58px;border-radius:50%;
            display:flex;align-items:center;justify-content:center;
            background:radial-gradient(circle at 50% 40%,rgba(201,162,39,.25),transparent 70%);
            border:1px solid rgba(201,162,39,.4);
            box-shadow:0 0 16px rgba(201,162,39,.4);
        }
        .mega-card h5{font-size:15px;letter-spacing:2px;text-transform:uppercase;color:var(--gold);font-weight:600}
        .mega-error{
            width:100%;background:rgba(230,80,80,.14);border:1px solid rgba(230,80,80,.4);
            color:#f0a3a3;font-size:12px;padding:8px 10px;border-radius:8px;text-align:center;
        }
        .mega-card .field{
            display:flex;align-items:center;gap:8px;width:100%;
            background:rgba(0,0,0,.25);border:1px solid rgba(201,162,39,.2);
            border-radius:8px;padding:9px 12px;transition:border-color .2s ease,box-shadow .2s ease;
        }
        .mega-card .field:focus-within{border-color:var(--gold);box-shadow:0 0 12px rgba(201,162,39,.35)}
        .mega-card .field .fi{font-size:15px;opacity:.85}
        .mega-card .field input{
            flex:1;background:transparent;border:none;outline:none;
            color:var(--cream);font-size:13px;font-family:'Montserrat',sans-serif;
        }
        .mega-card .field input::placeholder{color:#8a90a5}
        .mega-btn{
            width:100%;margin-top:4px;border:none;cursor:pointer;
            background:linear-gradient(135deg,var(--gold),var(--gold-light));
            color:#1a1304;font-weight:600;letter-spacing:1px;text-transform:uppercase;font-size:12px;
            padding:11px;border-radius:8px;transition:transform .2s ease,box-shadow .3s ease;
        }
        .mega-btn:hover{transform:translateY(-2px);box-shadow:0 8px 22px rgba(201,162,39,.5)}
        .btn-reserve{
            background:linear-gradient(135deg,var(--gold),var(--gold-light));
            color:#1a1304;font-weight:600;font-size:12px;letter-spacing:1.5px;
            text-transform:uppercase;padding:12px 26px;border-radius:4px;border:none;
            cursor:pointer;transition:transform .2s ease,box-shadow .3s ease;
        }
        .btn-reserve:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(201,162,39,.45)}

        /* ---- PROFIL ---- */
        .nav-right{flex:1;display:flex;align-items:center;justify-content:flex-end;gap:12px}
        .profile{display:flex;align-items:center;gap:12px;cursor:pointer;padding:5px 8px;border-radius:40px;transition:background .25s ease}
        .profile:hover{background:rgba(201,162,39,.1)}
        .profile-name{display:flex;flex-direction:column;line-height:1.15;text-align:right}
        .profile-name b{font-size:14px;color:#fff;font-weight:600}
        .profile-name span{font-size:11px;letter-spacing:1px;color:var(--gold);text-transform:uppercase}
        .avatar{
            width:46px;height:46px;border-radius:50%;object-fit:cover;
            border:2px solid var(--gold);
            box-shadow:0 0 12px rgba(201,162,39,.55);
            display:flex;align-items:center;justify-content:center;
            background:linear-gradient(135deg,#13224c,#0a1736);
            color:var(--gold);font-weight:700;font-size:18px;font-family:'Cormorant Garamond',serif;
        }
        .burger{display:none;flex-direction:column;gap:5px;cursor:pointer}
        .burger span{width:26px;height:2px;background:var(--cream)}

        /* ---------- FOOTER ---------- */
        footer{
            background:var(--navy-deep);border-top:1px solid rgba(201,162,39,.15);
            padding:40px 48px;text-align:center;color:var(--text-muted);font-size:13px;
        }
        footer .gold{color:var(--gold)}
        footer .site-copyright{margin-top:14px;font-size:13px;letter-spacing:.3px;color:var(--text-muted)}

        @media(max-width:860px){
            .navbar{padding:14px 22px}
            .nav-links{
                position:fixed;top:74px;right:0;height:calc(100vh - 74px);width:250px;
                flex-direction:column;gap:14px;padding:34px 24px;align-items:stretch;
                background:rgba(6,15,36,.98);transform:translateX(100%);
                border:none;border-radius:0;border-left:1px solid rgba(201,162,39,.25);
                box-shadow:-4px 0 24px rgba(0,0,0,.4);animation:none;
                transition:transform .3s ease;
            }
            .nav-links a{text-align:center}
            .nav-links.open{transform:translateX(0)}
            .burger{display:flex}
            .btn-reserve{display:none}
            .brand{flex:0}
            .nav-right{flex:1}
            .profile-name{display:none}
            .mega{top:auto;left:0;transform:none;width:100%;border-radius:0;max-height:70vh;overflow-y:auto}
            .mega.open{transform:none}
            .mega-grid{grid-template-columns:1fr}
        }
    </style>
    @include('partials.data-center-styles')
    @stack('styles')
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
    <nav class="navbar" id="navbar">
        <a href="{{ route('home') }}" class="brand">
            <img src="{{ asset('images/logo.png') }}" alt="Al Jazeera Hotel" class="brand-mark">
            <span class="brand-text"><b>AL JAZEERA</b><span>HOTEL &#9733;&#9733;&#9733;&#9733;&#9733;</span></span>
        </a>
        <ul class="nav-links" id="navLinks">
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
            <li><a href="{{ route('chambres') }}" class="{{ request()->routeIs('chambres') ? 'active' : '' }}">Chambre</a></li>
            <li><a href="{{ route('services') }}" class="{{ request()->routeIs('services') ? 'active' : '' }}">Service</a></li>
            <li><a href="{{ route('restaurant') }}" class="{{ request()->routeIs('restaurant') ? 'active' : '' }}">Restaurant</a></li>
            <li><a href="{{ route('calendrier') }}" class="{{ request()->routeIs('calendrier') ? 'active' : '' }}">Calendrier</a></li>
            <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a></li>
            <li class="has-mega">
                <a href="#" id="adminToggle" class="{{ request()->routeIs('admin') ? 'active' : '' }}">Admin &#9662;</a>
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
            </li>
        </ul>
        <div class="nav-right">
            <div class="profile">
                @if(file_exists(public_path('images/profile.png')))
                    <img src="{{ asset('images/profile.png') }}" alt="Profil" class="avatar">
                @else
                    <span class="avatar">AJ</span>
                @endif
                <span class="profile-name"><b>Direction</b><span>Général</span></span>
            </div>
            <div class="burger" id="burger"><span></span><span></span><span></span></div>
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
                adminMega.classList.toggle('open');
            });
            document.addEventListener('click',(e)=>{
                if(!adminMega.contains(e.target)&&!adminToggle.contains(e.target)){
                    adminMega.classList.remove('open');
                }
            });
            document.addEventListener('keydown',(e)=>{if(e.key==='Escape')adminMega.classList.remove('open')});
        }
    </script>
    @stack('scripts')
</body>
</html>
