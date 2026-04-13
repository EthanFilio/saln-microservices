<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'template',
        'form_data',
        'status',
        'output_path',
        'error_message',
    ];

    protected $casts = [
        'form_data' => 'array',
    ];
}