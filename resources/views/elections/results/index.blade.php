@extends('layouts.elections')

@push('styles')
    <!-- Include Chart.js and the Data Labels plugin -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
@endpush

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <h2>Results for {{ $election->name }}
                @if($groups == null)
                    {{ 'are pending until election is complete' }}
                @endif
            </h2>
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

                                    // Prepare data for Chart.js
                                    var labels = [];
                                    var data = [];
                                    var backgroundColors = [];
                                    var borderColors = [];

                                    @if ($category->candidates->count() === 1)
                                    // Single candidate, mark as "Duly Elected"
                                    labels.push('{{ $category->candidates->first()->practitioner->first_name }} {{ $category->candidates->first()->practitioner->last_name }}');
                                    data.push(1); // Dummy value for display
                                    backgroundColors.push('#28a745'); // Green for "Duly Elected"
                                    borderColors.push('#218838');
                                    @else
                                    @foreach ($category->candidates as $candidate)
                                    labels.push('{{ $candidate->practitioner->first_name }} {{ $candidate->practitioner->last_name }}');
                                    data.push({{ $candidate->votes->count() }});
                                    backgroundColors.push('#ff6384'); // Regular color
                                    borderColors.push('#e55473');
                                    @endforeach
                                    @endif

                                    // Create the chart
                                    new Chart(ctx, {
                                        type: 'bar',
                                        data: {
                                            labels: labels,
                                            datasets: [{
                                                label: 'Votes',
                                                data: data,
                                                backgroundColor: backgroundColors,
                                                borderColor: borderColors,
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
                                                            // Return only the vote count for regular candidates
                                                            if (labels[context.dataIndex] !== "Duly Elected") {
                                                                return `Votes: ${context.raw}`;
                                                            }
                                                            return "Duly Elected";
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
                                                    formatter: function(value, context) {
                                                        // Show "Duly Elected" inside the bar for single candidates
                                                        if (labels[context.dataIndex] === "{{ $category->candidates->first()->practitioner->first_name }} {{ $category->candidates->first()->practitioner->last_name }}" && {{ $category->candidates->count() }} === 1) {
                                                            return "Duly Elected";
                                                        }
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
