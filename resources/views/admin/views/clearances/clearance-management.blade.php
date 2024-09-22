{{-- resources/views/admin/views/clearance.blade.php --}}
<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Clearance Management') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 shadow-lg border border-gray-300">
        <div class="p-6 text-gray-900">
            <h2 class="text-2xl font-bold mb-4">Manage Clearance Checklists</h2>
            <p>Here you can create and manage clearance checklists.</p>
            <!-- Add Button -->
            <button onclick="openAddModal()" class="mt-4 bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                Add Clearance Checklist
            </button>
        </div>

        <!-- Clearance Table -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 max-w-full">
            <div class="table-container overflow-x-auto" style="max-height: 490px; max-width: 1200px;">
                <table class="min-w-full text-sm border-collapse border border-gray-300">
                    <thead class="bg-gray-200 sticky top-0">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border-b border-gray-300">ID</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border-b border-gray-300">Document Name</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border-b border-gray-300">Description</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border-b border-gray-300">Units</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border-b border-gray-300">Type</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border-b border-gray-300"># of Req.</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border-b border-gray-300">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($clearances as $clearance)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-4 whitespace-nowrap border-b border-gray-200">{{ $clearance->id }}</td>
                            <td class="px-4 py-4 whitespace-nowrap border-b border-gray-200">{{ $clearance->document_name }}</td>
                            <td class="px-4 py-4 border-b border-gray-200">
                                <div class="max-w-xs overflow-hidden overflow-ellipsis">
                                    {{ $clearance->description }}
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap border-b border-gray-200">{{ $clearance->units }}</td>
                            <td class="px-4 py-4 whitespace-nowrap border-b border-gray-200">{{ $clearance->type }}</td>
                            <td class="px-4 py-4 whitespace-nowrap border-b border-gray-200">{{ $clearance->number_of_requirements }}</td>
                            <td class="px-4 py-4 whitespace-nowrap border-b border-gray-200">
                                <div class="flex items-center space-x-2">
                                    <button onclick="openEditModal({{ $clearance->id }})" class="text-blue-600 hover:text-blue-800 flex items-center text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                        Edit
                                    </button>
                                    <button 
                                        onclick="openDeleteModal({{ $clearance->id }}, '{{ addslashes($clearance->document_name) }}')" 
                                        class="text-red-600 hover:text-red-800 flex items-center text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H3a1 1 0 000 2h1v10a2 2 0 002 2h8a2 2 0 002-2V6h1a1 1 0 100-2h-2V3a1 1 0 00-1-1H6zm3 4a1 1 0 112 0v8a1 1 0 11-2 0V6z" clip-rule="evenodd" />
                                        </svg>
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>     
        </div>
    </div>

    <!-- Add Modal -->
    <div id="addModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full relative">
            <h3 class="text-2xl font-semibold mb-4 text-gray-800">Add Clearance Checklist</h3>
            <form id="addForm" method="POST" action="{{ route('admin.clearance.store') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="addDocumentName" class="block text-sm font-medium text-gray-700">Document Name</label>
                        <input type="text" name="document_name" id="addDocumentName" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>
                    <div>
                        <label for="addDescription" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="addDescription" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                    </div>
                    <div>
                        <label for="addUnits" class="block text-sm font-medium text-gray-700">Units</label>
                        <input type="number" name="units" id="addUnits" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label for="addType" class="block text-sm font-medium text-gray-700">Type</label>
                        <select name="type" id="addType" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="" disabled selected>Select Type</option>
                            <option value="Permanent">Permanent</option>
                            <option value="Part-Timer">Part-Timer</option>
                            <option value="Temporary">Temporary</option>
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeAddModal()" class="px-4 py-2 border border-gray-300 rounded-md">Cancel</button>
                    <button type="submit" class="px-4 py-2 border border-transparent rounded-md bg-green-600 text-white">Add</button>
                </div>
            </form>
            <div id="addNotification" class="hidden mt-2 text-green-600"></div>
            
            <!-- Loader for Add Modal -->
            <div id="addLoader" class="hidden absolute inset-0 flex items-center justify-center bg-white bg-opacity-75">
                <div class="loader"></div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full relative">
            <h3 class="text-2xl font-semibold mb-4 text-gray-800">Edit Clearance Checklist</h3>
            <form id="editForm" method="POST" action="">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="editDocumentName" class="block text-sm font-medium text-gray-700">Document Name</label>
                        <input type="text" name="document_name" id="editDocumentName" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>
                    <div>
                        <label for="editDescription" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="editDescription" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                    </div>
                    <div>
                        <label for="editUnits" class="block text-sm font-medium text-gray-700">Units</label>
                        <input type="number" name="units" id="editUnits" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label for="editType" class="block text-sm font-medium text-gray-700">Type</label>
                        <select name="type" id="editType" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="" disabled>Select Type</option>
                            <option value="Permanent">Permanent</option>
                            <option value="Part-Timer">Part-Timer</option>
                            <option value="Temporary">Temporary</option>
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 border border-gray-300 rounded-md">Cancel</button>
                    <button type="submit" class="px-4 py-2 border border-transparent rounded-md bg-blue-600 text-white">Save</button>
                </div>
            </form>
            <div id="editNotification" class="hidden mt-2 text-blue-600"></div>
            
            <!-- Loader for Edit Modal -->
            <div id="editLoader" class="hidden absolute inset-0 flex items-center justify-center bg-white bg-opacity-75">
                <div class="loader"></div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full relative">
            <h3 class="text-2xl font-semibold mb-4 text-gray-800">Confirm Deletion</h3>
            <p class="mb-6">Are you sure you want to delete <span id="clearanceName" class="font-bold"></span>?</p>
            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 border border-gray-300 rounded-md">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md">Delete</button>
                </div>
            </form>
            <div id="deleteNotification" class="hidden mt-2 text-red-600 bg-red-100 p-2 rounded">
                <!-- Notification message will appear here -->
            </div>
            
            <!-- Loader for Delete Modal -->
            <div id="deleteLoader" class="hidden absolute inset-0 flex items-center justify-center bg-white bg-opacity-75">
                <div class="loader"></div>
            </div>
        </div>
    </div>

    <!-- Loader CSS (Add to your main CSS if not already present) -->
    <style>
        .loader {
            border: 6px solid #f3f3f3;
            border-top: 6px solid #3498db;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>

    <!-- Scripts -->
    <script>
        // Add Modal Functions
        function openAddModal() {
            document.getElementById('addModal').classList.remove('hidden');
        }

        function closeAddModal() {
            document.getElementById('addModal').classList.add('hidden');
            document.getElementById('addForm').reset();
            document.getElementById('addNotification').classList.add('hidden');
        }

        document.getElementById('addForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const addLoader = document.getElementById('addLoader');
            const addNotification = document.getElementById('addNotification');
            addLoader.classList.remove('hidden');

            const formData = {
                document_name: document.getElementById('addDocumentName').value,
                description: document.getElementById('addDescription').value,
                units: document.getElementById('addUnits').value,
                type: document.getElementById('addType').value,
            };

            fetch(this.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
                body: JSON.stringify(formData),
            })
            .then(response => response.json())
            .then(data => {
                addLoader.classList.add('hidden');

                if (data.success) {
                    addNotification.classList.remove('hidden');
                    addNotification.innerText = data.message;

                    // Optionally, append the new clearance to the table
                    location.reload(); // Simple reload, can be optimized
                } else {
                    addNotification.classList.remove('hidden');
                    addNotification.classList.add('text-red-600');
                    addNotification.innerText = data.message;
                }
            })
            .catch(error => {
                addLoader.classList.add('hidden');
                console.error('Error:', error);
                alert('An error occurred while adding the clearance.');
            });
        });

        // Edit Modal Functions
        function openEditModal(id) {
            // Fetch clearance data
            fetch(`/admin/clearance/edit/${id}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('editDocumentName').value = data.clearance.document_name;
                    document.getElementById('editDescription').value = data.clearance.description;
                    document.getElementById('editUnits').value = data.clearance.units;
                    document.getElementById('editType').value = data.clearance.type;

                    document.getElementById('editForm').action = `/admin/clearance/update/${id}`;

                    document.getElementById('editModal').classList.remove('hidden');
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while fetching clearance data.');
            });
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
            document.getElementById('editForm').reset();
            document.getElementById('editNotification').classList.add('hidden');
        }

        document.getElementById('editForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const editLoader = document.getElementById('editLoader');
            const editNotification = document.getElementById('editNotification');
            editLoader.classList.remove('hidden');

            const formData = {
                document_name: document.getElementById('editDocumentName').value,
                description: document.getElementById('editDescription').value,
                units: document.getElementById('editUnits').value,
                type: document.getElementById('editType').value,
            };

            fetch(this.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
                body: JSON.stringify(formData),
            })
            .then(response => response.json())
            .then(data => {
                editLoader.classList.add('hidden');

                if (data.success) {
                    editNotification.classList.remove('hidden');
                    editNotification.innerText = data.message;

                    // Optionally, update the table without reloading
                    location.reload(); // Simple reload, can be optimized
                } else {
                    editNotification.classList.remove('hidden');
                    editNotification.classList.add('text-red-600');
                    editNotification.innerText = data.message;
                }
            })
            .catch(error => {
                editLoader.classList.add('hidden');
                console.error('Error:', error);
                alert('An error occurred while updating the clearance.');
            });
        });

        // Delete Modal Functions
        let currentDeleteId;

        function openDeleteModal(id, name) {
            currentDeleteId = id;
            document.getElementById('clearanceName').innerText = name;
            document.getElementById('deleteForm').action = `/admin/clearance/delete/${id}`;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.getElementById('deleteNotification').classList.add('hidden');
        }

        document.getElementById('deleteForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const deleteLoader = document.getElementById('deleteLoader');
            const deleteNotification = document.getElementById('deleteNotification');
            deleteLoader.classList.remove('hidden');

            fetch(this.action, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                deleteLoader.classList.add('hidden');

                if (data.success) {
                    closeDeleteModal();
                    alert(data.message);
                    location.reload(); // Simple reload, can be optimized
                } else {
                    deleteNotification.classList.remove('hidden');
                    deleteNotification.innerText = data.message;
                }
            })
            .catch(error => {
                deleteLoader.classList.add('hidden');
                console.error('Error:', error);
                alert('An error occurred while deleting the clearance.');
            });
        });
    </script>
</x-admin-layout>