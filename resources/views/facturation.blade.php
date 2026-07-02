@extends('layouts.app')
@section('title','Facturation')
@include('partials.page-hero')
@push('styles')
<style>
    .stats{display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:22px;margin-bottom:46px}
    .stat{background:rgba(255,255,255,.03);border:1px solid rgba(201,162,39,.15);border-radius:12px;padding:24px}
    .stat .n{font-family:'Cormorant Garamond',serif;font-size:38px;color:var(--gold);line-height:1}
    .stat .l{color:var(--text-muted);font-size:13px;text-transform:uppercase;letter-spacing:1px;margin-top:6px}
    table{width:100%;border-collapse:collapse;background:rgba(255,255,255,.02);border-radius:12px;overflow:hidden}
    th,td{padding:14px 18px;text-align:center;vertical-align:middle;font-size:14px;border-bottom:1px solid rgba(255,255,255,.06)}
    th{color:var(--gold);text-transform:uppercase;font-size:12px;letter-spacing:1px}
    td{color:var(--cream)}
    .tag{padding:4px 12px;border-radius:20px;font-size:12px}
    .tag.paid{background:rgba(80,200,120,.15);color:#7fd99b}
    .tag.due{background:rgba(230,120,120,.15);color:#e89}
    h2.sec{font-family:'Cormorant Garamond',serif;font-size:28px;color:#fff;margin-bottom:20px}
</style>
@endpush
@section('content')
<header class="page-hero"><div class="ph-inner">
    <div class="crumb">Espace Facturation</div>
    <h1 class="serif">Gestion de la facturation</h1>
    <form method="POST" action="{{ route('space.logout', 'facturation') }}" style="margin-top:14px">
        @csrf
        <button type="submit" style="background:transparent;border:1px solid rgba(201,162,39,.5);color:var(--gold);padding:9px 20px;border-radius:6px;font-size:12px;letter-spacing:1px;text-transform:uppercase;cursor:pointer">Déconnexion</button>
    </form>
</div></header>
<section class="page-body">
    <div class="stats">
        <div class="stat"><div class="n">0 DH</div><div class="l">Chiffre du mois</div></div>
        <div class="stat"><div class="n">0</div><div class="l">Factures payées</div></div>
        <div class="stat"><div class="n">0</div><div class="l">Factures impayées</div></div>
        <div class="stat"><div class="n">0 DH</div><div class="l">En attente</div></div>
    </div>
    <h2 class="sec serif">Dernières factures</h2>
    <table>
        <thead><tr><th>N° Facture</th><th>Client</th><th>Date</th><th>Montant</th><th>Statut</th></tr></thead>
        <tbody>
            <tr><td colspan="5">Aucune donnée.</td></tr>
        </tbody>
    </table>
</section>
@endsection
