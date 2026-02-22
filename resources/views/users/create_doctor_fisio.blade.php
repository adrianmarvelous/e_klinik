@extends('dashboard')

@section('content')
    <div class="card">
        <div class="card-body">

            <form action="{{ isset($data) ? route('users.update_data', $data->id) : route('users.store_data') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @if (isset($data))
                    @method('PUT')
                @endif

                <div class="card-body">
                    <h2 class="fw-bold mb-3">
                        {{ isset($data) ? 'Edit Profil Pasien' : 'Profil Pasien Baru' }}
                    </h2>

                    <div class="row mt-3">
                        <div class="col-lg-2">
                            <label for="name">Dokter / Fisioterapi</label>
                        </div>
                        <div class="col-lg-10">
                            <select name="" id="" class="form-select">
                                <option value="" disabled selected>Pilih Salah Satu</option>
                                <option value="doctor">Dokter</option>
                                <option value="fisioterapi">fisioterapi</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-2">
                            <label for="name">Nama</label>
                        </div>
                        <div class="col-lg-10">
                            <input type="text" name="name" class="form-control" placeholder="Masukan Nama Anda"
                                value="{{ old('name', $data->user->name ?? '') }}">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-2">
                            <label for="name">Email</label>
                        </div>
                        <div class="col-lg-10">
                            <input type="email" name="email" class="form-control" placeholder="Masukan E-mail Anda"
                                value="{{ old('email', $data->user->name ?? '') }}">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-2">
                            <label for="dateofbirth">Tanggal Lahir</label>
                        </div>
                        <div class="col-lg-10">
                            <input type="date" name="dateofbirth" class="form-control"
                                value="{{ old('dateofbirth', $data->date_of_birth ?? '') }}">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-2">
                            <label for="gender">Jenis Kelamin</label>
                        </div>
                        <div class="col-lg-10">
                            <select name="gender" class="form-select">
                                <option value="male"
                                    {{ old('gender', $data->gender ?? '') == 'male' ? 'selected' : '' }}>
                                    Laki - laki</option>
                                <option value="female"
                                    {{ old('gender', $data->gender ?? '') == 'female' ? 'selected' : '' }}>Perempuan
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-2">
                            <label for="phone">No Telp</label>
                        </div>
                        <div class="col-lg-10">
                            <input type="text" name="phone" class="form-control" placeholder="Masukan No Telp Anda"
                                value="{{ old('phone', $data->phone ?? '') }}">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-2">
                            <label for="address">Alamat</label>
                        </div>
                        <div class="col-lg-10">
                            <input type="text" name="address" class="form-control" placeholder="Masukan Alamat Anda"
                                value="{{ old('address', $data->address ?? '') }}">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary">
                            {{ isset($data) ? 'Update' : 'Simpan' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
