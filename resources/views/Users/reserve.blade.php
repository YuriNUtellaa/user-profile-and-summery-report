@extends('header')
@extends('footer')

<body>

  <section class="section-rent">
    
    <div class="rent">
      <h2>Reserve Slot</h2>
      <h3>Slot Number: {{ $slot->slot_number }}</h3>
      <p>Status: {{ $slot->status }}</p>

      @if ($errors->any())
        <div class="error-message">
          <p name="error">{{ $errors->first('error') }}</p>
        </div>
      @endif

      <form action="{{ route('confirm-reserve') }}" method="POST">
        @csrf
        <input type="hidden" name="slot_id" value="{{ $slot->id }}">
        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

        <label for="start_time">Start Time:</label>
        <input type="datetime-local" id="start_time" name="start_time" required>
        <label for="end_time">End Time:</label>
        <input type="datetime-local" id="end_time" name="end_time" required>
        
        <button type="submit" name="orange">Confirm Reservation</button>
        <a href="{{ route('slots') }}" style="color: rgb(232, 113, 33)">Back</a>
      </form>
    </div>

  </section>

</body>
</html>
