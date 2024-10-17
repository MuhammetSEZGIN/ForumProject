
@props(['name'])
@error($name)
<p {{$attributes->merge(['class'=>'fs-6', 'style'=>'color:red;'])}}>{{$message}}</p>
@enderror
