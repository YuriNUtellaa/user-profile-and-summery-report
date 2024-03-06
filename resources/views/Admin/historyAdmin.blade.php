@extends('header')
@extends('footer')


<link rel="stylesheet" href="{{ asset('css/user.css') }}?v={{ time() }}">

<body>

    @auth('admin')
        <div class="history-container">
            <div class="history-header">
                ADMIN HISTORY
            </div>

            <section class="home-section">
                <div class="overall-slots">
                    <h3>Slot Rentals</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Slot ID</th>
                                <th>User ID</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($slotRentals as $slotRental)
                            <tr>
                                <td>{{ $slotRental->id }}</td>
                                <td>{{ $slotRental->slot_id }}</td>
                                <td>{{ $slotRental->user_id }}</td>
                                <td>
                                    <input type="datetime-local" name="start_time" value="{{ \Carbon\Carbon::parse($slotRental->start_time)->format('Y-m-d\TH:i') }}" form="update-form-{{ $slotRental->id }}" required>
                                </td>
                                <td>
                                    <input type="datetime-local" name="end_time" value="{{ \Carbon\Carbon::parse($slotRental->end_time)->format('Y-m-d\TH:i') }}" form="update-form-{{ $slotRental->id }}" required>
                                </td>
                                <td>
                                    <form id="update-form-{{ $slotRental->id }}" method="POST" action="{{ route('update-slot-rental', ['id' => $slotRental->id]) }}" style="display: inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="update-button">Update</button>
                                    </form>
                                    <form action="{{ route('delete-slot-rental', ['id' => $slotRental->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this slot rental?')" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-button">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <h3>Reservations</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Slot ID</th>
                                <th>User ID</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservations as $reservation)
                            <tr>
                                <td>{{ $reservation->id }}</td>
                                <td>{{ $reservation->slot_id }}</td>
                                <td>{{ $reservation->user_id }}</td>
                                <td>
                                    <input type="datetime-local" name="start_time" value="{{ \Carbon\Carbon::parse($reservation->start_time)->format('Y-m-d\TH:i') }}" form="update-form-reservation-{{ $reservation->id }}" required>
                                </td>
                                <td>
                                    <input type="datetime-local" name="end_time" value="{{ \Carbon\Carbon::parse($reservation->end_time)->format('Y-m-d\TH:i') }}" form="update-form-reservation-{{ $reservation->id }}" required>
                                </td>
                                <td>
                                    <form id="update-form-reservation-{{ $reservation->id }}" method="POST" action="{{ route('update-reservation', ['id' => $reservation->id]) }}" style="display: inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="update-button">Update</button>
                                    </form>
                                    <form action="{{ route('delete-reservation', ['id' => $reservation->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this reservation?')" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-button">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    @else
        <div class="history-container">
            <div class="history-header">
                ADMIN HISTORY
            </div>
            <section class="home-section">
                <div class="overall-slots">
                    <span>INVALID ADMIN AUTHENTICATION</span>
                </div>
            </section>
        </div>
    @endauth

</body>
</html>
