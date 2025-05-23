<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;
    protected $table = 'm_produk';

    protected $guarded = ['kd_produk'];
    
    protected $primaryKey = 'kd_produk';


    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';



    /**
     * Get the user associated with the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function CategoryProduct(): HasOne
    {
        return $this->hasOne(CategoryProduct::class, 'kd_kategori_produk', 'kd_kategori_produk');
    }


    // protected static function booted()
    // {
    //     static::creating(function ($product) {
    //         $latestUser = Product::orderBy('id', 'desc')->first();
    //         $nextId = $latestUser ? $latestUser->id + 1 : 1;
    //         $product->kd_produk = 'product' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
    //     });
    // }
}