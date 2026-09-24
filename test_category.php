<?php

use App\Models\Category;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

$cats = Category::active()->sorted()->get();
echo 'count: '.$cats->count()."\n";
$first = $cats->first();
echo 'first class: '.get_class($first)."\n";
echo 'first slug: '.$first->slug."\n";
echo 'first type: '.gettype($first)."\n";
