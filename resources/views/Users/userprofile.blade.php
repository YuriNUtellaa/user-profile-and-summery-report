@extends('header')
@extends('footer')


<link href="{{ asset('css/user.css') }}" rel="stylesheet">

<section class="content">
    <div class="user-profile-container">
        <h1>User Profile</h1>
 <!-- Display success message -->
 @if (session('success'))
 <div class="alert alert-success">
     Updated!!
 </div>
@endif
<!-- Display errors -->
@if ($errors->any())
 <div class="alert alert-danger">
     <ul>
         @foreach ($errors->all() as $error)
             <li>{{ $error }}</li>
         @endforeach
     </ul>
 </div>
@endif
<!-- Display current profile image if exists -->
@if(auth()->user()->image)
    <div class="current-profile-image">
        <img src="{{ asset('images/'.auth()->user()->image) }}" alt="Profile Image">
    </div>
@endif

<form action="{{ route('user.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

            <label for="username">Username:</label>
            <input type="text" name="username" value="{{ auth()->user()->username }}" required>

            <label for="email">Email:</label>
            <input type="email" name="email" value="{{ auth()->user()->email }}" required>

            <label for="password">Password:</label>
            <input type="password" name="password" placeholder="Enter new password">

            <label for="plate_number">Plate Number:</label>
            <input type="text" name="plate_number" value="{{ auth()->user()->plate_number }}" required>

            <label for="image">Profile Image:</label>
            <input type="file" name="image">


            <button type="submit" class="update-profile-button">Update Profile</button>
        </form>

        <form action="{{ route('user.deactivate') }}" method="POST">
            @csrf
            @method('PUT')
            <button type="submit">Deactivate Account</button>
        </form>
    </div>
</section>
