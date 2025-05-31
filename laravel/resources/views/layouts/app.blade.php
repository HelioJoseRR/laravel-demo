<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Somoteca')</title>
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <header class="header-main">
      <div class="header-container">
        <a id="logo" class="logo" href="/">
          <span class="logo-icon"><i class="fas fa-music"></i></span>
          <span class="logo-text">Somoteca</span>
        </a>
        <button class="header-mobile-toggle" aria-label="Open menu"><i class="fas fa-bars"></i></button>
        <div class="header-actions">
          <form action="{{ route('search') }}" method="GET" class="search-form">
            <input type="search" name="q" placeholder="Search the site..." required>
            <button type="submit"><i class="fas fa-search"></i></button>
          </form>
          <nav class="main-nav">
            <ul class="nav-list">
              @auth
              <li><span>Welcome, {{ Auth::user()->name }}</span></li>
              <li><a href="/profile/{{ Auth::id() }}">My profile</a></li>
              <li><a href="/playlists">Playlists</a></li>
              <li><a href="/forum">Forum</a></li>
              <li><a href="/songs">Songs</a></li>
              <li><a href="/events">Events</a></li>
              <li>
                <form method="POST" action="/logout" class="logout-form">
                  @csrf
                  <button type="submit">Logout</button>
                </form>
              </li>
              @else
              <li><a href="/login">Login</a></li>
              <li><a href="/register">Register</a></li>
              @endauth
            </ul>
          </nav>
        </div>
      </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="footer-main">
      <div class="footer-container">
        <div class="footer-brand">
          <span class="footer-logo"><i class="fas fa-music"></i> Somoteca</span>
          <span class="footer-copy">&copy; {{ date('Y') }} Somoteca | No rights reserved</span>
        </div>
        <div class="footer-links">
          <a href="#">Contact us</a>
          <a href="#">Privacy policy</a>
          <a href="#">Terms and conditions</a>
        </div>
      </div>
    </footer>

</body>

</html>
