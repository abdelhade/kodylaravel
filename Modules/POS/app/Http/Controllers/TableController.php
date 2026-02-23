<?php

namespace Modules\POS\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\POS\Models\POSTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TableController extends Controller
{
    /**
     * عرض قائمة الطاولات
     */
    public function index()
    {
        $tables = DB::table('tables')
            ->where('isdeleted', 0)
            ->orderBy('id', 'desc')
            ->get();

        $settings = (array) DB::table('settings')->first();
        $lang = $this->getLanguageArray();

        return view('pos::tables.index', compact('tables', 'settings', 'lang'));
    }

    /**
     * حفظ طاولة جديدة
     */
    public function store(Request $request)
    {
        $request->validate([
            'tname' => 'required|string|max:255',
            'table_case' => 'required|in:0,1,2',
        ]);

        DB::table('tables')->insert([
            'tname' => $request->tname,
            'table_case' => $request->table_case,
            'crtime' => now(),
            'mdtime' => now(),
            'isdeleted' => 0,
            'branch' => 'main',
            'tatnet' => 0
        ]);

        return redirect()->route('pos.tables.index')
            ->with('success', 'تم إضافة الطاولة بنجاح');
    }

    /**
     * تحديث طاولة
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tname' => 'required|string|max:255',
            'table_case' => 'required|in:0,1,2',
        ]);

        DB::table('tables')
            ->where('id', $id)
            ->update([
                'tname' => $request->tname,
                'table_case' => $request->table_case,
                'mdtime' => now()
            ]);

        return redirect()->route('pos.tables.index')
            ->with('success', 'تم تحديث الطاولة بنجاح');
    }

    /**
     * حذف طاولة
     */
    public function destroy($id)
    {
        DB::table('tables')
            ->where('id', $id)
            ->update(['isdeleted' => 1]);

        return redirect()->route('pos.tables.index')
            ->with('success', 'تم حذف الطاولة بنجاح');
    }

    /**
     * دالة للحصول على اللغة من الكاش
     */
    private function getLanguageArray()
    {
        return cache()->remember('language_ar', 3600, function () {
            $cached = cache()->get('laravel-cache-language_ar');
            if ($cached) {
                return $cached;
            }
            return [];
        });
    }
}
