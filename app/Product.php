<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function invoice_detail()
    {
        return $this->hasMany(InvoiceDetail::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
