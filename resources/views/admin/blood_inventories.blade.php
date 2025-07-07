<x-base>
    <x-slot name="title">{{ $title }}</x-slot>

    <div class="container-fluid mt-4 mb-4">

    {{-- Low Stock Alert --}}
    @php
        $allTypes = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
    @endphp

    {{-- Blood Type Cards --}}
    <div class="row mb-4 g-3">
        @foreach($allTypes as $type)
            <div class="col-6 col-md-3">
                <div class="card text-center border-0 shadow-sm" style="border-radius:14px;">
                    <div class="card-body p-3">
                        <div class="fw-bold mb-1" style="color:#d32f2f;font-size:1.2rem;">
                            <i class="bi bi-droplet-half"></i> {{ $type }}
                        </div>
                        <div class="display-6 fw-bold" style="color:{{ ($bloodSummary[$type] ?? 0) > 0 ? '#222' : '#b5b5b5' }};">
                            {{ $bloodSummary[$type] ?? 0 }}
                        </div>
                        <div class="text-muted" style="font-size:.92em;">Units</div>
                        @if(($bloodSummary[$type] ?? 0) == 0)
                            <div class="badge bg-secondary mt-2">Out of stock</div>
                        @elseif(($bloodSummary[$type] ?? 0) <= 2)
                            <div class="badge bg-warning text-dark mt-2">Low stock</div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Inventory Table --}}
    <div class="card border-0 shadow-sm mt-3">
        <div class="card-body">
            <table id="inventoryTable" class="table align-middle table-borderless" style="background:#fff;border-radius:10px;">
                <thead class="table-light">
                    <tr>
                        <th>Bag ID</th>
                        <th>Donor Name</th>
                        <th>Blood Type</th>
                        <th>Volume (ml)</th>
                        <th>Donation Date</th>
                        <th>Expiry Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bloodInventories as $inventory)
                        <tr>
                            <td>{{ $inventory->blood_id }}</td>
                            <td>{{ $inventory->donor_fullname }}</td>
                            <td>
                                <span class="badge bg-danger">{{ $inventory->blood_type }}</span>
                            </td>
                            <td>{{ $inventory->volume }}</td>
                            <td>{{ $inventory->collection_date }}</td>
                            <td>
                                @php
                                    $expiry = \Carbon\Carbon::parse($inventory->expiration_date);
                                    $daysLeft = $expiry->diffInDays(now(), false);
                                    $expiryClass = $daysLeft <= 3 ? 'bg-danger' : ($daysLeft <= 7 ? 'bg-warning text-dark' : 'bg-secondary');
                                @endphp
                                <span class="badge {{ $expiryClass }}">
                                    {{ $expiry->format('Y-m-d') }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $statusClass = $daysLeft <= 3 ? 'bg-danger' : ($daysLeft <= 7 ? 'bg-warning text-dark' : 'bg-success');
                                    $statusText = $daysLeft <= 3 ? 'Expiring Soon' : ($daysLeft <= 7 ? 'Expiring Soon' : 'Available');
                                @endphp
                                <span class="badge {{ $statusClass }}">
                                    {{ $statusText }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $bloodInventories->links() }}
        </div>
    </div>
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
