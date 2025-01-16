<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Dashboard JAMKRINDO</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">

    <!-- Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.1.2/css/dataTables.dataTables.min.css" rel="stylesheet">

    <!-- Bootstrap Select CSS -->
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css"> --}}
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-5-theme/1.2.0/select2-bootstrap-5-theme.min.css"
        rel="stylesheet">
    {{-- <script type="module" src="{{ asset('assets/vendor/ckeditor/ckeditor.js') }}"></script> --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
    <script src="https://cdn.tiny.cloud/1/mj7ot4pe00x1i38dfbs3wy1cdqbc972wvvke0lz3w5rbo85g/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css"> --}}
    <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->

    <script src="{{ asset('assets/js/app.js') }}"></script>

    <style>
        #chat-circle {
            position: fixed;
            bottom: 10px;
            right: 30px;
            background: #080e7e;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            color: white;
            padding: 15px;
            cursor: pointer;
            box-shadow: 0px 3px 16px 0px rgba(0, 0, 0, 0.6), 0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 1px 5px 0 rgba(0, 0, 0, 0.12);
        }

        .btn#my-btn {
            background: white;
            padding-top: 13px;
            padding-bottom: 12px;
            border-radius: 45px;
            padding-right: 40px;
            padding-left: 40px;
            color: #5865C3;
        }

        #chat-overlay {
            background: rgba(255, 255, 255, 0.1);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            display: none;
        }


        .chat-box {
            display: none;
            background: #efefef;
            position: fixed;
            right: 30px;
            bottom: 15px;
            width: 350px;
            max-width: 85vw;
            max-height: 80vh;
            border-radius: 5px;
            /*   box-shadow: 0px 5px 35px 9px #464a92; */
            box-shadow: 0px 5px 35px 9px #ccc;
        }

        .chat-box-toggle {
            float: right;
            margin-right: 15px;
            cursor: pointer;
        }

        .chat-box-header {
            background: #080e7e;
            height: 50px;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
            color: white;
            text-align: center;
            font-size: 20px;
            padding-top: 10px;
        }

        .chat-box-body {
            position: relative;
            height: 20 0px;
            height: auto;
            border: 1px solid #ccc;
            overflow: hidden;
        }

        .chat-box-body:after {
            content: "";
            background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgdmlld0JveD0iMCAwIDIwMCAyMDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGcgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMTAgOCkiIGZpbGw9Im5vbmUiIGZpbGwtcnVsZT0iZXZlbm9kZCI+PGNpcmNsZSBzdHJva2U9IiMwMDAiIHN0cm9rZS13aWR0aD0iMS4yNSIgY3g9IjE3NiIgY3k9IjEyIiByPSI0Ii8+PHBhdGggZD0iTTIwLjUuNWwyMyAxMW0tMjkgODRsLTMuNzkgMTAuMzc3TTI3LjAzNyAxMzEuNGw1Ljg5OCAyLjIwMy0zLjQ2IDUuOTQ3IDYuMDcyIDIuMzkyLTMuOTMzIDUuNzU4bTEyOC43MzMgMzUuMzdsLjY5My05LjMxNiAxMC4yOTIuMDUyLjQxNi05LjIyMiA5LjI3NC4zMzJNLjUgNDguNXM2LjEzMSA2LjQxMyA2Ljg0NyAxNC44MDVjLjcxNSA4LjM5My0yLjUyIDE0LjgwNi0yLjUyIDE0LjgwNk0xMjQuNTU1IDkwcy03LjQ0NCAwLTEzLjY3IDYuMTkyYy02LjIyNyA2LjE5Mi00LjgzOCAxMi4wMTItNC44MzggMTIuMDEybTIuMjQgNjguNjI2cy00LjAyNi05LjAyNS0xOC4xNDUtOS4wMjUtMTguMTQ1IDUuNy0xOC4xNDUgNS43IiBzdHJva2U9IiMwMDAiIHN0cm9rZS13aWR0aD0iMS4yNSIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIi8+PHBhdGggZD0iTTg1LjcxNiAzNi4xNDZsNS4yNDMtOS41MjFoMTEuMDkzbDUuNDE2IDkuNTIxLTUuNDEgOS4xODVIOTAuOTUzbC01LjIzNy05LjE4NXptNjMuOTA5IDE1LjQ3OWgxMC43NXYxMC43NWgtMTAuNzV6IiBzdHJva2U9IiMwMDAiIHN0cm9rZS13aWR0aD0iMS4yNSIvPjxjaXJjbGUgZmlsbD0iIzAwMCIgY3g9IjcxLjUiIGN5PSI3LjUiIHI9IjEuNSIvPjxjaXJjbGUgZmlsbD0iIzAwMCIgY3g9IjE3MC41IiBjeT0iOTUuNSIgcj0iMS41Ii8+PGNpcmNsZSBmaWxsPSIjMDAwIiBjeD0iODEuNSIgY3k9IjEzNC41IiByPSIxLjUiLz48Y2lyY2xlIGZpbGw9IiMwMDAiIGN4PSIxMy41IiBjeT0iMjMuNSIgcj0iMS41Ii8+PHBhdGggZmlsbD0iIzAwMCIgZD0iTTkzIDcxaDN2M2gtM3ptMzMgODRoM3YzaC0zem0tODUgMThoM3YzaC0zeiIvPjxwYXRoIGQ9Ik0zOS4zODQgNTEuMTIybDUuNzU4LTQuNDU0IDYuNDUzIDQuMjA1LTIuMjk0IDcuMzYzaC03Ljc5bC0yLjEyNy03LjExNHpNMTMwLjE5NSA0LjAzbDEzLjgzIDUuMDYyLTEwLjA5IDcuMDQ4LTMuNzQtMTIuMTF6bS04MyA5NWwxNC44MyA1LjQyOS0xMC44MiA3LjU1Ny00LjAxLTEyLjk4N3pNNS4yMTMgMTYxLjQ5NWwxMS4zMjggMjAuODk3TDIuMjY1IDE4MGwyLjk0OC0xOC41MDV6IiBzdHJva2U9IiMwMDAiIHN0cm9rZS13aWR0aD0iMS4yNSIvPjxwYXRoIGQ9Ik0xNDkuMDUgMTI3LjQ2OHMtLjUxIDIuMTgzLjk5NSAzLjM2NmMxLjU2IDEuMjI2IDguNjQyLTEuODk1IDMuOTY3LTcuNzg1LTIuMzY3LTIuNDc3LTYuNS0zLjIyNi05LjMzIDAtNS4yMDggNS45MzYgMCAxNy41MSAxMS42MSAxMy43MyAxMi40NTgtNi4yNTcgNS42MzMtMjEuNjU2LTUuMDczLTIyLjY1NC02LjYwMi0uNjA2LTE0LjA0MyAxLjc1Ni0xNi4xNTcgMTAuMjY4LTEuNzE4IDYuOTIgMS41ODQgMTcuMzg3IDEyLjQ1IDIwLjQ3NiAxMC44NjYgMy4wOSAxOS4zMzEtNC4zMSAxOS4zMzEtNC4zMSIgc3Ryb2tlPSIjMDAwIiBzdHJva2Utd2lkdGg9IjEuMjUiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIvPjwvZz48L3N2Zz4=');
            opacity: 0.1;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            height: 80%;
            position: absolute;
            z-index: -1;
        }

        #chat-input {
            background: #f4f7f9;
            width: 100%;
            position: relative;
            height: 47px;
            padding-top: 10px;
            padding-right: 50px;
            padding-bottom: 10px;
            padding-left: 15px;
            border: none;
            resize: none;
            outline: none;
            border: 1px solid #ccc;
            color: #888;
            border-top: none;
            border-bottom-right-radius: 5px;
            border-bottom-left-radius: 5px;
            overflow: hidden;
        }

        .chat-input>form {
            margin-bottom: 0;
        }

        #chat-input::-webkit-input-placeholder {
            /* Chrome/Opera/Safari */
            color: #ccc;
        }

        #chat-input::-moz-placeholder {
            /* Firefox 19+ */
            color: #ccc;
        }

        #chat-input:-ms-input-placeholder {
            /* IE 10+ */
            color: #ccc;
        }

        #chat-input:-moz-placeholder {
            /* Firefox 18- */
            color: #ccc;
        }

        .chat-submit {
            position: absolute;
            bottom: 3px;
            right: 10px;
            background: transparent;
            box-shadow: none;
            border: none;
            border-radius: 50%;
            color: #5A5EB9;
            width: 35px;
            height: 35px;
        }

        .chat-logs {
            padding: 15px;
            height: 370px;
            overflow-y: scroll;
        }

        .chat-logs::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
            background-color: #F5F5F5;
        }

        .chat-logs::-webkit-scrollbar {
            width: 5px;
            background-color: #F5F5F5;
        }

        .chat-logs::-webkit-scrollbar-thumb {
            background-color: #5A5EB9;
        }



        @media only screen and (max-width: 500px) {
            .chat-logs {
                height: 40vh;
            }
        }

        .chat-msg.user>.msg-avatar img {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            float: left;
            width: 15%;
        }

        .chat-msg.self>.msg-avatar img {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            float: right;
            width: 15%;
        }

        .cm-msg-text {
            background: white;
            padding: 10px 15px 10px 15px;
            color: #666;
            max-width: 75%;
            float: left;
            margin-left: 10px;
            position: relative;
            margin-bottom: 20px;
            border-radius: 30px;
        }

        .chat-msg {
            clear: both;
        }

        .chat-msg.self>.cm-msg-text {
            float: right;
            margin-right: 10px;
            background: #5A5EB9;
            color: white;
        }

        .cm-msg-button>ul>li {
            list-style: none;
            float: left;
            width: 50%;
        }

        .cm-msg-button {
            clear: both;
            margin-bottom: 70px;
        }

        .select2-container--bootstrap-5 .select2-selection {
            border: 1px solid #ced4da;
            /* Border bawaan Bootstrap 5 */
            border-radius: 0.375rem;
            /* Border-radius untuk Bootstrap 5 */
            height: calc(1.5em + 0.75rem + 2px);
            /* Sesuaikan tinggi agar sesuai dengan input bootstrap */
            padding: 0.375rem 0.75rem;
            /* Padding dalam input */
        }

        /* Fokus pada select2 agar sesuai dengan bootstrap */
        .select2-container--bootstrap-5 .select2-selection--single:focus {
            border-color: #86b7fe;
            /* Warna border saat focus */
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
            /* Shadow seperti pada input bootstrap */
        }
    </style>


