<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Silsilah extends Model
{
    use HasFactory;

    protected $table = 'silsilahs';

    protected $fillable = [
        'nama',
        'foto',
        'tgl_lahir',
        'alamat',
        'jenis_kelamin',
        'status',
        'tgl_meninggal',
        'pasangan_id',
        'ayah_id',
        'ibu_id',
    ];

    /**
     * Relasi ke Pasangan (Suami/Istri)
     */
    public function pasangan(): BelongsTo
    {
        return $this->belongsTo(Silsilah::class, 'pasangan_id');
    }

    /**
     * Relasi ke Ayah
     */
    public function ayah(): BelongsTo
    {
        return $this->belongsTo(Silsilah::class, 'ayah_id');
    }

    /**
     * Relasi ke Ibu
     */
    public function ibu(): BelongsTo
    {
        return $this->belongsTo(Silsilah::class, 'ibu_id');
    }

    /**
     * Relasi ke Anak-anak
     * Logika: Mencari data yang ayah_id atau ibu_id-nya adalah ID orang ini
     */
    public function anak(): HasMany
    {
        // Jika orang ini laki-laki, cari di kolom ayah_id. Jika perempuan, di ibu_id.
        $foreignKey = $this->jenis_kelamin === 'L' ? 'ayah_id' : 'ibu_id';
        return $this->hasMany(Silsilah::class, $foreignKey);
    }

    /**
     * Helper: Mengecek apakah sudah punya pasangan
     */
    public function punyaPasangan(): bool
    {
        return !is_null($this->pasangan_id);
    }

    /**
     * Helper: Mengecek apakah sudah punya orang tua di sistem
     */
    public function punyaOrangTua(): bool
    {
        return !is_null($this->ayah_id) || !is_null($this->ibu_id);
    }
}
