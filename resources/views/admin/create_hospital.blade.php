<x-base>
    <x-slot name="title">{{ $title }}</x-slot>

    <div class="container-fluid mt-5">
        <h1>Create Hospital</h1>
        
        <form id="create-hospital-form">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="#">Hospital Name</label>
                        <input type="text" name="hospital_name" id="hospital_name" class="form-control" placeholder="Enter Hospital Name" value="{{ old('hospital_name') }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="#">Hospital Email</label>
                        <input type="email" name="hospital_email" id="hospital_email" class="form-control" placeholder="Enter Email" value="{{ old('hospital_email') }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="#">Hospital Phone Number </label>
                        <input type="number" name="hospital_phone" id="hospital_phone" class="form-control" placeholder="Enter Contact Person" value="{{ old('hospital_phone') }}" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="address">Hospital Address</label>
                        <input type="text" name="hospital_Address" id="hospital_Address" class="form-control" placeholder="Enter Address" value="{{ old('hospital_Address') }}" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="#">Hospital Username</label>
                        <input type="text" name="hospital_username" id="hospital_username" class="form-control" placeholder="Enter Hospital's Username" value="{{ old('hospital_username') }}" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="#">Hospital Password</label>
                        <input type="password" name="hospital_password" id="hospital_password" class="form-control" placeholder="Enter Hospital's Password" value="{{ old('hospital_password') }}" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="address"> Hospital Region (optional) </label>
                        <input type="text" name="hospital_region" id="hospital_region" class="form-control" placeholder="Enter Hospitals Region" value="{{ old('hospital_region') }}" required>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="address"> Hospital Website (optional) </label>
                        <input type="text" name="hospital_web" id="hospital_web" class="form-control" placeholder="Enter Hospital's Website" value="{{ old('hospital_web') }}" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="#">Hospital Contact Person (optional) </label>
                        <input type="number" name="contact_person" id="contact_person" class="form-control" placeholder="Enter Contact Person" value="{{ old('contact_person') }}" required>
                    </div>
                </div>


                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary mt-3">Create Hospital</button>
                </div>

            </div>
        </form>
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