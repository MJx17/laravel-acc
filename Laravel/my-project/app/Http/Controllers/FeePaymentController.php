<?php

namespace App\Http\Controllers;

use App\Models\FeePayment;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class FeePaymentController extends Controller
{
    // Show all fee payments
    public function index()
    {
        $feePayments = FeePayment::all();
        return view('fees.index', compact('feePayments'));
    }

    // Show a specific fee payment
    public function show($id)
    {
        $feePayment = FeePayment::findOrFail($id);
        return view('fees.show', compact('feePayment'));
    }

    // Create a new fee payment
    public function create()
    {
        $enrollments = Enrollment::all(); // Get all enrollments to associate with fee payment
        return view('fees.create', compact('enrollments'));
    }

    // Store a new fee payment
    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'enrollment_id' => 'required|exists:enrollments,id',
            'tuition_fee' => 'required|numeric',
            'lab_fee' => 'required|numeric',
            'miscellaneous_fee' => 'required|numeric',
            'other_fee' => 'nullable|numeric',
            'initial_payment' => 'required|numeric',
            'prelims_payment' => 'required|numeric',
            'midterms_payment' => 'required|numeric',
            'pre_final_payment' => 'required|numeric',
            'final_payment' => 'required|numeric',
        ]);

        // Create the fee payment record
        FeePayment::create($request->all());

        // Redirect to the fee payments list
        return redirect()->route('fees.index')->with('success', 'Fee Payment created successfully.');
    }

    // Edit a fee payment
    public function edit($id)
    {
        $feePayment = FeePayment::findOrFail($id);
        $enrollments = Enrollment::all(); // Get all enrollments for dropdown
        return view('fees.edit', compact('feePayment', 'enrollments'));
    }

    // Update a fee payment
    public function update(Request $request, $id)
    {
        // Validate the input
        $request->validate([
            'enrollment_id' => 'required|exists:enrollments,id',
            'tuition_fee' => 'required|numeric',
            'lab_fee' => 'required|numeric',
            'miscellaneous_fee' => 'required|numeric',
            'other_fee' => 'nullable|numeric',
            'initial_payment' => 'required|numeric',
            'prelims_payment' => 'required|numeric',
            'midterms_payment' => 'required|numeric',
            'pre_final_payment' => 'required|numeric',
            'final_payment' => 'required|numeric',
        ]);

        // Find the fee payment record
        $feePayment = FeePayment::findOrFail($id);

        // Update the fee payment record
        $feePayment->update($request->all());

        // Redirect to the fee payments list
        return redirect()->route('fees.index')->with('success', 'Fee Payment updated successfully.');
    }

    // Delete a fee payment
    public function destroy($id)
    {
        $feePayment = FeePayment::findOrFail($id);
        $feePayment->delete();

        return redirect()->route('fees.index')->with('success', 'Fee Payment deleted successfully.');
    }
}
