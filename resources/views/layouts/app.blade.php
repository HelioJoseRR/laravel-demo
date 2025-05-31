<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Somoteca')</title>
  <link rel="stylesheet" href="/css/styles.css">
  <link rel="stylesheet" href="/css/header-styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
  <header class="header">
    <div class="header-wrapper">
      <div class="header-content">
        <!-- Logo Section -->
        <div class="header-brand">
          <a href="/" class="brand-link" aria-label="Somoteca Home">
            <i class="fas fa-music brand-icon" aria-hidden="true"></i>
            <span class="brand-text">Somoteca</span>
          </a>
        </div>

        <!-- Search Section -->
        <div class="header-search">
          <form action="{{ route('search') }}" method="GET" class="search-container">
            <div class="search-input-wrapper">
              <input type="search" name="q" placeholder="Search the site..." class="search-input" aria-label="Search"
                required>
              <button type="submit" class="search-button" aria-label="Search">
                <i class="fas fa-search" aria-hidden="true"></i>
              </button>
            </div>
          </form>
        </div>

        <!-- Navigation Section -->
        <div class="header-nav">
          @auth
        <!-- User Menu -->
        <div class="user-menu">
        <div class="user-info">
          <span class="user-greeting">Welcome, {{ Auth::user()->name }}</span>
        </div>

        <nav class="main-navigation" role="navigation">
          <ul class="nav-menu">
          <li class="nav-item">
            <a href="/profile/{{ Auth::id() }}" class="nav-link">My profile</a>
          </li>
          <li class="nav-item">
            <a href="/playlists" class="nav-link">Playlists</a>
          </li>
          <li class="nav-item">
            <a href="/forum" class="nav-link">Forum</a>
          </li>
          <li class="nav-item">
            <a href="/songs" class="nav-link">Songs</a>
          </li>
          <li class="nav-item">
            <a href="/events" class="nav-link">Events</a>
          </li>
          <li class="nav-item">
            <form method="POST" action="/logout" class="logout-form">
            @csrf
            <button type="submit" class="logout-button">Logout</button>
            </form>
          </li>
          </ul>
        </nav>
        </div>
      @else
        <!-- Guest Menu -->
        <div class="guest-menu">
        <nav class="auth-navigation" role="navigation">
          <ul class="auth-menu">
          <li class="auth-item">
            <a href="/login" class="nav-link">Login</a>
          </li>
          <li class="auth-item">
            <a href="/register" class="nav-link">Register</a>
          </li>
          </ul>
        </nav>
        </div>
      @endauth
        </div>

        <!-- Mobile Menu Toggle -->
        <button class="mobile-menu-toggle" aria-label="Toggle mobile menu" aria-expanded="false">
          <i class="fas fa-bars" aria-hidden="true"></i>
        </button>
      </div>
    </div>

    <!-- Mobile Menu Overlay -->
    <div class="mobile-menu-overlay" aria-hidden="true">
      <div class="mobile-menu-content">
        @auth
      <div class="mobile-user-info">
        <span class="mobile-user-name">Welcome, {{ Auth::user()->name }}</span>
      </div>

      <nav class="mobile-navigation">
        <ul class="mobile-nav-menu">
        <li><a href="/profile/{{ Auth::id() }}" class="mobile-nav-link">My profile</a></li>
        <li><a href="/playlists" class="mobile-nav-link">Playlists</a></li>
        <li><a href="/forum" class="mobile-nav-link">Forum</a></li>
        <li><a href="/songs" class="mobile-nav-link">Songs</a></li>
        <li><a href="/events" class="mobile-nav-link">Events</a></li>
        <li>
          <form method="POST" action="/logout" class="mobile-logout-form">
          @csrf
          <button type="submit" class="mobile-logout-button">Logout</button>
          </form>
        </li>
        </ul>
      </nav>
    @else
      <nav class="mobile-auth-navigation">
        <ul class="mobile-auth-menu">
        <li><a href="/login" class="mobile-nav-link">Login</a></li>
        <li><a href="/register" class="mobile-nav-link">Register</a></li>
        </ul>
      </nav>
    @endauth
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

  <script>
    // Mobile menu toggle functionality
    document.addEventListener('DOMContentLoaded', function () {
      const mobileToggle = document.querySelector('.mobile-menu-toggle');
      const mobileOverlay = document.querySelector('.mobile-menu-overlay');
      const body = document.body;

      if (mobileToggle && mobileOverlay) {
        mobileToggle.addEventListener('click', function () {
          const isExpanded = this.getAttribute('aria-expanded') === 'true';

          this.setAttribute('aria-expanded', !isExpanded);
          mobileOverlay.setAttribute('aria-hidden', isExpanded);

          body.classList.toggle('mobile-menu-open');
          this.classList.toggle('active');
        });

        // Close mobile menu when clicking overlay
        mobileOverlay.addEventListener('click', function (e) {
          if (e.target === this) {
            mobileToggle.click();
          }
        });

        // Close mobile menu on escape key
        document.addEventListener('keydown', function (e) {
          if (e.key === 'Escape' && body.classList.contains('mobile-menu-open')) {
            mobileToggle.click();
          }
        });
      }
    });
  </script>
</body>

</html>