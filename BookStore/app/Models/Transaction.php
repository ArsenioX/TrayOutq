<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'alamat',
        'telepon',
        'metode_pembayaran',
        'total',
        'status',
        'shipping_notes',  // Tambahkan kolom untuk catatan/resi
        'bukti_bayar'
      
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }
}
