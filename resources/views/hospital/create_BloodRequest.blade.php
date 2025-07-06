<x-hospital-layout>
    <x-slot name="title">{{ $title }}</x-slot>

   <div class="container">
        <p> Request Blood </p>

        <form id="create-blood-request-form">
            <div class="row">
                

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="#">Blood Type</label>
                        <select name="blood_type" id="blood_type" class="form-control">
                            <option value="">-- Select Blood Type --</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                        </select>

                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="#">Qty</label>
                        <input type="number" step="0.01" name="qty" id="qty" class="form-control" placeholder="" value="{{ old('qty') }}" required>
                    </div>
                </div>

                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary mt-3">Send Request</button>
                </div>

            </div>
        </form>

   </div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    $(document).ready(function(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#create-blood-request-form').on('submit', function(e){
            e.preventDefault(); // Prevent the default form submission
            
            // Collect form data
            var formData = $(this).serialize();

            // Send an AJAX POST request
            $.ajax({
                url: '{{ route('hospital.record_Bloodrequest')}}', // Adjust the URL to your route
                type: 'POST',
                data: formData,
                success: function(response) {
                    if(response.status === true) {
                        // Handle success response
                        $('#create-blood-request-form')[0].reset();
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: response.message || "Request Sent successfully!",
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = "{{ route('hospital.BloodRequests') }}"; 
                        });
                    } else {
                        Swal.fire({
                            position: "top-end",
                            icon: "error",
                            title: response.message || "Failed To Send Request.",
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
                        $('#create-blood-request-form').before(errorHtml);
                    } else {
                        alert('Error creating donor: ' + xhr.responseText);
                    }
                }
            });
        })
    });
    
</script>




</x-hospital-layout>