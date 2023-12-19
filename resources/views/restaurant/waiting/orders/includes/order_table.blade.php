<div class="top-action">
    <hr>
    <a href="{{ route('restaurant.waiting.order.index') }}?status=new" class="btn btn-primary"
        style="background-color: {{ request('status') == 'new' ? 'blueviolet' : '' }};">
        <i class="fas fa-filter"></i>
        @lang('dashboard.new') ({{ $restaurant->waitingOrders()->where('status', 'new')->count() }})
    </a>

    <a href="{{ route('restaurant.waiting.order.index') }}?status=in_progress" class="btn btn-primary"
        style="background-color: {{ request('status') == 'in_progress' ? 'blueviolet' : '' }};">
        <i class="fas fa-filter"></i>
        @lang('dashboard.in_progress') ({{ $restaurant->waitingOrders()->where('status', 'in_progress')->count() }})
    </a>
    <a href="{{ route('restaurant.waiting.order.index') }}?status=completed" class="btn btn-primary"
        style="background-color: {{ request('status') == 'completed' ? 'blueviolet' : '' }};">
        <i class="fas fa-filter"></i>
        @lang('dashboard.completed') ({{ $restaurant->waitingOrders()->where('status', 'completed')->count() }})
    </a>
    <a href="{{ route('restaurant.waiting.order.index') }}?status=canceled" class="btn btn-primary"
        style="background-color: {{ request('status') == 'canceled' ? 'blueviolet' : '' }};">
        <i class="fas fa-filter"></i>
        @lang('dashboard.canceled') ({{ $restaurant->waitingOrders()->where('status', 'canceled')->count() }})
    </a>
</div>

<div class="card">
    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>

                    <th> @lang('dashboard.waiter_order_id') </th>
                    <th> @lang('dashboard.branch') </th>
                    <th> @lang('dashboard.place') </th>
                    <th> @lang('dashboard.entry.name') </th>
                    <th> @lang('dashboard.entry.phone') / <br> @lang('dashboard.entry.email') </th>
                    <th> {{ trans('dashboard.people_count') }} </th>
                    <th> @lang('dashboard.note') </th>
                    <th> @lang('dashboard.order_status') </th>
                    <th> @lang('dashboard.waiting_count') </th>
                    
                    <th> @lang('dashboard.entry.created_at') </th>
                    <th> @lang('messages.operations') </th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 0; ?>
                @foreach ($orders as $index => $item)
                    <tr class="odd gradeX">

                        <td>{{ $item->num }}</td>
                        <td>
                            @if (isset($item->branch->id))
                                <a
                                    href="{{ route('restaurant.waiting.branch.edit', $item->branch_id) }}">{{ $item->branch->name }}</a>
                            @endif
                        </td>
                        <td>
                            @if (isset($item->place->id))
                                <a
                                    href="{{ route('restaurant.waiting.place.edit', $item->place_id) }}">{{ $item->place->name }}</a>
                            @endif
                        </td>
                        <td style="">
                            {{ $item->name }}
                        </td>
                        <td style="">
                            @if (!empty($item->phone))
                                <a href="tel:{{ $item->phone }}">{{ $item->phone }}</a>
                            @endif

                            @if (!empty($item->email))
                                <br>
                                <a href="mailto:{{ $item->email }}">{{ $item->email }}</a>
                            @endif
                        </td>
                        <td style="">
                            {{ $item->people_count }}
                        </td>
                        <td>{!! $item->note !!}</td>
                        <td>
                            @if ($item->status == 'new')
                                <span class="badge badge-secondary">{{ trans('dashboard.new') }}</span>
                            @elseif($item->status == 'in_progress')
                                <span class="badge badge-primary">{{ trans('dashboard.' . $item->status) }}</span>
                            @elseif($item->status == 'completed')
                                <span class="badge badge-success">{{ trans('dashboard.' . $item->status) }}</span>
                            @elseif($item->status == 'canceled')
                                <span class="badge badge-danger">{{ trans('dashboard.' . $item->status) }}</span>
                            @endif
                        </td>
                        <td>{{ $item->status == 'new' ? $item->waiting_count : '' }}</td>
                        <td>{{ date('Y-m-d h:i A', strtotime($item->created_at)) }}</td>
                        <td>
                            @if ($item->status == 'in_progress')
                                <a class="complete-order btn btn-success" data-id="{{ $item->id }}"
                                    data_name="{{ $index + 1 }}">
                                    {{ trans('dashboard.waiting_completed') }}
                                </a>
                            @endif
                            <a class="delete_data btn btn-danger" data="{{ $item->id }}"
                                data_name="{{ $index + 1 }}">
                                <i class="fa fa-key"></i> @lang('messages.delete')
                            </a>


                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {!! $orders->links() !!}
    </div>
</div>
