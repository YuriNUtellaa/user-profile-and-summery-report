@extends('header')
@extends('footer')

<body>

  <section class="section-rent">
    
    <div class="rent">
      <h2>Rent Slot</h2>
      <h3>Slot Number: {{ $slot->slot_number }}</h3>
      <p>Status: {{ $slot->status }}</p>

      @if ($errors->any())
        <div class="error-message">
          <p name="error">{{ $errors->first('error') }}</p>
        </div>
      @endif

      <form action="{{ route('confirm-rent') }}" method="POST">
        @csrf
        <input type="hidden" name="slot_id" value="{{ $slot->id}}">
        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
        <button name="details" type="submit">Confirm Rental</button>
        <a href="{{ route('slots') }}" style="color: rgb(232, 113, 33)">Back</a>
      </form>
    </div>

  </section>

</body>
</html>
