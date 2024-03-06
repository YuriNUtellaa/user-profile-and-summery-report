<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SPark</title>

    <link rel="icon" type="image/png" sizes="32x32" href="layouts/favicon-32x32.png">
    <link rel="manifest" href="/site.webmanifest">

    <link href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">

    <link href="{{ asset('css/header-footer.css') }}" rel="stylesheet">
    <link href="{{ asset('css/user.css') }}" rel="stylesheet">
    <link href="{{ asset('css/slot.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">

</head>

<header>
    {{-- FOR ADMIN --}}
    @auth('admin')
        <a href="/home" class="logo"><img src="layouts/SPark-logos_white_admin.png" alt=""></a>
        <ul class="navmenu">
            <li><a href="/">Home</a></li> |
            <li><a href="/slots-control-admin">Slot Control</a></li> |
            <li><a href="/user-management">User Management</a></li> |
            <li><a href="/history-admin">Rent & Reservation</a></li> |
            <li><a href="/summary">Summary Report</a></li>
        </ul>
        <div class="nav-icon">
            <form action="/logout-admin" method="POST">
                @csrf
                <i class='bx bxs-user-circle'></i>
                <button class="logout-button" type="submit">
                    <i class='bx bx-log-out-circle'></i>
                </button>
            </form>
        </div>
    {{-- FOR REGULAR USER --}}
    @else
        @auth
            <a href="/home" class="logo"><img src="layouts/SPark-logos_white.png" alt=""></a>
            <ul class="navmenu">
                <li><a href="/">Home</a></li>
                <li><a href="/slots">Slot</a></li>
                <li><a href="/login-admin">Administration</a></li>
                <li><a href="/">About Us</a></li>
            </ul>
            <div class="nav-icon">
                    {{-- Userprofile --}}
                <form action="/userprofile" method="GET">
                    @csrf
                <button class="userporfile" type="submit">
                    <i class='bx bxs-user-circle'></i>

                </button>

                </form>

                <form action="/logout" method="POST">
                    @csrf



                    <button class="logout-button" type="submit">
                        <i class='bx bx-log-out-circle'></i>
                    </button>
                </form>
            </div>
        {{-- FOR VISITORS --}}
        @else
            <a href="/home" class="logo"><img src="layouts/SPark-logos_white.png" alt=""></a>
            <ul class="navmenu">
                <li><a href="/">Home</a></li>
                <li><a href="/slots">Slot</a></li>
                <li><a href="/login-admin">Administration</a></li>
                <li><a href="/">About Us</a></li>
            </ul>
            <div class="nav-icon">
                <a href="register"><i class='bx bx-user-plus'></i></a>
                <a href="login"><i class='bx bx-log-in-circle'></i></a>
            </div>
        @endauth
    @endauth
</header>


