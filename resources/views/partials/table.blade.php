@forelse ($users as $user)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td class="fw-medium">{{ $user->name }}</td>
    <td class="text-muted">{{ $user->email }}</td>
    <td class="text-center">
        <span class="badge rounded-pill
            {{ $user->role === 'admin'
                ? 'bg-primary-subtle text-primary'
                : 'bg-secondary-subtle text-secondary' }}">
            {{ ucfirst($user->role) }}
        </span>
    </td>
    <td class="text-center">

        @if(auth()->user()->role === 'admin')
            <a href="{{ route('users.edit', $user->id) }}"
               class="btn btn-outline-primary btn-sm">
                <i class="bi bi-pencil"></i>
            </a>
        @endif

        @if(
            auth()->user()->role === 'admin' &&
            auth()->id() !== $user->id &&
            !($user->role === 'admin' && \App\Models\User::where('role','admin')->count() <= 1)
        )
            <form action="{{ route('users.destroy', $user->id) }}"
                  method="POST"
                  class="d-inline"
                  onsubmit="return confirm('Yakin hapus user ini?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-outline-danger btn-sm">
                    <i class="bi bi-trash"></i>
                </button>
            </form>
        @endif

    </td>
</tr>
@empty
<tr>
    <td colspan="5" class="text-center text-muted py-4">
        Data tidak ditemukan
    </td>
</tr>
@endforelse
