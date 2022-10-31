<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Gudang extends Model
{
    use HasFactory;
    // protected $appends = ['Stok'];
    
    protected $fillable = [
        'name',
        'alamat',
    ];
    public function saldo(){
        return $this->hasMany(SaldoProduct::class,'gudang_id');
    }

    public function getStok(){
        return $this->hasMany(SaldoProduct::class,'gudang_id');
    }

    public function cek($product_id,$gudang_id){
        return $this->getStok()->where('product_id',$product_id)->where('gudang_id',$gudang_id)->get();
    }
    
}
