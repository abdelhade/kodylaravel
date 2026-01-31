<?php

namespace Modules\Reservations\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    // bookings.php - قائمة الكروت الذكية
    public function index(Request $request)
    {
        $case = $request->get('case'); // Filter by bcase: 0, 1, or 2
        
        $query = DB::table('booking_cards')
            ->where('isdeleted', 0);
        
        if ($case !== null) {
            $query->where('bcase', $case);
        }
        
        $bookings = $query->orderBy('id', 'desc')->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('reservations::bookings.index', compact('bookings', 'case', 'settings', 'lang', ));
    }

    // add_booking.php - إضافة كارت جديد
    public function create()
    {
        // Get clients for datalist
        $clients = DB::table('clients')
            ->select('name')
            ->distinct()
            ->get();

        // Get booking types
        $bookingTypes = DB::table('book_tybes')
            ->where('isdeleted', 0)
            ->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('reservations::bookings.create', compact('clients', 'bookingTypes', 'settings', 'lang', ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cname' => 'required|string|max:255',
            'barcode' => 'required|string|max:255',
            'rtybe' => 'required|exists:book_tybes,id',
            'rcost' => 'required|numeric|min:0',
            'qty' => 'required|integer|min:1',
            'fromdate' => 'required|date',
            'todate' => 'required|date|after_or_equal:fromdate',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Check if client exists, if not create it
        $client = DB::table('clients')
            ->where('name', trim($request->cname))
            ->first();
        
        if (!$client) {
            DB::table('clients')->insert([
                'name' => trim($request->cname),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Check if barcode already exists
        $existingBarcode = DB::table('booking_cards')
            ->where('barcode', trim($request->barcode))
            ->where('isdeleted', 0)
            ->first();
        
        if ($existingBarcode) {
            return redirect()->back()
                ->with('error', 'الرقم موجود بالفعل')
                ->withInput();
        }

        // Insert booking card
        DB::table('booking_cards')->insert([
            'barcode' => trim($request->barcode),
            'client' => trim($request->cname),
            'rtybe' => $request->rtybe,
            'rcost' => $request->rcost,
            'qty' => $request->qty,
            'remain' => $request->qty, // Initially remain equals qty
            'fromdate' => $request->fromdate,
            'todate' => $request->todate,
            'bcase' => 0, // Default case
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('process')->insert([
            'type' => 'add booking',
            'created_at' => now(),
        ]);

        return redirect()->route('bookings.create')
            ->with('success', 'تم إضافة الكارت بنجاح');
    }

    // booking.php - استخدام الباركود لتخفيض حصة
    public function scan()
    {
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('reservations::bookings.scan', compact('settings', 'lang', ));
    }

    // AJAX endpoint to get barcode info
    public function getBarcodeInfo(Request $request)
    {
        $code = trim($request->input('code'));
        
        if (strlen($code) < 3) {
            return response()->json(['success' => false]);
        }

        $booking = DB::table('booking_cards')
            ->where('barcode', $code)
            ->where('isdeleted', 0)
            ->first();

        if (!$booking) {
            return response()->json(['success' => false]);
        }

        return response()->json([
            'success' => true,
            'id' => $booking->id,
            'client' => $booking->client,
            'remain' => $booking->remain,
            'todate' => $booking->todate,
        ]);
    }

    // AJAX endpoint to reduce remain
    public function reduceRemain(Request $request)
    {
        $code = $request->input('code');
        
        $booking = DB::table('booking_cards')
            ->where('id', $code)
            ->where('isdeleted', 0)
            ->first();

        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'الكارت غير موجود'
            ]);
        }

        if ($booking->remain <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'لا توجد وحدات متبقية'
            ]);
        }

        $newRemain = $booking->remain - 1;
        
        DB::table('booking_cards')
            ->where('id', $code)
            ->update([
                'remain' => $newRemain,
                'updated_at' => now(),
            ]);

        return response()->json([
            'success' => true,
            'remain' => $newRemain
        ]);
    }

    // AJAX endpoint to check client name
    public function checkClient(Request $request)
    {
        $cname = trim($request->input('cname'));
        
        $client = DB::table('clients')
            ->where('name', $cname)
            ->first();

        if ($client) {
            return response('العميل موجود');
        } else {
            return response('سيتم إنشاء عميل جديد');
        }
    }

    // AJAX endpoint to check barcode
    public function checkBarcode(Request $request)
    {
        $barcode = trim($request->input('barcode'));
        
        $existing = DB::table('booking_cards')
            ->where('barcode', $barcode)
            ->where('isdeleted', 0)
            ->first();

        if ($existing) {
            return response('<span class="text-danger">الرقم موجود بالفعل</span>');
        } else {
            return response('<span class="text-success">الرقم متاح</span>');
        }
    }

    // AJAX endpoint to get booking type value and qty
    public function getBookingTypeInfo(Request $request)
    {
        $id = $request->input('id');
        
        $bookingType = DB::table('book_tybes')
            ->where('id', $id)
            ->where('isdeleted', 0)
            ->first();

        if (!$bookingType) {
            return response()->json([
                'value' => 0,
                'qty' => 0
            ]);
        }

        return response()->json([
            'value' => $bookingType->value ?? 0,
            'qty' => $bookingType->qty ?? 0
        ]);
    }
}