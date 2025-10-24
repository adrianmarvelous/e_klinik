<?php

namespace App\Http\Controllers\Medical;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Rules\SafeInput;
use App\Models\Appoinment\Appoinments;

class Attendance extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'date' => ['nullable', 'date', new SafeInput],
        ]);

        // Use validated date or default to today
        $date = $validated['date'] ?? date('Y-m-d');

        // Just call the model scope
        $data = Appoinments::withAttendanceDate($date)->get();

        return view('attendance.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'appointment_id' => ['required', 'numeric', new SafeInput],
        ]);

        $update = Appoinments::where('id',$validated['appointment_id'])
            ->update(['attendance' => now(),
                      'status' => 'Attended']);

        return redirect()
            ->route('attendance.index')
            ->with('success', 'Daftar hadir berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
