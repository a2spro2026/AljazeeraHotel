<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Habillage
{
    public const FILE = 'habillage.json';

    public const LIBRARY = [
        '/images/hotel-hero.png',
        '/images/hotel-facade.png',
        '/images/hotel.png',
    ];

    private static ?array $cache = null;

    public static function defaults(): array
    {
        return [
            'title' => '',
            'subtitle' => '',
            'image' => '/images/hotel-hero.png',
            'color' => '#1a1520',
            'light' => 100,
            'veil' => 'none',
            'veil_opacity' => 40,
            'title_color' => '#ffffff',
            'title_style' => 'classique',
            'text_size' => 100,
            'text_x' => null,
            'text_y' => null,
            'text_placed' => false,
            'writings' => [],
            'services' => self::defaultServices(),
            'about' => self::defaultAbout(),
            'photos' => self::LIBRARY,
        ];
    }

    public static function defaultAbout(): array
    {
        return [
            'bg' => '#0a1736',
            'title' => "À propos d'",
            'brand' => 'ALJAZEERA',
            'title_color' => '#8b93a3',
            'accent' => '#c5a059',
            'text' => "Un hôtel <em>5 étoiles</em> qui allie élégance marocaine et confort international. Piscine, spa, gastronomie raffinée et un service attentionné pour un séjour d'exception au cœur de la ville.",
            'text_color' => '#c5cbd6',
            'style' => 'serif',
        ];
    }

    public static function defaultServices(): array
    {
        return [
            ['id' => 'piscine', 'label' => 'Piscine', 'icon' => '🏊', 'visible' => true],
            ['id' => 'spa', 'label' => 'Spa & Bien-être', 'icon' => '💖', 'visible' => true],
            ['id' => 'restaurant', 'label' => 'Restaurant', 'icon' => '🍽️', 'visible' => true],
            ['id' => 'cafe', 'label' => 'Café & Lounge', 'icon' => '☕', 'visible' => true],
            ['id' => 'sport', 'label' => 'Salle de Sport', 'icon' => '🏋️', 'visible' => true],
            ['id' => 'wifi', 'label' => 'Wi-Fi Gratuit', 'icon' => '📶', 'visible' => true],
            ['id' => 'parking', 'label' => 'Parking', 'icon' => '🚌', 'visible' => true],
            ['id' => 'roomservice', 'label' => 'Room Service', 'icon' => '🍽️', 'visible' => true],
        ];
    }

    public static function current(): array
    {
        if (self::$cache !== null) {
            return self::$cache;
        }

        $data = self::defaults();
        $data['saved'] = false;
        $previousPhotos = [];

        if (Storage::disk('local')->exists(self::FILE)) {
            $json = json_decode(Storage::disk('local')->get(self::FILE), true);
            if (is_array($json)) {
                $previousPhotos = is_array($json['photos'] ?? null) ? $json['photos'] : [];
                $data = array_merge($data, self::sanitize($json));
                $data['saved'] = true;
            }
        }

        $data['photos'] = self::archivePhotos(
            array_merge($previousPhotos, $data['photos'] ?? [], [$data['image']], self::diskPhotos())
        );
        $data['image_url'] = $data['image'];
        $data['light_ratio'] = round(max(40, min(140, (int) $data['light'])) / 100, 2);
        $data['veil_css'] = self::veilCss($data['veil'], (int) $data['veil_opacity']);

        return self::$cache = $data;
    }

    public static function sanitize(array $in): array
    {
        $veil = in_array($in['veil'] ?? 'none', ['none', 'navy', 'gold'], true) ? $in['veil'] : 'none';
        $styles = ['enseigne', 'classique', 'signature', 'moderne', 'lisere'];
        $style = (string) ($in['title_style'] ?? 'classique');
        if (! in_array($style, $styles, true)) {
            $style = 'classique';
        }
        $placed = filter_var($in['text_placed'] ?? false, FILTER_VALIDATE_BOOLEAN);
        $x = self::percent($in['text_x'] ?? null);
        $y = self::percent($in['text_y'] ?? null);
        if (! $placed || $x === null || $y === null) {
            $placed = false;
            $x = null;
            $y = null;
        }
        $image = (string) ($in['image'] ?? '/images/hotel-hero.png');
        if (! self::allowedImage($image)) {
            $image = '/images/hotel-hero.png';
        }
        $photos = self::archivePhotos(array_merge(
            self::LIBRARY,
            is_array($in['photos'] ?? null) ? $in['photos'] : [],
            [$image],
            self::diskPhotos()
        ));

        return [
            'title' => mb_substr(trim((string) ($in['title'] ?? '')), 0, 80),
            'subtitle' => mb_substr(trim((string) ($in['subtitle'] ?? '')), 0, 140),
            'image' => $image,
            'color' => self::hex($in['color'] ?? '', '#1a1520'),
            'light' => max(40, min(140, (int) ($in['light'] ?? 100))),
            'veil' => $veil,
            'veil_opacity' => max(0, min(80, (int) ($in['veil_opacity'] ?? 40))),
            'title_color' => self::hex($in['title_color'] ?? '', '#ffffff'),
            'title_style' => $style,
            'text_size' => max(50, min(220, (int) ($in['text_size'] ?? 100))),
            'text_x' => $x,
            'text_y' => $y,
            'text_placed' => $placed,
            'writings' => array_key_exists('writings', $in)
                ? self::sanitizeWritings($in['writings'])
                : self::legacyWritings($in),
            'services' => self::sanitizeServices($in['services'] ?? null),
            'about' => self::sanitizeAbout($in['about'] ?? null),
            'photos' => $photos,
        ];
    }

    public static function save(array $in): array
    {
        self::$cache = null;
        $current = [];
        if (Storage::disk('local')->exists(self::FILE)) {
            $json = json_decode(Storage::disk('local')->get(self::FILE), true);
            if (is_array($json)) {
                $current = $json;
            }
        }
        if (! isset($in['photos']) && isset($current['photos'])) {
            $in['photos'] = $current['photos'];
        }
        if (! empty($in['image'])) {
            $in['photos'] = array_merge(
                is_array($in['photos'] ?? null) ? $in['photos'] : [],
                [(string) $in['image']]
            );
        }
        Storage::disk('local')->put(
            self::FILE,
            json_encode(self::sanitize($in), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
        );

        return self::current();
    }

    public static function reset(): array
    {
        self::$cache = null;
        $photos = self::archivePhotos(array_merge(
            self::current()['photos'] ?? [],
            self::diskPhotos()
        ));
        self::$cache = null;
        Storage::disk('local')->put(
            self::FILE,
            json_encode(self::sanitize(array_merge(self::defaults(), [
                'photos' => $photos,
            ])), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
        );

        return self::current();
    }

    public static function storeUpload(UploadedFile $file): string
    {
        $path = $file->store('habillage', 'public');

        return '/storage/'.$path;
    }

    public static function allowedImage(string $image): bool
    {
        if (in_array($image, self::LIBRARY, true)) {
            return true;
        }

        return (bool) preg_match('#^/storage/habillage/[A-Za-z0-9._-]+$#', $image);
    }

    public static function archivePhotos(array $list): array
    {
        $out = [];
        foreach (array_merge(self::LIBRARY, $list) as $image) {
            $image = (string) $image;
            if (! self::allowedImage($image) || in_array($image, $out, true)) {
                continue;
            }
            $out[] = $image;
            if (count($out) >= 60) {
                break;
            }
        }

        return $out;
    }

    private static function diskPhotos(): array
    {
        $out = [];
        foreach (Storage::disk('public')->files('habillage') as $path) {
            $name = basename($path);
            if (! preg_match('/^[A-Za-z0-9._-]+$/', $name)) {
                continue;
            }
            $out[] = '/storage/habillage/'.$name;
        }

        return $out;
    }

    private const WRITING_STYLES = ['enseigne', 'classique', 'signature', 'moderne', 'lisere', 'contour', 'neon'];

    private const WRITING_MODES = ['libre', 'lignes', 'bandeau', 'encadre', 'incline', 'vertical'];

    private const WRITING_LIGHTS = ['none', 'soft', 'glow', 'forte', 'neon', 'or', 'relief', 'halo'];

    private const WRITING_ZONES = ['hero', 'offres', 'chambres', 'services', 'promos', 'confiance', 'apropos'];

    private static function sanitizeLight(mixed $value): string
    {
        if (is_bool($value) || $value === 0 || $value === 1 || $value === '0' || $value === '1' || $value === 'true' || $value === 'false') {
            return filter_var($value, FILTER_VALIDATE_BOOLEAN) ? 'soft' : 'none';
        }
        $light = (string) $value;

        return in_array($light, self::WRITING_LIGHTS, true) ? $light : 'soft';
    }

    private static function sanitizeAbout(mixed $in): array
    {
        $defaults = self::defaultAbout();
        if (! is_array($in)) {
            return $defaults;
        }
        $styles = ['serif', 'moderne', 'signature', 'enseigne'];
        $style = (string) ($in['style'] ?? $defaults['style']);
        if (! in_array($style, $styles, true)) {
            $style = $defaults['style'];
        }
        $text = (string) ($in['text'] ?? $defaults['text']);
        $text = strip_tags($text, '<em>');
        $text = preg_replace('/\s+/u', ' ', $text) ?? $text;

        return [
            'bg' => self::hex((string) ($in['bg'] ?? ''), $defaults['bg']),
            'title' => mb_substr(trim((string) ($in['title'] ?? $defaults['title'])), 0, 80),
            'brand' => mb_substr(trim((string) ($in['brand'] ?? $defaults['brand'])), 0, 40),
            'title_color' => self::hex((string) ($in['title_color'] ?? ''), $defaults['title_color']),
            'accent' => self::hex((string) ($in['accent'] ?? ''), $defaults['accent']),
            'text' => mb_substr(trim($text), 0, 500),
            'text_color' => self::hex((string) ($in['text_color'] ?? ''), $defaults['text_color']),
            'style' => $style,
        ];
    }

    private static function sanitizeServices(mixed $list): array
    {
        $defaults = self::defaultServices();
        $byId = [];
        if (is_array($list)) {
            foreach ($list as $item) {
                if (! is_array($item)) {
                    continue;
                }
                $id = (string) ($item['id'] ?? '');
                if ($id === '') {
                    continue;
                }
                $byId[$id] = filter_var($item['visible'] ?? true, FILTER_VALIDATE_BOOLEAN);
            }
        }

        $out = [];
        foreach ($defaults as $svc) {
            $svc['visible'] = array_key_exists($svc['id'], $byId) ? $byId[$svc['id']] : true;
            $out[] = $svc;
        }

        return $out;
    }

    private static function sanitizeWritings(mixed $list): array
    {
        if (! is_array($list)) {
            return [];
        }

        $out = [];
        foreach (array_slice($list, 0, 30) as $item) {
            if (! is_array($item)) {
                continue;
            }
            $style = in_array($item['style'] ?? '', self::WRITING_STYLES, true) ? $item['style'] : 'classique';
            $mode = in_array($item['mode'] ?? '', self::WRITING_MODES, true) ? $item['mode'] : 'libre';
            $zone = in_array($item['zone'] ?? '', self::WRITING_ZONES, true) ? $item['zone'] : 'hero';
            $id = (string) ($item['id'] ?? '');
            if (! preg_match('/^w[A-Za-z0-9_-]{1,24}$/', $id)) {
                $id = 'w'.substr(bin2hex(random_bytes(4)), 0, 8);
            }
            $text = preg_replace('/[\s\x{00A0}\x{2000}-\x{200B}\x{202F}\x{205F}\x{3000}]+/u', ' ', (string) ($item['text'] ?? '')) ?? '';
            $text2 = preg_replace('/[\s\x{00A0}\x{2000}-\x{200B}\x{202F}\x{205F}\x{3000}]+/u', ' ', (string) ($item['text2'] ?? '')) ?? '';
            $text = mb_substr(trim($text), 0, 80);
            $text2 = mb_substr(trim($text2), 0, 140);
            if ($text === '' && $text2 === '') {
                continue;
            }
            $out[] = [
                'id' => $id,
                'text' => $text,
                'text2' => $text2,
                'style' => $style,
                'mode' => $mode,
                'color' => self::hex((string) ($item['color'] ?? ''), '#ffffff'),
                'size' => max(50, min(220, (int) ($item['size'] ?? 100))),
                'light' => self::sanitizeLight($item['light'] ?? 'soft'),
                'stars' => filter_var($item['stars'] ?? true, FILTER_VALIDATE_BOOLEAN),
                'zone' => $zone,
                'x' => self::percent($item['x'] ?? 50) ?? 50.0,
                'y' => self::percent($item['y'] ?? 50) ?? 50.0,
            ];
        }

        return $out;
    }

    private static function legacyWritings(array $in): array
    {
        $text = mb_substr(trim((string) ($in['title'] ?? '')), 0, 80);
        $text2 = mb_substr(trim((string) ($in['subtitle'] ?? '')), 0, 140);
        if ($text === '' && $text2 === '') {
            return [];
        }
        $style = in_array($in['title_style'] ?? '', self::WRITING_STYLES, true) ? $in['title_style'] : 'classique';
        $placed = filter_var($in['text_placed'] ?? false, FILTER_VALIDATE_BOOLEAN);
        $x = self::percent($in['text_x'] ?? null);
        $y = self::percent($in['text_y'] ?? null);
        if (! $placed || $x === null || $y === null) {
            $x = in_array($style, ['enseigne', 'signature', 'lisere'], true) ? 50.0 : 28.0;
            $y = in_array($style, ['enseigne', 'signature', 'lisere'], true) ? 50.0 : 78.0;
        }

        return [[
            'id' => 'wlegacy',
            'text' => $text,
            'text2' => $text2,
            'style' => $style,
            'mode' => $text2 !== '' ? 'lignes' : 'libre',
            'color' => self::hex((string) ($in['title_color'] ?? ''), '#ffffff'),
            'size' => max(50, min(220, (int) ($in['text_size'] ?? 100))),
            'light' => 'soft',
            'stars' => true,
            'zone' => 'hero',
            'x' => $x,
            'y' => $y,
        ]];
    }

    private static function percent(mixed $value): ?float
    {
        if ($value === null || $value === '') {
            return null;
        }
        if (! is_numeric($value)) {
            return null;
        }

        return round(max(0, min(100, (float) $value)), 1);
    }

    private static function hex(string $value, string $fallback): string
    {
        return preg_match('/^#[0-9a-fA-F]{6}$/', $value) ? strtolower($value) : $fallback;
    }

    private static function veilCss(string $veil, int $opacity): string
    {
        $alpha = number_format(max(0, min(80, $opacity)) / 100, 2, '.', '');
        if ($veil === 'navy') {
            return "rgba(6,15,36,{$alpha})";
        }
        if ($veil === 'gold') {
            return "rgba(120,78,18,{$alpha})";
        }

        return 'transparent';
    }
}
