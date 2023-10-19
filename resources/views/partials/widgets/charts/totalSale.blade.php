@php
    use App\Models\Order;
	use Carbon\Carbon;

	$currentMonth = Carbon::now()->month;
	$currentYear = Carbon::now()->year;

	$totalSales = Order::whereMonth('order_date', $currentMonth)
						->whereYear('order_date', $currentYear)
						->sum('item_total');

@endphp

<!--begin::Chart widget 3-->
<div class="card card-flush overflow-hidden h-md-100">
	<!--begin::Header-->
	<div class="card-header py-5">
		<!--begin::Title-->
		<h3 class="card-title align-items-start flex-column">
			<span class="card-label fw-bold text-dark">Total Sales for the Current Month</span>
		</h3>
		<!--end::Title-->
	</div>
	<!--end::Header-->
	<!--begin::Card body-->
	<div class="card-body d-flex justify-content-between flex-column pb-1 px-0">
		<!--begin::Statistics-->
		<div class="px-9 mb-5">
			<!--begin::Statistics-->
			<div class="d-flex mb-2">
				<span class="fs-4 fw-semibold text-gray-400 me-1">$</span>
				<span class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">{{ $totalSales }}</span>
			</div>
			<!--end::Statistics-->
		</div>
		<!--end::Statistics-->
		<!--begin::Chart-->
		<div id="kt_charts_widget_3" class="min-h-auto ps-4 pe-6" style="height: 350px"></div>
		<!--end::Chart-->
	</div>
	<!--end::Card body-->
</div>
<!--end::Chart widget 3-->