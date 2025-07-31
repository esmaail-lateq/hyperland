<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $isAdmin ? 'لوحة الإدارة الشاملة' : 'إدارة المحتوى' }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif
            
            @if(session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            <!-- Type Tabs -->
            <div class="mb-6 bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                <div class="flex space-x-4 border-b border-gray-200">
                    <a href="{{ route('unified-cars.index', array_merge(['type' => 'cars'], request()->except('type'))) }}" class="px-4 py-2 text-sm font-medium {{ request('type', 'cars') === 'cars' ? 'text-emerald-600 border-b-2 border-emerald-600' : 'text-gray-500 hover:text-gray-700' }}">
                        السيارات
                    </a>
                    <a href="{{ route('unified-cars.index', array_merge(['type' => 'spare-parts'], request()->except('type'))) }}" class="px-4 py-2 text-sm font-medium {{ request('type') === 'spare-parts' ? 'text-emerald-600 border-b-2 border-emerald-600' : 'text-gray-500 hover:text-gray-700' }}">
                        قطع الغيار
                    </a>
                </div>
            </div>

            <!-- Search and Filter Section -->
            <div class="mb-6 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <form action="{{ route('unified-cars.index') }}" method="GET" class="space-y-4">
                    <input type="hidden" name="type" value="{{ request('type', 'cars') }}">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Search Field -->
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">البحث</label>
                            <input type="text" name="search" id="search" 
                                   value="{{ request('search') }}"
                                   placeholder="النوع، الطراز، الموقع..."
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Approval Status Filter -->
                        <div>
                            <label for="approval_status" class="block text-sm font-medium text-gray-700 mb-1">حالة الموافقة</label>
                            <select name="approval_status" id="approval_status" 
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="all" {{ request('approval_status') == 'all' ? 'selected' : '' }}>جميع حالات الموافقة</option>
                                <option value="pending" {{ request('approval_status') == 'pending' ? 'selected' : '' }}>
                                    في انتظار الموافقة ({{ $statusCounts['pending'] }})
                                </option>
                                <option value="approved" {{ request('approval_status') == 'approved' ? 'selected' : '' }}>
                                    تمت الموافقة ({{ $statusCounts['approved'] }})
                                </option>
                                <option value="rejected" {{ request('approval_status') == 'rejected' ? 'selected' : '' }}>
                                    مرفوضة ({{ $statusCounts['rejected'] }})
                                </option>
                            </select>
                        </div>

                        <!-- Car Status Filter -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">حالة السيارة</label>
                            <select name="status" id="status" 
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>جميع حالات السيارة</option>
                                <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>
                                    متوفرة للبيع في اليمن ({{ $statusCounts['available'] ?? 0 }})
                                </option>
                                <option value="at_customs" {{ request('status') == 'at_customs' ? 'selected' : '' }}>
                                    متوفرة في المنافذ الجمركية ({{ $statusCounts['at_customs'] ?? 0 }})
                                </option>
                                <option value="in_transit" {{ request('status') == 'in_transit' ? 'selected' : '' }}>
                                    قيد الشحن إلى اليمن ({{ $statusCounts['in_transit'] ?? 0 }})
                                </option>
                                <option value="purchased" {{ request('status') == 'purchased' ? 'selected' : '' }}>
                                    تم شراؤها مؤخراً ({{ $statusCounts['purchased'] ?? 0 }})
                                </option>
                                <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>
                                    تم البيع ({{ $statusCounts['sold'] ?? 0 }})
                                </option>
                            </select>
                        </div>

                        <!-- Year Filter -->
                        <div>
                            <label for="year" class="block text-sm font-medium text-gray-700 mb-1">السنة</label>
                            <select name="year" id="year" 
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">جميع السنوات</option>
                                @if(isset($years))
                                    @foreach($years as $year)
                                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <!-- Advertiser Filter (Admin Only) -->
                        @if($isAdmin)
                        <div>
                            <label for="advertiser" class="block text-sm font-medium text-gray-700 mb-1">صاحب الإعلان</label>
                            <select name="advertiser" id="advertiser" 
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">جميع البائعين</option>
                                @if(isset($advertisers))
                                    @foreach($advertisers as $advertiser)
                                        <option value="{{ $advertiser->id }}" {{ request('advertiser') == $advertiser->id ? 'selected' : '' }}>
                                            {{ $advertiser->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        @endif
                    </div>

                    <!-- Filter Buttons -->
                    <div class="flex justify-between items-center">
                        <div class="flex space-x-2">
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                تطبيق الفلتر
                            </button>
                            
                            @if(request('search') || request('status') || request('year') || request('advertiser'))
                            <a href="{{ route('unified-cars.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                مسح الفلتر
                            </a>
                            @endif
                        </div>

                        <a href="{{ route('cars.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            إضافة سيارة جديدة
                        </a>
                    </div>
                </form>
            </div>

            <!-- Results Summary -->
            @if(request('type', 'cars') === 'cars' && isset($cars))
            <div class="mb-4 flex justify-between items-center">
                <div class="text-sm text-gray-600">
                    تم العثور على <span class="font-semibold">{{ $cars->total() }}</span> سيارة
                    @if(request('search') || request('status') || request('year') || request('advertiser'))
                        (مع الفلتر المطبق)
                    @endif
                </div>
                
                @if($cars->hasPages())
                <div class="text-sm text-gray-600">
                    الصفحة {{ $cars->currentPage() }} من {{ $cars->lastPage() }}
                </div>
                @endif
            </div>
            @endif

            <!-- Cars Table -->
            @if(request('type', 'cars') === 'cars' && isset($cars))
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white">
                    @if($cars->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        @if($isAdmin)
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            ID
                                        </th>
                                        @endif
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            الصورة
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            تفاصيل السيارة
                                        </th>
                                        @if($isAdmin)
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            البائع
                                        </th>
                                        @endif
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            حالة الموافقة
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            حالة السيارة
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            التاريخ
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            الإجراءات
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($cars as $car)
                                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                                            @if($isAdmin)
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $car->id }}
                                            </td>
                                            @endif
                                            
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="h-16 w-24 overflow-hidden rounded-lg shadow-sm">
                                                    @if($car->images->count() > 0)
                                                        <img src="{{ asset('storage/' . $car->images->first()->image_path) }}" 
                                                             alt="{{ $car->title }}" 
                                                             class="h-full w-full object-cover">
                                                    @else
                                                        <div class="h-full w-full bg-gray-200 flex items-center justify-center text-gray-400">
                                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                            </svg>
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
                                                    {{ number_format($car->price, 0) }} € | {{ number_format($car->mileage) }} km
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ ucfirst($car->fuel_type) }} | {{ ucfirst($car->transmission) }}
                                                </div>
                                                @if($car->location)
                                                <div class="text-sm text-gray-500">
                                                    📍 {{ $car->location }}
                                                </div>
                                                @endif
                                            </td>
                                            
                                            @if($isAdmin)
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ $car->user->name }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $car->user->email }}
                                                </div>
                                            </td>
                                            @endif
                                            
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <!-- Approval Status Badge -->
                                                <div class="mb-2">
                                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $car->approval_status_badge_class }}">
                                                        {{ $car->approval_status_display }}
                                                    </span>
                                                </div>
                                                
                                                <!-- Approval Control (Admin Only) -->
                                                @if($isAdmin && $car->approval_status === 'pending')
                                                    <div class="flex space-x-2">
                                                        <form action="{{ route('unified-cars.approve', $car) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" 
                                                                    class="text-xs px-3 py-1.5 bg-green-100 text-green-800 hover:bg-green-200 rounded-md transition-colors duration-200 font-medium">
                                                                ✅ موافقة
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('unified-cars.reject', $car) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" 
                                                                    class="text-xs px-3 py-1.5 bg-red-100 text-red-800 hover:bg-red-200 rounded-md transition-colors duration-200 font-medium">
                                                                ❌ رفض
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </td>
                                            
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <!-- Car Status Badge -->
                                                <div class="mb-2">
                                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $car->status_badge_class }}">
                                                        {{ $car->status_display }}
                                                    </span>
                                                    @if($car->is_featured)
                                                        <span class="ml-1 px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                            مميزة
                                                        </span>
                                                    @endif
                                                </div>
                                                
                                                <!-- Car Status Control -->
                                                <div class="flex space-x-2">
                                                    <form action="{{ route('unified-cars.update-status', $car) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <select name="status" 
                                                                onchange="this.form.submit()"
                                                                class="text-xs rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                            @if($isAdmin)
                                                                <option value="available" {{ $car->status == 'available' ? 'selected' : '' }}>متوفرة للبيع في اليمن</option>
                                                                <option value="at_customs" {{ $car->status == 'at_customs' ? 'selected' : '' }}>متوفرة في المنافذ الجمركية</option>
                                                                <option value="in_transit" {{ $car->status == 'in_transit' ? 'selected' : '' }}>قيد الشحن إلى اليمن</option>
                                                                <option value="purchased" {{ $car->status == 'purchased' ? 'selected' : '' }}>تم شراؤها مؤخراً</option>
                                                                <option value="sold" {{ $car->status == 'sold' ? 'selected' : '' }}>تم البيع</option>
                                                            @else
                                                                <option value="sold" {{ $car->status == 'sold' ? 'selected' : '' }}>تم البيع</option>
                                                            @endif
                                                        </select>
                                                    </form>
                                                    
                                                    @if($isAdmin)
                                                    <form action="{{ route('unified-cars.toggle-featured', $car) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" 
                                                                class="text-xs px-2 py-1 rounded-md {{ $car->is_featured ? 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }} transition-colors duration-200">
                                                            {{ $car->is_featured ? 'إلغاء التمييز' : 'تمييز' }}
                                                        </button>
                                                    </form>
                                                    @endif
                                                </div>
                                            </td>
                                            
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $car->created_at->format('M d, Y') }}
                                                <br>
                                                <span class="text-xs text-gray-400">{{ $car->created_at->format('H:i') }}</span>
                                            </td>
                                            
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex flex-col space-y-2">
                                                    <!-- Regular Actions -->
                                                    <div class="flex space-x-2">
                                                        <a href="{{ route('cars.show', $car) }}" 
                                                           class="text-indigo-600 hover:text-indigo-900 transition-colors duration-200">
                                                            عرض
                                                        </a>
                                                        <a href="{{ route('cars.edit', $car) }}" 
                                                           class="text-green-600 hover:text-green-900 transition-colors duration-200">
                                                            تعديل
                                                        </a>
                                                        @if($isAdmin || $car->user_id == auth()->id())
                                                        <form action="{{ route('cars.destroy', $car) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" 
                                                                    onclick="return confirm('هل أنت متأكد من حذف هذه السيارة؟')"
                                                                    class="text-red-600 hover:text-red-900 transition-colors duration-200">
                                                                حذف
                                                            </button>
                                                        </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        @if($cars->hasPages())
                        <div class="mt-6">
                            {{ $cars->appends(request()->query())->links() }}
                        </div>
                        @endif
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">لا توجد سيارات</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                @if(request('search') || request('status') || request('year') || request('advertiser'))
                                    لا توجد سيارات تطابق معايير البحث المحددة.
                                @else
                                    {{ $isAdmin ? 'لا توجد سيارات في النظام.' : 'لم تقم بإضافة أي سيارات بعد.' }}
                                @endif
                            </p>
                            <div class="mt-6">
                                <a href="{{ route('cars.create') }}" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    إضافة سيارة جديدة
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Spare Parts Section -->
            @if(request('type') === 'spare-parts' && isset($spareParts))
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        الصورة
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        تفاصيل قطع الغيار
                                    </th>
                                    @if($isAdmin)
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        المنشئ
                                    </th>
                                    @endif
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        حالة الموافقة
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        تاريخ الإنشاء
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        الإجراءات
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($spareParts as $sparePart)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="h-16 w-24 overflow-hidden rounded">
                                                <img src="{{ $sparePart->first_image_url }}" 
                                                     alt="{{ $sparePart->name }}" 
                                                     class="h-full w-full object-cover">
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900 mb-1">
                                                {{ $sparePart->name }}
                                            </div>
                                            @if($sparePart->description)
                                            <div class="text-sm text-gray-500 line-clamp-2">
                                                {{ Str::limit($sparePart->description, 100) }}
                                            </div>
                                            @endif
                                        </td>
                                        @if($isAdmin)
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $sparePart->creator->name ?? 'غير محدد' }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $sparePart->creator->email ?? '' }}
                                            </div>
                                        </td>
                                        @endif
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex flex-col space-y-2">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $sparePart->approval_status_badge_class }}">
                                                    {{ $sparePart->approval_status_display }}
                                                </span>
                                                
                                                @if($isAdmin && $sparePart->approval_status === 'pending')
                                                <div class="flex space-x-2">
                                                    <form action="{{ route('unified-cars.spare-parts.approve', $sparePart) }}" method="POST" class="inline">
                                                        @csrf @method('PATCH')
                                                        <button type="submit" 
                                                                class="text-xs px-3 py-1.5 bg-green-100 text-green-800 hover:bg-green-200 rounded-md transition-colors duration-200 font-medium">
                                                            ✅ موافقة
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('unified-cars.spare-parts.reject', $sparePart) }}" method="POST" class="inline">
                                                        @csrf @method('PATCH')
                                                        <button type="submit" 
                                                                class="text-xs px-3 py-1.5 bg-red-100 text-red-800 hover:bg-red-200 rounded-md transition-colors duration-200 font-medium">
                                                            ❌ رفض
                                                        </button>
                                                    </form>
                                                </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $sparePart->created_at->format('M d, Y') }}
                                            <br>
                                            <span class="text-xs text-gray-400">{{ $sparePart->created_at->format('H:i') }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('spare-parts.show', $sparePart) }}" 
                                                   class="text-indigo-600 hover:text-indigo-900 transition-colors duration-200">
                                                    عرض
                                                </a>
                                                @if($isAdmin || $sparePart->created_by == auth()->id())
                                                <a href="{{ route('spare-parts.edit', $sparePart) }}" 
                                                   class="text-green-600 hover:text-green-900 transition-colors duration-200">
                                                    تعديل
                                                </a>
                                                <form action="{{ route('spare-parts.destroy', $sparePart) }}" method="POST" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" 
                                                            onclick="return confirm('هل أنت متأكد من حذف قطع الغيار هذه؟')"
                                                            class="text-red-600 hover:text-red-900 transition-colors duration-200">
                                                        حذف
                                                    </button>
                                                </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ $isAdmin ? '6' : '5' }}" class="px-6 py-12 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                            </svg>
                                            <h3 class="mt-2 text-sm font-medium text-gray-900">لا توجد قطع غيار</h3>
                                            <p class="mt-1 text-sm text-gray-500">
                                                @if(request('search') || request('approval_status') || request('creator'))
                                                    لا توجد قطع غيار تطابق معايير البحث المحددة.
                                                @else
                                                    {{ $isAdmin ? 'لا توجد قطع غيار في النظام.' : 'لم تقم بإضافة أي قطع غيار بعد.' }}
                                                @endif
                                            </p>
                                            <div class="mt-6">
                                                <a href="{{ route('spare-parts.create') }}" 
                                                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                    </svg>
                                                    إضافة قطع غيار جديدة
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if(isset($spareParts) && $spareParts->hasPages())
                    <div class="mt-6">
                        {{ $spareParts->appends(request()->query())->links() }}
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style> 