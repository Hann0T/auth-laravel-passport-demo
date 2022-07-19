@if(!empty( $grades ))
<h1>Notas</h1>
@foreach($grades as $grade)
<div>
    <p>Alumno: {{$grade->user->name}}</p>
    <p>Id: {{$grade->id}}</p>
    <p>nota: {{$grade->value}}</p>

    @can('update', $grade)
    <a href="/grades/edit/{{$grade->id}}">editar nota</a>
    @endcan
</div>
@endforeach

@else
<p>Sin notas</p>
@endif