<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomizationOption extends Model
{

    protected $table = 'customization_options';

    protected $fillable = ['value', 'customization_id'];

    public function customization()
    {
        return $this->belongsTo(Customization::class, 'customization_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_customization_option', 'customization_option_id', 'product_id');
    }

}
