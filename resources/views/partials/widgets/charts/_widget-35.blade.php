<!--begin::Chart Widget 35-->
<div class="card card-flush h-md-100">
	<!--begin::Header-->
	<div class="card-header pt-5 mb-6">
		<!--begin::Title-->
		<h3 class="card-title align-items-start flex-column">
			<!--begin::Statistics-->
			<div class="d-flex align-items-center mb-2">
				<!--begin::Currency-->
				<span class="fs-3 fw-semibold text-gray-400 align-self-start me-1">$</span>
				<!--end::Currency-->
				<!--begin::Value-->
				<span id="value-placeholder" class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2 active show"></span>
				<!--end::Value-->
				<!--begin::Label-->
				{{-- <span class="badge badge-light-success fs-base">{!! getIcon('arrow-up', 'fs-5 text-success ms-n1') !!} 9.2%</span> --}}
				<!--end::Label-->
			</div>
			<!--end::Statistics-->
			<!--begin::Description-->
			<span class="fs-6 fw-semibold text-gray-400">Avg. Total Sale</span>
			<!--end::Description-->
		</h3>
		<!--end::Title-->
		<!--begin::Toolbar-->
		<div class="card-toolbar">
			<button class="btn btn-icon btn-color-gray-400 btn-active-color-primary justify-content-end" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">{!! getIcon('dots-square', 'fs-1 text-gray-300 me-n1') !!}</button>
		</div>
		<!--end::Toolbar-->
	</div>
	<!--end::Header-->
	<!--begin::Body-->
	<div class="card-body py-0 px-0">
		<!--begin::Nav-->
		<ul class="nav d-flex justify-content-between mb-3 mx-9">
			<!--begin::Item-->
			<li class="nav-item mb-3">
				<!--begin::Link-->
				<a class="nav-link btn btn-flex flex-center btn-active-danger btn-color-gray-600 btn-active-color-white rounded-2 w-45px h-35px active" data-bs-toggle="tab" id="kt_charts_widget_35_tab_1" href="#kt_charts_widget_35_tab_content_1" onclick="updateValue(0)">1d</a>
				<!--end::Link-->
			</li>
			<!--end::Item-->
			<!--begin::Item-->
			<li class="nav-item mb-3">
				<!--begin::Link-->
				<a class="nav-link btn btn-flex flex-center btn-active-danger btn-color-gray-600 btn-active-color-white rounded-2 w-45px h-35px" data-bs-toggle="tab" id="kt_charts_widget_35_tab_2" href="#kt_charts_widget_35_tab_content_2" onclick="updateValue(1)">1w</a>
				<!--end::Link-->
			</li>
			<!--end::Item-->
			<!--begin::Item-->
			<li class="nav-item mb-3">
				<!--begin::Link-->
				<a class="nav-link btn btn-flex flex-center btn-active-danger btn-color-gray-600 btn-active-color-white rounded-2 w-45px h-35px" data-bs-toggle="tab" id="kt_charts_widget_35_tab_3" href="#kt_charts_widget_35_tab_content_3" onclick="updateValue(2)">1m</a>
				<!--end::Link-->
			</li>
			<!--end::Item-->
			<!--begin::Item-->
			<li class="nav-item mb-3">
				<!--begin::Link-->
				<a class="nav-link btn btn-flex flex-center btn-active-danger btn-color-gray-600 btn-active-color-white rounded-2 w-45px h-35px" data-bs-toggle="tab" id="kt_charts_widget_35_tab_4" href="#kt_charts_widget_35_tab_content_4" onclick="updateValue(3)">1y</a>
				<!--end::Link-->
			</li>
			<!--end::Item-->
		</ul>
		<!--end::Nav-->
		<!--begin::Tab Content-->
		<div class="tab-content mt-n6">
			<!--begin::Tap pane-->
			<div class="tab-pane fade active show" id="kt_charts_widget_35_tab_content_1">
				<!--begin::Chart-->
				<div id="kt_charts_widget_35_chart_1" data-kt-chart-color="primary" class="min-h-auto h-200px ps-3 pe-6"></div>
				<!--end::Chart-->
				<!--begin::Table container-->
				<div class="table-responsive mx-9 mt-n6">
					<!--begin::Table-->
					<table class="table align-middle gs-0 gy-4">
						<!--begin::Table head-->
						<thead>
							<tr>
								<th class="min-w-100px"></th>
								<th class="min-w-100px text-end pe-0"></th>
								<th class="text-end min-w-50px"></th>
							</tr>
						</thead>
						<!--end::Table head-->
						<!--begin::Table body-->
						<tbody>
							<tr>
								<td>
									<a href="#" class="text-gray-600 fw-bold fs-6" id="biggestLabel1"></a>
								</td>
								<td class="pe-0 text-end">
									<span class="text-gray-800 fw-bold fs-6 me-1" id="biggestData1"></span>
								</td>
								<td class="pe-0 text-end">
									<span class="fw-bold fs-6 text-success" id="in1"></span>
								</td>
							</tr>
							<tr>
								<td>
									<a href="#" class="text-gray-600 fw-bold fs-6" id="lowestLabel1"></a>
								</td>
								<td class="pe-0 text-end">
									<span class="text-gray-800 fw-bold fs-6 me-1" id="lowestData1"></span>
								</td>
								<td class="pe-0 text-end">
									<span class="fw-bold fs-6 text-danger" id="de1"></span>
								</td>
							</tr>
						</tbody>
						<!--end::Table body-->
					</table>
					<!--end::Table-->
				</div>
				<!--end::Table container-->
			</div>
			<!--end::Tap pane-->
			<!--begin::Tap pane-->
			<div class="tab-pane fade" id="kt_charts_widget_35_tab_content_2">
				<!--begin::Chart-->
				<div id="kt_charts_widget_35_chart_2" data-kt-chart-color="primary" class="min-h-auto h-200px ps-3 pe-6"></div>
				<!--end::Chart-->
				<!--begin::Table container-->
				<div class="table-responsive mx-9 mt-n6">
					<!--begin::Table-->
					<table class="table align-middle gs-0 gy-4">
						<!--begin::Table head-->
						<thead>
							<tr>
								<th class="min-w-100px"></th>
								<th class="min-w-100px text-end pe-0"></th>
								<th class="text-end min-w-50px"></th>
							</tr>
						</thead>
						<!--end::Table head-->
						<!--begin::Table body-->
						<tbody>
							<tr>
								<td>
									<a href="#" class="text-gray-600 fw-bold fs-6" id="biggestLabel2"></a>
								</td>
								<td class="pe-0 text-end">
									<span class="text-gray-800 fw-bold fs-6 me-1" id="biggestData2"></span>
								</td>
								<td class="pe-0 text-end">
									<span class="fw-bold fs-6 text-success" id="in2"></span>
								</td>
							</tr>
							<tr>
								<td>
									<a href="#" class="text-gray-600 fw-bold fs-6" id="lowestLabel2"></a>
								</td>
								<td class="pe-0 text-end">
									<span class="text-gray-800 fw-bold fs-6 me-1" id="lowestData2"></span>
								</td>
								<td class="pe-0 text-end">
									<span class="fw-bold fs-6 text-danger" id="de2"></span>
								</td>
							</tr>
						</tbody>
						<!--end::Table body-->
					</table>
					<!--end::Table-->
				</div>
				<!--end::Table container-->
			</div>
			<!--end::Tap pane-->
			<!--begin::Tap pane-->
			<div class="tab-pane fade" id="kt_charts_widget_35_tab_content_3">
				<!--begin::Chart-->
				<div id="kt_charts_widget_35_chart_3" data-kt-chart-color="primary" class="min-h-auto h-200px ps-3 pe-6"></div>
				<!--end::Chart-->
				<!--begin::Table container-->
				<div class="table-responsive mx-9 mt-n6">
					<!--begin::Table-->
					<table class="table align-middle gs-0 gy-4">
						<!--begin::Table head-->
						<thead>
							<tr>
								<th class="min-w-100px"></th>
								<th class="min-w-100px text-end pe-0"></th>
								<th class="text-end min-w-50px"></th>
							</tr>
						</thead>
						<!--end::Table head-->
						<!--begin::Table body-->
						<tbody>
							<tr>
								<td>
									<a href="#" class="text-gray-600 fw-bold fs-6" id="biggestLabel3"></a>
								</td>
								<td class="pe-0 text-end">
									<span class="text-gray-800 fw-bold fs-6 me-1" id="biggestData3"></span>
								</td>
								<td class="pe-0 text-end">
									<span class="fw-bold fs-6 text-success" id="in3"></span>
								</td>
							</tr>
							<tr>
								<td>
									<a href="#" class="text-gray-600 fw-bold fs-6" id="lowestLabel3"></a>
								</td>
								<td class="pe-0 text-end">
									<span class="text-gray-800 fw-bold fs-6 me-1" id="lowestData3"></span>
								</td>
								<td class="pe-0 text-end">
									<span class="fw-bold fs-6 text-danger" id="de3"></span>
								</td>
							</tr>
						</tbody>
						<!--end::Table body-->
					</table>
					<!--end::Table-->
				</div>
				<!--end::Table container-->
			</div>
			<!--end::Tap pane-->
			<!--begin::Tap pane-->
			<div class="tab-pane fade" id="kt_charts_widget_35_tab_content_4">
				<!--begin::Chart-->
				<div id="kt_charts_widget_35_chart_4" data-kt-chart-color="primary" class="min-h-auto h-200px ps-3 pe-6"></div>
				<!--end::Chart-->
				<!--begin::Table container-->
				<div class="table-responsive mx-9 mt-n6">
					<!--begin::Table-->
					<table class="table align-middle gs-0 gy-4">
						<!--begin::Table head-->
						<thead>
							<tr>
								<th class="min-w-100px"></th>
								<th class="min-w-100px text-end pe-0"></th>
								<th class="text-end min-w-50px"></th>
							</tr>
						</thead>
						<!--end::Table head-->
						<!--begin::Table body-->
						<tbody>
							<tr>
								<td>
									<a href="#" class="text-gray-600 fw-bold fs-6" id="biggestLabel4"></a>
								</td>
								<td class="pe-0 text-end">
									<span class="text-gray-800 fw-bold fs-6 me-1" id="biggestData4"></span>
								</td>
								<td class="pe-0 text-end">
									<span class="fw-bold fs-6 text-success" id="in4"></span>
								</td>
							</tr>
							<tr>
								<td>
									<a href="#" class="text-gray-600 fw-bold fs-6" id="lowestLabel4"></a>
								</td>
								<td class="pe-0 text-end">
									<span class="text-gray-800 fw-bold fs-6 me-1" id="lowestData4"></span>
								</td>
								<td class="pe-0 text-end">
									<span class="fw-bold fs-6 text-danger" id="de4"></span>
								</td>
							</tr>
						</tbody>
						<!--end::Table body-->
					</table>
					<!--end::Table-->
				</div>
				<!--end::Table container-->
			</div>
			<!--end::Tap pane-->
		</div>
		<!--end::Tab Content-->
	</div>
	<!--end::Body-->
