@extends('layouts.app')
@section('title', 'Kullanıcı Düzenle')

@section('content')
    <div class="card">
        <div class="card-header">Kullanıcı Düzenle</div>
        <div class="card-body">
            <form method="POST" action="{{ route('users.update', $user->id) }}">
                @csrf @method('PUT')
                <div class="form-group">
                    <label>Ad Soyad</label>
                    <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>E-posta</label>
                    <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
                </div>
                <button class="btn btn-primary">Güncelle</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Geri</a>
            </form>
        </div>
    </div>
@endsection
