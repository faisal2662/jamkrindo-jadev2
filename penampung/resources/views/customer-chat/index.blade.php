@extends('layouts.main')
@section('style')
    <style>
        .card {
            background: #fff;
            transition: .5s;
            border: 0;
            hat-histor margin-bottom: 30px;
            border-radius: .55rem;
            position: relative;
            width: 100%;
            box-shadow: 0 1px 2px 0 rgb(0 0 0 / 10%);
        }

        #toast {
            visibility: hidden;
            min-width: 50px;
            margin-left: -125px;
            color: #fff;
            text-align: center;
            border-radius: 2px;
            padding: 16px;
            position: fixed;
            z-index: 1;
            right: 30px;
            top: 80px;
            font-size: 17px;
        }

        #toast.show {
            visibility: visible;
            animation: fadein 0.5s, fadeout 0.5s 2.5s;
        }

        @keyframes fadein {
            from {
                top: 0;
                opacity: 0;
            }

            to {
                top: 80px;
                opacity: 1;
            }
        }

        @keyframes fadeout {
            from {
                top: 80px;
                opacity: 1;
            }

            to {
                top: 0;
                opacity: 0;
            }
        }

        .chat-app .people-list {
            width: 280px;
            position: absolute;
            left: 0;
            top: 0;
            padding: 20px;
            z-index: 7
        }

        .chat-app .chat {
            margin-left: 280px;
            border-left: 1px solid #eaeaea
        }

        .people-list {
            -moz-transition: .5s;
            -o-transition: .5s;
            -webkit-transition: .5s;
            transition: .5s
        }

        .people-list .chat-list li {
            padding: 10px 15px;
            list-style: none;
            border-radius: 3px
        }

        .scrollable-container::-webkit-scrollbar-thumb {
            background-color: #457B9D;
            border-radius: 10px;
        }

        .scrollable-container::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
            background-color: #F1FAEE;
        }

        .scrollable-container::-webkit-scrollbar {
            width: 5px;
            background-color: #F5F5F5;
        }


        .people-list .chat-list li:hover {
            background: #efefef;
            cursor: pointer
        }

        .people-list .chat-list li.active {
            background: #efefef
        }

        .people-list .chat-list li .name {
            font-size: 15px
        }

        .people-list .chat-list img {
            width: 45px;
            border-radius: 50%
        }

        .people-list img {
            float: left;
            border-radius: 50%
        }

        .people-list .about {
            float: left;
            padding-left: 8px
        }

        .people-list .status {
            color: #999;
            font-size: 13px
        }

        .chat .chat-header {
            padding: 15px 20px;
            border-bottom: 2px solid #f4f7f6;
            background-color: #f1f1f1;
        }

        .chat .chat-header img {
            float: left;
            border-radius: 40px;
            width: 40px
        }

        .chat .chat-header .chat-about {
            float: left;
            padding-left: 10px
        }

        .chat .chat-history {
            padding: 20px;
            border-bottom: 2px solid #fff
        }

        .chat .chat-history ul {
            padding: 0
        }

        .chat .chat-history ul li {
            list-style: none;
            margin-bottom: 30px
        }

        /* .chat .chat-history ul li:last-child {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        margin-bottom: 0px
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } */


        .chat .chat-history .message-data img {
            border-radius: 40px;
            width: 40px
        }

        .chat .chat-history .message-data-time {
            color: #434651;
            padding-left: 6px;
            font-size: 12px;
        }

        .chat .chat-history .message {
            color: #444;
            padding: 13px 20px;
            line-height: 20px;
            font-size: 16px;
            border-radius: 7px;
            display: inline-block;
            position: relative
        }
        
        .chat .chat-history .my-message {
            background: #efefef;
            background: #efefef;
            max-width: 80%;
            text-wrap: wrap;
        }
        
        .chat .chat-history .other-message {
            background: #dcf8c6;
            text-align: right;
            max-width: 80%;
            text-wrap: wrap;
        }

        .chat .chat-history .admin-name {
            font-size: 13px;
            margin-left: 5px;

        }
        
        .chat .chat-message {
            padding: 20px;
            background-color: #f1f1f1;
        }

        pre {
            text-wrap: wrap;
            margin-bottom: 5px;
            text-align: left;
        }

        .online,
        .offline,
        .me {
            margin-right: 2px;
            font-size: 8px;
            vertical-align: middle
        }

        .online {
            color: #86c541
        }

        .offline {
            color: #e47297
        }

        .me {
            color: #1d8ecd
        }

        .float-right {
            float: right
        }

        .clearfix:after {
            visibility: hidden;
            display: block;
            font-size: 0;
            content: " yhj";
            clear: both;
            height: 0
        }

        #sendMessage:hover {
            cursor: pointer;
        }

        .attachment-preview-container {
            margin-top: -30px;
        }

        @media only screen and (max-width: 767px) {
            .chat-app .people-list {
                height: 465px;
                width: 100%;
                overflow-x: auto;
                background: #fff;
                left: -400px;
                display: none
            }

            .chat-app .people-list.open {
                left: 0
            }

            .chat-app .chat {
                margin: 0
            }

            .chat-app .chat .chat-header {
                border-radius: 0.55rem 0.55rem 0 0
            }

            .chat-app .chat-history {
                height: 300px;
                overflow-x: auto
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 992px) {
            .chat-app .chat-list {
                height: 650px;
                overflow-x: auto
            }

            .chat-app .chat-history {
                height: 600px;
                overflow-x: auto
            }
        }

        @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: landscape) and (-webkit-min-device-pixel-ratio: 1) {
            .chat-app .chat-list {
                height: 480px;
                overflow-x: auto
            }

            .chat-app .chat-history {
                height: calc(100vh - 350px);
                overflow-x: auto
            }
        }
    </style>

