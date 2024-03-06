@extends('header')
@extends('footer')

<body>

  <section class="user-register-page">
    <div class="register-page">
        <form class="form-register-page" action="/register" method="POST" enctype="multipart/form-data">
          @csrf
          <h2 style="text-align: center;">REGISTER PAGE</h2>

          <input name="username" type="text" placeholder="Create a Username" value="{{ old('username') }}">
          @error('username') <span class="error">{{ $message }}</span>@enderror

          <input name="password" type="password" placeholder="Create a Password" value="{{ old('password') }}">
          @error('password')<span class="error">{{ $message }}</span>@enderror

          <input name="email" type="text" placeholder="Enter an Email" value="{{ old('email') }}">
          @error('email')<span class="error">{{ $message }}</span>@enderror

          <input name="plate_number" type="text" placeholder="Insert your Plate Number" value="{{ old('plate_number') }}">
          @error('plate_number')<span class="error">{{ $message }}</span>@enderror

          <label for="image">Choose your Profile:</label>
          <input type="file" name="image" id="image">

          <button>Register</button>
          <p>Already have an account?<br><a href="login">Login</a> now!</p>
        </form>
    </div>
  </section>

</body>
