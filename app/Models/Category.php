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

    // علاقة مع الفئات الفرعية (Child categories)
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // إضافة علاقة مع المنتجات
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
