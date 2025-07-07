<x-base>
    <x-slot name="title">{{ $title }}</x-slot>

    <div class="container-fluid mt-4 mb-5">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-md-12 text-center">
            <h2 class="fw-bold" style="color:#b91c1c;">
                <i class="bi bi-activity"></i> Welcome to the Admin Dashboard
            </h2>
            <div class="text-muted mb-2" style="font-size:1.1em;">
                This is the admin section of the Blood Management System.
            </div>
        </div>
    </div>

    <!-- Dashboard Summary Cards -->
    <div class="row justify-content-center mb-4 g-3">
        <div class="col-6 col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <i class="bi bi-people-fill fs-1 mb-2 text-danger"></i>
                    <h5 class="fw-bold mb-0">{{ $total_donors }}</h5>
                    <small class="text-muted">Total Donors</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <i class="bi bi-hospital fs-1 mb-2 text-primary"></i>
                    <h5 class="fw-bold mb-0">{{ $total_hospitals }}</h5>
                    <small class="text-muted">Total Hospitals</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <i class="bi bi-droplet-half fs-1 mb-2 text-danger"></i>
                    <h5 class="fw-bold mb-0">{{ $total_blood_units }}</h5>
                    <small class="text-muted">Blood Units</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <i class="bi bi-journal-text fs-1 mb-2 text-warning"></i>
                    <h5 class="fw-bold mb-0">{{ $total_requests }}</h5>
                    <small class="text-muted">Total Requests</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Table -->
    <div class="row mb-2 justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold" style="color:#b91c1c;">
                    <i class="bi bi-clock-history"></i> Recent Activity
                </div>
                <div class="card-body p-2">
                    <table class="table align-middle table-borderless" style="background:#fff;border-radius:12px;">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_activities as $activity)
                            <tr>
                                <td>
                                    <span class="badge bg-light text-dark">
                                        {{ $activity['date'] }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $activity['type_color'] ?? 'info' }}">
                                        {{ $activity['type'] }}
                                    </span>
                                </td>
                                <td>
                                    {{ $activity['details'] }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">No recent activity.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
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



</x-base>