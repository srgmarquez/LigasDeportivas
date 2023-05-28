<form action="{{ url('/equipo/' . $equipo->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    {{ method_field('PATCH') }}
    @include('equipo.form-equipo', ['modo' => 'Editar'])
</form>