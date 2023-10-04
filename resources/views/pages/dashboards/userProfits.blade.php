<x-default-layout>

    @section('title')
    Profits
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('dashboard') }}
    @endsection

        <div>
        <!--begin::Col-->
        <div class="col-xl-12">
            <div class="card card-flush h-md-100">
                <!--begin::Header-->
                <div class="card-header pt-7">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-gray-800">USER PROFITS</span>
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
                        <table class="table table-row-dashed align-middle gs-0 gy-5 my-0">
                            <!--begin::Table head-->
                            <thead>
                                <tr class="fs-6 fw-bold text-gray-500 border-bottom-0">
                                    <th class="p-0 pb-3 min-w-200px text-center">DATE RANGE</th>
                                    <th class="p-0 pb-3 min-w-200px text-center">POSITIONS</th>
                                    <th class="p-0 pb-3 min-w-200px text-center">PROFIT PER POSITION</th>
                                    <th class="p-0 pb-3 min-w-200px text-center">TOTAL PROFIT</th>
                                    <th class="p-0 pb-3 min-w-200px text-center">UPDATED TIME</th>
                                </tr>
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody>
                                @foreach($user_profits as $profit)
                                    <tr>
                                        <td class="text-center pe-0">
                                            {{-- <span class="badge py-3 px-4 fs-6 badge-light-primary">In Process</span> --}}
                                            <span class="text-gray-1000 fw-bold badge-light-primary mb-1 fs-6">
                                                {{ $profit->date_range }}
                                            </span>
                                        </td>
                                        <td class="text-center pe-0">
                                            <span class="badge badge-light-success fs-base">{{ $profit->position }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-start flex-column text-center">
                                                <div class="text-gray-600 fw-bold fs-6">{{ $profit->profit_per_position }}</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-start flex-column text-center">
                                                <div class="text-gray-600 fw-bold fs-6">{{ $profit->total_profit }}</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-start flex-column text-center">
                                                <div class="text-gray-600 fw-bold fs-6">{{ $profit->updated_at }}</div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <!--end::Table body-->
                        </table>
                    </div>
                </div>
                <!--end: Card Body-->
            </div>
            <!--end::Table widget 14-->
                    <div class="d-flex justify-content-center mt-3">
                        <ul class="pagination">
                            <!-- Previous Page Link -->
                            @if ($user_profits->onFirstPage())
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">&laquo;</a>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $user_profits->previousPageUrl() }}" tabindex="-1" aria-disabled="false">&laquo;</a>
                                </li>
                            @endif
                    
                            <!-- Pagination links -->
                            @for ($page = 1; $page <= $user_profits->lastPage(); $page++)
                                @if ($page == $user_profits->currentPage())
                                    <li class="page-item active">
                                        <a class="page-link" href="#">{{ $page }}</a>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $user_profits->url($page) }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endfor
                    
                            <!-- Next Page Link -->
                            @if ($user_profits->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $user_profits->nextPageUrl() }}">&raquo;</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">&raquo;</a>
                                </li>
                            @endif
                        </ul>
                    </div>

        </div>
        <!--end::Col-->
    </div>
</x-default-layout>