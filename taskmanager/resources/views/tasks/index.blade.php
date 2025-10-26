@extends('layouts.app')
@section('title', 'Görevler')

@section('content')
    <div class="d-flex justify-content-between mb-3">
        <h3>Görevler</h3>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">Yeni Görev</a>
    </div>

    <!-- 🔹 Arama formu -->
    <form method="GET" action="{{ route('tasks.index') }}" class="mb-3 d-flex">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control mr-2" placeholder="Görev, kullanıcı veya kategori ara...">
        <button class="btn btn-secondary">Ara</button>
        @if(request()->has('search'))
            <a href="{{ route('tasks.index') }}" class="btn btn-light ml-2">Temizle</a>
        @endif
    </form>

    <table class="table table-bordered bg-white">
        <thead>
        <tr>
            <th>#</th>
            <th>
                {{-- 🔹 Başlık sütunu sıralanabilir --}}
                <a href="{{ route('tasks.index', array_merge(request()->all(), [
                    'sort' => 'title',
                    'direction' => (request('sort') === 'title' && request('direction') === 'asc') ? 'desc' : 'asc'
                ])) }}">
                    Başlık
                    @if(request('sort') === 'title')
                        <span>{{ request('direction') === 'asc' ? '🔼' : '🔽' }}</span>
                    @endif
                </a>
            </th>
            <th>
                {{-- 🔹 Kullanıcı sütunu sıralanabilir --}}
                <a href="{{ route('tasks.index', array_merge(request()->all(), [
                    'sort' => 'user_id',
                    'direction' => (request('sort') === 'user_id' && request('direction') === 'asc') ? 'desc' : 'asc'
                ])) }}">
                    Kullanıcı
                    @if(request('sort') === 'user_id')
                        <span>{{ request('direction') === 'asc' ? '🔼' : '🔽' }}</span>
                    @endif
                </a>
            </th>
            <th>
                {{-- 🔹 Kategori sütunu sıralanabilir --}}
                <a href="{{ route('tasks.index', array_merge(request()->all(), [
                    'sort' => 'category_id',
                    'direction' => (request('sort') === 'category_id' && request('direction') === 'asc') ? 'desc' : 'asc'
                ])) }}">
                    Kategori
                    @if(request('sort') === 'category_id')
                        <span>{{ request('direction') === 'asc' ? '🔼' : '🔽' }}</span>
                    @endif
                </a>
            </th>
            <th>
                {{-- 🔹 Güncellenme sütunu sıralanabilir --}}
                <a href="{{ route('tasks.index', array_merge(request()->all(), [
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
        @forelse($tasks as $index => $task)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $task->title }}</td>
                <td>{{ $task->user ? $task->user->name : '-' }}</td>
                <td>{{ $task->category ? $task->category->name : '-' }}</td>
                <td>{{ $task->updated_at->format('d.m.Y H:i') }}</td>
                <td>
                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-warning">Düzenle</a>
                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Silmek istiyor musun?')" class="btn btn-sm btn-danger">Sil</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center">Görev bulunamadı.</td></tr>
        @endforelse
        </tbody>
    </table>

    <!-- 🔹 Sayfalama kısmı -->
    <div class="d-flex justify-content-center mt-3">
        {{ $tasks->links('pagination::bootstrap-4') }}
    </div>

@endsection