@stop
@section('main')
    <section>
        <div class="container">
            <div id="toast">
                <div class="alert alert-primary" role="alert">
                    <i class="bi bi-bell"></i> Cs :
                    <span class="name-from fw-bold"></span>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card chat-app">
                        <div id="plist" class="people-list">
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fa fa-search"></i></span>

                                <input type="text" class="form-control" placeholder="Search...">
                            </div>
                            <ul class="list-unstyled scrollable-container chat-list  mt-2 mb-0" id="conversationList"
                                style=" position: relative; height: 400px;overflow-y: auto;">


                            </ul>
                            <div class="input-group">
                                <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#exampleModal">New Chat</button>
                                <div class="d-grid gap-2">
                                </div>
                            </div>
                        </div>
                        <div class="chat">
                            <div class="chat-header clearfix">
                                <div class="row">
                                    <div class="col-lg-6">

                                        <div id="img-customer">
                                            <img src="{{ asset('assets/img/person.png') }}" alt="avatar">
                                        </div>
                                        <div class="chat-about">
                                            <h6 class="m-b-0 " id="nama-title">Admin</h6>
                                            <small id="cabang-title"></small>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 hidden-sm ">
                                        <div class="float-end">
                                            <div class="spinner-border float-end ms-2 spinner-border-sm loading"
                                                style="display: none;" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="chat-history scrollable-container"
                                style=" position: relative; height: 400px;overflow-y: auto;">
                                <ul class="m-b-0" id="box-message">



                                </ul>
                            </div>
                            <div class="chat-message clearfix">
                                <div class="chat-message clearfix">
                                    <div class="attachment-preview-container mb-2"></div>

                                    <div class="row align-items-center">
                                        <div class="col-1   ">
                                            <div class="btn-group dropup float-start">
                                                <span class="btn " type="button" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="bi bi-paperclip text-black fw-3 fs-5"></i>
                                                </span>
                                                <ul class="dropdown-menu">
                                                    <li class="dropdown-item"><span class="ms-3 "><label for="document"><i
                                                                    class="bi bi-file-earmark"></i> Dokumen</label><input
                                                                type="file" name="document"
                                                                accept=".pdf, .doc, .docx, .xlsx" id="document"
                                                                style="display: none"></span>
                                                    </li>
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                    <li class="dropdown-item"><span class="ms-3 "><label for="gambarin"><i
                                                                    class="bi bi-file-earmark-image"></i>
                                                                Gambar</label><input type="file" name="gambar"
                                                                id="gambarin" accept=".jpg, .jpeg, .png, .PNG, .webp"
                                                                style="display: none"></span>
                                                    </li>
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                    <li class="dropdown-item"><span class="ms-3 "><label for="video"> <i
                                                                    class="bi bi-play-circle"></i> Video</label><input
                                                                type="file" name="video" id="video"
                                                                accept="video/*" style="display: none"></span></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-10">

                                            <textarea class="form-control " id="messageInput" rows="1" placeholder="Enter text here..."></textarea>
                                        </div>
                                        <div class="col-1">

                                            <span class="btn btn-secondary" style="margin-left:-10px;width:50px;"
                                                id="sendMessage"><i class="fa fa-send"></i></span>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="notif" class="toast-container position-fixed bottom-0 end-0 p-3">


        </div>
        {{-- @if ($percakapan == null)
            <input type="hidden" name="" id="conversationId" value="">
        @else
            <input type="hidden" name="" id="conversationId" value="{{ $percakapan->id }}">
            @endif --}}
            <input type="hidden" name="" id="conversationId" value="">
        <audio id="notificationSound" src="{{ asset('assets/notif/notif.mp3') }}" preload="auto"></audio>
        
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">List Cabang</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <select class="form-select form-select-sm" aria-label="Small select example" id="branchId">
                      <option>Pilih Cabang</option>
                      @foreach ($getBranch as $dBranch)
                          <option value="{{ $dBranch->id_cabang }}" {{ $dBranch->id_cabang == $branch->id_cabang ? 'selected' : '' }}>{{ $dBranch->nm_cabang }}</option>
                      @endforeach
                  </select>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary" id="newConversation">Chat</button>
                </div>
              </div>
            </div>
          </div>
    </section>

