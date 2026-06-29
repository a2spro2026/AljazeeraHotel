@push('styles')
<style>
    .page-hero{
        position:relative;min-height:46vh;display:flex;align-items:flex-end;
        padding:0 48px 50px;
        background:url('{{ asset('images/hotel.png') }}') center/cover no-repeat;
    }
    .page-hero::before{content:'';position:absolute;inset:0;
        background:linear-gradient(180deg,rgba(6,15,36,.7),rgba(6,15,36,.92))}
    .page-hero .ph-inner{position:relative;z-index:2;max-width:1240px;margin:0 auto;width:100%}
    .page-hero .crumb{color:var(--gold);letter-spacing:3px;text-transform:uppercase;font-size:12px;margin-bottom:10px}
    .page-hero h1{font-family:'Cormorant Garamond',serif;font-size:clamp(38px,5vw,64px);color:#fff}
    .page-body{max-width:1240px;margin:0 auto;padding:70px 48px}
    @media(max-width:860px){.page-hero{padding:0 22px 36px}.page-body{padding:46px 22px}}
</style>
@endpush
