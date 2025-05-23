@foreach ($messages as $message)
    <div><strong>{{ $message->customer->nama_customer }}</strong>: {{ $message->message }}</div>
@endforeach

<script>
    scrollChatToBottom();
    
    Echo.private('conversations.{{ $conversationId }}')
        .listen('ConversationChatSentEvent', (event) => {
            console.log('ConversationChatSentEvent', event);
            renderMessage(event.message);
            scrollChatToBottom();
        });

    function scrollChatToBottom() {
        $('#messages').scrollTop($('#messages')[0].scrollHeight);
    }

    function renderMessage(message) {
        $('#messages').append(
            `
                <div><strong>${message.customer.nama_customer}</strong>: ${message.message}</div>
            `
        );
    }
</script>