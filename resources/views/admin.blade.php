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
        }
        .sb-item .ic{font-size:18px;width:22px;text-align:center}
        .sb-item:hover{background:rgba(201,162,39,.08);border-color:rgba(201,162,39,.2)}
        .sb-item.active{
            background:linear-gradient(135deg,var(--gold),var(--gold-light));color:#1a1304;font-weight:600;
            box-shadow:0 0 18px rgba(201,162,39,.45);
        }
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
            <div class="sb-item active" data-target="fournisseur"><span class="ic">&#128666;</span> Fournisseur</div>
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
                <h1 id="pageTitle">Fournisseur</h1>
            </div>
            <div class="who">
                <div style="text-align:right"><b>Direction</b><span>Général</span></div>
                @if(file_exists(public_path('images/profile.png')))
                    <img src="{{ asset('images/profile.png') }}" alt="profil">
                @endif
            </div>
        </div>

        <div class="content">

            {{-- FOURNISSEUR --}}
            <section class="panel active" id="fournisseur">
                <h2 class="serif">Fournisseurs</h2>
                <p class="sub">Gestion des fournisseurs et commandes d'approvisionnement</p>
                <div class="cards">
                    <div class="card"><div class="n">24</div><div class="l">Fournisseurs actifs</div></div>
                    <div class="card"><div class="n">7</div><div class="l">Commandes en cours</div></div>
                    <div class="card"><div class="n">3</div><div class="l">Livraisons en retard</div></div>
                    <div class="card"><div class="n">86 400 DH</div><div class="l">À payer ce mois</div></div>
                </div>
                <div class="block">
                    <div class="row-head"><h3>Liste des fournisseurs</h3><button class="btn-gold">+ Ajouter</button></div>
                    <table>
                        <thead><tr><th>Fournisseur</th><th>Catégorie</th><th>Contact</th><th>Dernière commande</th><th>Statut</th></tr></thead>
                        <tbody>
                            @foreach([['Sté Délices Aliments','Alimentaire','0661-000111','18/06/2026','ok'],['Linge & Co','Blanchisserie','0662-222333','15/06/2026','ok'],['HygiènePro','Produits d\'entretien','0663-444555','10/06/2026','warn'],['Mobilier Atlas','Mobilier','0664-666777','02/06/2026','ok'],['TechFroid','Maintenance','0665-888999','28/05/2026','bad']] as $r)
                            <tr><td>{{ $r[0] }}</td><td>{{ $r[1] }}</td><td>{{ $r[2] }}</td><td>{{ $r[3] }}</td>
                            <td><span class="tag {{ $r[4] }}">{{ ['ok'=>'À jour','warn'=>'À relancer','bad'=>'Litige'][$r[4]] }}</span></td></tr>
                            @endforeach
                        </tbody>
                    </table>
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
        it.classList.add('active');
        const t=it.dataset.target;
        panels.forEach(p=>p.classList.toggle('active',p.id===t));
        title.textContent=it.textContent.trim();
        sidebar.classList.remove('open');overlay.classList.remove('show');
        window.scrollTo({top:0,behavior:'smooth'});
    }));
    const hamb=document.getElementById('hamb');
    hamb.addEventListener('click',()=>{sidebar.classList.add('open');overlay.classList.add('show')});
    overlay.addEventListener('click',()=>{sidebar.classList.remove('open');overlay.classList.remove('show')});
</script>
</body>
</html>
