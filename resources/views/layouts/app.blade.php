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
    <script src="{{ asset('js/aj-dates.js') }}"></script>
    <script src="{{ asset('js/aj-money.js') }}"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700&family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,500;1,600&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
            border:1px solid rgba(197,160,89,.45);
            background:rgba(10,23,54,.88);color:var(--gold);
            cursor:pointer;display:flex;align-items:center;justify-content:center;
            font-size:17px;backdrop-filter:blur(8px);
            box-shadow:0 4px 20px rgba(10,23,54,.28),0 0 0 1px rgba(197,160,89,.12);
            transition:transform .2s,box-shadow .2s,border-color .2s,background .2s;
        }
        .admin-fab:hover,.admin-fab.is-open{
            transform:translateY(-1px);
            border-color:var(--gold-light);
            background:rgba(10,23,54,.96);
            box-shadow:0 8px 28px rgba(197,160,89,.35),0 0 24px rgba(212,176,106,.25);
        }
        .mega-veil{
            position:fixed;inset:0;z-index:85;
            background:rgba(6,15,36,.55);
            backdrop-filter:blur(6px);
            opacity:0;visibility:hidden;pointer-events:none;
            transition:opacity .3s ease,visibility .3s;
        }
        .mega-veil.open{opacity:1;visibility:visible;pointer-events:auto}
        .mega{
            position:fixed;top:50%;left:50%;z-index:90;
            width:min(460px,94vw);
            transform:translate(-50%,-46%) scale(.96);
            background:
                radial-gradient(120% 80% at 50% -10%,rgba(212,176,106,.28),transparent 55%),
                linear-gradient(165deg,#0b1a3a 0%,#071228 48%,#0a1736 100%);
            border:1px solid rgba(197,160,89,.42);
            border-radius:22px;padding:28px 26px 22px;
            box-shadow:
                0 30px 80px rgba(0,0,0,.45),
                0 0 0 1px rgba(255,255,255,.04) inset,
                0 0 60px rgba(197,160,89,.18);
            opacity:0;visibility:hidden;pointer-events:none;
            transition:opacity .35s ease,transform .35s cubic-bezier(.34,1.2,.64,1),visibility .35s;
        }
        .mega.open{opacity:1;visibility:visible;pointer-events:auto;transform:translate(-50%,-50%) scale(1)}
        .login-panel{display:flex;flex-direction:column;align-items:center;gap:14px;text-align:center}
        .login-logo{
            width:72px;height:72px;border-radius:18px;object-fit:cover;
            border:1px solid rgba(197,160,89,.45);
            box-shadow:0 0 0 4px rgba(197,160,89,.1),0 10px 28px rgba(0,0,0,.35);
            background:#fff;
        }
        .login-mark{display:flex;flex-direction:column;align-items:center;gap:5px;line-height:1}
        .login-mark .stars{color:var(--gold);letter-spacing:3px;font-size:11px;text-shadow:0 0 12px rgba(212,176,106,.7)}
        .login-title{
            font-family:'Cinzel',serif;font-weight:700;font-size:clamp(22px,5vw,28px);
            letter-spacing:.18em;text-transform:uppercase;color:#fff;
            text-shadow:
                0 0 8px rgba(255,255,255,.35),
                0 0 22px rgba(212,176,106,.55),
                0 0 42px rgba(197,160,89,.35);
            animation:loginGlow 3.6s ease-in-out infinite;
        }
        .login-title span{display:block;margin-top:6px;font-size:.42em;letter-spacing:.42em;color:var(--gold-light)}
        @keyframes loginGlow{
            0%,100%{text-shadow:0 0 8px rgba(255,255,255,.3),0 0 20px rgba(212,176,106,.45),0 0 36px rgba(197,160,89,.25)}
            50%{text-shadow:0 0 12px rgba(255,255,255,.5),0 0 28px rgba(232,201,120,.75),0 0 52px rgba(197,160,89,.45)}
        }
        .login-welcome{
            font-family:'Cormorant Garamond',serif;font-size:17px;font-style:italic;
            color:rgba(243,228,168,.92);letter-spacing:.3px;margin:2px 0 4px;
        }
        .login-form{width:100%;display:flex;flex-direction:column;gap:11px;margin-top:4px}
        .login-form label.lbl{
            display:block;text-align:left;font-size:10px;font-weight:700;letter-spacing:1.4px;
            text-transform:uppercase;color:rgba(212,176,106,.9);margin:0 0 5px 2px;
        }
        .login-form .field{
            display:flex;align-items:center;gap:10px;
            border:1px solid rgba(197,160,89,.35);
            border-radius:11px;padding:11px 13px;
            background:rgba(255,255,255,.06);
            transition:border-color .2s,box-shadow .2s,background .2s;
        }
        .login-form .field:focus-within{
            border-color:rgba(212,176,106,.75);
            background:rgba(255,255,255,.1);
            box-shadow:0 0 0 3px rgba(197,160,89,.18),0 0 20px rgba(197,160,89,.12);
        }
        .login-form .field .fi{color:var(--gold);opacity:.85;font-size:14px;line-height:1}
        .login-form .field input{
            border:none;outline:none;width:100%;min-width:0;
            font:inherit;font-size:14px;color:#fff;background:transparent;
        }
        .login-form .field input::placeholder{color:rgba(255,255,255,.35)}
        .login-statuts{
            display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:8px;
        }
        .login-statut{
            --st:#c5a059;
            position:relative;display:flex;align-items:center;gap:9px;
            width:100%;padding:10px 11px;border-radius:12px;cursor:pointer;
            border:1px solid color-mix(in srgb,var(--st) 45%,transparent);
            background:linear-gradient(135deg,color-mix(in srgb,var(--st) 22%,transparent),rgba(255,255,255,.04));
            color:#fff;text-align:left;font:inherit;
            transition:transform .18s,border-color .18s,box-shadow .18s,background .18s;
        }
        .login-statut:hover{
            transform:translateY(-1px);
            border-color:color-mix(in srgb,var(--st) 75%,#fff);
            box-shadow:0 8px 18px rgba(0,0,0,.22),0 0 18px color-mix(in srgb,var(--st) 28%,transparent);
        }
        .login-statut.is-on{
            border-color:var(--st);
            background:linear-gradient(135deg,color-mix(in srgb,var(--st) 38%,#0a1736),color-mix(in srgb,var(--st) 14%,#071228));
            box-shadow:0 0 0 1px color-mix(in srgb,var(--st) 55%,transparent),0 10px 22px color-mix(in srgb,var(--st) 28%,transparent);
        }
        .login-statut .dot{
            width:10px;height:10px;border-radius:50%;flex-shrink:0;
            background:var(--st);box-shadow:0 0 0 3px color-mix(in srgb,var(--st) 25%,transparent),0 0 12px var(--st);
        }
        .login-statut .meta{display:flex;flex-direction:column;gap:1px;min-width:0}
        .login-statut .meta b{
            font-size:11px;font-weight:700;letter-spacing:.6px;text-transform:uppercase;
            color:#fff;line-height:1.2;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;
        }
        .login-statut .meta small{
            font-size:10px;color:rgba(255,255,255,.62);letter-spacing:.2px;
            white-space:nowrap;overflow:hidden;text-overflow:ellipsis;
        }
        .login-statut.is-on .meta b{color:#fff;text-shadow:0 0 12px color-mix(in srgb,var(--st) 55%,transparent)}
        .login-statut[data-key="direction"]{--st:#e0b43a}
        .login-statut[data-key="administration"]{--st:#5b8def}
        .login-statut[data-key="reception"]{--st:#2fa864}
        .login-statut[data-key="commercial"]{--st:#e07a3b}
        .login-statut[data-key="housekeeping"]{--st:#8b7cf6}
        .login-statut[data-key="technique"]{--st:#2eb7c9}
        .mega-error{
            width:100%;background:rgba(180,40,40,.18);color:#ffb4b4;
            border:1px solid rgba(240,120,120,.35);padding:9px 11px;border-radius:9px;
            font-size:12px;text-align:center;line-height:1.35;
        }
        .mega-btn{
            width:100%;margin-top:4px;
            background:linear-gradient(135deg,#e0b43a,#c5a059 45%,#d4b06a);
            color:#1a1304;font-weight:700;letter-spacing:1.4px;text-transform:uppercase;font-size:12px;
            padding:13px;border:none;border-radius:11px;cursor:pointer;
            box-shadow:0 8px 22px rgba(197,160,89,.35);
            transition:transform .2s,box-shadow .2s;
        }
        .mega-btn:hover{transform:translateY(-1px);box-shadow:0 12px 28px rgba(197,160,89,.45)}
        .login-credit{
            margin-top:8px;font-size:10px;letter-spacing:.6px;text-transform:uppercase;
            color:rgba(185,191,208,.72);line-height:1.5;
        }
        .login-credit b{color:rgba(212,176,106,.85);font-weight:600}
        @media(max-width:480px){
            .mega{padding:24px 18px 18px;width:min(100%,94vw)}
            .login-logo{width:64px;height:64px}
            .login-statuts{grid-template-columns:1fr}
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
<body class="@if(request()->routeIs('home')) page-home @elseif(request()->routeIs('chambres')) page-chambres @endif @if(!empty($habillage['saved'])) hb-on @endif @if(request()->boolean('hb-edit')) hb-edit @endif"@if(!empty($habillage)) style="--hb-image:url('{{ $habillage['image_url'] }}');--hb-color:{{ $habillage['color'] }};--hb-light:{{ $habillage['light_ratio'] }};--hb-veil:{{ $habillage['veil_css'] }};--hb-title:{{ $habillage['title_color'] }};"@endif>
<script>
(function(){
    if(navigator.serviceWorker){
        navigator.serviceWorker.getRegistrations().then(function(regs){
            regs.forEach(function(r){r.unregister();});
        });
    }
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

    <button type="button" class="admin-fab" id="adminToggle" title="Connexion" aria-label="Connexion" aria-expanded="false" aria-controls="adminMega">&#128100;</button>
    <div class="mega-veil {{ session('login_error') ? 'open' : '' }}" id="adminVeil" @if(!session('login_error')) hidden @endif></div>
    @php
        $loginSpaces = [
            'direction' => ['label' => 'Direction', 'hint' => 'Pilotilotage hôtel', 'space' => 'admin'],
            'administration' => ['label' => 'Administration', 'hint' => 'Bureau & gestion', 'space' => 'administration'],
            'reception' => ['label' => 'Réception', 'hint' => 'Accueil clients', 'space' => 'admin'],
            'commercial' => ['label' => 'S. Commercial', 'hint' => 'Ventes & résas', 'space' => 'commercial'],
            'housekeeping' => ['label' => 'House Keeping', 'hint' => 'Étages & ménage', 'space' => 'admin'],
            'technique' => ['label' => 'S. Technique', 'hint' => 'Maintenance', 'space' => 'commercial'],
        ];
        $loginErrorSpace = session('login_space');
        $loginSelected = collect($loginSpaces)->search(fn ($s) => $s['space'] === $loginErrorSpace) ?: 'direction';
        $loginAction = route('space.login', $loginSpaces[$loginSelected]['space'] ?? 'admin');
    @endphp
    <div class="mega {{ session('login_error') ? 'open' : '' }}" id="adminMega" role="dialog" aria-modal="true" aria-labelledby="loginTitle">
        <div class="login-panel">
            <img class="login-logo" src="{{ asset('apple-touch-icon.png') }}" alt="Al Jazeera Hotel" width="72" height="72">
            <div class="login-mark">
                <div class="stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                <h2 class="login-title" id="loginTitle">Al Jazeera<span>Hotel</span></h2>
            </div>
            <p class="login-welcome">Bienvenus sur Aljazeera-Hotel</p>
            <form class="login-form js-nomem-login" id="spaceLoginForm" method="POST" action="{{ $loginAction }}" autocomplete="off" data-lpignore="true" data-1p-ignore data-form-type="other">
                @csrf
                <input type="hidden" name="login" value="">
                <input type="hidden" name="password" value="">
                <input type="hidden" id="login_statut" name="statut_ui" value="{{ $loginSelected }}">
                @if(session('login_error'))
                    <p class="mega-error">{{ session('login_error') }}</p>
                @endif
                <div>
                    <span class="lbl">Statut</span>
                    <div class="login-statuts" role="radiogroup" aria-label="Choisir un statut">
                        @foreach($loginSpaces as $key => $space)
                            <button type="button"
                                class="login-statut{{ $loginSelected === $key ? ' is-on' : '' }}"
                                data-key="{{ $key }}"
                                data-space="{{ $space['space'] }}"
                                role="radio"
                                aria-checked="{{ $loginSelected === $key ? 'true' : 'false' }}">
                                <span class="dot" aria-hidden="true"></span>
                                <span class="meta">
                                    <b>{{ $space['label'] }}</b>
                                    <small>{{ $space['hint'] }}</small>
                                </span>
                            </button>
                        @endforeach
                    </div>
                </div>
                <div>
                    <label class="lbl" for="login_user">Login</label>
                    <label class="field">
                        <span class="fi" aria-hidden="true">&#128100;</span>
                        <input id="login_user" type="text" class="js-nomem-user" value="" placeholder="Identifiant" autocomplete="off" autocapitalize="off" spellcheck="false" readonly data-lpignore="true" data-1p-ignore required>
                    </label>
                </div>
                <div>
                    <label class="lbl" for="login_pass">Mot de passe</label>
                    <label class="field">
                        <span class="fi" aria-hidden="true">&#128274;</span>
                        <input id="login_pass" type="password" class="js-nomem-pass" value="" placeholder="Mot de passe" autocomplete="new-password" readonly data-lpignore="true" data-1p-ignore required>
                    </label>
                </div>
                <button type="submit" class="mega-btn">Se connecter</button>
            </form>
            <p class="login-credit">créé par <b>A2SPRO2026</b> — tous droits réservés</p>
        </div>
    </div>
    <script>
    (function(){
        const form=document.getElementById('spaceLoginForm');
        const statut=document.getElementById('login_statut');
        const chips=[...document.querySelectorAll('.login-statut')];
        const routes={
            @foreach($loginSpaces as $key => $space)
            {{ $key }}:@json(route('space.login', $space['space'])),
            @endforeach
        };
        const syncAction=()=>{
            if(!form||!statut)return;
            form.action=routes[statut.value]||routes.direction;
        };
        const selectStatut=key=>{
            if(!routes[key])return;
            if(statut)statut.value=key;
            chips.forEach(btn=>{
                const on=btn.dataset.key===key;
                btn.classList.toggle('is-on',on);
                btn.setAttribute('aria-checked',on?'true':'false');
            });
            syncAction();
        };
        chips.forEach(btn=>btn.addEventListener('click',()=>selectStatut(btn.dataset.key)));
        syncAction();
        const wipe=all=>{
            if(!form)return;
            form.querySelectorAll('input:not([name="_token"]):not([type="hidden"])').forEach(i=>{
                if(!all&&i.dataset.touched)return;
                i.value='';
                i.setAttribute('readonly','');
                delete i.dataset.touched;
            });
        };
        if(form){
            const u=form.querySelector('.js-nomem-user'),p=form.querySelector('.js-nomem-pass');
            [u,p].forEach(i=>{
                if(!i)return;
                const unlock=()=>{i.removeAttribute('readonly');i.dataset.touched='1';};
                ['pointerdown','touchstart','focus'].forEach(ev=>i.addEventListener(ev,unlock,{passive:true}));
            });
            form.addEventListener('submit',e=>{
                syncAction();
                if(!u.value.trim()||!p.value){e.preventDefault();const t=u.value.trim()?p:u;t.removeAttribute('readonly');t.focus();return;}
                form.querySelector('input[name="login"]').value=u.value;
                form.querySelector('input[name="password"]').value=p.value;
                u.value='';p.value='';
            });
        }
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
        const adminVeil=document.getElementById('adminVeil');
        function setLoginOpen(open){
            if(!adminMega)return;
            adminMega.classList.toggle('open',open);
            adminToggle?.classList.toggle('is-open',open);
            adminToggle?.setAttribute('aria-expanded',open?'true':'false');
            if(adminVeil){
                adminVeil.classList.toggle('open',open);
                adminVeil.hidden=!open;
            }
            if(open){
                const first=adminMega.querySelector('.login-statut.is-on, .js-nomem-user');
                setTimeout(()=>first?.focus(),50);
            }
        }
        if(adminToggle&&adminMega){
            if(adminMega.classList.contains('open'))setLoginOpen(true);
            adminToggle.addEventListener('click',(e)=>{
                e.preventDefault();
                e.stopPropagation();
                setLoginOpen(!adminMega.classList.contains('open'));
            });
            adminVeil?.addEventListener('click',()=>setLoginOpen(false));
            document.addEventListener('click',(e)=>{
                if(!adminMega.classList.contains('open'))return;
                if(!adminMega.contains(e.target)&&!adminToggle.contains(e.target))setLoginOpen(false);
            });
            document.addEventListener('keydown',(e)=>{
                if(e.key==='Escape')setLoginOpen(false);
            });
        }
    </script>
    @stack('scripts')
</body>
</html>
