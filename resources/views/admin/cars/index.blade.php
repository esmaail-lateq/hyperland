<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin - Car Listings') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 flex justify-between items-center">
                <div>
                    <form action="{{ route('admin.cars.index') }}" method="GET" class="flex gap-2">
                        <x-text-input type="text" name="search" placeholder="Search by title, make, model..." value="{{ request('search') }}" class="w-64" />
                        <x-primary-button type="submit">
                            {{ __('Search') }}
                        </x-primary-button>
                        @if(request('search'))
                            <a href="{{ route('admin.cars.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300">
                                {{ __('Clear') }}
                            </a>
                        @endif
                    </form>
                </div>
                <div>
                    <select name="status" id="status-filter" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" onchange="window.location.href=this.value">
                        <option value="{{ route('admin.cars.index') }}" {{ request('status') == '' ? 'selected' : '' }}>All Listings</option>
                        <option value="{{ route('admin.cars.index', ['status' => 'pending_approval']) }}" {{ request('status') == 'pending_approval' ? 'selected' : '' }}>في انتظار الموافقة</option>
                        <option value="{{ route('admin.cars.index', ['status' => 'admin_approved']) }}" {{ request('status') == 'admin_approved' ? 'selected' : '' }}>تم القبول من الإدارة</option>
                                                        <option value="{{ route('admin.cars.index', ['status' => 'available']) }}" {{ request('status') == 'available' ? 'selected' : '' }}>متوفرة للبيع في اليمن</option>
                        <option value="{{ route('admin.cars.index', ['status' => 'at_customs']) }}" {{ request('status') == 'at_customs' ? 'selected' : '' }}>متوفرة في المنافذ الجمركية</option>
                        <option value="{{ route('admin.cars.index', ['status' => 'in_transit']) }}" {{ request('status') == 'in_transit' ? 'selected' : '' }}>قيد الشحن إلى اليمن</option>
                        <option value="{{ route('admin.cars.index', ['status' => 'purchased']) }}" {{ request('status') == 'purchased' ? 'selected' : '' }}>تم شراؤها مؤخراً من المزاد</option>
                        <option value="{{ route('admin.cars.index', ['status' => 'rejected']) }}" {{ request('status') == 'rejected' ? 'selected' : '' }}>مرفوضة</option>
                        <option value="{{ route('admin.cars.index', ['status' => 'sold']) }}" {{ request('status') == 'sold' ? 'selected' : '' }}>تم البيع</option>
                    </select>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        ID
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Image
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Listing Details
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Seller
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Featured
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($cars as $car)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $car->id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="h-16 w-24 overflow-hidden rounded">
                                                @if($car->images->count() > 0)
                                                    <img src="{{ asset('storage/' . $car->images->first()->image_path) }}" alt="{{ $car->title }}" class="h-full w-full object-cover">
                                                @else
                                                    <div class="h-full w-full bg-gray-200 flex items-center justify-center text-gray-400">
                                                        <span>No image</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900 mb-1">
                                                {{ $car->title }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $car->make }} {{ $car->model }}, {{ $car->year }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ number_format($car->price, 2) }} € | {{ number_format($car->mileage) }} km
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ ucfirst($car->fuel_type) }} | {{ ucfirst($car->transmission) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $car->user->name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                @if($car->user->isDealer())
                                                    {{ $car->user->dealer_name }}
                                                @endif
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $car->user->email }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $car->status_badge_class }}">
                                                {{ $car->status_display }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <form action="{{ route('admin.cars.toggle-featured', $car) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-indigo-600 hover:text-indigo-900">
                                                    @if($car->is_featured)
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                    @else
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                                        </svg>
                                                    @endif
                                                </button>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('cars.show', $car) }}" class="text-indigo-600 hover:text-indigo-900">
                                                    View
                                                </a>
                                                
                                                {{-- Status Update Dropdown --}}
                                                <div class="relative" x-data="{ open: false }">
                                                    <button @click="open = !open" class="text-blue-600 hover:text-blue-900">
                                                        Update Status
                                                    </button>
                                                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50">
                                                        <div class="py-1">
                                                            <form action="{{ route('admin.cars.update-status', $car) }}" method="POST" class="block">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="status" value="available">
                                                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                                    متوفرة للبيع في اليمن
                                                                </button>
                                                            </form>
                                                            <form action="{{ route('admin.cars.update-status', $car) }}" method="POST" class="block">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="status" value="available_at_customs">
                                                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                                    متوفرة في المنافذ الجمركية
                                                                </button>
                                                            </form>
                                                            <form action="{{ route('admin.cars.update-status', $car) }}" method="POST" class="block">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="status" value="shipping_to_yemen">
                                                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                                    قيد الشحن إلى اليمن
                                                                </button>
                                                            </form>
                                                            <form action="{{ route('admin.cars.update-status', $car) }}" method="POST" class="block">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="status" value="recently_purchased">
                                                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                                    تم شراؤها مؤخراً من المزاد
                                                                </button>
                                                            </form>
                                                            <form action="{{ route('admin.cars.update-status', $car) }}" method="POST" class="block">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="status" value="admin_approved">
                                                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-emerald-600 hover:bg-emerald-50">
                                                                    تم القبول من الإدارة
                                                                </button>
                                                            </form>
                                                            <form action="{{ route('admin.cars.update-status', $car) }}" method="POST" class="block">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="status" value="rejected">
                                                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                                                    رفض
                                                                </button>
                                                            </form>
                                                            <form action="{{ route('admin.cars.update-status', $car) }}" method="POST" class="block">
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
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            No car listings found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $cars->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 