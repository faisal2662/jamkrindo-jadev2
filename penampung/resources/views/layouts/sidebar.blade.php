  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">



      <ul class="sidebar-nav" id="sidebar-nav">
          @if (Auth::guard('web')->user())
              <?php
              $idAccount = Auth::user()->kd_user;
              $role = DB::table('t_role')->where('id_account', $idAccount)->get();
              ?>
              @foreach ($role as $rl)
                  @if ($rl->id_menu == 1)
                      @if ($rl->can_access == 'Y')
                          <a class="nav-link @if (request()->route()->uri == 'dashboard') '' @else collapsed @endif"
                              href="{{ route('dashboard') }}">
                              <i class="bi bi-grid"></i>

                              <span>Dashboard</span>
                          </a>
                      @endif
                  @endif
                  @if ($rl->id_menu == 2)
                      @if ($rl->can_access == 'Y')
                          <li class="nav-item  @if (request()->route()->uri == 'users-management' ||
                                  request()->route()->uri == 'users-management/tambah' ||
                                  request()->route()->uri == 'users-management/edit/{id}' ||
                                  request()->route()->uri == 'users-management/lihat/{id}') active @endif ">
                              <a class="nav-link @if (request()->route()->uri == 'users-management' ||
                                      request()->route()->uri == 'users-management/tambah' ||
                                      request()->route()->uri == 'users-management/edit/{id}' ||
                                      request()->route()->uri == 'users-management/lihat/{id}') '' @else collapsed @endif"
                                  href="{{ route('user-manager.index') }}">
                                  <i class="bi bi-person"></i>

                                  <span>Admin Management</span>
                              </a>
                          </li><!-- End Dashboard Nav -->
                      @endif
                  @endif
                  @if ($rl->id_menu == 3)
                      @if ($rl->can_access == 'Y')
                          <li class="nav-item  @if (request()->route()->uri == 'customers-management' ||
                                  request()->route()->uri == 'customers-management/lihat/{id}' ||
                                  request()->route()->uri == 'customers-management/edit/{id}') active @endif">
                              <a class="nav-link @if (request()->route()->uri == 'customers-management' ||
                                      request()->route()->uri == 'customers-management/lihat/{id}' ||
                                      request()->route()->uri == 'customers-management/edit/{id}') '' @else collapsed @endif"
                                  href="{{ route('customer-manager.index') }}">
                                  <i class="bi bi-person"></i>

                                  <span>Customer Management</span>
                              </a>
                          </li>
                      @endif
                  @endif
                  @if ($rl->id_menu == 16)
                      @if ($rl->can_access == 'Y')
                          <li class="nav-item  @if (request()->route()->uri == 'news-management' ||
                                  request()->route()->uri == 'news-management/lihat/{id}' ||
                                  request()->route()->uri == 'news-management/edit/{id}') active @endif">
                              <a class="nav-link @if (request()->route()->uri == 'news-management' ||
                                      request()->route()->uri == 'news-management/lihat/{id}' ||
                                      request()->route()->uri == 'news-management/edit/{id}') '' @else collapsed @endif"
                                  href="{{ route('news-manager.index') }}">
                                  <i class="bi bi-newspaper"></i>
                                  <span>News Management</span>
                              </a>
                          </li>
                      @endif
                  @endif
                  @if ($rl->id_menu == 4)
                      @if ($rl->can_access == 'Y')
                          <li class="nav-item  @if (request()->route()->uri == 'chat') active @endif">
                              <a class="nav-link @if (request()->route()->uri == 'chat') '' @else collapsed @endif"
                                  href="#" data-bs-toggle="modal" data-bs-target="#chatConfirmAdmin">
                                  <i class="bi bi-chat-dots"></i>

                                  <span>Chat Management</span>
                                  <span class="badge text-bg-light ms-5" id="is_read"></span>
                              </a>
                          </li>
                          <!-- End Dashboard Nav -->
                          <!--<li class="nav-item  @if (request()->route()->uri == 'chat') active @endif">-->
                          <!--    <a class="nav-link @if (request()->route()->uri == 'chat') '' @else collapsed @endif"-->
                          <!--        href="{{ route('chat') }}">-->
                          <!--        <i class="bi bi-chat-dots"></i>-->

                          <!--        <span>Chat Management</span>-->
                          <!--    </a>-->
                          <!--</li><!-- End Dashboard Nav -->
                      @endif
                  @endif
              @endforeach
              {{-- <li class="nav-item  @if (request()->route()->uri == 'dashboard') active @endif">
                  <a class="nav-link @if (request()->route()->uri == 'dashboard') '' @else collapsed @endif"
                      href="{{ route('dashboard') }}">
                      <i class="bi bi-grid"></i>

                      <span>Dashboard</span>
                  </a>
              </li><!-- End Dashboard Nav -->
              <li class="nav-item  @if (request()->route()->uri == 'users-management' || request()->route()->uri == 'users-management/tambah' || request()->route()->uri == 'users-management/edit/{id}' || request()->route()->uri == 'users-management/lihat/{id}') active @endif ">
                  <a class="nav-link @if (request()->route()->uri == 'users-management' || request()->route()->uri == 'users-management/tambah' || request()->route()->uri == 'users-management/edit/{id}' || request()->route()->uri == 'users-management/lihat/{id}') '' @else collapsed @endif"
                      href="{{ route('user-manager.index') }}">
                      <i class="bi bi-person"></i>

                      <span>Admin Management</span>
                  </a>
              </li><!-- End Dashboard Nav -->
              <li class="nav-item  @if (request()->route()->uri == 'customers-management' || request()->route()->uri == 'customers-management/lihat/{id}') active @endif">
                  <a class="nav-link @if (request()->route()->uri == 'customers-management' || request()->route()->uri == 'customers-management/lihat/{id}') '' @else collapsed @endif"
                      href="{{ route('customer-manager.index') }}">
                      <i class="bi bi-person"></i>

                      <span>Customer Management</span>
                  </a>
              </li>

              <li class="nav-item  @if (request()->route()->uri == 'chat') active @endif">
                  <a class="nav-link @if (request()->route()->uri == 'chat') '' @else collapsed @endif"
                       href="#" data-bs-toggle="modal" data-bs-target="#chatConfirmAdmin">
                      <i class="bi bi-chat-dots"></i>

                      <span>Chat Management</span>
                  </a>
              </li><!-- End Dashboard Nav --> --}}

              @foreach ($role as $rl)
                  @if ($rl->id_menu == 12)
                      @if ($rl->can_access == 'Y')
                          <li class="nav-heading">Master Data</li>
                      @endif
                  @endif
              @endforeach


              {{-- <li class="nav-heading">Master Data</li> --}}

              <li class="nav-item">
                  @foreach ($role as $rl)
                      @if ($rl->id_menu == 14)
                          @if ($rl->can_access == 'Y')
                              <a class="nav-link  @if (request()->route()->uri == 'categories-product' ||
                                      request()->route()->uri == 'categories-product/lihat/{id}' ||
                                      request()->route()->uri == 'products-management' ||
                                      request()->route()->uri == 'products-management/tambah' ||
                                      request()->route()->uri == 'products-management/edit/{id}' ||
                                      request()->route()->uri == 'products-management/lihat/{id}') active @else collapsed @endif"
                                  data-bs-target="#master-product" data-bs-toggle="collapse" href="#">
                                  <i class="bi bi-newspaper"></i><span>Master Produk</span><i
                                      class="bi bi-chevron-down ms-auto"></i>
                              </a>
                          @endif
                      @endif
                  @endforeach
                  {{-- <a class="nav-link  @if (request()->route()->uri == 'categories-product' || request()->route()->uri == 'categories-product/lihat/{id}' || request()->route()->uri == 'products-management' || request()->route()->uri == 'products-management/tambah' || request()->route()->uri == 'products-management/edit/{id}' || request()->route()->uri == 'products-management/lihat/{id}') active @else collapsed @endif"
                      data-bs-target="#master-product" data-bs-toggle="collapse" href="#">
                      <i class="bi bi-newspaper"></i><span>Master Produk</span><i
                          class="bi bi-chevron-down ms-auto"></i>
                  </a> --}}
                  <ul id="master-product" class="nav-content collapse @if (request()->route()->uri == 'categories-product' ||
                          request()->route()->uri == 'categories-product/lihat/{id}' ||
                          request()->route()->uri == 'products-management' ||
                          request()->route()->uri == 'products-management/tambah' ||
                          request()->route()->uri == 'products-management/edit/{id}' ||
                          request()->route()->uri == 'products-management/lihat/{id}') show @endif"
                      data-bs-parent="#sidebar-nav">
                      @foreach ($role as $rl)
                          @if ($rl->id_menu == 5)
                              @if ($rl->can_access == 'Y')
                                  <li>
                                      <a href="{{ route('product-manager.index') }}"
                                          class="@if (request()->route()->uri == 'products-management' ||
                                                  request()->route()->uri == 'products-management/tambah' ||
                                                  request()->route()->uri == 'products-management/edit/{id}' ||
                                                  request()->route()->uri == 'products-management/lihat/{id}') active @endif">
                                          <i class="bi bi-circle"></i><span>Product</span>
                                      </a>
                                  </li>
                              @endif
                          @endif
                          @if ($rl->id_menu == 6)
                              @if ($rl->can_access == 'Y')
                                  <li>
                                      <a href="{{ route('category-manager.index') }}"
                                          class="@if (request()->route()->uri == 'categories-product' || request()->route()->uri == 'categories-product/lihat/{id}') active @endif">
                                          <i class="bi bi-circle"></i><span>Category Product</span>
                                      </a>
                                  </li>
                              @endif
                          @endif
                      @endforeach
                      {{-- <li>
                          <a href="{{ route('product-manager.index') }}"
                              class="@if (request()->route()->uri == 'products-management' || request()->route()->uri == 'products-management/tambah' || request()->route()->uri == 'products-management/edit/{id}' || request()->route()->uri == 'products-management/lihat/{id}') active @endif">
                              <i class="bi bi-circle"></i><span>Product</span>
                          </a>
                      </li>
                      <li>
                          <a href="{{ route('category-manager.index') }}"
                              class="@if (request()->route()->uri == 'categories-product' || request()->route()->uri == 'categories-product/lihat/{id}') active @endif">
                              <i class="bi bi-circle"></i><span>Category Product</span>
                          </a>
                      </li> --}}

                  </ul>
              </li><!-- End Forms Nav -->

              <li class="nav-item">
                  @foreach ($role as $rl)
                      @if ($rl->id_menu == 15)
                          @if ($rl->can_access == 'Y')
                              <a class="nav-link  @if (request()->route()->uri == 'branchs-management' ||
                                      request()->route()->uri == 'branchs-management/lihat/{id}' ||
                                      request()->route()->uri == 'regions-of-management' ||
                                      request()->route()->uri == 'regions-of-management/lihat/{id}' ||
                                      request()->route()->uri == 'cities-management' ||
                                      request()->route()->uri == 'provincies-management') active @else collapsed @endif"
                                  data-bs-target="#master-lokasi" data-bs-toggle="collapse" href="#">
                                  <i class="bi bi-building"></i><span>Master Lokasi</span><i
                                      class="bi bi-chevron-down ms-auto"></i>
                              </a>
                          @endif
                      @endif
                  @endforeach
                  {{-- <a class="nav-link  @if (request()->route()->uri == 'branchs-management' || request()->route()->uri == 'branchs-management/lihat/{id}' || request()->route()->uri == 'regions-of-management' || request()->route()->uri == 'regions-of-management/lihat/{id}' || request()->route()->uri == 'cities-management' || request()->route()->uri == 'provincies-management') active @else collapsed @endif"
                      data-bs-target="#master-lokasi" data-bs-toggle="collapse" href="#">
                      <i class="bi bi-building"></i><span>Master Lokasi</span><i class="bi bi-chevron-down ms-auto"></i>
                  </a> --}}
                  <ul id="master-lokasi" class="nav-content collapse @if (request()->route()->uri == 'branchs-management' ||
                          request()->route()->uri == 'branchs-management/lihat/{id}' ||
                          request()->route()->uri == 'regions-of-management' ||
                          request()->route()->uri == 'regions-of-management/lihat/{id}' ||
                          request()->route()->uri == 'cities-management' ||
                          request()->route()->uri == 'provincies-management') show @endif"
                      data-bs-parent="#sidebar-nav">
                      @foreach ($role as $rl)
                          @if ($rl->id_menu == 7)
                              @if ($rl->can_access == 'Y')
                                  <li>
                                      <a href="{{ route('branch-manager.index') }}"
                                          class="@if (request()->route()->uri == 'branchs-management' || request()->route()->uri == 'branchs-management/lihat/{id}') active @endif">
                                          <i class="bi bi-circle"></i><span>Branch Management</span>
                                      </a>
                                  </li>
                              @endif
                          @endif
                          @if ($rl->id_menu == 8)
                              @if ($rl->can_access == 'Y')
                                  <li>
                                      <a href="{{ route('region-manager.index') }}"
                                          class="@if (request()->route()->uri == 'regions-of-management' || request()->route()->uri == 'regions-of-management/lihat/{id}') active @endif">
                                          <i class="bi bi-circle"></i><span>Region Of Management</span>
                                      </a>
                                  </li>
                              @endif
                          @endif
                          @if ($rl->id_menu == 9)
                              @if ($rl->can_access == 'Y')
                                  <li>
                                      <a href="{{ route('city-manager.index') }}"
                                          class="@if (request()->route()->uri == 'cities-management') active @endif">
                                          <i class="bi bi-circle"></i><span>City Management</span>
                                      </a>
                                  </li>
                              @endif
                          @endif
                          @if ($rl->id_menu == 10)
                              @if ($rl->can_access == 'Y')
                                  <li>
                                      <a href="{{ route('province-manager.index') }}"
                                          class="@if (request()->route()->uri == 'provincies-management') active @endif">
                                          <i class="bi bi-circle"></i><span>Province Management</span>
                                      </a>
                                  </li>
                              @endif
                          @endif
                      @endforeach
                      {{-- <li>
                          <a href="{{ route('branch-manager.index') }}"
                              class="@if (request()->route()->uri == 'branchs-management' || request()->route()->uri == 'branchs-management/lihat/{id}') active @endif">
                              <i class="bi bi-circle"></i><span>Branch Management</span>
                          </a>
                      </li>
                      <li>
                          <a href="{{ route('region-manager.index') }}"
                              class="@if (request()->route()->uri == 'regions-of-management' || request()->route()->uri == 'regions-of-management/lihat/{id}') active @endif">
                              <i class="bi bi-circle"></i><span>Region Of Management</span>
                          </a>
                      </li>
                      <li>
                          <a href="{{ route('city-manager.index') }}"
                              class="@if (request()->route()->uri == 'cities-management') active @endif">
                              <i class="bi bi-circle"></i><span>City Management</span>
                          </a>
                      </li>
                      <li>
                          <a href="{{ route('province-manager.index') }}"
                              class="@if (request()->route()->uri == 'provincies-management') active @endif">
                              <i class="bi bi-circle"></i><span>Province Management</span>
                          </a>
                      </li> --}}
                  </ul>
              </li><!-- End Forms Nav -->

              @foreach ($role as $rl)
                  @if ($rl->id_menu == 19)
                      @if ($rl->can_access == 'Y')
                          <li class="nav-heading">Reporting</li>
                      @endif
                  @endif
              @endforeach
              @foreach ($role as $rl)
                  @if ($rl->id_menu == 20)
                      @if ($rl->can_access == 'Y')
                          <li class="nav-item  @if (request()->route()->uri == 'report' || request()->route()->uri == 'report/customer') active @endif">
                              <a class="nav-link @if (request()->route()->uri == 'report' || request()->route()->uri == 'report/customer') '' @else collapsed @endif"
                                  href="{{ route('report.customer') }}">
                                  <i class="bi bi-file-earmark-person"></i>

                                  <span>Laporan Customer</span>
                              </a>
                          </li>
                      @endif
                  @endif
              @endforeach

              <li class="nav-item">
                  @foreach ($role as $rl)
                      @if ($rl->id_menu == 21)
                          @if ($rl->can_access == 'Y')
                              <a class="nav-link  @if (request()->route()->uri == 'branchs-management' ||
                                      request()->route()->uri == 'branchs-management/lihat/{id}' ||
                                      request()->route()->uri == 'regions-of-management' ||
                                      request()->route()->uri == 'regions-of-management/lihat/{id}' ||
                                      request()->route()->uri == 'cities-management' ||
                                      request()->route()->uri == 'provincies-management') active @else collapsed @endif"
                                  data-bs-target="#laporan-dwh" data-bs-toggle="collapse" href="#">
                                  <i class="bi bi-building"></i><span>Laporan DWH</span><i
                                      class="bi bi-chevron-down ms-auto"></i>
                              </a>
                          @endif
                      @endif
                  @endforeach
                  <ul id="laporan-dwh" class="nav-content collapse @if (request()->route()->uri == 'branchs-management' ||
                          request()->route()->uri == 'branchs-management/lihat/{id}' ||
                          request()->route()->uri == 'regions-of-management' ||
                          request()->route()->uri == 'regions-of-management/lihat/{id}' ||
                          request()->route()->uri == 'cities-management' ||
                          request()->route()->uri == 'provincies-management') show @endif"
                      data-bs-parent="#sidebar-nav">
                      @foreach ($role as $rl)
                          @if ($rl->id_menu == 22)
                              @if ($rl->can_access == 'Y')
                                  <li>
                                      <a href="{{ route('dwh.volume.penjaminan') }}"
                                          class="@if (request()->route()->uri == 'branchs-management' || request()->route()->uri == 'branchs-management/lihat/{id}') active @endif">
                                          <i class="bi bi-circle"></i><span>Volume Penjaminan</span>
                                      </a>
                                  </li>
                              @endif
                          @endif
                          @if ($rl->id_menu == 23)
                              @if ($rl->can_access == 'Y')
                                  <li>
                                      <a href="{{ route('dwh.serviceijp') }}"
                                          class="@if (request()->route()->uri == 'branchs-management' || request()->route()->uri == 'branchs-management/lihat/{id}') active @endif">
                                          <i class="bi bi-circle"></i><span>Service IJP003</span>
                                      </a>
                                  </li>
                              @endif
                          @endif
                          @if ($rl->id_menu == 24)
                              @if ($rl->can_access == 'Y')
                                  <li>
                                      <a href="{{ route('dwh.servicekld') }}"
                                          class="@if (request()->route()->uri == 'branchs-management' || request()->route()->uri == 'branchs-management/lihat/{id}') active @endif">
                                          <i class="bi bi-circle"></i><span>Service KLD001</span>
                                      </a>
                                  </li>
                              @endif
                          @endif
                          @if ($rl->id_menu == 25)
                              @if ($rl->can_access == 'Y')
                                  <li>
                                      <a href="{{ route('dwh.servicepr001') }}"
                                          class="@if (request()->route()->uri == 'branchs-management' || request()->route()->uri == 'branchs-management/lihat/{id}') active @endif">
                                          <i class="bi bi-circle"></i><span>Service PR001</span>
                                      </a>
                                  </li>
                              @endif
                          @endif
                          @if ($rl->id_menu == 26)
                              @if ($rl->can_access == 'Y')
                                  <li>
                                      <a href="{{ route('dwh.servicepr004') }}"
                                          class="@if (request()->route()->uri == 'branchs-management' || request()->route()->uri == 'branchs-management/lihat/{id}') active @endif">
                                          <i class="bi bi-circle"></i><span>Service PR004</span>
                                      </a>
                                  </li>
                              @endif
                          @endif
                          @if ($rl->id_menu == 27)
                              @if ($rl->can_access == 'Y')
                                  <li>
                                      <a href="{{ route('dwh.servicesbr002') }}"
                                          class="@if (request()->route()->uri == 'branchs-management' || request()->route()->uri == 'branchs-management/lihat/{id}') active @endif">
                                          <i class="bi bi-circle"></i><span>Service SBR002</span>
                                      </a>
                                  </li>
                              @endif
                          @endif
                          @if ($rl->id_menu == 28)
                              @if ($rl->can_access == 'Y')
                                  <li>
                                      <a href="{{ route('dwh.servicepdr008') }}"
                                          class="@if (request()->route()->uri == 'branchs-management' || request()->route()->uri == 'branchs-management/lihat/{id}') active @endif">
                                          <i class="bi bi-circle"></i><span>Service PDR008</span>
                                      </a>
                                  </li>
                              @endif
                          @endif
                      @endforeach
                  </ul>
              </li><!-- End Forms Nav -->

              @foreach ($role as $rl)
                  @if ($rl->id_menu == 29)
                      @if ($rl->can_access == 'Y')
                          <li class="nav-heading">MASTER SMTP</li>
                          <li class="nav-item  @if (request()->route()->uri == 'stmp') active @endif">
                              <a class="nav-link @if (request()->route()->uri == 'smtp') '' @else collapsed @endif"
                                  href="{{ route('smtp.index') }}">
                                  <i class="bi bi-envelope"></i>
                                  <span>SMTP</span>
                              </a>
                          </li>
                      @endif
                  @endif
                  @if ($rl->id_menu == 30)
                      @if ($rl->can_access == 'Y')
                          <li class="nav-heading">Log</li>
                          <li class="nav-item  @if (request()->route()->uri == 'audit-trail') active @endif">
                              <a class="nav-link @if (request()->route()->uri == 'audit-trail') '' @else collapsed @endif"
                                  href="{{ route('audit-trail.index') }}">
                                  <i class="bi bi-envelope"></i>
                                  <span>Audit Trails</span>
                              </a>
                          </li>
                      @endif
                  @endif
              @endforeach
              @foreach ($role as $rl)
                  @if ($rl->id_menu == 11)
                      @if ($rl->can_access == 'Y')
                          <li class="nav-heading">General Options</li>
                          <li class="nav-item ">
                              <a class="nav-link" href="{{ route('jade.role.index') }}">
                                  <i class="bi bi-person-lines-fill"></i>

                                  <span>Master Akses</span>
                              </a>
                          </li><!-- End Dashboard Nav -->
                      @endif
                  @endif
              @endforeach

          @endif
          @if (Auth::guard('customer')->user())
              <li class="nav-item  @if (request()->route()->uri == 'customer/dashboard') active @endif">
                  <a class="nav-link @if (request()->route()->uri == 'customer/dashboard') '' @else collapsed @endif"
                      href="{{ route('dashboard-customer') }}">
                      <i class="bi bi-grid"></i>

                      <span>Dashboard</span>
                  </a>
              </li><!-- End Dashboard Nav -->
              <li class="nav-item  @if (request()->route()->uri == 'chat-customer') active @endif">
                  <a class="nav-link @if (request()->route()->uri == 'chat-customer') '' @else collapsed @endif" href="#"
                      data-bs-toggle="modal" data-bs-target="#chatConfirm">
                      <i class="bi bi-chat-dots"></i>

                      <span>Chat Management</span>
                  </a>
              </li><!-- End Dashboard Nav -->
          @endif

      </ul>

  </aside><!-- End Sidebar-->

  <div class="modal fade" id="chatConfirmAdmin" tabindex="-1">
      <div class="modal-dialog modal-sm">
          <div class="modal-content">
              <div class="modal-header">
                  <h6 class="modal-title">Apakah anda akan melakukan chat ? </h6>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                  <a href="{{ route('chat') }}" class="btn btn-primary btn-sm">Ya</a>
              </div>
          </div>
      </div>
  </div><!-- End Small Modal-->
  <div class="modal fade" id="chatConfirm" tabindex="-1">
      <div class="modal-dialog modal-sm">
          <div class="modal-content">
              <div class="modal-header">
                  <h6 class="modal-title">Apakah anda akan melakukan chat ? </h6>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                  <a href="{{ route('chat-customer') }}" class="btn-primary btn btn-sm">Ya</a>
              </div>
          </div>
      </div>
  </div><!-- End Small Modal-->
