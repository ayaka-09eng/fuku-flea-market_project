<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'user_id',
        'postal_code',
        'address',
        'building',
        'payment_method',
    ];

    public function item() {
        return $this->belongsTo('App\Models\Item');
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public static function paymentMethods() {
        return [
            0 => 'カード支払い',
            1 => 'コンビニ払い',
        ];
    }
}
