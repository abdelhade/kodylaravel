<?php

namespace Modules\Employees\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CVController extends Controller
{
    public function index()
    {
        $cvs = DB::table('cvs')
            ->where('isdeleted', '!=', 1)
            ->orderBy('id', 'desc')
            ->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('employees::cvs.index', compact('cvs', 'settings', 'lang', ));
    }

    public function create()
    {
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('employees::cvs.create', compact('settings', 'lang', ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'skills' => 'required|string',
            'exp1' => 'required|string|max:255',
            'exp2' => 'nullable|string|max:255',
            'exp3' => 'nullable|string|max:255',
            'exp4' => 'nullable|string|max:255',
            'exp5' => 'nullable|string|max:255',
            'lastsalary' => 'nullable|string|max:255',
            'expsalary' => 'nullable|string|max:255',
            'referances' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $userId = session('userid');

        DB::table('cvs')->insert([
            'userid' => $userId,
            'name' => $request->name,
            'degree' => $request->degree,
            'address' => $request->address,
            'birthdate' => $request->birthdate,
            'phone' => $request->phone,
            'email' => $request->email ?? '',
            'skills' => $request->skills,
            'exp1' => $request->exp1,
            'exp2' => $request->exp2 ?? '',
            'exp3' => $request->exp3 ?? '',
            'exp4' => $request->exp4 ?? '',
            'exp5' => $request->exp5 ?? '',
            'lastsalary' => $request->lastsalary ?? '',
            'expsalary' => $request->expsalary ?? '',
            'referances' => $request->referances ?? '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('process')->insert([
            'type' => 'add cv',
            'created_at' => now(),
        ]);

        return redirect()->route('cvs.index')
            ->with('success', 'تم إضافة السيرة الذاتية بنجاح');
    }

    public function edit(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->back()->with('error', 'معرف السيرة الذاتية مطلوب');
        }

        $cv = DB::table('cvs')->where('id', $id)->first();
        if (!$cv) {
            return redirect()->back()->with('error', 'السيرة الذاتية غير موجودة');
        }

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('employees::cvs.edit', compact('cv', 'settings', 'lang', ));
    }

    public function update(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->back()->with('error', 'معرف السيرة الذاتية مطلوب');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'skills' => 'required|string',
            'exp1' => 'required|string|max:255',
            'exp2' => 'nullable|string|max:255',
            'exp3' => 'nullable|string|max:255',
            'exp4' => 'nullable|string|max:255',
            'exp5' => 'nullable|string|max:255',
            'lastsalary' => 'nullable|string|max:255',
            'expsalary' => 'nullable|string|max:255',
            'referances' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('cvs')
            ->where('id', $id)
            ->update([
                'name' => $request->name,
                'degree' => $request->degree,
                'address' => $request->address,
                'birthdate' => $request->birthdate,
                'phone' => $request->phone,
                'email' => $request->email ?? '',
                'skills' => $request->skills,
                'exp1' => $request->exp1,
                'exp2' => $request->exp2 ?? '',
                'exp3' => $request->exp3 ?? '',
                'exp4' => $request->exp4 ?? '',
                'exp5' => $request->exp5 ?? '',
                'lastsalary' => $request->lastsalary ?? '',
                'expsalary' => $request->expsalary ?? '',
                'referances' => $request->referances ?? '',
                'updated_at' => now(),
            ]);

        return redirect()->route('cvs.index')
            ->with('success', 'تم تحديث السيرة الذاتية بنجاح');
    }
}