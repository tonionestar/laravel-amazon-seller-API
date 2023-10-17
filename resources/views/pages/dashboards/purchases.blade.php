<x-default-layout>

    @section('title')
        Purchases
    @endsection

    @section('breadcrumbs')
        {{-- {{ Breadcrumbs::render('dashboard') }} --}}
    @endsection

    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}" />

    <!--begin::Row-->
    {{-- <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <!--begin::Col-->
        <div class="col-xl-4">
            @include('partials/widgets/charts/_widget-35')
        </div>
        <!--end::Col-->
    </div> --}}

    <div>
        <!--begin::Col-->
        <div class="col-xl-12">
            <div class="card card-flush h-md-100">
                <!--begin::Header-->
                <div class="card-header pt-7">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-gray-800">PURCHASES</span>
                        <span class="text-gray-400 mt-1 fw-semibold fs-6">Updated 37 minutes ago</span>
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
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table table-row-dashed align-middle gs-0 gy-3 my-0">
                            <!--begin::Table head-->
                            <thead>
                                <tr class="fs-6 fw-bold text-gray-500 border-bottom-0">
                                    <th class="p-0 pb-3 min-w-200px text-center">DATE</th>
                                    <th class="p-0 pb-3 min-w-300px text-center">AMAZON LINK</th>
                                    <th class="p-0 pb-3 min-w-150px text-center">ASIN</th>
                                    <th class="p-0 pb-3 min-w-150px text-center">TOTAL UNITS</th>
                                    <th class="p-0 pb-3 min-w-150px text-center">COST PER UNIT</th>
                                    <th class="p-0 pb-3 min-w-150px text-center">ESTIMATED SHIPPING FEE</th>
                                </tr>
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody>
                                @foreach($purchases as $purchase)
                                    <tr>
                                        <td class="text-center pe-0">
                                            <!--begin::Label-->
                                            <span class="text-gray-600 fw-bold fs-6">{{ $purchase->date }}</span>
                                            <!--end::Label-->
                                        </td>
                                        <td class="text-center pe-0">
                                            {{-- <span class="badge py-3 px-4 fs-6 badge-light-primary">In Process</span> --}}
                                            <span class="text-gray-1000 fw-bold badge-light-primary mb-1 fs-6">
                                                {{ $purchase->amazon_link }}
                                            </span>
                                        </td>
                                        <td class="text-center pe-0">
                                            <span class="badge badge-light-success fs-base">{{ $purchase->asin }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-start flex-column text-center">
                                                <div class="text-gray-600 fw-bold fs-6">{{ $purchase->total_purchased_units }}</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-start flex-column text-center">
                                                <div class="text-gray-600 fw-bold fs-6">{{ $purchase->cost_per_unit }}</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-start flex-column text-center">
                                                <div class="text-gray-600 fw-bold fs-6">{{ $purchase->shipping_fee }}</div>
                                            </div>
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
                            @if ($purchases->onFirstPage())
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">&laquo;</a>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $purchases->previousPageUrl() }}" tabindex="-1" aria-disabled="false">&laquo;</a>
                                </li>
                            @endif
                    
                            <!-- Pagination links -->
                            @for ($page = 1; $page <= $purchases->lastPage(); $page++)
                                @if ($page == $purchases->currentPage())
                                    <li class="page-item active">
                                        <a class="page-link" href="#">{{ $page }}</a>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $purchases->url($page) }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endfor
                    
                            <!-- Next Page Link -->
                            @if ($purchases->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $purchases->nextPageUrl() }}">&raquo;</a>
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
</x-default-layout>
