<x-default-layout>
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
                                    <th class="p-0 pb-3 min-w-200px text-center">CLIENT NAME</th>
                                    <th class="p-0 pb-3 min-w-200px text-center">TOTAL PROFIT</th>
                                </tr>
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody>
                                @foreach ($profitList as $profit)
                                    <tr>
                                        <td class="text-center pe-0">
                                            <!--begin::Label-->
                                            <span class="text-gray-600 fw-bold fs-6">{{ $profit->month }}</span>
                                            <!--end::Label-->
                                        </td>
                                        <td class="text-center pe-0">
                                            <!--begin::Label-->
                                            <span class="text-gray-600 fw-bold fs-6">{{ $profit->client_name }}</span>
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
</x-default-layout>
