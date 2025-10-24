@extends('dashboard')

@section('content')
    <div class="card">
        <div class="card-body">
            <h2>
                Daftar Kehadiran
            </h2>
            <div style="width: 200px">
                <form action="{{ route('attendance.index') }}" method="get">
                    <input type="date" name="date" class="form-control" onchange="this.form.submit()">
                </form>
            </div>
            <div class="table-responsive mt-3">
                <table id="basic-datatables" class="display table table-bordered table-hover" cellspacing="0" width="100%">
                    <thead class="table-primary">
                        <tr>
                            <th>NO</th>
                            <th>Nama</th>
                            <th>Tangal</th>
                            <th>Status</th>
                            <th>Kehadiran</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $item->patient->user->name }}</td>
                                <td>{{ date('d-M-Y H:i',strtotime($item->datetime)) }}</td>
                                <td>{{ $item->status }}</td>
                                <td>{{ date('d-M-Y H:i',strtotime($item->attendance)) }}</td>
                                <td class="text-center">
                                    @if (!$item->attendance)
                                        <form action="{{ route('attendance.update', ['attendance' => $item->id]) }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="appointment_id" value="{{ $item->id }}">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i></button>
                                        </form>

                                    @else
                                        <button class="btn btn-success" disabled><i class="fa fa-check"></i></button>
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
