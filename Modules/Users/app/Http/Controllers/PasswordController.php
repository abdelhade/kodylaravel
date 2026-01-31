<?php

namespace Modules\Users\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function showChangeForm()
    {
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('users::password.change', compact('settings', 'lang', ));
    }

    public function change(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6',
            'confirm_new_password' => 'required|string|same:new_password',
        ], [
            'confirm_new_password.same' => 'كلمات المرور غير متطابقة',
            'new_password.min' => 'يجب أن تكون كلمة المرور 6 أحرف على الأقل',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $userId = session('userid');
        if (!$userId) {
            return redirect()->back()->with('error', 'يجب تسجيل الدخول أولاً');
        }

        // Get current user
        $user = DB::table('users')->where('id', $userId)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'المستخدم غير موجود');
        }

        // Verify current password
        $currentPassword = $request->current_password;
        $storedPassword = $user->password ?? '';

        // Check password according to encryption type (supports bcrypt, MD5, and plain text)
        $passwordMatches = false;
        
        // Check if password is bcrypt/argon (60+ chars or starts with $2y$, $2a$, $argon)
        if (strlen($storedPassword) >= 60 || str_starts_with($storedPassword, '$2y$') || 
            str_starts_with($storedPassword, '$2a$') || str_starts_with($storedPassword, '$argon')) {
            // Password is hashed with password_hash
            if (Hash::check($currentPassword, $storedPassword) || password_verify($currentPassword, $storedPassword)) {
                $passwordMatches = true;
            }
        } elseif (strlen($storedPassword) === 32) {
            // Password is MD5 hashed (legacy support)
            if (md5($currentPassword) === $storedPassword) {
                $passwordMatches = true;
            }
        } else {
            // Try password_verify as fallback
            if (password_verify($currentPassword, $storedPassword)) {
                $passwordMatches = true;
            } elseif ($currentPassword === $storedPassword) {
                // Plain text fallback (legacy)
                $passwordMatches = true;
            }
        }

        if (!$passwordMatches) {
            return redirect()->back()->with('error', 'كلمة المرور الحالية غير صحيحة')->withInput();
        }

        // Update password - Use MD5 to match legacy system behavior
        // Note: In production, consider migrating to bcrypt for better security
        $hashedPassword = md5($request->new_password);

        DB::table('users')
            ->where('id', $userId)
            ->update([
                'password' => $hashedPassword,
                'updated_at' => now(),
            ]);

        DB::table('process')->insert([
            'type' => 'change password',
            'created_at' => now(),
        ]);

        return redirect()->route('kody2.dashboard')
            ->with('success', 'تم تغيير كلمة المرور بنجاح');
    }
}