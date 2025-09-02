@extends('dashboard')

@section('content')
    <style>
        /* Remove Bootstrap's default underline */
        .custom-nav .nav-link.active {
            border-bottom: none !important;
        }

        /* Container for underline animation */
        .underline {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            background-color: #0d6efd; /* Bootstrap primary */
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .custom-nav {
            position: relative;
            display: flex;
        }

        .hover-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-card:hover {
            transform: scale(1.08);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .card-border-green {
            border: 2px solid #198754; /* Bootstrap success green */
            background-color: #fff;
        }

        .card-border-green .card-header {
            border-bottom: 2px solid #198754;
        }
    </style>

    <div class="card">
        <div class="card-body">
            <h2>Pilih Jadwal Dokter</h2>

            <!-- Nav Tabs for Doctors -->
            <ul class="nav nav-line nav-color-secondary custom-nav" id="doctorTab" role="tablist">
                @foreach ($doctors as $doctor)
                    <li class="nav-item">
                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" 
                           id="tab-doctor-{{ $doctor->id }}"
                           data-bs-toggle="tab" 
                           href="#doctor-{{ $doctor->id }}" 
                           role="tab">
                            {{ $doctor->name }}
                        </a>
                    </li>
                @endforeach
                <div class="underline"></div>
            </ul>

            <!-- Doctor Tab Content -->
            <div class="tab-content mt-3">
                @foreach ($doctors as $doctor)
                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" 
                         id="doctor-{{ $doctor->id }}" 
                         role="tabpanel">

                        <!-- Second Nav Tabs (Dates) -->
                        <ul class="nav nav-line nav-color-secondary custom-nav" id="dateTab-{{ $doctor->id }}" role="tablist">
                            @for ($d = 0; $d <= 5; $d++)
                                @php
                                    $date = now()->addDays($d);
                                @endphp
                                <li class="nav-item">
                                    <a class="nav-link {{ $d === 0 ? 'active' : '' }}"
                                       id="tab-date-{{ $doctor->id }}-{{ $d }}"
                                       data-bs-toggle="tab"
                                       href="#date-{{ $doctor->id }}-{{ $d }}"
                                       role="tab">
                                        {{ $date->format('d-M') }}
                                    </a>
                                </li>
                            @endfor
                            <div class="underline"></div>
                        </ul>

                        <!-- Date Tab Content -->
                        <div class="tab-content mt-3">
                            @for ($d = 0; $d <= 7; $d++)
                                @php
                                    $date = now()->addDays($d);
                                    $start = strtotime("08:00");
                                @endphp
                                <div class="tab-pane fade {{ $d === 0 ? 'show active' : '' }}" 
                                     id="date-{{ $doctor->id }}-{{ $d }}" 
                                     role="tabpanel">
                                    <h5>Jadwal untuk {{ $date->format('l, d M Y') }}</h5>

                                    <div class="row">
                                        @for ($i = 0; $i < 9; $i++)
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <form action="{{ route('appoinment.save_schedule') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="patient_id" value="{{ $patient_id }}">
                                                <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
                                                <input type="hidden" name="date" value="{{ $date->format('Y-m-d') }}">
                                                <input type="hidden" name="time" value="{{ date('H:i', strtotime("+$i hour", $start)) }}">

                                                <button type="submit" class="btn p-0 w-100 border-0 bg-transparent text-start" style="height: 150px">
                                                    <div class="card shadow-sm h-100 hover-card bg-success-gradient">
                                                        <div class="card-body bubble-shadow text-white">
                                                            <div class="d-flex justify-content-between">
                                                                <h4 class="mb-1">
                                                                    {{ date("H:i", strtotime("+$i hour", $start)) }}
                                                                </h4>
                                                                <h4 class="mb-1">
                                                                    {{ $date->format('d M Y') }}
                                                                </h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </button>
                                            </form>
                                        </div>
                                        @endfor
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // handle underline animation for ALL custom-nav sets (doctor + date)
            document.querySelectorAll(".custom-nav").forEach(nav => {
                const underline = nav.querySelector(".underline");
                const links = nav.querySelectorAll(".nav-link");

                function moveUnderline(activeLink) {
                    underline.style.width = activeLink.offsetWidth + "px";
                    underline.style.left = activeLink.offsetLeft + "px";
                }

                // init
                const active = nav.querySelector(".nav-link.active");
                if (active) moveUnderline(active);

                // update on tab shown
                links.forEach(link => {
                    link.addEventListener("shown.bs.tab", function () {
                        moveUnderline(this);
                    });
                });
            });
        });
    </script>
@endsection
