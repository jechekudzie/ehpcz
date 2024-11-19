@extends('layouts.elections')

@push('styles')
    <!-- Include Chart.js and the Data Labels plugin -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
@endpush

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <h2>Results for {{ $election->name }} @if($groups == null) {{ 'are pending until election is complete' }} @endif</h2>
            @foreach ($groups as $group)
                <div class="card mt-4">
                    <div class="card-header bg-primary text-white">
                        <h4 style="color: white;">{{ $group->name }}</h4>
                    </div>
                    <div class="card-body">
                        @foreach ($group->categories as $category)
                            <h5>{{ $category->name }}</h5>
                            <div style="max-width: 1200px; margin: auto;"> <!-- Larger canvas width for a bigger chart -->
                                <canvas id="chart-{{ $group->id }}-{{ $category->id }}" width="800" height="400"></canvas>
                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    var ctx = document.getElementById('chart-{{ $group->id }}-{{ $category->id }}').getContext('2d');
                                    new Chart(ctx, {
                                        type: 'bar',
                                        data: {
                                            labels: [
                                                @foreach ($category->candidates as $candidate)
                                                    '{{ $candidate->practitioner->first_name }} {{ $candidate->practitioner->last_name }}',
                                                @endforeach
                                            ],
                                            datasets: [{
                                                label: 'Votes',
                                                data: [
                                                    @foreach ($category->candidates as $candidate)
                                                        {{ $candidate->votes->count() }},
                                                    @endforeach
                                                ],
                                                backgroundColor: [
                                                    '#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff', '#ff9f40'
                                                ],
                                                borderColor: [
                                                    '#e55473', '#3097d8', '#e6b84d', '#3aa6a6', '#8a5fd9', '#e68b3c'
                                                ],
                                                borderWidth: 1,
                                                borderRadius: 8,
                                                barThickness: 40,
                                                maxBarThickness: 50
                                            }]
                                        },
                                        options: {
                                            responsive: true,
                                            maintainAspectRatio: false,
                                            scales: {
                                                y: {
                                                    beginAtZero: true,
                                                    ticks: {
                                                        stepSize: 1,
                                                        font: {
                                                            size: 12
                                                        }
                                                    },
                                                    title: {
                                                        display: true,
                                                        text: 'Votes',
                                                        font: {
                                                            size: 14,
                                                            weight: 'bold'
                                                        }
                                                    }
                                                },
                                                x: {
                                                    ticks: {
                                                        font: {
                                                            size: 12
                                                        }
                                                    }
                                                }
                                            },
                                            plugins: {
                                                legend: {
                                                    display: false
                                                },
                                                tooltip: {
                                                    backgroundColor: '#333',
                                                    titleColor: '#fff',
                                                    bodyColor: '#fff',
                                                    titleFont: { weight: 'bold' },
                                                    padding: 10,
                                                    cornerRadius: 4,
                                                    callbacks: {
                                                        label: function(context) {
                                                            return `Votes: ${context.raw}`;
                                                        }
                                                    }
                                                },
                                                datalabels: {
                                                    color: '#ffffff',
                                                    anchor: 'center',
                                                    align: 'center',
                                                    font: {
                                                        weight: 'bold',
                                                        size: 14
                                                    },
                                                    rotation: -90, // Rotate text to be vertical from bottom up
                                                    formatter: function(value) {
                                                        return value;
                                                    }
                                                }
                                            },
                                            layout: {
                                                padding: {
                                                    top: 10,
                                                    bottom: 10
                                                }
                                            }
                                        },
                                        plugins: [ChartDataLabels]
                                    });
                                });
                            </script>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
