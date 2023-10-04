<x-default-layout>

    @section('title')
        Orders
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('dashboard') }}
    @endsection

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
            @include('partials/widgets/tables/_widget-14')
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->
</x-default-layout>
