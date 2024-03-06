<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Summary Report</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 0;
            background: #f8f9fa;
        }
        .container {
            padding: 20px;
            background: #fff;
        }
        .text-center {
            text-align: center;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table, .table th, .table td {
            border: 1px solid #dee2e6;
        }
        .table th, .table td {
            padding: 12px 15px;
            text-align: left;
        }
        .table thead {
            background-color: rgb(74, 83, 118);
            color: #ffffff;
        }
        .table thead th {
            font-weight: normal;
        }
        .text-right {
            text-align: right;
        }
        .table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .table tbody tr td {
            font-size: 0.9em;
        }
        .text-title {
            margin-bottom: 0;
            color: #333333;
            font-size: 2em;
        }
        h2 {
            background-color: rgb(74, 83, 118);
            color: white;
            padding: 10px;
            border-radius: 5px;
        }
        .grand-total {
            background-color: #343a40;
            color: white;
        }

        .footer {
            text-align: center;
            padding: 10px;
            background-color: #fff;
            position: fixed;
            bottom: 0;
            width: 100%;
            font-size: 0.8em;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1 class="text-center mb-4">Summary Report</h1>

        <!-- Rental Record Section -->
        <section>
            <h2>Rental Record (Mainly for Irregular Users)</h2>
            <table class="table">
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
                        <td>₱{{ $rental->per_hour_rate }}</td>
                        <td>₱{{ number_format($rental->total, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No rental records found.</td>
                    </tr>
                    @endforelse
                    <tr>
                        <td colspan="5" class="text-right"><strong>Grand Total:</strong></td>
                        <td><strong>₱{{ number_format($grandTotalRental, 2) }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </section>

        <!-- Reservation Record Section -->
        <section>
            <h2>Reservation Record</h2>
            <table class="table">
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
                    <tr>
                        <td colspan="6" class="text-center">No reservation records found.</td>
                    </tr>
                    @endforelse
                    <tr>
                        <td colspan="5" class="text-right"><strong>Grand Total:</strong></td>
                        <td><strong>₱{{ number_format($grandTotalReservation, 2) }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </section>

        <!-- Monthly Subscription Section -->
        <section>
            <h2>Monthly Subscription of Regular Users</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>User Name</th>
                        <th>Monthly Payment</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($regularUsers as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->username }}</td>
                        <td>₱{{ number_format($user->monthly_payment, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center">No regular user records found.</td>
                    </tr>
                    @endforelse
                    <tr>
                        <td colspan="2" class="text-right"><strong>Grand Total:</strong></td>
                        <td><strong>₱{{ number_format($grandTotalRegular, 2) }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </section>

    </div>

    </body>
    </html>
