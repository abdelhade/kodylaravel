<?php

namespace Modules\Users\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    public function index()
    {
        $users = DB::table('users')
            ->orderBy('id', 'desc')
            ->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('users::index', compact('users', 'settings', 'lang', ));
    }

    public function create()
    {
        $roles = DB::table('usr_pwrs')
            ->orderBy('id')
            ->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('users::create', compact('roles', 'settings', 'lang'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uname' => 'required|string|max:20',
            'password' => 'required|string|min:1',
            'userrole' => 'required|integer|exists:usr_pwrs,id',
            'img' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $password = md5($request->password);
        $imgName = null;

        // Handle image upload
        if ($request->hasFile('img') && $request->file('img')->isValid()) {
            $file = $request->file('img');
            $extension = $file->getClientOriginalExtension();
            $allowedExt = ['jpg', 'png', 'gif', 'jpeg'];
            
            if (!in_array(strtolower($extension), $allowedExt)) {
                return redirect()->back()->with('error', 'امتداد الملف غير مسموح به')->withInput();
            }

            if ($file->getSize() > 2000000) {
                return redirect()->back()->with('error', 'حجم الملف أكبر من 2 ميجا بايت')->withInput();
            }

            $baseName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $imgName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $baseName) . rand(1, 1000000) . '.' . $extension;
            
            // Move to public/uploads directory
            $file->move(public_path('uploads'), $imgName);
        }

        $data = [
            'uname' => $request->uname,
            'password' => $password,
            'userrole' => $request->userrole,
            'usertype' => 2, // Default value from native code
            'created_at' => now(),
            'updated_at' => now(),
        ];

        if ($imgName) {
            $data['img'] = $imgName;
        }

        DB::table('users')->insert($data);

        DB::table('process')->insert([
            'type' => 'add user',
            'created_at' => now(),
        ]);

        return redirect()->route('users.index')
            ->with('success', 'تم إضافة المستخدم بنجاح');
    }

    public function edit(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->back()->with('error', 'معرف المستخدم مطلوب');
        }

        $user = DB::table('users')
            ->where('id', $id)
            ->first();

        if (!$user) {
            return redirect()->route('users.index')
                ->with('error', 'المستخدم غير موجود');
        }

        $roles = DB::table('usr_pwrs')
            ->orderBy('id')
            ->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('users::edit', compact('user', 'roles', 'settings', 'lang'));
    }

    public function update(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->back()->with('error', 'معرف المستخدم مطلوب');
        }

        $validator = Validator::make($request->all(), [
            'uname' => 'required|string|max:20',
            'userrole' => 'required|integer|exists:usr_pwrs,id',
            'password' => 'nullable|string|min:1',
            'confirm_password' => 'nullable|same:password',
            'img' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:51200',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Check password match if provided
        if ($request->password && $request->password !== $request->confirm_password) {
            return redirect()->back()->with('error', 'كلمات المرور غير متطابقة')->withInput();
        }

        $data = [
            'uname' => $request->uname,
            'userrole' => $request->userrole,
            'updated_at' => now(),
        ];

        // Update password if provided
        if ($request->password) {
            $data['password'] = md5($request->password);
        }

        // Handle image upload
        if ($request->hasFile('img') && $request->file('img')->isValid()) {
            $file = $request->file('img');
            $extension = strtolower($file->getClientOriginalExtension());
            $allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            
            if (!in_array($extension, $allowedExt)) {
                return redirect()->back()->with('error', 'امتداد الملف غير مسموح به')->withInput();
            }

            if ($file->getSize() > 50 * 1024 * 1024) {
                return redirect()->back()->with('error', 'حجم الملف أكبر من 50 ميجا بايت')->withInput();
            }

            $baseName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $imgName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $baseName) . '_' . rand(1000, 999999) . '.' . $extension;
            
            // Move to public/uploads directory
            $file->move(public_path('uploads'), $imgName);
            $data['img'] = $imgName;
        }

        DB::table('users')
            ->where('id', $id)
            ->update($data);

        return redirect()->route('users.index')
            ->with('success', 'تم تحديث المستخدم بنجاح');
    }

    public function destroy(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->back()->with('error', 'معرف المستخدم مطلوب');
        }

        // Hard delete (as in native code)
        DB::table('users')
            ->where('id', $id)
            ->delete();

        DB::table('process')->insert([
            'type' => 'delete user',
            'created_at' => now(),
        ]);

        return redirect()->route('users.index')
            ->with('success', 'تم حذف المستخدم بنجاح');
    }
}