<x-base>
    <x-slot name="title">{{ $title }}</x-slot>
    <div class="container-fluid mt-5">
        <h1 class="mb-4 fw-bold">Blood Inventories</h1>
        
        <!-- Inventory Summary Cards -->
        <div class="row mb-4">
            @foreach($bloodSummary as $type => $count)
                <div class="col-md-2 mb-2">
                    <div class="card text-center shadow-sm border-0">
                        <div class="card-body p-2">
                            <h5 class="fw-bold mb-0" style="font-size:1.5rem;">{{ $type }}</h5>
                            <span class="fw-semibold text-secondary">Units: </span>
                            <span class="fs-4">{{ $count }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <table id="inventoryTable" class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Bag ID</th>
                    <th>Donor Name</th>
                    <th>Blood Type</th>
                    <th>Volume (ml)</th>
                    <th>Donation Date</th>
                    <th>Expiry Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bloodInventories as $inventory)
                @php
                    $expiry = \Carbon\Carbon::parse($inventory->expiration_date);
                    $now = \Carbon\Carbon::now();
                    // Should check: Is expiry in the past?
                    if ($expiry->lt($now)) {
                        $statusClass = 'bg-danger';
                        $statusText = 'Expired';
                    } elseif ($expiry->diffInDays($now) <= 3) {
                        $statusClass = 'bg-warning text-dark';
                        $statusText = 'Expiring Soon';
                    } else {
                        $statusClass = 'bg-success';
                        $statusText = 'Available';
                    }
                @endphp
                    <tr>
                        <td>{{ $inventory->blood_id }}</td>
                        <td>{{ $inventory->donor_fullname }}</td>
                        <td class="fw-bold">{{ $inventory->blood_type }}</td>
                        <td>{{ $inventory->volume }}</td>
                        <td>{{ $inventory->collection_date }}</td>
                        <td>
                            <span class="badge {{ $statusClass }}">
                                {{ $inventory->expiration_date }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $statusClass }}">{{ $statusText }}</span>
                        </td>
                        <td>
                            @if($inventory->status == 'available')
                                <a href="#" class="btn btn-outline-primary btn-sm mb-1">Issue</a>
                                <a href="#" class="btn btn-outline-danger btn-sm mb-1">Discard</a>
                            @else
                                <a href="#" class="btn btn-outline-secondary btn-sm">Details</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- DataTables & Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#inventoryTable').DataTable({
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
