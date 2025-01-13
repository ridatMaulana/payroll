<div class="card stats-card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h6 class="text-muted mb-1">{{ $title }}</h6>
                <h3 class="mb-0">{{ $value }}</h3>
            </div>
            <div class="stats-icon">
                <i class="bi {{ $icon }}"></i>
            </div>
        </div>
        <div class="mt-3">
            <span class="trend {{ $trendUp ? 'trend-up' : 'trend-down' }}">
                <i class="bi {{ $trendUp ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i>
                {{ $trend }}
            </span>
            <span class="text-muted ms-2">vs last month</span>
        </div>
    </div>
</div>
