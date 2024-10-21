<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customization extends Model
{
    protected $table = 'customizations';

    protected $fillable = ['name'];

    public function options()
    {
        return $this->hasMany(CustomizationOption::class);
    }

    public function category()
    {
        return $this->belongsToMany(Category::class, 'category_customization', 'customization_id', 'category_id');
    }

}
