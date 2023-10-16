@php
    use App\Models\Order;
    use App\Models\User;
    use App\Models\ShippingFee;

    $numberOfClients = User::where('role', 'Client')->count();
    $totalPositions = User::where('role', 'Client')->sum('position');
    $totalSales = Order::count();
    $totalCog = Order::sum('cost_per_unit');
    $totalAmazonFee = Order::sum('amazon_fee');
    $totalWarehouseFee = Order::sum('warehouse_fee');
    $totalShippingFee = Order::sum('shipping_fee');
    $actualShippingFee = ShippingFee::sum('shipping_fee');
    $shippingDifference = $totalShippingFee - $actualShippingFee;
    $totalProfits = Order::sum('profit') + $shippingDifference;
    $actualProfitPerPosition = round($totalProfits / $totalPositions, 2);

    $productFundTotal = round( $totalProfits * 0.2, 2);
    $companyFee = round( $totalProfits * 0.1, 2);

    $clients = User::where('role', 'Client')->get();
    
@endphp

<x-default-layout>


    @section('title')
        Monthly Reports
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('dashboard') }}
    @endsection

    <div>
        <div class="row">
            <form action="{{ route('dashboard.monthlyReports.post') }}" method="post">
                @csrf
                <div class="col-xl-4 mb-3">
                    <label class="mb-2 required form-label">Select Month and Year</label>
                    <input type="month" placeholder="01/2000" name="month_year" autocomplete="off" class="form-control bg-transparent" value="" id="month_year" required/>
                </div>

                <div class="col-xl-4 mb-3">
                    <label class="mb-2 required form-label">Actual Shipping Fees</label>
                    <input type="number" placeholder="105.55" name="shipping_fee" step="0.01" autocomplete="off" class="form-control bg-transparent" value="" required/>
                </div>

                <div class="col-xl-4 mb-3">
                    <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                        @include('partials/general/_button-indicator', ['label' => 'Generate Report'])
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div>
        <!--begin::Col-->
        <div class="col-xl-12">
            <div class="card card-flush h-md-100">
                <!--begin::Header-->
                <div class="card-header pt-7">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-gray-800">Monthly Reports</span>
                    </h3>
                    <!--end::Title-->
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
                                <tr class="fs-5 fw-bold text-gray-500 border-bottom-0">
                                    <th class="p-0 pb-3 min-w-200px text-center">Month/Year Date Generated</th>
                                    <th class="p-0 pb-3 min-w-150px text-center">VIEW REPORT</th>
                                </tr>
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody>
                                @foreach($shipping_fees as $shipping_fee)
                                    <tr>
                                        <td class="text-center pe-0">
                                            {{-- <span class="badge py-3 px-4 fs-6 badge-light-primary">In Process</span> --}}
                                            <span class="text-gray-1000 fw-bold badge-light-primary mb-1 fs-6">
                                                {{ date('F Y M j, Y g:iA', strtotime($shipping_fee->created_at)) }}
                                            </span>
                                        </td>
                                        <td class="text-center pe-0">
                                            <button type="button" class="btn btn-sm btn-success" onclick="createPrintableReport()">View Report</button>
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
                            @if ($shipping_fees->onFirstPage())
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">&laquo;</a>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $shipping_fees->previousPageUrl() }}" tabindex="-1" aria-disabled="false">&laquo;</a>
                                </li>
                            @endif
                    
                            <!-- Pagination links -->
                            @for ($page = 1; $page <= $shipping_fees->lastPage(); $page++)
                                @if ($page == $shipping_fees->currentPage())
                                    <li class="page-item active">
                                        <a class="page-link" href="#">{{ $page }}</a>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $shipping_fees->url($page) }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endfor
                    
                            <!-- Next Page Link -->
                            @if ($shipping_fees->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $shipping_fees->nextPageUrl() }}">&raquo;</a>
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

        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script>
        function createPrintableReport() {
            // Create the printable report content
            const printableReport = `
                <div>
                    <h3>Report For: MONTH YEAR ENTERED ON REPORT GENERATION FORM</h3>
                </div>
                
                <div>
                    <div>
                        <h3 style="display: inline;">Total Number of Clients:</h3> <span style="display: inline;">{{ $numberOfClients }}</span>
                    </div>
                    <div>
                        <h3 style="display: inline;">Total Positions:</h3> <span style="display: inline;">{{ $totalPositions }}</span>
                    </div>
                    <div>
                        <h3 style="display: inline;">Total Sales:</h3> <span style="display: inline;">{{ $totalSales }}</span>
                    </div>
                    <div>
                        <h3 style="display: inline;">Total Cost Of Goods:</h3> <span style="display: inline;">{{ $totalCog }}</span>
                    </div>
                    <div>
                        <h3 style="display: inline;">Total Amazon Fees:</h3> <span style="display: inline;">{{ $totalAmazonFee }}</span>
                    </div>
                    <div>
                        <h3 style="display: inline;">Total Warehouse Fees:</h3> <span style="display: inline;">{{ $totalWarehouseFee }}</span>
                    </div>
                    <div>
                        <h3 style="display: inline;">Total Estimated Shipping Fees:</h3> <span style="display: inline;">{{ $totalShippingFee }}</span>
                    </div>
                    <div>
                        <h3 style="display: inline;">Total Actual Shipping Fees:</h3> <span style="display: inline;">{{ $actualShippingFee }}</span>
                    </div>
                    <div>
                        <h3 style="display: inline;">Shipping Difference:</h3> <span style="display: inline;">{{ $shippingDifference }}</span>
                    </div>
                    <div>
                        <h3 style="display: inline;">Total Profits:</h3> <span style="display: inline;">{{ $totalProfits }}</span>
                    </div>
                    <div>
                        <h3 style="display: inline;">Actual Profit Per Position:</h3> <span style="display: inline;">{{ $actualProfitPerPosition }}</span>
                    </div>
                </div>

                <div style="margin-top: 30px;">
                    <div style="font-style: italic"><h3 style="display: inline;">Payout Breakdown</h3></div>
                    <div>
                        <h3 style="display: inline;">Product Fund Rollover Total:</h3> <span style="display: inline;">{{ $productFundTotal }}</span>
                    </div>
                    <div>
                        <h3 style="display: inline;">Company Fee:</h3> <span style="display: inline;">{{ $companyFee }}</span>
                    </div>
                </div>

                <div style="margin-top: 30px;">
                    <div style="font-style: italic"><h3 style="display: inline;">Client Payout Table</h3></div>
                    <div class="card-body pt-6">
                    <!--begin::Table container-->
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table table-row-dashed align-middle gs-0 gy-3 my-0">
                            <!--begin::Table head-->
                            <thead>
                                <tr class="fs-6 fw-bold text-gray-500 border-bottom-0">
                                    <th style="padding: 0 30px 0 0">Client Name</th>
                                    <th style="padding: 0 30px 0 0">Positions</th>
                                    <th style="padding: 0 30px 0 0">Profit Per Position</th>
                                    <th style="padding: 0 30px 0 0">Total Payout</th>
                                </tr>
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody>
                                @foreach($clients as $client)
                                    @php
                                        $position = $client->position;
                                        $profitPerPosition = round($actualProfitPerPosition / $totalPositions, 2);
                                        $totalPayout = $profitPerPosition * $position;
                                    @endphp
                                    <tr>
                                        <td>
                                            <!--begin::Label-->
                                            <span class="text-gray-600 fw-bold fs-6">{{ $client->full_name }}</span>
                                            <!--end::Label-->
                                        </td>
                                        <td>
                                            <span class="text-gray-600 fw-bold fs-6">{{ $position }}</span>
                                        </td>
                                        <td>
                                            <span class="text-gray-600 fw-bold fs-6">{{ $profitPerPosition }}</span>
                                        </td>
                                        <td>
                                            <span class="text-gray-600 fw-bold fs-6">{{ $totalPayout }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <!--end::Table body-->
                        </table>
                    </div>
                    <!--end::Table-->
                </div>
                

                <!-- Add your desired styling for the printable report -->
                <style>
                    /* Example styles */
                    body {
                        font-family: Arial, sans-serif;
                    }

                    h2 {
                        color: #333;
                    }

                    p {
                        margin-bottom: 15px;
                    }
                </style>
            `;

            // Create a new window or tab with the printable report content
            const printableWindow = window.open('', '_blank');
            printableWindow.document.write(printableReport);
            printableWindow.document.close();
            printableWindow.print();
        }

        $(document).ready(function() {
            $(".alert.alert-danger").delay(5000).slideUp(200, function() {
                $(this).alert('close');
            });

            $(".alert.alert-success").delay(5000).slideUp(200, function() {
                $(this).remove(); 
            });
        });
    </script>


    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" id="success-alert" role="alert" style="position: fixed; top: 20px; right: 20px; min-width: 30%; z-index: 9999;">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>      
    @endif
</x-default-layout>
