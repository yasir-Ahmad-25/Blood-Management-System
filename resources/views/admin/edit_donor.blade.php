<x-base>
    <x-slot name="title">{{ $title }}</x-slot>

    <div class="container-fluid mt-5">
        <h1>Update Donor</h1>
        
        <form id="update-donor-form">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="#">Fullname</label>
                        <input type="text" name="fullname" id="fullname" class="form-control" placeholder="Enter Fullname" value="{{ $donor->fullname ?? old('fullname') }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="#">Email</label>
                        <input type="email" name="Email" id="Email" class="form-control" placeholder="Enter Email" value="{{ $donor->email ?? old('Email') }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="#">Phone</label>
                        <input type="number" name="phone" id="phone" class="form-control" placeholder="Enter Phone Number"value="{{ $donor->phone ?? old('phone') }}"  required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="#">Sex</label>
                        <select name="sex" id="sex" class="form-control">
                            <option value="#" disabled {{ empty($donor->sex) ? 'selected' : ''}}> Select Donor Sex </option>
                            <option value="Male" {{ $donor->sex == 'Male' ? 'selected' : ''}}>Male</option>
                            <option value="Female" {{ $donor->sex == 'Female' ? 'selected' : ''}}>Female</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="#">Date Of Birth</label>
                        <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" placeholder="Enter Date of Birth" value="{{ $donor->date_of_birth ?? old('date_of_birth') }}" required>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="#">Blood Type</label>
                        <select name="blood_type" id="blood_type" class="form-control">
                            <option value="#" disabled {{ empty($donor->blood_type) ? 'selected' : '' }}> Select Blood Type </option>
                            <option value="A+" {{ $donor->blood_type == 'A+' ? 'selected' : '' }}>A+</option>
                            <option value="A-" {{ $donor->blood_type == 'A-' ? 'selected' : '' }}>A-</option>
                            <option value="B+" {{ $donor->blood_type == 'B+' ? 'selected' : '' }}>B+</option>
                            <option value="B-" {{ $donor->blood_type == 'B-' ? 'selected' : '' }}>B-</option>
                            <option value="AB+" {{ $donor->blood_type == 'AB+' ? 'selected' : '' }}>AB+</option>
                            <option value="AB-" {{ $donor->blood_type == 'AB-' ? 'selected' : '' }}>AB-</option>
                            <option value="O+" {{ $donor->blood_type == 'O+' ? 'selected' : '' }}>O+</option>
                            <option value="O-" {{ $donor->blood_type == 'O-' ? 'selected' : '' }}>O-</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="#">Address</label>
                        <input type="text" name="address" id="address" class="form-control" placeholder="Enter Address" value="{{ $donor->address ?? old('address') }}" required>
                    </div>
                </div>

                <div class="col-md-12">
                    <button type="submit" class="btn btn-warning">Update Donor</button>
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

        $('#update-donor-form').on('submit', function(e){
            e.preventDefault(); // Prevent the default form submission
            
            // Collect form data
            var formData = $(this).serialize();

            // Send an AJAX POST request
            $.ajax({
                url: '{{ route('admin.update_donor',$donor->id)}}', // Adjust the URL to your route
                type: 'POST',
                data: formData,
                success: function(response) {
                    if(response.status === true) {
                        // Handle success response
                        $('#update-donor-form')[0].reset();
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: response.message || "Donor Updated successfully!",
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = "{{ route('admin.donors') }}"; 
                        });
                    } else {
                        Swal.fire({
                            position: "top-end",
                            icon: "error",
                            title: response.message || "Failed to Update donor.",
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
                        $('#update-donor-form').before(errorHtml);
                    } else {
                        alert('Error creating donor: ' + xhr.responseText);
                    }
                }
            });
        })
    });
    
</script>



</x-base>