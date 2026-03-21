<form action="{{ route('users.updateRole', $row->id) }}" method="POST" style="display:flex;gap:0.4rem;align-items:center;">
    @csrf
    @method('PATCH')
    <select name="role" class="form-select form-select-sm"
        style="background:#0d0b1c;border:1px solid rgba(168,155,194,0.15);color:#d4cfe0;font-size:0.65rem;padding:0.25rem 0.5rem;border-radius:0;">
        <option value="customer" {{ $row->role === 'customer' ? 'selected' : '' }}>Customer</option>
        <option value="admin"    {{ $row->role === 'admin'    ? 'selected' : '' }}>Admin</option>
    </select>
    <button type="submit"
        style="background:transparent;border:1px solid rgba(201,168,76,0.3);color:#c9a84c;font-family:'Montserrat',sans-serif;font-size:0.55rem;letter-spacing:0.1em;text-transform:uppercase;padding:0.28rem 0.65rem;cursor:pointer;transition:all 0.2s;"
        onmouseover="this.style.background='rgba(201,168,76,0.08)'"
        onmouseout="this.style.background='transparent'">
        Update
    </button>
</form>