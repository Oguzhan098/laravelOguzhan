@extends('layouts.app')

@section('title', 'Aktiviteler')

@section('content')
    <div class="d-flex justify-content-between mb-3">
        <h3>Aktivite Kayıtları</h3>
        <a href="{{ route('activity.create') }}" class="btn btn-primary">Yeni Aktivite</a>
    </div>

    <form method="GET" action="{{ route('activity.index') }}" class="mb-3 d-flex">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control mr-2" placeholder="Aksiyon, kullanıcı veya görev ara...">
        <button class="btn btn-secondary">Ara</button>
        @if(request()->has('search'))
            <a href="{{ route('activity.index') }}" class="btn btn-light ml-2">Temizle</a>
        @endif
    </form>

    <table class="table table-bordered bg-white">
        <thead>
        <tr>
            <th>Sıra Numarası</th>
            <th>
                <a href="{{ route('activity.index', array_merge(request()->all(), [
                    'sort' => 'action',
                    'direction' => (request('sort') === 'action' && request('direction') === 'asc') ? 'desc' : 'asc'
                ])) }}">
                    Aksiyon
                    @if(request('sort') === 'action')
                        <span>{{ request('direction') === 'asc' ? '🔼' : '🔽' }}</span>
                    @endif
                </a>
            </th>

            <th>Kullanıcı</th>
            <th>Görev</th>
            <th>

                <a href="{{ route('activity.index', array_merge(request()->all(), [
                    'sort' => 'updated_at',
                    'direction' => (request('sort') === 'updated_at' && request('direction') === 'asc') ? 'desc' : 'asc'
                ])) }}">
                    Güncellenme
                    @if(request('sort') === 'updated_at' || !request()->has('sort'))
                        <span>{{ request('direction', 'desc') === 'asc' ? '🔼' : '🔽' }}</span>
                    @endif
                </a>
            </th>
            <th>Açıklama</th>
            <th>İşlemler</th>
        </tr>
        </thead>

        <tbody>
        @forelse($activities as $index => $activity)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $activity->action }}</td>
                <td>{{ $activity->user ? $activity->user->name : '-' }}</td>
                <td>{{ $activity->task ? $activity->task->title : '-' }}</td>
                <td>{{ $activity->updated_at ? $activity->updated_at->format('d.m.Y H:i') : '-' }}</td>
                <td>{{ $activity->description ?? '-' }}</td>
                <td>

                    <a href="{{ route('activity.edit', $activity->id) }}" class="btn btn-sm btn-warning">Düzenle</a>
                    <form action="{{ route('activity.destroy', $activity->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Bu aktiviteyi silmek istiyor musun?')" class="btn btn-sm btn-danger">
                            Sil
                        </button>
                    </form>
                </td>

            </tr>
        @empty
            <tr><td colspan="7" class="text-center">Aktivite kaydı bulunamadı.</td></tr>
        @endforelse
        </tbody>
    </table>

    <!-- 🔹 Sayfalama kısmı -->
    <div class="d-flex justify-content-center mt-3">
        {{ $activities->links('pagination::bootstrap-4') }}
    </div>
@endsection
