<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableOrderItemOption extends Model
{
    use HasFactory;
    protected $table = 'table_order_item_options';
    protected $fillable = [
        'table_order_item_id',
        'option_id',
        'option_count',
        'option_name_en' , 'option_name_ar' , 'price'
    ];
    public function getOptionNameAttribute(){
        return $this->attributes['option_name_'  . app()->getLocale()];
    }
    public function table_order_item()
    {
        return $this->belongsTo(TableOrderItem::class , 'table_order_item_id');
    }
    public function option()
    {
        return $this->belongsTo(Option::class , 'option_id');
    }
}
