<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Storage;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ["stok","satuan"];

    public function storageId()
    {
        return $this->belongsTo(Storage::class, 'storage_id');
    }
    public function getStokAttribute(){
        return $this->stoks()->get();
    }
    public function stoks(){
        return $this->hasMany(SaldoProduct::class,'product_id');
    }
    public function category(){
        return $this->belongsTo(CategoryProduct::class,'category_product_id');
    }
    public function getSatuanAttribute(){
        return $this->satuan()->first();
    }
    public function satuan(){
        return $this->belongsTo(Satuan::class,'satuan_id');
    }
}
