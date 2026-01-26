@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if(email_logo_url())
<img src="{{ email_logo_url() }}" 
     alt="{{ setting('site_name', config('app.name')) }}" 
     style="width: {{ setting('email_logo_width', '150') }}px; height: {{ setting('email_logo_height', '60') }}px; object-fit: contain;">
@else
{!! $slot !!}
@endif
</a>
</td>
</tr>
