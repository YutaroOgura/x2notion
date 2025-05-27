<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_message',
        'ai_response',
        'source_platform',
        'user_id',
        'response_time',
        'tokens_used',
        'notion_query',
        'status'
    ];

    protected $casts = [
        'response_time' => 'datetime',
        'tokens_used' => 'integer',
    ];
}