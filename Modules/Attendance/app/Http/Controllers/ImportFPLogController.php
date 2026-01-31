<?php

namespace Modules\Attendance\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Carbon\Carbon;

class ImportFPLogController extends Controller
{
    public function index()
    {
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('attendance::import-fp-log.index', compact('settings', 'lang', ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sheet' => 'required|file|mimes:xlsx|max:20000', // 20MB max
            'basma_model' => 'required|in:zkt,advision,hikvision',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $file = $request->file('sheet');
            $spreadsheet = IOFactory::load($file->getRealPath());
            $worksheet = $spreadsheet->getActiveSheet();

            $columnMapping = [
                'AC-No' => 0,
                'NO' => 1,
                'Name' => 2,
                'Time' => 3,
                'State' => 4,
                'New State' => 5,
                'Exception' => 6,
                'Operation' => 7,
            ];

            $importedCount = 0;
            $errors = [];

            // Iterate through each row (start from row 2 to skip header)
            foreach ($worksheet->getRowIterator(2) as $row) {
                $rowData = [];
                foreach ($row->getCellIterator() as $cell) {
                    $rowData[] = $cell->getValue();
                }

                if (empty($rowData[$columnMapping['AC-No']]) || empty($rowData[$columnMapping['Time']])) {
                    continue; // Skip empty rows
                }

                $basmaid = $rowData[$columnMapping['AC-No']];
                $dateTimeStr = $rowData[$columnMapping['Time']];

                // Get employee by basma_id
                $employee = DB::table('employees')
                    ->where('basma_id', $basmaid)
                    ->first();

                if (!$employee) {
                    $errors[] = "الموظف برقم البصمة {$basmaid} غير موجود في قاعدة البيانات";
                    continue;
                }

                // Get shift properties
                $shift = DB::table('shifts')
                    ->where('id', $employee->shift)
                    ->first();

                if (!$shift) {
                    $errors[] = "الموظف {$employee->name} لا يملك وردية محددة";
                    continue;
                }

                // Parse date and time
                try {
                    $dateTime = Carbon::parse($dateTimeStr);
                    $formattedDate = $dateTime->format('Y-m-d');
                    $formattedTime = $dateTime->format('H:i:s');
                } catch (\Exception $e) {
                    $errors[] = "خطأ في تنسيق التاريخ/الوقت في السطر: {$dateTimeStr}";
                    continue;
                }

                $userId = session('userid', 1);

                // Determine fingerprint type based on shift times
                $fptype = '5'; // Default
                if ($formattedTime >= $shift->shiftstart && $formattedTime <= $shift->shiftend) {
                    if ($formattedTime >= $shift->instart && $formattedTime <= $shift->inend) {
                        $fptype = '1'; // Check-in
                    } elseif ($formattedTime >= $shift->outstart && $formattedTime <= $shift->outend) {
                        $fptype = '2'; // Check-out
                    }
                }

                // Insert into attendance table
                try {
                    DB::table('attandance')->insert([
                        'employee' => $employee->id,
                        'fptybe' => $fptype,
                        'fpdate' => $formattedDate,
                        'time' => $formattedTime,
                        'user' => $userId,
                        'fromwhere' => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $importedCount++;
                } catch (\Exception $e) {
                    $errors[] = "خطأ في إدخال السجل للموظف {$employee->name}: " . $e->getMessage();
                }
            }

            $message = "تم استيراد {$importedCount} سجل بنجاح";
            if (!empty($errors)) {
                $message .= ". " . count($errors) . " أخطاء: " . implode(', ', array_slice($errors, 0, 5));
            }

            return redirect()->route('import-fp-log.index')
                ->with('success', $message)
                ->with('errors', $errors);

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء استيراد الملف: ' . $e->getMessage())
                ->withInput();
        }
    }
}