@component('mail::message')
# Olá, {{ $stakeholder->name ?? 'time' }}

Este é um lembrete referente ao projeto **{{ $project->name ?? 'N/D' }}**.

- **Data da notificação:** {{ \Illuminate\Support\Carbon::parse($reminder->notification_date)->format('d/m/Y') }}
- **Dias após deploy:** {{ $reminder->days_after_deploy }}

@isset($project->id)
@component('mail::button', ['url' => url('/projects/'.$project->id)])
Ver projeto
@endcomponent
@endisset

Se você não for o contato certo, por favor encaminhe para o responsável.

Obrigado,
{{ config('app.name') }}
@endcomponent
