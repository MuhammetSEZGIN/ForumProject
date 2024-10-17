@props(['$href'=>'#', 'divClass'=>'', 'linkClass'=>''])
    <div {{$attributes->merge(['class'=>'container-fluid' .$divClass])}}>
        <a {{$attributes->merge(['class'=>'navbar-brand'. $linkClass])}} >{{$slot}}</a>
    </div>
