<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSubmission extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'message',
        'ip_address',
        'submitted_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    public function scopeRecent($query, int $days = 30)
    {
        return $query->where('submitted_at', '>=', now()->subDays($days));
    }
}
