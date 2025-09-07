@extends('dashboard')

@section('content')
    <div class="card">
        <div class="card-body">
            <h2>List Pasien Masuk</h2>
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="basic-datatables">
                    <thead>
                        <tr class="table-primary">
                            <th>No</th>
                            <th>Nama</th>
                            <th>Keluhan</th>
                            <th>tanggal Daftar</th>
                            <th>Status</th>
                            <th>Tanggal Dokter</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $no => $item)
                            <tr>
                                <td>{{ $no+1 }}</td>
                                <td>{{ $item->patient->user->name }}</td>
                                <td>{!! $item->description !!}</td>
                                <td>{{ date('d-M-Y H:i',strtotime($item->created_at)) }}</td>
                                <td style="text-transform: capitalize">{{ optional($item->appointments)->status }}</td>
                                <td>{{ optional($item->appointments)->datetime ? \Carbon\Carbon::parse($item->appointments->datetime)->format('d-M-Y H:i') : '-' }}</td>
                                <td>
                                    <a class="btn {{ $item->appointments === null ? 'btn-primary' : 'btn-success' }}" href="{{ route('appoinment.schedule',['patient_id' => $item->patient->id,'medical_history_id' => $item->id]) }}"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Pilih Jadwal Dokter"><i class="fas fa-calendar-alt"></i></a>
                                    @if ($item->appointments !== null)
                                        <a class="btn btn-primary" href=""data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Check Up"><i class="fa fa-list"></i></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
