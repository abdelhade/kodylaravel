<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (session('login')) {
            return redirect()->route('dashboard.index');
        }

        $users = DB::table('users')
                    ->select('id', 'uname')
                    ->where('isdeleted', '!=', 1)
                    ->orderBy('id', 'ASC')
                    ->get();

        return view('auth.login', compact('users'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'uname' => 'required',
            'password' => 'required',
        ]);

        $user = DB::table('users')
                    ->where('uname', $request->uname)
                    ->where('isdeleted', '!=', 1)
                    ->first();

        if ($user) {
            $check = false;
            $storedHash = $user->password;

            if (password_verify($request->password, $storedHash)) {
                $check = true;
                if (password_needs_rehash($storedHash, PASSWORD_DEFAULT)) {
                     $newHash = password_hash($request->password, PASSWORD_DEFAULT);
                     DB::table('users')->where('id', $user->id)->update(['password' => $newHash]);
                }
            } 
            elseif (strlen($storedHash) === 32 && md5($request->password) === $storedHash) {
                $check = true;
                $newHash = password_hash($request->password, PASSWORD_DEFAULT);
                DB::table('users')->where('id', $user->id)->update(['password' => $newHash]);
            }

            if ($check) {
                session([
                    'userid' => $user->id,
                    'usrole' => $user->userrole,
                    'usty' => $user->usertype,
                    'login' => $user->uname,
                ]);
                
                try {
                     DB::table('session_time')->insert(['user' => $user->id]);
                } catch (\Exception $e) {}

                return redirect()->route('dashboard.index');
            }
        }

        return back()->withErrors(['uname' => 'Invalid username or password']);
    }
    
    public function logout()
    {
        Session::flush();
        return redirect()->route('login');
    }
}
