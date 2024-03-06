@extends('header')
@extends('footer')

<body>

  <section class="user-login-page">
    <div class="login-page">
      
      <form class="form-login-page" action="/login" method="POST">
        @csrf
        <h2>LOGIN PAGE</h2>
        <input name="username" type="text" placeholder="Enter your Username">
        @error('username') <span class="error">{{ $message }}</span>@enderror
        <input name="password" type="password" placeholder="Enter your Password">
        @error('password') <span class="error">{{ $message }}</span>@enderror
        <button>Login</button>
        <p>Don't have account? <a href="register">Register</a> now!</p>
      </form>

    </div>
  </section>
  
</body>


