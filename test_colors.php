<?php

use App\Models\Color;

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$colors = Color::all();
foreach ($colors as $c) {
    $count = 0;
    foreach ($c->variants as $v) {
        if ($v->is_active && $v->product && $v->product->is_active) {
            $count++;
        }
    }
    echo $c->name.' - '.$c->hex_code.' - '.$count."\n";
}
