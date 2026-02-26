<!DOCTYPE html>
<html>
<head>
    <title>Mark Attendance</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #36b9cc, #4e73df);
            display: flex;
            justify-content: center;
            padding: 50px 0;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            width: 550px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        input[type="date"] {
            width: 100%;
            padding: 8px;
            margin: 10px 0 20px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .student-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f8f9fc;
            padding: 12px;
            margin-bottom: 10px;
            border-radius: 6px;
        }

        .student-name {
            font-weight: 600;
            width: 40%;
        }

        .student-select {
            width: 55%;
        }

        select {
            width: 100%;
            padding: 7px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            width: 100%;
            margin-top: 15px;
            padding: 10px;
            background: #4e73df;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 15px;
            cursor: pointer;
        }

        button:hover {
            background: #2e59d9;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Mark Attendance</h2>

    <form action="/attendance/store" method="POST">
        @csrf

        <label>Date:</label>
        <input type="date" name="date">

        @foreach($students as $student)
        <div class="student-row">
            <input type="hidden" name="student_id[]" value="{{ $student->id }}">

            <div class="student-name">
                {{ $student->name }}
            </div>

            <div class="student-select">
                <select name="status[]">
                    <option value="Present">Present</option>
                    <option value="Absent">Absent</option>
                </select>
            </div>
        </div>
        @endforeach

        <button type="submit">Save Attendance</button>
    </form>
</div>

</body>
</html>