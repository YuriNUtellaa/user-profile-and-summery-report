<?php

namespace App\Http\Controllers;

use App\Models\Slot;
use App\Models\SlotRental;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;

class SlotsController extends Controller
{
    public function index()
    {
        $slots = Slot::all();
        return view('home', compact('slots'));
    }

    public function slot()
    {
        $slots = Slot::all();
        return view('Users/slots', compact('slots'));
    }

    public function showRentForm(Slot $slot)
    {
        return view('Users/rent', compact('slot'));
    }

    public function showReserveForm(Slot $slot)
    {
        return view('Users/reserve', compact('slot'));
    }

// USER SIDE //////////////////////////////////////////////////////////////////

    public function confirmRent(Request $request)
    {
        // Check if the user already has an active rental
        $alreadyRented = SlotRental::where('user_id', auth()->id())
            ->whereNull('end_time')
            ->exists();
    
        if ($alreadyRented) {
            return redirect()->back()->withErrors(['error' => 'You already have an active rental.']);
        }
    
        // Proceed with renting the slot
        $slot = Slot::findOrFail($request->slot_id);
    
        // Update slot details
        $slot->status = 'occupied';
        $slot->updated_at = now();
        $slot->save();
    
        // Create a new SlotRental record
        $slotRental = new SlotRental();
        $slotRental->slot_id = $slot->id;
        $slotRental->user_id = auth()->id();
        $slotRental->start_time = now();
        $slotRental->save();
    
        // Redirect to the slots page after successful rental
        return redirect()->route('slots')->with('success', 'Slot rented successfully.');
    }
    
    public function endRent(Request $request, $slotId)
    {
        // Find the slot rental record
        $slotRental = SlotRental::where('slot_id', $slotId)
            ->whereNull('end_time')
            ->first();

        if (!$slotRental) {
            // No active rental found for the slot, return with an error message
            return redirect()->back()->withErrors(['error' => 'No active rental found for the specified slot.']);
        }

        // Update end time and update slot status
        $slotRental->update(['end_time' => now()]);
        $slot = Slot::findOrFail($slotId);
        $slot->update(['status' => 'available']);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Renting ended successfully.');
    }
    

    public function confirmReserve(Request $request)
    {
        // Check if the user already has an active reservation
        $alreadyReserved = Reservation::where('user_id', auth()->id())
            ->whereNull('end_time')
            ->exists();

        if ($alreadyReserved) {
            return redirect()->back()->withErrors(['error' => 'You already have an active reservation.']);
        }

        // Validate the form inputs
        $request->validate([
            'slot_id' => 'required',
            'user_id' => 'required',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        // Proceed with reserving the slot
        $slot = Slot::findOrFail($request->slot_id);

        // Update slot details
        $slot->status = 'reserved';
        $slot->updated_at = now();
        $slot->save();

        // Create a new Reservation record
        $reservation = new Reservation();
        $reservation->slot_id = $slot->id;
        $reservation->user_id = auth()->id();
        $reservation->start_time = $request->start_time;
        $reservation->end_time = $request->end_time;
        $reservation->save();

        // Redirect to the slots page after successful reservation
        return redirect()->route('slots')->with('success', 'Slot reserved successfully.');
    }

    




// ADMIN SIDE //////////////////////////////////////////////////////////////


    // RENT
    public function showRentAdminForm($slotId)
    {
        $slot = Slot::findOrFail($slotId);
        return view('Admin.rentAdmin', compact('slot'));
    }

    public function confirmRentAdmin(Request $request)
    {
        // Validate the form inputs
        $request->validate([
            'slot_id' => 'required',
            'username' => 'required|unique:users',
            'plate_number' => 'required|unique:users',
        ]);

        // Create a new user with type "irregular"
        $user = new User();
        $user->username = $request->username;
        $user->plate_number = $request->plate_number;
        $user->type = 'irregular';
        $user->save();

        // Update the slot status
        $slot = Slot::findOrFail($request->slot_id);
        $slot->status = 'occupied';
        $slot->updated_at = now();
        $slot->save();

        // Create a new SlotRental record
        $slotRental = new SlotRental();
        $slotRental->slot_id = $slot->id;
        $slotRental->user_id = $user->id;
        $slotRental->start_time = now();
        $slotRental->save();

        // Redirect to the admin slots control page after successful rental
        return redirect()->route('slots-control-admin')->with('success', 'Slot rented successfully to irregular user.');
    }

    public function endRentingAdmin(Request $request, $slotId)
    {
        // Find the slot rental record
        $slotRental = SlotRental::where('slot_id', $slotId)
            ->whereNull('end_time')
            ->first();

        if (!$slotRental) {
            // No active rental found for the slot, return with an error message
            return redirect()->back()->withErrors(['error' => 'No active rental found for the specified slot.']);
        }

        // Update end time and update slot status
        $slotRental->update(['end_time' => now()]);
        $slot = Slot::findOrFail($slotId);
        $slot->update(['status' => 'available']);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Renting ended successfully.');
    }

    // RESERVE 
    public function showReserveAdminForm($slotId)
    {
        $slot = Slot::findOrFail($slotId);
        $regularUsers = User::where('type', 'regular')->get();
        return view('Admin.reserveAdmin', compact('slot', 'regularUsers'));
    }

    public function confirmReserveAdmin(Request $request)
    {
        // Validate the form inputs
        $request->validate([
            'slot_id' => 'required',
            'user_id' => 'required|exists:users,id,type,regular',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);
    
        // Update the slot status
        $slot = Slot::findOrFail($request->slot_id);
        $slot->status = 'reserved';
        $slot->updated_at = now();
        $slot->save();
    
        // Create a new Reservation record
        $reservation = new Reservation();
        $reservation->slot_id = $slot->id;
        $reservation->user_id = $request->user_id;
        $reservation->start_time = $request->start_time;
        $reservation->end_time = $request->end_time;
        $reservation->save();
    
        // Redirect to the admin slots control page after successful reservation
        return redirect()->route('slots-control-admin')->with('success', 'Slot reserved successfully for regular user.');
    }
    


    

}
