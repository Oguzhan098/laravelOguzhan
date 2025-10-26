@extends('layouts.app')
@section('title', 'Etkinlik Düzenle')

@section('content')
    <div class="container">
        <h3>Etkinlik Düzenle</h3>
        <form action="{{ route('activity.update', $log->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group mb-2">
                <label>Kullanıcı</label>
                <select name="user_id" class="form-control">
                    <option value="">Seçiniz</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $user->id == $log->user_id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-2">
                <label>Görev</label>
                <select name="task_id" class="form-control">
                    <option value="">Seçiniz</option>
                    @foreach($tasks as $task)
                        <option value="{{ $task->id }}" {{ $task->id == $log->task_id ? 'selected' : '' }}>{{ $task->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-2">
                <label>İşlem</label>
                <input type="text" name="action" value="{{ $log->action }}" class="form-control" required>
            </div>
            <div class="form-group mb-2">
                <label>Açıklama</label>
                <textarea name="description" rows="3" class="form-control">{{ $log->description }}</textarea>
            </div>
            <button class="btn btn-warning">Güncelle</button>
            <a href="{{ route('activity.index') }}" class="btn btn-secondary">İptal</a>
        </form>
    </div>
@endsection
