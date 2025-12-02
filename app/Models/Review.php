<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'guest_name',
        'guest_phone',
        'guest_email',
        'rating',
        'comment',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get reviewer name (user or guest)
     */
    public function getReviewerNameAttribute(): string
    {
        return $this->user ? $this->user->name : $this->guest_name;
    }

    /**
     * Check if review is from guest
     */
    public function isGuest(): bool
    {
        return $this->user_id === null;
    }
}
