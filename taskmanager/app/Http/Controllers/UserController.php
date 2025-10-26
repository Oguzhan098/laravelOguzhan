<?php

namespace App\Http\Controllers;

use App\Rules\ValidEmailDomain;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()->whereNull('deleted_at');

        // 🔹 Filtre uygula (eğer varsa)
        $query = $query->filter($request);

        // 🔹 Eğer sort parametresi yoksa varsayılan sıralama uygula
        if (!$request->has('sort')) {
            $query->orderBy('updated_at', 'desc');
        }

        $users = $query->paginate(10)->withQueryString();

        return view('users.index', compact('users'));
    }
    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->whereNull('deleted_at'),
                new ValidEmailDomain,
            ],
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'Kullanıcı eklendi.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($request->only('name', 'email'));
        return redirect()->route('users.index')->with('success', 'Kullanıcı güncellendi.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->tasks()->exists() || $user->ActivityLogs()->exists()) {
            return redirect()->route('users.index')
                ->with('error', 'Bu kullanıcıya ait görevler bulunduğu için silinemez. Önce görevleri silmelisiniz.');
        }

        $user->delete(); // soft delete
        return redirect()->route('users.index')->with('success', 'Kullanıcı silindi.');
    }
}
