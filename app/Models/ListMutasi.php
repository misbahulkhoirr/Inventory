<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListMutasi extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function supplier(){
        return $this->belongsTo(Supplier::class,'supplier_id');
    }
    public function gudang(){
        return $this->belongsTo(Gudang::class,'gudang_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'created_by');
    }
    public function jumlah(){
        return $this->hasMany(Mutasi::class,'list_mutasi_id');
    }
    public function mutasis(){
        return $this->hasMany(Mutasi::class,'list_mutasi_id');
    }
}
