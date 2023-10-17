<x-default-layout>


    @section('title')
        Add Post
    @endsection

    @section('breadcrumbs')
        {{-- {{ Breadcrumbs::render('dashboard') }} --}}
    @endsection

    <div>
        <!--begin::Col-->
        <div class="col-xl-6">
            <form action="{{ route('dashboard.addPost') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-8">
                    <label for="headline" class="mb-2 required form-label">Headline</label>
                    <input type="text" id="headline" name="headline" autocomplete="off" class="form-control bg-transparent" required />
                </div>

                <div class="mb-8">
                    <label for="content" class="mb-2 required form-label">Content</label>
                    <textarea id="content" name="content" rows="4" class="form-control bg-transparent" required></textarea>
                </div>

                <div class="mb-8">
                    <label for="category" class="mb-2 required form-label">Category</label>
                    <input type="text" id="category" name="category" autocomplete="off" class="form-control bg-transparent" required />
                </div>

                <div class="mb-8">
                    <label for="image" class="mb-2 required form-label">Image</label>
                    <input type="file" id="image" name="image" class="form-control" accept="image/*" required />
                </div>

                <div class="mb-8">
                    <img id="image-preview" src="#" alt="Image Preview" style="display: none; max-width: 300px; max-height: 300px;" />
                </div>

                <div class="d-grid mb-10">
                    <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                        @include('partials/general/_button-indicator', ['label' => 'Add Post'])
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

        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('image-preview');

        imageInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                imagePreview.style.display = 'block';
                const reader = new FileReader();
                reader.addEventListener('load', function () {
                    imagePreview.src = this.result;
                });
                reader.readAsDataURL(file);
            } else {
                imagePreview.style.display = 'none';
                imagePreview.src = '#';
            }
        });
        </script>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" id="success-alert" role="alert" style="position: fixed; top: 20px; right: 20px; min-width: 30%; z-index: 9999;">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>      
    @endif
</x-default-layout>
