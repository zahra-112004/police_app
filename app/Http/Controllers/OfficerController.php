<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Officer;
use Illuminate\Support\Facades\Auth;

class OfficerController extends Controller
{
    public function index(Request $request)
    {
        $officers = Officer::all();

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data petugas ditemukan',
                'data' => $officers,
            ]);
        }

        return view('officers.index', compact('officers'));
    }

    public function create(Request $request)
    {
        if ($request->wantsJson()) {
            return response()->json(['message' => 'Endpoint tidak tersedia untuk API'], 404);
        }

        return view('officers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'badge_number' => 'required|string|max:100|unique:officers,badge_number',
            'rank' => 'required|string|max:100',
            'assigned_area' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama petugas wajib diisi',
            'badge_number.required' => 'Nomor lencana wajib diisi',
            'badge_number.unique' => 'Nomor lencana sudah terdaftar',
            'rank.required' => 'Pangkat wajib diisi',
            'assigned_area.required' => 'Area tugas wajib diisi',
        ]);

        $officer = Officer::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data petugas berhasil ditambahkan',
                'data' => $officer,
            ], 201);
        }

        return redirect()->route('officers.index')->with('success', 'Petugas berhasil ditambahkan.');
    }

    public function show(Request $request, $id)
    {
        $officer = Officer::findOrFail($id);

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data petugas ditemukan',
                'data' => $officer,
            ]);
        }

        return redirect()->route('officers.index');
    }

    public function update(Request $request, $id)
    {
        $officer = Officer::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'badge_number' => 'required|string|max:100|unique:officers,badge_number,' . $officer->id,
            'rank' => 'required|string|max:100',
            'assigned_area' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama petugas wajib diisi',
            'badge_number.required' => 'Nomor lencana wajib diisi',
            'badge_number.unique' => 'Nomor lencana sudah terdaftar',
            'rank.required' => 'Pangkat wajib diisi',
            'assigned_area.required' => 'Area tugas wajib diisi',
        ]);

        $officer->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data petugas berhasil diubah',
                'data' => $officer,
            ]);
        }

        return redirect()->route('officers.index')->with('success', 'Data petugas berhasil diubah.');
    }

    public function destroy(Request $request, $id)
    {
        $officer = Officer::findOrFail($id);
        $officer->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data petugas berhasil dihapus',
                'data' => [],
            ]);
        }

        return redirect()->route('officers.index')->with('success', 'Data petugas berhasil dihapus.');
    }
}