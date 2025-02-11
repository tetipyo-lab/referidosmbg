<x-mail::message>
<x-mail::panel>
# {{ $asunto }}
</x-mail::panel>

<div style="margin: 20px 0;">
{!! nl2br(e($mensaje)) !!}
</div>

<x-mail::subcopy>
¿Necesitas ayuda? No dudes en contactarnos.
</x-mail::subcopy>

<x-mail::footer>
Saludos cordiales,<br>
El equipo de {{ config('app.name') }}
</x-mail::footer>
</x-mail::message>
