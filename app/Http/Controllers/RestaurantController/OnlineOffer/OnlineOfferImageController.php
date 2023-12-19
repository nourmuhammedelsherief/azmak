<?php

namespace App\Http\Controllers\RestaurantController\OnlineOffer;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\LuckyItem;
use App\Models\OnlineOfferCategory;
use App\Models\OnlineOfferImage;
use App\Models\ServiceSubscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OnlineOfferImageController extends Controller
{
    private $restaurant, $subscription;
    public function __construct()
    {
        $this->middleware('auth:restaurant');
        $this->middleware(function ($request, $next) {
            $this->restaurant = auth('restaurant')->user();

            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $restaurant = $this->restaurant;
        $items = OnlineOfferImage::whereHas('category' , function($query)use($restaurant){
            $query->whereHas('branch' , function($query)use($restaurant){
                $query->where('restaurant_id' , $restaurant->id);
            });
        })->with('category')->paginate(500);
        return view('restaurant.online_offers.images.index', compact('items', 'restaurant'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $restaurant = $this->restaurant;

        $categories = OnlineOfferCategory::whereHas('branch' , function($query)use($restaurant){
            $query->where('restaurant_id' , $restaurant->id);
        })->get();
        return view('restaurant.online_offers.images.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $restaurant = $this->restaurant;
        $this->validate($request, [
            'category_id' => 'required|integer' ,
            'status' => 'required|in:true,false' ,
            'image' => 'required|image' ,

        ]);
        // create new employee
        $employee = OnlineOfferImage::create([
            // 'restaurant_id' => $restaurant->id,
            'category_id'  => $request->category_id,
            'status' => $request->status ,
            'path' => UploadImage($request->file('image'), 'photo', '/uploads/online_offers'),
        ]);
        flash(trans('messages.created'))->success();
        return redirect()->route('restaurant.online_offer.image.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $restaurant = $this->restaurant;
        $item = OnlineOfferImage::whereHas('category' , function($query)use($restaurant){
            $query->whereHas('branch' , function($query)use($restaurant){
                $query->where('restaurant_id' , $restaurant->id);
            });
        })->findOrFail($id);
        $categories = OnlineOfferCategory::whereHas('branch' , function($query)use($restaurant){
            $query->where('restaurant_id' , $restaurant->id);
        })->get();
        return view('restaurant.online_offers.images.edit', compact( 'item' , 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $restaurant = $this->restaurant;
        $item =  OnlineOfferImage::whereHas('category' , function($query)use($restaurant){
            $query->whereHas('branch' , function($query)use($restaurant){
                $query->where('restaurant_id' , $restaurant->id);
            });
        })->findOrFail($id);
        $this->validate($request, [
            'category_id' => 'required|integer' ,
            'status' => 'required|in:true,false' ,
            'image' => 'nullable|image' ,

        ]);
        $image = $item->path;
        if($request->hasFile('image')):
            if(Storage::disk('public_storage')->exists($item->image_path)):
                Storage::disk('public_storage')->delete($item->image_path);
            endif;
            $image = UploadImage($request->file('image'), 'photo', '/uploads/online_offers');
        endif;
        // create new employee
        $item->update([
            // 'restaurant_id' => $restaurant->id,
            'category_id'  => $request->category_id,
            'status' => $request->status ,
            'path' => $image,
        ]);
        flash(trans('messages.updated'))->success();
        return redirect()->route('restaurant.online_offer.image.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        
        $restaurant = $this->restaurant;
        $employee =  OnlineOfferImage::whereHas('category' , function($query)use($restaurant){
            $query->whereHas('branch' , function($query)use($restaurant){
                $query->where('restaurant_id' , $restaurant->id);
            });
        })->findOrFail($id);
        $employee->delete();
        flash(trans('messages.deleted'))->success();
        return redirect()->route('restaurant.online_offer.image.index');
    }
}
