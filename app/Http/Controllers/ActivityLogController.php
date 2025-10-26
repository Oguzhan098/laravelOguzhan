<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\ActivityLog;
use App\User;
use App\Task;
use Illuminate\Validation\Rule;

class ActivityLogController extends Controller
{

    public function index(Request $request)
    {
        $query = ActivityLog::with(['user', 'task'])
            ->whereNull('deleted_at')
            ->filter($request); // kendi filter scope’un varsa burada çalışır


        if (!$request->has('sort')) {
            $query->orderBy('updated_at', 'desc');
        }

        $activities = $query->paginate(10)->withQueryString();

        return view('activity.index', compact('activities'));
    }


    public function create()
    {
        $users = User::all();
        $tasks = Task::all();
        return view('activity.create', compact('users', 'tasks'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'task_id' => 'required|exists:tasks,id',
            'action' => [
                'required',
                'string',
                'max:255',
                Rule::unique('activity_logs')->whereNull('deleted_at'),
            ],
        ], [
            'user_id.required' => 'Kullanıcı seçimi zorunludur.',
            'user_id.exists' => 'Geçersiz kullanıcı seçildi.',
            'task_id.required' => 'Görev seçimi zorunludur.',
            'task_id.exists' => 'Geçersiz görev seçildi.',
            'action.required' => 'Aksiyon adı zorunludur.',
            'action.unique' => 'Bu aksiyon zaten mevcut.',
        ]);


        ActivityLog::create($request->all());
        return redirect()->route('activity.index')->with('success', 'Aktivite başarıyla kaydedildi.');
    }


    public function edit(ActivityLog $activity)
    {
        $users = User::all();
        $tasks = Task::all();
        return view('activity.edit', compact('activity', 'users', 'tasks'));
    }

    public function update(Request $request, ActivityLog $activity)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'task_id' => 'required|exists:tasks,id',
            'action' => [
                'required',
                'string',
                'max:255',
                Rule::unique('activity_logs')
                    ->ignore($activity->id)
                    ->whereNull('deleted_at'),
            ],
            'description' => 'nullable|string|max:500',
        ], [
            'action.unique' => 'Bu aksiyon zaten mevcut.',
            'user_id.required' => 'Kullanıcı seçimi zorunludur.',
            'task_id.required' => 'Görev seçimi zorunludur.',
        ]);

        $activity->update($request->all());

        return redirect()->route('activity.index')->with('success', 'Aktivite başarıyla güncellendi.');
    }


    public function destroy($id)
    {
        $log = ActivityLog::findOrFail($id);
        $log->delete(); // Soft delete (deleted_at dolar)
        return redirect()->route('activity.index')->with('success', 'Etkinlik başarıyla silindi.');
    }

}
