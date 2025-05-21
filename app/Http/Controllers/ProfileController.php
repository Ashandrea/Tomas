<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['required', 'string', 'max:20', 'unique:users,phone,' . $user->id],
            'nim' => ['nullable', 'string', 'max:20', 'unique:users,nim,' . $user->id],
            'photo' => ['nullable', 'image', 'max:2048'],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'nim' => $request->nim,
        ];

        if ($request->hasFile('photo')) {
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            $data['profile_photo'] = $request->file('photo')->store('profile-photos', 'public');
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('profile.edit')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePhoto(Request $request)
    {
        try {
            $request->validate([
                'photo' => [
                    'required',
                    'image',
                    'mimes:jpeg,png,jpg,gif',
                    'max:2048', // 2MB
                ],
            ], [
                'photo.required' => 'Harap pilih foto profil.',
                'photo.image' => 'File yang diunggah harus berupa gambar.',
                'photo.mimes' => 'Format file yang didukung: jpeg, png, jpg, gif.',
                'photo.max' => 'Ukuran file tidak boleh melebihi 2MB.',
            ]);

            $user = auth()->user();

            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $path = $request->file('photo')->store('profile-photos', 'public');
            $user->update([
                'profile_photo' => $path,
            ]);

            return redirect()->route('profile.edit')
                ->with('success', 'Foto profil berhasil diperbarui.');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)
                        ->withInput()
                        ->with('error', 'Gagal mengunggah foto. ' . 
                            ($e->validator->errors()->first('photo') ?? 'Terjadi kesalahan.'));
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengunggah foto. Silakan coba lagi.');
        }
    }

    /**
     * Update the user's cover photo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateCoverPhoto(Request $request)
    {
        try {
            $request->validate([
                'cover_photo' => [
                    'required',
                    'image',
                    'mimes:jpeg,png,jpg,gif',
                    'max:5120', // 5MB
                ],
            ], [
                'cover_photo.required' => 'Harap pilih foto sampul.',
                'cover_photo.image' => 'File yang diunggah harus berupa gambar.',
                'cover_photo.mimes' => 'Format file yang didukung: jpeg, png, jpg, gif.',
                'cover_photo.max' => 'Ukuran file tidak boleh melebihi 5MB.',
            ]);

            $user = auth()->user();

            // Delete old cover photo if exists
            if ($user->cover_photo) {
                Storage::disk('public')->delete($user->cover_photo);
            }

            // Store new cover photo
            $path = $request->file('cover_photo')->store('cover-photos', 'public');
            
            $user->update([
                'cover_photo' => $path,
            ]);

            return redirect()->route('profile.edit')
                ->with('success', 'Foto sampul berhasil diperbarui.');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)
                        ->withInput()
                        ->with('error', 'Gagal mengunggah foto sampul. ' . 
                            ($e->validator->errors()->first('cover_photo') ?? 'Terjadi kesalahan.'));
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengunggah foto sampul. Silakan coba lagi.');
        }
    }

    /**
     * Show the specified user's profile.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function show(User $user)
    {
        $user->load(['foods' => function($query) {
            $query->withCount(['orders', 'likes']);
        }]);
        
        // Get the IDs of foods liked by the current user
        $likedFoodIds = [];
        if (auth()->check()) {
            $likedFoodIds = auth()->user()->likedFoods()->pluck('food_id')->toArray();
        }

        return view('profile.show', [
            'user' => $user,
            'likedFoodIds' => $likedFoodIds
        ]);
    }
    
    /**
     * Delete the user's profile photo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyPhoto(Request $request)
    {
        $user = $request->user();

        if ($user->profile_photo) {
            // Delete the photo from storage
            Storage::disk('public')->delete($user->profile_photo);
            
            // Update the user's profile_photo to null
            $user->update(['profile_photo' => null]);

            return back()->with('success', 'Foto profil berhasil dihapus.');
        }

        return back()->with('error', 'Tidak ada foto profil yang bisa dihapus.');
    }
}