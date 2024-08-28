@extends('admin.layouts')
@section('content')
<div class="container">
    <div class="row">
        <div class="my-3">
            <form method="GET" class="flex gap-3">
                <div class="form-group w-full">
                    <select name="search" class="form-control">
                        <option value="">Select</option>
                        <option value="daily">Daily</option>
                        <option value="weekly">Weekly</option>
                        <option value="monthly">Monthly</option>
                        <option value="year">Yearly</option>
                    </select>
                </div>
                <div class="form-group w-full">
                    <button class="bg-sky-700 text-white hover:bg-sky-600 btn" type="submit" class="form-control">Search</button>
                </div>
            </form>
        </div>
       <div class="my-2" style="height: 600px; width:100%;">
        <canvas id="myChart" width="600" height="400"></canvas>

       </div>
        <div class="card mb-4">
            <div class="card-body">
                @if ($search)
                <p class="font-bold text-lg">Month of {{ $search }}</p>
                @endif
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Income</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalIncome = 0;
                        @endphp
                        @foreach ($incomes as $income)
                        <tr>
                            <td>{{ date('M d , Y', strtotime($income->date_at)) }}</td>
                            <td>₱ {{ number_format($income->partial) }}</td>
                        </tr>
                        @php
                            $totalIncome += $income->partial;
                        @endphp
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    <p class="font-bold">Total Income: ₱ {{ number_format($totalIncome) }}</p>
                </div>
                <div class="mt-4">
                    {{ $incomes->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // Sample data for daily, weekly, and monthly
    const dailyData = @json($dailychart);
    const weeklyData =  @json($weeklychart);
    const monthlyData =  @json($monthlychart);

    const values = @json($values);

    const convertedValues = values.map(convertDateToReadableFormatWithYear);

    // Get the canvas element
    const ctx = document.getElementById('myChart').getContext('2d');

    // Create a new chart
    const myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: convertedValues,
            datasets: [
                {
                    label: 'Daily',
                    data: dailyData,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2,
                    fill: false
                },
                {
                    label: 'Weekly',
                    data: weeklyData,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: false
                },
                {
                    label: 'Monthly',
                    data: monthlyData,
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 2,
                    fill: false
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
            legend: {
                display: false  // Set to false to hide the legend
            }
        }
        }
    });


function convertDateToReadableFormatWithYear(dateString) {
    const [year, month, day] = dateString.split('-');

    const monthNames = [
        "January", "February", "March", "April",
        "May", "June", "July", "August",
        "September", "October", "November", "December"
    ];

    const monthName = monthNames[parseInt(month) - 1];

    return `${monthName} ${day}, ${year}`;
}

</script>
@endsection
