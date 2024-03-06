@extends('header')
@extends('footer')

<body>

<section class="section-rent">
    <div class="rent">
        <h2>Rent Slot</h2>
        <h3>Slot Number: {{ $slot->slot_number }}</h3>
        <p>Status: {{ $slot->status }}</p>
        <form action="{{ route('confirmRentAdmin') }}" method="POST">
            @csrf
            <input type="hidden" name="slot_id" value="{{ $slot->id }}">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="plate_number">Plate Number:</label>
                <input type="text" name="plate_number" id="plate_number" required>
            </div>
            <button type="submit">Confirm Rental</button>
            <a href="{{ route('slots-control-admin') }}" style="color: rgb(232, 113, 33)">Back</a>
        </form>
    </div>
</section>

</body>
</html>
