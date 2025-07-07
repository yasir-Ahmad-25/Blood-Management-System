<x-base>
    <x-slot name="title">{{ $title }}</x-slot>

<div class="container-fluid mt-4 mb-5">
    <div class="row mb-3">
        <div class="col-12 d-flex align-items-center justify-content-between">
            <h3 class="fw-bold" style="color:#b91c1c;">
                <i class="bi bi-droplet-half"></i> Donations List
            </h3>
            <a href="{{ route('admin.create_donation') }}" class="btn btn-primary shadow-sm">
                <i class="bi bi-plus-circle"></i> Create Donation
            </a>
        </div>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <table id="donationsTable" class="table align-middle table-borderless" style="background:#fff;border-radius:10px;">
                <thead class="table-light">
                    <tr>
                        <th>Donor Name</th>
                        <th>Donation Date</th>
                        <th>Blood Type</th>
                        <th>Volume (ml)</th>
                        <th>Status</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($donations as $donation)
                        <tr>
                            <td>{{ $donation->donor_fullname ?? '-' }}</td>
                            <td>{{ $donation->donation_date }}</td>
                            <td>
                                <span class="badge bg-danger">{{ $donation->blood_type }}</span>
                            </td>
                            <td>{{ $donation->volume_ml }}</td>
                            <td>
                                @php
                                    $statusMap = [
                                        'collected' => 'primary',
                                        'in_testing' => 'warning text-dark',
                                        'approved' => 'success',
                                        'rejected' => 'danger',
                                        'completed' => 'secondary'
                                    ];
                                    $statusClass = $statusMap[$donation->status] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $statusClass }}" style="font-size:.98em;">
                                    {{ ucfirst($donation->status) }}
                                </span>
                            </td>
                            <td class="text-end">
                                @if($donation->status === 'collected')
                                    <a href="{{ route('admin.change_donation_status', [$donation->id, 'start_testing']) }}"
                                    class="btn btn-primary btn-sm">Start Testing</a>
                                @elseif($donation->status === 'in_testing')
                                    <a href="{{ route('admin.change_donation_status', [$donation->id, 'approve']) }}"
                                    class="btn btn-success btn-sm">Approve</a>
                                    <a href="{{ route('admin.change_donation_status', [$donation->id, 'reject']) }}"
                                    class="btn btn-danger btn-sm">Reject</a>
                                @else
                                    <a type="button" class="badge bg-secondary">No Action</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $donations->links() }}
        </div>
    </div>
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