@extends('layouts.app')
@section('title', 'Etkinlik Düzenle')

@section('content')
    <div class="container">
        <h3>Etkinlik Düzenle</h3>

        <form action="{{ route('activity.update', $activity->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- 🔹 Kullanıcı Seçimi -->
            <div class="form-group mb-2">
                <label>Kullanıcı</label>
                <select name="user_id" class="form-control">
                    <option value="">Seçiniz</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $user->id == $activity->user_id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- 🔹 Görev Seçimi -->
            <div class="form-group mb-2">
                <label>Görev</label>
                <select name="task_id" class="form-control">
                    <option value="">Seçiniz</option>
                    @foreach($tasks as $task)
                        <option value="{{ $task->id }}" {{ $task->id == $activity->task_id ? 'selected' : '' }}>
                            {{ $task->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- 🔹 İşlem -->
            <div class="form-group mb-2">
                <label>İşlem</label>
                <input type="text" name="action" value="{{ $activity->action }}" class="form-control" required>
            </div>

            <!-- 🔹 Açıklama -->
            <div class="form-group mb-2">
                <label>Açıklama</label>
                <textarea name="description" rows="3" class="form-control">{{ $activity->description }}</textarea>
            </div>

            <!-- 🔹 Butonlar -->
            <button class="btn btn-warning">Güncelle</button>
            <a href="{{ route('activity.index') }}" class="btn btn-secondary">İptal</a>
        </form>
    </div>
@endsection
