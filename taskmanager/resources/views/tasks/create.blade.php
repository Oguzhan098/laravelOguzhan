@extends('layouts.app')
@section('title', 'Yeni Görev')

@section('content')
    <div class="card">
        <div class="card-header">Yeni Görev Ekle</div>
        <div class="card-body">
            <form method="POST" action="{{ route('tasks.store') }}">
                @csrf
                <div class="form-group">
                    <label>Başlık</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Açıklama</label>
                    <textarea name="description" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label>Kullanıcı Seç</label>
                    <select name="user_id" class="form-control" required>
                        <option value="">Seçiniz</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Kategori Seç</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">Seçiniz</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="btn btn-success">Kaydet</button>
                <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Geri</a>
            </form>
        </div>
    </div>
@endsection
