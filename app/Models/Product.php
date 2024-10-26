<?php

namespace App\Models;

use App\Trait\FilterableProductsTrait;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use FilterableProductsTrait;

    protected $fillable = [
        'name',
        'description',
        'price',
        'vendor_id',
        'stock',
    ];


    public function category()
    {
        return $this->belongsToMany(Category::class, 'category_product', 'product_id', 'category_id');
    }

    public function customizationOptions()
    {
        return $this->belongsToMany(CustomizationOption::class, 'product_customization_option', 'product_id', 'customization_option_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
