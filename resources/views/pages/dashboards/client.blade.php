<x-default-layout>

    @section('title')
    Client
    @endsection

    @section('breadcrumbs')
        {{-- {{ Breadcrumbs::render('dashboard') }} --}}
    @endsection

    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}" />

    <style>
        .post-image {
            width: 100%;
            height: auto;
            object-fit: cover; /* This maintains the aspect ratio and avoids image distortion */
        }

        .post-content {
            margin-top: 10px; /* Adjust the margin value as needed */
        }
    </style>

    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <!--begin::Col-->
        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-4 mb-md-5 mb-xl-10">
            @include('partials/widgets/cards/currentMonthProfit')
            @include('partials/widgets/cards/lastMonthProfit')
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-4 mb-md-5 mb-xl-10">
            @include('partials/widgets/cards/annualProfit')
            @include('partials/widgets/cards/allProfit')
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-4 mb-md-5 mb-xl-10">
            @include('partials/widgets/cards/positions')
            @include('partials/widgets/cards/totalShipped')
        </div>
        <!--end::Col-->
    </div>

    <div>
        <!--begin::Col-->
        <div class="col-xl-12">
            <div class="card card-flush h-md-100">
                <!--begin::Header-->
                <div class="card-header pt-7">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-gray-800">MONTHLY PAYOUTS</span>
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
                                    <th class="p-0 pb-3 min-w-200px text-center">MONTH</th>
                                    <th class="p-0 pb-3 min-w-200px text-center">TOTAL PROFIT</th>
                                </tr>
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody>
                                @foreach($profitList as $profit)
                                    <tr>
                                        <td class="text-center pe-0">
                                            <!--begin::Label-->
                                            <span class="text-gray-600 fw-bold fs-6">{{ $profit->month }}</span>
                                            <!--end::Label-->
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-start flex-column text-center">
                                                <div class="text-gray-600 fw-bold fs-6">{{ $profit->per_user_profit }}</div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <!--end::Table body-->
                        </table>
                    </div>
                    <!--end::Table-->
                </div>
                <!--end: Card Body-->
            </div>
            <!--end::Table widget 14-->

        </div>
        <!--end::Col-->
    </div>

    <div class="row">
        <!--begin::Col-->
        @foreach($posts as $post)
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('dashboard.allPosts') }}">
                            <img src="{{ $post->image }}" alt="" class="rounded-3 mb-5 post-image" >
                            <span class="fw-bold text-gray-800 fs-3 fs-xl-1">{{ $post->headline }}</span>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
        <!--end::Col-->
    </div>

</x-default-layout>
