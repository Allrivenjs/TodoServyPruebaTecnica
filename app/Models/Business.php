<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Business extends Model
{
    use HasFactory;

    public const rules = [
        'name' => 'required|string|max:150',
        'about_it' => 'required|string|max:450',
        'phone' => 'required|string|max:100',
    ];

    protected $fillable = ['name', 'about_it', 'phone', 'user_id'];

    public function create(mixed $validated): static
    {
        $post = $this->query()->create(array_merge($validated, ['user_id' => auth()->id()]));
        $post->images()->create([
            'url' => Storage::put('businesses/'. $post->id, $validated['image']),
        ]);
        return $this;
    }


    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function images(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Images::class, 'imageable');
    }

    public function reviews(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Reviews::class);
    }
}
