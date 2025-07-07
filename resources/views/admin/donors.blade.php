<x-base>
    <x-slot name="title">{{ $title }}</x-slot>

    <div class="container-fluid mt-4 mb-5 p-4">
        <div class="row mb-3">
            <div class="col-12 d-flex align-items-center justify-content-between">
                <h3 class="fw-bold" style="color:#b91c1c;">
                    <i class="bi bi-people-fill"></i> Donors List
                </h3>
                <a href="{{ route('admin.create_donor') }}" class="btn btn-primary shadow-sm">
                    <i class="bi bi-plus-circle"></i> Create New Donor
                </a>
            </div>
        </div>
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <table id="donorsTable" class="table align-middle table-borderless" style="background:#fff;border-radius:10px;">
                    <thead class="table-light">
                        <tr>
                            <th>Fullname</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Sex</th>
                            <th>Blood Type</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($donors as $donor)
                            <tr>
                                <td>{{ $donor->fullname }}</td>
                                <td>{{ $donor->email }}</td>
                                <td>{{ $donor->phone }}</td>
                                <td>
                                    <span class="badge bg-{{ strtolower($donor->sex)=='male' ? 'primary' : 'warning' }}">
                                        {{ $donor->sex }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-danger" style="font-size:1em;">
                                        {{ $donor->blood_type }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.edit_donor', $donor->id) }}" class="btn btn-warning btn-sm me-1">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <button class="btn btn-danger btn-sm btn-delete-donor" data-donor-id="{{ $donor->id }}">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $donors->links() }}
            </div>
        </div>
    </div>



<link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $('#example').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true
        });
    });


    $('.btn-delete-donor').on('click', function(){
        let donor_id = $(this).data('donor-id');
        
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
                    url: "{{ route('admin.delete_donor', ':id') }}".replace(':id', donor_id),
                    method: "GET",
                    success: function(response){
                        if(response.success){
                            Swal.fire({
                                title: "Deleted!",
                                text: response.message || "Donor Has Been Deleted Successfully",
                                icon: "success"
                            }).then(() => {
                                window.location.reload();
                            });
                        }else{
                            Swal.fire({
                                title: "Ummm.....???",
                                text: response.message || "Failed To Delete Donor Data Please Try Again...",
                                icon: "error"
                            });
                            // window.location.reload();
                        }
                    },
                    error: function(){
                        Swal.fire({
                            title: "Server Error",
                            text: "Server is Kind a Busy Right Now Please Try Again.....",
                            icon: "error"
                        });
                    }
                });
            }
        });
    });

</script>



</x-base>