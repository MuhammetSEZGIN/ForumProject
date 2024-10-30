{{--Validation sırasında dönen hataları yakalar ve $message kısmına hata içeriğini paylaşır
Controller kısmında kendi hata türlerimizi oluşturabiliriz. Oluşturmazsak eğer default olarak
validation sırasında alınan verilerin adlarına göre hata mesajları döner.
--}}
@props(['name'])
@error($name)
<p {{$attributes->merge(['class'=>'fs-6', 'style'=>'color:red;'])}}>{{$message}}</p>
@enderror
