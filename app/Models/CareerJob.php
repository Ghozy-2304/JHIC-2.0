<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CareerJob extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'major',
        'salary',
        'work_location',
        'work_type',
        'company_name',
        'company_logo_char',
        'company_img',
        'company_bg',
        'location',
        'location_group',
        'posted_time',
        'post_time_category',
        'posted_at',
        'expires_at',
        'apply_url',
        'source_platform',
        'requirements',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'posted_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Scope query untuk hanya mengambil lowongan yang aktif dan belum kedaluwarsa.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>', now());
            });
    }

    /**
     * Hitung waktu posting relatif secara dinamis & realtime ("2 hari yang lalu", "3 jam yang lalu").
     */
    public function getPostedTimeAgoAttribute(): string
    {
        if ($this->posted_at) {
            \Carbon\Carbon::setLocale('id');
            return \Carbon\Carbon::parse($this->posted_at)->diffForHumans();
        }

        return $this->posted_time ?: 'Baru saja';
    }

    /**
     * Hitung kategori filter waktu secara otomatis dari tanggal posting.
     */
    public function getCalculatedTimeCategoryAttribute(): string
    {
        if (!$this->posted_at) {
            return $this->post_time_category ?: 'Minggu ini';
        }

        $now = \Carbon\Carbon::now();
        $posted = \Carbon\Carbon::parse($this->posted_at);
        $diffDays = $now->diffInDays($posted);

        if ($diffDays == 0 && $posted->isSameDay($now)) {
            return 'Hari ini';
        }
        if ($diffDays <= 7) {
            return 'Minggu ini';
        }
        if ($diffDays <= 30) {
            return 'Bulan ini';
        }
        return 'Tahun ini';
    }

    /**
     * Cek apakah lowongan telah melewati batas waktu (expired).
     */
    public function getIsExpiredAttribute(): bool
    {
        return $this->expires_at ? $this->expires_at->isPast() : false;
    }
}
