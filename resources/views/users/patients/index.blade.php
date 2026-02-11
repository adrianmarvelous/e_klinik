@extends('dashboard')

@section('content')
    <div class="card">
        <div class="card-body">
            <h1>List Pasien</h1>
            <div class="table-responsive">
                <table class="table table-bordered" id="basic-datatables">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Nama Pasien</th>
                            <th>Email</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    @foreach ($patients as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $item->user->email }}</td>
                            <td>
                                <a href="{{ route('list_patient.show', $item->id) }}" class="btn btn-primary">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
