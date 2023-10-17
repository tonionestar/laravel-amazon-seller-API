@php
use Carbon\Carbon;
    $chart = App\Models\Order::all();

    // Get the current date as per your timezone
    $currentDate = date('Y-m-d');

    // Initialize the variables
    $chart_d = [];
    $chart_w = [];
    $chart_m = [];
    $chart_y = [];

    // Loop through each order and store data in respective variables
    foreach ($chart as $order) {
        $orderDate = $order->order_date;
        $orderTime = $order->order_time;
        $itemTotal = $order->item_total;

        if ($orderDate === $currentDate) {
            $chart_d[] = [
                'order_date' => $orderDate . ' ' . $orderTime,
                'item_total' => $itemTotal
            ];
        }

        if (Carbon::parse($orderDate)->isSameWeek($currentDate)) {
            $chart_w[] = [
                'order_date' => $orderDate . ' ' . $orderTime,
                'item_total' => $itemTotal
            ];
        }

        if (Carbon::parse($orderDate)->format('Y-m') === date('Y-m')) {
            $chart_m[] = [
                'order_date' => $orderDate . ' ' . $orderTime,
                'item_total' => $itemTotal
            ];
        }

        if (Carbon::parse($orderDate)->format('Y') === date('Y')) {
            $chart_y[] = [
                'order_date' => $orderDate,
                'item_total' => $itemTotal
            ];
        }
    }
@endphp

<x-default-layout>

    @section('title')
        Orders
    @endsection

    @section('breadcrumbs')
        {{-- {{ Breadcrumbs::render('dashboard') }} --}}
    @endsection

    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}" />

    <span id="chart_d" data-value='<?php echo json_encode($chart_d); ?>'></span>
    <span id="chart_w" data-value='<?php echo json_encode($chart_w); ?>'></span>
    <span id="chart_m" data-value='<?php echo json_encode($chart_m); ?>'></span>
    <span id="chart_y" data-value='<?php echo json_encode($chart_y); ?>'></span>

    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <!--begin::Col-->
        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
            @include('partials/widgets/cards/totalSales')
            @include('partials/widgets/cards/warehouseFee')
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
            @include('partials/widgets/cards/shippingFee')
            @include('partials/widgets/cards/overallProfit')
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
            @include('partials/widgets/cards/amazonFee')
            @include('partials/widgets/cards/ourProfit')
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
            @include('partials/widgets/cards/totalCog')
            @include('partials/widgets/cards/totalProduct')
        </div>
        <!--end::Col-->
    </div>
    <!--begin::Row-->
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <!--begin::Col-->
        <div class="col-xl-4">
            @include('partials/widgets/charts/_widget-35')
        </div>
        <!--end::Col-->

        <!--begin::Col-->
        <div class="col-xl-8">
            <!--begin::Table widget 14-->
            <div class="card card-flush h-md-100">
                <!--begin::Header-->
                <div class="card-header pt-7">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-gray-800">ORDERS</span>
                        <span class="text-gray-400 mt-1 fw-semibold fs-6">Latest 10 Orders</span>
                    </h3>
                    <!--end::Title-->
                    <!--begin::Toolbar-->
                    <div class="card-toolbar">
                        <a href="#" class="btn btn-sm btn-light">History</a>
                    </div>
                    <!--end::Toolbar-->
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-6">
                    <!--begin::Table container-->
                    <div class="table-responsive" style="max-height: 400px; overflow-x: auto;">
                        <!--begin::Table-->
                        <table class="table table-row-dashed align-middle gs-0 gy-3 my-0">
                            <!--begin::Table head-->
                            <thead>
                                <tr class="fs-7 fw-bold text-gray-500 border-bottom-0">
                                    <th class="p-0 pb-3 text-center" style="width: 10%">ORDER ID</th>
                                    <th class="p-0 pb-3 text-center" style="width: 6%">ORDER DATE</th>
                                    <th class="p-0 pb-3 text-center" style="width: 6%">ORDER TIME</th>
                                    <th class="p-0 pb-3 text-center" style="width: 30%">PRODUCT NAME</th>
                                    <th class="p-0 pb-3 text-center">QUANTITY</th>
                                    <th class="p-0 pb-3 text-center" style="width: 7%">UNIT PRICE</th>
                                    <th class="p-0 pb-3 text-center" style="width: 7%">ITEM TOTAL</th>
                                    <th class="p-0 pb-3 text-center" style="width: 7%">AMAZON FEE</th>
                                    <th class="p-0 pb-3 text-center" style="width: 7%">SHIPPING FEE</th>
                                    <th class="p-0 pb-3 text-center" style="width: 8%">WAREHOUSE FEE</th>
                                    <th class="p-0 pb-3 text-center" style="width: 7%">COG</th>
                                    <th class="p-0 pb-3 text-center">PROFIT</th>
                                </tr>
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td class="text-center pe-0">
                                            <!--begin::Label-->
                                            <span class="text-gray-600 fw-bold fs-7">{{ $order->order_id }}</span>
                                            <!--end::Label-->
                                        </td>
                                        <td class="text-center pe-0">
                                            {{-- <span class="badge py-3 px-4 fs-7 badge-light-primary">In Process</span> --}}
                                            <span class="text-gray-600 fw-bold fs-7">{{ $order->order_date }}</span>
                                        </td>
                                        <td class="text-center pe-0">
                                            <span class="text-gray-600 fw-bold fs-7">{{ $order->order_time }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-start flex-column">
                                                <div class="text-gray-1000 fw-bold badge-light-primary mb-1 fs-7">
                                                    {{ $order->product_name }}
                                                </div>
                                                <span class="text-gray-600 fw-semibold d-block fs-7">ASIN: {{ $order->product_asin }}</span>
                                                <span class="text-gray-600 fw-semibold d-block fs-7">SKU: {{ $order->sku }}</span>
                                            </div>
                                        </td>
                                        <td class="text-center pe-0">
                                            <span class="text-gray-600 fw-bold fs-7">{{ $order->quantity }}</span>
                                        </td>
                                        <td class="text-center pe-0">
                                            <span class="text-gray-600 fw-bold fs-7">{{ $order->item_price }}</span>
                                        </td>
                                        <td class="text-center pe-0">
                                            <span class="text-gray-600 fw-bold fs-7">{{ $order->item_total }}</span>
                                        </td>
                                        <td class="text-center pe-0">
                                            <span class="text-gray-600 fw-bold fs-7">{{ $order->amazon_fee }}</span>
                                        </td>
                                        <td class="text-center pe-0">
                                            <span class="text-gray-600 fw-bold fs-7">{{ $order->shipping_fee }}</span>
                                        </td>
                                        <td class="text-center pe-0">
                                            <span class="text-gray-600 fw-bold fs-7">{{ $order->warehouse_fee }}</span>
                                        </td>
                                        <td class="text-center pe-0">
                                            <span class="text-gray-600 fw-bold fs-7">{{ $order->cost_per_unit }}</span>
                                        </td>
                                        <td class="text-center pe-0">
                                            <span class="text-gray-600 fw-bold fs-7">{{ $order->profit }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <!--end::Table body-->
                        </table>
                    </div>
                    <!--end::Table-->
                </div>
            </div>
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->
</x-default-layout>
