<?php

namespace App\Http\Controllers;

use App\Support\HotelWebReservations;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HotelWebReservationController extends Controller
{
    /** Demande publique (site externe) */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'ref' => ['nullable', 'string', 'max:40'],
            'date' => ['nullable', 'string', 'max:20'],
            'num' => ['required', 'string', 'max:20'],
            'title' => ['nullable', 'string', 'max:120'],
            'nom' => ['required', 'string', 'max:160'],
            'nationalite' => ['nullable', 'string', 'max:80'],
            'idType' => ['nullable', 'string', 'max:40'],
            'cin' => ['required', 'string', 'max:60'],
            'personnes' => ['nullable', 'integer', 'min:1', 'max:20'],
            'nuits' => ['nullable', 'integer', 'min:1', 'max:90'],
            'arrivee' => ['nullable', 'string', 'max:20'],
            'depart' => ['nullable', 'string', 'max:20'],
            'tel' => ['required', 'string', 'max:40'],
            'email' => ['required', 'email', 'max:160'],
            'price' => ['nullable', 'numeric', 'min:0'],
        ]);

        $item = HotelWebReservations::add($data);

        return response()->json([
            'ok' => true,
            'item' => $item,
            'unread' => HotelWebReservations::unreadCount(),
        ], 201);
    }

    /** Liste admin */
    public function index(Request $request): JsonResponse
    {
        $this->authorizeSpace($request);

        $items = HotelWebReservations::load()['items'];
        usort($items, fn ($a, $b) => strcmp((string) ($b['at'] ?? ''), (string) ($a['at'] ?? '')));

        return response()->json([
            'items' => $items,
            'unread' => HotelWebReservations::unreadCount(),
        ]);
    }

    /** Compteur non lus (polling léger) */
    public function unread(Request $request): JsonResponse
    {
        $this->authorizeSpace($request);

        return response()->json([
            'unread' => HotelWebReservations::unreadCount(),
        ]);
    }

    /** Marquer comme lu */
    public function markRead(Request $request): JsonResponse
    {
        $this->authorizeSpace($request);

        $data = $request->validate([
            'ids' => ['nullable', 'array'],
            'ids.*' => ['string'],
        ]);

        $saved = HotelWebReservations::markRead($data['ids'] ?? null);

        return response()->json([
            'ok' => true,
            'items' => $saved['items'],
            'unread' => HotelWebReservations::unreadCount(),
        ]);
    }

    /** Transfert effectué → retirer l'alerte de la cloche */
    public function remove(Request $request): JsonResponse
    {
        $this->authorizeSpace($request);

        $data = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['string'],
        ]);

        $saved = HotelWebReservations::remove($data['ids']);

        return response()->json([
            'ok' => true,
            'items' => $saved['items'],
            'unread' => HotelWebReservations::unreadCount(),
        ]);
    }

    private function authorizeSpace(Request $request): void
    {
        abort_unless($request->session()->get('space_admin'), 403, 'Connexion admin requise.');
    }
}
