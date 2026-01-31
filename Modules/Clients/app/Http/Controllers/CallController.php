<?php

namespace Modules\Clients\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CallController extends Controller
{
    public function index()
    {
        $calls = DB::table('calls')
            ->where('isdeleted', 0)
            ->orderBy('call_date', 'desc')
            ->orderBy('call_time', 'desc')
            ->get();

        // Enrich with client names
        foreach ($calls as $call) {
            $client = DB::table('acc_head')
                ->where('id', $call->client_id)
                ->first();
            $call->client_name = $client->aname ?? '';

            // Get call type name (assuming 1 = incoming, 0 = outgoing)
            $call->call_type_name = $call->call_type == 1 ? 'وارد' : 'صادر';
        }

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('clients::calls.index', compact('calls', 'settings', 'lang', ));
    }

    public function create()
    {
        // Get clients (code like '122%')
        $clients = DB::table('acc_head')
            ->where('code', 'like', '122%')
            ->where('is_basic', 0)
            ->where('isdeleted', 0)
            ->orderBy('aname')
            ->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('clients::calls.create', compact('clients', 'settings', 'lang', ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required|string|max:100',
            'client_id' => 'required|exists:acc_head,id',
            'call_type' => 'required|in:0,1',
            'call_date' => 'required|date',
            'call_time' => 'required',
            'duration' => 'nullable|string|max:100',
            'emp_comment' => 'nullable|string|max:250',
            'content' => 'nullable|string',
            'next_date' => 'nullable|date',
            'next_time' => 'nullable',
            'mod_comment' => 'nullable|string|max:250',
            'mod_rate' => 'nullable|integer|min:0|max:9',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('calls')->insert([
            'subject' => $request->subject,
            'client_id' => $request->client_id,
            'call_type' => $request->call_type,
            'call_date' => $request->call_date,
            'call_time' => $request->call_time,
            'duration' => $request->duration ?? '',
            'emp_comment' => $request->emp_comment ?? '',
            'content' => $request->content ?? '',
            'next_date' => $request->next_date ?? null,
            'next_time' => $request->next_time ?? null,
            'mod_comment' => $request->mod_comment ?? '',
            'mod_rate' => $request->mod_rate ?? 5,
            'user_id' => auth()->id() ?? 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('process')->insert([
            'type' => 'add call',
            'created_at' => now(),
        ]);

        return redirect()->route('calls.index')
            ->with('success', 'تم إضافة المكالمة بنجاح');
    }

    public function destroy(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->back()->with('error', 'معرف المكالمة مطلوب');
        }

        // Soft delete
        DB::table('calls')
            ->where('id', $id)
            ->update([
                'isdeleted' => 1,
                'updated_at' => now(),
            ]);

        return redirect()->route('calls.index')
            ->with('success', 'تم حذف المكالمة بنجاح');
    }
}