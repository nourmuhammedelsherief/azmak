<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableOrderItem extends Model
{
    use HasFactory;
    protected $table = 'table_order_items';
    protected $fillable = [
        'table_order_id',
        'product_id',
        'size_id',
        'product_count',
        'price' , 
        'loyalty_points' , 
        'product_name_ar' , 'product_name_en' , 'size_name_en' , 'size_name_ar'
    ];
    public function getProductNameAttribute(){
        return $this->attributes['product_name_'  . app()->getLocale()];
    }
    public function getSizeNameAttribute(){
        return $this->attributes['size_name_'  . app()->getLocale()];
    }
    public function table_order()
    {
        return $this->belongsTo(TableOrder::class , 'table_order_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class , 'product_id');
    }
    public function size()
    {
        return $this->belongsTo(ProductSize::class , 'size_id');
    }
    public function order_item_options()
    {
        return $this->hasMany(TableOrderItemOption::class , 'table_order_item_id');
    }
}
