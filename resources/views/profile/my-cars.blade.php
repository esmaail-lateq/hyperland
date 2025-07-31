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
                    <a href="{{ route('profile.my-cars', ['status' => 'pending_approval']) }}" class="inline-flex items-center px-4 py-2 bg-{{ $statusFilter === 'pending_approval' ? 'orange-500 text-white' : 'gray-200 text-gray-800' }} border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-{{ $statusFilter === 'pending_approval' ? 'orange-600' : 'gray-300' }}">
                        في انتظار الموافقة ({{ auth()->user()->cars()->where('status', 'pending_approval')->count() }})
                    </a>
                                            <a href="{{ route('profile.my-cars', ['status' => 'available']) }}" class="inline-flex items-center px-4 py-2 bg-{{ $statusFilter === 'available' ? 'green-500 text-white' : 'gray-200 text-gray-800' }} border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-{{ $statusFilter === 'available' ? 'green-600' : 'gray-300' }}">
                            متوفرة للبيع في اليمن ({{ auth()->user()->cars()->where('status', 'available')->count() }})
                        </a>
                                            <a href="{{ route('profile.my-cars', ['status' => 'at_customs']) }}" class="inline-flex items-center px-4 py-2 bg-{{ $statusFilter === 'at_customs' ? 'blue-500 text-white' : 'gray-200 text-gray-800' }} border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-{{ $statusFilter === 'at_customs' ? 'blue-600' : 'gray-300' }}">
                            متوفرة في المنافذ الجمركية ({{ auth()->user()->cars()->where('status', 'at_customs')->count() }})
                        </a>
                                            <a href="{{ route('profile.my-cars', ['status' => 'in_transit']) }}" class="inline-flex items-center px-4 py-2 bg-{{ $statusFilter === 'in_transit' ? 'yellow-500 text-white' : 'gray-200 text-gray-800' }} border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-{{ $statusFilter === 'in_transit' ? 'yellow-600' : 'gray-300' }}">
                            قيد الشحن إلى اليمن ({{ auth()->user()->cars()->where('status', 'in_transit')->count() }})
                        </a>
                                            <a href="{{ route('profile.my-cars', ['status' => 'purchased']) }}" class="inline-flex items-center px-4 py-2 bg-{{ $statusFilter === 'purchased' ? 'purple-500 text-white' : 'gray-200 text-gray-800' }} border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-{{ $statusFilter === 'purchased' ? 'purple-600' : 'gray-300' }}">
                            تم شراؤها مؤخراً ({{ auth()->user()->cars()->where('status', 'purchased')->count() }})
                        </a>
                    
                    <a href="{{ route('profile.my-cars', ['status' => 'sold']) }}" class="inline-flex items-center px-4 py-2 bg-{{ $statusFilter === 'sold' ? 'gray-500 text-white' : 'gray-200 text-gray-800' }} border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-{{ $statusFilter === 'sold' ? 'gray-600' : 'gray-300' }}">
                        تم البيع ({{ auth()->user()->cars()->where('status', 'sold')->count() }})
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
                                                    {{ $car->status_badge_class }}">
                                                    {{ $car->status_display }}
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
                                                    
                                                    {{-- Status Update Dropdown --}}
                                                    <div class="relative" x-data="{ open: false }">
                                                        <button @click="open = !open" class="text-blue-600 hover:text-blue-900">
                                                            Update Status
                                                        </button>
                                                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50">
                                                            <div class="py-1">
                                                                <form action="{{ route('profile.cars.update-status', $car) }}" method="POST" class="block">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" name="status" value="available">
                                                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                                        متوفرة للبيع في اليمن
                                                                    </button>
                                                                </form>
                                                                <form action="{{ route('profile.cars.update-status', $car) }}" method="POST" class="block">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" name="status" value="available_at_customs">
                                                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                                        متوفرة في المنافذ الجمركية
                                                                    </button>
                                                                </form>
                                                                <form action="{{ route('profile.cars.update-status', $car) }}" method="POST" class="block">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" name="status" value="shipping_to_yemen">
                                                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                                        قيد الشحن إلى اليمن
                                                                    </button>
                                                                </form>
                                                                <form action="{{ route('profile.cars.update-status', $car) }}" method="POST" class="block">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" name="status" value="recently_purchased">
                                                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                                        تم شراؤها مؤخراً من المزاد
                                                                    </button>
                                                                </form>
                                                                <form action="{{ route('profile.cars.update-status', $car) }}" method="POST" class="block">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" name="status" value="admin_approved">
                                                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                                        تم القبول من الإدارة
                                                                    </button>
                                                                </form>
                                                                <form action="{{ route('profile.cars.update-status', $car) }}" method="POST" class="block">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" name="status" value="sold">
                                                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-600 hover:bg-gray-100">
                                                                        تم البيع
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
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