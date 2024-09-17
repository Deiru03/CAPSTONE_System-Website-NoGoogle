<x-admin-layout>
    <x-slot name="header">
        {{ __('Dashboard') }} <!-- Set the header content here -->
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Faculty Card -->
                <div class="bg-blue-500 text-white p-4 rounded-lg shadow">
                    <h3 class="text-lg font-bold">Faculty</h3>
                    <p class="text-2xl">{{ $TotalUser }}</p>
                </div>
                 <!-- Clearance Card -->
                 <div class="bg-blue-500 text-white p-4 rounded-lg shadow">
                    <h3 class="text-lg font-bold">Clearance</h3>
                    <p class="text-2xl">{{ $clearanceTotal }}</p>
                </div>
                <!-- My Files Card -->
                <div class="bg-blue-500 text-white p-4 rounded-lg shadow">
                    <h3 class="text-lg font-bold">My Files</h3>
                    <p class="text-2xl">10</p>
                </div>
                <!-- Shared Files Card -->
                <div class="bg-blue-500 text-white p-4 rounded-lg shadow">
                    <h3 class="text-lg font-bold">Shared Files</h3>
                    <p class="text-2xl">5</p>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Clearance Status -->
                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="text-lg font-bold">Clearance Status</h3>
                    <table class="min-w-full mt-4">
                        <thead>
                            <tr>
                                <th class="text-left">Status</th>
                                <th class="text-left">Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-yellow-500">Pending</td>
                                <td>{{ $clearancePending }}</td>
                            </tr>
                            <tr>
                                <td class="text-green-500">Complete</td>
                                <td>{{ $clearanceComplete }}</td>
                            </tr>
                            <tr>
                                <td class="text-orange-700">Return</td>
                                <td>{{ $clearanceReturn }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Faculty Status -->
                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="text-lg font-bold">Faculty Status</h3>
                    <table class="min-w-full mt-4">
                        <thead>
                            <tr>
                                <th class="text-left">Position</th>
                                <th class="text-left">Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Permanent</td>
                                <td>{{ $facultyPermanent }}</td>
                            </tr>
                            <tr>
                                <td>Part-Timer</td>
                                <td>{{ $facultyPartTime }}</td>
                            </tr>
                            <tr>
                                <td>Temporary</td>
                                <td>{{ $facultyTemporary }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
