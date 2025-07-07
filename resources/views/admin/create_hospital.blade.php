<x-base>
    <x-slot name="title">{{ $title }}</x-slot>

<div class="container-fluid mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="fw-bold mb-3 text-center" style="color:#b91c1c;">
                        <i class="bi bi-hospital"></i> Add New Hospital
                    </h4>
                    @if($errors->any())
                        <div class="alert alert-danger mb-2">
                            {{ implode('', $errors->all(':message ')) }}
                        </div>
                    @endif
                    <form id="create-hospital-form">
                        <div class="mb-3">
                            <label for="name" class="form-label">Hospital Name</label>
                            <input type="text" class="form-control" name="hospital_name" id="hospital_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Hospital Email</label>
                            <input type="email" class="form-control" name="hospital_email" id="hospital_email" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" name="hospital_phone" id="hospital_phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" name="hospital_Address" id="hospital_Address" required>
                        </div>

                        <div class="mb-3">
                                <label for="#">Hospital Username</label>
                                <input type="text" name="hospital_username" id="hospital_username" class="form-control" placeholder="Enter Hospital's Username" value="{{ old('hospital_username') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="#">Hospital Password</label>
                            <input type="password" name="hospital_password" id="hospital_password" class="form-control" placeholder="Enter Hospital's Password" value="{{ old('hospital_password') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="address"> Hospital Region (optional) </label>
                            <input type="text" name="hospital_region" id="hospital_region" class="form-control" placeholder="Enter Hospitals Region" value="{{ old('hospital_region') }}" required>
                        </div>

                        {{-- <div class="mb-3">
                            <label for="website" class="form-label">Website</label>
                            <input type="text" class="form-control" name="website" id="website">
                        </div> --}}
                        
                        <div class="mb-3">
                                <label for="#">Hospital Contact Person (optional) </label>
                                <input type="number" name="contact_person" id="contact_person" class="form-control" placeholder="Enter Contact Person" value="{{ old('contact_person') }}" required>
                        </div>


                        <button type="submit" class="btn btn-danger w-100 fw-bold mt-2">
                            <i class="bi bi-check2-circle"></i> Save Hospital
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#create-hospital-form').on('submit', function(e){
            e.preventDefault(); // Prevent the default form submission
            
            // Collect form data
            var formData = $(this).serialize();

            // Send an AJAX POST request
            $.ajax({
                url: '{{ route('admin.record_hospital')}}', // Adjust the URL to your route
                type: 'POST',
                data: formData,
                success: function(response) {
                    if(response.status === true) {
                        // Handle success response
                        $('#create-hospital-form')[0].reset();
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: response.message || "Hospital created successfully!",
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = "{{ route('admin.hospitals') }}"; 
                        });
                    } else {
                        Swal.fire({
                            position: "top-end",
                            icon: "error",
                            title: response.message || "Failed to create Hospital.",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                },
               error: function(xhr) {
                    // Remove any previous errors
                    $('.alert-danger').remove();

                    if (xhr.status === 422) {
                        // Validation error
                        var errors = xhr.responseJSON.errors;
                        var errorHtml = '<div class="alert alert-danger"><ul style="list-style-type: none;">';
                        $.each(errors, function(key, value) {
                            errorHtml += '<li><i class="bi bi-x-circle-fill"></i> ' + value[0] + '</li>';
                        });
                        errorHtml += '</ul></div>';
                        // Insert the error messages above the form
                        $('#create-hospital-form').before(errorHtml);
                    } else {
                        alert('Error creating donor: ' + xhr.responseText);
                    }
                }
            });
        })
    });
    
</script>



</x-base>