@extends('dashboard')

@section('content')
    <div class="card">
        <div class="card-body">

            <form action="{{ isset($patient) ? route('users.update_patient', $patient->id) : route('doctor.store_doctor') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @if (isset($patient))
                    @method('PUT')
                @endif

                <div class="card-body">
                    <h2 class="fw-bold mb-3">
                        {{ isset($patient) ? 'Edit Profil Dokter/Fisioterapi' : 'Profil Dokter/Fisioterapi Baru' }}
                    </h2>

                    <div class="row mt-3">
                        <div class="col-lg-2">
                            <label for="name">Dokter/Fisioterapi</label>
                        </div>
                        <div class="col-lg-10">
                            <select name="bio" class="form-select" id="" required>
                                <option value="" selected disabled>Pilih Salah Satu</option>
                                <option value="dokter">Dokter</option>
                                <option value="fisioterapi">Fisioterapi</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-2">
                            <label for="name">Nama Dokter/Fisioterapi</label>
                        </div>
                        <div class="col-lg-10">
                            <input type="text" name="name" class="form-control" placeholder="Masukan Nama Dokter/Fisioterapi"
                                value="{{ old('name', $patient->user->name ?? '') }}">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-2">
                            <label for="name">Gender</label>
                        </div>
                        <div class="col-lg-10">
                            <select name="gender" class="form-select" id="" required>
                                <option value="" selected disabled>Pilih Salah Satu</option>
                                <option value="male">Laki-laki</option>
                                <option value="female">Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-2">
                            <label for="name">Spesialisasi</label>
                        </div>
                        <div class="col-lg-10">
                            <input type="text" name="specialization" class="form-control" placeholder="Masukan Spesialisasi"
                                value="{{ old('specialization', $patient->user->specialization ?? '') }}">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-2">
                            <label for="name">Telp</label>
                        </div>
                        <div class="col-lg-10">
                            <input type="text" name="phone" class="form-control" placeholder="Masukan Nomor Telepon"
                                value="{{ old('phone', $patient->user->phone ?? '') }}">
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
    </div>
@endsection
