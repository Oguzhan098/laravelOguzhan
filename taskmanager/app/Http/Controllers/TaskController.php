<?php

namespace App\Http\Controllers;

use App\ActivityLog;
use App\Task;
use App\User;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::with(['user', 'category'])
            ->whereNull('deleted_at')
            ->filter($request);

        if (!$request->has('sort')) {
            $query->orderBy('updated_at', 'desc');
        }

        $tasks = $query->paginate(10)->withQueryString();


        return view('tasks.index', compact('tasks'));
    }



    public function create()
    {
        $users = User::all();
        $categories = Category::all();
        return view('tasks.create', compact('users', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tasks')->whereNull('deleted_at'),
            ],
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
        ], [
            'title.required' => 'Görev başlığı zorunludur.',
            'title.unique' => 'Bu görev zaten mevcut.',
        ]);

        // 🟢 Görevi oluştur
        $task = Task::create($request->all());

        // 🟢 İşlem logunu ekle (sisteme etki etmeden sadece kayıt tutar)
        ActivityLog::create([
            'user_id'     => auth()->id(), // Giriş yapan kullanıcı kimse
            'action'      => 'task_created',
            'description' => 'Yeni görev oluşturuldu: ' . $task->title,
        ]);

        Task::create($request->all());
        return redirect()->route('tasks.index')->with('success', 'Görev oluşturuldu.');
    }

    public function edit(Task $task)
    {
        $users = User::all();
        $categories = Category::all();
        return view('tasks.edit', compact('task', 'users', 'categories'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tasks')->ignore($task->id)->whereNull('deleted_at'),
            ],
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
        ], [
            'title.unique' => 'Bu görev başlığı zaten mevcut.',
        ]);

        $task->update($request->all());
        return redirect()->route('tasks.index')->with('success', 'Görev güncellendi.');
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Görev silindi.');
    }
}
