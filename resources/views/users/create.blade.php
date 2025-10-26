@extends('layouts.app')
@section('title', 'Yeni Kullanıcı')

@section('content')
    <div class="card">
        <div class="card-header">Yeni Kullanıcı Ekle</div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('users.store') }}">
                @csrf
                <div class="form-group">
                    <label>Ad Soyad</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>E-posta</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Şifre</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button class="btn btn-success">Kaydet</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Geri</a>
            </form>
        </div>
    </div>
@endsection
