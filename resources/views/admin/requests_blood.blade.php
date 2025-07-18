<x-base>
    <x-slot name="title">{{ $title }}</x-slot>

   <div class="container-fluid p-5">
        <div class="row mb-4 g-3">
            @foreach($bloodRequestCards as $type => $count)
                <div class="col-6 col-md-3">
                    <div class="card text-center border-0 shadow-sm" style="border-radius:14px;">
                        <div class="card-body p-3">
                            <div class="fw-bold mb-1" style="color:#d32f2f;font-size:1.2rem;">
                                <i class="bi bi-droplet-half"></i> {{ $type }}
                            </div>
                            <div class="display-6 fw-bold" style="color:{{ $count > 0 ? '#222' : '#b5b5b5' }};">
                                {{ $count }}
                            </div>
                            <div class="text-muted" style="font-size:.92em;">Requests</div>
                            @if($count == 0)
                                <div class="badge bg-secondary mt-2">No requests</div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <hr>

        <table id="requests_table" class="display">
            <thead>
                <tr>
                    <th>Hospital</th>
                    <th>Blood Type</th>
                    <th>Qty</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($blood_requests as $request)
                    <tr>
                        <td> {{ $request->Hospital_Name}} </td>
                        <td> {{ $request->blood_type }} </td>
                        <td>{{ $request->qty}}</td>
                        <td>{{ $request->requested_date}}</td>
                        {{-- <td>
                            <button class="btn btn-success btn-accept-request" data-request-id="{{ $request->request_id}}" > Accept </button>
                            <button class="btn btn-danger btn-cancel-request" data-request-id="{{ $request->request_id}}"> Cancel </button>
                        </td> --}}
                        <td>
                            @if($request->status == 'Pending')
                                <button class="btn btn-success btn-accept-request" data-request-id="{{ $request->request_id }}">Accept</button>
                                <button class="btn btn-danger btn-cancel-request" data-request-id="{{ $request->request_id }}">Decline</button>
                            @else
                                <span class="badge bg-secondary">{{ $request->status }}</span>
                            @endif
                        </td>

                    </tr>
                @endforeach

            </tbody>
        </table>

   </div>


<link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $('#requests_table').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true
        });
    });

    $('.btn-accept-request').on('click', function(){
        let request_id = $(this).data('request-id');
        
        Swal.fire({
            title: "Are you sure?",
            text: "You Want To Accept This Request",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Accept it!"
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: "{{ route('admin.accept_request', ':id') }}".replace(':id', request_id),
                    method: "GET",
                    success: function(response){
                        if(response.success){
                            Swal.fire({
                                title: "Deleted!",
                                text: response.message || "Request Has Been Accepted Successfully",
                                icon: "success"
                            }).then(() => {
                                window.location.reload();
                            });
                        }else{
                            Swal.fire({
                                title: "Ummm.....???",
                                text: response.message || "Failed To Accept Request Data Please Try Again...",
                                icon: "error"
                            });
                            // window.location.reload();
                        }
                    },
                    error: function(){
                        Swal.fire({
                            title: "Server Error",
                            text: "Server is Kind Busy Right Now Please Try Again.....",
                            icon: "error"
                        });
                    }
                });
            }
        });
    });

    // Cancel The Request
    $('.btn-cancel-request').on('click', function(){
        let request_id = $(this).data('request-id');
        
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Cancel it!"
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: "{{ route('admin.cancel_request', ':id') }}".replace(':id', request_id),
                    method: "GET",
                    success: function(response){
                        if(response.success){
                            Swal.fire({
                                title: "Accepted!",
                                text: response.message || "Request Has Been Canceled Successfully",
                                icon: "success"
                            }).then(() => {
                                window.location.reload();
                            });
                        }else{
                            Swal.fire({
                                title: "Ummm.....???",
                                text: response.message || "Failed To Cancel Request Data Please Try Again...",
                                icon: "error"
                            });
                            // window.location.reload();
                        }
                    },
                    error: function(){
                        Swal.fire({
                            title: "Server Error",
                            text: "Server is Kind Busy Right Now Please Try Again.....",
                            icon: "error"
                        });
                    }
                });
            }
        });
    });

</script>



</x-base>