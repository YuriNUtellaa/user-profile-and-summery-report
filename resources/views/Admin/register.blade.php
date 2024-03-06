@extends('header')
@extends('footer')

<body>

  <section class="user-register-page">
    <div class="register-page">
        <form class="form-register-page" action="register-admin" method="POST" enctype="multipart/form-data">
          @csrf
          <h2 style="text-align: center;">ADMIN REGISTER PAGE</h2>

          <input name="username" type="text" placeholder="Create a Username" value="{{ old('username') }}">
          @error('username') <span class="error">{{ $message }}</span>@enderror

          <input name="password" type="password" placeholder="Create a Password" value="{{ old('password') }}">
          @error('password')<span class="error">{{ $message }}</span>@enderror

          <button>Register</button>
          <p>Authorized Perosonel Osnly</p>
        </form>
    </div>
  </section>

</body>
