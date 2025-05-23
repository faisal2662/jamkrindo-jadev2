<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryProduct extends Model
{
    use HasFactory;

    protected $table = 'm_kategori_produk';

    protected $guarded = ['kd_kategori_produk'];

    protected $primaryKey = 'kd_kategori_produk';

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';



    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'kd_kategori_produk', 'kd_kategori_produk');
    }

    /**
     * Get the Product associated with the CategoryProduct
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    // public function Product(): HasOne
    // {
    //     return $this->hasOne(r::class, 'foreign_key', 'local_key');
    // }

    // protected static function booted()
    // {
    //     static::creating(function ($category) {
    //         $latestUser = CategoryProduct::orderBy('id', 'desc')->first();
    //         $nextId = $latestUser ? $latestUser->id + 1 : 1;
    //         $category->kd_kategori_produk = 'categori' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
    //     });
    // }
}