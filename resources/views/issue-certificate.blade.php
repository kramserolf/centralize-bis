<x-mail::layout>
{{-- Header --}}
<x-slot:header>
<x-mail::header :url="config('app.url')" style="background-color: white">
    <img src="{{ asset('images/barangay_logo/'.$logo.'')}}" class="logo" alt="Barangay {{ $logo }} Logo" height="60" width="60">
</x-mail::header>
</x-slot:header>

# Hi {{ $name }}!

## Your Certificate of {{ $certificate  }} is available for pick up.


Our office is open 8am - 5pm Monday to Friday.

Thanks,<br>
Office of the Barangay {{ $barangay }}.

{{-- Subcopy --}}
@isset($subcopy)
<x-slot:subcopy>
<x-mail::subcopy>
{{ $subcopy }}
</x-mail::subcopy>
</x-slot:subcopy>
@endisset

{{-- Footer --}}
<x-slot:footer>
<x-mail::footer>
© {{ date('Y') }} Barangay {{ $barangay }}. @lang('All rights reserved.')
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>

