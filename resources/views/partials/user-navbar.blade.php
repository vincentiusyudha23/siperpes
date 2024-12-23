<nav class="navbar bg-primary position-relative">
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

    <div class="btn-menu ">
        <button class="btn btn-sm btn-primary border-2 rounded-pill border-light" id="btn-menu-upbar">
            <span class="fw-semibold">Menu</span>
        </button>
    </div>

    <div class="upbar bg-primary-subtle">
        <div class="w-100 d-flex flex-column gap-3 py-2">
            <div class="px-3">
                <a href="{{ route('user.dashboard') }}" class="btn btn-primary w-100 d-flex justify-content-center align-items-center gap-2">
                    <i class="fa-solid fa-gauge fa-lg"></i>
                    <span class="fw-bold text-white fs-5">Dashboard</span>
                </a>
            </div>
            <div class="px-3">
                <a href="{{ route('user.perumahan') }}" class="btn btn-primary w-100 d-flex justify-content-center align-items-center gap-2">
                    <i class="fa-solid fa-map fa-lg"></i>
                    <span class="fw-bold text-white fs-5">GIS</span>
                </a>
            </div>
        </div>
    </div>
</nav>