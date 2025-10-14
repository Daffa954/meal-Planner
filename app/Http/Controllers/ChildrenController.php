<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChildrenRequest;
use App\Http\Requests\UpdateChildrenRequest;
use App\Models\Children;
use App\Models\Preference;
use Auth;
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

        return redirect()->route('children.index')
            ->with('success', 'Profil anak berhasil ditambahkan!');
    }
    /**
     * Store a newly created resource in storage.
     */

    public function show(Children $child)
    {
        // Check authorization
        if ($child->user_id !== Auth::id()) {
            abort(403);
        }

        $child->load('preference', 'mealPlans.recipes.nutrition');

        return view('childrenShow', compact('child'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Children $child)
    {
        // Check authorization
        if ($child->user_id !== Auth::id()) {
            abort(403);
        }

        $child->load('preference');

        return view('editChildren', compact('child'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Children $child)
    {
        // Check authorization
        if ($child->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'age_years' => 'required|integer|min:0|max:18',
            'age_months' => 'required|integer|min:0|max:11',
            'gender' => 'required|in:male,female',
            'weight' => 'required|numeric|min:1|max:100',
            'height' => 'required|numeric|min:30|max:200',
            'allergens' => 'nullable|string',
            'favorite_foods' => 'nullable|string',
            'disliked_foods' => 'nullable|string',
            'lokasi' => 'nullable|string|max:255',
            'additional_notes' => 'nullable|string'
        ]);

        try {
            // Update child
            $child->update([
                'name' => $validated['name'],
                'age_years' => $validated['age_years'],
                'age_months' => $validated['age_months'],
                'gender' => $validated['gender'],
                'weight' => $validated['weight'],
                'height' => $validated['height']
            ]);

            // Update or create preference
            $preferenceData = [
                'allergens' => $validated['allergens'] ? explode(',', $validated['allergens']) : [],
                'favorite_foods' => $validated['favorite_foods'] ? explode(',', $validated['favorite_foods']) : [],
                'disliked_foods' => $validated['disliked_foods'] ? explode(',', $validated['disliked_foods']) : [],
                'lokasi' => $validated['lokasi'],
                'additional_notes' => $validated['additional_notes']
            ];

            if ($child->preference) {
                $child->preference->update($preferenceData);
            } else {
                Preference::create(array_merge(['child_id' => $child->id], $preferenceData));
            }

            return redirect()->route('children.index')
                ->with('success', 'Profil anak berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui profil anak: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $child = Children::findOrFail($id);

        // Check authorization
        if ($child->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action.'
            ], 403);
        }

        try {
            $child->delete();

            // Return JSON response for AJAX request
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Profil anak berhasil dihapus!'
                ]);
            }

            return redirect()->route('children.index')
                ->with('success', 'Profil anak berhasil dihapus!');

        } catch (\Exception $e) {
            // Return JSON response for AJAX request
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus profil anak: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Gagal menghapus profil anak: ' . $e->getMessage());
        }
    }
    public function index()
    {
        $children = Auth::user()->children()->with('preference')->get();

        return view('listChildren', compact('children'));
    }
    /**
     * Display the specified resource.
     */

    //

}
