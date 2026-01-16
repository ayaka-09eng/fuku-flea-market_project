<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'price',
        'brand',
        'description',
        'condition',
        'img_path',
        'is_sold',
    ];

    public function comments() {
        return $this->hasMany('App\Models\Comment');
    }

    public function likes() {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    }

    public function isSold() {
        return !is_null($this->buyer_id);
    }

    public function order() {
        return $this->hasMany('App\Models\Order');
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function categories() {
        return $this->belongsToMany(Category::class, 'category_item');
    }

    public function scopeKeywordSearch($query, $keyword) {
        if (empty($keyword)) {
            return $query;
        }

        return $query->where(function ($q) use ($keyword) {
            $q->where('name', $keyword)
                ->orWhere('name', 'like', "%{$keyword}%");
        });
    }

    public static function conditions() {
        return [
            0 => '良好',
            1 => '目立った傷や汚れなし',
            2 => 'やや傷や汚れあり',
            3 => '状態が悪い',
        ];
    }

    public function getConditionLabelAttribute() {
        return self::conditions()[$this->condition];
    }
}
