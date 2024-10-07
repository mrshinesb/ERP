<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseCart extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'desc',
        'cqty',
        'dprice',
        'pqty',
        ];
}
