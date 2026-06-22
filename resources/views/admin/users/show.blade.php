@extends('admin.layout')

@section('title', 'User: ' . $user->name)

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- User Info -->
    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white rounded-xl shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-800">User Info</h3>
            </div>
            <div class="p-6 text-center">
                <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <span class="text-xl font-bold text-indigo-600">{{ substr($user->name, 0, 2) }}</span>
                </div>
                <h4 class="font-semibold text-gray-800 text-lg">{{ $user->name }}</h4>
                <p class="text-sm text-gray-500">{{ $user->email }}</p>
                <p class="text-xs text-gray-400 mt-1">Joined {{ $user->created_at->format('M d, Y') }}</p>
            </div>
            <div class="px-6 pb-6 space-y-3 text-sm">
                <div class="flex justify-between border-b border-gray-50 pb-2">
                    <span class="text-gray-500">Total Orders</span>
                    <span class="font-medium text-gray-800">{{ $user->orders->count() }}</span>
                </div>
                <div class="flex justify-between border-b border-gray-50 pb-2">
                    <span class="text-gray-500">Total Reviews</span>
                    <span class="font-medium text-gray-800">{{ $user->reviews->count() }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Account Status</span>
                    <span class="px-2 py-0.5 bg-green-100 text-green-700 text-xs rounded-full">Active</span>
                </div>
            </div>
        </div>
    </div>

    <div class="lg:col-span-2 space-y-6">
        <!-- User Orders -->
        <div class="bg-white rounded-xl shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-800">Orders ({{ $user->orders->count() }})</h3>
            </div>
            <div class="p-6">
                @if($user->orders->count() > 0)
                    <div class="space-y-3">
                        @foreach($user->orders as $order)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-800">#{{ $order->id }} - ${{ number_format($order->total_amount, 2) }}</p>
                                    <p class="text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-xs px-2 py-1 rounded-full
                                        @if($order->status === 'pending') bg-yellow-100 text-yellow-700
                                        @elseif($order->status === 'processing') bg-blue-100 text-blue-700
                                        @elseif($order->status === 'shipped') bg-purple-100 text-purple-700
                                        @elseif($order->status === 'delivered') bg-green-100 text-green-700
                                        @elseif($order->status === 'cancelled') bg-red-100 text-red-700
                                        @else bg-gray-100 text-gray-700 @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                    <a href="/admin/orders/{{ $order->id }}" class="text-sm text-indigo-600 hover:text-indigo-800">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">No orders yet</p>
                @endif
            </div>
        </div>

        <!-- User Reviews -->
        <div class="bg-white rounded-xl shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-800">Reviews ({{ $user->reviews->count() }})</h3>
            </div>
            <div class="p-6">
                @if($user->reviews->count() > 0)
                    <div class="space-y-3">
                        @foreach($user->reviews as $review)
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center justify-between mb-1">
                                    <p class="font-medium text-gray-800">{{ $review->product->name ?? 'Unknown Product' }}</p>
                                    <div class="flex items-center gap-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }} text-xs"></i>
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600">{{ $review->comment ?? 'No comment' }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $review->created_at->diffForHumans() }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">No reviews yet</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
