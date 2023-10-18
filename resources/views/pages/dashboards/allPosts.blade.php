@php
    use App\Models\User;

    $user = User::findOrFail(auth()->id());
    $fullName = $user->full_name;
    $firstName = explode(" ", $fullName)[0];

@endphp

<x-default-layout>


    @section('title')
        News And Updates
    @endsection

    @section('breadcrumbs')
        {{-- {{ Breadcrumbs::render('dashboard') }} --}}
    @endsection

    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}" />

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

    @if(auth()->user()->role === 'Admin')
    <div>
        <a href="{{ route('dashboard.addPost') }}" class="btn btn-lg mb-5 w-100" style="background-color: white; color: black; border: 1px solid black;">
            Add New Post
        </a>
    </div>
    @endif

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

                        <div class="d-flex justify-content-between align-items-center">
                            <!-- Edit Button -->
                            <a href="{{ route('dashboard.editPost', ['id' => $post->id]) }}" class="btn btn-primary btn-sm mt-3">Edit</a>

                            <!-- Delete Button -->
                            <form action="{{ route('dashboard.deletePost', ['id' => $post->id]) }}" method="post" class="mt-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <!--end::Col-->
    </div>

</x-default-layout>
