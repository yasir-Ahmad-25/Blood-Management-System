<x-base>
    <x-slot name="title">{{ $title }}</x-slot>

    <div class="container-fluid mt-5 mb-5 p-5">

        {{-- Top Summary Cards --}}
        <div class="row mb-4 g-3">
            <div class="col-6 col-md-2">
                <div class="card text-center shadow-sm border-0">
                    <div class="card-body p-3">
                        <i class="bi bi-people-fill fs-1 text-danger"></i>
                        <h5 class="fw-bold mb-0">{{ $totalDonors }}</h5>
                        <small class="text-muted">Donors</small>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-2">
                <div class="card text-center shadow-sm border-0">
                    <div class="card-body p-3">
                        <i class="bi bi-droplet-half fs-1 text-danger"></i>
                        <h5 class="fw-bold mb-0">{{ $totalDonations }}</h5>
                        <small class="text-muted">Donations</small>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-2">
                <div class="card text-center shadow-sm border-0">
                    <div class="card-body p-3">
                        <i class="bi bi-hospital fs-1 text-primary"></i>
                        <h5 class="fw-bold mb-0">{{ $totalHospitals }}</h5>
                        <small class="text-muted">Hospitals</small>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-2">
                <div class="card text-center shadow-sm border-0">
                    <div class="card-body p-3">
                        <i class="bi bi-archive fs-1 text-success"></i>
                        <h5 class="fw-bold mb-0">{{ $inventoryUnits }}</h5>
                        <small class="text-muted">Blood Units</small>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-2">
                <div class="card text-center shadow-sm border-0">
                    <div class="card-body p-3">
                        <i class="bi bi-journal-text fs-1 text-warning"></i>
                        <h5 class="fw-bold mb-0">{{ $totalRequests }}</h5>
                        <small class="text-muted">Requests</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Low Stock Alert --}}
        @php
            $allTypes = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
            $lowStockTypes = [];
            foreach($allTypes as $type) {
                $qty = $bloodSummary[$type] ?? 0;
                if ($qty <= 2) {
                    $lowStockTypes[] = $type . " ($qty)";
                }
            }
        @endphp

        <div class="row g-4">
            {{-- Recent Donations --}}
            <div class="col-md-6">
                <div class="card shadow-sm border-0 mb-2">
                    <div class="card-header bg-white fw-bold" style="color:#b91c1c;">
                        <i class="bi bi-droplet-half"></i> Recent Donations
                    </div>
                    <div class="card-body p-2">
                        <table class="table table-sm align-middle table-borderless">
                            <thead class="table-light">
                                <tr>
                                    <th>Donor</th>
                                    <th>Blood Type</th>
                                    <th>Volume (ml)</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($recentDonations as $donation)
                                <tr>
                                    <td>{{ $donation->fullname ?? '-' }}</td>
                                    <td><span class="badge bg-danger">{{ $donation->blood_type }}</span></td>
                                    <td>{{ $donation->volume_ml }}</td>
                                    <td>{{ $donation->donation_date }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No recent donations.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- Recent Requests --}}
            <div class="col-md-6">
                <div class="card shadow-sm border-0 mb-2">
                    <div class="card-header bg-white fw-bold" style="color:#b91c1c;">
                        <i class="bi bi-journal-text"></i> Recent Requests
                    </div>
                    <div class="card-body p-2">
                        <table class="table table-sm align-middle table-borderless">
                            <thead class="table-light">
                                <tr>
                                    <th>Hospital</th>
                                    <th>Blood Type</th>
                                    <th>Qty</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($recentRequests as $request)
                                <tr>
                                    <td>{{ $request->name ?? '-' }}</td>
                                    <td><span class="badge bg-danger">{{ $request->blood_type }}</span></td>
                                    <td>{{ $request->qty }}</td>
                                    <td>
                                        @php
                                            $badge = [
                                                'Pending' => 'warning text-dark',
                                                'Accepted' => 'success',
                                                'Declined' => 'secondary'
                                            ][$request->status] ?? 'secondary';
                                        @endphp
                                        <span class="badge bg-{{ $badge }}">{{ $request->status }}</span>
                                    </td>
                                    <td>{{ $request->requested_date }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No recent requests.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</x-base>