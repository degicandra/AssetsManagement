<script>
// Simple and reliable chart initialization
function initDashboardCharts() {
    // Check if Chart.js is available
    if (typeof Chart === 'undefined') {
        console.error('Chart.js not loaded');
        return;
    }

    // Asset Status Distribution - Doughnut Chart
    const statusCtx = document.getElementById('assetStatusChart');
    if (statusCtx) {
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Ready', 'Deployed', 'Archive', 'Broken', 'Service', 'Disposal', 'Disposed'],
                datasets: [{
                    data: [
                        {{ $readyToDeploy }},
                        {{ $deployed }},
                        {{ $archive }},
                        {{ $broken }},
                        {{ $inService }},
                        {{ $requestDisposal }},
                        {{ $disposed }}
                    ],
                    backgroundColor: [
                        '#10B981', // green
                        '#3B82F6', // blue
                        '#F59E0B', // amber
                        '#EF4444', // red
                        '#8B5CF6', // purple
                        '#F97316', // orange
                        '#6B7280'  // gray
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            usePointStyle: true,
                            font: {
                                size: 11
                            },
                            color: function(context) {
                                return document.documentElement.classList.contains('dark') ? '#f0f0f0' : '#1a1a1a';
                            }
                        }
                    }
                }
            }
        });
    }

    // Department Distribution - Bar Chart
    const deptCtx = document.getElementById('departmentChart');
    if (deptCtx) {
        new Chart(deptCtx, {
            type: 'bar',
            data: {
                labels: [
                    @foreach($departmentCounts as $dept)
                        '{{ $dept->name }}',
                    @endforeach
                ],
                datasets: [{
                    label: 'Assets',
                    data: [
                        @foreach($departmentCounts as $dept)
                            {{ $dept->count }},
                        @endforeach
                    ],
                    backgroundColor: '#10B981',
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: function(context) {
                                return document.documentElement.classList.contains('dark') ? '#f0f0f0' : '#1a1a1a';
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: function(context) {
                                return document.documentElement.classList.contains('dark') ? '#f0f0f0' : '#1a1a1a';
                            }
                        }
                    }
                }
            }
        });
    }

    // Monthly Asset Trends - Line Chart
    const monthlyCtx = document.getElementById('monthlyTrendsChart');
    if (monthlyCtx) {
        new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Assets Added',
                    data: {!! $monthlyAssetsTrend !!},
                    borderColor: '#10B981',
                    backgroundColor: 'rgba(69, 241, 184, 0.87)',
                    borderWidth: 2,
                    pointBackgroundColor: '#10B981',
                    pointRadius: 4,
                    fill: false,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            font: {
                                size: 11
                            },
                            color: function(context) {
                                return document.documentElement.classList.contains('dark') ? '#f0f0f0' : '#1a1a1a';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: function(context) {
                                return document.documentElement.classList.contains('dark') ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.05)';
                            }
                        },
                        ticks: {
                            color: function(context) {
                                return document.documentElement.classList.contains('dark') ? '#f0f0f0' : '#1a1a1a';
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: function(context) {
                                return document.documentElement.classList.contains('dark') ? '#f0f0f0' : '#1a1a1a';
                            }
                        }
                    }
                }
            }
        });
    }

    // Asset Damage Trends - Bar Chart
    const damageCtx = document.getElementById('damageTrendsChart');
    if (damageCtx) {
        new Chart(damageCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Broken Assets',
                    data: {!! $monthlyBrokenTrend !!},
                    backgroundColor: '#EF4444',
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            font: {
                                size: 11
                            },
                            color: function(context) {
                                return document.documentElement.classList.contains('dark') ? '#f0f0f0' : '#1a1a1a';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: function(context) {
                                return document.documentElement.classList.contains('dark') ? '#f0f0f0' : '#1a1a1a';
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: function(context) {
                                return document.documentElement.classList.contains('dark') ? '#f0f0f0' : '#1a1a1a';
                            }
                        }
                    }
                }
            }
        });
    }
}

// Initialize charts when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initDashboardCharts);
} else {
    initDashboardCharts();
}

// Watch for dark mode changes and update charts
function updateChartColors() {
    // Destroy existing charts first
    if (typeof Chart !== 'undefined') {
        Chart.helpers.each(Chart.instances, function(instance) {
            instance.destroy();
        });
    }
    // Reinitialize charts with new colors
    setTimeout(initDashboardCharts, 50);
}

// Listen for dark mode toggle
document.addEventListener('darkModeToggled', updateChartColors);

// Also watch for class changes on html element
const darkModeObserver = new MutationObserver(function(mutations) {
    mutations.forEach(function(mutation) {
        if (mutation.attributeName === 'class') {
            updateChartColors();
        }
    });
});

darkModeObserver.observe(document.documentElement, {
    attributes: true,
    attributeFilter: ['class']
});
</script>
