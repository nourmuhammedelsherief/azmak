<?php

namespace App\Models\Waiting;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WaitingOrder extends Model
{
    use HasFactory;
    protected $table = 'waiting_orders';
    protected $fillable = [
        'place_name' , 'name' , 'email' , 'phone' , 'status' , 'restaurant_id' , 'branch_id' , 'place_id' , 'in_progress_date' , 'message_count' , 'people_count', 'note' , 'num' , 'user_id' , 'token'
    ];


    public function restaurant(){
        return $this->belongsTo(Restaurant::class , 'restaurant_id');
    }
    public function branch(){
        return $this->belongsTo(WaitingBranch::class , 'branch_id');
    }
    public function user(){
        return $this->belongsTo(User::class , 'user_id');
    }
    public function place(){
        return $this->belongsTo(WaitingPlace::class , 'place_id');
    }
    public function waitingCount(){
        return DB::select("select count(*) as count from waiting_orders as w where w.id != ".$this->id." and w.status in('new') and w.created_at < '".$this->created_at."'")[0]->count;
    }

    public static function getNewNum($restaurantId){
        return WaitingOrder::where('restaurant_id' , $restaurantId)->where('created_at' , 'like' , "%".date('Y-m-d')."%")->max('num') + 1;
    }
}
