<x-default-layout>


    @section('title')
        Create New Product
    @endsection

    @section('breadcrumbs')
        {{-- {{ Breadcrumbs::render('dashboard') }} --}}
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
        <div class="col-xl-6">
            <form action="{{ route('dashboard.createProduct.post') }}" method="post">
                @csrf
                <div class="fv-row mb-8">
                    <label class="mb-2 required form-label">Date</label>
                    <input type="datetime-local" placeholder="01/01/2000 00:00" name="date" autocomplete="off" class="form-control bg-transparent" value="" required/>
                </div>

                <div class="fv-row mb-8">
                    <label class="mb-2 required form-label">Amazon Link</label>
                    <input type="text" placeholder="https://www.amazon.com/dp/" name="amazon_link" autocomplete="off" class="form-control bg-transparent" value="" required/>
                    @error('amazon_link')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="fv-row mb-8">
                    <label class="mb-2 required form-label">ASIN</label>
                    <input type="text" placeholder="B0038RBXZS" name="asin" autocomplete="off" class="form-control bg-transparent" value="" required/>
                </div>

                <div class="fv-row mb-8">
                    <label class="mb-2 required form-label">Total Purchased Units</label>
                    <input type="number" placeholder="15" name="total_purchased_units" autocomplete="off" class="form-control bg-transparent" value="" required/>
                </div>

                <div class="fv-row mb-3">
                    <label class="mb-2 required form-label">Cost Per Unit</label>
                    <input type="number" placeholder="10.35" name="cost_per_unit" step="0.01" autocomplete="off" class="form-control bg-transparent" value="" required/>
                </div>

                <div class="fv-row mb-3">
                    <label class="mb-2 required form-label">Estimated Shipping Fee</label>
                    <input type="number" placeholder="5.35" name="shipping_fee" step="0.01" autocomplete="off" class="form-control bg-transparent" value="" required/>
                </div>

                <!--begin::Submit button-->
                <div class="d-grid mb-10">
                    <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                        @include('partials/general/_button-indicator', ['label' => 'Create New Product'])
                    </button>
                </div>
            </form>
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script>
            $(document).ready(function() {
                $(".alert.alert-danger").delay(5000).slideUp(200, function() {
                    $(this).alert('close');
                });

                $(".alert.alert-success").delay(5000).slideUp(200, function() {
                    $(this).remove(); 
                });
            });
        </script>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" id="success-alert" role="alert" style="position: fixed; top: 20px; right: 20px; min-width: 30%; z-index: 9999;">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>      
    @endif
</x-default-layout>
