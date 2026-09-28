<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SizeGuide extends Model
{
    protected $fillable = [
        'size_label',
        'size_type',
        'chest_cm',
        'chest_inch',
        'waist_cm',
        'waist_inch',
        'hip_cm',
        'hip_inch',
        'shoulder_cm',
        'sleeve_length_cm',
        'body_length_cm',
        'notes',
    ];
}
