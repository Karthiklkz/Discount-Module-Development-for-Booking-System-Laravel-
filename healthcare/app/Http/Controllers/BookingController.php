<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Discount;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // Display the booking form
    public function create()
    {
        $users = User::all();
        $doctors = Doctor::all();
        $discounts = Discount::all();

        return view('bookings.create', compact('users', 'doctors', 'discounts'));
    }

    // Store booking data
    public function store(Request $request)
    {
        // Validate request data
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'base_cost' => 'required|numeric',
            'discount_id' => 'nullable|exists:discounts,id',
        ]);

        // Original cost (you might fetch it based on the doctor or service)
        $original_cost = $validatedData['base_cost'];
        $final_cost = $original_cost;

        // Fetch discount details if a discount is applied
        if (isset($validatedData['discount_id'])) {
            $discount = Discount::find($validatedData['discount_id']);
            if ($discount) {
                if ($discount->type === 'percentage') {
                    $final_cost -= ($original_cost * ($discount->value / 100));
                } elseif ($discount->type === 'amount') {
                    $final_cost -= $discount->value;
                }
            }
        }

        // Ensure final cost does not go below zero
        $final_cost = max($final_cost, 0);

        // Create the booking
        Booking::create([
            'user_id' => $validatedData['user_id'],
            'doctor_id' => $validatedData['doctor_id'],
            'appointment_date' => $validatedData['appointment_date'],
            'original_cost' => $original_cost,
            'final_cost' => $final_cost,
            'discount_id' => $validatedData['discount_id'],
        ]);

        return redirect()->back()->with('success', 'Booking successful! Your final cost is: ₹' . number_format($final_cost, 2));
    }
}
