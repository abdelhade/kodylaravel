<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LegacyController extends Controller
{
    /**
     * Handle legacy PHP files by including them
     */
    public function handle(Request $request)
    {
        // Get route name from current route
        $routeName = $request->route()->getName();
        
        // Map of route names to PHP files
        $fileMap = [
            'acc_report' => 'acc_report.php',
            'add_item' => 'add_item.php',
            'myitems' => 'myitems.php',
            'myunits' => 'myunits.php',
            'mygroups' => 'mygroups.php',
            'item_categories' => 'item_categories.php',
            'barcode_search' => 'barcode_search.php',
            'pos_barcode' => 'pos_barcode.php',
            'pos.barcode' => 'pos_barcode.php',
            'crud_tables' => 'crud_tables.php',
            'closed_sessions' => 'closed_sessions.php',
            'sales' => 'sales.php',
            'pos_po' => 'pos_po.php',
            'add_voucher' => 'add_voucher.php',
            'vouchers' => 'vouchers.php',
            'employees' => 'employees.php',
            'shifts' => 'shifts.php',
            'jops' => 'jops.php',
            'joprules' => 'joprules.php',
            'joplevels' => 'joplevels.php',
            'departments' => 'departments.php',
            'add_rent' => 'add_rent.php',
            'rentables' => 'rentables.php',
            'myrentables' => 'myrentables.php',
            'reservations' => 'reservations.php',
            'drugs' => 'drugs.php',
            'manualattandance' => 'manualattandance.php',
            'machinelog' => 'machinelog.php',
            'calcsalary' => 'calcsalary.php',
            'add_task' => 'add_task.php',
            'tasks' => 'tasks.php',
            'followup' => 'followup.php',
            'kbis' => 'kbis.php',
            'emp_kbis' => 'emp_kbis.php',
            'trainingcontracts' => 'trainingcontracts.php',
            'hiringcontracts' => 'hiringcontracts.php',
            'externalcontracts' => 'externalcontracts.php',
            'production' => 'production.php',
            'cvs' => 'cvs.php',
            'chances' => 'chances.php',
            'calls' => 'calls.php',
            'orders' => 'orders.php',
            'prints' => 'prints.php',
            'change_password' => 'change_password.php',
            'add_journal' => 'add_journal.php',
            'addmulti_journal' => 'addmulti_journal.php',
            'daily_journal' => 'daily_journal.php',
            'accounts' => 'accounts.php',
            'start_balance' => 'start_balance.php',
            'items_start_balance' => 'items_start_balance.php',
            'summary' => 'summary.php',
            'reps_cl' => 'reps_cl.php',
            'reports' => 'reports.php',
            'sales-reports' => 'sales-reports.php',
            'operations_summary' => 'operations_summary.php',
            'items_summery' => 'items_summery.php',
            'add_booking' => 'add_booking.php',
            'booking' => 'booking.php',
            'bookings' => 'bookings.php',
            'clients' => 'clients.php',
            'mytowns' => 'mytowns.php',
        ];

        $phpFile = $fileMap[$routeName] ?? $routeName . '.php';
        $filePath = base_path("native/{$phpFile}");

        // Check if file exists
        if (!file_exists($filePath)) {
            Log::warning('Legacy file not found', [
                'route' => $routeName,
                'file' => $phpFile,
                'path' => $filePath,
                'user_id' => session('userid'),
            ]);
            abort(404, "File not found: {$phpFile}");
        }

        // Start PHP session first (legacy files expect this)
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Sync Laravel session with native $_SESSION
        $sessionData = Session::all();
        foreach ($sessionData as $key => $value) {
            $_SESSION[$key] = $value;
        }

        // Preserve query parameters for legacy files
        foreach ($request->query() as $key => $value) {
            $_GET[$key] = $value;
            $_REQUEST[$key] = $value;
        }

        // Preserve POST data if exists
        if ($request->isMethod('post')) {
            $_POST = [];
            $_REQUEST = [];
            foreach ($request->all() as $key => $value) {
                $_POST[$key] = $value;
                $_REQUEST[$key] = $value;
            }
            // Preserve files if uploaded
            if ($request->hasFile('*')) {
                foreach ($request->allFiles() as $key => $file) {
                    $_FILES[$key] = [
                        'name' => $file->getClientOriginalName(),
                        'type' => $file->getMimeType(),
                        'tmp_name' => $file->getRealPath(),
                        'error' => $file->getError(),
                        'size' => $file->getSize(),
                    ];
                }
            }
        } else {
            // Clear POST and FILES for GET requests
            $_POST = [];
            $_FILES = [];
        }

        // Change directory to native folder
        $oldDir = getcwd();
        chdir(base_path('native'));

        // Capture output and errors
        ob_start();
        try {
            include $filePath;
            $content = ob_get_clean();
        } catch (\Throwable $e) {
            ob_end_clean();
            chdir($oldDir);
            
            // Log error with context
            Log::error('Error loading legacy file', [
                'route' => $routeName,
                'file' => $phpFile,
                'path' => $filePath,
                'user_id' => session('userid'),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            // Log error but don't expose it to user in production
            if (config('app.debug')) {
                return response("Error loading file: {$phpFile}<br>" . $e->getMessage(), 500);
            }
            
            abort(500, "Error loading file: {$phpFile}");
        }

        // Restore directory
        chdir($oldDir);

        return response($content);
    }
}
