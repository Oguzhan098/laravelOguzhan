@extends('layouts.app')
@section('title', 'Yeni Kategori')

@section('content')
    <div class="card">
        <div class="card-header">Yeni Kategori Ekle</div>
        <div class="card-body">
            <form method="POST" action="{{ route('categories.store') }}">
                @csrf
                <div class="form-group">
                    <label>Kategori Adı</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <button class="btn btn-success">Kaydet</button>
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">Geri</a>
            </form>
        </div>
    </div>
@endsection
