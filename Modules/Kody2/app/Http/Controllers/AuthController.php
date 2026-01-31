<?php

namespace Modules\Kody2\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function loginForm()
    {
        if (session('login')) {
            return redirect()->route('kody2.dashboard');
        }

        $users = DB::table('users')
                    ->select('id', 'uname')
                    ->where('isdeleted', '!=', 1)
                    ->orderBy('id', 'ASC')
                    ->get();

        return view('kody2::auth.login', compact('users'));
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

            // Check if password_verify works (for bcrypt/argon)
            if (password_verify($request->password, $storedHash)) {
                $check = true;
                if (password_needs_rehash($storedHash, PASSWORD_DEFAULT)) {
                     $newHash = password_hash($request->password, PASSWORD_DEFAULT);
                     DB::table('users')->where('id', $user->id)->update(['password' => $newHash]);
                }
            } 
            // Fallback for MD5 (legacy)
            elseif (strlen($storedHash) === 32 && md5($request->password) === $storedHash) {
                $check = true;
                // Rehash to secure storage
                $newHash = password_hash($request->password, PASSWORD_DEFAULT);
                DB::table('users')->where('id', $user->id)->update(['password' => $newHash]);
            }

            if ($check) {
                // Set Session Variables
                session([
                    'userid' => $user->id,
                    'usrole' => $user->userrole,
                    'usty' => $user->usertype,
                    'login' => $user->uname,
                ]);
                
                // Log session time if table exists
                try {
                     DB::table('session_time')->insert(['user' => $user->id]);
                } catch (\Exception $e) {
                    // Ignore if table doesn't exist
                }

                return redirect()->route('kody2.dashboard');
            }
        }

        return back()->withErrors(['uname' => 'اسم المستخدم أو كلمة المرور غير صحيحة']);
    }
    
    public function logout()
    {
        Session::flush();
        return redirect()->route('kody2.login');
    }
}
