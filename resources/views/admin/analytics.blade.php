@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100">Admin Analytics</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                <h3 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Daily Loan Applications</h3>
                <canvas id="dailyLoansChart" width="400" height="300"></canvas>
                <p class="text-center text-gray-500 dark:text-gray-400 mt-2">Total: {{ $analytics['daily'] }}</p>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                <h3 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Weekly Loan Applications</h3>
                <canvas id="weeklyLoansChart" width="400" height="300"></canvas>
                <p class="text-center text-gray-500 dark:text-gray-400 mt-2">Total: {{ $analytics['weekly'] }}</p>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                <h3 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Monthly Loan Applications (Current Month)</h3>
                <canvas id="monthlyLoansChart" width="400" height="300"></canvas>
                <p class="text-center text-gray-500 dark:text-gray-400 mt-2">Total: {{ $analytics['monthly'] }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                <h3 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Daily Loan Application Trend (Last 7 Days)</h3>
                <canvas id="dailyTrendChart" width="800" height="400"></canvas>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                <h3 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Weekly Loan Application Trend (Last 4 Weeks)</h3>
                <canvas id="weeklyTrendChart" width="800" height="400"></canvas>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-6">
            <h3 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Monthly Loan Application Trend (Last 6 Months)</h3>
            <canvas id="monthlyTrendChart" width="800" height="400"></canvas>
        </div>

        <script>
            const dailyLoans = {{ $analytics['daily'] }};
            const weeklyLoans = {{ $analytics['weekly'] }};
            const monthlyLoans = {{ $analytics['monthly'] }};
            const monthlyTrendData = @json($monthlyTrend);
            const dailyTrendData = @json($dailyTrend);
            const weeklyTrendData = @json($weeklyTrend);

            // Daily Loans Chart
            const dailyCtx = document.getElementById('dailyLoansChart').getContext('2d');
            const dailyChart = new Chart(dailyCtx, {
                type: 'bar',
                data: {
                    labels: ['Today'],
                    datasets: [{
                        label: 'Daily Applications',
                        data: [dailyLoans],
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Applications'
                            }
                        }
                    }
                }
            });

            // Weekly Loans Chart
            const weeklyCtx = document.getElementById('weeklyLoansChart').getContext('2d');
            const weeklyChart = new Chart(weeklyCtx, {
                type: 'bar',
                data: {
                    labels: ['This Week'],
                    datasets: [{
                        label: 'Weekly Applications',
                        data: [weeklyLoans],
                        backgroundColor: 'rgba(255, 99, 132, 0.7)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Applications'
                            }
                        }
                    }
                }
            });

            // Monthly Loans Chart (Current Month)
            const monthlyCtx = document.getElementById('monthlyLoansChart').getContext('2d');
            const monthlyChart = new Chart(monthlyCtx, {
                type: 'bar',
                data: {
                    labels: ['This Month'],
                    datasets: [{
                        label: 'Monthly Applications',
                        data: [monthlyLoans],
                        backgroundColor: 'rgba(255, 206, 86, 0.7)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Applications'
                            }
                        }
                    }
                }
            });

            // Daily Trend Chart (Last 7 Days)
            const dailyTrendCtx = document.getElementById('dailyTrendChart').getContext('2d');
            const dailyTrendChart = new Chart(dailyTrendCtx, {
                type: 'line',
                data: {
                    labels: dailyTrendData.map(item => item.day),
                    datasets: [{
                        label: 'Daily Applications',
                        data: dailyTrendData.map(item => item.count),
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderWidth: 2,
                        pointRadius: 3,
                        pointBackgroundColor: 'rgba(54, 162, 235, 1)'
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Applications'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Day'
                            }
                        }
                    }
                }
            });

            // Weekly Trend Chart (Last 4 Weeks)
            const weeklyTrendCtx = document.getElementById('weeklyTrendChart').getContext('2d');
            const weeklyTrendChart = new Chart(weeklyTrendCtx, {
                type: 'line',
                data: {
                    labels: weeklyTrendData.map(item => item.week_label),
                    datasets: [{
                        label: 'Weekly Applications',
                        data: weeklyTrendData.map(item => item.count),
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderWidth: 2,
                        pointRadius: 3,
                        pointBackgroundColor: 'rgba(255, 99, 132, 1)'
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Applications'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Week'
                            }
                        }
                    }
                }
            });

            // Monthly Trend Chart (Last 6 Months)
            const trendCtx = document.getElementById('monthlyTrendChart').getContext('2d');
            const trendChart = new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: monthlyTrendData.map(item => item.month_year),
                    datasets: [{
                        label: 'Monthly Applications',
                        data: monthlyTrendData.map(item => item.count),
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 2,
                        pointRadius: 3,
                        pointBackgroundColor: 'rgba(75, 192, 192, 1)'
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Applications'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Month'
                            }
                        }
                    }
                }
            });
        </script>
    </div>
@endsection