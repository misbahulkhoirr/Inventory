<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailOpname extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['DetailProduct'];

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
    public function getDetailProductAttribute(){
        return $this->product()->first();
    }
}
