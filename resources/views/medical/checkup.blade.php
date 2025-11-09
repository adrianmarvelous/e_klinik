@extends('dashboard')

@section('content')
<div class="card">
    <div class="card-body">
        <h2>Medical Check Up</h2>

        {{-- === Patient Info Section (your existing code omitted for brevity) === --}}

        <form
            action="{{ isset($data->medicalHistory->medical_records->id)
                ? route('medical.update', $data->medicalHistory->medical_records->id)
                : route('medical.store') }}"
            method="post">

            @csrf
            @if (isset($data->medicalHistory->medical_records->id))
                @method('PUT')
            @endif

            {{-- === Existing summary section === --}}
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

            {{-- === Jadwal Section === --}}
            <div class="mt-4">
                <h5>Jadwal Pemeriksaan</h5>
                <div id="tanggalContainer" class="mt-2"></div>
                <button type="button" id="btnTambahJadwal" class="btn btn-primary mt-2">
                    Tambah Jadwal
                </button>
            </div>
        </form>
    </div>
</div>

{{-- STEP 1: Pass booked dates to JavaScript --}}
<script>
    const bookedDates = @json(
        $appointments->pluck('datetime')->map(fn($d) => \Carbon\Carbon::parse($d)->format('Y-m-d'))
    );
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('btnTambahJadwal');
    const container = document.getElementById('tanggalContainer');

    if (!btn || !container) {
        console.error('btnTambahJadwal or tanggalContainer not found');
        return;
    }

    btn.addEventListener('click', function (e) {
        e.preventDefault();

        const div = document.createElement('div');
        div.classList.add('d-flex', 'align-items-center', 'gap-2', 'mb-2');

        const input = document.createElement('input');
        input.type = 'date';
        input.name = 'jadwal[]';
        input.classList.add('form-control', 'w-auto');

        // Prevent user selecting already booked date
        input.addEventListener('input', function() {
            const selectedDate = this.value;
            if (bookedDates.includes(selectedDate)) {
                alert('Tanggal ini sudah terisi. Pilih tanggal lain.');
                this.value = ''; // clear invalid selection
            }
        });

        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.classList.add('btn', 'btn-danger', 'btn-sm');
        removeBtn.textContent = 'Hapus';
        removeBtn.addEventListener('click', () => div.remove());

        div.appendChild(input);
        div.appendChild(removeBtn);
        container.appendChild(div);
    });
});
</script>
@endsection
