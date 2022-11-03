<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    use HasFactory;

    public const rules = [
        'name' => 'required|string|max:150',
        'starts' => 'required|integer|min:1|max:5',
        'comment' => 'required|string|max:450',

    ];

    protected $fillable = ['name', 'starts', 'comment', 'user_id', 'business_id'];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function business(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Business::class);
    }


}
