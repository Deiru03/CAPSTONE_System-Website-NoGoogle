<x-admin-layout>
    <x-slot name="header">
        {{ __('Dashboard') }} <!-- Set the header content here -->
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Faculty Card -->
                <a href="{{ route('admin.views.faculty') }}" class="bg-blue-500 text-white p-4 rounded-lg shadow relative hover:bg-blue-600 transition duration-300 ease-in-out cursor-pointer">
                    <div>
                        <h3 class="text-lg font-bold">Faculty</h3>
                        <p class="text-2xl">{{ $TotalUser }}</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 absolute top-2 right-2 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </a>
                 <!-- Clearance Card -->
                 <a href="{{ route('admin.views.clearances') }}" class="bg-blue-500 text-white p-4 rounded-lg shadow relative hover:bg-blue-600 transition duration-300 ease-in-out cursor-pointer">
                    <div>
                        <h3 class="text-lg font-bold">Clearance</h3>
                        <p class="text-2xl">{{ $clearanceTotal }}</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 absolute top-2 right-2 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </a>
                <!-- My Files Card -->
                <a href="{{ route('admin.views.myFiles') }}" class="bg-blue-500 text-white p-4 rounded-lg shadow relative hover:bg-blue-600 transition duration-300 ease-in-out cursor-pointer">
                    <div>
                        <h3 class="text-lg font-bold">My Files</h3>
                        <p class="text-2xl">10</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 absolute top-2 right-2 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                    </svg>
                </a>
                <!-- Shared Files Card -->
                <a href="{{ route('admin.views.submittedReports') }}" class="bg-blue-500 text-white p-4 rounded-lg shadow relative hover:bg-blue-600 transition duration-300 ease-in-out cursor-pointer">
                    <div>
                        <h3 class="text-lg font-bold">Submitted Reports</h3>
                        <p class="text-2xl">{{ $submittedReportsCount ?? 0 }}</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 absolute top-2 right-2 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </a>
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
