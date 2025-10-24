@extends('dashboard')

@section('content')
    <div class="card">
        <div class="card-body">
            <h2>
                Medical Check Up
            </h2>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card shadow p-3">
                        <h3>Pasien</h3>
                        <div class="row">
                            <div class="col-lg-2">
                                <p class="fw-bold">Nama Pasien</p>
                            </div>
                            <div class="col-lg-10">
                                <p>{{ $data->patient->user->name }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2">
                                <p class="fw-bold">Jenis Kelamin</p>
                            </div>
                            <div class="col-lg-10">
                                <p>
                                    {{ $data->patient->gender === 'male' ? 'Laki-laki' : ($data->patient->gender === 'female' ? 'Perempuan' : '-') }}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2">
                                <p class="fw-bold">Usia</p>
                            </div>
                            <div class="col-lg-10">
                                <p>{{ $age }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class=" card p-3 shadow">
                        <h3>Keluhan</h3>
                        <div class="row">
                            <div class="col-lg-4">
                                <p class="fw-bold">Keluhan Utama</p>
                            </div>
                            <div class="col-lg-8">
                                <p>{{ $data->medicalHistory->main_complaint }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <p class="fw-bold">Keluhan Tambahan</p>
                            </div>
                            <div class="col-lg-8">
                                <p>{{ $data->medicalHistory->additional_complaint }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <p class="fw-bold">Lama Sakit</p>
                            </div>
                            <div class="col-lg-8">
                                <p>{{ $data->medicalHistory->illness_duration }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <p class="fw-bold">Merokok</p>
                            </div>
                            <div class="col-lg-8">
                                <p>{{ $data->medicalHistory->smooking == 1 ? 'Iya' : 'Tidak' }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <p class="fw-bold">Konsumsi Alkohol</p>
                            </div>
                            <div class="col-lg-8">
                                <p>{{ $data->medicalHistory->alcohol_consumption == 1 ? 'Iya' : 'Tidak' }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <p class="fw-bold">Kurang Sayur Buah</p>
                            </div>
                            <div class="col-lg-8">
                                <p>{{ $data->medicalHistory->low_fruit_veggie_intake == 1 ? 'Iya' : 'Tidak' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <form
                action="{{ isset($data->medicalHistory->medical_records->id)
                    ? route('medical.update', $data->medicalHistory->medical_records->id)
                    : route('medical.store') }}"
                method="post">

                @csrf
                @if (isset($data->medicalHistory->medical_records->id))
                    @method('PUT') {{-- Use PUT for update --}}
                @endif

                <div class="card shadow p-3">
                    <label for="summernote" class="fw-bold">Ringkasan Pasien</label>
                    <textarea id="summernote" name="patient_summary" class="form-control">
                        {{ $data->medicalHistory->medical_records->patient_summary ?? '' }}
                    </textarea>

                    <label for="summernote1" class="fw-bold mt-5">Ringkasan Dokter</label>
                    <textarea id="summernote1" name="doctor_summary" class="form-control">
                        {{ $data->medicalHistory->medical_records->doctor_summary ?? '' }}
                    </textarea>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    <input type="hidden" name="medical_history_id" value="{{ $data->medical_history_id }}">
                    <button class="btn btn-primary" type="submit">
                        {{ isset($data->medicalHistory->medical_records->id) ? 'Update' : 'Simpan' }}
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection
