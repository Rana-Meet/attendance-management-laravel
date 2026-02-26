<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(){
        return view('welcome');
    }

    public function create(){
        return view('student.create');
    }

    public function store(Request $request){
        Student::create($request->all());
        return redirect('/student/create')->with("success","Successfully Added");
    }

    public function markAttendance(){
        $students = Student::all();
        return view('attendance.mark', compact('students'));
    } 

    public function storeAttendance(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'student_id' => 'required|array',
            'status' => 'required|array'
        ]);

        foreach ($request->student_id as $key => $student) {
            Attendance::create([
                'student_id' => $student,
                'date' => $request->date,
                'status' => $request->status[$key]
            ]);
        }

        return back()->with('success', 'Attendance Saved');
    }

    public function report(Request $request)
    {
        // Filtered attendance (by date if provided)
        $query = Attendance::with('student');
        if ($request->date) {
            $query->whereDate('date', $request->date);
        }
        $attendances = $query->get()->filter(fn($a) => $a->student != null);

        // Daily totals
        $totalPresent = $attendances->where('status','Present')->count();
        $totalAbsent = $attendances->where('status','Absent')->count();

        // Group by student for table
        $students = $attendances->groupBy('student_id');

        // Monthly summary
        $currentMonth = Carbon::now()->month;
        $monthlyAttendances = Attendance::with('student')
            ->whereMonth('date', $currentMonth)
            ->get()
            ->filter(fn($a) => $a->student != null);

        $monthlyPresent = $monthlyAttendances->where('status','Present')->count();
        $monthlyAbsent = $monthlyAttendances->where('status','Absent')->count();
        $monthlyPercentage = $monthlyAttendances->count() > 0
            ? ($monthlyPresent / $monthlyAttendances->count()) * 100
            : 0;

        return view('attendance.report', compact(
            'attendances',
            'totalPresent',
            'totalAbsent',
            'students',
            'monthlyPresent',
            'monthlyAbsent',
            'monthlyPercentage'
        ));
    }
}