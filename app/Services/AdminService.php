<?php

namespace App\Services;

use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminService {
    public function login($username, $password) {
        // Attempt login with username and password credential retrieved from parameters
        $attempt = Auth::guard('admin')->attempt([
            'username' => $username,
            'password' => $password,
        ]);
        $message = "Login berhasil.";

        if (!$attempt) {
            // Change $message value when failed to attempt authentication, mostly due to incorrect credentials combination
            $message = "Login gagal. Kombinasi username dan password tidak tepat";
        }

        return [
            'status' => $attempt,
            'message' => $message,
        ];
    }
    public function loginManually($username, $password) {
        // Use this method if we need to modify user's record like updating token (login via API)

        $message = "";
        $adm = Admin::where('username', $username); // Build Admin model query
        $admin = $adm->first(); // Retrieve admin data
        $attempt = false; // Define default status

        if ($admin == "") {
            // If the record is empty or null, change $message value
            $message = "Kami tidak dapat menemukan akun Anda.";

            // We don't need to change anything else due to $attempt has defined as false already
        } else {
            // Checking user's input with default Laravel's password encryption (bcrypt)
            $attempt = Hash::check($password, $admin->password);

            if (!$attempt) {
                $message = "Login gagal. Kombinasi username dan password tidak tepat";
            } else {
                $message = "Login berhasil.";
                
                // Store session into Laravel's auth system based on given user's ID
                Auth::loginUsingId($admin->id);
            }
        }

        return [
            'status' => $attempt,
            'message' => $message,
        ];
    }
    public function logout() {
        return Auth::guard('admin')->logout();
    }
    public function me() {
        return Auth::guard('admin')->user();
    }
}