@php
  $today = date('Y-m-d');
  $year = substr($today, 0, 4);
  $month = substr($today, 5, 2);
  $day = substr($today, 8, 2);
  $current_Month = $year . '-' . $month;

  // Check if the profitList array is not empty

  $currentMonth = $profitList[count($profitList) - 1]->per_user_profit;

  // If the current month is not equal to the last month in the profitList array, set it to 0
  if ($current_Month !== $profitList[count($profitList) - 1]->month) {
      $currentMonth = 0;
  }

@endphp
<div class="card card-theme h-md-50 mb-5 mb-xl-10" style="background-color: #50CD89; background-image: url('/assets/media/patterns/vector-green.png')">
  <!--begin::Content-->
  <div class="card-body d-flex flex-column align-items-center">
    <!--begin::Info-->
    <div class="d-flex align-items-center">
      <!--begin::Currency-->
      <span class="fs-4 fw-semibold text-theme-accent me-1">$</span>
      <!--end::Currency-->
      <!--begin::Amount-->
      <span class="fs-2hx fw-bold text-theme-primary me-2 lh-1 ls-n2">{{ $currentMonth }}</span>
      <!--end::Amount-->
    </div>
    <!--end::Info-->
    <!--begin::Subtitle-->
    <span class="text-theme-secondary pt-1 fw-semibold fs-6">Current Months Profits</span>
    <!--end::Subtitle-->
  </div>
  <!--end::Content-->
</div>
