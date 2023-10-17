<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<!--begin::Table widget 14-->
<div class="card card-flush h-md-100">
	<!--begin::Header-->
	<div class="card-header pt-7">
		<!--begin::Title-->
		<h3 class="card-title align-items-start flex-column">
			<span class="card-label fw-bold text-gray-800">ORDERS</span>
		</h3>
		<div class="mb-0">
				<form method="GET" action="{{ route('dashboard.orders') }}" id="order_form">
					<input class="form-control form-control-solid" name="date_range" placeholder="Pick date rage" id="kt_daterangepicker" value="{{$dateRequest}}" />
				</form>
			</div>
	</div>
	<!--end::Header-->
	<!--begin::Body-->
	<div class="card-body pt-6">
			
		<!--begin::Table container-->
		<div class="table-responsive">
			<!--begin::Table-->
			<table class="table table-row-dashed align-middle gs-0 gy-3 my-0">
				<!--begin::Table head-->
				<thead>
					<tr class="fs-7 fw-bold text-gray-500 border-bottom-0">
						<th class="p-0 pb-3 text-center">STATUS</th>
						<th class="p-0 pb-3 text-center" style="width: 10%">ORDER ID</th>
						<th class="p-0 pb-3 text-center" style="width: 6%">ORDER DATE</th>
						<th class="p-0 pb-3 text-center" style="width: 6%">ORDER TIME</th>
						<th class="p-0 pb-3 text-center" style="width: 23%">PRODUCT NAME</th>
						<th class="p-0 pb-3 text-center">QUANTITY</th>
						<th class="p-0 pb-3 text-center">UNIT PRICE</th>
						<th class="p-0 pb-3 text-center">ITEM TOTAL</th>
						<th class="p-0 pb-3 text-center">AMAZON FEE</th>
						<th class="p-0 pb-3 text-center" style="width: 7%">SHIPPING FEE</th>
						<th class="p-0 pb-3 text-center" style="width: 8%">WAREHOUSE FEE</th>
						<th class="p-0 pb-3 text-center">COG</th>
						<th class="p-0 pb-3 text-center">PROFIT</th>
						<th class="p-0 pb-3 text-center">CARRIER</th>
					</tr>
				</thead>
				<!--end::Table head-->
				<!--begin::Table body-->
				<tbody>
					@foreach($orders as $order)
						<tr>
							<td>
								<div class="text-center d-flex align-items-center">
									<span class="badge badge-light-success fs-base">{{ $order->order_status }}</span>
								</div>
							</td>
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
							<td class="text-center pe-0">
								<span class="text-gray-600 fw-bold fs-7">{{ $order->shipping_carrier }}</span>
							</td>
						</tr>
					@endforeach
				</tbody>
				<!--end::Table body-->
			</table>
		</div>
		<!--end::Table-->
		<!-- Pagination Links -->
		<div class="d-flex justify-content-center mt-3">
			<ul class="pagination">
				<!-- Previous Page Link -->
				@if ($orders->onFirstPage())
					<li class="page-item disabled">
						<a class="page-link" href="#" tabindex="-1" aria-disabled="true">&laquo;</a>
					</li>
				@else
					<li class="page-item">
						<a class="page-link" href="{{ $orders->previousPageUrl() }}" tabindex="-1" aria-disabled="false">&laquo;</a>
					</li>
				@endif
		
				<!-- Pagination links -->
				@for ($page = 1; $page <= $orders->lastPage(); $page++)
					@if ($page == $orders->currentPage())
						<li class="page-item active">
							<a class="page-link" href="{{ $orders->appends(request()->input())->url($page) }}">{{ $page }}</a>
						</li>
					@else
						<li class="page-item">
							<a class="page-link" href="{{ $orders->appends(request()->input())->url($page) }}">{{ $page }}</a>
						</li>
					@endif
				@endfor
		
				<!-- Next Page Link -->
				@if ($orders->hasMorePages())
					<li class="page-item">
						<a class="page-link" href="{{ $orders->nextPageUrl() }}">&raquo;</a>
					</li>
				@else
					<li class="page-item disabled">
						<a class="page-link" href="#" tabindex="-1" aria-disabled="true">&raquo;</a>
					</li>
				@endif
			</ul>
		</div>
	</div>
	<!--end: Card Body-->
</div>
<!--end::Table widget 14-->

<script>
	$(function () {
		$("#kt_daterangepicker").daterangepicker();

		$("#kt_daterangepicker").change(function() {
			$("#order_form").submit();
		})
	})
</script>