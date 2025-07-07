<x-base>
    <x-slot name="title">{{ $title }}</x-slot>

<div class="container-fluid mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="fw-bold mb-3 text-center" style="color:#b91c1c;">
                        <i class="bi bi-droplet-half"></i> Create Donation
                    </h4>
                    @if($errors->any())
                        <div class="alert alert-danger mb-2">
                            {{ implode('', $errors->all(':message ')) }}
                        </div>
                    @endif
                    <form id="create-donation-form">
                        <div class="mb-3">
                            <label for="donor_id" class="form-label">Donor</label>
                            <select class="form-control" name="donor" id="donor" required>
                                <option value="">-- Select Donor --</option>
                                @foreach($donors as $donor)
                                    <option value="{{ $donor->id }}" {{ old('donor_id') == $donor->id ? 'selected' : '' }}>
                                        {{ $donor->fullname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="donation_date" class="form-label">Donation Date</label>
                            <input type="date" class="form-control" name="donation_date" id="donation_date" value="{{ old('donation_date') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="blood_type" class="form-label">Blood Type</label>
                            <select class="form-control" name="blood_type" id="blood_type" required>
                                <option value="">-- Select --</option>
                                @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $type)
                                    <option value="{{ $type }}" {{ old('blood_type') == $type ? 'selected' : '' }}>
                                        {{ $type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="volume_ml" class="form-label">Volume (ml)</label>
                            <input type="number" class="form-control" name="volume" id="volume" min="1" value="{{ old('volume_ml') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control" name="location" id="location" value="{{ old('location') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea class="form-control" name="remarks" id="remarks" rows="2">{{ old('remarks') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-danger w-100 fw-bold mt-2">
                            <i class="bi bi-check2-circle"></i> Save Donation
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

        $('#create-donation-form').on('submit', function(e){
            e.preventDefault(); // Prevent the default form submission
            
            // Collect form data 
            var formData = $(this).serialize();

            // Send an AJAX POST request
            $.ajax({
                url: '{{ route('admin.record_donation')}}', // Adjust the URL to your route
                type: 'POST',
                data: formData,
                success: function(response) {
                    if(response.status === true) {
                        // Handle success response
                        $('#create-donation-form')[0].reset();
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: response.message || "Donation created successfully!",
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = "{{ route('admin.donations') }}"; 
                        });
                    } else {
                        Swal.fire({
                            position: "top-end",
                            icon: "error",
                            title: response.message || "Failed to create donation.",
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
                        $('#create-donation-form').before(errorHtml);
                    } else {
                        alert('Error creating donation: ' + xhr.responseText);
                    }
                }
            });
        })
    
        // get the donor blood_type
        $('#donor').on('change', function() {
            var donorId = $(this).val();
            if (donorId) {
                $.ajax({
                    url: '{{ route('admin.get_donor_blood_type') }}',
                    type: 'GET',
                    data: { donorId: donorId },
                    success: function(response) {
                        if (response.status === true) {
                            $('#blood_type').val(response.blood_type);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message ,
                            });
                        }
                    },
                    error: function(xhr) {
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error fetching blood type: ' + xhr.responseText,
                        });
                    }
                });
            } else {
                $('#blood_type').val('');
            }
        });
    });
    
</script>



</x-base>