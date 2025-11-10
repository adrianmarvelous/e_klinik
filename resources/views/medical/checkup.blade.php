@extends('dashboard')

@section('content')
<div class="card">
    <div class="card-body">
        <h2>Medical Check Up</h2>

        <form
            action="{{ isset($data->medicalHistory->medical_records->id)
                ? route('medical.update', $data->medicalHistory->medical_records->id)
                : route('medical.store') }}"
            method="post">

            @csrf
            @if (isset($data->medicalHistory->medical_records->id))
                @method('PUT')
            @endif

            {{-- === Ringkasan === --}}
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


            {{-- === Jadwal Pemeriksaan === --}}
            <div class="mt-4">
                <h5>Jadwal Pemeriksaan</h5>
                <div id="tanggalContainer" class="mt-2"></div>
                <button type="button" id="btnTambahJadwal" class="btn btn-primary mt-2">
                    Tambah Jadwal
                </button>
            </div>
            <div class="d-flex justify-content-end mt-3">
                <input type="hidden" name="medical_history_id" value="{{ $data->medical_history_id }}">
                <input type="hidden" name="poli_id" value="{{ $data->poli_id }}">
                <button class="btn btn-primary" type="submit">
                    {{ isset($data->medicalHistory->medical_records->id) ? 'Update' : 'Simpan' }}
                </button>
            </div>
        </form>
    </div>
</div>

{{-- STEP 1: Ambil data booked datetime dari backend --}}
<script>
    const bookedDateTimes = @json(
        $appointments->pluck('datetime')->map(fn($d) => \Carbon\Carbon::parse($d)->format('Y-m-d H:i'))
    );
</script>

{{-- STEP 2: Script utama --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('btnTambahJadwal');
    const container = document.getElementById('tanggalContainer');

    const jamList = [
        '08:00', '09:00', '10:00', '11:00',
        '12:00', '13:00', '14:00', '15:00', '16:00'
    ]; // kamu bisa ubah range jam di sini

    btn.addEventListener('click', function (e) {
        e.preventDefault();

        const div = document.createElement('div');
        div.classList.add('d-flex', 'align-items-center', 'gap-2', 'mb-2', 'flex-wrap');

        // === Input tanggal ===
        const inputDate = document.createElement('input');
        inputDate.type = 'date';
        inputDate.name = 'jadwal_tanggal[]';
        inputDate.classList.add('form-control', 'w-auto');

        // === Select jam ===
        const selectTime = document.createElement('select');
        selectTime.name = 'jadwal_jam[]';
        selectTime.classList.add('form-select', 'w-auto');

        // Saat tanggal dipilih, generate daftar jam
        inputDate.addEventListener('change', function() {
            const selectedDate = this.value;
            selectTime.innerHTML = ''; // reset options

            jamList.forEach(jam => {
                const fullDateTime = `${selectedDate} ${jam}`;
                const option = document.createElement('option');
                option.value = jam;
                option.textContent = jam;

                if (bookedDateTimes.includes(fullDateTime)) {
                    option.disabled = true;
                    option.style.color = 'red'; // warna merah untuk jam booked
                    option.textContent += ' (Booked)';
                }

                selectTime.appendChild(option);
            });
        });

        // Tombol hapus
        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.classList.add('btn', 'btn-danger', 'btn-sm');
        removeBtn.textContent = 'Hapus';
        removeBtn.addEventListener('click', () => div.remove());

        div.appendChild(inputDate);
        div.appendChild(selectTime);
        div.appendChild(removeBtn);
        container.appendChild(div);
    });
});
</script>
@endsection