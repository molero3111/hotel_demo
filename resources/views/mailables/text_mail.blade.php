@component('mail::message')
# Introduction

The body of your message. so hello {{$param}}

@component('mail::button', ['url' => '12313'])
Button Text <button disabled="disabled"></button>
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
