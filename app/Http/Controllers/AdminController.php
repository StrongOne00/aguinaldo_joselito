<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{
    public function index()
    {
        $patients = User::where('role', 'patient')
            ->withTrashed()
            ->latest()
            ->paginate(10);
            
        return view('admin.patients.index', compact('patients'));
    }

    public function create()
    {
        return view('admin.patients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'date_of_birth' => ['required', 'date'],
            'phone' => ['required', 'string'],
            'address' => ['required', 'string'],
            'medical_history' => ['nullable', 'string'],
            'emergency_contact' => ['required', 'string'],
        ]);

        $validated['role'] = 'patient';
        $user = User::create($validated);

        return redirect()->route('admin.patients.index')
            ->with('success', 'Patient registered successfully.');
    }

    public function edit(User $patient)
    {
        return view('admin.patients.edit', compact('patient'));
    }

    public function update(Request $request, User $patient)
    {
        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $patient->id],
                'date_of_birth' => ['required', 'date'],
                'phone' => ['required', 'string'],
                'address' => ['required', 'string'],
                'medical_history' => ['nullable', 'string'],
                'emergency_contact' => ['required', 'string'],
            ]);

            $patient->fill($validated);
            $patient->save();

            return redirect()
                ->route('admin.patients.index')
                ->with('success', 'Patient information updated successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'There was an error updating the patient information: ' . $e->getMessage());
        }
    }

    public function destroy(User $patient)
    {
        $patient->delete();
        return redirect()->route('admin.patients.index')
            ->with('success', 'Patient deleted successfully.');
    }

    public function restore($id)
    {
        $patient = User::withTrashed()->findOrFail($id);
        $patient->restore();
        return redirect()->route('admin.patients.index')
            ->with('success', 'Patient restored successfully.');
    }

    public function search(Request $request)
    {
        $query = User::where('role', 'patient')->withTrashed();

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%")
                  ->orWhere('phone', 'like', "%{$request->search}%");
            });
        }

        if ($request->status) {
            if ($request->status === 'active') {
                $query->whereNull('deleted_at');
            } elseif ($request->status === 'inactive') {
                $query->whereNotNull('deleted_at');
            }
        }

        $patients = $query->latest()->paginate(10);
        return view('admin.patients.index', compact('patients'));
    }
} 