@section('script')
    <script>
        $('#document').on('change', function() {
            const files = $(this)[0].files
            $('.attachment-preview-container').empty(); // Clear previous previews
            $('#messageInput').attr('disabled', true)
            if (files.length > 0) {
                $.each(files, function(index, file) {
                    const fileType = file.type;
                    let previewElement;
                    previewElement = `
                        <div class="attachment-preview" style="border-radius:10px;  background-color: white;padding: 12px;">
                            <span class="doc-icon"><i class="bi bi-file-earmark-text"></i></span> <button onclick="closePreview()" id="close-preview" style="border:none;background:none;" class=" float-end"><i class="bi bi-x"></i></button>
                            <p>${file.name}</p>
                        </div>`;

                    // Append the preview to the preview container
                    $('#gambarin').val(null);
                    $('#video').val(null);
                    $('.attachment-preview-container').append(previewElement);
                });
            }
        })
        $('#gambarin').on('change', function() {
            console.log('gambar')
            const files = $(this)[0].files
            $('.attachment-preview-container').empty(); // Clear previous previews
            $('#messageInput').attr('disabled', true)
            if (files.length > 0) {
                $.each(files, function(index, file) {
                    const imgURL = URL.createObjectURL(file);

                    const fileType = file.type;
                    let previewElement;

                    previewElement = `
                        <div class="attachment-preview" style="border-radius:10px;  background-color: white;padding: 12px;">
                            <img src="${imgURL}" width="80px;" alt="Image Preview"> <button onclick="closePreview()" id="close-preview" style="border:none;background:none;" class=" float-end"><i class="bi bi-x"></i></button>
                            <p>${file.name}</p>
                        </div>`;

                    // Append the preview to the preview container
                    $('#document').val(null);
                    $('#video').val(null);
                    $('.attachment-preview-container').append(previewElement);
                });
            }
        })
        $('#video').on('change', function() {
            const files = $(this)[0].files
            $('.attachment-preview-container').empty(); // Clear previous previews
            $('#messageInput').attr('disabled', true)
            if (files.length > 0) {
                $.each(files, function(index, file) {
                    // const imgURL = URL.createObjectURL(file);

                    const fileType = file.type;
                    let previewElement;

                    previewElement = `
                        <div class="attachment-preview" style="border-radius:10px;  background-color: white;padding: 12px;">
                            <span class="doc-icon"><i class="bi bi-file-earmark-text"></i></span> <button onclick="closePreview()" id="close-preview" style="border:none;background:none;" class=" float-end"><i class="bi bi-x"></i></button>
                            <pr>${file.name}</p>
                        </div>`;

                    // Append the preview to the preview container
                    $('#document').val(null);
                    $('#gambarin').val(null);
                    $('.attachment-preview-container').append(previewElement);
                });
            }
        })

        function closePreview() {
            $('.attachment-preview-container').empty();
            $('#document').val(null);
            $('#gambarin').val(null);
            $('#video').val(null);
            $('#messageInput').removeAttr('disabled')
        };

        function downloadBtn(name) {
            // $('button.downloadBtn').on('click', function() {
            // let name = $(this).data('name');
            var fileUrl = 'assets/files/' + name; // Path to the file

            // Buat link <a> dinamis untuk mengunduh file
            var link = document.createElement('a');
            link.href = fileUrl;
            link.download = name; // Nama file saat diunduh
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        };
    </script>
    <script>
        const customerId = '{{ auth()->user()->kd_customer }}';
        var lastMessageTime = new Date().toISOString();
        const cabangId = '{{ $branch->id_cabang }}';
        const conversationId = $('#conversationId').val();

        // const ws = new WebSocket(`ws://localhost:8080?wilayah_id=${wilayahId}`);
        let socket = null;
        // // const baseWsUrl = 'ws://localhost:8080/chat';
        const baseWsUrl = 'ws://192.168.124.33:8080?type=customer&';

        if (Notification.permission !== 'granted') {
            Notification.requestPermission();
        }

        function tanggal(waktu) {

            const dateStr = '2024-07-30T10:00:21.000000Z';
            const date = waktu.split('T')[0]; // Mendapatkan bagian waktu, yaitu '10:00:21.000000'
            // const [hours, minutes] = timePart.split('-');
            return date
        }

        function Tanggal(tanggal) {

            // Memecah string menjadi tanggal dan waktu (opsional)
            var parts = tanggal.split('T');
            var datePart = parts[0];

            // Memecah bagian tanggal menjadi komponen-komponennya
            var dateComponents = datePart.split('-');
            var year = dateComponents[0];
            var month = dateComponents[1];
            var day = dateComponents[2];
            // Membentuk string tanggal dalam format yang diinginkan (tanggal-bulan-tahun)
            var formattedDate = day + '-' + month + '-' + year;
            return formattedDate;
        }

        function loadConversations() {
            $.get('customer/get-conversations', function(data) {
                $('#conversationList').empty();
                // console.log(data + "sddsd")
                if (data.length == 0) {
                    // $('#generateChat').css('display', 'block')
                    $('#sendMessage').attr('disabled', '')
                    $('#alert').css('display', 'block')
                } else {
                    $('#sendMessage').removeAttr('disabled', '')
                    // $('#generateChat').css('display', 'none')
                }
                data.forEach(conversation => {
                    if(conversation.user){
                        $('#conversationList').append(`<li class="clearfix p-2 border-bottom list-message" data-name="${conversation.user.nm_user}" data-id="${conversation.id}" data-cabang="${conversation.branch.nm_cabang}">
                                    <div id="is_read_message" class="float-end"></div>
                                    <img src="{{ asset('assets/img/person.png') }}" alt="avatar">
                                       <div class="d-flex flex-row">
                                             <div class="pt-1">
                                               <p class="mb-0" style="font-size:14px;font-wieght:650">${conversation.branch.nm_cabang}</p>
                                               <p class="small text-muted mb-1" style="font-size:12px;">${Tanggal(conversation.created_date)}</p>
                                            </div>
                                        </div>
                                        <div class="pt-1">
                                        </div>
                            </li>`
                        );
                    }else{
                        $('#conversationList').append(`<li class="clearfix p-2 border-bottom list-message" data-name="${conversation.branch.nm_cabang}" data-id="${conversation.id}" data-cabang="${conversation.branch.nm_cabang}">
                                    <div id="is_read_message" class="float-end"></div>
                                    <img src="{{ asset('assets/img/person.png') }}" alt="avatar">
                                       <div class="d-flex flex-row">
                                             <div class="pt-1">
                                               <p class="mb-0" style="font-size:14px;font-wieght:650">${conversation.branch.nm_cabang}</p>
                                               <p class="small text-muted mb-1" style="font-size:12px;">${Tanggal(conversation.created_date)}</p>
                                            </div>
                                        </div>
                                        <div class="pt-1">
                                        </div>
                            /li>`
                        );
                    }
                });
            });
        }

        function playNotificationSound() {
            var audio = $('#notificationSound')[0]; // Mengakses elemen audio
            audio.play(); // Memutar suara
        }

        function updateElapsedTime() {
            $('.timeElapsed').each(function() {
                var messageElement = $(this);
                var messageTime = new Date(messageElement.attr('data-timestamp'));
                if (isNaN(messageTime)) {
                    console.error('Invalid timestamp:', messageElement.attr('data-timestamp'));
                    return;
                }

                var now = new Date();
                var timeDifference = now - messageTime;

                var seconds = Math.floor((timeDifference / 1000) % 60);
                var minutes = Math.floor((timeDifference / (1000 * 60)) % 60);
                var hours = Math.floor((timeDifference / (1000 * 60 * 60)) % 24);
                var days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));

                var timeString = '';

                if (days > 0) {
                    timeString += days + ' hari ';
                }
                if (hours > 0 || days > 0) {
                    timeString += hours + ' jam ';
                }
                if (minutes > 0 || hours > 0 || days > 0) {
                    timeString += minutes + ' menit ';
                }
                timeString += seconds + ' detik yang lalu';

                messageElement.find('.time-elapsed').text(timeString);
            });
        }

        function showDesktopNotification(message, from) {
            if (Notification.permission === 'granted') {
                const notification = new Notification('CS - ' + from, {
                    body: message,
                    icon: "{{ asset('assets/img/logo-jamkrindo-bg.png') }}" // You can add an icon here
                });

                notification.onclick = () => {
                    window.focus(); // Bring the chat window to the front
                    notification.close(); // Close the notification when clicked
                };
            } else {
                console.log('Notification permission is not granted.');
            }
        }

        function fetchMessages() {
            $.ajax({
                url: 'customer/fetch-messages',
                type: 'GET',
                data: {
                    conversationId: conversationId,
                    userId: '{{ auth()->user()->kd_customer }}'
                },
                success: function(res) {
                    res.messages.forEach(function(data) {
                        // if (message.id > lastMessageId) {
                        //     appendMessage(message.sender, message.text);
                        //     showNotification(message.sender, message.text);
                        //     lastMessageId = message.id; // Update ID pesan terakhir
                        // }
                        playNotificationSound()
                        var lastMessageTime = new Date().toISOString();



                        // onMessageReceived();

                        $.get("{{ route('chat-read-customer') }}", {
                            conversationId: data.conversation_id,
                            user_id: '{{ auth()->user()->kd_customer }}'
                        }, function(res) {

                            if (data.type_message == "FILE") {
                                $('#box-message').append(`
                        <li class="clearfix">
                             <div class="admin-name">CS - <strong>${data.user.nm_user}</strong></div> 
                            <div class="message my-message">    <div class=""> <i class="bi bi-file-earmark-text"></i> <span>Pdf</span></div><button onclick="downloadBtn('${data.message}')"  style="border:none" id="downloadBtn" class="badge bg-secondary downloadBtn">Unduh File</button> <div class="message-data text-end">
                                <span class="message-data-time float-end">${waktu(data.created_date)} </span>
                            </div> </div>
                           </li>`);
                            } else if (data.type_message == "IMAGE") {
                                $('#box-message').append(` <li class="clearfix">
                                <div class="admin-name">CS - <strong>${data.user.nm_user}</strong></div> 
                            <div class="message my-message">    <div class=""><img src="assets/files/${data.message}" onload="Load()" class="img-thumbnail" max-width="50px;"  ></div><button onclick="downloadBtn('${data.message}')"  style="border:none" id="downloadBtn" class="badge bg-secondary downloadBtn">Unduh File</button>  <div class="message-data text-end">
                                <span class="message-data-time float-end">${waktu(data.created_date)}</span>
                            </div> </div>
                          </li>`);
                            } else if (data.type_message == "VIDEO") {
                                $('#box-message').append(` <li class="clearfix">
                             <div class="admin-name">CS - <strong>${data.user.nm_user}</strong></div> 
                            <div class="message my-message">     <div class=""><video style="max-width: 100%; height: auto;" onloadeddata="Load()"   controls ><source src="assets/files/${data.message}"  type="video/mp4"></video></div><button onclick="downloadBtn('${data.message}')"  style="border:none" id="downloadBtn" class="badge bg-secondary downloadBtn">Unduh File</button> <div class="message-data text-end">
                                <span class="message-data-time ">${waktu(data.created_date)}</span>
                            </div> </div>
                           </li>`);
                            } else {
                                $('#box-message').append(
                                    ` <li class="clearfix">
                                <div class="admin-name">CS - <strong>${data.user.nm_user}</strong></div> 
                            <div class="message my-message"><pre>${data.message} </pre> <div class="message-data text-end">
                                <span class="message-data-time ">${waktu(data.created_date)}</span>
                            </div></div>
                            </li>`);

                            }
                            $('.chat-history').scrollTop($('#box-message').height());


                        });


                        $('.name-from').text(data.user.nm_user);
                        const toast = $('#toast');
                        toast.addClass('show');
                        setTimeout(function() {
                            toast.removeClass('show');
                        }, 3000); // Toast will be visible for 3 seconds

                        showDesktopNotification(data.message, data.user.nm_user);

                    });

                },
                error: function(err) {
                    console.error('Error fetching messages!', err);
                }
            });
        }

        setInterval(fetchMessages, 4000);

        function Load() {

            $('.chat-history').scrollTop($('#box-message').height());
        }

        function nowDate() {
            var now = new Date();

            // Mendapatkan bagian-bagian dari tanggal dan waktu
            var year = now.getFullYear(); // Mendapatkan tahun (2024)
            var month = (now.getMonth() + 1).toString().padStart(2, '0'); // Mendapatkan bulan (08)
            var day = now.getDate().toString().padStart(2, '0'); // Mendapatkan hari (16)

            var hours = now.getHours().toString().padStart(2, '0'); // Mendapatkan jam (04)
            var minutes = now.getMinutes().toString().padStart(2, '0'); // Mendapatkan menit (04)
            var seconds = now.getSeconds().toString().padStart(2, '0'); // Mendapatkan detik (22)

            // Membuat format "YYYY-MM-DD HH:MM:SS"
            var formattedTime = year + '-' + month + '-' + day;
            return formattedTime;
        }



        function waktu(waktu) {

            const dateStr = '2024-07-30T10:00:21.000000Z';
            const timePart = waktu.split('T')[1].split('Z')[
                0]; // Mendapatkan bagian waktu, yaitu '10:00:21.000000'
            // const [hours, minutes] = timePart.split(':');
            const now = new Date(waktu);
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            return hours + ":" + minutes
        }

        function tanggal(waktu) {

            const dateStr = '2024-07-30T10:00:21.000000Z';
            const date = waktu.split('T')[0]; // Mendapatkan bagian waktu, yaitu '10:00:21.000000'
            // const [hours, minutes] = timePart.split('-');
            return date
        }



        function waktuAL(waktu) {

            // const dateStr = '2024-07-30T10:00:21.000000Z';
            // const timePart = waktu.split(' ')[1]; // Mendapatkan bagian waktu, yaitu '10:00:21.000000'
            // const [hours, minutes] = timePart.split(':');
            // return hours + ":" + minutes

            var date = new Date(waktu);

            // Get hours and minutes
            var hours = date.getHours().toString().padStart(2, '0');
            var minutes = date.getMinutes().toString().padStart(2, '0');

            var time = hours + ':' + minutes;
            return time
        }

        function generateChat(cabang_id) {
            $.post('customer/conversations', {
                cabang_id: cabang_id,
                user_id: '{{ auth()->user()->kd_customer }}'
            }, function(data) {
                loadConversations()
            });
        }

        function loadMessages(conversationId) {
            let lastDate = "  ";
            $('.loading').show()
            $.get(`customer/conversations/${conversationId}/messages`, function(data) {
                $('#box-message').empty();
                data.forEach(message => {
                    console.log(message.length);
                    
                    let dateNow = tanggal(message.created_date);
                    // console.log(tanggal(message.created_date))
                    if (dateNow !== lastDate) {
                        if (nowDate() == dateNow) {

                            $('#box-message').append(

                                ` <p  class="text-center fw-bold"> Hari ini</p>
                                `
                            )
                        } else {
                            $('#box-message').append(

                                ` <p  class="text-center fw-bold"> ${lastDate}</p>
                            `
                            )
                        }

                        lastDate = dateNow;
                    }
                    
                    let is_read = '<i class="bi bi-eye"></i>';
                    if (message.is_read == 'FALSE') {
                        is_read = '<i class="bi bi-eye-slash"></i>'
                    }
                    if (message.status) {
                        if (message.type_message == "FILE") {
                            $('#box-message').append(`
                            <li class="clearfix">
                                <div class="message my-message">    <div class=""> <i class="bi bi-file-earmark-text"></i> <span>  Dokumen</span></div><button onclick="downloadBtn('${message.message}')"  style="border:none" id="downloadBtn" class="badge bg-secondary downloadBtn">Unduh File</button> <div class="message-data text-end">
                                    <span class="message-data-time float-end">${waktu(message.created_date)} </span>
                                </div> </div>
                               </li>`);
                        } else if (message.type_message == "IMAGE") {
                            $('#box-message').append(` <li class="clearfix">
                                <div class="message my-message">    <div class=""><img src="assets/files/${message.message}" onload="Load()" class="img-thumbnail" max-width="50px;"  ></div><button onclick="downloadBtn('${message.message}')"  style="border:none" id="downloadBtn" class="badge bg-secondary downloadBtn">Unduh File</button>  <div class="message-data text-end">
                                    <span class="message-data-time float-end">${waktu(message.created_date)}  </span>
                                </div> </div>
                              </li>`);
                        } else if (message.type_message == "VIDEO") {
                            $('#box-message').append(` <li class="clearfix">
                                <div class="message my-message">     <div class=""><video style="max-width: 100%; height: auto;" onloadeddata="Load()" controls ><source src="assets/files/${message.message}"  type="video/mp4"></video></div><button onclick="downloadBtn('${message.message}')"  style="border:none" id="downloadBtn" class="badge bg-secondary downloadBtn">Unduh File</button> <div class="message-data text-end">
                                    <span class="message-data-time ">${waktu(message.created_date)}   </span>
                                </div> </div>
                               </li>`);
                        } else {
                            if (message.user) {
                                $('#box-message').append(
                                    ` <li class="clearfix">
                                    <div class="admin-name">${message.user.nm_user} - <strong>${message.user.cabang.nm_cabang}</strong></div> 
                                <div class="message my-message"><pre>${message.message} </pre> <div class="message-data text-end">
                                    <span class="message-data-time ">${waktu(message.created_date)} </span>
                                </div></div>
                                </li>`);
                            } else {
                                $('#box-message').append(
                                    ` <li class="clearfix">
                                    <div class="admin-name">CS - <strong>Pesan Otomatis</strong></div> 
                                <div class="message my-message"><pre>${message.message} </pre> <div class="message-data text-end">
                                    <span class="message-data-time ">${waktu(message.created_date)} </span>
                                </div></div>
                                </li>`);
                            }
                        }
                    } else {


                        if (message.type_message == "FILE") {
                            $('#box-message').append(`
                         <li class="clearfix">
                             <div class="message other-message float-end" >    <div class=""> <i class="bi bi-file-earmark-text"></i> <span> Dokumen</span></div><button onclick="downloadBtn('${message.message}')"  style="border:none" id="downloadBtn" class="badge bg-secondary downloadBtn">Unduh File</button> <div class="message-data text-end" >
                                <span class="message-data-time" >${waktu(message.created_date)}  ${is_read}</span>
                            </div></div>
                             
                          </li> `);
                        } else if (message.type_message == "IMAGE") {
                            $('#box-message').append(`
                        <li class="clearfix">
                        <div class="message other-message float-end">
                             <div class=""><img src="assets/files/${message.message}" class="img-thumbnail" max-width="50px;" onload="Load()" ></div><button onclick="downloadBtn('${message.message}')"  style="border:none" id="downloadBtn" class="badge bg-secondary downloadBtn">Unduh File</button>
                            <div class="message-data text-end">
                                <span class="message-data-time">${nowTime()}  ${is_read}</span> 
                            </div>
                        </div>
                    </li>`);
                        } else if (message.type_message == "VIDEO") {
                            $('#box-message').append(`
                         <li class="clearfix">
                             <div class="message other-message float-end" >  <div class=""><video style="max-width: 100%; height: auto;" onloadeddata="Load()" controls ><source src="assets/files/${message.message}"    type="video/mp4"></video></div><button onclick="downloadBtn('${message.message}')"  style="border:none" id="downloadBtn" class="badge bg-secondary downloadBtn">Unduh File</button><div class="message-data text-end" >
                                <span class="message-data-time" >${waktu(message.created_date)}  ${is_read}</span>
                            </div></div>
                              
                          </li> `);
                        } else {
                            $('#box-message').append(`
                         <li class="clearfix">
                             <div class="message other-message float-end" ><pre>${message.message} </pre><div class="message-data text-end" >
                                <span class="message-data-time" >${waktu(message.created_date)}  ${is_read}</span>
                            </div></div>
                              
                          </li> `);
                        }
                    }
                    $('.loading').hide()
                    $('.chat-history').scrollTop($('#box-message').height());
                });

            });
        }

        function updateConversationId(newId) {
            currentConversationId = newId;
            // console.log('Conversation ID updated:', currentConversationId);
            // connectWebSocket(currentConversationId); // Reconnect dengan ID baru
        }


        // Update currentConversationId saat pengguna memilih percakapan baru
        function nowTime() {
            var now = new Date();

            // Mendapatkan bagian-bagian dari tanggal dan waktu
            var year = now.getFullYear(); // Mendapatkan tahun (2024)
            var month = (now.getMonth() + 1).toString().padStart(2, '0'); // Mendapatkan bulan (08)
            var day = now.getDate().toString().padStart(2, '0'); // Mendapatkan hari (16)

            var hours = now.getHours().toString().padStart(2, '0'); // Mendapatkan jam (04)
            var minutes = now.getMinutes().toString().padStart(2, '0'); // Mendapatkan menit (04)
            var seconds = now.getSeconds().toString().padStart(2, '0'); // Mendapatkan detik (22)

            // Membuat format "YYYY-MM-DD HH:MM:SS"
            var formattedTime = hours + ':' + minutes;
            return formattedTime;
        }

        function now() {
            var now = new Date();

            // Mendapatkan bagian-bagian dari tanggal dan waktu
            var year = now.getFullYear(); // Mendapatkan tahun (2024)
            var month = (now.getMonth() + 1).toString().padStart(2, '0'); // Mendapatkan bulan (08)
            var day = now.getDate().toString().padStart(2, '0'); // Mendapatkan hari (16)

            var hours = now.getHours().toString().padStart(2, '0'); // Mendapatkan jam (04)
            var minutes = now.getMinutes().toString().padStart(2, '0'); // Mendapatkan menit (04)
            var seconds = now.getSeconds().toString().padStart(2, '0'); // Mendapatkan detik (22)

            // Membuat format "YYYY-MM-DD HH:MM:SS"
            var formattedTime = year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;
            return formattedTime;
        }


        function uploadFile(file, type, currentConversationId) {
            var fileSize = file.size / 1024 / 1024; // Ukuran file dalam MB
            if (fileSize > 10) {
                alert('Ukuran file tidak boleh lebih dari 10 MB');
                return false; // Hentikan proses pengiriman
            }

            var formData = new FormData();
            formData.append('file', file);
            formData.append('created_date', now());
            formData.append('type', type);
            formData.append('conversation_id', currentConversationId);
            formData.append('sender_id', customerId);

            $.ajax({
                url: "{{ route('upload-file-customer') }}",
                type: "POST",
                data: formData,
                contentType: false, // Use false to prevent jQuery from overriding the Content-Type header
                processData: false, // Use false to prevent jQuery from trying to process the data
                success: function(data) {
                    // displayMessage(data);
                    $('#messageInput').removeAttr('disabled');
                    $('#messageInput').val('');
                    $('.attachment-preview-container').empty(); // Clear previous previews
                    $('#document').val(null);
                    $('#gambarin').val(null);
                    $('#video').val(null);
                    let file = data.type_message;
                    if (file == "FILE") {
                        $('#box-message').append(`
                         <li class="clearfix">
                             <div class="message other-message float-end" >    <div class=""> <i class="bi bi-file-earmark-text"></i> <span>Pdf</span></div><button onclick="downloadBtn('${data.message}')"  style="border:none" id="downloadBtn" class="badge bg-secondary downloadBtn">Unduh File</button>   <div class="message-data text-end" >
                                <span class="message-data-time" >${nowTime()}  <i class="bi bi-eye-slash"></i></span>
                            </div></div>
                            
                          </li> `);
                    } else if (file == "IMAGE") {

                        $('#box-message').append(`
                        <li class="clearfix">
                        <div class="message other-message float-end">
                             <div class=""><img src="assets/files/${data.message}" class="img-thumbnail" max-width="50px;" onload="Load()"   ></div><button onclick="downloadBtn('${data.message}')"  style="border:none" id="downloadBtn" class="badge bg-secondary downloadBtn">Unduh File</button>
                            <div class="message-data text-end">
                                <span class="message-data-time">${nowTime()}  <i class="bi bi-eye-slash"></i></span>
                            </div>
                                </div>
                            </li>`);
                    } else if (file == "VIDEO") {
                        $('#box-message').append(`
                         <li class="clearfix">
                             <div class="message other-message float-end" >  <div class=""><video style="max-width: 100%; height: auto;" onloadeddata="Load()"  controls ><source src="assets/files/${data.message}"  type="video/mp4"></video></div><button onclick="downloadBtn('${data.message}')"  style="border:none" id="downloadBtn" class="badge bg-secondary downloadBtn">Unduh File</button> <div class="message-data text-end" >
                                <span class="message-data-time" >${nowTime()}  <i class="bi bi-eye-slash"></i></span>
                            </div></div>
                             
                          </li> `);
                    } else {
                        $('#box-message').append(`
                         <li class="clearfix">
                             <div class="message other-message float-end" > ${data.message} <div class="message-data text-end" >
                                <span class="message-data-time" >${nowTime()}  <i class="bi bi-eye-slash"></i></span>
                            </div></div>
                              
                          </li> `);
                    }

                    $('#messageInput').removeAttr('disabled');

                    $('#messageInput').val('');

                    $('.chat-history').scrollTop($('#box-message').height());
                },
                error: function(response) {
                    alert('File upload failed!');
                }
            });
        }

        // window
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            loadConversations();
            //    console.log(conversationId) 
            setInterval(updateElapsedTime, 5000);
            
            loadMessages(conversationId);
            $(document).on('click', '.list-message', function() {
                $('.list-message').removeClass('bg-conversation')
                currentConversationId = $(this).data('id');
                $('#nama-title').text($(this).data('name'));
                $('#cabang-title').text($(this).data('cabang'));
                $(this).addClass('bg-conversation')
                $('#conversationId').val(currentConversationId);
                loadMessages(currentConversationId);

            });

            $('#sendMessage').click(function() {

                const conversationId = $('#conversationId').val();
                const message = $('#messageInput').val();
                
                const files = $('#document')[0].files
                const imageFiles = $('#gambarin')[0].files;
                const videoFiles = $('#video')[0].files;
                if (message && customerId) {

                    $.ajax({
                        url: "{{ route('sendMessageCustomer') }}",
                        type: 'POST',
                        data: {
                            conversation_id: conversationId,
                            message: message,
                            created_date: now(),
                            type: 'TEXT',
                            sender_id: '{{ auth()->user()->kd_customer }}',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(res) {
                            $('#box-message').append(

                                ` <li class="clearfix">
                                <div class="message other-message float-end" ><pre>${message} </pre><div class="message-data text-end">
                                       <span class="message-data-time"  >${nowTime()} <i class="bi bi-eye-slash"></i></span>
                                       </div> </div>
                                   </li>`
                            )


                            $('#messageInput').val('');
                            // var chatContainer = $('#box-message');
                            // chatContainer.scrollTop(chatContainer[0].scrollHeight);
                            $('.chat-history').scrollTop($('#box-message').height());

                        }
                    })
                } else if (imageFiles[0] && imageFiles[0].type.startsWith('image/') &&
                    conversationId) {
                    uploadFile(imageFiles[0], 'IMAGE', conversationId);
                } else if (files[0] && files[0].type === 'application/pdf' && conversationId) {
                    uploadFile(files[0], 'FILE', conversationId);
                } else if (videoFiles.length > 0 && videoFiles[0].type.startsWith('video/') &&
                    conversationId) {
                    uploadFile(videoFiles[0], 'VIDEO', conversationId);
                } else if (imageFiles[0] && imageFiles[0].type.startsWith('image/') &&
                    conversationId) {
                    uploadFile(imageFiles[0], 'IMAGE', conversationId);
                } else if (files[0] && files[0].type === 'application/pdf' && conversationId) {
                    uploadFile(files[0], 'FILE', conversationId);
                } else if (videoFiles.length > 0 && videoFiles[0].type.startsWith('video/') &&
                    conversationId) {
                    uploadFile(videoFiles[0], 'VIDEO', conversationId);
                }
                $.get("{{ route('check-receive-customer') }}", {
                    cabangId: '{{ auth()->user()->kd_cabang }}',
                    user_id: '{{ auth()->user()->kd_customer }}',
                    conversation_id: conversationId,
                    message: 'Terima kasih telah menghubungi cs kami, mohon tunggu admin membalas pesan anda',
                }, function(data) {
                    if (data) {
                        $('#box-message').append(
                            ` <li class="clearfix">
                                    <div class="admin-name"><strong>Pesan Otomatis</strong></div> 
                                <div class="message my-message"><pre>Terima kasih telah menghubungi cs kami, mohon tunggu admin membalas pesan anda </pre> <div class="message-data text-end">
                                    <span class="message-data-time ">${nowTime()} </span>
                                </div></div>
                                </li>`);
                        $('.chat-history').scrollTop($('#box-message').height());

                    }

                });
            });

            $('#newConversation').click(function() {

                const branchId = $('#branchId').val();
                const files = $('#document')[0].files
                const imageFiles = $('#gambarin')[0].files;
                const videoFiles = $('#video')[0].files;

                $.post("{{ route('check-conversation.customer') }}", {
                    cabangId: branchId,
                    user_id: '{{ auth()->user()->kd_customer }}'
                }, function(data) {
                    currentConversationId = data.id;
                    $('#conversationId').val(data.id);
                    $('#exampleModal').modal('hide');
                    loadMessages(currentConversationId);

                });
            });
        });
    </script>
@stop
@endsection
