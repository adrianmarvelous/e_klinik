@extends('dashboard')

@section('content')
    <style>
        /* === STYLES === */
        .custom-nav .nav-link.active {
            border-bottom: none !important;
        }

        .underline {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            background-color: #0d6efd;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .custom-nav {
            position: relative;
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
            white-space: nowrap;
            scrollbar-width: none;
        }

        .custom-nav::-webkit-scrollbar {
            display: none;
        }

        .hover-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .slot-card {
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            border-radius: 10px;
            overflow: hidden;
        }

        .slot-card:hover {
            transform: scale(1.02);
        }

        .slot-radio:checked+.slot-card {
            outline: 3px solid #fff;
            box-shadow: 0 0 12px rgba(0, 255, 100, 0.8);
            border: 8px solid #002fff;
        }

        @media (max-width: 768px) {
            h2 {
                font-size: 1.25rem;
            }

            .slot-card h4 {
                font-size: 1rem;
            }
        }

        .bg-success-gradient {
            background: linear-gradient(45deg, #28a745, #85e085);
        }
    </style>

    <div class="card">
        <div class="card-body">
            <h2>Buat Keluhan</h2>

            <form action="{{ isset($data) ? route('appoinment.update', $data->id) : route('appoinment.store') }}"
                method="post">

                @csrf
                @if (isset($data))
                    @method('PUT')
                @endif

                {{-- ================= FORM KELUHAN ================= --}}
                @php
                    $fields = [
                        ['label' => 'Keluhan Utama', 'name' => 'main_complaint', 'type' => 'text', 'required' => true],
                        ['label' => 'Keluhan Tambahan', 'name' => 'additional_complaint', 'type' => 'text'],
                        ['label' => 'Lama Sakit', 'name' => 'illness_duration', 'type' => 'text', 'required' => true],
                    ];
                @endphp

                @foreach ($fields as $field)
                    <div class="row mt-3">
                        <div class="col-lg-2">
                            <label class="fw-bold form-label mb-0">{{ $field['label'] }}</label>
                        </div>
                        <div class="col-lg-10">
                            <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" class="form-control"
                                value="{{ old($field['name'], $data->medicalHistory->{$field['name']} ?? '') }}"
                                @if (!empty($field['required'])) required @endif>
                        </div>
                    </div>
                @endforeach


                @php
                    $selects = [
                        ['label' => 'Merokok', 'name' => 'smoking'],
                        ['label' => 'Konsumsi Alkohol', 'name' => 'alcohol_consumption'],
                        ['label' => 'Kurang Sayur Buah', 'name' => 'low_fruit_veggie_intake'],
                    ];
                @endphp

                @foreach ($selects as $select)
                    <div class="row mt-3">
                        <div class="col-lg-2">
                            <label class="fw-bold form-label mb-0">{{ $select['label'] }}</label>
                        </div>
                        <div class="col-lg-10">
                            <select name="{{ $select['name'] }}" class="form-select" required>
                                <option value="" disabled>Silahkan Pilih</option>

                                <option value="1"
                                    {{ old($select['name'], $data->medicalHistory->{$select['name']} ?? null) == 1 ? 'selected' : '' }}>
                                    Iya
                                </option>

                                <option value="0"
                                    {{ old($select['name'], $data->medicalHistory->{$select['name']} ?? null) === 0 ? 'selected' : '' }}>
                                    Tidak
                                </option>
                            </select>
                        </div>
                    </div>
                @endforeach


                {{-- ================= PILIH JADWAL DOKTER ================= --}}
                <div class="card mt-4">
                    <div class="card-body">
                        <h2>Pilih Jadwal</h2>

                        <!-- Nav Tabs for Doctors -->
                        <ul class="nav nav-line nav-color-secondary custom-nav" id="doctorTab" role="tablist">
                            @foreach ($polis as $poli)
                                <li class="nav-item">
                                    <a class="nav-link {{ $loop->first ? 'active' : '' }}"
                                        id="tab-doctor-{{ $poli->id }}" data-bs-toggle="tab"
                                        href="#doctor-{{ $poli->id }}" role="tab">
                                        {{ $poli->name }}
                                    </a>
                                </li>
                            @endforeach
                            <div class="underline"></div>
                        </ul>

                        <!-- Doctor Tabs Content -->
                        <div class="tab-content mt-3">
                            @foreach ($polis as $doctor)
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                    id="doctor-{{ $doctor->id }}" role="tabpanel">

                                    <!-- Date Tabs -->
                                    <ul class="nav nav-line nav-color-secondary custom-nav"
                                        id="dateTab-{{ $doctor->id }}" role="tablist">
                                        @for ($d = 0; $d <= 5; $d++)
                                            @php
                                                $date = now()->addDays($d);
                                                $isSunday = $date->isSunday();
                                            @endphp
                                            <li class="nav-item">
                                                @if ($isSunday)
                                                    <a class="nav-link text-danger disabled"
                                                        style="pointer-events:none;opacity:0.6;">
                                                        {{ $date->format('d-M') }}
                                                    </a>
                                                @else
                                                    <a class="nav-link {{ $d === 0 ? 'active' : '' }}"
                                                        id="tab-date-{{ $doctor->id }}-{{ $d }}"
                                                        data-bs-toggle="tab"
                                                        href="#date-{{ $doctor->id }}-{{ $d }}"
                                                        role="tab">
                                                        {{ $date->format('d-M') }}
                                                    </a>
                                                @endif
                                            </li>
                                        @endfor
                                        <div class="underline"></div>
                                    </ul>

                                    <!-- Time Slots -->
                                    <div class="tab-content mt-3">
                                        @for ($d = 0; $d <= 5; $d++)
                                            @php
                                                $date = \Carbon\Carbon::now()->startOfDay()->addDays($d);
                                                $isSaturday = $date->isSaturday();
                                                $isSunday = $date->isSunday();
                                                $maxSlots = $isSaturday ? 6 : 9;
                                            @endphp

                                            <div class="tab-pane fade {{ $d === 0 ? 'show active' : '' }}"
                                                id="date-{{ $doctor->id }}-{{ $d }}" role="tabpanel">

                                                @if ($isSunday)
                                                    <div class="alert alert-warning text-center">
                                                        Klinik tutup pada hari Minggu.
                                                    </div>
                                                @else
                                                    <h5>Jadwal untuk {{ $date->translatedFormat('l, d M Y') }}</h5>

                                                    <div class="row">
                                                        @for ($i = 0; $i < $maxSlots; $i++)
                                                            @php
                                                                $slot = $date->copy()->setTime(8, 0)->addHours($i);
                                                                $end = $slot->copy()->addHour();

                                                                $appointmentExists = $doctors->contains(function (
                                                                    $app,
                                                                ) use ($slot, $doctor) {
                                                                    return $app->poli_id == $doctor->id &&
                                                                        \Carbon\Carbon::parse($app->datetime)->equalTo(
                                                                            $slot,
                                                                        );
                                                                });

                                                                $editingDateTime = isset($data)
                                                                    ? \Carbon\Carbon::parse($data->datetime)
                                                                    : null;

                                                                $isEditingSlot =
                                                                    $editingDateTime &&
                                                                    $editingDateTime->equalTo($slot) &&
                                                                    $data->poli_id == $doctor->id;

                                                                $isToday = $slot->isToday();
                                                                $now = now();
                                                                $isPast =
                                                                    $isToday &&
                                                                    $slot->lessThanOrEqualTo(
                                                                        $now->addHour()->startOfHour(),
                                                                    );

                                                                $isLunchBreak = $slot->format('H:i') === '13:00';

                                                                $disabled =
                                                                    !$isEditingSlot &&
                                                                    ($appointmentExists || $isPast || $isLunchBreak);
                                                            @endphp

                                                            <div class="col-lg-4 col-md-6 mb-3">
                                                                <label class="w-100">
                                                                    <input type="radio" name="selected_slot"
                                                                        value="{{ $slot->format('Y-m-d H:i') }}"
                                                                        data-poli="{{ $doctor->id }}"
                                                                        class="d-none slot-radio"
                                                                        @if ($isEditingSlot) checked @endif
                                                                        @if ($disabled) disabled @endif
                                                                        required>

                                                                    <div
                                                                        class="card shadow-sm h-100 hover-card
                                                        {{ $isEditingSlot ? 'bg-primary' : ($appointmentExists || $disabled ? 'bg-danger' : 'bg-success-gradient') }}
                                                        text-white slot-card">
                                                                        <div class="card-body bubble-shadow">
                                                                            <div class="d-flex justify-content-between">
                                                                                <h4 class="mb-1">
                                                                                    {{ $slot->format('H:i') }} -
                                                                                    {{ $end->format('H:i') }}
                                                                                </h4>
                                                                                <h4 class="mb-1">
                                                                                    {{ $slot->format('d M Y') }}
                                                                                </h4>
                                                                            </div>

                                                                            <span
                                                                                class="badge
                                                                {{ $isEditingSlot ? 'bg-info' : ($appointmentExists || $isLunchBreak || $isPast ? 'bg-danger' : 'bg-success') }}">
                                                                                @if ($isEditingSlot)
                                                                                    Appointment Anda
                                                                                @elseif ($appointmentExists)
                                                                                    Booked
                                                                                @elseif ($isLunchBreak)
                                                                                    Break
                                                                                @elseif ($isPast)
                                                                                    Closed
                                                                                @else
                                                                                    Available
                                                                                @endif
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                        @endfor
                                                    </div>
                                                @endif
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>


                {{-- ✅ Hidden input that will be updated when user selects a slot --}}
                <input type="hidden" name="poli_id" id="selected_poli_id">

                <div class="d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-primary px-5 py-2">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // === Underline animation ===
            document.querySelectorAll(".custom-nav").forEach(nav => {
                const underline = nav.querySelector(".underline");
                const links = nav.querySelectorAll(".nav-link");

                function moveUnderline(activeLink) {
                    underline.style.width = activeLink.offsetWidth + "px";
                    underline.style.left = activeLink.offsetLeft + "px";
                }

                const active = nav.querySelector(".nav-link.active");
                if (active) moveUnderline(active);

                links.forEach(link => {
                    link.addEventListener("shown.bs.tab", function() {
                        moveUnderline(this);
                    });
                });
            });

            // === Capture poli_id when a slot is clicked ===
            const radios = document.querySelectorAll('.slot-radio');
            const hiddenInput = document.getElementById('selected_poli_id');

            radios.forEach(radio => {
                radio.addEventListener('change', function() {
                    hiddenInput.value = this.dataset.poli;
                });
            });
        });
    </script>
@endsection
