@php

    // \Carbon\Carbon::
    $notif = DB::table('t_notif')
        ->where('is_delete', 'N')
        ->where('kd_user', auth()->user()->kd_user)
        ->where('status_notif', 'FALSE')
        ->orderBy('created_date', 'desc')
        ->limit(3);
    $status = [
        'Info' => 'bi bi-info-circle text-primary',
        'Reject' => 'bi bi-x-circle text-danger',
        'Approve' => 'bi bi-check-circle text-success',
        'Delete' => 'bi bi-trash text-warning',
        'DeleteApprove' => 'bi bi-trash text-success',
        'DeleteReject' => 'bi bi-trash text-danger',
    ];
@endphp
<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="dashboard" class="logo d-flex align-items-center">
            <img src="{{ asset('assets/img/logo-jamkrindo.png') }}" alt="">

        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>

    </div><!-- End Logo -->

    <span>
        <h3 class="fw-bolder fs-5 mt-2 ms-3">Portal Aplikasi</h3>
    </span>

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <li class="nav-item dropdown">

                <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-bell"></i>
                    <span class="badge bg-primary badge-number"> {{ $notif->count() }} </span>
                </a><!-- End Notification Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                    <li class="dropdown-header">
                        Kamu Memiliki {{ $notif->count() }} Notifikasi Baru
                        {{-- <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">Lihat Semua</span></a> --}}
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    @foreach ($notif->get() as $item)
                        <li class="notification-item">
                            <i class="{{ $status[$item->status] }}"></i>
                            <div>
                                <h4>{{ strtoupper($item->status) }}</h4>
                                {{-- <p style="  width: 250px; white-space: nowrap;overflow: hidden;text-overflow: ellipsis;"> {{$item->keterangan}} </p> --}}
                                <p> {{ $item->keterangan }} </p>
                                <p> <a onclick="return read_notif(event,{{ $item->id }})" href="">Klik
                                        disini</a>
                                </p>
                                <p> {{ \Carbon\Carbon::parse($item->created_date)->diffForHumans() }} </p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>
                    @endforeach

                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li class="dropdown-footer">
                        <a href="{{ route('notif.index') }}">Lihat semua notifikasi</a>
                    </li>

                </ul><!-- End Notification Dropdown Items -->

            </li><!-- End Notification Nav -->

            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    @if (auth()->user()->kd_customer)
                        @if (auth()->user()->foto_customer)
                            <img src="{{ asset('assets/img/customer/' . auth()->user()->foto_customer) }}"
                                alt="Profile" class="rounded-circle">
                        @else
                            <img src="{{ asset('assets/img/person.png') }}" alt="Profile" class="rounded-circle">
                        @endif
                    @else
                        <img src="{{ asset('assets/img/person.png') }}" alt="Profile" class="rounded-circle">
                    @endif
                    <span class="d-none d-md-block dropdown-toggle ps-2 ">
                        @if (auth()->user()->nm_user)
                        {{ auth()->user()->npp_user  . ' - ' .  auth()->user()->nm_user  }}
                        @else
                        {{ auth()->user()->nama_customer }}
                        @endif

                    </span>
                </a><!-- End Profile Iamge Icon -->
                @if (auth()->user()->nm_user)
                <span class="d-none d-md-block " style="font-size: 12px;"> {{auth()->user()->branch_name}} </span>
                @else
                <span class="d-none d-md-block " style="margin-left: 1rem;font-size: 12px;margin-top: -5px;"> {{auth()->user()->Branch->nm_cabang}} </span>
                @endif

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        @if (auth()->user()->nm_user)
                            <h6>
                                {{ auth()->user()->npp_user  . ' - ' .  auth()->user()->nm_user  }}

                            </h6>
                            <p> {{auth()->user()->branch_name}} </p>
                            @else
                            <h6>
                                {{ auth()->user()->nama_customer }}
                            </h6>
                            <p> {{auth()->user()->Branch->nm_cabang}} </p>
                        @endif
                        <!--<span>Web Designer</span>-->
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    @if (auth()->user()->nm_user)
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('profile') }}">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                    @else
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('profile-customer') }}">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                    @endif
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <!--<li>-->
                    <!--    <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">-->
                    <!--        <i class="bi bi-question-circle"></i>-->
                    <!--        <span>Need Help?</span>-->
                    <!--    </a>-->
                    <!--</li>-->
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        @if (auth()->user()->nm_user)
                            <a class="dropdown-item d-flex align-items-center text-danger"
                                href="{{ route('logout') }}">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        @else
                            <a class="dropdown-item d-flex align-items-center text-danger"
                                href="{{ route('logout-customer') }}">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        @endif
                    </li>

                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->

<script>
    function read_notif(event, id) {
        let t = this;
        event.preventDefault();
        console.log(id);
        $.ajax({
            url: "{{ route('notif.read') }}",
            type: 'POST',

            data: {
                id: id,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log(response);
                if (response.status == 'success') {
                    return window.location.href = response.tautan;
                } else {
                    alert('Gagal membaca notifikasi');
                }
            },
            error: function() {
                alert('Terjadi kesalahan pada server');

            }
        });

    }
</script>
<!-- ======= Header ======= -->
