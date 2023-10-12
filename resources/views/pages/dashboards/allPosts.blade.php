<x-default-layout>


    @section('title')
        News And Updates
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('dashboard') }}
    @endsection

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

   <div class="row">
        <!--begin::Col-->
        @foreach($posts as $post)
            <div class="col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <img src="{{ $post->image }}" alt="" class="rounded-3 mb-5 post-image" >
                        <span class="fw-bold text-gray-800 fs-3 fs-xl-1">{{ $post->headline }}</span>
                        <span class="text-gray-400 fw-semibold d-block fs-6 post-content">{{ $post->content }}</span>  
                        <span class="fw-bold d-block fs-6 post-content">{{ $post->category }}</span>  
                    </div>
                </div>
            </div>
        @endforeach
        <!--end::Col-->
    </div>

</x-default-layout>
