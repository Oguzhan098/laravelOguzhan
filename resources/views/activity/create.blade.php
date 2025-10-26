@extends('layouts.app')
@section('title', 'Yeni Etkinlik')

@section('content')
    <div class="container">
        <h3>Yeni Etkinlik Ekle</h3>
        <form action="{{ route('activity.store') }}" method="POST">
            @csrf
            <div class="form-group mb-2">
                <label>Kullanıcı</label>
                <select name="user_id" class="form-control">
                    <option value="">Seçiniz</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-2">
                <label>Görev</label>
                <select name="task_id" class="form-control">
                    <option value="">Seçiniz</option>
                    @foreach($tasks as $task)
                        <option value="{{ $task->id }}">{{ $task->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-2">
                <label>İşlem</label>
                <input type="text" name="action" class="form-control" required>
            </div>
            <div class="form-group mb-2">
                <label>Açıklama</label>
                <textarea name="description" rows="3" class="form-control"></textarea>
            </div>
            <button class="btn btn-success">Kaydet</button>
            <a href="{{ route('activity.index') }}" class="btn btn-secondary">İptal</a>
        </form>
    </div>
@endsection
