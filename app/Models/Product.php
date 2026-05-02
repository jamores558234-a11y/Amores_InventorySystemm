<?php
// FILE PATH: app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'sku', 'description', 'category_id', 'supplier_id',
        'price', 'quantity', 'reorder_level', 'unit', 'status',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    public function isLowStock(): bool
    {
        return $this->quantity <= $this->reorder_level;
    }

    public function getStatusBadgeAttribute(): string
    {
        return $this->quantity === 0
            ? 'out-of-stock'
            : ($this->isLowStock() ? 'low-stock' : 'in-stock');
    }
}