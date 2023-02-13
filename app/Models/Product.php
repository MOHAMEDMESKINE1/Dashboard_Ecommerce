<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory,SoftDeletes;
    // protected $fillable = [ 'name', 'description', 'image', 'price', 'discount_price', 'category_id'];
    protected $guarded=[''];
    protected $table = 'products';


    public  function category(){
        
        return $this->belongsTo(Category::class, 'category_id');
    }
   
}
