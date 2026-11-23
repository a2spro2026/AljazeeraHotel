<?php

namespace App\Http\Controllers;

use App\Support\HotelReservations;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HotelReservationController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $this->authorizeSpace($request);

        return response()->json(HotelReservations::load());
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorizeSpace($request);

        $data = $request->validate([
            'resas' => ['nullable', 'array'],
            'log' => ['nullable', 'array'],
            'statuses' => ['nullable', 'array'],
        ]);

        return response()->json(HotelReservations::save([
            'resas' => $data['resas'] ?? [],
            'log' => $data['log'] ?? [],
            'statuses' => $data['statuses'] ?? [],
        ]));
    }

    private function authorizeSpace(Request $request): void
    {
        abort_unless($request->session()->get('space_admin'), 403, 'Connexion admin requise.');
    }
}
