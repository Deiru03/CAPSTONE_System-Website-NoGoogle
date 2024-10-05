<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Clearances') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900">
                    <h3 class="text-2xl font-bold mb-6 text-indigo-700 border-b-2 border-indigo-200 pb-2">Clearances Management</h3>
                    <div class="flex items-center mb-6">
                        <svg class="w-8 h-8 text-indigo-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-lg text-gray-700">Here you can view and manage your clearances efficiently.</p>
                    </div>
                    <div class="bg-indigo-50 p-6 rounded-lg shadow-inner mb-6">
                        <h4 class="text-lg font-semibold text-indigo-800 mb-3">Quick Actions</h4>
                        <a href="{{ route('faculty.clearances.index') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                            View Clearance Checklists
                        </a>
                    </div>
                </div>
            </div>            
        </div>
    </div>

    <!-- Include the clearance-show view -->
    @include('faculty.views.clearances.clearance-show', ['userClearance' => $userClearance, 'isInclude' => true])
</x-app-layout>
