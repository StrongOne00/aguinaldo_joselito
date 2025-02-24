<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;

class PatientsTable extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatus()
    {
        $this->resetPage();
    }

    public function delete($patientId)
    {
        $patient = User::findOrFail($patientId);
        $patient->delete();
    }

    public function restore($patientId)
    {
        $patient = User::withTrashed()->findOrFail($patientId);
        $patient->restore();
    }

    public function render()
    {
        $patients = User::where('role', 'patient')
            ->withTrashed()
            ->when($this->search, function ($query) {
                $query->where(function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->status === 'active', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->when($this->status === 'inactive', function ($query) {
                $query->whereNotNull('deleted_at');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.patients-table', [
            'patients' => $patients
        ]);
    }
} 