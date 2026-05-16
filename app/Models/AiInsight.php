<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiInsight extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'insight_text',
        'confidence_score',
        'is_actionable',
        'action_url',
    ];

    protected $casts = [
        'is_actionable' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
