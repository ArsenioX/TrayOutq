<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    // Field yang boleh diisi secara massal
    protected $fillable = [
        'transaction_id',
        'produk_id',
        'jumlah',
        'harga',
        'user_id',
        'status',
        'bukti_bayar',
    ];

    // Relasi ke transaksi (jika dibutuhkan)
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    // Relasi ke produk
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    // Relasi ke user (jika memang kamu perlukan user_id di table ini)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
