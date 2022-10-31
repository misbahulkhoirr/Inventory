<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opname extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['DetailOpname'];
    
    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
    public function createBy(){
        return $this->belongsTo(User::class,'created_by');
    }
    public function userId(){
        return $this->belongsTo(User::class,'petugas_id');
    }
    public function detail(){
        return $this->hasMany(DetailOpname::class);
    }
    public function gudang(){
        return $this->belongsTo(Gudang::class,'gudang_id');
    }
    public function getDetailOpnameAttribute(){
        return $this->detail()->orderBy('id','ASC')->get();
    }
    public function operators(){
        return $this->hasMany(PetugasOpname::class,'opname_id');
    }
}
