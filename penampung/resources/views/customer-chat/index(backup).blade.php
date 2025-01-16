<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="{{ asset('assets/js/app.js') }}"></script>

    <title>Document</title>
    <style>
        .bg-conversation {
            background-color: rgb(192, 193, 194);
        }
    </style>
</head>

<body>



    <div class="row">
        <div class="col-md-4">
            <h4>Conversations as {{ auth()->user()->nama_customer }}</h4>
            <ul class="list-group" id="conversationList">
                <!-- Daftar percakapan akan muncul di sini -->
            </ul>
        </div>
        <div class="col-md-8">
            <div id="chatWindow">
                <h4>Chat</h4>
                @if (!auth()->user()->is_admin)
                    <span class=""><button onclick="generateChat('{{ auth()->user()->kd_cabang }}')"
                            {{-- style="display:none;" --}} class="btn btn-primary " id="generateChat">Buat Ruang Chat
                            Baru</button></span>
                @endif
                <div id="messages" style="height: 300px; overflow-y: scroll; border: 1px solid #ccc; padding: 10px;">
                    <!-- Pesan akan muncul di sini -->
                </div>
                <div class="mt-3">
                    <textarea id="messageInput" class="form-control" placeholder="Type a message..."></textarea>
                    <button id="sendMessage" class="btn btn-primary mt-2">Send</button>
                    @if (!auth()->user()->is_admin)
                        <span id="alert" class="text-danger" style="display: none">Silahkan buat ruang chat terlebih
                            dahulu</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>


    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var currentConversationId;
// setInterval(function() {
//             // Reload halaman setiap 2000 milidetik (2 detik)
//             location.reload();
//         }, 2000); // 2 detik
            loadConversations();

            $(document).on('click', '#conversationList .list-group-item', function() {

                $('#conversationList .list-group-item').removeClass('bg-conversation')
                if (currentConversationId !== undefined) {
                    Echo.leave(`conversations.${currentConversationId}`);
                }
                currentConversationId = $(this).data('id');
                $(this).addClass('bg-conversation')
                loadMessages(currentConversationId);
            });

            $('#sendMessage').click(function() {
                const message = $('#messageInput').val();
                console.log(currentConversationId)
                if (message && currentConversationId) {
                    $.post('customer/messages', {
                        conversation_id: currentConversationId,
                        message: message
                    }, function(data) {
                        $('#messages').append(
                            `<div style="text-align:end;"><strong>{{ auth()->user()->nama_customer }}</strong>: ${data.message}</div>`
                            );
                        $('#messageInput').val('');
                    });
                }
                 loadMessages(currentConversationId)
                 
                // if(currentConversationId == null){

                // }


            });
        });

        function loadConversations() {
            $.get('customer/conversations', function(data) {
                $('#conversationList').empty();
                // console.log(data)
                if (data.length == 0) {
                    // $('#generateChat').css('display', 'block')
                    $('#sendMessage').attr('disabled', '')
                    $('#alert').css('display', 'block')
                } else {
                    $('#sendMessage').removeAttr('disabled', '')
                    // $('#generateChat').css('display', 'none')
                }
                data.forEach(conversation => {
                    $('#conversationList').append(
                        `<li class="list-group-item" data-id="${conversation.id}">Conversation ${conversation.id}</li>`
                    );
                });
            });
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
                $.get(`customer/conversations/${conversationId}/messages`, function(data) {
                    $('#messages').empty();
                    data.forEach(message => {
                        console.log(message)
                        if (message.status) {
                            $('#messages').append(
                                `<div><strong>admin - ${message.user.nm_user}</strong>: ${message.message}</div>`
                            );
                        } else {

                            $('#messages').append(
                                `<div style="text-align:end;"><strong>${message.customer.nama_customer}</strong>: ${message.message}</div>`
                            );
                        }
                         var chatContainer = $('#messages');
                        chatContainer.scrollTop(chatContainer[0].scrollHeight);
                    });
                });
            }
        
    </script>

</body>

</html>
