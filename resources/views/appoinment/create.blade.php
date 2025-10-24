@extends('dashboard')

@section('content')
    <div class="card">
        <div class="card-body">
            <h2>Buat Keluhan</h2>
            <form action="{{ route('appoinment.store') }}" method="post">
                @csrf
                <div class="row mt-3">
                    <div class="col-lg-2">
                        <label class="fw-bold form-label mb-0" style="font-size: 1rem;">Keluhan Utama</label>
                    </div>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" name="main_complaint" required>
                    </div>
                    {{-- <div class="col-lg-10">
                        <textarea id="summernote" name="keluhan">
                            {{ old('keluhan', $medicalHistory->description ?? "Keluhan Utama : <br>
                        Keluhan Tambahan : <br>
                        Lama Sakit : <br>
                        Merokok : <br>
                        Konsumsi Alkohol : <br>
                        Kurang Sayur Buah : <br>") }}
                        </textarea>

                    </div> --}}
                </div>
                <div class="row mt-3">
                    <div class="col-lg-2">
                        <label class="fw-bold form-label mb-0" style="font-size: 1rem;">Keluhan Tambahan</label>
                    </div>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" name="additional_complaint">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-2">
                        <label class="fw-bold form-label mb-0" style="font-size: 1rem;">Lama Sakit</label>
                    </div>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" name="illness_duration" required>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-2">
                        <label class="fw-bold form-label mb-0" style="font-size: 1rem;">Merokok</label>
                    </div>
                    <div class="col-lg-10">
                        <select name="smoking" class="form-select" id="" required>
                            <option value="" selected disabled>Silahkan Pilih</option>
                            <option value="1">Iya</option>
                            <option value="0">Tidak</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-2">
                        <label class="fw-bold form-label mb-0" style="font-size: 1rem;">Konsumsi Alkohol</label>
                    </div>
                    <div class="col-lg-10">
                        <select name="alcohol_consumption" class="form-select" id="" required>
                            <option value="" selected disabled>Silahkan Pilih</option>
                            <option value="1">Iya</option>
                            <option value="0">Tidak</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-2">
                        <label class="fw-bold form-label mb-0" style="font-size: 1rem;">Kurang Sayur Buah</label>
                    </div>
                    <div class="col-lg-10">
                        <select name="low_fruit_veggie_intake" class="form-select" id="" required>
                            <option value="" selected disabled>Silahkan Pilih</option>
                            <option value="1">Iya</option>
                            <option value="0">Tidak</option>
                        </select>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
