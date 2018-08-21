<!-- Check if There is a Notification -->
@if($notification)
<li class="no-phone">
    <!--  when click we should make the notification as read -->
    <a class="icon" 
        href="{{ $notification->action_url }}" 
        data-role="hint" 
        data-hint="{{ $notification->action_text }}|{{ $notification->body }}"
        @if($notification->read == 0) 
            data-hint-background="bg-green" 
        @else 
            data-hint-background="bg-amber" 
        @endif
            data-hint-color="fg-white">&nbsp;
            <span class="mif-bell 
            @if($notification->read == '0')
                mif-ani-ring mif-ani-fast fg-lightGreen 
            @else
                fg-amber 
            @endif"
            >
            </span>
    </a>
</li>
@endif