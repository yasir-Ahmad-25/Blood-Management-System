<x-base>
    <x-slot name="title">{{ $title }}</x-slot>

    {{-- <div class="container-fluid mt-5">
        <h1>Edit Hospital</h1>
        
        <form id="edit-hospital-form">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="hospital_name">Hospital Name</label>
                        <input type="text" name="hospital_name" id="hospital_name" class="form-control" placeholder="Enter Hospital Name" value="{{ $hospital->name ?? old('hospital_name') }}" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="hospital_email">Hospital Email</label>
                        <input type="email" name="hospital_email" id="hospital_email" class="form-control" placeholder="Enter Email" value="{{ $hospital->email ?? old('hospital_email') }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="hospital_phone">Hospital Phone Number</label>
                        <input type="number" name="hospital_phone" id="hospital_phone" class="form-control" placeholder="Enter Contact Person" value="{{ $hospital->phone ?? old('hospital_phone') }}" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="hospital_Address">Hospital Address</label>
                        <input type="text" name="hospital_Address" id="hospital_Address" class="form-control" placeholder="Enter Address" value="{{ $hospital->address ?? old('hospital_Address') }}" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="hospital_username">Hospital Username</label>
                        <input type="text" name="hospital_username" id="hospital_username" class="form-control" placeholder="Enter Hospital's Username" value="{{ $hospital->username ?? old('hospital_username') }}" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="hospital_password">Hospital Password <small>(leave blank to keep current)</small></label>
                        <input type="password" name="hospital_password" id="hospital_password" class="form-control" placeholder="Enter Hospital's Password">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="hospital_region">Hospital Region (optional)</label>
                        <input type="text" name="hospital_region" id="hospital_region" class="form-control" placeholder="Enter Hospitals Region" value="{{ $hospital->region ?? old('hospital_region') }}">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="hospital_web">Hospital Website (optional)</label>
                        <input type="text" name="hospital_web" id="hospital_web" class="form-control" placeholder="Enter Hospital's Website" value="{{ $hospital->website ?? old('hospital_web') }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="contact_person">Hospital Contact Person (optional)</label>
                        <input type="number" name="contact_person" id="contact_person" class="form-control" placeholder="Enter Contact Person" value="{{ $hospital->contact_person ?? old('contact_person') }}">
                    </div>
                </div>

                <div class="col-md-12">
                    <button type="submit" class="btn btn-warning mt-3">Update Hospital</button>
                </div>
            </div>
        </form>
    </div> --}}

    <div class="container-fluid mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="fw-bold mb-3 text-center" style="color:#b91c1c;">
                        <i class="bi bi-pencil-square"></i> Edit Hospital
                    </h4>
                    @if($errors->any())
                        <div class="alert alert-danger mb-2">
                            {{ implode('', $errors->all(':message ')) }}
                        </div>
                    @endif
                    <form id="edit-hospital-form">
                        <div class="mb-3">
                            <label for="name" class="form-label">Hospital Name</label>
                            <input type="text" class="form-control" name="hospital_name" id="hospital_name" value="{{ old('name', $hospital->name) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Hospital Email</label>
                            <input type="email" class="form-control" name="hospital_email" id="hospital_email" value="{{ old('email', $hospital->email) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" name="hospital_phone" id="hospital_phone" value="{{ old('phone', $hospital->phone) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" name="hospital_Address" id="hospital_Address" value="{{ old('address', $hospital->address) }}" required>
                        </div>
                        {{-- <div class="mb-3">
                            <label for="website" class="form-label">Website</label>
                            <input type="text" class="form-control" name="website" id="website" value="{{ old('website', $hospital->website) }}">
                        </div> --}}

                        <div class="mb-3">
                                <label for="#">Hospital Username</label>
                                <input type="text" name="hospital_username" id="hospital_username" class="form-control" placeholder="Enter Hospital's Username" value="{{ old('hospital_username',$hospital->username ) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="#">Hospital Password</label>
                            <input type="password" name="hospital_password" id="hospital_password" class="form-control" placeholder="Enter Hospital's Password" value="{{ old('hospital_password') }}">
                        </div>

                        <div class="mb-3">
                            <label for="address"> Hospital Region (optional) </label>
                            <input type="text" name="hospital_region" id="hospital_region" class="form-control" placeholder="Enter Hospitals Region" value="{{ old('hospital_region',$hospital->region ) }}" required>
                        </div>

                        <div class="mb-3">
                                <label for="#">Hospital Contact Person (optional) </label>
                                <input type="number" name="contact_person" id="contact_person" class="form-control" placeholder="Enter Contact Person" value="{{ old('contact_person',$hospital->contact_person) }}" required>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.hospitals') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Back
                            </a>
                            <button type="submit" class="btn btn-success fw-bold">
                                <i class="bi bi-check2-circle"></i> Update Hospital
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#edit-hospital-form').on('submit', function(e){
                e.preventDefault(); // Prevent the default form submission
                
                // Collect form data
                var formData = $(this).serialize();

                // Send an AJAX POST request
                $.ajax({
                    url: '{{ route('admin.update_hospital', $hospital->id) }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if(response.status === true) {
                            $('#edit-hospital-form')[0].reset();
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: response.message || "Hospital updated successfully!",
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                window.location.href = "{{ route('admin.hospitals') }}"; 
                            });
                        } else {
                            Swal.fire({
                                position: "top-end",
                                icon: "error",
                                title: response.message || "Failed to update Hospital.",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    },
                    error: function(xhr) {
                        $('.alert-danger').remove();

                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            var errorHtml = '<div class="alert alert-danger"><ul style="list-style-type: none;">';
                            $.each(errors, function(key, value) {
                                errorHtml += '<li><i class="bi bi-x-circle-fill"></i> ' + value[0] + '</li>';
                            });
                            errorHtml += '</ul></div>';
                            $('#edit-hospital-form').before(errorHtml);
                        } else {
                            alert('Error updating hospital: ' + xhr.responseText);
                        }
                    }
                });
            });
        });
    </script>
</x-base>