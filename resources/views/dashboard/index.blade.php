@extends('layouts.dashboard')
@push('styles')
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
@endpush
@section('content')
<div class="container-fluid py-4">

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            @include('components.dashboard.stats-card', [
                'title' => 'Total Gaji',
                'value' => number_format($totalGaji, 0, ',', '.'),
                'icon' => 'bi-cash',
                'trend' => '',
                'trendUp' => true
            ])
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            @include('components.dashboard.stats-card', [
                'title' => 'Total Denda',
                'value' => number_format($totalDenda, 0, ',', '.'),
                'icon' => 'bi-exclamation-triangle',
                'trend' => '',
                'trendUp' => false
            ])
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            @include('components.dashboard.stats-card', [
                'title' => 'Total Tunjangan',
                'value' => number_format($totalTunjangan, 0, ',', '.'),
                'icon' => 'bi-gift',
                'trend' => '',
                'trendUp' => true
            ])
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            @include('components.dashboard.stats-card', [
                'title' => 'Gaji Bersih',
                'value' => number_format($gajiBersih, 0, ',', '.'),
                'icon' => 'bi-wallet',
                'trend' => '',
                'trendUp' => true
            ])
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 mb-4">
            @include('components.dashboard.chart-card', [
                'title' => 'Gaji Overview',
                'subtitle' => 'Chart gaji bulan ini',
                'totalGaji' => $totalGaji ?? 0,
                'totalDenda' => $totalDenda ?? 0,
                'totalTunjangan' => $totalTunjangan ?? 0,
                'gajiBersih' => $gajiBersih ?? 0
            ])
        </div>
        {{-- <div class="col-lg-4 mb-4">
            @include('components.dashboard.activity-card')
        </div> --}}
    </div>
</div>
@endsection
@push('scripts')
    <script src="{{ asset('js/dashboard.js') }}"></script>
@endpush
