<?php

namespace App\Support;

use Illuminate\Support\Facades\File;

class HotelReservations
{
    public static function path(): string
    {
        return storage_path('app/hotel_reservations.json');
    }

    public static function load(): array
    {
        $path = self::path();
        if (! File::exists($path)) {
            return ['resas' => new \stdClass, 'log' => [], 'statuses' => new \stdClass];
        }

        $data = json_decode(File::get($path), true);

        return [
            'resas' => $data['resas'] ?? new \stdClass,
            'log' => is_array($data['log'] ?? null) ? $data['log'] : [],
            'statuses' => $data['statuses'] ?? new \stdClass,
        ];
    }

    public static function save(array $payload): array
    {
        $resas = $payload['resas'] ?? [];
        $statuses = $payload['statuses'] ?? [];
        if (is_array($resas) && $resas === []) {
            $resas = new \stdClass;
        } elseif (is_array($resas)) {
            $resas = (object) $resas;
        }
        if (is_array($statuses) && $statuses === []) {
            $statuses = new \stdClass;
        } elseif (is_array($statuses)) {
            $statuses = (object) $statuses;
        }

        $data = [
            'resas' => $resas,
            'log' => is_array($payload['log'] ?? null) ? array_values($payload['log']) : [],
            'statuses' => $statuses,
            'updated_at' => now()->toIso8601String(),
        ];

        File::ensureDirectoryExists(dirname(self::path()));
        File::put(self::path(), json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        return [
            'resas' => $data['resas'],
            'log' => $data['log'],
            'statuses' => $data['statuses'],
        ];
    }
}
