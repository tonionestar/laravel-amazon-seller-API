<x-default-layout>

    @section('title')
        Users
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('user-management.users.index') }}
    @endsection

    @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    {!! getIcon('magnifier', 'fs-3 position-absolute ms-5') !!}
                    <input type="text" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Search user" id="mySearchInput"/>
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card title-->

            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                    <!--begin::Add user-->
                    <a type="button" class="btn btn-primary" 
                    {{-- onclick="openAddModal()"  --}}
                    data-bs-toggle="modal" data-bs-target="#kt_modal_add_user" data-kt-action="add_row" onclick="openAddModal()" id="addButton">
                        {!! getIcon('plus', 'fs-2', '', 'i') !!}
                        Add User
                    </a>
                    <!--end::Add user-->
                </div>
                <!--end::Toolbar-->

                <!--begin::Modal-->
                <livewire:user.add-user-modal></livewire:user.add-user-modal>
                <!--end::Modal-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body py-4">
            <!--begin::Table-->
            <div class="table-responsive">
                {{-- {{ $dataTable->table() }} --}}
                <table class="table table-row-dashed align-middle gs-0 gy-3 my-0">
                            <!--begin::Table head-->
                            <thead>
                                <tr class="fs-6 fw-bold text-gray-500 border-bottom-0">
                                    <th class="p-0 pb-3 min-w-200px text-center">CLIENT NAME</th>
                                    <th class="p-0 pb-3 min-w-200px text-center">EMAIL</th>
                                    <th class="p-0 pb-3 min-w-150px text-center">PHONE NUMBER</th>
                                    <th class="p-0 pb-3 min-w-150px text-center">ROLE</th>
                                    <th class="p-0 pb-3 min-w-150px text-center">LAST LOGIN</th>
                                    <th class="p-0 pb-3 min-w-150px text-center">JOINED DATE</th>
                                    <th class="p-0 pb-3 min-w-150px text-center">ACTION</th>
                                </tr>
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td class="d-flex justify-content-start flex-column text-center">
                                            <span class="text-gray-600 fw-bold fs-6">{{ $user->full_name }}</span>
                                        </td>
                                        <td class="text-center pe-0">
                                            <span class="text-gray-600 fw-bold fs-6">
                                                {{ $user->email }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-start flex-column text-center">
                                                <div class="text-gray-600 fw-bold fs-6">{{ $user->phone_number }}</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-start flex-column text-center">
                                                <div class="text-gray-600 fw-bold fs-6">{{ $user->role }}</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-center pe-0">
                                                <div class="badge badge-light-success fs-base">
                                                    {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : $user->updated_at->diffForHumans() }}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-start flex-column text-center">
                                                <div class="text-gray-600 fw-bold fs-6">{{ $user->created_at }}</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-center pe-0">
                                                <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                    Actions
                                                    <i class="ki-duotone ki-down fs-5 ms-1"></i>
                                                </a>
                                                <!--begin::Menu-->
                                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="{{ route('dashboard.client', ['id' => $user]) }}" class="menu-link px-3">
                                                            View
                                                        </a>
                                                    </div>
                                                    <!--end::Menu item-->

                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        {{-- <a href="#" class="menu-link px-3" data-kt-user-id="{{ $user->id }}" data-bs-toggle="modal" data-bs-target="#kt_modal_edit_user" data-kt-action="update_row">
                                                            Edit
                                                        </a> --}}
                                                        <a href="javascript:void(0)" class="menu-link px-3" data-kt-user-id="{{ $user->id }}" onclick="openEditModal()" id="editButton" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user" data-kt-action="update_row">Edit</a>
                                                    </div>
                                                    <!--end::Menu item-->

                                                    {{-- <!--begin::Menu item-->
                                                    <form action="{{ route('user-management.users.destroy', $user) }}" method="POST" id="deleteForm_{{ $user->id }}" style="display: none">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <div class="menu-item px-3">
                                                        <a href="javascript:void(0)" class="menu-link px-3" onclick="document.getElementById('deleteForm_{{ $user->id }}').submit()">
                                                            Delete
                                                        </a>
                                                    </div>
                                                    <!--end::Menu item--> --}}
                                                </div>
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
        <!--end::Card body-->
    </div>

