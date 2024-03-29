<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transactionDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        "transaction_id",
        "product_id",
        "product_name",
        "qty",
        "subtotal"
    ];
}
