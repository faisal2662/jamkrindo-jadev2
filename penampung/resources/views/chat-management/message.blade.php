@foreach ($messages as $message)
    @if ($message->status)
        <div class="justify-content-end">
            <p class="small p-2 text-white mb-1 rounded-3 bg-primary" style="margin-left: 40px;">
                {{ $message->message }}
                <span class="small ms-3 mb-3 rounded-3 text-muted">{{ date('H:i', strtotime($message->created_date)) }}</span>
            </p>
        </div>
    @else
        <div class="justify-content-start">
            <p class="small p-2 mb-1 rounded-3 bg-body-tertiary" style="margin-right: 40px;">
                {{ $message->message }}
                <span class="small ms-3 mb-3 rounded-3 text-muted">{{ date('H:i', strtotime($message->created_date)) }}</span>
            </p>
        </div>
    @endif
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
        $('#box-message').scrollTop($('#box-message')[0].scrollHeight);
    }

    function renderMessage(message) {
        if (message.status) {
            $('#box-message').append(
                `
                    <div class="justify-content-end">
                        <p class="small p-2 text-white mb-1 rounded-3 bg-primary" style="margin-left: 40px;">
                            ${message.message}
                            <span class="small ms-3 mb-3 rounded-3 text-muted">${waktu(message.created_date)}</span>
                        </p>
                    </div>
                `
            );
        } else {
            $('#box-message').append(
                `
                    <div class="justify-content-start">
                        <p class="small p-2 mb-1 rounded-3 bg-body-tertiary" style="margin-right: 40px;">
                            ${message.message}
                            <span class="small ms-3 mb-3 rounded-3 text-muted">${waktu(message.created_date)}</span>
                        </p>
                    </div>
                `
            );
        }
    }
</script>