@php
  // Get the second-to-last value from the array
  $positions = $profitList[0]->position;
@endphp
<div class="card card-theme h-md-50 mb-5 mb-xl-10" style="background-color: #d63384;background-image:url('assets/media/patterns/vector-1.png')">
  <!--begin::Content-->
  <div class="card-body d-flex flex-column align-items-center">
    <!--begin::Info-->
    <div class="d-flex align-items-center">
      <!--begin::Currency-->
      <span class="fs-4 fw-semibold text-theme-accent me-1"></span>
      <!--end::Currency-->
      <!--begin::Amount-->
      <span class="fs-2hx fw-bold text-theme-primary me-2 lh-1 ls-n2">{{ $positions }}</span>
      <!--end::Amount-->
    </div>
    <!--end::Info-->
    <!--begin::Subtitle-->
    <span class="text-theme-secondary pt-1 fw-semibold fs-6">Number of Positions</span>
    <!--end::Subtitle-->
  </div>
  <!--end::Content-->
</div>
