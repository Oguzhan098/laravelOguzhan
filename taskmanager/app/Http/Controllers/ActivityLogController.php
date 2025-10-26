<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\ActivityLog;
use App\User;
use App\Task;

class ActivityLogController extends Controller
{
    /**
     * 🔹 Log kayıtlarını listele (arama + sayfalama)
     */
    public function index(Request $request)
    {
        $query = ActivityLog::query()
            ->whereNull('deleted_at')
            ->filter($request); // kendi filter scope’un varsa burada çalışır

        // 🔹 Varsayılan sıralama (sort parametresi yoksa)
        if (!$request->has('sort')) {
            $query->orderBy('updated_at', 'desc');
        }

        // 🔹 Sayfalama: her sayfada 10 kayıt, mevcut query stringleri koru
        $activity = $query->paginate(10)->withQueryString();

        return view('activity.index', compact('activity'));
    }

    /**
     * 🔹 Yeni etkinlik formu
     */
    public function create()
    {
        $users = User::all();
        $tasks = Task::all();
        return view('activity.create', compact('users', 'tasks'));
    }

    /**
     * 🔹 Yeni etkinlik kaydı oluştur
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'task_id' => 'nullable|exists:tasks,id',
            'action' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        ActivityLog::create([
            'user_id' => $request->user_id ?? auth()->id(),
            'task_id' => $request->task_id,
            'action' => $request->action,
            'description' => $request->description,
        ]);

        return redirect()->route('activity.index')->with('success', 'Etkinlik başarıyla oluşturuldu.');
    }

    /**
     * 🔹 Etkinlik düzenleme formu
     */
    public function edit($id)
    {
        $log = ActivityLog::findOrFail($id);
        $users = User::all();
        $tasks = Task::all();
        return view('activity.edit', compact('log', 'users', 'tasks'));
    }

    /**
     * 🔹 Etkinlik güncelle
     */
    public function update(Request $request, $id)
    {
        $log = ActivityLog::findOrFail($id);

        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'task_id' => 'nullable|exists:tasks,id',
            'action' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $log->update([
            'user_id' => $request->user_id,
            'task_id' => $request->task_id,
            'action' => $request->action,
            'description' => $request->description,
        ]);

        return redirect()->route('activity.index')->with('success', 'Etkinlik başarıyla güncellendi.');
    }

    /**
     * 🔹 Etkinliği soft delete ile sil
     */
    public function destroy($id)
    {
        $log = ActivityLog::findOrFail($id);
        $log->delete(); // Soft delete (deleted_at dolar)
        return redirect()->route('activity.index')->with('success', 'Etkinlik başarıyla silindi.');
    }

    /**
     * 🔹 Silinmiş etkinlikleri listele
     */
    public function deleted()
    {
        $logs = ActivityLog::onlyTrashed()->with(['user', 'task'])->latest()->paginate(10);
        return view('activity.deleted', compact('logs'));
    }

    /**
     * 🔹 Silinmiş etkinliği geri getir
     */
    public function restore($id)
    {
        $log = ActivityLog::onlyTrashed()->findOrFail($id);
        $log->restore();
        return redirect()->route('activity.deleted')->with('success', 'Etkinlik geri getirildi.');
    }

    /**
     * 🔹 Tek bir log kaydını görüntüle (detay sayfası)
     */
    public function show($id)
    {
        $log = ActivityLog::with(['user', 'task'])->findOrFail($id);
        return view('activity.show', compact('log'));
    }
}
