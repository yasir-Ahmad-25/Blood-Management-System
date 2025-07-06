<x-base>
    <x-slot name="title">{{ $title }}</x-slot>

    <div class="container-fluid mt-5">
        <h1>Donations List</h1>
        <span>This is Donations Page</span>
        <a href="{{ route('admin.create_donation')}}" class="btn btn-primary"> Create New Donation </a>
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
        
        <table id="donationsTable" class="display">
            <thead>
                <tr>
                    <th>Donor Name</th>
                    <th>Donation Date</th>
                    <th>Blood Type</th>
                    <th>Volume (ml)</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($donations as $donation)
                    <tr>
                        <td>{{ $donation->donor_fullname }}</td>
                        <td>{{ $donation->donation_date }}</td>
                        <td>{{ $donation->blood_type }}</td>
                        <td>{{ $donation->volume_ml }} ml</td>
                        <td>
                            @php
                                $statusClasses = [
                                    'collected' => 'badge bg-primary',
                                    'in_testing' => 'badge bg-warning text-dark',
                                    'approved' => 'badge bg-success',
                                    'rejected' => 'badge bg-danger',
                                ];
                                $statusLabels = [
                                    'collected' => 'Collected',
                                    'in_testing' => 'In Testing',
                                    'approved' => 'Approved',
                                    'rejected' => 'Rejected',
                                ];
                                $status = $donation->status;
                            @endphp
                            <span class="{{ $statusClasses[$status] ?? 'badge bg-secondary' }}">
                                {{ $statusLabels[$status] ?? ucfirst($status) }}
                            </span>
                        </td>
                            <td>
                            <a href="#" class="btn btn-warning btn-sm">Edit</a>
                            <a href="#" class="btn btn-danger btn-sm">Delete</a>
                            @if($status === 'collected')
                                <a href="{{ route('admin.change_donation_status', [$donation->id, 'start_testing']) }}"
                                class="btn btn-primary btn-sm">Start Testing</a>
                            @elseif($status === 'in_testing')
                                <a href="{{ route('admin.change_donation_status', [$donation->id, 'approve']) }}"
                                class="btn btn-success btn-sm">Approve</a>
                                <a href="{{ route('admin.change_donation_status', [$donation->id, 'reject']) }}"
                                class="btn btn-danger btn-sm">Reject</a>
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
<script>
    $(document).ready(function() {
        $('#donationsTable').DataTable({
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