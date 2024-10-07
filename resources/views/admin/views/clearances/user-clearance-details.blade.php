<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Clearance Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-2xl font-semibold mb-4">{{ $userClearance->sharedClearance->clearance->document_name }}</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="py-2 px-3 text-left">Requirement</th>
                                    <th class="py-2 px-3 text-left">Status</th>
                                    <th class="py-2 px-3 text-left">Uploaded Files</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($userClearance->sharedClearance->clearance->requirements as $requirement)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $requirement->requirement }}</td>
                                        <td class="border px-4 py-2">
                                            @if($userClearance->uploadedClearanceFor($requirement->id))
                                                <span class="text-green-500">Uploaded</span>
                                            @else
                                                <span class="text-red-500">Pending</span>
                                            @endif
                                        </td>
                                        <td class="border px-4 py-2">
                                            @foreach($userClearance->uploadedClearances as $uploaded)
                                                @if($uploaded->requirement_id == $requirement->id)
                                                    <a href="{{ asset('storage/' . $uploaded->file_path) }}" target="_blank" class="text-blue-500 hover:underline">
                                                        {{ basename($uploaded->file_path) }}
                                                    </a><br>
                                                @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>