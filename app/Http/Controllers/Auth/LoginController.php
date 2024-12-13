<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Tenter de connecter l'utilisateur
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            // Vérifier si l'utilisateur est un admin
            if ($user->role !== User::ROLE_ADMIN) {
                Auth::logout();
                return redirect()->back()->withErrors(['email' => 'Vous n\'avez pas accès à cette zone.']);
            }

            // Rediriger vers la page d'accueil de l'admin
            return redirect()->intended('/admin/dashboard'); // Change ce chemin selon ta route admin
        }

        // En cas d'échec de connexion
        return redirect()->back()->withErrors(['email' => 'Identifiants incorrects.']);
    }

    // Autres méthodes, comme showLoginForm()
}

