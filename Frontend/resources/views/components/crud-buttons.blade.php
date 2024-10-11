<a href="{{ route($baseRoute . '.show', $id) }}" class="btn btn-primary btn-lg btn-block">Anzeigen</a>
<a href="{{ route($baseRoute . '.edit', $id) }}" class="btn btn-warning btn-lg btn-block">Bearbeiten</a>
<form action="{{ route($baseRoute . '.destroy', $id) }}" method="POST" class="d-inline">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-lg btn-block">Löschen</button>
</form>
