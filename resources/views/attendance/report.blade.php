<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Attendance Report</title>
<style>
body {
    font-family: Arial, sans-serif;
    background: linear-gradient(to right, #1cc88a, #36b9cc);
    padding: 40px;
    display: flex;
    justify-content: center;
}
.container {
    background: #ffffff;
    padding: 30px;
    border-radius: 10px;
    width: 950px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}
h2 { text-align: center; margin-bottom: 20px; }
form { margin-bottom: 20px; display:flex; gap:10px; align-items:center; }
input[type="date"] { padding: 8px; border:1px solid #ccc; border-radius:5px; outline:none; }
button { padding: 8px 15px; background-color:#4e73df; border:none; color:white; border-radius:5px; cursor:pointer; }
button:hover { background-color:#2e59d9; }
.cards { display:flex; gap:20px; margin-bottom:20px; flex-wrap:wrap; }
.card { flex:1; color:white; padding:15px; border-radius:8px; text-align:center; }
.present { background:#28a745; }
.absent { background:#dc3545; }
.table-container { overflow-x:auto; }
table { width:100%; border-collapse: collapse; margin-top:15px; }
table th, table td { padding:10px; text-align:center; }
table th { background-color:#4e73df; color:white; }
table tr:nth-child(even) { background-color:#f8f9fc; }
table tr:hover { background-color:#e2e6ea; }
.low { color:red; font-weight:bold; }
.good { color:green; font-weight:bold; }
</style>
</head>
<body>
<div class="container">
<h2>Attendance Report</h2>

{{-- Filter Form --}}
<form method="GET" action="/report">
    <label>Filter by Date:</label>
    <input type="date" name="date" value="{{ request('date') }}">
    <button type="submit">Search</button>
</form>

@php
    // Filter out attendance records without student
    $attendances = $attendances->filter(fn($a) => $a->student != null);

    // Daily totals
    $totalPresent = $attendances->where('status','Present')->count();
    $totalAbsent  = $attendances->where('status','Absent')->count();

    // Group by student
    $students = $attendances->groupBy('student_id');

    // Monthly summary (passed from Controller)
    $monthlyPresent = $monthlyPresent ?? 0;
    $monthlyAbsent = $monthlyAbsent ?? 0;
    $monthlyPercentage = $monthlyPercentage ?? 0;
@endphp

{{-- Monthly Summary --}}
<div class="cards">
    <div class="card present">
        <h3>📅 This Month Present</h3>
        <h2>{{ $monthlyPresent }}</h2>
    </div>
    <div class="card absent">
        <h3>📅 This Month Absent</h3>
        <h2>{{ $monthlyAbsent }}</h2>
    </div>
    <div class="card" style="background:#1cc88a;">
        <h3>📊 Monthly Attendance %</h3>
        <h2>{{ number_format($monthlyPercentage,2) }} %</h2>
    </div>
</div>

{{-- Daily Totals --}}
<div class="cards">
    <div class="card present">
        <h3>✅ Total Present</h3>
        <h2>{{ $totalPresent }}</h2>
    </div>
    <div class="card absent">
        <h3>❌ Total Absent</h3>
        <h2>{{ $totalAbsent }}</h2>
    </div>
</div>

{{-- Attendance Table --}}
<div class="table-container">
<table>
    <tr>
        <th>Name</th>
        <th>Total Days</th>
        <th>Present</th>
        <th>Percentage</th>
    </tr>
    @forelse($students as $records)
        @php
            $student = $records->first()->student;
            $total = $records->count();
            $present = $records->where('status', 'Present')->count();
            $percentage = $total > 0 ? ($present / $total) * 100 : 0;
        @endphp
        <tr>
            <td>{{ $student->name ?? 'Deleted Student' }}</td>
            <td>{{ $total }}</td>
            <td>{{ $present }}</td>
            <td class="{{ $percentage < 75 ? 'low' : 'good' }}">
                {{ number_format($percentage,2) }} %
            </td>
        </tr>
    @empty
        <tr><td colspan="4">No attendance records found.</td></tr>
    @endforelse
</table>
</div>
</div>
</body>
</html>