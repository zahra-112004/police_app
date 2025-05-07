<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::where('user_id', Auth::id())->get();

        return response()->json([
            'status'  => 'success',
            'message' => 'data kendaraan ditemukan',
            'data'    => $vehicles
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'license_plate' => 'required|string|max:20',
            'type'          => 'required|string|max:20',
            'brand'         => 'required|string|max:50',
            'color'         => 'required|string|max:30',
            'is_stolen'     => 'required|boolean',
        ], [
            'license_plate.required' => 'Nomor polisi wajib diisi',
            'type.required'          => 'Jenis kendaraan wajib diisi',
            'brand.required'         => 'Merek kendaraan wajib diisi',
            'color.required'         => 'Warna kendaraan wajib diisi',
            'is_stolen.required'     => 'Status kehilangan wajib diisi',
            'is_stolen.boolean'      => 'Status kehilangan harus berupa true atau false',
        ]);

        $vehicle = Vehicle::create([
            'user_id'       => Auth::id(),
            'license_plate' => $validated['license_plate'],
            'type'          => $validated['type'],
            'brand'         => $validated['brand'],
            'color'         => $validated['color'],
            'is_stolen'     => $validated['is_stolen'],
        ]);

        if (!$vehicle) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menambahkan kendaraan',
                'data'    => []
            ], 400);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Kendaraan berhasil ditambahkan',
            'data'    => $vehicle
        ], 200);
    }

    public function show($id)
    {
        $vehicle = Vehicle::where('user_id', Auth::id())->find($id);

        if (!$vehicle) {
            return response()->json([
                'status'  => 'failed',
                'message' => 'Kendaraan tidak ditemukan',
                'data'    => []
            ], 404);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Data kendaraan ditemukan',
            'data'    => $vehicle
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::where('user_id', Auth::id())->find($id);

        if (!$vehicle) {
            return response()->json([
                'status'  => 'failed',
                'message' => 'Kendaraan tidak ditemukan',
                'data'    => []
            ], 404);
        }

        $validated = $request->validate([
            'license_plate' => 'required|string|max:20',
            'type'          => 'required|string|max:20',
            'brand'         => 'required|string|max:50',
            'color'         => 'required|string|max:30',
            'is_stolen'     => 'required|boolean',
        ]);

        $vehicle->update($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Data kendaraan berhasil diperbarui',
            'data'    => $vehicle
        ], 200);
    }

    public function destroy($id)
    {
        $vehicle = Vehicle::where('user_id', Auth::id())->find($id);

        if (!$vehicle) {
            return response()->json([
                'status'  => 'failed',
                'message' => 'Kendaraan tidak ditemukan',
                'data'    => []
            ], 404);
        }

        $vehicle->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Data kendaraan berhasil dihapus',
            'data'    => []
        ], 200);
    }
}