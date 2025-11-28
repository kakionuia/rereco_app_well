<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = ['tier','code','discount_type','discount_value','stock'];

    public function userVouchers()
    {
        return $this->hasMany(\App\Models\UserVoucher::class);
    }
}
