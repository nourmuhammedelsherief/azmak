<?php

namespace App\Models\ServiceProvider;

use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceProviderSubscription extends Model
{
    use HasFactory;
    const statuses = [
        'new', 'wait_to_paid', 'in_progress', 'canceled', 'completed', 'denied'
    ];
    protected $fillable = [
        'service_provider_id', 'service_provider_name', 'start_date', 'end_date', 'status', 'accepted_by_id', 'accepted_by_name', 'price', 'paid_at',
        'payment_type', // enum [cash,myfatoora , bank]
        'payment_method', // enum ['mada' , 'visa' , 'apple' , 'cash']
        'bank_transfer', 'invoice_id', 'bank_id',
        'transfer_upload_date', 'add_by_admin', 'add_by_service_provider',
    ];

    // public function getBankTransferPathAttribute(){
    //     return empty($this->bank_transfer) ? null : 'uploads/service_provider_subscriptions/' . $this->bank_transfer;
    // }

    public function serviceProvider()
    {
        return $this->belongsTo(ServiceProvider::class, 'service_provider_id');
    }

    public function getStatusHtml()
    {
        if ($this->status == 'new') :
            return '<span class="badge badge-info">' . trans('dashboard._service_provice_subscription_status.' . $this->status) . '</span>';

        elseif ($this->status == 'in_progress') :
            return '<span class="badge badge-primary">' . trans('dashboard._service_provice_subscription_status.' . $this->status) . '</span>';
        elseif ($this->status == 'paid') :
            return '<span class="badge badge-primary">' . trans('dashboard._service_provice_subscription_status.' . $this->status) . '</span>';
        elseif ($this->status == 'wait_to_paid') :
            return '<span class="badge badge-warning">' . trans('dashboard._service_provice_subscription_status.' . $this->status) . '</span>';
        elseif ($this->status == 'completed') :
            return '<span class="badge badge-success">' . trans('dashboard._service_provice_subscription_status.' . $this->status) . '</span>';
        elseif ($this->status == 'canceled') :
            return '<span class="badge badge-danger">' . trans('dashboard._service_provice_subscription_status.' . $this->status) . '</span>';
        elseif ($this->status == 'denied') :
            return '<span class="badge badge-danger">' . trans('dashboard._service_provice_subscription_status.' . $this->status) . '</span>';

        endif;

        return '--';
    }




    public function admin()
    {
        return $this->belongsTo(Admin::class, 'accepted_by_id');
    }
    public static function updateStatus()
    {
        $now = Carbon::parse(date('Y-m-d'));
        $items = ServiceProviderSubscription::whereIn('status', ['paid', 'in_progress'])->get();
        foreach ($items as $item) :
            if (empty($item->start_date) or empty($item->end_date)) :
                $item->update([
                    'status' => 'canceled'
                ]);
            else :
                $cStart = Carbon::parse($item->start_date);
                $cEnd = Carbon::parse($item->end_date);
                if ($now->greaterThanOrEqualTo($cStart) and $now->lessThanOrEqualTo($cEnd) and $item->status == 'paid') :
                    $item->update([
                        'status' => 'in_progress',
                    ]);
                elseif ($now->greaterThan($cEnd)) :
                    $item->update([
                        'status' => 'completed',
                    ]);
                endif;
            endif;
        endforeach;
    }

    public function addByAdmin()
    {
        return $this->belongsTo(Admin::class, 'add_by_admin');
    }
    public function addByServiceProvider()
    {
        return $this->belongsTo(ServiceProvider::class, 'add_by_service_provider');
    }
}
