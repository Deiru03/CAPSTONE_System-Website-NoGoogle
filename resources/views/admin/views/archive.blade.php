<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Archive') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">  
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium">Archive</h3>
                    <p class="mt-2">Here you can view and manage archived files.</p>
                    <!-- Add your Archive management content here -->
                </div>
            </div>            
        </div>
    </div>
</x-admin-layout>