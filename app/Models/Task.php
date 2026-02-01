<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'priority',
        'due_date',
        'is_completed'
    ];

    // Garante que a data de vencimento seja tratada como um objeto Carbon
    protected $casts = [
        'due_date' => 'date',
        'is_completed' => 'boolean',
    ];

    /**
     * Uma tarefa pertence a um utilizador
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
