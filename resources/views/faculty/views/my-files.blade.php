<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Files') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium">Uploaded Files</h3>
                    <p class="mt-2">Here you can view all your uploaded files.</p>

                    @if($uploadedFiles->isEmpty())
                        <p class="mt-4 text-gray-500">No files uploaded yet.</p>
                    @else
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b">File Name</th>
                                    <th class="py-2 px-4 border-b">Requirement</th>
                                    <th class="py-2 px-4 border-b">Uploaded Date</th>
                                    <th class="py-2 px-4 border-b">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($uploadedFiles as $file)
                                    <tr>
                                        <td class="py-2 px-4 border-b">{{ basename($file->file_path) }}</td>
                                        <td class="py-2 px-4 border-b">{{ $file->requirement->requirement ?? 'N/A' }}</td>
                                        <td class="py-2 px-4 border-b">{{ $file->created_at->format('Y-m-d H:i') }}</td>
                                        <td class="py-2 px-4 border-b">
                                            <a href="{{ Storage::url($file->file_path) }}" target="_blank" class="text-blue-500 hover:underline">View</a>
                                            <form action="{{ route('faculty.clearances.deleteSingleFile', [$file->shared_clearance_id, $file->requirement_id, $file->id]) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:underline">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>