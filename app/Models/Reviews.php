<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    use HasFactory;

    public const rules = [
        'stars' => 'required|integer|min:1|max:5',
        'comment' => 'required|string|max:450',
    ];

    protected $fillable = [ 'stars', 'comment', 'user_id', 'business_id'];

    public function getCreatedAtAttribute($value): string
    {
        return Carbon::create($value)->diffForHumans(['parts' => 1]);
    }


    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function business(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Business::class);
    }


}
