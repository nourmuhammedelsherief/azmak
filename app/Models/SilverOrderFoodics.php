<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SilverOrderFoodics extends Model
{
    use HasFactory;

    protected $table = 'silver_order_foodics';
    protected $fillable = [
        'foodics_id', 'foodics_status', 'user_id', 'restaurant_id', 'branch_id' , 'foodics_reference'
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function details()
    {
        return $this->hasMany(SilverOrder::class, 'order_id');
    }
    // '_foodics_status' => [
    // 	'1' => 'انتظار' ,
    // 	'2' => 'نشط' ,
    // 	'3' => 'انتهي' ,
    // 	'4' => 'في الطريق' ,
    // 	'5' => 'فارغ' ,
    // 	'6' => 'مرتجع' ,
    // 	'7' => 'مرفوض' ,

    // ] ,
    public function getFoodicsStatusHtml()
    {
        $content = '';
        if ($this->foodics_status == 2) {
            $content = '<span class="badge badge-primary">' . trans('dashboard._foodics_status.' . $this->foodics_status) . '</span>';
        } elseif (in_array($this->foodics_status, [5, 6, 7,3])) {
            $content = '<span class="badge badge-danger">' . trans('dashboard._foodics_status.' . $this->foodics_status) . '</span>';
        } elseif ($this->foodics_status == 4) {
            $content = '<span class="badge badge-success">' . trans('dashboard._foodics_status.' . $this->foodics_status) . '</span>';
        } else {
            $content = '<span class="badge badge-info">' . trans('dashboard._foodics_status.1') . '</span>';
        }

        return $content;
    }

    public function getFoodicsStatusHtml2()
    {
        $content = '';
        if ($this->foodics_status == 1) :
            $content = '<span class="badge badge-secondary">' . trans('dashboard._foodics_status.' . $this->foodics_status) . '</span>';
        elseif ($this->foodics_status == 2) :
            $content = '<span class="badge badge-primary">' . trans('dashboard._foodics_status.' . $this->foodics_status) . '</span>';
        elseif ($this->foodics_status == 3) :
            $content = '<span class="badge badge-danger">' . trans('dashboard._foodics_status.' . $this->foodics_status) . '</span>';
        elseif ($this->foodics_status == 4) :
            $content = '<span class="badge badge-success">' . trans('dashboard._foodics_status.' . $this->foodics_status) . '</span>';
        elseif ($this->foodics_status == 5) :
            $content  = '<span class="badge badge-warning">' . trans('dashboard._foodics_status.' . $this->foodics_status) . '</span>';
        elseif ($this->foodics_status == 6) :
            $content = '<span class="badge badge-info">' . trans('dashboard._foodics_status.' . $this->foodics_status) . '</span>';
        elseif ($this->foodics_status == 7) :
            $content = '<span class="badge badge-info">' . trans('dashboard._foodics_status.' . $this->foodics_status) . '</span>';
        endif;

        return $content;
    }
}
