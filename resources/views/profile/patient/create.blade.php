@extends('dashboard')

@section('content')
    <div class="card">
        <form 
            action="{{ isset($patient) ? route('patient.update', $patient->id) : route('patient.store') }}" 
            method="POST"
        >
            @csrf
            @if(isset($patient))
                @method('PUT')
            @endif

            <div class="card-body">
                <h2 class="fw-bold mb-3">
                    {{ isset($patient) ? 'Edit Profil Pasien' : 'Profil Pasien Baru' }}
                </h2>

                <div class="row mt-3">
                    <div class="col-lg-2">
                        <label for="name">Nama</label>
                    </div>
                    <div class="col-lg-10">
                        <input 
                            type="text" 
                            name="name" 
                            class="form-control" 
                            placeholder="Masukan Nama Anda" 
                            value="{{ old('name', $patient->user->name ?? session('user.name')) }}"
                        >
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-lg-2">
                        <label for="dateofbirth">Tanggal Lahir</label>
                    </div>
                    <div class="col-lg-10">
                        <input 
                            type="date" 
                            name="dateofbirth" 
                            class="form-control" 
                            value="{{ old('dateofbirth', $patient->date_of_birth ?? '') }}"
                        >
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-lg-2">
                        <label for="gender">Jenis Kelamin</label>
                    </div>
                    <div class="col-lg-10">
                        <select name="gender" class="form-select">
                            <option value="male" {{ old('gender', $patient->gender ?? '') == 'male' ? 'selected' : '' }}>Laki - laki</option>
                            <option value="female" {{ old('gender', $patient->gender ?? '') == 'female' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-lg-2">
                        <label for="phone">No Telp</label>
                    </div>
                    <div class="col-lg-10">
                        <input 
                            type="text" 
                            name="phone" 
                            class="form-control" 
                            placeholder="Masukan No Telp Anda" 
                            value="{{ old('phone', $patient->phone ?? '') }}"
                        >
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-lg-2">
                        <label for="address">Alamat</label>
                    </div>
                    <div class="col-lg-10">
                        <input 
                            type="text" 
                            name="address" 
                            class="form-control" 
                            placeholder="Masukan Alamat Anda" 
                            value="{{ old('address', $patient->address ?? '') }}"
                        >
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-primary">
                        {{ isset($patient) ? 'Update' : 'Simpan' }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
