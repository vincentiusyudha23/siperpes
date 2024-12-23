@extends('user.user-master')

@section('title', 'Add Perum')

@section('style')
    
@endsection

@section('content')
    <div class="container-fluid py-2">
        <div class="mb-3">
            <div class="card w-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <h1 class="fw-semibold text-secondary">Tambah Perumahan</h1>
                    <a href="{{ route('user.perumahan') }}" class="btn btn-sm btn-danger fw-semibold">
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="">
            <div class="card w-100">
                <div class="card-body">
                    <form method="POST" action="{{ route('user.perumahan.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label text-secondary fw-semibold">Nama Perumahan</label>
                            <input type="text" class="form-control" name="name_perum" value="{{ old('name_perum') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-secondary fw-semibold">Nama Pengembang</label>
                            <input type="text" class="form-control" name="name_pengembang" value="{{ old('name_pengembang') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-secondary fw-semibold">Image</label>
                            <input type="file" class="form-control" name="image" value="{{ old('image') }}">
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-6 mb-3">
                                <div>
                                    <label class="form-label text-secondary fw-semibold">Desa</label>
                                    <input type="text" class="form-control" name="desa" value="{{ old('desa') }}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <div>
                                    <label class="form-label text-secondary fw-semibold">Kecamatan</label>
                                    <input type="text" class="form-control" name="kecamatan" value="{{ old('kecamatan') }}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <div>
                                    <label class="form-label text-secondary fw-semibold">Jumlah Unit/Rumah</label>
                                    <input type="number" class="form-control" name="jumlah_unit" value="{{ old('jumlah_unit') }}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <div>
                                    <label class="form-label text-secondary fw-semibold">Tahun Berdiri</label>
                                    <input type="number" class="form-control" name="tahun_berdiri" value="{{ old('tahun_berdiri') }}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <div>
                                    <label class="form-label text-secondary fw-semibold">Easting</label>
                                    <input type="number" class="form-control" name="easting" value="{{ old('easting') }}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <div>
                                    <label class="form-label text-secondary fw-semibold">Norting</label>
                                    <input type="number" class="form-control" name="norting" value="{{ old('norting') }}">
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <button type="button" class="btn btn-sm btn-light w-100">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                    Cari Lokasi
                                </button>
                            </div>
                        </div>

                        <div class="w-100">
                            <div id="map"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection