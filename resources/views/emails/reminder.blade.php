@component('mail::message')
# Olá, {{ $stakeholder->name ?? 'time' }}

Este é um lembrete do projeto **{{ $project->name ?? 'N/D' }}**.

- Data de notificação: {{ \Illuminate\Support\Carbon::parse($reminder->notification_date)->format('d/m/Y') }}
- Dias após deploy: {{ $reminder->days_after_deploy }}

@component('mail::button', ['url' => url('/projects/'.$project->id)])
Ver projeto
@endcomponent

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
