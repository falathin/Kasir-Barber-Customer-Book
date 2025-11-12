<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\CustomerBook;
use App\Models\Note;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     *
     * Selain mengupdate data di tabel users, apabila kolom 'name' berubah
     * maka juga akan mengupdate:
     *  - notes.kasir_name (semua record yang sama dengan nama lama)
     *  - customer_books.barber_name (semua record yang sama dengan nama lama)
     *
     * Semua perubahan dibungkus dalam transaksi.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $oldName = $user->name;

        DB::beginTransaction();

        try {
            // Ganti atribut user dengan data yang tervalidasi
            $user->fill($request->validated());

            // Jika email berubah, reset verifikasi email
            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }

            $user->save();

            // Setelah save, cek apakah nama berubah
            if ($user->wasChanged('name')) {
                $newName = $user->name;

                // Update semua notes yang memiliki kasir_name sama dengan nama lama
                Note::where('kasir_name', $oldName)
                    ->update(['kasir_name' => $newName]);

                // Update semua customer_books yang memiliki barber_name sama dengan nama lama
                CustomerBook::where('barber_name', $oldName)
                    ->update(['barber_name' => $newName]);
            }

            DB::commit();

            return Redirect::route('profile.edit')->with('status', 'profile-updated');
        } catch (\Throwable $e) {
            DB::rollBack();

            // Opsional: log error di sini jika mau, mis. Log::error($e)
            return Redirect::route('profile.edit')
                ->with('status', 'profile-update-failed')
                ->with('error', 'Terjadi kesalahan saat memperbarui profil.');
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