</div>
<!--end::Chart Widget 35-->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script>
var valueElem = document.getElementById("value-placeholder");
var value = 0;

let increase1 = document.getElementById("in1");
let decrease1 = document.getElementById("de1");
increase1.innerHTML = 0 - valueElem.textContent;
decrease1.innerHTML = 0  - valueElem.textContent;

// Check if chart_d is defined and has data
if (typeof chart_d !== "undefined" && chart_d.length > 0) {
  value = calculateAverage(chart_d);
  console.log(value);
} else {
  console.log("chart_d is empty or undefined");
}

valueElem.textContent = value.toLocaleString();

function updateValue(type) {
    // Use the 'type' parameter to determine the updated value
    var value = 0;
    if (type === 0) {
        value = calculateAverage(chart_d).average;
    } else if (type === 1) {
        value = calculateAverage(chart_w).average;
    } else if (type === 2) {
        value = calculateAverage(chart_m).average;
    } else if (type === 3) {
        value = calculateAverage(chart_y).average;
    }

    // Format the value to have a comma as the thousands separator
    var formattedValue = value.toLocaleString();

    // Update the value in the HTML element
    valueElem.textContent = formattedValue;

	let increase1 = document.getElementById("in1");
	let decrease1 = document.getElementById("de1");
	increase1.innerHTML = biggestData[type] - valueElem.textContent;
	decrease1.innerHTML = lowestData[type] - valueElem.textContent;

	let increase2 = document.getElementById("in2");
	let decrease2 = document.getElementById("de2");
	increase2.innerHTML = biggestData[type] - valueElem.textContent;
	decrease2.innerHTML = lowestData[type] - valueElem.textContent;

	let increase3 = document.getElementById("in3");
	let decrease3 = document.getElementById("de3");
	increase3.innerHTML = (biggestData[type] - valueElem.textContent).toFixed(2);
	decrease3.innerHTML = (lowestData[type] - valueElem.textContent).toFixed(2);

	let increase4 = document.getElementById("in4");
	let decrease4 = document.getElementById("de4");
	increase4.innerHTML = (biggestData[type] - valueElem.textContent).toFixed(2);
	decrease4.innerHTML = (lowestData[type] - valueElem.textContent).toFixed(2);
}

function calculateAverage(data) {
    if (data.length === 0) {
        return {
            average: 0,
            highest: null,
            lowest: null,
            highestDate: null,
            lowestDate: null
        };
    }

    var sum = 0;
    var highest = data[0].item_total;
    var lowest = data[0].item_total;
    var highestDate = data[0].order_date;
    var lowestDate = data[0].order_date;

    for (var i = 0; i < data.length; i++) {
        var itemTotal = data[i].item_total;
        var orderDate = data[i].order_date;
        sum += itemTotal;

        if (itemTotal > highest) {
            highest = itemTotal;
            highestDate = orderDate;
        }

        if (itemTotal < lowest) {
            lowest = itemTotal;
            lowestDate = orderDate;
        }
    }

    return {
        average: sum / data.length,
        highest: highest,
        lowest: lowest,
        highestDate: highestDate,
        lowestDate: lowestDate
    };
}

</script>
