@extends('layouts.app')
@section('title','Calendrier')
@include('partials.page-hero')
@push('styles')
<style>
    .cal-wrap{max-width:620px;margin:0 auto;background:rgba(255,255,255,.03);border:1px solid rgba(201,162,39,.15);border-radius:14px;padding:28px}
    .cal-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px}
    .cal-head h3{font-family:'Cormorant Garamond',serif;font-size:28px;color:#fff}
    .cal-nav{background:transparent;border:1px solid rgba(201,162,39,.4);color:var(--gold);width:38px;height:38px;border-radius:8px;cursor:pointer;font-size:18px}
    .cal-nav:hover{background:rgba(201,162,39,.15)}
    .grid7{display:grid;grid-template-columns:repeat(7,1fr);gap:8px}
    .dow{text-align:center;color:var(--gold);font-size:12px;letter-spacing:1px;text-transform:uppercase;padding-bottom:8px}
    .day{aspect-ratio:1;display:flex;align-items:center;justify-content:center;border-radius:8px;font-size:14px;background:rgba(255,255,255,.03);border:1px solid transparent;cursor:pointer;transition:all .2s}
    .day.empty{background:transparent;cursor:default}
    .day.free:hover{border-color:var(--gold)}
    .day.booked{background:rgba(220,80,80,.12);color:#e88;cursor:not-allowed;text-decoration:line-through}
    .day.selected{background:linear-gradient(135deg,var(--gold),var(--gold-light));color:#1a1304;font-weight:600}
    .legend{display:flex;gap:22px;justify-content:center;margin-top:22px;font-size:12px;color:var(--text-muted)}
    .legend span{display:flex;align-items:center;gap:7px}
    .dot{width:12px;height:12px;border-radius:3px}
</style>
@endpush
@section('content')
<header class="page-hero"><div class="ph-inner"><div class="crumb">Al Jazeera Hotel</div><h1 class="serif">Calendrier de disponibilité</h1></div></header>
<section class="page-body">
    <div class="cal-wrap">
        <div class="cal-head">
            <button class="cal-nav" id="prev">&#8249;</button>
            <h3 class="serif" id="monthLabel"></h3>
            <button class="cal-nav" id="next">&#8250;</button>
        </div>
        <div class="grid7" id="dows"></div>
        <div class="grid7" id="days"></div>
        <div class="legend">
            <span><i class="dot" style="background:rgba(255,255,255,.1)"></i> Disponible</span>
            <span><i class="dot" style="background:rgba(220,80,80,.5)"></i> Réservé</span>
            <span><i class="dot" style="background:var(--gold)"></i> Sélectionné</span>
        </div>
    </div>
</section>
@push('scripts')
<script>
    const months=['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];
    const dows=['Lun','Mar','Mer','Jeu','Ven','Sam','Dim'];
    const dowEl=document.getElementById('dows');
    dows.forEach(d=>{const e=document.createElement('div');e.className='dow';e.textContent=d;dowEl.appendChild(e)});
    let view=new Date();view.setDate(1);
    const booked={}; // ex: '2026-6-12':true (démo aléatoire stable par mois)
    function render(){
        document.getElementById('monthLabel').textContent=months[view.getMonth()]+' '+view.getFullYear();
        const days=document.getElementById('days');days.innerHTML='';
        let start=(view.getDay()+6)%7; // lundi=0
        const total=new Date(view.getFullYear(),view.getMonth()+1,0).getDate();
        for(let i=0;i<start;i++){const e=document.createElement('div');e.className='day empty';days.appendChild(e)}
        for(let d=1;d<=total;d++){
            const e=document.createElement('div');e.textContent=d;
            const isBooked=(d*7+view.getMonth())%9===0; // démo
            e.className='day '+(isBooked?'booked':'free');
            if(!isBooked)e.addEventListener('click',()=>{
                days.querySelectorAll('.selected').forEach(x=>x.classList.remove('selected'));
                e.classList.add('selected');
            });
            days.appendChild(e);
        }
    }
    document.getElementById('prev').onclick=()=>{view.setMonth(view.getMonth()-1);render()};
    document.getElementById('next').onclick=()=>{view.setMonth(view.getMonth()+1);render()};
    render();
</script>
@endpush
@endsection
