@php
    $currentMonthOverallProfits = round(App\Models\Order::whereMonth('order_date', now()->month)->sum('profit'), 2);
@endphp

<div class="card card-theme h-md-50 mb-5 mb-xl-10" style="background-color: #50CD89;background-image:url('assets/media/patterns/vector-1.png')">
  <!--begin::Content-->
  <div class="card-body d-flex flex-column align-items-center">
    <!--begin::Info-->
    <div class="d-flex align-items-center">
      <!--begin::Currency-->
      <span class="fs-4 fw-semibold text-theme-accent me-1">$</span>
      <!--end::Currency-->
      <!--begin::Amount-->
      <span class="fs-2hx fw-bold text-theme-primary me-2 lh-1 ls-n2">{{ $currentMonthOverallProfits }}</span>
      <!--end::Amount-->
    </div>
    <!--end::Info-->
    <!--begin::Subtitle-->
    <span class="text-theme-secondary pt-1 fw-semibold fs-6">Total Overall Profits</span>
    <!--end::Subtitle-->
  </div>
  <!--end::Content-->
</div>
