<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Car Listings') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex justify-between items-center">
                <div class="flex space-x-2">
                    <a href="{{ route('profile.my-cars') }}" class="inline-flex items-center px-4 py-2 bg-{{ $statusFilter ? 'gray-200' : 'indigo-500' }} border border-transparent rounded-md font-semibold text-xs text-{{ $statusFilter ? 'gray-800' : 'white' }} uppercase tracking-widest hover:bg-{{ $statusFilter ? 'gray-300' : 'indigo-600' }}">
                        All ({{ auth()->user()->cars()->count() }})
                    </a>
                    <a href="{{ route('profile.my-cars', ['status' => 'pending']) }}" class="inline-flex items-center px-4 py-2 bg-{{ $statusFilter === 'pending' ? 'yellow-500 text-white' : 'gray-200 text-gray-800' }} border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-{{ $statusFilter === 'pending' ? 'yellow-600' : 'gray-300' }}">
                        Pending ({{ auth()->user()->cars()->where('status', 'pending')->count() }})
                    </a>
                    <a href="{{ route('profile.my-cars', ['status' => 'approved']) }}" class="inline-flex items-center px-4 py-2 bg-{{ $statusFilter === 'approved' ? 'green-500 text-white' : 'gray-200 text-gray-800' }} border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-{{ $statusFilter === 'approved' ? 'green-600' : 'gray-300' }}">
                        Approved ({{ auth()->user()->cars()->where('status', 'approved')->count() }})
                    </a>
                    <a href="{{ route('profile.my-cars', ['status' => 'rejected']) }}" class="inline-flex items-center px-4 py-2 bg-{{ $statusFilter === 'rejected' ? 'red-500 text-white' : 'gray-200 text-gray-800' }} border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-{{ $statusFilter === 'rejected' ? 'red-600' : 'gray-300' }}">
                        Rejected ({{ auth()->user()->cars()->where('status', 'rejected')->count() }})
                    </a>
                </div>
                <a href="{{ route('cars.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-600">
                    {{ __('Add New Car') }}
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white">
                    @if($cars->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Car Details
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Created
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($cars as $car)
                                        <tr>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <div class="h-16 w-24 flex-shrink-0 mr-4">
                                                        @if(strpos($car->mainImage, 'images/') === 0)
                                                            <img src="{{ asset($car->mainImage) }}" alt="{{ $car->title }}" class="h-16 w-24 object-cover rounded">
                                                        @else
                                                            <img src="{{ asset('storage/' . $car->mainImage) }}" alt="{{ $car->title }}" class="h-16 w-24 object-cover rounded">
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $car->title }}
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            {{ $car->make }} {{ $car->model }}, {{ $car->year }}
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            {{ number_format($car->price, 2) }} € | {{ number_format($car->mileage) }} km
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $car->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                                       ($car->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                                    {{ ucfirst($car->status) }}
                                                </span>
                                                @if($car->is_featured)
                                                    <span class="ml-1 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        Featured
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $car->created_at->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('cars.show', $car) }}" class="text-indigo-600 hover:text-indigo-900">
                                                        View
                                                    </a>
                                                    <a href="{{ route('cars.edit', $car) }}" class="text-indigo-600 hover:text-indigo-900">
                                                        Edit
                                                    </a>
                                                    <form action="{{ route('cars.destroy', $car) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this listing?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-6">
                            {{ $cars->links() }}
                        </div>
                    @else
                        <div class="text-center py-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M8 20h8a2 2 0 002-2V6a2 2 0 00-2-2H8a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <h3 class="mt-2 text-lg font-medium text-gray-900">No car listings found</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by adding your first car listing.</p>
                            <div class="mt-6">
                                <a href="{{ route('cars.create') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                                    Add New Car
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 