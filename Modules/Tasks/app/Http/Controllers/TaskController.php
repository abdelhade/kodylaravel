<?php

namespace Modules\Tasks\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $userFilter = $request->get('user');
        
        $tasks = DB::table('tasks')
            ->where('isdeleted', '!=', 1)
            ->orderBy('crtime', 'desc');

        if ($userFilter) {
            $user = DB::table('users')->where('uname', $userFilter)->first();
            if ($user) {
                $tasks->where('user', $user->id);
            }
        }

        $tasks = $tasks->get();

        // Get users for filter
        $users = DB::table('users')->orderBy('id')->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('tasks::tasks.index', compact('tasks', 'users', 'userFilter', 'settings', 'lang', ));
    }

    public function create()
    {
        $clients = DB::table('clients')->orderBy('name')->get();
        $users = DB::table('users')->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('tasks::tasks.create', compact('clients', 'users', 'settings', 'lang', ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'user' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('tasks')->insert([
            'name' => $request->name,
            'phone' => $request->phone ?? null,
            'user' => $request->user,
            'info' => $request->info ?? null,
            'crtime' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('tasks.index')
            ->with('success', 'تم إضافة المهمة بنجاح');
    }

    public function edit(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->route('tasks.index')
                ->with('error', 'معرف المهمة مطلوب');
        }

        $task = DB::table('tasks')->where('id', $id)->first();
        if (!$task) {
            return redirect()->route('tasks.index')
                ->with('error', 'المهمة غير موجودة');
        }

        $clients = DB::table('clients')->orderBy('name')->get();
        $users = DB::table('users')->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('tasks::tasks.edit', compact('task', 'clients', 'users', 'settings', 'lang', ));
    }

    public function update(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->route('tasks.index')
                ->with('error', 'معرف المهمة مطلوب');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'user' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('tasks')
            ->where('id', $id)
            ->update([
                'name' => $request->name,
                'phone' => $request->phone ?? null,
                'user' => $request->user,
                'info' => $request->info ?? null,
                'updated_at' => now(),
            ]);

        return redirect()->route('tasks.index')
            ->with('success', 'تم تحديث المهمة بنجاح');
    }

    public function destroy(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->route('tasks.index')
                ->with('error', 'معرف المهمة مطلوب');
        }

        DB::table('tasks')
            ->where('id', $id)
            ->update([
                'isdeleted' => 1,
                'updated_at' => now(),
            ]);

        return redirect()->route('tasks.index')
            ->with('success', 'تم حذف المهمة بنجاح');
    }
}