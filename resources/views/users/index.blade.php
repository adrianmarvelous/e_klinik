@extends('dashboard')

@section('content')
    <div class="card">
        <div class="card-body">
            <h2>List Users</h2>
            <div class="d-flex justify-content-end">
                <a class="btn btn-primary" href="{{ route('users.create_patient') }}">Buat Akun Pasien</a>
            </div>
            <div class="table-responsive mt-3">
                <table class="table table-striped table-hover" id="basic-datatables">
                    <thead>
                        <tr class="table-primary">
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $no => $item)
                            <tr>
                                <td>{{ $no+1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>
                                    <form action="{{ route('users.updateRole', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <select name="role" id="roles_{{ $item->id }}" class="form-select"
                                                onchange="this.form.submit()">

                                            {{-- Put current role as first option --}}
                                            @if ($item->getRoleNames()->isNotEmpty())
                                                <option value="{{ $item->getRoleNames()->first() }}" selected>
                                                    {{ $item->getRoleNames()->first() }}
                                                </option>
                                            @endif

                                            {{-- Then show all roles except the current one --}}
                                            @foreach ($roles as $role)
                                                @if ($item->getRoleNames()->first() !== $role->name)
                                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                                @endif
                                            @endforeach

                                        </select>
                                    </form>


                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
