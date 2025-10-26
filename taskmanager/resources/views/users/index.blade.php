@extends('layouts.app')
@section('title', 'Kullanıcılar')

@section('content')
    <div class="d-flex justify-content-between mb-3">
        <h3>Kullanıcılar</h3>
        <a href="{{ route('users.create') }}" class="btn btn-primary">Yeni Kullanıcı</a>
    </div>

    <!-- 🔹 Filtre / Arama formu -->
    <form method="GET" action="{{ route('users.index') }}" class="mb-3 d-flex">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control mr-2" placeholder="Kullanıcı ara...">
        <button class="btn btn-secondary">Ara</button>
        @if(request()->has('search'))
            <a href="{{ route('users.index') }}" class="btn btn-light ml-2">Temizle</a>
        @endif
    </form>

    <table class="table table-bordered bg-white">
        <thead>
        <tr>
            <th>#</th>
            <th>
                {{-- 🔹 Ad Soyad sütunu sıralanabilir --}}
                <a href="{{ route('users.index', array_merge(request()->all(), [
                    'sort' => 'name',
                    'direction' => (request('sort') === 'name' && request('direction') === 'asc') ? 'desc' : 'asc'
                ])) }}">
                    Ad Soyad
                    @if(request('sort') === 'name')
                        <span>{{ request('direction') === 'asc' ? '🔼' : '🔽' }}</span>
                    @endif
                </a>
            </th>
            <th>
                {{-- 🔹 Email sütunu sıralanabilir --}}
                <a href="{{ route('users.index', array_merge(request()->all(), [
                    'sort' => 'email',
                    'direction' => (request('sort') === 'email' && request('direction') === 'asc') ? 'desc' : 'asc'
                ])) }}">
                    E-Posta
                    @if(request('sort') === 'email')
                        <span>{{ request('direction') === 'asc' ? '🔼' : '🔽' }}</span>
                    @endif
                </a>
            </th>
            <th>
                {{-- 🔹 Güncellenme Tarihi sütunu sıralanabilir --}}
                <a href="{{ route('users.index', array_merge(request()->all(), [
                    'sort' => 'updated_at',
                    'direction' => (request('sort') === 'updated_at' && request('direction') === 'asc') ? 'desc' : 'asc'
                ])) }}">
                    Güncellenme
                    @if(request('sort') === 'updated_at' || !request()->has('sort'))
                        <span>{{ request('direction', 'desc') === 'asc' ? '🔼' : '🔽' }}</span>
                    @endif
                </a>
            </th>
            <th>İşlemler</th>
        </tr>
        </thead>
        <tbody>
        @forelse($users as $index => $user)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->updated_at->format('d.m.Y H:i') }}</td>
                <td>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">Düzenle</a>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Silmek istiyor musun?')" class="btn btn-sm btn-danger">Sil</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center">Kayıt bulunamadı.</td></tr>
        @endforelse
        </tbody>
    </table>

    <!-- 🔹 Sayfalama kısmı -->
    <div class="d-flex justify-content-center mt-3">
        {{ $users->links('pagination::bootstrap-4') }}
    </div>
@endsection
