@component('mail::message')
{{-- Greeting --}}
@isset($greeting)
# {{ $greeting }}
@else
@if ($level === 'error')
# Whoops!
@else
# Halo!
@endif
@endisset

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    $color = match($level) {
        'success' => 'green',
        'error' => 'red',
        default => 'green',
    };
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}
@isset($salutation)
{{ $salutation }}
@else
Salam,
<br>
{{ config('app.name') }}
@endisset

{{-- Subcopy --}}
@isset($actionText)
@slot('subcopy')
Jika Anda mengalami kesulitan menekan tombol "{{ $actionText }}", salin dan tempel URL berikut ke peramban Anda:
[{{ $actionUrl }}]({{ $actionUrl }})
@endslot
@endisset
@endcomponent
