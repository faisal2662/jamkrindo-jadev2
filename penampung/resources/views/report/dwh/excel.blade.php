<?php 
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Laporan_BMHD_".$date.".xls");
 ?>                    
  <!doctype html>
  <html lang="en">
  
  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Laporan Pelanggan</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
      <style>
          table,
          th,
          td {
              border: 1px solid black;
              border-collapse: collapse;
              padding: 5px;
          }
      </style>
  
  </head>
  
  <body>
      <div class="container">
          <p>&nbsp;</p>
          <div class="row">
              <div class="col-md-12" style="border-bottom: 1px solid #000;">
                  <center>
                      <img src="{{ asset('assets/img/kop-surat.png') }}" style="width: 60%;border-radius: 5px;">
                  </center>
                  <p>&nbsp;</p>
              </div>
              <div class="col-md-12" style="border-top: 3px solid #000;margin-top: 5px;">
                  <p>&nbsp;</p>
              </div>
          </div>
          <div class="row">
              <div class="col-md-8">
                  <p>Keterangan : <b>Laporan Pengaduan</b></p>
                  <p>
                      Tanggal Periode : <b><?= date('j F Y', strtotime($start)) ?> s/d
                          <?= date('j F Y', strtotime($end)) ?></b>
                  </p>
                  <p>&nbsp;</p>
              </div>
              <!-- <div class="col-md-4 text-end">
                  <button type="button" id="btnPdf" class="btn btn-danger btn-sm"><i class="bi bi-filetype-pdf"></i> PDF</button>
                  <button type="button" id="btnExcel" class="btn btn-success btn-sm"><i class="bi bi-file-earmark-excel"></i> Excel</button>
              </div> -->
          </div>
          
          @php
              $noc = 1;
          @endphp
          @foreach ($customers as $item)
              <div class="row">
                  <p><span><strong>Information User</strong></span></p>
              </div>
              <div class="row">
                  <div class="table-responsive">
                      <table class="table table-striped">
                          <thead>
                              <tr>
                                  <th>No.</th>
                                  <th>Nama User Jade</th>
                                  <th>Unit Kerja</th>
                                  <th>Email</th>
                                  <th>No. Telpon</th>
                                  <th>Kode Referral </th>
                                  <th>Nama Perusahaan</th>
                                  <th>Provinsi Perusahaan</th>
                                  <th>Kota Perusahaan</th>
                                  <th>Periode Register</th>
                              </tr>
                          </thead>
                          <tbody>
                              <tr>
                                  <td>{{ $loop->iteration }}</td>
                                  <td>{{ $item->nama_customer }}</td>
                                  @if ($item->branch)
                                      <td>{{ $item->branch->nm_cabang }}</td>
                                  @else
                                      <td></td>
                                  @endif
                                  <td>{{ $item->email_customer}}</td>
                                  <td>{{ $item->hp_customer }}</td>
                                  <td>{{ $item->kd_referral_customer }}</td>
                                  <td>{{ $item->company_name }}</td>
                                  @if ($item->province)
                                      <td>{{ $item->province->nm_provinsi }}</td>
                                  @else
                                      <td></td>
                                  @endif
                                  @if ($item->city)
                                      <td>{{ $item->city->nm_kota }}</td>
                                  @else
                                      <td></td>
                                  @endif
                                  <td>{{ $item->created_date }}</td>
                              </tr>
                          </tbody>
                      </table>
                  </div>
                  <div class="row">
                      <p><span><strong>Information Chatting</strong></span></p>
                  </div>
                  <div class="row">
                      <div class="table-responsive">
                          <table class="table table-striped">
                              <thead>
                                  <tr>
                                      <th>No.</th>
                                      <th>Nama User Jade</th>
                                      <th>Unit Kerja</th>
                                      <th>Start Chat</th>
                                      <th>Duration Chat</th>
                                      <th>Close Chat</th>
                                      <th>Chatting</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  @php
                                      $getConversation = DB::table('t_percakapan')->where('kd_customer', $item->kd_customer)->first();
                                      $conversation = DB::table('t_percakapan')->where('kd_customer', $item->kd_customer)->get();
                                      $hours = '';
                                      $minutes = '';
                                      if($getConversation){
                                          $firstMessage = DB::table('t_pesan')->where('conversation_id', $getConversation->id)->where('status', '0')->orderBy('created_date', 'ASC')->first();
                                          $secondMessage = DB::table('t_pesan')->where('conversation_id', $getConversation->id)->where('status', '1')->orderBy('created_date', 'ASC')->first();
                                          $lastMessage = DB::table('t_pesan')->where('conversation_id', $getConversation->id)->orderBy('created_date', 'DESC')->first();
                                          $startTime = new DateTime($firstMessage->created_date);
                                          $endTime = new DateTime($lastMessage->created_date);
                                          $diffInSeconds = strtotime($lastMessage->created_date) - strtotime($firstMessage->created_date);
                                          $hours = floor($diffInSeconds / 3600);
                                          $minutes = floor(($diffInSeconds % 3600) / 60);
                                      }
                                      $no = 1;
                                  @endphp
                                  @foreach ($conversation as $items)
                                      <tr>
                                          <td>{{ $loop->iteration }}</td>
                                          <td>{{ $item->nama_customer }}</td>
                                          @if ($item->branch)
                                              <td>{{ $item->branch->nm_cabang }}</td>
                                          @else
                                              <td></td>
                                          @endif
                                          <td>{{ $firstMessage->created_date }}</td>
                                          <td>{{ $hours . ' Jam ' . $minutes . ' Menit' }}</td>
                                          <td>{{ $lastMessage->created_date }}</td>
                                          <td> 
                                              @php
                                                  if($getConversation){
                                                      $messages = DB::table('t_pesan')->leftJoin('m_users', 't_pesan.send_id', 'm_users.kd_user')->leftJoin('m_customer', 't_pesan.send_id', 'm_customer.kd_customer')->where('conversation_id', $getConversation->id)->select('t_pesan.*', 'm_users.employee_name', 'm_customer.nama_customer')->get();
                                                  }
                                              @endphp
                                              <div class="short-conversation" id="{{ $noc }}short-conversation_{{ $no }}">
                                                  <div class="row border-bottom border-primary" style="margin: 0;padding:0;">
                                                      <div class="col  text-center text-primary  ">
                                                          <span style="display:block;">{{ 'Admin' }}</span>
                                                          {{-- <span> {{ 'Cabang Jakarta' }} </span> --}}
                                                      </div>
                                                      <div class="col  text-center text-primary  ">
                                                          <span style="display: block">{{ 'Customer' }}</span>
                                                          {{-- <span> {{ $item->customer }} </span> --}}
                                                      </div>
                                                  </div>
                                                  @for ($i = 0; $i < 5; $i++)
                                                      <div class="row border-bottom" style="margin: 0;padding:0;">
                                                          @if ($messages[$i]->status == '1')
                                                              <div class="col-12 text-start " style=" margin-right: 10px;">
                                                                  <span class=" text-primary" style="display:block;">{{ $messages[$i]->employee_name }}</span>
                                                                  <span style="display:block;"> {{ $messages[$i]->message }} </span>
                                                                  <span style="display:block;">
                                                                      {{-- <small>{{ \Carbon\Carbon::parse($messages[$i]->created_date)->translatedFormat('j F Y h:i') }}</small> --}}
                                                                      <small>{{ $messages[$i]->created_date }}</small>
                                                                  </span>
                                                              </div>
                                                          @elseif($messages[$i]->status == '0')
                                                              <div class="col-12  " style=" text-align:end; margin-right:5px; margin-left: 10px;">
                                                                  <span class=" text-primary" style="display:block;">{{ $messages[$i]->nama_customer }}</span>
                                                                  <span style="display:block;"> {{ $messages[$i]->message }} </span>
                                                                  <span style="display:block;">
                                                                      {{-- <small>{{ \Carbon\Carbon::parse($messages[$i]->created_date)->translatedFormat('j F Y h:i') }}</small> --}}
                                                                      <small>{{ $messages[$i]->created_date }}</small>
                                                                      {{-- <small>{{ $msg->created_date }}</small> --}}
                                                                  </span>
                                                              </div>
                                                          @endif
                                                          {{-- <div class="col  text-center text-primary"><p class="fw-bold">Divisi Lain</p></div> --}}
                                                      </div>
                                                  @endfor
                                                  {{-- <button class="btn btn-primary mt-3" id="toggle-btn">Selengkapnya</button> --}}
                                              </div>
                                              <div class="full-conversation" id="{{ $noc }}full-conversation_{{ $no }}" style="display: none;">
                                                  <div class="row border-bottom border-primary" style="margin: 0;padding:0;">
                                                      <div class="col  text-center text-primary  ">
                                                          <span style="display:block;">{{ 'Admin' }}</span>
                                                          {{-- <span> {{ 'Cabang Jakarta' }} </span> --}}
                                                      </div>
                                                      <div class="col  text-center text-primary  ">
                                                          <span style="display: block">{{ 'Customer' }}</span>
                                                          {{-- <span> {{ $item->customer }} </span> --}}
                                                      </div>
                                                  </div>
                                                  {{-- @if(!is_null($message->chats)) --}}
                                                  @foreach ($messages as $msg)
                                                      <div class="row border-bottom" style="margin: 0;padding:0;">
                                                          @if ($msg->status == '1')
                                                              <div class="col-12 text-start " style=" margin-right: 10px;">
                                                                  <span class=" text-primary" style="display:block;">{{ $msg->employee_name }}</span>
                                                                  <span style="display:block;"> {{ $msg->message }} </span>
                                                                  <span style="display:block;">
                                                                      {{-- <small>{{ \Carbon\Carbon::parse($msg->created_date)->translatedFormat('j F Y h:i') }}</small> --}}
                                                                      <small>{{ $msg->created_date }}</small>
                                                                  </span>
                                                              </div>
                                                          @elseif($msg->status == '0')
                                                              <div class="col-12  " style=" text-align:end; margin-right:5px; margin-left: 10px;">
                                                                  <span class=" text-primary" style="display:block;">{{ $msg->nama_customer }}</span>
                                                                  <span style="display:block;"> {{ $msg->message }} </span>
                                                                  <span style="display:block;">
                                                                      {{-- <small>{{ \Carbon\Carbon::parse($msg->created_date)->translatedFormat('j F Y h:i') }}</small> --}}
                                                                      <small>{{ $msg->created_date }}</small>
                                                                      {{-- <small>{{ $msg->created_date }}</small> --}}
                                                                  </span>
                                                              </div>
                                                          @endif
                                                          {{-- <div class="col  text-center text-primary"><p class="fw-bold">Divisi Lain</p></div> --}}
                                                      </div>
                                                  @endforeach
                                                  {{-- @endif --}}
                                              </div>
  
                                              <!-- Tombol untuk menampilkan seluruh konten -->
                                              <a href="#" id="{{ $noc }}btnShort_{{ $no }}" type="button" onclick="collapseConversation({{ $noc }},{{ $no }})">Selengkapnya</a>
                                              @php
                                                  $no++;
                                              @endphp
                                          </td>
                                      </tr>
                                  @endforeach
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
              <div class="col-md-12" style="border-top: 3px solid #000;margin-top: 5px;">
                  <p>&nbsp;</p>
              </div>
              @php
                  $noc++;
              @endphp
          @endforeach
      </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
          integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
      </script>
      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
      <script>
          function collapseConversation(noc,no){
              event.preventDefault();
              var btnCollapse = document.getElementById(noc + 'btnShort_' + no);
              var shortConversation = document.getElementById(noc + 'short-conversation_' + no);
              var fullConversation = document.getElementById(noc + 'full-conversation_' + no);// Jika konten penuh disembunyikan, tampilkan konten penuh dan sembunyikan konten singkat
              // console.log(shortConversation);
              
              if (fullConversation.style.display == 'none') {
                  shortConversation.style.display = 'none';
                  fullConversation.style.display = 'block';
                  btnCollapse.innerHTML = 'Tutup'; // Ganti teks tombol menjadi 'Tutup'
              } else {
                  shortConversation.style.display = 'block';
                  fullConversation.style.display = 'none';
                  btnCollapse.innerHTML = 'Selengkapnya'; // Ganti teks tombol kembali
              }
  
          }
          $('#btnPdf').on('click', function(e) {
              e.preventDefault();
              window.open('{{ route("report.customer.pdf") }}' + '?startDate=' + $('#startDate').val() + '&endDate=' + $('#endDate').val(), '_blank');
          });
          $('#btnExcel').on('click', function(e) {
              e.preventDefault();
              window.open('{{ route("report.customer.excel") }}' + '?startDate=' + $('#startDate').val() + '&endDate=' + $('#endDate').val(), '_blank');
          });
          // document.getElementById('btnShort').addEventListener('click', function() {
          // // $('#btnShort').on('click', function(){
          // });
      </script>
      {{-- <script>window.print()</script> --}}
  </body>
  
  </html>
  