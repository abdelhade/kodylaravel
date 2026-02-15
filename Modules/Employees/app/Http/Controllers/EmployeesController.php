<?php

namespace Modules\Employees\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return app(EmployeeController::class)->index();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return app(EmployeeController::class)->create();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return app(EmployeeController::class)->store($request);
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        // Redirect to profile if singular controller handles it differently
        return redirect()->route('employees.profile', ['id' => $id]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // The singular controller's edit method expects ID in the request
        request()->merge(['id' => $id]);
        return app(EmployeeController::class)->edit(request());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->merge(['id' => $id]);
        return app(EmployeeController::class)->update($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        request()->merge(['id' => $id]);
        return app(EmployeeController::class)->destroy(request());
    }
}
