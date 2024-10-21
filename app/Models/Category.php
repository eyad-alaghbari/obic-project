<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'parent_id','description'];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_product', 'category_id', 'product_id');
    }

    public function vendors()
    {
        return $this->belongsToMany(Vendor::class, 'category_vendor', 'category_id', 'vendor_id');
    }

    public function customizations()
    {
        return $this->belongsToMany(Customization::class, 'category_customization', 'category_id', 'customization_id');
    }

    // public function options()
    // {
    //     return $this->hasManyThrough(CustomizationOption::class, Customization::class, 'category_id', 'customization_id');
    // }
}
