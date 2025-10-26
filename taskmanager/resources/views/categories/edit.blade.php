@extends('layouts.app')
@section('title', 'Kategori Düzenle')

@section('content')
    <div class="card">
        <div class="card-header">Kategori Düzenle</div>
        <div class="card-body">
            <form method="POST" action="{{ route('categories.update', $category->id) }}">
                @csrf @method('PUT')
                <div class="form-group">
                    <label>Kategori Adı</label>
                    <input type="text" name="name" value="{{ $category->name }}" class="form-control" required>
                </div>
                <button class="btn btn-primary">Güncelle</button>
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">Geri</a>
            </form>
        </div>
    </div>
@endsection
