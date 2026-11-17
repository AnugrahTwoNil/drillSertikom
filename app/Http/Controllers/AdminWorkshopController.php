<?php

namespace App\Http\Controllers;

use App\Models\Workshop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminWorkshopController extends Controller
{
    public function index(Request $request)
    {
        $dataWorkshop = Workshop::withCount([
                'registrations as taken_count' => fn ($q) => $q->whereIn('status', ['pending', 'paid']),
            ])
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('judul', 'like', "%{$search}%")
                        ->orWhere('deskripsi', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.index', compact('dataWorkshop'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:50',
            'deskripsi' => 'required|string',
            'foto' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'capacity' => 'nullable|integer|min:5',
            'harga' => 'required|integer|min:1000|max:10000000',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('event', 'public');
        }

        Workshop::create($validated);

        return redirect()->route('adminWorkshop.index')
            ->with('success', 'Workshop berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $dataWorkshop = Workshop::findOrFail($id);

        return view('admin.edit', compact('dataWorkshop'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:50',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'capacity' => 'nullable|integer|min:5',
            'harga' => 'required|integer|min:1000|max:10000000',
        ]);

        $dataWorkshop = Workshop::findOrFail($id);

        if ($request->hasFile('foto')) {
            if ($dataWorkshop->foto) {
                Storage::disk('public')->delete($dataWorkshop->foto);
            }
            $validated['foto'] = $request->file('foto')->store('event', 'public');
        }

        $dataWorkshop->update($validated);

        return redirect()->route('adminWorkshop.index')
            ->with('success', 'Workshop berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $dataWorkshop = Workshop::findOrFail($id);

        if ($dataWorkshop->foto) {
            Storage::disk('public')->delete($dataWorkshop->foto);
        }

        $dataWorkshop->delete();

        return redirect()->route('adminWorkshop.index')
            ->with('success', 'Workshop berhasil dihapus.');
    }
}