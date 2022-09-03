<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
{{-- <nav class="navbar navbar-expand-md header navbar-dark w3-animate-bottom shadow" >
<!-- Brand -->
    <span class="mail-logo w3-animate-right w-50">
        <a class="mail-title" href="#">Hotel Inverdata</a>
    </span>
</nav>
<div class="navbar-space"></div> --}}
