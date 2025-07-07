<x-base>
    <x-slot name="title">{{ $title }}</x-slot>

    <div class="container-fluid mt-4 mb-5 p-5">
        <div class="row mb-3">
            <div class="col-12 d-flex align-items-center justify-content-between">
                <h3 class="fw-bold" style="color:#b91c1c;">
                    <i class="bi bi-hospital"></i> Hospitals List
                </h3>
                <a href="{{ route('admin.create_hospital') }}" class="btn btn-primary shadow-sm">
                    <i class="bi bi-plus-circle"></i> Add Hospital
                </a>
            </div>
        </div>
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <table class="table align-middle table-borderless" style="background:#fff;border-radius:10px;">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hospitals as $hospital)
                            <tr>
                                <td>{{ $hospital->name }}</td>
                                <td>{{ $hospital->email }}</td>
                                <td>{{ $hospital->phone }}</td>
                                <td>{{ $hospital->address }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.edit_hospital', $hospital->id) }}" class="btn btn-warning btn-sm me-1">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <button class="btn btn-danger btn-sm btn-delete-hospital" data-hospital-id="{{ $hospital->id }}">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $hospitals->links() }}
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
        $('#hospitalsTable').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true
        });
    });

    $('.btn-delete-hospital').on('click', function(){
        let hospital_id = $(this).data('hospital-id');
        
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Delete it!"
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: "{{ route('admin.delete_hospital', ':id') }}".replace(':id', hospital_id),
                    method: "GET",
                    success: function(response){
                        if(response.success){
                            Swal.fire({
                                title: "Deleted!",
                                text: response.message || "Hospital Has Been Deleted Successfully",
                                icon: "success"
                            }).then(() => {
                                window.location.reload();
                            });
                        }else{
                            Swal.fire({
                                title: "Ummm.....???",
                                text: response.message || "Failed To Delete Hospital Data Please Try Again...",
                                icon: "error"
                            });
                            window.location.reload();
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