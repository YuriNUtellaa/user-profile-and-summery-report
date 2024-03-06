@extends('header')
@extends('footer')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Summary Report</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>
<body>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Summary Report</h1>

        <section>
            <h2>Rental Record (Mainly for Irregular Users)</h2>
            <table class="table table-bordered">

                    <thead>
                        <tr>
                            <th>Rental ID</th>
                            <th>Slot ID</th>
                            <th>User Name</th>
                            <th>Total Hours</th>
                            <th>Rate per Hour</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rentals as $rental)
                        <tr>
                            <td>{{ $rental->id }}</td>
                            <td>{{ $rental->slot_id ?? 'Slot not found' }}</td>
                            <td>{{ optional($rental->user)->username ?? 'User not found' }}</td>
                            <td>{{ $rental->total_hours }}</td>
                            <td>₱{{ $rental->per_hour_rate }}</td> {{-- Ensure per_hour_rate is displayed --}}
                            <td>₱{{ number_format($rental->total, 2) }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center">No rental records found.</td></tr>
                        @endforelse
                    </tbody>

            </table>
        </section>

        <section>
            <h2>Reservation Record</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Reservation ID</th>
                        <th>Slot ID</th>
                        <th>User Name</th>
                        <th>Total Hours</th>
                        <th>Rate per Hour</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->id }}</td>
                        <td>{{ $reservation->slot_id ?? 'Slot not found' }}</td>
                        <td>{{ optional($reservation->user)->username ?? 'User not found' }}</td>
                        <td>{{ $reservation->total_hours }}</td>
                        <td>₱{{ $reservation->per_hour_rate }}</td>
                        <td>₱{{ number_format($reservation->total, 2) }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center">No reservation records found.</td></tr>
                    @endforelse
                    <tr>
                        <td colspan="5" class="text-right"><strong>Grand Total:</strong></td>
                        <td><strong>₱{{ number_format($grandTotalReservation, 2) }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </section>

        <section>
            <h2>Monthly Subscription of Regular Users</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>User Name</th>
                        <!-- Removed Slot ID from here -->
                        <th>Monthly Payment</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($regularUsers as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->username }}</td>
                        <!-- Removed Slot ID from here -->
                        <td>₱{{ number_format($user->monthly_payment, 2) }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-center">No regular user records found.</td></tr>
                    @endforelse
                    <tr>
                        <td colspan="2" class="text-right"><strong>Grand Total:</strong></td>
                        <td><strong>₱{{ number_format($grandTotalRegular, 2) }}</strong></td>
                    </tr>
                </tbody>
            </table>
            <div class="text-center">
                <a href="{{ route('admin.generate-summary-report') }}" class="btn btn-primary">
                    Download Summary Report as PDF
                </a>
            </div>
        </section>


    </div>

</body>
</html>
