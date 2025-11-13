<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Seller extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_toko',
        'deskripsi_singkat',
        'nama_pic',
        'no_ktp_pic',
        'alamat_ktp_pic',
        'email_pic',
        'alamat',
        'nama_kelurahan',
        'kecamatan',
        'kabupaten_kota',
        'provinsi',
        'file_ktp_pic',
        'verification_status',
        'rejection_reason',
        'verified_at',
        'verified_by',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    /**
     * Get the user that owns the seller profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the platform user who verified this seller.
     */
    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Check if seller is approved.
     */
    public function isApproved(): bool
    {
        return $this->verification_status === 'approved';
    }

    /**
     * Check if seller is pending.
     */
    public function isPending(): bool
    {
        return $this->verification_status === 'pending';
    }

    /**
     * Check if seller is rejected.
     */
    public function isRejected(): bool
    {
        return $this->verification_status === 'rejected';
    }
}
