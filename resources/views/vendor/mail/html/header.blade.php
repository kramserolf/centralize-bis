@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{ asset('images/barangay_logo/baggao.png') }}" class="logo" alt="Barangay Logo" height="60" width="60">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
