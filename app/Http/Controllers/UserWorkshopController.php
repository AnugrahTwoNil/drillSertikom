<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\Workshop;
use Illuminate\Http\Request;

class UserWorkshopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $dataWorkshop = Workshop::query()
            ->withCount(['registrations as taken_count' => function ($q) {
                $q->whereIn('status', ['pending', 'paid']);
            }])
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('judul', 'like', "%{$search}%")
                        ->orWhere('deskripsi', 'like', "%{$search}%");
                });
            })
            ->when($request->boolean('available'), function ($query) {
                $query->where(function ($q) {
                    $q->whereNull('capacity') 
                        ->orWhereRaw(
                            'capacity > (select count(*) from registrations
                                        where registrations.workshop_id = workshops.id
                                        and registrations.status in (?, ?))',
                            ['pending', 'paid']
                        );
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('user.workshops.index', compact('dataWorkshop'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dataWorkshop = Workshop::with('workshop')->findOrFail($id);

        return view('user.show', compact('dataWorkshop'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
