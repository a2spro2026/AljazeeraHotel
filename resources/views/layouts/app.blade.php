<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Al Jazeera Hotel') — Al Jazeera Hotel</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <meta name="theme-color" content="#0a1736">
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
            --content-max:100%;
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

        /* ---- Accès admin discret (sans navbar) ---- */
        .admin-fab{
            position:fixed;top:18px;right:18px;z-index:80;
            width:44px;height:44px;border-radius:50%;
            border:1px solid rgba(197,160,89,.35);
            background:rgba(255,255,255,.92);color:var(--gold);
            cursor:pointer;display:flex;align-items:center;justify-content:center;
            font-size:17px;backdrop-filter:blur(8px);
            box-shadow:0 4px 20px rgba(10,23,54,.12);
            transition:transform .2s,box-shadow .2s,border-color .2s;
        }
        .admin-fab:hover,.admin-fab.is-open{
            transform:translateY(-1px);
            border-color:var(--gold);
            box-shadow:0 8px 28px rgba(197,160,89,.28);
        }
        .mega{
            position:fixed;top:70px;right:18px;left:auto;transform:translateY(-12px) scale(.98);
            width:min(880px,92vw);z-index:90;
            background:linear-gradient(165deg,rgba(255,255,255,.98),rgba(247,245,240,.95));
            border:1px solid rgba(197,160,89,.3);border-radius:20px;
            padding:28px;
            box-shadow:0 28px 70px rgba(10,23,54,.12),0 0 80px rgba(197,160,89,.12);
            opacity:0;visibility:hidden;pointer-events:none;
            transition:opacity .35s ease,transform .35s cubic-bezier(.34,1.4,.64,1),visibility .35s;
        }
        .mega.open{opacity:1;visibility:visible;pointer-events:auto;transform:translateY(0) scale(1)}
        .mega-head{text-align:center;margin-bottom:24px}
        .mega-head h4{
            font-family:'Cormorant Garamond',serif;font-size:26px;color:var(--text-dark);letter-spacing:1px;
        }
        .mega-head p{font-size:13px;color:var(--text-muted);margin-top:6px}
        .mega-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:18px}
        .mega-card{
            background:var(--white);border:1px solid rgba(197,160,89,.16);border-radius:14px;
            padding:20px 18px;display:flex;flex-direction:column;gap:10px;
            box-shadow:0 4px 16px rgba(0,0,0,.04);
        }
        .mega-icon{font-size:28px;text-align:center}
        .mega-card h5{font-size:14px;letter-spacing:2px;text-transform:uppercase;color:var(--gold);font-weight:600;text-align:center}
        .mega-error{background:rgba(180,40,40,.08);color:#a11;border:1px solid rgba(180,40,40,.2);padding:8px 10px;border-radius:8px;font-size:12px;text-align:center}
        .mega-card .field{
            display:flex;align-items:center;gap:8px;border:1px solid rgba(197,160,89,.22);
            border-radius:8px;padding:10px 12px;background:#fff;
        }
        .mega-card .field input{
            border:none;outline:none;width:100%;font:inherit;font-size:14px;background:transparent;
        }
        .mega-btn{
            background:linear-gradient(135deg,var(--gold),var(--gold-light));
            color:#1a1304;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;font-size:12px;
            padding:12px;border:none;border-radius:10px;cursor:pointer;
        }
        @media(max-width:860px){
            .mega{right:12px;left:12px;width:auto;max-height:75vh;overflow-y:auto}
            .mega-grid{grid-template-columns:1fr}
        }

        /* ---------- FOOTER ---------- */
        footer{
            background:var(--navy-deep);border-top:1px solid rgba(197,160,89,.15);
            padding:40px 48px;text-align:center;color:#b9bfd0;font-size:13px;
        }
        footer .gold{color:var(--gold)}
        footer .site-copyright{margin-top:14px;font-size:13px;letter-spacing:.3px;color:#b9bfd0}
        .footer-nav{
            display:flex;flex-wrap:wrap;justify-content:center;gap:10px 22px;
            margin:18px 0 8px;list-style:none;
        }
        .footer-nav a{
            color:#d4b06a;font-size:12px;letter-spacing:1px;text-transform:uppercase;font-weight:600;
            opacity:.9;transition:opacity .2s,color .2s;
        }
        .footer-nav a:hover{opacity:1;color:#fff}
        @media(max-width:860px){footer{padding:32px 20px}}
    </style>
    @include('partials.data-center-styles')
    @stack('styles')
</head>
<body class="@if(request()->routeIs('home')) page-home @elseif(request()->routeIs('chambres')) page-chambres @endif">
<script>
(function(){
    if(navigator.serviceWorker){
        navigator.serviceWorker.getRegistrations().then(function(regs){
            regs.forEach(function(r){r.unregister();});
        });
    }
    var V='aj_reset_v4';
    if(localStorage.getItem('aj_data_version')!==V){
        for(var i=localStorage.length-1;i>=0;i--){
            var k=localStorage.key(i);
            if(k&&k.indexOf('aj_')===0)localStorage.removeItem(k);
        }
        localStorage.setItem('aj_data_version',V);
    }
})();
</script>

    <button type="button" class="admin-fab" id="adminToggle" title="Espace administration" aria-label="Connexion">&#128100;</button>
    <div class="mega {{ session('login_error') ? 'open' : '' }}" id="adminMega">
        <div class="mega-head">
            <h4>Espace d'administration</h4>
            <p>Connectez-vous à votre espace dédié</p>
        </div>
        <div class="mega-grid">
            @foreach([['Direction','admin','&#128081;'],['Facturation','facturation','&#129534;'],['Commercial','commercial','&#128188;']] as $space)
            <form class="mega-card js-nomem-login" method="POST" action="{{ route('space.login', $space[1]) }}" autocomplete="off" data-lpignore="true" data-1p-ignore data-form-type="other">
                @csrf
                <input type="hidden" name="login" value="">
                <input type="hidden" name="password" value="">
                <div class="mega-icon">{!! $space[2] !!}</div>
                <h5>{{ $space[0] }}</h5>
                @if(session('login_error') && session('login_space') === $space[1])
                    <p class="mega-error">{{ session('login_error') }}</p>
                @endif
                <label class="field">
                    <span class="fi">&#128100;</span>
                    <input type="text" class="js-nomem-user" value="" placeholder="Identifiant" autocomplete="off" autocapitalize="off" spellcheck="false" readonly data-lpignore="true" data-1p-ignore required>
                </label>
                <label class="field">
                    <span class="fi">&#128274;</span>
                    <input type="password" class="js-nomem-pass" value="" placeholder="Mot de passe" autocomplete="new-password" readonly data-lpignore="true" data-1p-ignore required>
                </label>
                <button type="submit" class="mega-btn">Se connecter</button>
            </form>
            @endforeach
        </div>
    </div>
    <script>
    (function(){
        const forms=document.querySelectorAll('.js-nomem-login');
        const wipe=all=>forms.forEach(f=>f.querySelectorAll('input:not([name="_token"])').forEach(i=>{
            if(!all&&i.dataset.touched)return;
            i.value='';
            if(i.type!=='hidden'){i.setAttribute('readonly','');delete i.dataset.touched;}
        }));
        forms.forEach(f=>{
            const u=f.querySelector('.js-nomem-user'),p=f.querySelector('.js-nomem-pass');
            [u,p].forEach(i=>{
                const unlock=()=>{i.removeAttribute('readonly');i.dataset.touched='1';};
                ['pointerdown','touchstart','focus'].forEach(ev=>i.addEventListener(ev,unlock,{passive:true}));
            });
            f.addEventListener('submit',e=>{
                if(!u.value.trim()||!p.value){e.preventDefault();const t=u.value.trim()?p:u;t.removeAttribute('readonly');t.focus();return;}
                f.querySelector('input[name="login"]').value=u.value;
                f.querySelector('input[name="password"]').value=p.value;
                u.value='';p.value='';
            });
        });
        wipe(true);
        window.addEventListener('pageshow',()=>wipe(true));
        window.addEventListener('load',()=>[0,300,1000,2500].forEach(ms=>setTimeout(()=>wipe(false),ms)));
    })();
    </script>

    @yield('content')

    <footer>
        <p class="serif" style="font-size:22px;color:#fff;margin-bottom:8px">Al Jazeera Hotel</p>
        <p>Luxe, confort et élégance au cœur de la ville.</p>
        <ul class="footer-nav">
            <li><a href="{{ url('/') }}">Accueil</a></li>
            <li><a href="{{ url('/chambres') }}">Chambres</a></li>
            <li><a href="{{ url('/restaurant') }}">Restaurant</a></li>
            <li><a href="{{ url('/services') }}">Services</a></li>
            <li><a href="{{ url('/galerie') }}">Galerie</a></li>
            <li><a href="{{ url('/apropos') }}">À propos</a></li>
            <li><a href="{{ url('/contact') }}">Contact</a></li>
        </ul>
        @include('partials.copyright')
    </footer>

    <script>
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
