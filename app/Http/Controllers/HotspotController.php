<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HotspotController extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter dari MikroTik (router akan kirim via query)
        $mac = $request->query('mac', 'AA:BB:CC:DD:EE:FF');
        $ip = $request->query('ip', $request->ip());
        $username = $request->query('username', '');

        // Prefer 'link-orig' lalu 'link-login'
        $link = $request->query('link-orig', $request->query('link-login', null));

        return view('login', compact('mac', 'ip', 'username', 'link'));
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $username = $request->input('username');
        $password = $request->input('password');
        $mac = $request->input('mac');
        $ip = $request->input('ip');

        // Ambil link dari form hidden (atau fallback ke query)
        $link = $request->input('link', $request->input('link-orig', $request->input('link-login', null)));

        // >>> Ganti logika ini dengan cek database / LDAP di production
        $ok = ($username === 'admin' && $password === '1234');

        if (! $ok) {
            // kembalikan ke form dengan pesan error
            return back()->withInput()->with('error', 'Invalid username or password');
        }

        // Jika router memberi "link" -> lakukan post-back ke router agar router
        // menandai client sebagai authenticated (external UAM flow)
        if ($link) {
            // Render view yang auto-submit POST ke $link (tanpa CSRF)
            return view('post-back', compact('link', 'username', 'password', 'ip', 'mac'));
        }

        // Jika tidak ada link (mis. testing), set session lokal dan redirect ke status
        session(['user_id' => 1, 'username' => $username]);

        return redirect()->route('status')->with('info', 'Login successful');
    }

    public function status()
    {
        // Pastikan user ter-set di session
        if (! session('user_id')) {
            return redirect()->route('login');
        }

        return view('status');
    }

    public function logout()
    {
        // Hapus session
        session()->forget(['user_id', 'username']);
        return redirect()->route('login')->with('info', 'Logged out');
    }

    public function error()
    {
        return view('error'); // optional: buat view error kalau perlu
    }
}
