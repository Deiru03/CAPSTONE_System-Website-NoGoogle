<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Clearances Checklist') }}
        </h2>
    </x-slot>
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-2xl font-bold mb-6">Shared Clearances</h2>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if($sharedClearances->isEmpty())
            <p>No clearances have been shared with you yet.</p>
        @else
            @php
                // Convert userClearances array to a collection
                $userClearancesCollection = collect($userClearances);
                // Check if the user already has any copy
                $hasAnyCopy = $userClearancesCollection->isNotEmpty();
            @endphp
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2">ID</th>
                        <th class="py-2">Document Name</th>
                        <th class="py-2">Description</th>
                        <th class="py-2">Units</th>
                        <th class="py-2">Type</th>
                        <th class="py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sharedClearances as $sharedClearance)
                    <tr>
                        <td class="border px-4 py-2">{{ $sharedClearance->clearance->id }}</td>
                        <td class="border px-4 py-2">{{ $sharedClearance->clearance->document_name }}</td>
                        <td class="border px-4 py-2">{{ Str::limit($sharedClearance->clearance->description, 50) }}</td>
                        <td class="border px-4 py-2">{{ $sharedClearance->clearance->units }}</td>
                        <td class="border px-4 py-2">{{ $sharedClearance->clearance->type }}</td>
                        <td class="border px-4 py-2">
                            <div class="flex justify-center space-x-2">
                                @if(isset($userClearances[$sharedClearance->id]))
                                    <a href="{{ route('faculty.clearances.show', $userClearances[$sharedClearance->id]) }}" 
                                       class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 text-sm rounded-md transition duration-300 ease-in-out flex items-center"
                                       onclick="event.preventDefault(); window.location.href='{{ route('faculty.views.clearances', $userClearances[$sharedClearance->id]) }}';">
                                        View
                                    </a>
                                    <button onclick="openModal('{{ $sharedClearance->id }}')" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 text-sm rounded-md transition duration-300 ease-in-out flex items-center">
                                        Remove
                                    </button>
                                @else
                                    @if(!$hasAnyCopy)
                                        <form action="{{ route('faculty.clearances.getCopy', $sharedClearance->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 text-sm rounded-md transition duration-300 ease-in-out flex items-center">
                                                Get Copy
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmationModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg p-6 w-1/3">
            <h3 class="text-lg font-semibold mb-4">Confirm Removal</h3>
            <p>Are you sure you want to remove this clearance?</p>
            <div class="flex justify-end mt-4">
                <button id="cancelButton" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded-md mr-2" onclick="closeModal()">Cancel</button>
                <form id="removeForm" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md">Remove</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        let currentClearanceId = null;

        function openModal(clearanceId) {
            currentClearanceId = clearanceId;
            document.getElementById('confirmationModal').classList.remove('hidden');
            document.getElementById('removeForm').action = `/faculty/clearances/remove-copy/${clearanceId}`; // Update the form action
        }

        function closeModal() {
            document.getElementById('confirmationModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
