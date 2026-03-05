<a href="{{ route('users.edit', $id) }}" class="btn btn-sm btn-primary">Edit</a>

<form action="{{ route('users.destroy', $id) }}" method="POST" style="display:inline"
      onsubmit="return confirm('Delete this user?')">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
</form>