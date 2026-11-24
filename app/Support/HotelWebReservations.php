<?php

namespace App\Support;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class HotelWebReservations
{
    public static function path(): string
    {
        return storage_path('app/hotel_web_reservations.json');
    }

    public static function load(): array
    {
        $path = self::path();
        if (! File::exists($path)) {
            return ['items' => []];
        }

        $data = json_decode(File::get($path), true);

        return [
            'items' => is_array($data['items'] ?? null) ? array_values($data['items']) : [],
        ];
    }

    public static function save(array $items): array
    {
        $payload = [
            'items' => array_values($items),
            'updated_at' => now()->toIso8601String(),
        ];

        File::ensureDirectoryExists(dirname(self::path()));
        File::put(self::path(), json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        return $payload;
    }

    public static function add(array $data): array
    {
        $store = self::load();
        $item = [
            'id' => (string) Str::uuid(),
            'ref' => (string) ($data['ref'] ?? ''),
            'date' => (string) ($data['date'] ?? now()->toDateString()),
            'num' => (string) ($data['num'] ?? ''),
            'title' => (string) ($data['title'] ?? ''),
            'nom' => (string) ($data['nom'] ?? ''),
            'nationalite' => (string) ($data['nationalite'] ?? ''),
            'idType' => (string) ($data['idType'] ?? ''),
            'cin' => (string) ($data['cin'] ?? ''),
            'personnes' => (int) ($data['personnes'] ?? 1),
            'nuits' => (int) ($data['nuits'] ?? 1),
            'arrivee' => (string) ($data['arrivee'] ?? ''),
            'depart' => (string) ($data['depart'] ?? ''),
            'tel' => (string) ($data['tel'] ?? ''),
            'email' => (string) ($data['email'] ?? ''),
            'price' => (float) ($data['price'] ?? 0),
            'status' => 'en_attente',
            'source' => 'web',
            'read' => false,
            'at' => now()->toIso8601String(),
        ];
        $store['items'][] = $item;
        self::save($store['items']);

        return $item;
    }

    public static function unreadCount(): int
    {
        return count(array_filter(self::load()['items'], fn ($i) => empty($i['read'])));
    }

    public static function markRead(?array $ids = null): array
    {
        $store = self::load();
        $items = $store['items'];
        foreach ($items as &$item) {
            if ($ids === null || in_array($item['id'] ?? '', $ids, true)) {
                $item['read'] = true;
            }
        }
        unset($item);

        return self::save($items);
    }

    public static function find(string $id): ?array
    {
        foreach (self::load()['items'] as $item) {
            if (($item['id'] ?? '') === $id) {
                return $item;
            }
        }

        return null;
    }

    /** Retire les alertes (après transfert vers Réservations) */
    public static function remove(?array $ids = null): array
    {
        $items = self::load()['items'];
        if ($ids === null) {
            $items = [];
        } else {
            $items = array_values(array_filter(
                $items,
                fn ($item) => ! in_array($item['id'] ?? '', $ids, true)
            ));
        }

        return self::save($items);
    }
}
