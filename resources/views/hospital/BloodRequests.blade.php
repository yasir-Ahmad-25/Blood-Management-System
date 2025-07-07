<x-hospital-layout>
    <x-slot name="title">{{ $title }}</x-slot>

   <div class="container p-5">
            <!-- Blood Types Cards Row -->
            <div class="row mb-4 g-3">
                @foreach($blood_stock as $type => $qty)
                    <div class="col-6 col-md-3">
                        <div class="card text-center border-0 shadow-sm" style="border-radius:14px;">
                            <div class="card-body p-3">
                                <div class="fw-bold mb-1" style="color:#d32f2f;font-size:1.2rem;">
                                    <i class="bi bi-droplet-half"></i> {{ $type }}
                                </div>
                                <div class="display-6 fw-bold" style="color:{{ $qty > 0 ? '#222' : '#b5b5b5' }};">
                                    {{ $qty }}
                                </div>
                                <div class="text-muted" style="font-size:.92em;">Units Available</div>
                                @if($qty == 0)
                                    <div class="badge bg-secondary mt-2">Out of stock</div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- End Blood Type Cards Row -->

        
        <a href="{{ route('hospital.create_BloodRequest')}}" class="btn btn-primary"> Request Blood </a>

        

        <table class="table align-middle table-borderless shadow-sm" style="background:#fff; border-radius:12px;">
            <thead class="table-light">
                <tr>
                    <th>Date</th>
                    <th>Blood Type</th>
                    <th>Qty</th>
                    <th>Status</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bloodRequests as $request)
                    <tr style="vertical-align:middle;">
                        <td>{{ $request->requested_date }}</td>
                        <td class="fw-bold" style="color:#d32f2f;">{{ $request->blood_type }}</td>
                        <td>{{ $request->qty }}</td>
                        <td>
                            @php
                                $statusClass = [
                                    'Pending' => 'bg-warning text-dark',
                                    'Accepted' => 'bg-success',
                                    'Declined' => 'bg-secondary'
                                ][$request->status] ?? 'bg-light text-dark';
                            @endphp
                            <span class="badge {{ $statusClass }}" style="font-size:.99em;">
                                {{ $request->status }}
                            </span>
                        </td>
                        <td class="text-end">
                            @if($request->status == 'Pending')
                                <button class="btn btn-outline-danger btn-sm btn-cancel-request" 
                                        data-request-id="{{ $request->request_id }}">
                                    <i class="bi bi-x-circle"></i> Cancel
                                </button>
                            @else
                                <span class="badge bg-light text-muted">
                                    <i class="bi bi-lock"></i> No action
                                </span>
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
        $('#requestTable').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true
        });
    });

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
                    url: "{{ route('hospital.cancel_request', ':id') }}".replace(':id', request_id),
                    method: "GET",
                    success: function(response){
                        if(response.success){
                            Swal.fire({
                                title: "Deleted!",
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



</x-hospital-layout>