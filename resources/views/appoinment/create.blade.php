@extends('dashboard')

@section('content')
    <div class="card">
        <div class="card-body">
            <h2>Buat Keluhan</h2>
            <form action="{{ route('appoinment.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-lg-2">
                        <label for="">Keluhan</label>
                    </div>
                    <div class="col-lg-10">
                        <textarea id="summernote" name="keluhan">
                            {{ old('keluhan', $medicalHistory->description ?? "Keluhan Utama : <br>
                        Keluhan Tambahan : <br>
                        Lama Sakit : <br>
                        Merokok : <br>
                        Konsumsi Alkohol : <br>
                        Kurang Sayur Buah : <br>") }}
                        </textarea>

                    </div>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
