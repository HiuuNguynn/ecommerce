<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Brand;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products'; // Đảm bảo tên bảng đúng

    protected $fillable = [
        'name', 'slug', 'short_description', 'description', 'regular_price',
        'sale_price', 'SKU', 'stock_status', 'featured', 'quantity', 
        'image', 'gallery_images', 'category_id', 'brand_id'
    ];

    public function category() 
    {
        return $this->belongsTo(Category::class, 'category_id');    
    }

    public function brand() 
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
}
