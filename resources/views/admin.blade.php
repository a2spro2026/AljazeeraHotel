<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Direction — Al Jazeera Hotel</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root{--navy:#0a1736;--navy-deep:#060f24;--panel:#0d1b3d;--gold:#c9a227;--gold-light:#e6c75a;--cream:#f5f1e6;--muted:#aab0c4;}
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Montserrat',sans-serif;background:var(--navy-deep);color:var(--cream)}
        a{text-decoration:none;color:inherit}
        .serif{font-family:'Cormorant Garamond',serif}
        .admin-wrap{display:flex;min-height:100vh}

        /* SIDEBAR */
        .sidebar{
            width:268px;flex-shrink:0;background:linear-gradient(180deg,var(--navy),var(--navy-deep));
            border-right:1px solid rgba(201,162,39,.18);display:flex;flex-direction:column;
            position:fixed;top:0;bottom:0;left:0;z-index:40;transition:transform .3s ease;
        }
        .sb-brand{display:flex;align-items:center;gap:12px;padding:20px 22px;border-bottom:1px solid rgba(201,162,39,.15)}
        .sb-brand img{height:46px;width:auto;border-radius:8px;box-shadow:0 0 14px rgba(201,162,39,.5)}
        .sb-brand b{font-size:16px;letter-spacing:2px;color:#fff;display:block}
        .sb-brand span{font-size:11px;letter-spacing:3px;color:var(--gold)}
        .sb-nav{flex:1;overflow-y:auto;padding:14px 12px;display:flex;flex-direction:column;gap:4px}
        .sb-item{
            display:flex;align-items:center;gap:13px;padding:12px 15px;border-radius:10px;
            color:var(--cream);font-size:14px;cursor:pointer;border:1px solid transparent;transition:all .2s ease;
            position:relative;
        }
        .sb-item .ic{font-size:18px;width:22px;text-align:center}
        .sb-item::after{
            content:'\203A';position:absolute;right:14px;top:50%;
            transform:translateY(-50%) translateX(-6px);opacity:0;
            font-size:18px;font-weight:700;color:var(--gold);transition:all .25s ease;
        }
        .sb-item:hover::after{opacity:.8;transform:translateY(-50%) translateX(0)}
        .sb-item.active::after{opacity:1;transform:translateY(-50%) translateX(0);color:#1a1304}
        .sb-item:hover{background:rgba(201,162,39,.08);border-color:rgba(201,162,39,.2)}
        .sb-item.active{
            background:linear-gradient(135deg,var(--gold),var(--gold-light));color:#1a1304;font-weight:600;
            box-shadow:0 0 18px rgba(201,162,39,.45);
        }
        .sb-parent{display:flex;align-items:center;gap:13px;padding:12px 15px;border-radius:10px;color:var(--cream);font-size:14px;cursor:pointer;border:1px solid transparent;transition:all .2s}
        .sb-parent .ic{font-size:18px;width:22px;text-align:center}
        .sb-parent:hover{background:rgba(201,162,39,.08);border-color:rgba(201,162,39,.2)}
        .sb-parent .caret{margin-left:auto;width:24px;height:24px;display:flex;align-items:center;justify-content:center;border-radius:50%;background:rgba(201,162,39,.15);border:1px solid rgba(201,162,39,.45);font-size:11px;color:var(--gold);transition:transform .3s ease,background .2s ease;box-shadow:0 0 8px rgba(201,162,39,.3)}
        .sb-parent.expanded{background:rgba(201,162,39,.1);border-color:rgba(201,162,39,.25)}
        .sb-parent.expanded .caret{transform:rotate(180deg)}
        .sb-parent.active{background:linear-gradient(135deg,var(--gold),var(--gold-light));color:#1a1304;font-weight:600;box-shadow:0 0 18px rgba(201,162,39,.45)}
        .sb-parent.active .caret{color:#1a1304;background:rgba(26,19,4,.15);border-color:rgba(26,19,4,.35)}
        .sb-sub{display:flex;flex-direction:column;gap:4px;overflow:hidden;max-height:0;transition:max-height .3s ease;padding-left:12px;margin-top:2px}
        .sb-sub.open{max-height:320px}
        .sb-sub .sb-item{font-size:13px;padding:10px 14px}
        .sb-sub .sb-item .ic{font-size:16px}
        .sb-foot{padding:16px;border-top:1px solid rgba(201,162,39,.15)}
        .logout-btn{width:100%;background:transparent;border:1px solid rgba(230,80,80,.5);color:#f0a3a3;
            padding:11px;border-radius:8px;font-size:12px;letter-spacing:1px;text-transform:uppercase;cursor:pointer;transition:all .2s}
        .logout-btn:hover{background:rgba(230,80,80,.12)}

        /* MAIN */
        .main{flex:1;margin-left:268px;display:flex;flex-direction:column;min-width:0}
        .topbar{
            display:flex;align-items:center;justify-content:space-between;gap:16px;
            padding:18px 30px;background:rgba(10,23,54,.7);backdrop-filter:blur(8px);
            border-bottom:1px solid rgba(201,162,39,.15);position:sticky;top:0;z-index:30;
        }
        .topbar h1{font-size:22px;color:#fff;font-weight:600}
        .topbar .who{display:flex;align-items:center;gap:12px}
        .topbar .who img{width:42px;height:42px;border-radius:50%;object-fit:cover;border:2px solid var(--gold)}
        .topbar .who b{font-size:14px;color:#fff;display:block}
        .topbar .who span{font-size:11px;color:var(--gold);text-transform:uppercase;letter-spacing:1px}
        .hamb{display:none;background:none;border:none;color:var(--gold);font-size:24px;cursor:pointer}
        .content{padding:30px;flex:1}

        .panel{display:none;animation:fade .35s ease}
        .panel.active{display:block}
        @keyframes fade{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)}}
        .panel h2{font-family:'Cormorant Garamond',serif;font-size:30px;color:#fff;margin-bottom:6px}
        .panel .sub{color:var(--muted);font-size:14px;margin-bottom:26px}

        .cards{display:grid;grid-template-columns:repeat(auto-fit,minmax(190px,1fr));gap:18px;margin-bottom:30px}
        .card{background:var(--panel);border:1px solid rgba(201,162,39,.15);border-radius:14px;padding:22px}
        .card .n{font-family:'Cormorant Garamond',serif;font-size:34px;color:var(--gold);line-height:1}
        .card .l{color:var(--muted);font-size:12px;text-transform:uppercase;letter-spacing:1px;margin-top:6px}

        /* DASHBOARD CHARTS */
        .dash-charts{display:grid;grid-template-columns:repeat(auto-fit,minmax(320px,1fr));gap:22px;margin-bottom:22px}
        .chart-box{background:var(--panel);border:1px solid rgba(201,162,39,.15);border-radius:14px;padding:22px}
        .chart-box h3{font-size:16px;color:#fff;margin-bottom:16px;letter-spacing:.5px}
        .chart-box .cv{position:relative;height:280px}

        .block{background:var(--panel);border:1px solid rgba(201,162,39,.15);border-radius:14px;padding:22px;margin-bottom:22px}
        .block h3{font-size:16px;color:#fff;margin-bottom:16px;letter-spacing:.5px}
        table{width:100%;border-collapse:collapse}
        th,td{padding:12px 14px;text-align:left;font-size:13.5px;border-bottom:1px solid rgba(255,255,255,.06)}
        th{color:var(--gold);text-transform:uppercase;font-size:11px;letter-spacing:1px}
        td{color:var(--cream)}
        tr:last-child td{border-bottom:none}
        .tag{padding:3px 11px;border-radius:20px;font-size:11px;white-space:nowrap}
        .tag.ok{background:rgba(80,200,120,.15);color:#7fd99b}
        .tag.warn{background:rgba(230,199,90,.15);color:var(--gold-light)}
        .tag.bad{background:rgba(230,120,120,.15);color:#e89}
        .btn-gold{background:linear-gradient(135deg,var(--gold),var(--gold-light));color:#1a1304;border:none;
            padding:10px 18px;border-radius:8px;font-weight:600;font-size:12px;letter-spacing:.5px;cursor:pointer;text-transform:uppercase}
        .row-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;flex-wrap:wrap;gap:10px}

        /* SUB-TABS & FORMS (Fournisseur) */
        .subtabs{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:22px;border-bottom:1px solid rgba(201,162,39,.15);padding-bottom:12px}
        .subtab{background:rgba(255,255,255,.03);border:1px solid rgba(201,162,39,.2);color:var(--cream);padding:10px 16px;border-radius:8px;font-size:13px;cursor:pointer;transition:all .2s}
        .subtab:hover{border-color:var(--gold)}
        .subtab.active{background:linear-gradient(135deg,var(--gold),var(--gold-light));color:#1a1304;font-weight:600;box-shadow:0 0 14px rgba(201,162,39,.4)}
        .subpanel{display:none}
        .subpanel.active{display:block;animation:fade .3s ease}
        .form-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(170px,1fr));gap:14px;margin-bottom:16px}
        .form-flex{display:flex;flex-wrap:wrap;gap:14px;margin-bottom:4px}
        .form-flex .field{display:flex;flex-direction:column;margin-bottom:0}
        .ibtn{background:transparent;border:1px solid rgba(201,162,39,.3);color:var(--cream);width:32px;height:32px;border-radius:7px;cursor:pointer;font-size:14px;margin-right:5px;transition:all .2s}
        .ibtn:hover{border-color:var(--gold);color:var(--gold);background:rgba(201,162,39,.12)}
        .ibtn.del:hover{border-color:#e89;color:#e89;background:rgba(230,120,120,.12)}
        .actions{display:flex;gap:10px;flex-wrap:wrap;margin:6px 0 4px}
        .btn{border:none;cursor:pointer;padding:10px 18px;border-radius:8px;font-size:12px;font-weight:600;letter-spacing:.5px;text-transform:uppercase;transition:all .2s}
        .btn.gold{background:linear-gradient(135deg,var(--gold),var(--gold-light));color:#1a1304}
        .btn.ghost{background:transparent;border:1px solid rgba(201,162,39,.4);color:var(--gold)}
        .btn:hover{transform:translateY(-2px);box-shadow:0 6px 16px rgba(201,162,39,.3)}
        .tbtn{background:transparent;border:1px solid rgba(201,162,39,.3);color:var(--cream);padding:5px 10px;border-radius:6px;font-size:11px;cursor:pointer;margin-right:4px;transition:all .2s}
        .tbtn:hover{border-color:var(--gold);color:var(--gold)}
        .tbtn.del:hover{border-color:#e89;color:#e89}
        .table-wrap{overflow-x:auto}
        .empty-row td{text-align:center;color:var(--muted);padding:22px}
        .bal-list{display:flex;flex-direction:column;gap:8px;margin:6px 0 16px}
        .bal-row{display:flex;align-items:center;gap:14px;flex-wrap:wrap;background:rgba(0,0,0,.2);border:1px solid rgba(201,162,39,.15);border-radius:10px;padding:12px 14px}
        .bal-row label.chk{display:flex;align-items:center;gap:8px;font-size:14px;color:#fff;min-width:180px}
        .bal-row .mnt{color:var(--cream);font-weight:600;font-size:14px;min-width:130px}
        .bal-row .sld{color:var(--gold);font-weight:600;font-size:14px;min-width:130px}
        .bal-row input.pay{width:130px;background:rgba(0,0,0,.25);border:1px solid rgba(201,162,39,.2);border-radius:7px;padding:8px 10px;color:var(--cream);font-size:13px;outline:none}
        .hint{font-size:12px;color:var(--muted);margin-bottom:10px}

        .cfg-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:18px}
        .field{margin-bottom:14px}
        .field label{display:block;font-size:12px;color:var(--muted);margin-bottom:6px;text-transform:uppercase;letter-spacing:1px}
        .field input,.field select{width:100%;background:rgba(0,0,0,.25);border:1px solid rgba(201,162,39,.2);
            border-radius:8px;padding:11px 13px;color:var(--cream);font-family:inherit;font-size:14px;outline:none}
        .field input:focus,.field select:focus{border-color:var(--gold)}

        .overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:35}

        @media(max-width:900px){
            .sidebar{transform:translateX(-100%)}
            .sidebar.open{transform:translateX(0)}
            .main{margin-left:0}
            .hamb{display:block}
            .overlay.show{display:block}
        }
    </style>
</head>
<body>
<div class="admin-wrap">
    <aside class="sidebar" id="sidebar">
        <div class="sb-brand">
            <img src="{{ asset('images/logo.png') }}" alt="logo">
            <div><b>DIRECTION</b><span>Al Jazeera</span></div>
        </div>
        <nav class="sb-nav" id="sbNav">
            <div class="sb-item active" data-target="dashboard"><span class="ic">&#128202;</span> Tableau de bord</div>
            <div class="sb-parent" id="frnsParent"><span class="ic">&#128666;</span> Fournisseur <span class="caret">&#9662;</span></div>
            <div class="sb-sub" id="frnsSub">
                <div class="sb-item" data-target="fiche"><span class="ic">&#128209;</span> Fiche fournisseur</div>
                <div class="sb-item" data-target="bon"><span class="ic">&#128722;</span> Bon Achats</div>
                <div class="sb-item" data-target="regl"><span class="ic">&#128179;</span> Règlement Achats</div>
                <div class="sb-item" data-target="balance"><span class="ic">&#9878;</span> Balance</div>
            </div>
            <div class="sb-item" data-target="stock"><span class="ic">&#128230;</span> Stock</div>
            <div class="sb-item" data-target="facturation"><span class="ic">&#129534;</span> Facturation</div>
            <div class="sb-item" data-target="chambres"><span class="ic">&#128719;</span> Gestion Chambres</div>
            <div class="sb-item" data-target="personnels"><span class="ic">&#128101;</span> Personnels</div>
            <div class="sb-item" data-target="paies"><span class="ic">&#128176;</span> Gestion des Paies</div>
            <div class="sb-item" data-target="tresorerie"><span class="ic">&#127974;</span> Trésorerie</div>
            <div class="sb-item" data-target="charges"><span class="ic">&#128202;</span> Charges</div>
            <div class="sb-item" data-target="configuration"><span class="ic">&#9881;</span> Configuration</div>
        </nav>
        <div class="sb-foot">
            <form method="POST" action="{{ route('space.logout', 'admin') }}">
                @csrf
                <button type="submit" class="logout-btn">Déconnexion</button>
            </form>
        </div>
    </aside>

    <div class="overlay" id="overlay"></div>

    <div class="main">
        <div class="topbar">
            <div style="display:flex;align-items:center;gap:14px">
                <button class="hamb" id="hamb">&#9776;</button>
                <h1 id="pageTitle">Tableau de bord</h1>
            </div>
            <div class="who">
                <div style="text-align:right"><b>Direction</b><span>Général</span></div>
                @if(file_exists(public_path('images/profile.png')))
                    <img src="{{ asset('images/profile.png') }}" alt="profil">
                @endif
            </div>
        </div>

        <div class="content">

            {{-- TABLEAU DE BORD --}}
            <section class="panel active" id="dashboard">
                <h2 class="serif">Tableau de bord</h2>
                <p class="sub">Vue d'ensemble — Direction générale</p>
                <div class="cards">
                    <div class="card"><div class="n" id="kpiFrns">0</div><div class="l">Fournisseurs</div></div>
                    <div class="card"><div class="n" id="kpiBons">0</div><div class="l">Bons d'achats</div></div>
                    <div class="card"><div class="n" id="kpiAchats">0,00 DH</div><div class="l">Total achats</div></div>
                    <div class="card"><div class="n" id="kpiRegle">0,00 DH</div><div class="l">Total réglé</div></div>
                    <div class="card"><div class="n" id="kpiSolde">0,00 DH</div><div class="l">Solde fournisseurs</div></div>
                </div>
                <div class="dash-charts">
                    <div class="chart-box"><h3>Achats vs Règlements (par mois)</h3><div class="cv"><canvas id="chartFlux"></canvas></div></div>
                    <div class="chart-box"><h3>Solde par fournisseur</h3><div class="cv"><canvas id="chartSolde"></canvas></div></div>
                </div>
                <div class="block">
                    <h3>Derniers bons d'achats</h3>
                    <div class="table-wrap">
                        <table>
                            <thead><tr><th>Date</th><th>Fournisseur</th><th>Réf</th><th>Désignation</th><th>Montant</th></tr></thead>
                            <tbody id="dashBons"></tbody>
                        </table>
                    </div>
                </div>
                <div class="block">
                    <h3>Derniers règlements</h3>
                    <div class="table-wrap">
                        <table>
                            <thead><tr><th>Date</th><th>Réf</th><th>Fournisseur</th><th>Type</th><th>Montant payé</th></tr></thead>
                            <tbody id="dashRegls"></tbody>
                        </table>
                    </div>
                </div>
            </section>

            {{-- FOURNISSEUR (FICHE) --}}
            <section class="panel" id="fiche">
                <div class="block">
                    <div style="display:flex;align-items:flex-end;justify-content:space-between;gap:14px;flex-wrap:wrap;margin-bottom:18px">
                        <div class="field" style="flex:0 0 190px;margin:0"><label>Date Création</label><input type="date" id="ff_date"></div>
                        <div class="actions" style="margin:0">
                            <button class="btn gold" onclick="FRNS.saveFiche()">Valider</button>
                            <button class="btn ghost" onclick="FRNS.newFiche()">Ajouter</button>
                        </div>
                    </div>
                    <div class="form-flex">
                        <div class="field" style="flex:0 0 92px"><label>ID</label><input type="text" id="ff_id" placeholder="FR0001"></div>
                        <div class="field" style="flex:3 1 240px"><label>Nom</label><input type="text" id="ff_nom" placeholder="Nom fournisseur"></div>
                        <div class="field" style="flex:1 1 150px"><label>Contact</label><input type="text" id="ff_contact" placeholder="Téléphone / email"></div>
                        <div class="field" style="flex:1 1 130px"><label>Ville</label><input type="text" id="ff_ville" placeholder="Ville"></div>
                        <div class="field" style="flex:3 1 240px"><label>Adresse</label><input type="text" id="ff_adresse" placeholder="Adresse"></div>
                        <div class="field" style="flex:1 1 140px"><label>Règlement</label>
                            <select id="ff_reglement"><option>Espèces</option><option>Chèque</option><option>Effet</option><option>Virement</option><option>Versement</option></select>
                        </div>
                        <div class="field" style="flex:1 1 130px"><label>Echéance</label><input type="text" id="ff_echeance" placeholder="Ex: 30 jours"></div>
                        <div class="field" style="flex:1 1 130px"><label>Solde Initial</label><input type="number" id="ff_solde" placeholder="0" step="0.01"></div>
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
            </section>

            {{-- BON ACHATS --}}
            <section class="panel" id="bon">
                <h2 class="serif">Bon Achats</h2>
                <p class="sub">Saisie des bons d'achats fournisseurs</p>
                <div>
                    <div class="block">
                        <h3>Bon d'achat</h3>
                        <div class="form-flex">
                            <div class="field" style="flex:1 1 150px"><label>Date</label><input type="date" id="ba_date"></div>
                            <div class="field" style="flex:3 1 240px"><label>Fournisseur</label><select id="ba_frns" data-frns-select></select></div>
                            <div class="field" style="flex:0 0 110px"><label>Réf</label><input type="text" id="ba_ref" placeholder="N° bon"></div>
                            <div class="field" style="flex:3 1 240px"><label>Désignation</label><input type="text" id="ba_desig" placeholder="Article"></div>
                            <div class="field" style="flex:0 0 90px"><label>Qté</label><input type="number" id="ba_qte" placeholder="0" step="1" oninput="FRNS.calcSousTotal()"></div>
                            <div class="field" style="flex:0 0 110px"><label>Prix U</label><input type="number" id="ba_prix" placeholder="0.00" step="0.01" oninput="FRNS.calcSousTotal()" onblur="FRNS.fmtPrix()"></div>
                            <div class="field" style="flex:0 0 120px"><label>Sous-Total</label><input type="text" id="ba_st" placeholder="0.00" readonly></div>
                        </div>
                        <div class="actions">
                            <button class="btn gold" onclick="FRNS.addBon()">Ajouter</button>
                            <button class="btn ghost" onclick="FRNS.newBon()">Valider</button>
                            <button class="btn ghost" onclick="FRNS.print('ba_table','Bons d\'achats')">Imprimer</button>
                            <button class="btn ghost" onclick="FRNS.csv('ba_table','bons_achats.csv')">Exporter</button>
                        </div>
                    </div>
                    <div class="block">
                        <h3>Liste des bons d'achats</h3>
                        <div class="table-wrap">
                            <table id="ba_table">
                                <thead><tr><th>Date</th><th>Fournisseur</th><th>Réf</th><th>Désignation</th><th>Qté</th><th>Prix U</th><th>Sous-Total</th><th class="no-print">Actions</th></tr></thead>
                                <tbody id="ba_tbody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

            {{-- REGLEMENT ACHATS --}}
            <section class="panel" id="regl">
                <div>
                    <div class="block">
                        <div class="actions" style="margin:0 0 16px">
                            <button class="btn gold" onclick="FRNS.addReglement()">Valider le règlement</button>
                            <button class="btn ghost" onclick="FRNS.newReglement()">Ajouter Règl</button>
                            <button class="btn ghost" onclick="FRNS.print('ra_table','Règlements achats')">Imprimer</button>
                            <button class="btn ghost" onclick="FRNS.csv('ra_table','reglements.csv')">Exporter</button>
                        </div>
                        <div class="form-flex">
                            <div class="field" style="flex:1 1 150px"><label>Date</label><input type="date" id="ra_date"></div>
                            <div class="field" style="flex:0 0 90px"><label>Réf</label><input type="text" id="ra_ref" placeholder="Auto" readonly></div>
                            <div class="field" style="flex:0 0 130px"><label>Type</label>
                                <select id="ra_type"><option value="Esp">Espèces</option><option value="Chq">Chèque</option><option value="Eff">Effet</option><option value="Vir">Virement</option><option value="Vers">Versement</option></select>
                            </div>
                            <div class="field" style="flex:0 0 100px"><label>N° Règl</label><input type="text" id="ra_num" placeholder="N°"></div>
                            <div class="field" style="flex:0 0 140px"><label>Banque</label>
                                <select id="ra_banq"><option value="">—</option><option value="AWB">AWB</option><option value="BP">BP</option><option value="BMCE">BMCE</option><option value="BMCI">BMCI</option><option value="CIH">CIH</option><option value="SG">SG</option><option value="AKHDAR BNQ">AKHDAR BNQ</option><option value="OUMNIA">OUMNIA</option><option value="BARID">BARID</option></select>
                            </div>
                            <div class="field" style="flex:3 1 260px"><label>Nom Tiré</label><input type="text" id="ra_tire" placeholder="Nom tiré"></div>
                            <div class="field" style="flex:1 1 150px"><label>Date décaiss.</label><input type="date" id="ra_decaiss"></div>
                            <div class="field" style="flex:2 1 200px"><label>Fournisseur</label><select id="ra_frns" data-frns-select><option value="">— Tous —</option></select></div>
                        </div>
                        <p class="hint">Cochez le(s) fournisseur(s) à solder et saisissez le montant payé :</p>
                        <div class="bal-list" id="ra_balances"></div>
                    </div>
                    <div class="block">
                        <h3>Liste des règlements</h3>
                        <div class="table-wrap">
                            <table id="ra_table">
                                <thead><tr><th>Date</th><th>Réf</th><th>Nom Fournisseur</th><th>Mnt Bon</th><th>Règlement</th><th>Date Décaiss</th><th>Mnt Payé</th><th>Solde</th><th class="no-print">Actions</th></tr></thead>
                                <tbody id="ra_tbody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

            {{-- BALANCE --}}
            <section class="panel" id="balance">
                <h2 class="serif">Balance</h2>
                <p class="sub">Balance des fournisseurs</p>
                <div>
                    <div class="block">
                        <div class="row-head"><h3>Balance fournisseurs</h3>
                            <div class="actions" style="margin:0">
                                <button class="btn ghost" onclick="FRNS.print('bl_table','Balance fournisseurs')">Imprimer</button>
                                <button class="btn ghost" onclick="FRNS.csv('bl_table','balance.csv')">Exporter</button>
                            </div>
                        </div>
                        <div class="table-wrap">
                            <table id="bl_table">
                                <thead><tr><th>Date Bon</th><th>Nom Fournisseur</th><th>Type Règlement</th><th>Montant</th><th>Montant Payé</th><th>Solde</th></tr></thead>
                                <tbody id="bl_tbody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </section>

            {{-- STOCK --}}
            <section class="panel" id="stock">
                <h2 class="serif">Stock</h2>
                <p class="sub">Inventaire et suivi des articles</p>
                <div class="cards">
                    <div class="card"><div class="n">512</div><div class="l">Articles en stock</div></div>
                    <div class="card"><div class="n">14</div><div class="l">En rupture</div></div>
                    <div class="card"><div class="n">28</div><div class="l">Seuil critique</div></div>
                    <div class="card"><div class="n">142 000 DH</div><div class="l">Valeur du stock</div></div>
                </div>
                <div class="block">
                    <div class="row-head"><h3>Articles</h3><button class="btn-gold">+ Entrée stock</button></div>
                    <table>
                        <thead><tr><th>Article</th><th>Catégorie</th><th>Quantité</th><th>Seuil</th><th>État</th></tr></thead>
                        <tbody>
                            @foreach([['Serviettes de bain','Linge','320','100','ok'],['Savon liquide (L)','Hygiène','18','40','bad'],['Café (kg)','Cuisine','45','30','ok'],['Eau minérale (pack)','Boisson','12','25','bad'],['Draps king size','Linge','86','60','warn']] as $r)
                            <tr><td>{{ $r[0] }}</td><td>{{ $r[1] }}</td><td>{{ $r[2] }}</td><td>{{ $r[3] }}</td>
                            <td><span class="tag {{ $r[4] }}">{{ ['ok'=>'Suffisant','warn'=>'À surveiller','bad'=>'Rupture'][$r[4]] }}</span></td></tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            {{-- FACTURATION --}}
            <section class="panel" id="facturation">
                <h2 class="serif">Facturation</h2>
                <p class="sub">Factures clients et encaissements</p>
                <div class="cards">
                    <div class="card"><div class="n">284 500 DH</div><div class="l">Chiffre du mois</div></div>
                    <div class="card"><div class="n">112</div><div class="l">Factures payées</div></div>
                    <div class="card"><div class="n">9</div><div class="l">Impayées</div></div>
                    <div class="card"><div class="n">18 200 DH</div><div class="l">En attente</div></div>
                </div>
                <div class="block">
                    <div class="row-head"><h3>Dernières factures</h3><button class="btn-gold">+ Nouvelle facture</button></div>
                    <table>
                        <thead><tr><th>N°</th><th>Client</th><th>Date</th><th>Montant</th><th>Statut</th></tr></thead>
                        <tbody>
                            @foreach([['FAC-1042','Ahmed Benali','12/07/2026','6 600 DH','ok'],['FAC-1043','Sara Idrissi','13/07/2026','750 DH','bad'],['FAC-1044','Youssef Alami','18/07/2026','4 400 DH','ok'],['FAC-1045','Fatima Zahra','20/07/2026','4 750 DH','bad']] as $r)
                            <tr><td>{{ $r[0] }}</td><td>{{ $r[1] }}</td><td>{{ $r[2] }}</td><td>{{ $r[3] }}</td>
                            <td><span class="tag {{ $r[4] }}">{{ $r[4]==='ok'?'Payée':'Impayée' }}</span></td></tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            {{-- GESTION CHAMBRES --}}
            <section class="panel" id="chambres">
                <h2 class="serif">Gestion des Chambres</h2>
                <p class="sub">État et disponibilité des chambres</p>
                <div class="cards">
                    <div class="card"><div class="n">60</div><div class="l">Chambres totales</div></div>
                    <div class="card"><div class="n">42</div><div class="l">Occupées</div></div>
                    <div class="card"><div class="n">14</div><div class="l">Disponibles</div></div>
                    <div class="card"><div class="n">4</div><div class="l">En maintenance</div></div>
                </div>
                <div class="block">
                    <div class="row-head"><h3>Chambres</h3><button class="btn-gold">+ Ajouter une chambre</button></div>
                    <table>
                        <thead><tr><th>N°</th><th>Type</th><th>Étage</th><th>Tarif / nuit</th><th>État</th></tr></thead>
                        <tbody>
                            @foreach([['101','Standard','1','450 DH','bad'],['205','Deluxe','2','750 DH','ok'],['301','Suite Junior','3','1 100 DH','ok'],['410','Suite Royale','4','3 000 DH','warn'],['115','Familiale','1','950 DH','bad']] as $r)
                            <tr><td>{{ $r[0] }}</td><td>{{ $r[1] }}</td><td>{{ $r[2] }}</td><td>{{ $r[3] }}</td>
                            <td><span class="tag {{ $r[4] }}">{{ ['ok'=>'Disponible','warn'=>'Maintenance','bad'=>'Occupée'][$r[4]] }}</span></td></tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            {{-- PERSONNELS --}}
            <section class="panel" id="personnels">
                <h2 class="serif">Personnels</h2>
                <p class="sub">Gestion des employés de l'hôtel</p>
                <div class="cards">
                    <div class="card"><div class="n">48</div><div class="l">Employés</div></div>
                    <div class="card"><div class="n">41</div><div class="l">Présents</div></div>
                    <div class="card"><div class="n">5</div><div class="l">En congé</div></div>
                    <div class="card"><div class="n">2</div><div class="l">Absents</div></div>
                </div>
                <div class="block">
                    <div class="row-head"><h3>Liste du personnel</h3><button class="btn-gold">+ Ajouter</button></div>
                    <table>
                        <thead><tr><th>Nom</th><th>Poste</th><th>Service</th><th>Téléphone</th><th>Statut</th></tr></thead>
                        <tbody>
                            @foreach([['Mohamed Tazi','Réceptionniste','Accueil','0661-100100','ok'],['Laila Saidi','Gouvernante','Étages','0662-200200','ok'],['Hassan Oubella','Chef cuisinier','Restaurant','0663-300300','warn'],['Nadia Cherkaoui','Comptable','Administration','0664-400400','ok'],['Omar Fassi','Agent sécurité','Sécurité','0665-500500','bad']] as $r)
                            <tr><td>{{ $r[0] }}</td><td>{{ $r[1] }}</td><td>{{ $r[2] }}</td><td>{{ $r[3] }}</td>
                            <td><span class="tag {{ $r[4] }}">{{ ['ok'=>'Présent','warn'=>'Congé','bad'=>'Absent'][$r[4]] }}</span></td></tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            {{-- GESTION DES PAIES --}}
            <section class="panel" id="paies">
                <h2 class="serif">Gestion des Paies</h2>
                <p class="sub">Bulletins de salaire et versements</p>
                <div class="cards">
                    <div class="card"><div class="n">48</div><div class="l">Bulletins</div></div>
                    <div class="card"><div class="n">312 000 DH</div><div class="l">Masse salariale</div></div>
                    <div class="card"><div class="n">44</div><div class="l">Payés</div></div>
                    <div class="card"><div class="n">4</div><div class="l">En attente</div></div>
                </div>
                <div class="block">
                    <div class="row-head"><h3>Paies du mois</h3><button class="btn-gold">Générer les bulletins</button></div>
                    <table>
                        <thead><tr><th>Employé</th><th>Poste</th><th>Salaire brut</th><th>Net à payer</th><th>Statut</th></tr></thead>
                        <tbody>
                            @foreach([['Mohamed Tazi','Réceptionniste','6 500 DH','5 400 DH','ok'],['Laila Saidi','Gouvernante','5 200 DH','4 350 DH','ok'],['Hassan Oubella','Chef cuisinier','9 000 DH','7 350 DH','warn'],['Nadia Cherkaoui','Comptable','8 200 DH','6 700 DH','ok']] as $r)
                            <tr><td>{{ $r[0] }}</td><td>{{ $r[1] }}</td><td>{{ $r[2] }}</td><td>{{ $r[3] }}</td>
                            <td><span class="tag {{ $r[4] }}">{{ $r[4]==='ok'?'Payé':'En attente' }}</span></td></tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            {{-- TRESORERIE --}}
            <section class="panel" id="tresorerie">
                <h2 class="serif">Trésorerie</h2>
                <p class="sub">Suivi des flux financiers</p>
                <div class="cards">
                    <div class="card"><div class="n">486 000 DH</div><div class="l">Solde actuel</div></div>
                    <div class="card"><div class="n">+312 500 DH</div><div class="l">Entrées (mois)</div></div>
                    <div class="card"><div class="n">-198 700 DH</div><div class="l">Sorties (mois)</div></div>
                    <div class="card"><div class="n">+113 800 DH</div><div class="l">Résultat net</div></div>
                </div>
                <div class="block">
                    <div class="row-head"><h3>Derniers mouvements</h3><button class="btn-gold">+ Mouvement</button></div>
                    <table>
                        <thead><tr><th>Date</th><th>Libellé</th><th>Type</th><th>Montant</th><th>Compte</th></tr></thead>
                        <tbody>
                            @foreach([['22/06/2026','Encaissement réservations','Entrée','+42 000 DH','Banque','ok'],['21/06/2026','Achat fournitures','Sortie','-8 600 DH','Caisse','bad'],['20/06/2026','Versement salaires','Sortie','-94 000 DH','Banque','bad'],['19/06/2026','Recette restaurant','Entrée','+15 200 DH','Caisse','ok']] as $r)
                            <tr><td>{{ $r[0] }}</td><td>{{ $r[1] }}</td><td><span class="tag {{ $r[5] }}">{{ $r[2] }}</span></td><td>{{ $r[3] }}</td><td>{{ $r[4] }}</td></tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            {{-- CHARGES --}}
            <section class="panel" id="charges">
                <h2 class="serif">Charges</h2>
                <p class="sub">Dépenses et charges fixes / variables</p>
                <div class="cards">
                    <div class="card"><div class="n">198 700 DH</div><div class="l">Charges du mois</div></div>
                    <div class="card"><div class="n">62%</div><div class="l">Charges fixes</div></div>
                    <div class="card"><div class="n">38%</div><div class="l">Charges variables</div></div>
                    <div class="card"><div class="n">3</div><div class="l">Échéances proches</div></div>
                </div>
                <div class="block">
                    <div class="row-head"><h3>Détail des charges</h3><button class="btn-gold">+ Ajouter une charge</button></div>
                    <table>
                        <thead><tr><th>Charge</th><th>Type</th><th>Montant</th><th>Échéance</th><th>Statut</th></tr></thead>
                        <tbody>
                            @foreach([['Électricité','Fixe','24 000 DH','30/06/2026','warn'],['Eau','Fixe','9 500 DH','30/06/2026','ok'],['Salaires','Fixe','94 000 DH','28/06/2026','ok'],['Approvisionnement','Variable','38 200 DH','25/06/2026','bad'],['Internet & Télécom','Fixe','3 200 DH','05/07/2026','ok']] as $r)
                            <tr><td>{{ $r[0] }}</td><td>{{ $r[1] }}</td><td>{{ $r[2] }}</td><td>{{ $r[3] }}</td>
                            <td><span class="tag {{ $r[4] }}">{{ ['ok'=>'Réglée','warn'=>'À venir','bad'=>'En retard'][$r[4]] }}</span></td></tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            {{-- CONFIGURATION --}}
            <section class="panel" id="configuration">
                <h2 class="serif">Configuration</h2>
                <p class="sub">Paramètres généraux de l'établissement</p>
                <div class="cfg-grid">
                    <div class="block">
                        <h3>Informations de l'hôtel</h3>
                        <div class="field"><label>Nom</label><input type="text" value="Al Jazeera Hotel"></div>
                        <div class="field"><label>Adresse</label><input type="text" value="Boulevard principal, Centre-ville"></div>
                        <div class="field"><label>Téléphone</label><input type="text" value="+212 600 000 000"></div>
                        <div class="field"><label>Email</label><input type="text" value="contact@aljazeerahotel.com"></div>
                        <button class="btn-gold">Enregistrer</button>
                    </div>
                    <div class="block">
                        <h3>Paramètres</h3>
                        <div class="field"><label>Devise</label><select><option>Dirham (DH)</option><option>Euro (€)</option><option>Dollar ($)</option></select></div>
                        <div class="field"><label>Langue par défaut</label><select><option>Français</option><option>Arabe</option><option>Anglais</option></select></div>
                        <div class="field"><label>TVA (%)</label><input type="text" value="10"></div>
                        <div class="field"><label>Heure de check-out</label><input type="text" value="12:00"></div>
                        <button class="btn-gold">Mettre à jour</button>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>

<script>
    const items=document.querySelectorAll('.sb-item');
    const panels=document.querySelectorAll('.panel');
    const title=document.getElementById('pageTitle');
    const sidebar=document.getElementById('sidebar');
    const overlay=document.getElementById('overlay');
    items.forEach(it=>it.addEventListener('click',()=>{
        items.forEach(x=>x.classList.remove('active'));
        document.getElementById('frnsParent').classList.remove('active');
        it.classList.add('active');
        const t=it.dataset.target;
        panels.forEach(p=>p.classList.toggle('active',p.id===t));
        title.textContent=it.textContent.trim();
        if(typeof FRNS!=='undefined'){
            if(t==='dashboard')FRNS.renderDashboard();
            if(t==='bon'||t==='regl')FRNS.renderSelects();
            if(t==='regl')FRNS.renderReglBalances();
            if(t==='balance')FRNS.renderBalance();
        }
        sidebar.classList.remove('open');overlay.classList.remove('show');
        window.scrollTo({top:0,behavior:'smooth'});
    }));
    const hamb=document.getElementById('hamb');
    hamb.addEventListener('click',()=>{sidebar.classList.add('open');overlay.classList.add('show')});
    overlay.addEventListener('click',()=>{sidebar.classList.remove('open');overlay.classList.remove('show')});
    const frnsParent=document.getElementById('frnsParent');
    const frnsSub=document.getElementById('frnsSub');
    frnsParent.addEventListener('click',()=>{
        frnsParent.classList.toggle('expanded');
        frnsSub.classList.toggle('open');
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
/* ===== Module Fournisseur (achats) — persistance localStorage ===== */
const FRNS = (function(){
    const K={f:'aj_frns',b:'aj_bons',r:'aj_regls'};
    const get=k=>JSON.parse(localStorage.getItem(k)||'[]');
    const set=(k,v)=>localStorage.setItem(k,JSON.stringify(v));
    const uid=()=>Date.now().toString(36)+Math.random().toString(36).slice(2,6);
    const num=v=>Number(v)||0;
    const fmt=v=>num(v).toLocaleString('fr-FR',{minimumFractionDigits:2,maximumFractionDigits:2})+' DH';
    const esc=s=>(s==null?'':String(s)).replace(/[&<>"]/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c]));
    let editFiche=null;

    /* ---- calculs ---- */
    const frnsById=id=>get(K.f).find(f=>f.id===id);
    const frnsName=id=>{const f=frnsById(id);return f?f.nom:'—';};
    const totalBons=id=>get(K.b).filter(b=>b.frnsId===id).reduce((s,b)=>s+num(b.st),0);
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
            <td class="no-print">
                <button class="ibtn" title="Modifier" onclick="FRNS.edit('${f.id}')">&#9998;</button>
                <button class="ibtn del" title="Supprimer" onclick="FRNS.del('${f.id}')">&#128465;</button>
                <button class="ibtn" title="Imprimer" onclick="FRNS.printRow('${f.id}')">&#128424;</button>
                <button class="ibtn" title="Exporter" onclick="FRNS.csvRow('${f.id}')">&#11015;</button>
            </td>
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
    function calcSousTotal(){
        const q=num(document.getElementById('ba_qte').value),p=num(document.getElementById('ba_prix').value);
        document.getElementById('ba_st').value=(q*p).toFixed(2);
    }
    function fmtPrix(){
        const el=document.getElementById('ba_prix');
        if(el.value!=='')el.value=num(el.value).toFixed(2);
        calcSousTotal();
    }
    function addBon(){
        const frnsId=document.getElementById('ba_frns').value;
        const desig=document.getElementById('ba_desig').value.trim();
        if(!frnsId){alert('Choisissez un fournisseur.');return;}
        if(!desig){alert('Saisissez une désignation.');return;}
        calcSousTotal();
        const list=get(K.b);
        list.push({id:uid(),date:document.getElementById('ba_date').value,frnsId,
            ref:document.getElementById('ba_ref').value.trim(),desig,
            qte:num(document.getElementById('ba_qte').value),prix:num(document.getElementById('ba_prix').value),
            st:num(document.getElementById('ba_st').value)});
        set(K.b,list);
        ['ba_desig','ba_qte','ba_prix','ba_st'].forEach(i=>document.getElementById(i).value='');
        renderBons();
    }
    function newBon(){
        ['ba_date','ba_ref','ba_desig','ba_qte','ba_prix','ba_st'].forEach(i=>document.getElementById(i).value='');
        document.getElementById('ba_frns').selectedIndex=0;
    }
    function delBon(id){ if(!confirm('Supprimer ce bon ?'))return; set(K.b,get(K.b).filter(b=>b.id!==id)); renderBons(); }
    function renderBons(){
        const tb=document.getElementById('ba_tbody'); const list=get(K.b);
        tb.innerHTML=list.length?list.map(b=>`<tr>
            <td>${esc(b.date)}</td><td>${esc(frnsName(b.frnsId))}</td><td>${esc(b.ref)}</td><td>${esc(b.desig)}</td>
            <td>${b.qte}</td><td>${fmt(b.prix)}</td><td>${fmt(b.st)}</td>
            <td class="no-print"><button class="tbtn del" onclick="FRNS.delBon('${b.id}')">Supprimer</button></td>
        </tr>`).join(''):'<tr class="empty-row"><td colspan="8">Aucun bon d\'achat enregistré.</td></tr>';
    }

    /* ---- REGLEMENT ACHATS ---- */
    function renderReglBalances(){
        const box=document.getElementById('ra_balances'); const list=get(K.f);
        const filter=document.getElementById('ra_frns').value;
        const shown=list.filter(f=>!filter||f.id===filter);
        box.innerHTML=shown.length?shown.map(f=>{
            const s=soldeFrns(f);
            return `<div class="bal-row" data-frns="${f.id}" data-mnt="${s}">
                <label class="chk"><input type="checkbox" class="bal-chk"> ${esc(f.nom)}</label>
                <span class="mnt">Mnt Bon : ${fmt(s)}</span>
                <input class="pay" type="number" step="0.01" placeholder="MNT Payé" value="${s>0?s.toFixed(2):''}" oninput="FRNS.calcSolde(this)">
                <span class="sld">Solde : ${fmt(s-(s>0?s:0))}</span>
            </div>`;
        }).join(''):'<p class="hint">Aucun fournisseur. Créez d\'abord une fiche fournisseur.</p>';
    }
    function calcSolde(inp){
        const row=inp.closest('.bal-row');
        const mnt=num(row.dataset.mnt), paye=num(inp.value);
        row.querySelector('.sld').textContent='Solde : '+fmt(mnt-paye);
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
        renderReglBalances();
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
    /* ---- TABLEAU DE BORD ---- */
    let _charts={};
    function renderDashboard(){
        const frns=get(K.f), bons=get(K.b), regls=get(K.r);
        const totalAchats=bons.reduce((s,b)=>s+num(b.st),0);
        const totalRegle=regls.reduce((s,r)=>s+num(r.montant),0);
        const soldeGlobal=frns.reduce((s,f)=>s+soldeFrns(f),0);
        document.getElementById('kpiFrns').textContent=frns.length;
        document.getElementById('kpiBons').textContent=bons.length;
        document.getElementById('kpiAchats').textContent=fmt(totalAchats);
        document.getElementById('kpiRegle').textContent=fmt(totalRegle);
        document.getElementById('kpiSolde').textContent=fmt(soldeGlobal);
        const lastBons=bons.slice(-6).reverse();
        document.getElementById('dashBons').innerHTML=lastBons.length?lastBons.map(b=>`<tr>
            <td>${esc(b.date)}</td><td>${esc(frnsName(b.frnsId))}</td><td>${esc(b.ref)}</td><td>${esc(b.desig)}</td><td>${fmt(b.st)}</td>
        </tr>`).join(''):'<tr class="empty-row"><td colspan="5">Aucun bon d\'achat.</td></tr>';
        const lastRegls=regls.slice(-6).reverse();
        document.getElementById('dashRegls').innerHTML=lastRegls.length?lastRegls.map(r=>`<tr>
            <td>${esc(r.date)}</td><td>${esc(r.ref)}</td><td>${esc(frnsName(r.frnsId))}</td><td>${esc(r.type)}</td><td>${fmt(r.montant)}</td>
        </tr>`).join(''):'<tr class="empty-row"><td colspan="5">Aucun règlement.</td></tr>';
        renderCharts(frns,bons,regls);
    }
    function monthKey(d){ return (d||'').slice(0,7) || '—'; }
    function renderCharts(frns,bons,regls){
        if(typeof Chart==='undefined')return;
        const months={};
        bons.forEach(b=>{const k=monthKey(b.date);(months[k]=months[k]||{a:0,r:0}).a+=num(b.st);});
        regls.forEach(r=>{const k=monthKey(r.date);(months[k]=months[k]||{a:0,r:0}).r+=num(r.montant);});
        const labels=Object.keys(months).sort();
        drawChart('chartFlux','bar',{labels,datasets:[
            {label:'Achats',data:labels.map(k=>months[k].a),backgroundColor:'rgba(201,162,39,.75)',borderRadius:6},
            {label:'Règlements',data:labels.map(k=>months[k].r),backgroundColor:'rgba(120,170,255,.6)',borderRadius:6}
        ]},true);
        const sol=frns.map(f=>({n:f.nom,s:soldeFrns(f)})).filter(x=>x.s>0).sort((a,b)=>b.s-a.s).slice(0,6);
        drawChart('chartSolde','doughnut',{labels:sol.map(x=>x.n),datasets:[{data:sol.map(x=>x.s),
            backgroundColor:['#c9a227','#e6c75a','#7aa6ff','#7fd99b','#e8899b','#b58be0'],borderColor:'#0d1b3d',borderWidth:2}]},false);
    }
    function drawChart(id,type,data,axes){
        const el=document.getElementById(id); if(!el)return;
        if(_charts[id])_charts[id].destroy();
        _charts[id]=new Chart(el,{type,data,options:{
            responsive:true,maintainAspectRatio:false,
            plugins:{legend:{labels:{color:'#f5f1e6',font:{size:12}}}},
            scales:axes?{x:{ticks:{color:'#aab0c4'},grid:{color:'rgba(255,255,255,.05)'}},y:{ticks:{color:'#aab0c4'},grid:{color:'rgba(255,255,255,.05)'}}}:{}
        }});
    }

    function renderBalance(){
        const tb=document.getElementById('bl_tbody'); const list=get(K.f);
        tb.innerHTML=list.length?list.map(f=>{
            const bons=get(K.b).filter(b=>b.frnsId===f.id);
            const lastBon=bons.length?bons[bons.length-1].date:'—';
            const regls=get(K.r).filter(r=>r.frnsId===f.id);
            const lastType=regls.length?regls[regls.length-1].type:'—';
            return `<tr>
            <td>${esc(lastBon)}</td><td>${esc(f.nom)}</td><td>${esc(lastType)}</td>
            <td>${fmt(duTotal(f))}</td><td>${fmt(totalPaye(f.id))}</td><td>${fmt(soldeFrns(f))}</td>
        </tr>`;}).join(''):'<tr class="empty-row"><td colspan="6">Aucune donnée.</td></tr>';
    }

    /* ---- IMPRIMER / EXPORTER ---- */
    function print(tableId,title){
        const t=document.getElementById(tableId).cloneNode(true);
        t.querySelectorAll('.no-print').forEach(e=>e.remove());
        const w=window.open('','','width=1000,height=700');
        w.document.write('<html><head><title>'+title+'</title><style>body{font-family:Arial;padding:24px}h2{font-family:Georgia}table{width:100%;border-collapse:collapse;margin-top:14px}th,td{border:1px solid #888;padding:8px;font-size:12px;text-align:left}th{background:#0a1736;color:#fff}</style></head><body><h2>'+title+'</h2>'+t.outerHTML+'</body></html>');
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

    function init(){ renderSelects(); renderFiche(); renderBons(); renderRegls(); renderBalance(); renderDashboard(); document.getElementById('ff_id').value=nextId(); document.getElementById('ra_ref').value=nextReglRef(); }

    return {init,renderSelects,renderReglBalances,renderBalance,renderDashboard,calcSolde,
        saveFiche,newFiche,edit:editFicheRow,del:delFiche,printRow,csvRow,
        calcSousTotal,fmtPrix,addBon,newBon,delBon,
        addReglement,newReglement,delRegl,print,csv};
})();

window.FRNS=FRNS;
document.getElementById('ra_frns')?.addEventListener('change',()=>FRNS.renderReglBalances());
FRNS.init();
</script>
</body>
</html>
