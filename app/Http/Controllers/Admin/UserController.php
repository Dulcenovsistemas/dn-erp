<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Zona;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function index()
    {
        $usuarios = User::with('roles')
            ->orderBy('name')
            ->get();

        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $roles = Role::orderBy('name')->get();

        $zonas = Zona::where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view('admin.usuarios.create', compact(
            'roles',
            'zonas'
        ));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role' => 'required|exists:roles,name',
            'zonas' => 'nullable|array',
            'zonas.*' => 'exists:zonas,id',
        ]);

        $data['password'] = bcrypt($data['password']);
        $data['activo'] = $request->has('activo');

        // ⛔ Quitamos campos que no pertenecen a users
        unset($data['role'], $data['zonas']);

        $user = User::create($data);

        // Rol
        $user->assignRole($request->role);

        // Zonas
        $user->zonas()->sync(
            $request->input('zonas', [])
        );

    

        return redirect()
            ->route('admin.usuarios.index')
            ->with('success', 'Usuario creado correctamente');
    }


    public function edit(User $usuario)
    {
        $roles = Role::orderBy('name')->get();

        $zonas = Zona::where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view('admin.usuarios.edit', compact(
            'usuario',
            'roles',
            'zonas'
        ));
    }

    public function update(Request $request, User $usuario)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
            'password' => 'nullable|min:8',
            'role' => 'required|exists:roles,name',
            'zonas' => 'nullable|array',
            'zonas.*' => 'exists:zonas,id',

        ]);

        // Password opcional
        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $data['activo'] = $request->has('activo');

        // ⛔ Quitamos campos que no pertenecen a users
        unset($data['role'], $data['zonas']);

        $usuario->update($data);

        // Rol
        $usuario->syncRoles([$request->role]);

        // Sucursales (sync siempre, aunque venga vacío)
        $usuario->zonas()->sync(
            $request->input('zonas', [])
        );

        return redirect()
            ->route('admin.usuarios.index')
            ->with('success', 'Usuario actualizado correctamente');
    }


    public function destroy(User $usuario)
    {
        if (Auth::check() && Auth::id() === $usuario->id) {
            return redirect()->route('admin.usuarios.index')
                ->with('error', 'No puedes desactivar tu propio usuario');
        }

        $usuario->update([
            'activo' => false,
        ]);

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario desactivado correctamente');
    }




}
