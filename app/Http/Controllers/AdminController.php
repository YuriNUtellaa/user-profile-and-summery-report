<?php

namespace App\Http\Controllers;

use App\Models\Slot;
use App\Models\User;
use App\Models\Admin;
use App\Models\SlotRental;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('Admin.login');
    }

    public function showAdminSlot()
    {
        $slots = Slot::all();
        $rentals = SlotRental::with('user')->whereNull('end_time')->get();
        $reservations = Reservation::with('user')->whereNull('end_time')->get();
        return view('Admin.slotsControl', compact('slots', 'rentals', 'reservations'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->intended('/slots-control-admin');
        } else {
            return back()->withErrors(['error' => 'Invalid username or password']);
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function showRegistrationForm()
    {
        return view('Admin.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:admins',
            'password' => 'required|min:6',
        ]);

        try {
            $admin = new Admin();
            $admin->username = $request->username;
            $admin->password = bcrypt($request->password);
            $admin->save();

            return redirect()->route('login-admin')->with('success', 'Admin registration successful. Please log in.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to register admin. Please try again.']);
        }
    }

    // RENT & RESERVATION HISTORY

    public function showAdminHistory()
    {
        $slotRentals = SlotRental::with('user')->orderBy('created_at', 'desc')->get();
        $reservations = Reservation::with('user')->orderBy('created_at', 'desc')->get();

        return view('Admin.historyAdmin', compact('slotRentals', 'reservations'));
    }

        // DELETE FUNCTION

            public function deleteSlotRental($id)
            {
                $slotRental = SlotRental::findOrFail($id);
                $slotRental->delete();
                return back()->with('success', 'Slot rental deleted successfully.');
            }

            public function deleteReservation($id)
            {
                $reservation = Reservation::findOrFail($id);
                $reservation->delete();
                return back()->with('success', 'Reservation deleted successfully.');
            }

        // UPDATE FUNCTION

            public function updateSlotRental(Request $request, $id)
            {
                $request->validate([
                    'start_time' => 'required|date',
                    'end_time' => 'required|date|after_or_equal:start_time',
                ]);

                $slotRental = SlotRental::findOrFail($id);
                $slotRental->update([
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                ]);

                return back()->with('success', 'Slot rental updated successfully.');
            }

            public function updateReservation(Request $request, $id)
            {
                $request->validate([
                    'start_time' => 'required|date',
                    'end_time' => 'required|date|after_or_equal:start_time',
                ]);

                $reservation = Reservation::findOrFail($id);
                $reservation->update([
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                ]);

                return back()->with('success', 'Reservation updated successfully.');
            }

    // USERMANAGEMENT

    public function showUserManagement()
    {
        $users = User::all(); // Fetch all users
        return view('Admin/usermanagementAdmin', compact('users')); // Pass users to the view
    }

    public function updateUser(Request $request, User $user)
    {
        // Validate the input
        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|nullable|min:6',
            'plate_number' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update the user
        $user->username = $validatedData['username'];
        $user->email = $validatedData['email'];
        if ($validatedData['password']) {
            $user->password = bcrypt($validatedData['password']);
        }
        $user->plate_number = $validatedData['plate_number'];
        $user->type = $validatedData['type'];

        if ($request->hasFile('image')) {
            $imageName = $user->id . '_' . time() . '.' . $request->image->extension();
            $request->image->move(public_path('profiles'), $imageName);
            $user->image = $imageName;
        }

        $user->save();

        return redirect()->route('admin.user-management')->with('success', 'User updated successfully.');
    }

    public function deleteUser(User $user)
        {
            $user->delete(); // This deletes the user from the database
            return redirect()->route('admin.user-management')->with('success', 'User deleted successfully.');
        }

//summery

public function showSummary() {
    $ratePerHour = 50;
    $fixedMonthlyPayment = 4500;

    $rentals = SlotRental::with(['user', 'slot'])
                    ->selectRaw('slot_rentals.id, slot_rentals.slot_id, user_id, SUM(TIMESTAMPDIFF(HOUR, start_time, end_time)) as total_hours')
                    ->groupBy('slot_rentals.id', 'slot_rentals.slot_id', 'user_id')
                    ->get()
                    ->each(function ($rental) use ($ratePerHour) {
                        $rental->per_hour_rate = $ratePerHour;
                        $rental->total = $rental->total_hours * $ratePerHour;
                    });

    $reservations = Reservation::with(['user', 'slot'])
                    ->selectRaw('reservations.id, reservations.slot_id, user_id, SUM(TIMESTAMPDIFF(HOUR, start_time, end_time)) as total_hours')
                    ->groupBy('reservations.id', 'reservations.slot_id', 'user_id')
                    ->get()
                    ->each(function ($reservation) use ($ratePerHour) {
                        $reservation->per_hour_rate = $ratePerHour;
                        $reservation->total = $reservation->total_hours * $ratePerHour;
                    });

    $grandTotalRental = $rentals->sum('total');
    $grandTotalReservation = $reservations->sum('total');

    $regularUsers = User::where('type', 'regular')
                    ->with('slot')
                    ->get()
                    ->each(function ($user) use ($fixedMonthlyPayment) {
                        $user->monthly_payment = $fixedMonthlyPayment;
                        $user->slot_id = $user->slot ? $user->slot->id : 'No slot';
                    });

    $grandTotalRegular = $regularUsers->sum('monthly_payment');

    return view('Admin.summary', [
        'rentals' => $rentals,
        'reservations' => $reservations,
        'regularUsers' => $regularUsers,
        'grandTotalRental' => $grandTotalRental,
        'grandTotalReservation' => $grandTotalReservation,
        'grandTotalRegular' => $grandTotalRegular
    ]);
}





public function generateSummaryReportPDF() {
    // Prepare the data para sa pdf
    $rentals = SlotRental::with(['user', 'slot'])
                    ->selectRaw('slot_rentals.id, slot_rentals.slot_id, user_id,
                                SUM(TIMESTAMPDIFF(HOUR, start_time, end_time)) as total_hours')
                    ->groupBy('slot_rentals.id', 'slot_rentals.slot_id', 'user_id')
                    ->get()
                    ->each(function ($rental) {
                        $rental->per_hour_rate = 50; // 50 pesos per hour
                        $rental->total = $rental->total_hours * $rental->per_hour_rate;
                    });

    $reservations = Reservation::with(['user', 'slot'])
                    ->selectRaw('reservations.id, reservations.slot_id, user_id,
                                SUM(TIMESTAMPDIFF(HOUR, start_time, end_time)) as total_hours')
                    ->groupBy('reservations.id', 'reservations.slot_id', 'user_id')
                    ->get()
                    ->each(function ($reservation) {
                        $reservation->per_hour_rate = 50; // 50 pesos per hour
                        $reservation->total = $reservation->total_hours * $reservation->per_hour_rate;
                    });

    $regularUsers = User::where('type', 'regular')
                    ->get()
                    ->each(function ($user) {
                        $user->monthly_payment = 4500; // Fixed monthly payment for regular users
                    });

    $data = [
        'rentals' => $rentals,
        'reservations' => $reservations,
        'regularUsers' => $regularUsers,
        'grandTotalRental' => $rentals->sum('total'),
        'grandTotalReservation' => $reservations->sum('total'),
        'grandTotalRegular' => $regularUsers->sum('monthly_payment')
    ];

    // Generate PDF

    $pdf = PDF::loadView('pdf.summary', $data); // Make sure you have the correct view file
    return $pdf->download('summary-report.pdf'); // DOWNLOAD NG PUTANGINANG PDF NA YAN
}

}
