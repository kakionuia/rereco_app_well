<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVoucher extends Model
{
    use HasFactory;

    protected $table = 'user_vouchers';
    protected $fillable = ['user_id','voucher_id','claimed_at','used','times_used','used_at'];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
}
