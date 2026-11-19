@foreach(($habillage['writings'] ?? []) as $w)
    @if(($w['zone'] ?? '') === ($zone ?? '') && (trim((string) ($w['text'] ?? '')) !== '' || trim((string) ($w['text2'] ?? '')) !== ''))
        @php
            $hbLight = $w['light'] ?? 'soft';
            if (is_bool($hbLight)) {
                $hbLight = $hbLight ? 'soft' : 'none';
            }
            if (! in_array($hbLight, ['none', 'soft', 'glow', 'forte', 'neon', 'or', 'relief', 'halo'], true)) {
                $hbLight = 'soft';
            }
        @endphp
        <div class="hb-writing hb-style-{{ $w['style'] }} hb-mode-{{ $w['mode'] }} hb-light-{{ $hbLight }}{{ ($w['stars'] ?? true) ? '' : ' hb-nostars' }}" data-id="{{ $w['id'] }}" style="left:{{ $w['x'] }}%;top:{{ $w['y'] }}%;--hb-wsize:{{ number_format(((int) $w['size']) / 100, 2, '.', '') }};--hb-wcolor:{{ $w['color'] }};">
            <span class="hb-w-1">{{ $w['text'] }}</span>
            <span class="hb-w-stars" aria-hidden="true"><span></span><b>★★★★★</b><span></span></span>
            <span class="hb-w-2">{{ $w['text2'] }}</span>
            <span class="hb-w-orn" aria-hidden="true"><span></span><i>◆</i><span></span></span>
            <span class="hb-resize" title="Agrandir"></span>
        </div>
    @endif
@endforeach
