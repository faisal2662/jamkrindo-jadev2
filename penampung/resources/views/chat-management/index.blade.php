@extends('layouts.main')
@section('style')
    <style>
        .card {
            background: #fff;
            transition: .5s;
            border: 0;
            margin-bottom: 30px;
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

        pre {
            text-wrap: wrap;
            margin-bottom: 5px;
            text-align: left;
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

        .receive {
            margin-top: 55px;
            font-size: 14px;
        }

        .currentDay {
            position: absolute;
            right: 10px;
            font-size: 12px;
            float: right;
        }

        #is_read_message {
            margin-top: 20px;
            margin-right: 5px;
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
            max-width: 80%;
            text-wrap: wrap;

        }

        .chat .chat-history .other-message {

            background: #dcf8c6;
            text-align: left;
            max-width: 80%;
            text-wrap: wrap;
        }

        .chat .chat-message {
            padding: 20px;
            background-color: #f1f1f1;
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

        #sendMessage:hover {
            cursor: pointer;
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
                    <i class="bi bi-bell"></i> Masuk :
                    <span class="name-from fw-bold"></span>
                </div>
            </div>
            <input type="hidden" name="" id="currentConversationId">


            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card chat-app">
                        <div id="plist" class="people-list">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa fa-search"></i></span>

                                <input type="text" class="form-control" placeholder="Search...">
                            </div>
                            <ul class="list-unstyled scrollable-container chat-list  mt-2 mb-0" id="conversationList"
                                style=" position: relative; height: 400px;overflow-y: auto;">


                            </ul>
                        </div>
                        <div class="chat">
                            <div class="chat-header clearfix">
                                <div class="row">
                                    <div class="col-lg-6">

                                        <div id="img-customer">
                                        </div>
                                        <div class="chat-about">
                                            <h6 class="m-b-0 " id="nama-title"></h6>
                                            <small id="cabang-title"></small>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 hidden-sm ">
                                        <div class="float-end">
                                            <button id="close-chatting" class="btn btn-outline-secondary btn-sm close-chat"
                                                data-conversation="">Close
                                                Chat</button>

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
                                                            type="file" name="document" accept=".pdf, .doc, .docx, .xlsx"
                                                            id="document" style="display: none"></span>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li class="dropdown-item"><span class="ms-3 "><label for="gambarin"><i
                                                                class="bi bi-file-earmark-image"></i> Gambar</label><input
                                                            type="file" name="gambar" id="gambarin"
                                                            accept=".jpg, .jpeg, .png, .PNG, .webp"
                                                            style="display: none"></span>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li class="dropdown-item"><span class="ms-3 "><label for="video"> <i
                                                                class="bi bi-play-circle"></i> Video</label><input
                                                            type="file" name="video" id="video" accept="video/*"
                                                            style="display: none"></span></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-10">

                                        <textarea class="form-control" disabled id="messageInput" rows="1" placeholder="Enter text here..."></textarea>
                                    </div>
                                    <div class="col-1">

                                        <button class="btn btn-secondary" style="margin-left:-10px;width:50px;"
                                            id="sendMessage" disabled><i class="fa fa-send"></i></button>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="popup"
            style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%); background-color:white; padding:20px; border:1px solid #ccc; box-shadow: 0 4px 8px rgba(0,0,0,0.2); z-index:1000;">
            <p>Anda tidak aktif selama beberapa waktu. Apakah Anda masih di sini?</p>
            <button onclick="closePopup()">Ya, saya di sini</button>
        </div>
        <audio id="notificationSound" src="{{ asset('assets/notif/notif.mp3') }}" preload="auto"></audio>

        <div id="notif" class="toast-container position-fixed bottom-0 end-0 p-3">


        </div>
    </section>
    <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="
        crossorigin="anonymous"></script>

@section('script')
    <script>
        let inactivityTime = 30000; // Waktu dalam milidetik (30 detik)
        // let inactivityTime = 300000; // Waktu dalam milidetik (30 detik)
        let inactivityTimer;

        function resetTimer() {
            // Sembunyikan popup jika ada aktivitas
            clearTimeout(inactivityTimer); // Reset timer
            inactivityTimer = setTimeout(showPopup, inactivityTime); // Mulai ulang timer
            // playNotificationSound();
        }

        function showPopup() {
            document.getElementById('popup').style.display = 'block'; // Tampilkan popup
        }

        function closePopup() {
            document.getElementById('popup').style.display = 'none'; // Sembunyikan popup
            resetTimer(); // Reset timer
        }

        // Deteksi aktivitas pengguna
        window.onload = resetTimer;
        window.onmousemove = resetTimer;
        window.onkeypress = resetTimer;
        window.onclick = resetTimer;
        window.onscroll = resetTimer;
    </script>
    <script>
        $('#document').on('change', function() {
            console.log('document')
            const files = $(this)[0].files
            $('.attachment-preview-container').empty(); // Clear previous previews
            $('#messageInput').attr('disabled', true)
            if (files.length > 0) {
                $.each(files, function(index, file) {
                    const fileType = file.type;
                    let previewElement;
                    previewElement = `
                        <div class="attachment-preview" style="border-radius:10px;  background-color: white;padding: 5px;">
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
                        <div class="attachment-preview" style="border-radius:10px;  background-color: white;padding: 5px;">
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
            console.log('video')
            const files = $(this)[0].files
            $('.attachment-preview-container').empty(); // Clear previous previews
            $('#messageInput').attr('disabled', true)
            if (files.length > 0) {
                $.each(files, function(index, file) {
                    // const imgURL = URL.createObjectURL(file);

                    const fileType = file.type;
                    let previewElement;

                    previewElement = `
                        <div class="attachment-preview" style="border-radius:10px;  background-color: white;padding: 5px;">
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
            console.log(name)
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
        // const conversationId = document.getElementById('conversation-id').value;
        // var lastMessageTime = new Date();

        const cabangId = {{ auth()->user()->branch_code }};
        const inputConversationId = $('#currentConversationId').val();
        var baseUrl = window.location.origin;
        // const ws = new WebSocket(`ws://localhost:8080?wilayah_id=${wilayahId}`);
        let socket = null;
        // const baseWsUrl = 'ws://localhost:8080/chat';
        const baseWsUrl = 'ws://192.168.1.12:8080?type=admin&';

        if (Notification.permission !== 'granted') {
            Notification.requestPermission();
        }

        function tanggal(waktu) {

            const dateStr = '2024-07-30T10:00:21.000000Z';
            const date = waktu.split('T')[0]; // Mendapatkan bagian waktu, yaitu '10:00:21.000000'
            // const [hours, minutes] = timePart.split('-');
            return date
        }

        function Tanggal(tanggal, daysToSubtract = 0) {
            // Memecah string menjadi tanggal dan waktu (opsional)
            var parts = tanggal.split('T');
            var datePart = parts[0];

            // Membuat objek Date dari string tanggal
            var date = new Date(datePart);

            // Mengurangi hari berdasarkan parameter yang diberikan
            date.setDate(date.getDate() - daysToSubtract);

            // Mengambil komponen tanggal yang sudah dikurangi
            var year = date.getFullYear();
            var month = ('0' + (date.getMonth() + 1)).slice(-2); // Menambahkan 0 di depan jika bulan < 10
            var day = ('0' + date.getDate()).slice(-2); // Menambahkan 0 di depan jika hari < 10

            // Membentuk string tanggal dalam format yang diinginkan (tanggal-bulan-tahun)
            var formattedDate = day + '-' + month + '-' + year;
            return formattedDate;
        }

        function loadConversations() {
            $.get('conversations', function(data) {
                $('#conversationList').empty();
                $('.loading').show()
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
                    console.log(conversation)
                    let tanggal = conversation.latest_message.created_date
                    let today = Tanggal(tanggal);
                    console.log('Kemar : ' + Tanggal(nowDate(), 1))
                    console.log('today :' + nowDate())
                    if (today == nowDate()) {
                        today = "Hari ini";
                    } else if (today == Tanggal(nowDate(), 1)) {
                        today = "Kemarin";
                    }

                    let receive = '';
                    let receiveId = '';
                    if (conversation.user !== null) {
                        receive = conversation.user.nm_user;
                        receiveId = conversation.user.kd_user;
                    }



                    if (conversation.customer.foto_customer) {

                        $.get('chat/unread-message', {
                            conversationId: conversation.id,
                            userId: '{{ auth()->user()->kd_customer }}'
                        }, function(data) {

                            $('#conversationList').append(

                                `   <li class="clearfix list-message" id="tes"
                                    data-name="${conversation.customer.nama_customer}"
                                    data-img="${conversation.customer.foto_customer}" data-id="${conversation.id}"
                                    data-cabang="${conversation.branch.nm_cabang}">
                                    <div id="is_read_message" class="float-end"></div>
                                    <div class="currentDay ">${today}</div>
                                    <img src="{{ asset('assets/img/customer/${conversation.customer.foto_customer}') }}" alt="avatar">
                                    <div class="about">
                                        <div class="name">${conversation.customer.nama_customer}</div>
                                        <div class="status"> <span class="time-last">
                                                 ${waktu(conversation.latest_message.created_date)}</span></div>
                                    </div>
                                    <div class="receive" > Penerima : <span class="fw-bold text-success adminReceive" data-id="${receiveId}" >${receive}</span> </div>
                                </li>`);

                            if (data > 0) {
                                $(`#tes[data-id="${conversation.id}"] #is_read_message`)
                                    .append(
                                        `<span class="badge count-message"  data-ids="${conversation.id}"  style="background-color:#c5f79f;color:black;"> ${data} </span>`
                                    )
                            }
                            $('.loading').hide()
                        });
                    } else {

                        $.get('chat/unread-message', {
                            conversationId: conversation.id,
                            userId: '{{ auth()->user()->kd_customer }}'
                        }, function(data) {

                            $('#conversationList').append(

                                `   <li class="clearfix list-message" id="tes"
                                    data-name="${conversation.customer.nama_customer}"
                                    data-img="${conversation.customer.foto_customer}" data-id="${conversation.id}"
                                    data-cabang="${conversation.branch.nm_cabang}">
                                    <div id="is_read_message" class="float-end"></div>
                                    <div class="currentDay ">${today}</div>
                                    <img src="{{ asset('assets/img/person.png') }}" alt="avatar">
                                    <div class="about">
                                        <div class="name">${conversation.customer.nama_customer}</div>
                                        <div class="status"> <span class="time-last">
                                                 ${waktu(conversation.latest_message.created_date)}</span></div>
                                    </div>
                                    <div class="receive" > Penerima : <span class="fw-bold text-success adminReceive" data-id="${receiveId}" >${receive}</span> </div>
                                </li>`);
                            if (data > 0) {
                                $(`#tes[data-id="${conversation.id}"] #is_read_message`)
                                    .append(
                                        `<span class="badge float-end count-message"  data-ids="${conversation.id}"  style="background-color:#c5f79f;color:black;"> ${data} </span>`
                                    )
                            }
                            $('.loading').hide()
                        });
                    }

                });
            });
        }


        function showDesktopNotification(message, from) {
            if (Notification.permission === 'granted') {
                const notification = new Notification(from, {
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

        function playNotificationSound() {
            var audio = $('#notificationSound')[0]; // Mengakses elemen audio
            audio.play(); // Memutar suara
        }

        let id= [];
        function fetchMessages() {
            $.ajax({
                url: 'fetch-messages',
                type: 'GET',
                data: {
                    cabangId: '{{ auth()->user()->branch_code }}'
                },
                success: function(res) {
                    console.log(res)
                    res.messages.forEach(function(data) {
                        let idMessagge = data.id;
                        if (!id.some(item => item === idMessagge)) {
                            playNotificationSound()
                            var lastMessageTime = new Date().toISOString();

                            const inputConversationId = $('#currentConversationId').val();

                            // onMessageReceived();
                            // console.log(data);
                            // console.log(inputConversationId);
                            if (data.conversation_id == inputConversationId) {

                                $.post("{{ route('chat-read') }}", {
                                    conversationId: data.conversation_id,
                                    user_id: '{{ auth()->user()->kd_user }}'
                                }, function(res) {
                                    if (data.type_message == "FILE") {
                                        $('#box-message').append(`
                                    <li class="clearfix">
                                        <div class="message my-message">    <div class=""> <i class="bi bi-file-earmark-text"></i> <span>  Dokumen</span></div><button onclick="downloadBtn('${data.message}')"  style="border:none" id="downloadBtn" class="badge bg-secondary downloadBtn">Unduh File</button> <div class="message-data text-end">
                                            <span class="message-data-time">${waktu(data.created_date)}  </span>
                                        </div></div>
                                    </li>`);
                                    } else if (data.type_message == "IMAGE") {
                                        $('#box-message').append(` <li class="clearfix">
                                    <div class="message my-message">    <div class=""><img src="{{ asset('assets/files/${data.message}') }}" onload="Load()" class="img-thumbnail" max-width="50px;"  ></div><button onclick="downloadBtn('${data.message}')"  style="border:none" id="downloadBtn" class="badge bg-secondary downloadBtn">Unduh File</button><div class="message-data text-end">
                                        <span class="message-data-time">${waktu(data.created_date)} </span>
                                    </div></div>
                                    </li>`);
                                    } else if (data.type_message == "VIDEO") {
                                        $('#box-message').append(` <li class="clearfix">
                                        <div class="message my-message">     <div class=""><video style="max-width: 100%; height: auto;" onloadeddata="Load()"   controls ><source src="{{ asset('assets/files/${data.message}') }}"   type="video/mp4"></video></div><button onclick="downloadBtn('${data.message}')"  style="border:none" id="downloadBtn" class="badge bg-secondary downloadBtn">Unduh File</button><div class="message-data text-end">
                                            <span class="message-data-time">${waktu(data.created_date)}    </span>
                                        </div> </div>
                                    </li>`);
                                    } else {

                                        $('#box-message').append(
                                            ` <li class="clearfix">
                                            <div class="message my-message"><pre>${data.message} </pre> <div class="message-data text-end">
                                                <span class="message-data-time">${waktu(data.created_date)}  </span>
                                            </div> </div>
                                        </li>`);
                                    }
                                    $('.chat-history').scrollTop($('#box-message').height());
                                });
                            } else {
                                $.post("{{ route('chat-read') }}", {
                                    conversationId: data.conversation_id,
                                    user_id: '{{ auth()->user()->kd_user }}'
                                }, function(data) {
                                    console.log('success');
                                });
                            }
                            // const notif = $('#toast');
                            $.get('chat/unread-conversation', {
                                cabangId: '{{ auth()->user()->branch_code }}',
                            }, function(data) {
                                console.log(data)
                                $('#is_read').text(data)
                            });
                            $('.name-from').text(data.customer.nama_customer);
                            const toast = $('#toast');
                            toast.addClass('show');
                            setTimeout(function() {
                                toast.removeClass('show');
                            }, 3000); // Toast will be visible for 3 seconds

                            let conversationList = $(
                                `#conversationList li[data-id="${data.conversation_id}"]`);
                            $('#conversationList').prepend(conversationList);
                            $.get('chat/unread-message', {
                                conversationId: data.conversation_id,
                                userId: '{{ auth()->user()->kd_user }}'
                            }, function(result) {
                                $(`#conversationList li[data-id="${data.conversation_id}"] #is_read_message`)
                                    .empty()
                                // $(`span.count-message[data-ids="${data.conversation_id}"]`).text(result);
                                $(`#conversationList li[data-id="${data.conversation_id}"] #is_read_message`)
                                    .append(
                                        `<span class="badge float-end count-message"  data-ids="${data.conversation}"  style="background-color:#c5f79f;color:black;"> ${result} </span>`
                                    )
                                console.log('masuk')

                            });

                            $(`#conversationList li[data-id="${data.conversation_id}"] .time-last`)
                                .text(
                                    data
                                    .created_at);
                            $(`#conversationList li[data-id="${data.conversation_id}"] .currentDay`)
                                .text(
                                    'Hari Ini');
                            showDesktopNotification(data.message, data.customer.nama_customer);

                        }
                        id.push(idMessagge)
                         if(id.length > 50){
                            id =[];
                         }
                    });

                },
                error: function(err) {
                    console.error('Error fetching messages!', err);
                }
            });

        }


        function Load() {

            $('.chat-history').scrollTop($('#box-message').height());
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
                console.log($(this).parent())
                messageElement.find('.time-elapsed').text(timeString);
            });

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

        function waktuAL(waktu) {


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

        function loadMessages(conversationId, id = true) {
            $('.loading').show()
            let lastDate = "";
            $.get(`conversations/${conversationId}/messages`, function(data) {
                $('#box-message').empty();
                data.forEach(message => {
                    // console.log(message);
                    let dateNow = tanggal(message.created_date);

                    // Pisahkan string tanggal berdasarkan tanda '-'
                    let parts = dateNow.split('-');

                    // Urutkan ulang menjadi format DD-MM-YYYY
                    let formattedDate = `${parts[2]}-${parts[1]}-${parts[0]}`;
                    if (formattedDate !== lastDate) {
                        if (formattedDate == nowDate()) {

                            $('#box-message').append(

                                ` <p  class="text-center fw-bold"> Hari Ini</p>
                                `
                            )
                        } else {

                            $('#box-message').append(

                                ` <p  class="text-center fw-bold"> ${lastDate}</p>
                                `
                            )
                        }

                        lastDate = formattedDate;
                    }

                    let is_read = '<i class="bi bi-eye"></i>';
                    if (message.is_read == 'FALSE') {
                        is_read = '<i class="bi bi-eye-slash"></i>'
                    }

                    if (message.status) {
                        if (message.type_message == "FILE") {
                            $('#box-message').append(`
                         <li class="clearfix">
                             <div class="message other-message float-end" >    <div class=""> <i class="bi bi-file-earmark-text"></i> <span>Pdf</span></div><button onclick="downloadBtn('${message.message}')"  style="border:none" id="downloadBtn" class="badge bg-secondary downloadBtn">Unduh File</button>   <div class="message-data text-end" >
                                <span class="message-data-time" >${waktu(message.created_date)}  ${is_read}</span>
                            </div></div>

                          </li> `);
                        } else if (message.type_message == "IMAGE") {
                            $('#box-message').append(`
                            <li class="clearfix">
                                <div class="message other-message float-end">
                                    <div class=""><img src="{{ asset('assets/files/${message.message}') }}" onload="Load()" class="img-thumbnail" max-width="50px;"  ></div><button onclick="downloadBtn('${message.message}')"  style="border:none" id="downloadBtn" class="badge bg-secondary downloadBtn">Unduh File</button>
                                    <div class="message-data text-end">
                                        <span class="message-data-time">${nowTime()}  ${is_read}</span>
                                    </div>
                                </div>
                            </li>`);
                        } else if (message.type_message == "VIDEO") {
                            $('#box-message').append(`
                            <li class="clearfix">
                                <div class="message other-message float-end" >  <div class=""><video  style="max-width: 100%; height: auto;" onloadeddata="Load()" controls ><source src="{{ asset('assets/files/${message.message}') }}"   type="video/mp4"></video></div><button onclick="downloadBtn('${message.message}')"  style="border:none" id="downloadBtn" class="badge bg-secondary downloadBtn">Unduh File</button> <div class="message-data text-end" >
                                    <span class="message-data-time" >${waktu(message.created_date)}  ${is_read}</span>
                                </div></div>

                            </li> `);
                        } else {
                            $('#box-message').append(`
                            <li class="clearfix">
                                <div class="message other-message float-end" ><pre>${message.message} </pre> <div class="message-data text-end" >
                                    <span class="message-data-time" >${waktu(message.created_date)}  ${is_read}</span>
                                </div></div>

                            </li> `);
                        }
                    } else {
                        if (message.type_message == "FILE") {
                            $('#box-message').append(`
                            <li class="clearfix">
                                <div class="message my-message">    <div class=""> <i class="bi bi-file-earmark-text"></i> <span>Pdf</span></div><button onclick="downloadBtn('${message.message}')"  style="border:none" id="downloadBtn" class="badge bg-secondary downloadBtn">Unduh File</button> <div class="message-data text-end">
                                    <span class="message-data-time">${waktu(message.created_date)} </span>
                                </div></div>
                                </li>`);
                        } else if (message.type_message == "IMAGE") {
                            $('#box-message').append(` <li class="clearfix">
                                <div class="message my-message">    <div class=""><img src="{{ asset('assets/files/${message.message}') }}" onload="Load()" class="img-thumbnail" max-width="50px;"  ></div><button onclick="downloadBtn('${message.message}')"  style="border:none" id="downloadBtn" class="badge bg-secondary downloadBtn">Unduh File</button><div class="message-data text-end">
                                    <span class="message-data-time">${waktu(message.created_date)}  </span>
                                </div></div>
                                 </li>`);
                        } else if (message.type_message == "VIDEO") {
                            $('#box-message').append(` <li class="clearfix">
                                <div class="message my-message">     <div class=""><video style="max-width: 100%; height: auto;"  onloadeddata="Load()" controls ><source src="{{ asset('assets/files/${message.message}') }}"   type="video/mp4"></video></div><button onclick="downloadBtn('${message.message}')"  style="border:none" id="downloadBtn" class="badge bg-secondary downloadBtn">Unduh File</button><div class="message-data text-end">
                                    <span class="message-data-time">${waktu(message.created_date)}   </span>
                                </div> </div>
                                </li>`);
                        } else {

                            $('#box-message').append(
                                ` <li class="clearfix">
                                <div class="message my-message"><pre>${message.message} </pre> <div class="message-data text-end">
                                    <span class="message-data-time">${waktu(message.created_date)} </span>
                                </div> </div>
                               </li>`);
                        }
                    }
                    $('.chat-history').scrollTop($('#box-message').height());
                    $('.loading').hide()
                });
                if (id) {

                    $('#messageInput').removeAttr('disabled')
                }
            });
        }

        function updateConversationId(newId) {
            currentConversationId = newId;
            console.log('Conversation ID updated:', currentConversationId);
            connectWebSocket(currentConversationId); // Reconnect dengan ID baru
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
            var formattedTime = day + '-' + month + '-' + year;
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



        $('#close-chatting').click(function() {
            let conversation = $(this).data('conversation');
            console.log(conversation);
            if (!conversation) {
                alert('silahkan pilih percakapan telebih dahulu')
                return false;
            }
            if (!confirm('Kamu yakin ingin menutup percakapan ini?')) {
                return false
            }
            $('.loading').show()
            let formData = {
                'conversationId': conversation
            };

            $.ajax({
                url: "{{ route('chat-close') }}",
                type: "POST",
                data: formData,
                beforeSend: function() {
                    $('#close-chatting').html("Loading...");
                    $('#close-chatting').attr("disabled", "");
                },
                error: function(res) {
                    alert("Error");
                },
                success: function(res) {

                    let message =
                        "Terimakasih telah mengubungi Jamkrindo. \n Silahkan hubungi kembali jika ada pertanyaan yang ingin ditanyakan";
                    $.ajax({
                        url: "{{ route('sendMessage') }}",
                        type: 'POST',
                        data: {
                            conversation_id: conversation,
                            message: message,
                            created_date: now(),
                            status: true,
                            type: 'TEXT',
                            admin: true,
                            sender_id: '{{ auth()->user()->kd_user }}',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(res) {
                            console.log(res)
                            $('#box-message').append(

                                ` <li class="clearfix">
                                    <div class="message other-message float-end" ><pre>${message} </pre>  <div class="message-data text-end" >
                                    <span class="message-data-time" >${nowTime()}  <i class="bi bi-eye-slash"></i></span>
                                                </div></div>
                                                    </li>`
                            );
                            $(`.list-message[data-id="${conversation}"] #is_read_message`)
                                .empty();
                            $.get('chat/unread-conversation', {
                                cabangId: '{{ auth()->user()->branch_code }}',
                                userId: '{{ auth()->user()->kd_customer }}'
                            }, function(data) {
                                $('#is_read').text(data);
                            });
                            $('#messageInput').attr('disabled', true);
                            $('#currentConversationId').val('');
                            $('#close-chatting').data('conversation', '');
                        }
                    });
                    $(`.list-message[data-id=${conversation}] span.adminReceive`).text('')
                    $(`.list-message[data-id=${conversation}] span.adminReceive`).data('id', '')
                },
                complete: function() {
                    $('#close-chatting').html("Close Chat");
                    $('#close-chatting').removeAttr("disabled");
                    $('.loading').hide()
                }
            });
        })

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
            formData.append('sender_id', '{{ auth()->user()->kd_user }}');
            formData.append('admin', true);
            formData.append('status', true);

            $.ajax({
                url: "{{ route('upload-file') }}",
                type: "POST",
                data: formData,
                contentType: false, // Use false to prevent jQuery from overriding the Content-Type header
                processData: false, // Use false to prevent jQuery from trying to process the data
                success: function(data) {
                    console.log(data)
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
                             <div class="message other-message float-end" >    <div class=""> <i class="bi bi-file-earmark-text"></i> <span>  Dokumen</span></div><button onclick="downloadBtn('${data.message}')"  style="border:none" id="downloadBtn" class="badge bg-secondary downloadBtn">Unduh File</button>   <div class="message-data text-end" >
                                <span class="message-data-time" >${nowTime()}  <i class="bi bi-eye-slash"></i></span>
                            </div></div>

                          </li> `);
                    } else if (file == "IMAGE") {

                        $('#box-message').append(`
                        <li class="clearfix">
                        <div class="message other-message float-end">
                             <div class=""><img src="assets/files/${data.message}" class="img-thumbnail" max-width="50px;" onload="Load()"  ></div><button onclick="downloadBtn('${data.message}')"  style="border:none" id="downloadBtn" class="badge bg-secondary downloadBtn">Unduh File</button>
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
                    console.log(response);
                }
            });

        }

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // let websocket = connectWebSocket();
            $.get('chat/unread-conversation', {
                cabangId: '{{ auth()->user()->branch_code }}',
                userId: '{{ auth()->user()->kd_user }}'
            }, function(data) {
                // console.log(data)
                $('#is_read').text(data)
            });
            loadConversations();

            setInterval(fetchMessages, 4000);

            function scrollToBottom() {
                var chatContainer = $('#box-message');
                chatContainer.scrollTop(chatContainer[0].scrollHeight);
            }

            // click-list-message
            $(document).on('click', '.list-message', function() {
                currentConversationId = $(this).data('id');
                $('.loading').show()
                let adminId = $(this).find('span.adminReceive').data('id')
                // console.log(adminId)
                let list = $(this)
                let id_user = {{ auth()->user()->kd_user }};
                let id = true;
                $.post("{{ route('check-receive') }}", {
                    conversationId: currentConversationId,
                    user_id: '{{ auth()->user()->kd_user }}'
                }, function(data) {
                    console.log(data)
                    // console.log(adminId)

                    if (data.receive_id != id_user) {
                        if (data.receive_id != null && adminId != '') {
                            console.log('masuk')
                            if (confirm('Kamu hanya bisa melihat pesan ini!')) {
                                $(`.list-message[data-id="${currentConversationId}"] span.adminReceive`)
                                    .text(data.user.nm_user);
                                $(`.list-message[data-id="${currentConversationId}"] span.adminReceive`)
                                    .data("id", data.receive_id);
                                $('#messageInput').attr('disabled', true)
                                id = false;
                            } else {
                                $('.loading').hide()
                                return false;

                            }

                        } else if (data.receive_id != null && adminId == '') {
                            console.log('masuk')
                            if (confirm('Kamu hanya bisa melihat pesan ini!')) {
                                $(`.list-message[data-id="${currentConversationId}"] span.adminReceive`)
                                    .text(data.user.nm_user ?? '-');
                                $(`.list-message[data-id="${currentConversationId}"] span.adminReceive`)
                                    .data("id", data.receive_id);
                                $('#messageInput').attr('disabled', true)
                                id = false;
                            } else {
                                $('.loading').hide()
                                return false;

                            }

                        } else if (adminId == '' && data.receive_id == null) {
                            if (!confirm('Kamu yakin ingin membalas pesan ini ?')) {
                                $('.loading').hide()
                                return false;
                            } else {
                                $.post("{{ route('chat-reply') }}", {
                                    conversationId: currentConversationId,
                                    user_id: '{{ auth()->user()->kd_user }}'
                                }, function(data) {

                                    $(`.list-message[data-id="${currentConversationId}"] span.adminReceive`)
                                        .text(data.nm_user);
                                    $(`.list-message[data-id="${currentConversationId}"] span.adminReceive`)
                                        .data("id", data.kd_user);
                                });
                                $('#messageInput').removeAttr('disabled');

                            }
                        }
                    }

                    if (data.receive_id == null) {
                        if (!confirm('Kamu yakin ingin membalas pesan ini ?')) {
                            $('.loading').hide()
                            return false;
                        } else {
                            $.post("{{ route('chat-reply') }}", {
                                conversationId: currentConversationId,
                                user_id: '{{ auth()->user()->kd_user }}'
                            }, function(data) {

                                $(`.list-message[data-id="${currentConversationId}"] span.adminReceive`)
                                    .text(data.nm_user);
                                $(`.list-message[data-id="${currentConversationId}"] span.adminReceive`)
                                    .data("id", data.kd_user);
                            });
                            $('#messageInput').removeAttr('disabled');

                        }
                    }
                    $('.list-message').removeClass('active')
                    // $('.list-message a').css('color', '#000')
                    let img = list.data('img');
                    // console.log(img)
                    if (img) {
                        $('#img-customer').html(
                            `<img src="{{ asset('assets/img/customer/${img}') }}" alt="avatar">`
                        )
                    } else {
                        $('#img-customer').html(
                            `<img src="{{ asset('assets/img/person.png') }}" alt="avatar">`)

                    }
                    $('#currentConversationId').val(currentConversationId)
                    $('#nama-title').text(list.data('name'));
                    $('#cabang-title').text(list.data('cabang'));
                    list.addClass('active');
                    list.find('#is_read_message').empty();
                    // console.log($('#close-chatting'))
                    $('button#close-chatting').data('conversation', currentConversationId);

                    // console.log($(this, '.list-message x`a').text())

                loadMessages(currentConversationId, id);
                // connectWebSocket(currentConversationId);
            });

        });

        $('#sendMessage').click(function() {
            const message = $('#messageInput').val();

            // Pastikan currentConversationId sudah terupdate dengan benar
            if (!currentConversationId) {
                console.error('No conversation ID set');

                return false;
            }
            const files = $('#document')[0].files
            const imageFiles = $('#gambarin')[0].files;
            const videoFiles = $('#video')[0].files;
            console.log(" id " + currentConversationId)
            if (message && currentConversationId) {
                if (!message) return; // Jangan kirim jika tidak ada pesan

                $.ajax({
                    url: "{{ route('sendMessage') }}",
                    type: 'POST',
                    data: {
                        conversation_id: currentConversationId,
                        message: message,
                        created_date: now(),
                        status: true,
                        type: 'TEXT',
                        admin: true,
                        sender_id: '{{ auth()->user()->kd_user }}',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        console.log(res)
                        $('#box-message').append(

                            ` <li class="clearfix">
                                      <div class="message other-message float-end" ><pre>${message} </pre>  <div class="message-data text-end" >
                                       <span class="message-data-time" >${nowTime()}  <i class="bi bi-eye-slash"></i></span>
                                                </div></div>
                                                     </li>`
                        );
                        $('#messageInput').val('');

                        $('.chat-history').scrollTop($('#box-message').height());
                        $(`.list-message[data-id="${currentConversationId}"] #is_read_message`)
                                .empty()
                        }
                    });
                } else if (imageFiles[0] && imageFiles[0].type.startsWith('image/') &&
                    currentConversationId) {
                    uploadFile(imageFiles[0], 'IMAGE', currentConversationId);
                } else if (files[0] && files[0].type === 'application/pdf' && currentConversationId) {
                    uploadFile(files[0], 'FILE', currentConversationId);
                } else if (videoFiles.length > 0 && videoFiles[0].type.startsWith('video/') &&
                    currentConversationId) {
                    console.log('Video file detected');
                    uploadFile(videoFiles[0], 'VIDEO', currentConversationId);
                } else if (imageFiles[0] && imageFiles[0].type.startsWith('image/') &&
                    currentConversationId) {
                    uploadFile(imageFiles[0], 'IMAGE', currentConversationId);
                } else if (files[0] && files[0].type === 'application/pdf' && currentConversationId) {
                    uploadFile(files[0], 'FILE', currentConversationId);
                } else if (videoFiles.length > 0 && videoFiles[0].type.startsWith('video/') &&
                    currentConversationId) {
                    console.log('Video file detected');
                    uploadFile(videoFiles[0], 'VIDEO', currentConversationId);
                }
                setTimeout(function() {

                    $.get('chat/unread-conversation', {
                        cabangId: '{{ auth()->user()->branch_code }}',
                        userId: '{{ auth()->user()->kd_customer }}'
                    }, function(data) {
                        console.log(data)
                        $('#is_read').text(data)
                    });
                }, 3000);

            });
        });
    </script>
@stop
@endsection
