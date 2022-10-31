<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Move extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'tanggal',
        'dari_gudang',
        'ke_gudang',
        'amount'
    ];
    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
    public function dariGudang(){
        return $this->belongsTo(Gudang::class,'dari_gudang');
    }
    public function keGudang(){
        return $this->belongsTo(Gudang::class,'ke_gudang');
    }
}
