<?php

return [
    'name' => 'POS',
    'description' => 'نظام نقاط البيع - Point of Sale System',
    'version' => '1.0.0',
    'author' => 'Your Company',
    
    // إعدادات POS
    'settings' => [
        'enable_barcode_scanning' => true,
        'enable_table_management' => true,
        'enable_delivery' => true,
        'enable_takeaway' => true,
        'default_order_type' => 1, // 1=تيك أواي، 2=طاولة، 3=دليفري
        'auto_close_shift' => true,
        'shift_close_time' => '23:59:59',
    ],

    // أنواع الطلبات
    'order_types' => [
        1 => 'تيك أواي',
        2 => 'طاولة',
        3 => 'دليفري',
    ],

    // حالات الطاولات
    'table_statuses' => [
        0 => 'متاحة',
        1 => 'محجوزة',
        2 => 'صيانة',
    ],
];
