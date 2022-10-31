<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mutasi extends Model
{
    use HasFactory;
    // protected $fillable = [
    //     'gudang_id',
    //     'product_id',
    //     'created_by',
    //     'mutasi',
    //     'jumlah',
    //     'supplier_id',
    //     'balance',
    //     'keterangan',
    //     'deleted_at',
    //     'created_at'
    // ];
    protected $guarded = [];
    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
    public function supplier(){
        return $this->belongsTo(Supplier::class,'supplier_id');
    }
    public function gudang(){
        return $this->belongsTo(Gudang::class,'gudang_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'created_by');
    }
}
