<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Checking Invoices ===\n\n";

$invoices = DB::table('ot_head')
    ->where('isdeleted', 0)
    ->orderBy('id', 'desc')
    ->get(['id', 'pro_id', 'pro_tybe', 'pro_date', 'fat_net']);

echo "Total invoices found: " . $invoices->count() . "\n\n";

if ($invoices->count() > 0) {
    echo "Invoice Details:\n";
    echo str_repeat("-", 80) . "\n";
    printf("%-5s %-10s %-10s %-15s %-15s\n", "ID", "Pro ID", "Type", "Date", "Net");
    echo str_repeat("-", 80) . "\n";
    
    foreach ($invoices as $inv) {
        printf("%-5s %-10s %-10s %-15s %-15s\n", 
            $inv->id, 
            $inv->pro_id, 
            $inv->pro_tybe, 
            $inv->pro_date ?? 'N/A',
            $inv->fat_net ?? '0'
        );
    }
    
    echo "\n\nBy Type:\n";
    echo str_repeat("-", 40) . "\n";
    $byType = DB::table('ot_head')
        ->select('pro_tybe', DB::raw('count(*) as count'))
        ->where('isdeleted', 0)
        ->groupBy('pro_tybe')
        ->get();
    
    foreach ($byType as $type) {
        echo "Type {$type->pro_tybe}: {$type->count} invoices\n";
    }
} else {
    echo "No invoices found!\n";
}
