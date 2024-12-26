<div class="sidebar-header">
    <img src="{{ $perumahan->image }}" alt="img">
    <div class="widget-sidebar">
        <div class="widget-item">
            <div class="circle-widget bg-body-secondary shadow-md">
                <span class="fw-bold">{{ $perumahan->luas_perumahan }}</span>
            </div>  
            <span class="fw-semibold fs-6 text-secondary">Luas (M<sup>2</sup>)</span>
        </div>
        <div class="widget-item">
            <div class="circle-widget bg-body-secondary shadow-md">
                <span class="fw-bold">{{ $perumahan->jumlah_unit }}</span>
            </div>
            <span class="fw-semibold fs-6 text-secondary">Unit</span>
        </div>
        <div class="widget-item">
            <div class="circle-widget bg-body-secondary shadow-md route-btn" data-id="{{ $perumahan->id }}">
                <i class="fa-solid fa-route fa-xl"></i>
            </div>
            <span class="fw-semibold fs-6 text-secondary">Rute</span>
        </div>
    </div>
</div>

<div class="sidebar-content">
    <div class="w-100 text-center py-3">
        <span class="fw-bold fs-5">{{ $perumahan->name_perum }}</span>
    </div>
    <div class="d-flex w-100 flex-column gap-1 px-2">
        <div class="">
            <small class="fw-semibold text-secondary">Nama Pengembang</small>
            <h1 class="fw-semibold fs-6">{{ $perumahan->name_pengembang }}</h1>
        </div>
        <div class="">
            <small class="fw-semibold text-secondary">Desa</small>
            <h1 class="fw-semibold fs-6">{{ $perumahan->desa }}</h1>
        </div>
        <div class="">
            <small class="fw-semibold text-secondary">Kecamatan</small>
            <h1 class="fw-semibold fs-6">{{ $perumahan->kecamatan }}</h1>
        </div>
        <div class="">
            <small class="fw-semibold text-secondary">Tahun Berdiri</small>
            <h1 class="fw-semibold fs-6">{{ $perumahan->tahun_berdiri }}</h1>
        </div>
    </div>
</div>

@if (Auth::check())
<div class="w-100 d-flex gap-2 justify-content-center align-items-center px-2">
    <a class="btn btn-sm btn-success w-100 fw-semibold">
        <i class="fa-solid fa-pen-to-square"></i> Edit
    </a>
    <a class="btn btn-sm btn-danger w-100 fw-semibold">
        <i class="fa-solid fa-trash"></i> Hapus
    </a>
</div>
@endif

<button class="btn btn-sm btn-danger btn-close-sidebar">
    <i class="fa-solid fa-x"></i>
</button>