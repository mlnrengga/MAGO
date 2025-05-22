<?php

namespace App\Http\Controllers;

use App\Models\Auth\AdminModel;
use App\Models\Auth\DosenPembimbingModel;
use App\Models\Auth\MahasiswaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
       $request->validate([
            'identifier' => 'required',
            'password' => 'required',
        ]);

        $user = null;

        // Check Mahasiswa
        $mahasiswa = MahasiswaModel::where('nim', $request->identifier)->first();
        if ($mahasiswa && Hash::check($request->password, $mahasiswa->user->password)) {
            $user = $mahasiswa->user;
            $user->assignRole('mahasiswa');
            $role = 'mahasiswa';
        }

        // Check Dosen
        $dosen = DosenPembimbingModel::where('nip', $request->identifier)->first();
        if ($dosen && Hash::check($request->password, $dosen->user->password)) {
            $user = $dosen->user;
            $user->assignRole('dosen_pembimbing');
            $role = 'dosen';
        }

        // Check Admin
        $admin = AdminModel::where('nip', $request->identifier)->first();
        if ($admin && Hash::check($request->password, $admin->user->password)) {
            $user = $admin->user;
            $user->assignRole('admin');
            $role = 'admin';
        }

        // Tidak ditemukan
        if (!$user){
            return back()->withErrors([
                'identifier' => 'Kredensial tidak valid',
            ]);
        }

        Auth::guard('web')->login($user);

        // Redirect berdasarkan role user
        switch ($role) {
            case 'mahasiswa':
                return redirect('/mahasiswa');
            case 'dosen':
                return redirect('/pembimbing');
            case 'admin':
                return redirect('/admin'); 
            default:
                return redirect('/login')->withErrors(['identifier' => 'Kredensial tidak valid']);
        }
    }
}
