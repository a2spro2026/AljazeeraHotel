<?php

namespace App\Http\Controllers;

use App\Support\Habillage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HabillageController extends Controller
{
    public function update(Request $request): JsonResponse
    {
        $this->authorizeAdmin($request);

        $rawWritings = $request->input('writings');
        if (is_string($rawWritings)) {
            $decoded = json_decode($rawWritings, true);
            $rawWritings = is_array($decoded) ? $decoded : [];
        }
        $rawPhotos = $request->input('photos');
        if (is_string($rawPhotos)) {
            $decodedPhotos = json_decode($rawPhotos, true);
            $rawPhotos = is_array($decodedPhotos) ? $decodedPhotos : null;
        }
        $rawServices = $request->input('services');
        if (is_string($rawServices)) {
            $decodedServices = json_decode($rawServices, true);
            $rawServices = is_array($decodedServices) ? $decodedServices : null;
        }
        $rawAbout = $request->input('about');
        if (is_string($rawAbout)) {
            $decodedAbout = json_decode($rawAbout, true);
            $rawAbout = is_array($decodedAbout) ? $decodedAbout : null;
        }

        $data = $request->validate([
            'title' => ['nullable', 'string', 'max:80'],
            'subtitle' => ['nullable', 'string', 'max:140'],
            'image' => ['nullable', 'string', 'max:255'],
            'color' => ['nullable', 'string', 'max:7'],
            'light' => ['nullable', 'integer', 'min:40', 'max:140'],
            'veil' => ['nullable', 'in:none,navy,gold'],
            'veil_opacity' => ['nullable', 'integer', 'min:0', 'max:80'],
            'title_color' => ['nullable', 'string', 'max:7'],
            'title_style' => ['nullable', 'in:enseigne,classique,signature,moderne,lisere'],
            'text_size' => ['nullable', 'integer', 'min:50', 'max:220'],
            'text_x' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'text_y' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'text_placed' => ['nullable', 'boolean'],
            'image_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        if (is_array($rawWritings)) {
            $data['writings'] = $rawWritings;
        }
        if (is_array($rawPhotos)) {
            $data['photos'] = $rawPhotos;
        }
        if (is_array($rawServices)) {
            $data['services'] = $rawServices;
        }
        if (is_array($rawAbout)) {
            $data['about'] = $rawAbout;
        }

        if ($request->hasFile('image_file')) {
            $uploaded = Habillage::storeUpload($request->file('image_file'));
            $data['image'] = $uploaded;
            $data['photos'] = array_merge(
                is_array($data['photos'] ?? null) ? $data['photos'] : [],
                [$uploaded]
            );
        }

        return response()->json(Habillage::save($data));
    }

    public function destroy(Request $request): JsonResponse
    {
        $this->authorizeAdmin($request);

        return response()->json(Habillage::reset());
    }

    private function authorizeAdmin(Request $request): void
    {
        abort_unless($request->session()->get('space_admin'), 403);
    }
}
