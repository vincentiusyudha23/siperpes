@extends('user.user-master')

@section('title', 'Dashboard')

@section('style')
    <style>
        .icon-dash{
            font-size: 5em;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid p-3">
        <div class="w-100">
            <div class="row">
                <div class="col-12 col-md-6 mb-3">
                    <div class="card w-100 bg-danger" style="height: 200px;">
                        <div class="card-body w-100 h-100">
                            <div class="row h-100">
                                <div class="col-6 h-100 d-flex justify-content-center align-items-center text-white">
                                    <h1 class="fw-bold icon-dash">{{ $perumahans->count() }}</h1>
                                </div>
                                <div class="col-6 h-100 d-flex justify-content-center align-items-center text-white">
                                    <i class="fa-solid fa-house icon-dash"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="card w-100 bg-success" style="height: 200px;">
                        <div class="card-body w-100 h-100">
                            <div class="row h-100">
                                <div class="col-6 h-100 d-flex justify-content-center align-items-center text-white">
                                    <h1 class="fw-bold icon-dash">5</h1>
                                </div>
                                <div class="col-6 h-100 d-flex justify-content-center align-items-center text-white">
                                    <i class="fa-solid fa-users icon-dash"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-100 mt-3 table-responsive">
            <table class="table table-striped">
                <thead class="table-primary">
                    <tr>
                        <th>No.</th>
                        <th>Perumahan</th>
                        <th>Nama Pengembang</th>
                        <th class="text-center">Desa</th>
                        <th class="text-center">Kecamatan</th>
                        <th class="text-center">Jumlah Unit</th>
                        <th class="text-center">Luast Perumahan</th>
                        <th class="text-center">Tahun Berdiri</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($perumahans as $item)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $item->name_perum }}</td>
                            <td>{{ $item->name_pengembang }}</td>
                            <td class="text-center">{{ $item->desa }}</td>
                            <td class="text-center">{{ $item->kecamatan }}</td>
                            <td class="text-center">{{ $item->jumlah_unit }}</td>
                            <td class="text-center">{{ $item->luas_perumahan }} M<sup>2</sup></td>
                            <td class="text-center">{{ $item->tahun_berdiri }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection