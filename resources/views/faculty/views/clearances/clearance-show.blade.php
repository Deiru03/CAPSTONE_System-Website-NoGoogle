<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-2xl font-bold mb-6">Clearance Checklist: {{ $userClearance->sharedClearance->clearance->document_name }}</h2>
        <p>{{ $userClearance->sharedClearance->clearance->description }}</p>
        <p>Units: {{ $userClearance->sharedClearance->clearance->units }}</p>
        <p>Type: {{ $userClearance->sharedClearance->clearance->type }}</p>

        <h3 class="text-xl font-semibold mt-6 mb-4">Requirements</h3>

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

        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-2">ID</th>
                    <th class="py-2">Requirement</th>
                    <th class="py-2">Status</th>
                    <th class="py-2">Upload</th>
                </tr>
            </thead>
            <tbody>
                @foreach($userClearance->sharedClearance->clearance->requirements as $requirement)
                <tr>
                    <td class="border px-4 py-2">{{ $requirement->id }}</td>
                    <td class="border px-4 py-2">{{ $requirement->requirement }}</td>
                    <td class="border px-4 py-2">
                        @if($userClearance->uploadedClearanceFor($requirement->id))
                            <span class="text-green-600">Completed</span>
                        @else
                            <span class="text-red-600">Pending</span>
                        @endif
                    </td>
                    <td class="border px-4 py-2">
                        @if($userClearance->uploadedClearanceFor($requirement->id))
                            <a href="{{ Storage::url($userClearance->uploadedClearanceFor($requirement->id)->file_path) }}" class="text-blue-500" target="_blank">
                                View File
                            </a>
                        @else
                            <button onclick="openUploadModal({{ $userClearance->shared_clearance_id }}, {{ $requirement->id }})" class="bg-blue-500 text-white px-3 py-1 rounded">
                                Upload
                            </button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Upload Modal -->
    <div id="uploadModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full relative">
            <h3 class="text-2xl font-semibold mb-4">Upload File for Requirement ID: <span id="uploadRequirementId"></span></h3>
            <form id="uploadForm" class="space-y-4">
                @csrf
                <input type="hidden" id="uploadUserClearanceId" name="userClearanceId">
                <input type="hidden" id="uploadRequirementIdInput" name="requirementId">
                <div>
                    <label for="uploadFile" class="block text-sm font-medium text-gray-700">Select File</label>
                    <input type="file" id="uploadFile" name="file" class="mt-1 block w-full">
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Upload</button>
                    <button type="button" onclick="closeUploadModal()" class="text-gray-500">Cancel</button>
                </div>
                <div id="uploadNotification" class="hidden bg-green-100 text-green-700 p-2 rounded mt-4"></div>
                <div id="uploadLoader" class="hidden">Uploading...</div>
            </form>
        </div>
    </div>

    <script>
        function openUploadModal(userClearanceId, requirementId) {
            document.getElementById('uploadModal').classList.remove('hidden');
            document.getElementById('uploadUserClearanceId').value = userClearanceId;
            document.getElementById('uploadRequirementId').innerText = requirementId;
            document.getElementById('uploadRequirementIdInput').value = requirementId;
        }

        // Function to close the upload modal
        function closeUploadModal() {
            document.getElementById('uploadModal').classList.add('hidden');
            document.getElementById('uploadForm').reset();
            document.getElementById('uploadNotification').classList.add('hidden');
        }

        // Handle Upload Form Submission
        document.getElementById('uploadForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const userClearanceId = document.getElementById('uploadUserClearanceId').value;
            const requirementId = document.getElementById('uploadRequirementIdInput').value;
            const fileInput = document.getElementById('uploadFile');
            const uploadNotification = document.getElementById('uploadNotification');
            const uploadLoader = document.getElementById('uploadLoader');

            if (fileInput.files.length === 0) {
                alert('Please select a file to upload.');
                return;
            }

            const formData = new FormData();
            formData.append('file', fileInput.files[0]);

            uploadLoader.classList.remove('hidden');
            uploadNotification.classList.add('hidden');

            fetch(`/faculty/clearances/${userClearanceId}/upload/${requirementId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                uploadLoader.classList.add('hidden');

                if (data.success) {
                    uploadNotification.classList.remove('hidden');
                    uploadNotification.innerText = 'File uploaded successfully.';
                    setTimeout(() => {
                        closeUploadModal();
                        location.reload();
                    }, 1500);
                } else {
                    if (data.errors) {
                        // Display validation errors
                        alert(JSON.stringify(data.errors));
                    } else {
                        alert(data.message || 'Failed to upload file.');
                    }
                }
            })
            .catch(error => {
                uploadLoader.classList.add('hidden');
                console.error('Error uploading file:', error);
                alert('An error occurred while uploading the file.');
            });
        });
    </script>
</x-app-layout>