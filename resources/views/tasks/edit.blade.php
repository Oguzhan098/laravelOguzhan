@extends('layouts.app')
@section('title', 'Görev Düzenle')

@section('content')
    <div class="card">
        <div class="card-header">Görev Düzenle</div>
        <div class="card-body">
            <form method="POST" action="{{ route('tasks.update', $task->id) }}">
                @csrf @method('PUT')
                <div class="form-group">
                    <label>Başlık</label>
                    <input type="text" name="title" value="{{ $task->title }}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Açıklama</label>
                    <textarea name="description" class="form-control">{{ $task->description }}</textarea>
                </div>
                <div class="form-group">
                    <label>Kullanıcı</label>
                    <select name="user_id" class="form-control" required>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $user->id == $task->user_id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <select name="category_id" class="form-control" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $category->id == $task->category_id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button class="btn btn-primary">Güncelle</button>
                <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Geri</a>
            </form>
        </div>
    </div>
@endsection
