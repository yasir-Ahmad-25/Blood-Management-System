<x-base>
    <x-slot name="title">{{ $title }}</x-slot>

    <div class="container-fluid mt-5">
        <h1>Donors List</h1>
        <span>This is Donors Page</span>
        <a href="{{ route('admin.create_donor')}}" class="btn btn-primary"> Create New Donor </a>
        <hr>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        
        <table id="example" class="display">
            <thead>
                <tr>
                    <th>Fullname</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Sex</th>
                    <th>Blood Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($donors as $donor)
                    <tr>
                        <td>{{ $donor->fullname }}</td>
                        <td>{{ $donor->email }}</td>
                        <td>{{ $donor->phone }}</td>
                        <td>{{ $donor->sex }}</td>
                        <td>{{ $donor->blood_type }}</td>
                        <td>
                            <a href="{{ route('admin.edit_donor', $donor->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <a href="{{ route('admin.delete_donor', $donor->id) }}" class="btn btn-danger btn-sm">Delete</a>
                            
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
</script>



</x-base>