<x-hospital-layout>
    <x-slot name="title">{{ $title }}</x-slot>

        <!-- Welcome Section -->
    <div class="row mb-3">
        <div class="col-md-12 text-center">
            <div class="mb-2">
                {{-- <img src="/images/hospital-icon.png" alt="Hospital Logo" style="height:54px;width:54px;border-radius:50%;box-shadow:0 4px 18px #f3424220;"> --}}
            </div>
            <h2 class="fw-bold" style="color:#d32f2f;">
                Welcome, {{ $hospital->name ?? 'Hospital' }}!
            </h2>
            <div class="text-muted" style="font-size:1.05em;">
                Here’s a quick overview of your requests & inventory.
            </div>
        </div>
    </div>

    <!-- Cards Row -->
    <div class="row justify-content-center mb-4 g-3">
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <i class="bi bi-droplet-half fs-1 mb-2 text-danger"></i>
                    <h5 class="fw-bold mb-0">{{ $total_requests }}</h5>
                    <small class="text-muted">Total Requests</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <i class="bi bi-hourglass-split fs-1 mb-2 text-warning"></i>
                    <h5 class="fw-bold mb-0">{{ $pending_requests }}</h5>
                    <small class="text-muted">Pending Requests</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <i class="bi bi-check-circle fs-1 mb-2 text-success"></i>
                    <h5 class="fw-bold mb-0">{{ $accepted_requests }}</h5>
                    <small class="text-muted">Accepted Requests</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <i class="bi bi-x-circle fs-1 mb-2 text-secondary"></i>
                    <h5 class="fw-bold mb-0">{{ $declined_requests }}</h5>
                    <small class="text-muted">Declined Requests</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Inventory -->
    <div class="row mb-4 justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold" style="color:#d32f2f;">
                    Blood Inventory Overview
                </div>
                <div class="card-body p-2">
                    <div class="row g-2">
                        @foreach($inventory_summary as $type => $qty)
                        <div class="col-6 col-md-3">
                            <div class="border rounded-3 p-2 text-center" style="background: #f8f9fa;">
                                <div class="fw-bold" style="color:#d32f2f;">{{ $type }}</div>
                                <div class="fs-4">{{ $qty }}</div>
                            </div>
                        </div>
                        @endforeach
                        @if(empty($inventory_summary))
                            <div class="col-12 text-center text-muted">No blood inventory yet.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row mb-2 justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold" style="color:#d32f2f;">
                    Recent Activity
                </div>
                <div class="card-body p-2">
                    <ul class="list-group list-group-flush">
                        @forelse($recent_activities as $activity)
                            <li class="list-group-item">
                                <i class="bi bi-arrow-right-circle me-2 text-danger"></i>
                                {{ $activity }}
                            </li>
                        @empty
                            <li class="list-group-item text-muted">No recent activity.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row justify-content-center mt-4">
        <div class="col-md-8 text-center">
            <a href="{{ route('hospital.BloodRequests') }}" class="btn btn-danger px-4 me-2">Request Blood</a>
            <a href="{{ route('hospital.stockout') }}" class="btn btn-outline-danger px-4">View Inventory</a>
        </div>
    </div>
</div>




<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    @if(session('success'))
        toastr.success("{{ session('success') }}");
    @endif
    @if(session('error'))
        toastr.error("{{ session('error') }}");
    @endif
</script>



</x-hospital-layout>