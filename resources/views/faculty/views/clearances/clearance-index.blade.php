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
                        <td class="border px-4 py-2 flex justify-center">
                            @if(array_key_exists($sharedClearance->id, $userClearances))
                                <a href="{{ route('faculty.clearances.show', $userClearances[$sharedClearance->id]) }}" class="bg-blue-500 text-white px-3 py-1 rounded">
                                    View
                                </a>
                            @else
                                <form action="{{ route('faculty.clearances.getCopy', $sharedClearance->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded">
                                        Get a Copy
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-app-layout>