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

        Task::create($request->only(['title', 'user_id', 'category_id']));
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
                Rule::unique('tasks')
                    ->ignore($task->id)
                    ->whereNull('deleted_at'),
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
