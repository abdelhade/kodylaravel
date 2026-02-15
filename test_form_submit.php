<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Testing Form Submission ===\n\n";

// Simulate a form submission
$testData = [
    'pro_tybe' => 4,
    'store_id' => 1,
    'acc2_id' => 1,
    'emp_id' => 1,
    'pro_date' => '2026-02-09',
    'headtotal' => 100,
    'headdisc' => 0,
    'headplus' => 0,
    'headnet' => 100,
    'info' => 'Test invoice',
    'itmname' => [1],
    'itmqty' => [10],
    'itmprice' => [10],
    'itmdisc' => [0],
    'u_val' => [1]
];

echo "Test data:\n";
print_r($testData);

try {
    DB::beginTransaction();
    
    // Get next invoice number
    $max_id = DB::table('ot_head')
        ->where('pro_tybe', $testData['pro_tybe'])
        ->max(DB::raw('CAST(pro_id AS UNSIGNED)'));
    
    $pro_id = $max_id ? ($max_id + 1) : 1;
    
    echo "\nNext invoice number: $pro_id\n";
    
    // Insert header
    $last_op = DB::table('ot_head')->insertGetId([
        'pro_id' => $pro_id,
        'pro_tybe' => $testData['pro_tybe'],
        'is_stock' => 1,
        'is_journal' => 1,
        'journal_tybe' => $testData['pro_tybe'],
        'info' => $testData['info'],
        'pro_date' => $testData['pro_date'],
        'store_id' => $testData['store_id'],
        'emp_id' => $testData['emp_id'],
        'acc1' => $testData['store_id'],
        'acc2' => $testData['acc2_id'],
        'fat_total' => $testData['headtotal'],
        'fat_disc' => $testData['headdisc'],
        'fat_plus' => $testData['headplus'],
        'fat_net' => $testData['headnet'],
        'user' => 1,
        'created_at' => now(),
        'updated_at' => now()
    ]);
    
    echo "Inserted header with ID: $last_op\n";
    
    // Insert details
    foreach ($testData['itmname'] as $index => $item_id) {
        $qty = $testData['itmqty'][$index];
        $price = $testData['itmprice'][$index];
        $disc = $testData['itmdisc'][$index] ?? 0;
        $u_val = $testData['u_val'][$index] ?? 1;
        
        DB::table('fat_details')->insert([
            'pro_tybe' => $testData['pro_tybe'],
            'pro_id' => $last_op,
            'item_id' => $item_id,
            'u_val' => $u_val,
            'qty_in' => $qty * $u_val,
            'price' => $price / $u_val,
            'discount' => $disc,
            'det_value' => $qty * ($price - $disc),
            'fatid' => $last_op,
            'fat_tybe' => $testData['pro_tybe'],
            'det_store' => $testData['store_id'],
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        echo "Inserted detail for item $item_id\n";
    }
    
    DB::commit();
    echo "\n✓ Success! Invoice created.\n";
    
} catch (\Exception $e) {
    DB::rollBack();
    echo "\n✗ Error: " . $e->getMessage() . "\n";
}
