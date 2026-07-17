@push('styles')
<style>
    .page-hero{
        position:relative;min-height:46vh;display:flex;align-items:flex-end;
        padding:74px 48px 50px;margin-top:0;
        background:
            linear-gradient(180deg,rgba(255,250,240,.14) 0%,rgba(255,255,255,.05) 50%,transparent 100%),
            linear-gradient(180deg,rgba(6,15,36,.45),rgba(6,15,36,.78)),
            url('{{ asset('images/hotel-facade.png') }}') center/cover no-repeat;
        background-color:#e8e4dc;
    }
    .page-hero::before{content:'';position:absolute;inset:0;z-index:1;pointer-events:none;
        background:radial-gradient(ellipse 70% 60% at 50% 30%,rgba(255,255,255,.16),transparent 65%)}
    .page-hero .ph-inner{position:relative;z-index:2;max-width:var(--content-max,1140px);margin:0 auto;width:100%}
    .page-hero .crumb{
        color:var(--gold-light);letter-spacing:4px;text-transform:uppercase;font-size:12px;margin-bottom:10px;
        font-weight:600;text-shadow:0 0 20px rgba(212,176,106,.45);
    }
    .page-hero h1{
        font-family:'Cormorant Garamond',serif;font-size:clamp(38px,5vw,64px);color:#fff;
        letter-spacing:2px;text-shadow:0 4px 28px rgba(0,0,0,.45),0 0 40px rgba(255,255,255,.1);
    }
    .page-body{
        max-width:var(--content-max,1140px);margin:0 auto;padding:56px clamp(20px,4vw,48px) 80px;width:100%;
        background:var(--surface);
    }
    @media(max-width:860px){.page-hero{padding:74px 22px 36px}.page-body{padding:40px 22px 60px}}
</style>
@endpush
