<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaldoProduct extends Model
{
    use HasFactory;
    protected $appends = ['GudangProduct'];//,,,'Produk'
    protected $fillable = [
        'product_id',
        'gudang_id',
        'saldo'
    ];
    // public function getProdukAttribute(){
    //     return $this->product()->first();
    // }
    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
    public function getGudangProductAttribute(){
        return $this->gudang()->first();
    }
    public function gudang(){
        return $this->belongsTo(Gudang::class,'gudang_id');
    }
}
