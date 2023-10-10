<div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <form class="form" method="POST" action="{{ route('user-management.users.store') }}" id="kt_modal_add_user_form">
                @csrf
                <div class="modal-header" id="kt_modal_update_user_header">
                    <h2 class="fw-bold" id="modal-title">Add User</h2>
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                        {!! getIcon('cross','fs-1') !!}
                    </div>
                    <!--end::Close-->
                </div>
                <div class="modal-body px-5 my-7">
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#kt_modal_update_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
                        <div class="row g-9 mb-7">
                            <input type="hidden" placeholder="" name="_id" id="_id" required />
                            <div class="col-md-6 fv-row">
                                <label class="fs-6 fw-semibold mb-2">First Name</label>
                                <input class="form-control form-control-solid" placeholder="" name="firstname" id="firstname" required />
                                @error('firstname')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 fv-row">
                                <label class="fs-6 fw-semibold mb-2">Last Name</label>
                                <input class="form-control form-control-solid" placeholder="" name="lastname" id="lastname" required />
                                @error('lastname')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="fv-row mb-7">
                            <label class="fs-6 fw-semibold mb-2">
                                <span>Email</span>
                                <span class="ms-1" data-bs-toggle="tooltip" title="Email address must be active">
                                    <i class="ki-duotone ki-information fs-7">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                </span>
                            </label>
                            <input type="email" class="form-control form-control-solid" placeholder="" name="email" id="email" required />
                            <span id="emailError" class="text-danger"></span>
                        </div>
                        <div class="fv-row mb-7">
                            <label class="fs-6 fw-semibold mb-2">Phone Number</label>
                            <input type="tel" class="form-control form-control-solid @error('phonenumber') is-invalid @enderror" placeholder="333 333 3333" name="phonenumber" id="phonenumber" required />
                            @error('phonenumber')
                                    <div class="alert alert-danger invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="fv-row mb-7">
                            <label class="fs-6 fw-semibold mb-2">Password</label>
                            <input type="password" class="form-control form-control-solid" placeholder="" name="password" id="password" required />
                            @error('password')
                                    <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="fv-row mb-7">
                            <label class="fs-6 fw-semibold mb-2">Confirm Password</label>
                            <input type="password" class="form-control form-control-solid" placeholder="" name="confirmPassword" id="confirmPassword" required />
                            @error('confirmPassword')
                                    <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="fv-row mb-7" style="display: flex; justify-content: center;">
                            <button id="passwordButton" type="button" class="btn btn-primary" style="">Set New Password</button>
                        </div>
                        <div class="d-flex flex-column mb-7 fv-row">
                            <label class="fs-6 fw-semibold mb-2">Address Line 1</label>
                            <input class="form-control form-control-solid" placeholder="" name="address1" id="address1" required />
                            @error('address1')
                                    <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex flex-column mb-7 fv-row">
                            <label class="fs-6 fw-semibold mb-2">Address Line 2</label>
                            <input class="form-control form-control-solid" placeholder="" name="address2" />
                        </div>
                        <div class="d-flex flex-column mb-7 fv-row">
                            <label class="fs-6 fw-semibold mb-2">City</label>
                            <input class="form-control form-control-solid" placeholder="" name="city" id="city" required />
                            @error('city')
                                    <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row g-9 mb-7">
                            <div class="col-md-6 fv-row">
                                <label class="fs-6 fw-semibold mb-2">State / Province</label>
                                <input class="form-control form-control-solid" placeholder="" name="state" id="state" required />
                                @error('state')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 fv-row">
                                <label class="fs-6 fw-semibold mb-2">Zip Code</label>
                                <input class="form-control form-control-solid" placeholder="" name="zipcode" id="zipcode" type="number" required />
                                @error('zipcode')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row g-9 mb-7">
                            <div class="col-md-6 fv-row">
                                <label class="fs-6 fw-semibold mb-2">Number of Positions</label>
                                <select name="position" aria-label="Number of Positions" class="form-select"
                                    data-dropdown-parent="#kt_modal_add_user" id="position" required>
                                    <option value="">-- Select Position --</option>
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select> 
                                @error('position')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 fv-row">
                                <label class="fs-6 fw-semibold mb-2">Role</label>
                                <select name="role" aria-label="Role"  class="form-select" data-dropdown-parent="#kt_modal_add_user" id="role" required>
                                    <option></option>
                                    <option value="Admin">Admin</option>
                                    <option value="Client">Client</option>
                                    <option value="Support">Support</option>
                                </select>
                                @error('role')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <!--begin::Modal footer-->
                <div class="modal-footer flex-center">
                    <!--begin::Button-->
                    <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">Discard</button>
                    <!--end::Button-->
                    <!--begin::Button-->
                    <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                        <span class="indicator-label">Submit</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                    <!--end::Button-->
                </div>
                <!--end::Modal footer-->
            </form>
            <!--end::Form-->
        </div>
    </div>
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
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#kt_modal_add_user_scroll :nth-child(6)').hide();

        $('a#addButton').on('click', () => {
            $('#kt_modal_add_user_scroll :nth-child(4)').show();
            $('#kt_modal_add_user_scroll :nth-child(5)').show();
            $('#kt_modal_add_user_scroll :nth-child(6)').hide();
            $('input[name="password"]').prop('required', true);
            $('input[name="confirmPassword"]').prop('required', true);
        });

        $('a#editButton').on('click', () => {
            if ($('a#editButton').data('kt-action') === 'update_row') {
                $('#kt_modal_add_user_scroll :nth-child(4)').hide();
                $('#kt_modal_add_user_scroll :nth-child(5)').hide();
                $('#kt_modal_add_user_scroll :nth-child(6)').show();
                $('input[name="password"]').prop('required', false);
                $('input[name="confirmPassword"]').prop('required', false);
            } else {
                $('#kt_modal_add_user_scroll :nth-child(4)').show();
                $('#kt_modal_add_user_scroll :nth-child(5)').show();
                $('#kt_modal_add_user_scroll :nth-child(6)').hide();
                $('input[name="password"]').prop('required', true);
                $('input[name="confirmPassword"]').prop('required', true);
            }

            $('#passwordButton').click(function() {
                $('#kt_modal_add_user_scroll :nth-child(4)').show();
                $('#kt_modal_add_user_scroll :nth-child(5)').show();
                $('#kt_modal_add_user_scroll :nth-child(6)').hide();
                $('input[name="password"]').prop('required', true);
                $('input[name="confirmPassword"]').prop('required', true);
            });

            $('#kt_modal_add_user_scroll').on('hidden.bs.modal', function() {
                $('#passwordButton').show();
                $('#kt_modal_add_user_scroll :nth-child(4)').hide();
                $('#kt_modal_add_user_scroll :nth-child(5)').hide();
                $('input[name="password"]').prop('required', true);
                $('input[name="confirmPassword"]').prop('required', true);
            });
        });
        $('button[type="submit"][data-kt-users-modal-action="submit"]').on('click', function(e) {
            // Check if firstname field is empty
            if($.trim($('input[name="firstname"]').val()) === '') {
                console.log('Firstname validation failed.');
                e.preventDefault(); // prevent the form from submitting
                toastr.error('Please enter your first name'); // show a simple error message
                return;
            }
            // Check if lastname field is empty
            if($.trim($('input[name="lastname"]').val()) === '') {
                e.preventDefault(); 
                toastr.error('Please enter your last name'); 
                return;
            }
            // Check if email field is empty and valid
            if($.trim($('input[name="email"]').val()) === '' || !validateEmail($('input[name="email"]').val())) {
                e.preventDefault();
                toastr.error('Please enter a valid email');
                return;
            }
            // Check if phonenumber field is in correct format
            if(!validatePhoneNumber($('input[name="phonenumber"]').val())) {
                e.preventDefault();
                toastr.error('Please enter a valid phone number in the format 333 333 3333');
                return;
            }
            // // Check if password is needed
            if ($('#kt_modal_add_user_scroll :nth-child(6)').css('display') === 'none') {
                console.log('display none')

                // Check if password field is empty and secure
                if($.trim($('input[name="password"]').val()) === '' || !validatePassword($('input[name="password"]').val())) {
                    e.preventDefault();
                    toastr.error('Please enter a strong password. Passwords must contain at least one number, one lowercase and one uppercase letter, one special symbol and be at least 8 characters long');
                    return;
                }
                // Check if password and password confirmation are matching
                if($('input[name="password"]').val() !== $('input[name="confirmPassword"]').val()) {
                    e.preventDefault();
                    toastr.error('The password confirmation does not match the password');
                    return;
                }
            }
        });
    
        // Function to validate email
        function validateEmail(email) {
            // Regular expression pattern for email validation
            var pattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
            return pattern.test(email); // it will return true if pattern matches
        }
    
        // Function to validate phone number
        function validatePhoneNumber(phone) {
            // Regular expression pattern for phone number validation
            var pattern = /^[0-9]{3} [0-9]{3} [0-9]{4}$/;
            return pattern.test(phone); // it will return true if pattern matches
        }

        $('input[name="phonenumber"]').on('keyup', function() {
            // remove all non-digit characters
            var pureNum = this.value.replace(/\D/g, '');
            // truncate to 10 numbers
            pureNum = pureNum.substring(0, 10);
            // separate the numbers in groups of 3 and 4
            var formattedNum = '';
            for (var i = 0; i < pureNum.length; i++) {
                if (i === 3 || i === 6) formattedNum += ' ';
                formattedNum += pureNum[i];
            }
            // set the value to our formatted string
            this.value = formattedNum;
        });

        // Function to validate password
        function validatePassword(password) {
            // Regular expression pattern for password validation
            // At least one number, one lowercase and one uppercase letter, one special symbol and be at least 8 characters long
            var pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/ ;
            return pattern.test(password); // it will return true if pattern matches
        }

        // Handle toastr options
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",  // Position of Toasts
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "600",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    });

    $(document).ready(function () {
        $('#email').on('blur', function(){
            var email = $(this).val();
            $.ajax({
                url: '/user-management/users/checkEmail',
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    email: email
                }, 
                success: function(response) {
                    if(response == "taken") {
                        $('#emailError').text('The email has already been taken');
                        $('#email').addClass('is-invalid');
                    } else {
                        $('#emailError').text('');
                        $('#email').removeClass('is-invalid');
                    }
                }
            });
        });
    });

    $('#role').change(function(){
        var role_name = $(this).find('option:selected').data('role');
        $('#role_name').val(role_name);
    });

    $('#position').change(function(){
        var position_name = $(this).find('option:selected').data('position');
        $('#position_name').val(position_name);
    });
</script>