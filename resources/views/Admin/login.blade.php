@extends('header')
@extends('footer')

<body>
    <section class="user-login-page">
        <div class="login-page">
            <form class="form-login-page" action="{{ route('login-admin') }}" method="POST">
                @csrf
                <h2>ADMIN LOGIN PAGE</h2>
                <input name="username" type="text" placeholder="Enter your Username">
                @error('username') <span class="error">{{ $message }}</span>@enderror
                <input name="password" type="password" placeholder="Enter your Password">
                @error('password') <span class="error">{{ $message }}</span>@enderror
                <button>Login</button>
                <p>Administration Staffs Only</p>
            </form>
        </div>
    </section>
</body>
