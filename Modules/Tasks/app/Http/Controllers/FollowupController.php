<?php

namespace Modules\Tasks\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FollowupController extends Controller
{
    public function index(Request $request)
    {
        $tasks = DB::table('tasks')
            ->where('isdeleted', 1)
            ->orderBy('mdtime', 'desc')
            ->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('tasks::followup.index', compact('tasks', 'settings', 'lang', ));
    }

    public function destroy(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->back()->with('error', 'معرف المهمة مطلوب');
        }

        // Permanent delete (already soft deleted)
        DB::table('tasks')->where('id', $id)->delete();

        return redirect()->route('followup.index')
            ->with('success', 'تم حذف المهمة نهائياً بنجاح');
    }
}