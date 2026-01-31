<?php

namespace Modules\News\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    public function index()
    {
        $news = DB::table('my_news')
            ->where('isdeleted', '!=', 1)
            ->orderBy('id', 'desc')
            ->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('news::index', compact('news', 'settings', 'lang', ));
    }

    public function create()
    {
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('news::create', compact('settings', 'lang', ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:200',
            'content' => 'required|string',
            'tags' => 'nullable|string|max:250',
            'img' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5120',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $userId = session('userid');
        $imgName = null;

        // Handle image upload
        if ($request->hasFile('img') && $request->file('img')->isValid()) {
            $file = $request->file('img');
            $extension = strtolower($file->getClientOriginalExtension());
            $allowedExt = ['jpg', 'png', 'gif', 'jpeg', 'webp'];
            
            if (!in_array($extension, $allowedExt)) {
                return redirect()->back()->with('error', 'امتداد الملف غير مسموح به')->withInput();
            }

            $baseName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $imgName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $baseName) . rand(1, 1000000) . '.' . $extension;
            
            // Move to public/uploads directory
            $file->move(public_path('uploads'), $imgName);
        }

        $data = [
            'title' => $request->title,
            'tags' => $request->tags ?? '',
            'content' => $request->content,
            'user' => $userId,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        if ($imgName) {
            $data['img'] = $imgName;
        }

        DB::table('my_news')->insert($data);

        DB::table('process')->insert([
            'type' => 'add news',
            'created_at' => now(),
        ]);

        return redirect()->route('news.index')
            ->with('success', 'تم إضافة الخبر بنجاح');
    }

    public function show(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->back()->with('error', 'معرف الخبر مطلوب');
        }

        $newsItem = DB::table('my_news')
            ->where('id', $id)
            ->where('isdeleted', '!=', 1)
            ->first();

        if (!$newsItem) {
            return redirect()->route('news.index')
                ->with('error', 'الخبر غير موجود');
        }

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('news::show', compact('newsItem', 'settings', 'lang', ));
    }

    public function destroy(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->back()->with('error', 'معرف الخبر مطلوب');
        }

        // Soft delete
        DB::table('my_news')
            ->where('id', $id)
            ->update([
                'isdeleted' => 1,
                'updated_at' => now(),
            ]);

        return redirect()->route('news.index')
            ->with('success', 'تم حذف الخبر بنجاح');
    }
}