<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = [
        'user_id',
        'task_title',
        'description',
        'start_date',
        'due_date',
        'completed',
    ];

    protected function casts(): array
    {
        return [
            'completed' => 'boolean',
            'start_date' => 'date',
            'due_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
