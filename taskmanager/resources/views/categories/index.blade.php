@extends('layouts.app')
@section('title', 'Kategoriler')

@section('content')
    <div class="d-flex justify-content-between mb-3">
        <h3>Kategoriler</h3>
        <a href="{{ route('categories.create') }}" class="btn btn-primary">Yeni Kategori</a>
    </div>


    <!-- 🔹 Arama formu -->
    <form method="GET" action="{{ route('categories.index') }}" class="mb-3 d-flex">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control mr-2" placeholder="Kategori ara...">
        <button class="btn btn-secondary">Ara</button>
        @if(request()->has('search'))
            <a href="{{ route('categories.index') }}" class="btn btn-light ml-2">Temizle</a>
        @endif
    </form>

    <table class="table table-bordered bg-white">
        <thead>
        <tr>
            <th>#</th>
            <th>

                <a href="{{ route('categories.index', array_merge(request()->all(), [
                    'sort' => 'name',
                    'direction' => (request('sort') === 'name' && request('direction') === 'asc') ? 'desc' : 'asc'
                ])) }}">
                    Ad
                    @if(request('sort') === 'name')
                        <span>{{ request('direction') === 'asc' ? '🔼' : '🔽' }}</span>
                    @endif
                </a>
            </th>
            <th>

                <a href="{{ route('categories.index', array_merge(request()->all(), [
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
        @forelse($categories as $category)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->updated_at->format('d.m.Y H:i') }}</td>
                <td>
                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-warning">Düzenle</a>
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Bu kategoriyi silmek istiyor musun?')" class="btn btn-sm btn-danger">Sil</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="4" class="text-center">Kategori bulunamadı.</td></tr>
        @endforelse
        </tbody>
    </table>

    <!-- 🔹 Sayfalama kısmı -->
    <div class="d-flex justify-content-center mt-3">
        {{ $categories->links('pagination::bootstrap-4') }}
    </div>

@endsection
