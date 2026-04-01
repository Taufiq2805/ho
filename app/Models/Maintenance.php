<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pengeluaran; // pastikan di-import

class Maintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'kamar_id',
        'user_id',
        'tanggal',
        'status',
        'catatan',
    ];

    // ===== RELASI =====
    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pengeluaran()
    {
        return $this->hasMany(Pengeluaran::class);
    }
}
