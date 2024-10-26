<?php

namespace App\Trait;

use Illuminate\Database\Eloquent\Builder;

trait FilterableProductsTrait
{
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when(!empty($filters['search']), function ($query) use ($filters) {
                $query->where('name', 'like', '%' . $filters['search'] . '%');
            })
            ->when(!empty($filters['vendor_id']), function ($query) use ($filters) {
                $query->whereHas('vendor', function ($q) use ($filters) {
                    $q->where('vendors.id', $filters['vendor_id']);
                });
            })
            ->when(!empty($filters['category_id']), function ($query) use ($filters) {
                $query->whereHas('category', function ($q) use ($filters) {
                    $q->where('categories.id', $filters['category_id']);
                });
            })
            ->when(!empty($filters['custom_options']), function ($query) use ($filters) {
                $query->whereHas('customizationOptions', function ($q) use ($filters) {
                    $q->whereIn('customization_options.id', $filters['custom_options']);
                });
            })
            ->when(!empty($filters['price_sort']), function ($query) use ($filters) {
                $query->orderBy('price', $filters['price_sort'] === 'asc' ? 'asc' : 'desc');
            })
            ->when(!empty($filters['stock_sort']), function ($query) use ($filters) {
                $query->orderBy('stock', $filters['stock_sort'] === 'asc' ? 'asc' : 'desc');
            });
    }
}
