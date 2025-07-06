<x-base>
    <x-slot name="title">{{ $title }}</x-slot>

    <div class="container-fluid mt-5">
        <h1>Create Donation</h1>
        
        <form id="create-donation-form">
            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="#">Donor</label>
                        <select name="donor" id="donor" class="form-control">
                            <option value="#" selected disabled> Select Donor</option>
                            @foreach($donors as $donor)
                                <option value="{{ $donor->id }}">{{ $donor->fullname }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="#">Date Of Birth</label>
                        <input type="date" name="donation_date" id="donation_date" class="form-control" placeholder="Enter Date of Donation" value="{{ old('donation_date') }}" required>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="#">Blood Type</label>
                        <input type="text" name="blood_type" id="blood_type" class="form-control" placeholder="Enter Blood Type" value="{{ old('blood_type') }}" required>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="#">Volume (ml)</label>
                        <input type="text" name="volume" id="volume" class="form-control" placeholder="Enter Volume" value="{{ old('volume') }}" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="#"> Donation Location </label>
                        <input type="text" name="location" id="location" class="form-control" placeholder="Enter Location" value="{{ old('location') }}" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="#"> Remarks </label>
                        <input type="text" name="remarks" id="remarks" class="form-control" placeholder="Enter Remark" value="{{ old('remarks') }}" required>
                    </div>
                </div>

                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Make Donation</button>
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