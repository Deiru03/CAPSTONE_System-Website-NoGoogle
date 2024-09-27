<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Clearances') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium">Clearances</h3>
                    <p class="mt-2">Here you can view and manage clearances.</p>
                    <!-- Navigation Button -->
                    <a href="{{ route('faculty.clearances.index') }}" class="mt-4 inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        View Clearance Checklists
                    </a>
                </div>
            </div>            
        </div>
    </div>
</x-app-layout>