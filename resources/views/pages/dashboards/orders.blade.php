@php
    use App\Models\User;

    $user = User::findOrFail(auth()->id());
    $fullName = $user->full_name;
    $firstName = explode(" ", $fullName)[0];

@endphp

<x-default-layout>

    @section('title')
        Welcome {{ $firstName }}
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
            @include('partials/widgets/tables/_widget-14')
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->
</x-default-layout>
