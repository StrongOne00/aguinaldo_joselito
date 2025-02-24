<div>
    <div class="flex justify-between mb-6">
        <div class="flex gap-4">
            <x-text-input 
                wire:model.live="search" 
                type="text" 
                placeholder="Search patients..." 
            />
            <select 
                wire:model.live="status" 
                class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-md border-gray-300 dark:border-gray-700"
            >
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
        
        <a href="{{ route('admin.patients.create') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
            Add New Patient
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Phone</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach ($patients as $patient)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $patient->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $patient->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $patient->phone }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($patient->deleted_at)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Inactive
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Active
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm space-x-3">
                            <a href="{{ route('admin.patients.edit', $patient) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            @if ($patient->deleted_at)
                                <button wire:click="restore({{ $patient->id }})" class="text-green-600 hover:text-green-900">
                                    Restore
                                </button>
                            @else
                                <button wire:click="delete({{ $patient->id }})" class="text-red-600 hover:text-red-900">
                                    Delete
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="mt-4">
            {{ $patients->links() }}
        </div>
    </div>
</div> 