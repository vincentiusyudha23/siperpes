<nav class="navbar bg-primary">
    <div class="container-fluid px-4 py-2 text-white">
        <span class="navbar-brand mb-0 h1 fw-bold text-white fs-4">SIPERPES</span>

        <div class="dropdown mx-5">
            <a href="#" class="text-white list-style-none d-flex dropdown-toggle justify-content-center align-items-center gap-2" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-user fa-lg"></i>
                <span class="fw-semibold">{{ auth()->user()->name ?? '' }}</span>
            </a>
    
            <ul class="dropdown-menu">
                <li>
                    <form method="POST" action="{{ route('user.logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">Log Out</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>