</x-default-layout>

<script>
var modalStatus = '';
function openAddModal() {
    modalStatus = 'add_row';
}

function openEditModal() {
   modalStatus = 'edit_row';
}

function updateUser() {
    var modal = $('#kt_modal_add_user');
    var firstName =  modal.find('#firstname').val();
    var lastName = modal.find('#lastname').val();
    var email = modal.find('#email').val();
    var phonenumber = modal.find('#phonenumber').val();
    var address1 = modal.find('#address1').val();
    var city = modal.find('#city').val();
    var state = modal.find('#state').val();
    var zipcode = modal.find('#zipcode').val();
    var password = modal.find('#password').val();
    var position = modal.find('#position').val();
    var role = modal.find('#role').val();

    var full_name = `${firstname} ${lastname}`;
    var address = `${address1} ${city} ${state} ${zipcode}`;

    fetch(`/user-management/updateUser/${editUserId}`,{
        method: "PUT",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content"),
        },
        body: JSON.stringify({
            firstName: firstName,
            lastName: lastName,
            email: email, 
            phoneNumber: phoneNumber,
            address: address,
            password: password
        }),
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.status);
        }
        return response.json();
    })
    .then(data => {
      console.log('User data updated.', data);
    })
    .catch((error) => {
      console.error('Error:', error);
    });
}
$('.editButton').on('click', function() {
    openModal(true, $(this).data('kt-user-id'));
});

$('.addButton').on('click', function() {
    openModal(false);
});

// When form is submitted
$('#kt_modal_add_user form').on('submit', function(e) {
    updateUser(e);
});

$('#kt_modal_add_user').on('show.bs.modal', async function (event) {
    // var button = $(event.relatedTarget); // Button that triggered the modal
    var button = $(event.relatedTarget); // Button that triggered the modal
    var action = button.data('kt-action');
    var modal = $('#kt_modal_add_user');
        modal.find('#modal-title').text('Add User');
        modal.find('#firstname').val('');
        modal.find('#lastname').val('');
        modal.find('#email').val('');
        modal.find('#phonenumber').val('');
        modal.find('#address1').val('');
        modal.find('#city').val('');
        modal.find('#state').val('');
        modal.find('#zipcode').val('');
        modal.find('#position').val('');
        modal.find('#role').val('');
    
    // var action = button.data('kt-action'); // Extract info from data-* attributes

    if(action === 'update_row') {
        var userId = button.data('kt-user-id')
        
        var response = await fetch(`/user-management/getusers/${userId}`,{
            method: "GET", // or 'POST', 'PUT', etc.
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            },
        })
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.status);
        }
        let data = await response.json();
        var modal = $('#kt_modal_add_user');
        var fullName = data.full_name;
        var names = fullName.split(' '); 
        var firstName = names[0];
        var lastName = names.slice(1).join(' '); 
        var address = data.address;
        var addressParts = address.split(' ');
        var position = data.position;
        var role = data.role;

        var zipcode = addressParts.pop();
        var state = addressParts.pop();
        var city = addressParts.pop();
        var address1 = addressParts.join(' ');

        modal.find('#modal-title').text('Edit User');
        modal.find('#firstname').val(firstName);
        modal.find('#lastname').val(lastName);
        modal.find('#email').val(data.email);
        modal.find('#phonenumber').val(data.phone_number);
        modal.find('#address1').val(address1);
        modal.find('#city').val(city);
        modal.find('#state').val(state);
        modal.find('#zipcode').val(zipcode);
        modal.find('#position').val(position);
        modal.find('#role').val(role);
        // $("#kt_modal_add_user_form").attr("action", "");
        $("#kt_modal_add_user_form").attr("method", "POST");
        $("#kt_modal_add_user_form").attr("action", "/user-management/updateUser/" + userId);
    }
});

// }
</script>