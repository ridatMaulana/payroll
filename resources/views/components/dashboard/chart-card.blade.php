<div class="card chart-card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="card-title mb-1">{{ $title }}</h5>
                <p class="text-muted mb-0">{{ $subtitle }}</p>
            </div>
            {{-- <div class="dropdown">
                <button class="btn btn-link dropdown-toggle" data-bs-toggle="dropdown">
                    This Month
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#">This Week</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                </ul>
            </div> --}}
        </div>
        <div class="chart-container">
            <canvas id="gajiBarChart"></canvas>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById('gajiBarChart').getContext('2d');
        var totalGaji = @json($totalGaji);
        var totalDenda = @json($totalDenda);
        var totalTunjangan = @json($totalTunjangan);
        var gajiBersih = @json($gajiBersih);

        var gajiBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Total Gaji', 'Total Denda', 'Total Tunjangan', 'Gaji Bersih'],
                datasets: [{
                    data: [totalGaji, totalDenda, totalTunjangan, gajiBersih],
                    backgroundColor: ['#4e73df', '#e74a3b', '#1cc88a', '#36b9cc'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                var label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed !== null) {

                                    label += new Intl.NumberFormat('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR'
                                    }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endpush
