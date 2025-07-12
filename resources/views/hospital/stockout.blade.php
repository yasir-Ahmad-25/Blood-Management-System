<x-hospital-layout>


    <div class="container-fluid mt-4 mb-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="d-flex justify-content-end mb-2">
                <a href="{{ route('hospital.create_stockout') }}" class="btn btn-danger px-4 py-2 fw-bold rounded shadow-sm">
                    <i class="bi bi-plus-circle"></i> Create Stockout
                </a>
            </div>
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold" style="color:#d32f2f;">
                    <i class="bi bi-list-ul"></i> Recent Stockouts
                </div>
                <div class="card-body p-2">
                    <table class="table align-middle table-hover mb-0" style="background:#fff; border-radius:12px;">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Blood Type</th>
                                <th>Qty</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_stockouts as $stockout)
                                <tr>
                                    <td>
                                        <span class="badge bg-light text-dark">
                                            {{ \Carbon\Carbon::parse($stockout->created_at)->format('Y-m-d') }}
                                        </span>
                                    </td>
                                    <td class="fw-bold" style="color:#d32f2f;">
                                        <i class="bi bi-droplet-fill"></i> {{ $stockout->blood_type }}
                                    </td>
                                    <td>
                                        <span class="badge bg-warning text-dark">{{ $stockout->qty }}</span>
                                    </td>
                                    <td class="text-end">
                                        @if($stockout->status != 'out of stock')
                                            <a href="{{ route('hospital.create_stockout') }}" class="btn btn-outline-danger btn-sm">
                                                <i class="bi bi-exclamation-octagon"></i> Stockout
                                            </a>
                                        @else
                                            <span class="badge bg-secondary">No action</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No stockouts yet.</td>
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
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $('#requestTable').DataTable({
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


</x-hospital-layout>