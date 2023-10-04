<x-default-layout>

    @section('title')
    Client
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('dashboard') }}
    @endsection

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
</x-default-layout>