</head>

<body>
    @include('layouts.header')

    @include('layouts.sidebar')
    <main id="main" class="main">
        <div id="toast">

            <div class="alert alert-primary" role="alert">
                <i class="bi bi-bell"></i> Masuk :
                <span class="name-from fw-bold"></span>
            </div>
        </div>

        @yield('main')
        @if (auth()->user()->kd_customer)

            @if ($percakapan == null)
                <input type="hidden" name="" id="conversationId" value="">
            @else
                <input type="hidden" name="" id="conversationId" value="{{ $percakapan->id }}">
            @endif
        @else
            <input type="hidden" name="" id="conversationId" value="">
        @endif
        <audio id="notificationSound" src="{{ asset('assets/notif/notif.mp3') }}" preload="auto"></audio>
        <div id="body">

            <a href="/chat">
                <div id="chat-circle" class="btn btn-raised">
                    <div id="chat-overlay"></div>
                    <i class="bi bi-chat-left-dots"></i>
                </div>
            </a>

            <div class="chat-box">
                <div class="chat-box-header">
                    ChatBot
                    <span class="chat-box-toggle"><i class="bi bi-x-circle"></i></span>
                </div>
                <div class="chat-box-body">
                    <div class="chat-box-overlay">
                    </div>
                    <div class="chat-logs">

                    </div><!--chat-log -->
                </div>
                <div class="chat-input">
                    <form>
                        <input type="text" id="chat-input" placeholder="Send a message..." />
                        <button type="submit" class="chat-submit" id="chat-submit"><i
                                class="bi bi-send-fill"></i></button>
                    </form>
                </div>
            </div>
        </div>

    </main><!-- End #main -->
    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span><a href="https://cnplus.id/">CNPLUS</a></span></strong>. All Rights Reserved
        </div>
        {{-- <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
            <!--Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>-->
        </div> --}}
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="https://cdn.tiny.cloud/1/mj7ot4pe00x1i38dfbs3wy1cdqbc972wvvke0lz3w5rbo85g/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea.tinymce', // Replace this CSS selector to match the placeholder element for TinyMCE
            plugins: 'code table lists',
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
        });
    </script>
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/quill/quill.js') }}"></script>
    {{-- <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script> --}}
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
    <!-- Template Main JS File -->
    <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="
        crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/2.1.2/js/dataTables.min.js"></script>

    <!-- Bootstrap Select JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>

    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>


    {{-- @if (!request()->is('chat') && !request()->is('chat-customer'))
        @if (auth()->user()->kd_user)
            <script>
                const baseWsUrl = 'ws://10.220.60.63:8090?type=admin&';
                let socket = null;
                $(document).ready(function() {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.get('chat/unread-conversation', {
                        cabangId: '{{ auth()->user()->branch_code }}',
                        userId: '{{ auth()->user()->kd_customer }}'
                    }, function(data) {
                        $('#is_read').text(data)
                    });
                    if (!socket || socket.readyState !== WebSocket.OPEN) {
                        connectWebSocket();
                    }
                    // if (!localStorage.getItem('wsConnected')) {
                    //     connectWebSocket().then(() => {
                    //         localStorage.setItem('wsConnected', true);
                    //     });
                    // } else {
                    //     console.log("WebSocket sudah terbuka dari halaman sebelumnya.");
                    // }
                    // console.log(localStorage)


                });


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

                function connectWebSocket(chatId = null) {
                    return new Promise((resolve, reject) => {
                        if (socket && socket.readyState === WebSocket.OPEN) {
                            // console.log('WebSocket is already connected.');
                            resolve(chatId); // Resolve the promise if already connected
                            return;
                        }

                        const wsUrl =
                            `${baseWsUrl}id_cabang={{ auth()->user()->branch_code }}&id_user={{ auth()->user()->kd_user }}&conversation_id=${chatId}`;
                        // console.log('Connecting to:', wsUrl);
                        socket = new WebSocket(wsUrl);

                        socket.onopen = function() {
                            console.log('WebSocket connection opened.');
                            resolve(chatId); // Resolve the promise when connection opens
                        };

                        socket.onmessage = function(event) {
                            const data = JSON.parse(event.data);
                            playNotificationSound()
                            var lastMessageTime = new Date().toISOString();

                            // const inputConversationId = $('#currentConversationId').val();

                            // onMessageReceived();
                            // console.log(inputConversationId);

                            // if (data.conversation_id == inputConversationId) {

                            //     $('#box-message').append(
                            //         ` <li class="clearfix">
                //         <div class="message my-message">${data.message}</div>
                //         <div class="message-data">
                //           <span class="message-data-time">${data.created_at}<i class="bi bi-eye"></i></span>
                //            </div>
                //            </li>`
                            //     );
                            // }
                            // const notif = $('#toast');

                            const toast = $('#toast');
                            $('.name-from').text(data.send_id);
                            toast.addClass('show');
                            setTimeout(function() {
                                toast.removeClass('show');
                            }, 3000); // Toast will be visible for 3 seconds
                            $.get('chat/unread-conversation', {
                                cabangId: '{{ auth()->user()->branch_code }}',
                                userId: '{{ auth()->user()->kd_customer }}'
                            }, function(data) {
                                $('#is_read').text(data)
                            });
                            // setTimeout(function() {
                            //     notif.fadeOut()
                            // }, 2000);

                            // $('#notif').append(` <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                //      <div class="toast-header">
                //      <strong class="me-auto"> ${data.send_id}</strong>
                //         <small class="text-body-secondary timeElapsed"  data-timestamp="${lastMessageTime}"><span class="time-elapsed"></span> </small>
                //          <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                //         </div>
                //         <div class="toast-body">
                //              ${data.message}
                //                  </div>
                //           </div>`);
                            // var chatContainer = $('#box-message');
                            // chatContainer.scrollTop(chatContainer[0].scrollHeight);
                            showDesktopNotification(data.message, data.send_id);
                        };

                        socket.onclose = function() {
                            // console.log('WebSocket connection closed.');
                            setTimeout(connectWebSocket(), 3000);
                        };

                        socket.onerror = function(error) {
                            console.error('WebSocket error:', error);
                            reject(error); // Reject the promise if there's an error
                        };
                    });

                }
            </script>
        @endif
        @if (auth()->user()->kd_customer)
            <script>
                const baseWsUrl = 'ws://10.220.60.63:8090?type=customer&';
                let socket = null;
                const conversationId = $('#conversationId').val();

                $(document).ready(function() {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    if (!socket || socket.readyState !== WebSocket.OPEN) {
                        connectWebSocket(conversationId);
                    }
                    // if (!localStorage.getItem('wsConnected')) {
                    //     connectWebSocket().then(() => {
                    //         localStorage.setItem('wsConnected', true);
                    //     });
                    // } else {
                    //     console.log("WebSocket sudah terbuka dari halaman sebelumnya.");
                    // }
                    // console.log(localStorage)

                });


                function showDesktopNotification(message, from) {
                    if (Notification.permission === 'granted') {
                        const notification = new Notification('Cs - ' + from, {
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

                function connectWebSocket(chatId = null) {
                    return new Promise((resolve, reject) => {
                        if (socket && socket.readyState === WebSocket.OPEN) {
                            // console.log('WebSocket is already connected.');
                            resolve(chatId); // Resolve the promise if already connected
                            return;
                        }

                        const wsUrl =
                            `${baseWsUrl}id_cabang={{ auth()->user()->kd_cabang }}&id_user={{ auth()->user()->kd_customer }}&conversation_id=${chatId}`;
                        // console.log('Connecting to:', wsUrl);
                        socket = new WebSocket(wsUrl);

                        socket.onopen = function() {
                            console.log('WebSocket connection opened.');
                            resolve(chatId); // Resolve the promise when connection opens
                        };

                        socket.onmessage = function(event) {
                            const data = JSON.parse(event.data);
                            playNotificationSound()
                            var lastMessageTime = new Date().toISOString();

                            // const inputConversationId = $('#currentConversationId').val();

                            // onMessageReceived();
                            // console.log(inputConversationId);

                            // if (data.conversation_id == inputConversationId) {

                            //     $('#box-message').append(
                            //         ` <li class="clearfix">
                //         <div class="message my-message">${data.message}</div>
                //         <div class="message-data">
                //           <span class="message-data-time">${data.created_at}<i class="bi bi-eye"></i></span>
                //            </div>
                //            </li>`
                            //     );
                            // }
                            // const notif = $('#toast');

                            const toast = $('#toast');
                            $('.name-from').text(data.send_id);
                            toast.addClass('show');
                            setTimeout(function() {
                                toast.removeClass('show');
                            }, 3000); // Toast will be visible for 3 seconds

                            // setTimeout(function() {
                            //     notif.fadeOut()
                            // }, 2000);

                            // $('#notif').append(` <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                //      <div class="toast-header">
                //      <strong class="me-auto"> ${data.send_id}</strong>
                //         <small class="text-body-secondary timeElapsed"  data-timestamp="${lastMessageTime}"><span class="time-elapsed"></span> </small>
                //          <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                //         </div>
                //         <div class="toast-body">
                //              ${data.message}
                //                  </div>
                //           </div>`);
                            // var chatContainer = $('#box-message');
                            // chatContainer.scrollTop(chatContainer[0].scrollHeight);
                            showDesktopNotification(data.message, data.send_id);
                        };

                        socket.onclose = function() {
                            console.log('WebSocket connection closed.');

                        };

                        socket.onerror = function(error) {
                            console.error('WebSocket error:', error);
                            reject(error); // Reject the promise if there's an error
                        };
                    });

                }
            </script>
        @endif
    @endif --}}

    @yield('script')


</body>

</html>
