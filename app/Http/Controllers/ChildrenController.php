<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChildrenRequest;
use App\Http\Requests\UpdateChildrenRequest;
use App\Models\Children;
use App\Models\Preference;
use Illuminate\Http\Request;

class ChildrenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function create()
    {
        return view('addChildren');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'age_years' => 'required|integer|min:0|max:12',
            'age_months' => 'required|integer|min:0|max:11',
            'gender' => 'required|in:male,female',
            'weight' => 'required|numeric|min:1|max:100',
            'height' => 'required|numeric|min:30|max:200',
            // Step 2 fields
            'allergens' => 'nullable|array',
            'favorite_foods' => 'nullable|array',
            
            'lokasi' => 'nullable|string|max:255',
            
        ]);

        // Calculate total age in months
        // $totalAgeMonths = ($validated['age_years'] * 12) + $validated['age_months'];

        // Handle photo upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('children-photos', 'public');
        }

        // Create child
        $child = Children::create([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'age_years' => $validated['age_years'],
            'age_months' => $validated['age_months'],

            'gender' => $validated['gender'],
            'weight' => $validated['weight'],
            'height' => $validated['height'],
        ]);

        // Create preferences
        Preference::create([
            'children_id' => $child->id,
            'allergens' => $validated['allergens'] ?? [],
            'favorite_foods' => $validated['favorite_foods'] ?? [],
            
            'lokasi' => $validated['lokasi'],
            
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Profil anak berhasil ditambahkan!');
    }
    /**
     * Store a newly created resource in storage.
     */



    /**
     * Display the specified resource.
     */
    public function show(Children $children)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Children $children)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChildrenRequest $request, Children $children)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Children $children)
    {
        //
    }
}
