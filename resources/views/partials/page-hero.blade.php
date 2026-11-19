@push('styles')
<style>
    .page-hero{
        position:relative;width:100%;display:block;margin-top:0;padding:0;
        background:transparent;overflow:hidden;
    }
    .page-hero .hb-photo{display:block;width:100%;height:auto;filter:brightness(var(--hb-light,1))}
    .page-hero::before{content:'';position:absolute;inset:0;z-index:1;pointer-events:none;
        background:
            linear-gradient(180deg,rgba(255,250,240,.14) 0%,rgba(255,255,255,.05) 50%,transparent 100%),
            linear-gradient(180deg,rgba(6,15,36,.35),rgba(6,15,36,.72));
    }
    .page-hero .ph-inner{position:absolute;z-index:2;left:0;right:0;bottom:0;max-width:100%;margin:0 auto;width:100%;padding:48px}
    .page-hero .crumb{
        color:var(--gold-light);letter-spacing:4px;text-transform:uppercase;font-size:12px;margin-bottom:10px;
        font-weight:600;text-shadow:0 0 20px rgba(212,176,106,.45);
    }
    .page-hero h1{
        font-family:'Cormorant Garamond',serif;font-size:clamp(38px,5vw,64px);color:#fff;
        letter-spacing:2px;text-shadow:0 4px 28px rgba(0,0,0,.45),0 0 40px rgba(255,255,255,.1);
    }
    .page-body{
        max-width:100%;margin:0 auto;padding:56px clamp(20px,4vw,48px) 80px;width:100%;
        background:var(--surface);
    }
    @media(max-width:860px){.page-hero .ph-inner{padding:32px 22px 28px}.page-body{padding:40px 22px 60px}}
    body.hb-on .page-hero{background:transparent}
    body.hb-on .page-hero::before{background:var(--hb-veil)}
</style>
@endpush
