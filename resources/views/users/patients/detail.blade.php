@extends('dashboard')

@section('content')
    <div class="card">
        <div class="card-body">
            <h1>Detail Pasien</h1>
            <div>
                <div class="row">
                    <div class="col-lg-1">
                        <label for="" class="fw-bold">Nama</label>
                    </div>
                    <div class="col-lg-11">
                        {{ $patient->user->name }}
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-1">
                        <label for="" class="fw-bold">Jenis Kelamin</label>
                    </div>
                    <div class="col-lg-11">
                        @if ($patient->gender == 'female')
                            Perempuan
                        @else
                            Laki - laki
                        @endif
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-1">
                        <label for="" class="fw-bold">No Telp</label>
                    </div>
                    <div class="col-lg-11">
                        {{ $patient->phone }}
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-1">
                        <label for="" class="fw-bold">Alamat</label>
                    </div>
                    <div class="col-lg-11">
                        {{ $patient->address }}
                    </div>
                </div>
            </div>
            <h2>History Pemeriksaan</h2>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Keluhan Utama</th>
                            <th>Keluhan Tambahan</th>
                            <th>Dokter/Fisio</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            // dd($patient);
                        @endphp
                        @foreach ($patient->medicalHistories as $history)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::parse($history->appointments->datetime)->format('d-M-Y H:i') }}</td>
                                <td>{{ $history->main_complaint }}</td>
                                <td>{{ $history->additional_complaint }}</td>
                                <td>{{ optional($history->doctor)->name }}</td>
                                <td>
                                    <a href="{{ route('medical.show',['medical' => $history->id]) }}" class="btn btn-primary">Detail</a>
                                    <a href="{{ route('appointment.edit',['id' => $history->appointments->id]) }}" class="btn btn-primary">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
