<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class FoodController extends Controller
{
    use AuthorizesRequests;
    public function create()
    {
        return view('foods.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_available' => 'boolean',
            'show_in_other_menu' => 'boolean',
        ]);
        
        // Handle file upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('foods', 'public');
            $validated['image'] = $path;
        }
        
        // Set default values
        $validated['seller_id'] = auth()->id();
        $validated['is_available'] = $request->has('is_available');
        $validated['show_in_other_menu'] = $request->has('show_in_other_menu');
        
        // Create the food item
        Food::create($validated);
        
        return redirect('/dashboard')
            ->with('success', 'Menu berhasil ditambahkan!');
    }

    public function create2()
    {
        return view('foods.create2');
    }

    public function store2(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_available' => 'boolean',
            'show_in_other_menu' => 'boolean',
        ]);
        
        // Handle file upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('foods', 'public');
            $validated['image'] = $path;
        }
        
        // Set default values
        $validated['seller_id'] = auth()->id();
        $validated['is_available'] = $request->has('is_available');
        $validated['show_in_other_menu'] = true; // Always true for mahasiswa
        
        // Create the food item
        Food::create($validated);
        
        return redirect('/dashboard')
            ->with('success', 'Menu berhasil ditambahkan!');
    }

    public function toggleAvailability(Food $food)
    {
        $this->authorize('update', $food);
        
        $food->update([
            'is_available' => !$food->is_available
        ]);
        
        return back()->with('success', 'Status ketersediaan menu berhasil diubah');
    }
    
    public function incrementDeliveryCount(Food $food)
    {
        $this->authorize('update', $food);
        
        $food->increment('delivery_count');
        
        return back()->with('success', 'Jumlah pengantaran berhasil ditambahkan');
    }

    public function edit(Food $food)
    {
        $this->authorize('update', $food);
        return view('foods.edit', compact('food'));
    }

    public function update(Request $request, Food $food)
    {
        $this->authorize('update', $food);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_available' => 'boolean',
            'show_in_other_menu' => 'boolean',
        ]);
        
        // Handle file upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($food->image) {
                Storage::disk('public')->delete($food->image);
            }
            $path = $request->file('image')->store('foods', 'public');
            $validated['image'] = $path;
        }
        
        $validated['is_available'] = $request->has('is_available');
        
        // Set show_in_other_menu based on user role
        if (auth()->user()->role === 'mahasiswa') {
            // For mahasiswa, always set show_in_other_menu to true
            $validated['show_in_other_menu'] = true;
        } else {
            // For sellers, use the value from the form
            $validated['show_in_other_menu'] = $request->boolean('show_in_other_menu');
        }
        
        $food->update($validated);
        
        return redirect()->route('dashboard')
            ->with('success', 'Menu berhasil diperbarui!');
    }

    public function publicMenu()
    {
        $foods = Food::with(['seller', 'ratings'])
            ->withAvg('ratings as average_rating', 'rating')
            ->where('is_available', true)
            ->where('show_in_other_menu', true)
            ->latest()
            ->paginate(12);
            
        return view('lainnya.public', compact('foods'));
    }

    public function destroy(Food $food)
    {
        $this->authorize('delete', $food);
        
        // Delete the image if it exists
        if ($food->image) {
            Storage::disk('public')->delete($food->image);
        }
        
        $food->delete();
        
        return redirect()->route('dashboard')
            ->with('success', 'Menu berhasil dihapus!');
    }
}
