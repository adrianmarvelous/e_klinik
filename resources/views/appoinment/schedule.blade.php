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
    </style>

    <div class="card">
        <div class="card-body">
            <h2>Pilih Jadwal Dokter</h2>

            <!-- Nav Tabs -->
            <ul class="nav nav-line nav-color-secondary custom-nav" id="myTab" role="tablist">
                @foreach ($doctors as $no => $doctor)
                    <li class="nav-item">
                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" 
                           id="tab-{{ $doctor->id }}"
                           data-bs-toggle="tab" 
                           href="#doctor-{{ $doctor->id }}" 
                           role="tab">
                            {{ $doctor->name }}
                        </a>
                    </li>
                @endforeach
                <div class="underline"></div>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content mt-3">
                @foreach ($doctors as $no => $doctor)
                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" 
                         id="doctor-{{ $doctor->id }}" 
                         role="tabpanel">
                        <div class="card p-3">
                            @php
                                $start = strtotime("08:00");
                            @endphp
                            <div class="row">
                                @for ($i = 0; $i < 9; $i++)
                                <div class="col-lg-4 col-md-6 mb-3">
                                    <a href="" class="text-decoration-none">
                                        <div class="card border-success shadow-sm h-100 bg-success hover-card">
                                            <div class="card-body text-center">
                                                <h4 class="text-white mb-0">
                                                    {{ date("H:i", strtotime("+$i hour", $start)) }}
                                                </h4>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                @endfor
                            </div>


                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const navLinks = document.querySelectorAll(".custom-nav .nav-link");
            const underline = document.querySelector(".underline");

            function moveUnderline(activeLink) {
                underline.style.width = activeLink.offsetWidth + "px";
                underline.style.left = activeLink.offsetLeft + "px";
            }

            // Set initial position
            const active = document.querySelector(".custom-nav .nav-link.active");
            if (active) moveUnderline(active);

            // Update on click
            navLinks.forEach(link => {
                link.addEventListener("shown.bs.tab", function () {
                    moveUnderline(this);
                });
            });
        });
    </script>
@endsection
