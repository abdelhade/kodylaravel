<?php

namespace Modules\POS\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\POS\Models\POSTable;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.auth');
    }

    /**
     * عرض قائمة الطاولات
     */
    public function index()
    {
        $tables = POSTable::active()->orderBy('id')->get();
        return view('pos::tables.index', compact('tables'));
    }

    /**
     * عرض نموذج إضافة طاولة
     */
    public function create()
    {
        return view('pos::tables.create');
    }

    /**
     * حفظ طاولة جديدة
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tname' => 'required|string|max:255',
            'table_case' => 'required|in:0,1,2',
        ]);

        POSTable::create($validated);

        return redirect()->route('pos.tables.index')
            ->with('success', 'تم إضافة الطاولة بنجاح');
    }

    /**
     * عرض نموذج تعديل طاولة
     */
    public function edit(POSTable $table)
    {
        return view('pos::tables.edit', compact('table'));
    }

    /**
     * تحديث طاولة
     */
    public function update(Request $request, POSTable $table)
    {
        $validated = $request->validate([
            'tname' => 'required|string|max:255',
            'table_case' => 'required|in:0,1,2',
        ]);

        $table->update($validated);

        return redirect()->route('pos.tables.index')
            ->with('success', 'تم تحديث الطاولة بنجاح');
    }

    /**
     * حذف طاولة
     */
    public function destroy(POSTable $table)
    {
        $table->update(['isdeleted' => 1]);

        return redirect()->route('pos.tables.index')
            ->with('success', 'تم حذف الطاولة بنجاح');
    }

    /**
     * تحديث حالة الطاولة (AJAX)
     */
    public function updateStatus(Request $request, POSTable $table)
    {
        $validated = $request->validate([
            'table_case' => 'required|in:0,1,2',
        ]);

        $table->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث حالة الطاولة',
            'status' => $table->getStatusLabel()
        ]);
    }
}
