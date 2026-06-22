@extends('admin.layout')

@section('title', 'Order #' . $order->id)

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Order Details -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-xl shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-semibold text-gray-800">Order #{{ $order->id }}</h3>
                <span class="px-3 py-1 text-sm rounded-full font-medium
                    @if($order->status === 'pending') bg-yellow-100 text-yellow-700
                    @elseif($order->status === 'processing') bg-blue-100 text-blue-700
                    @elseif($order->status === 'shipped') bg-purple-100 text-purple-700
                    @elseif($order->status === 'delivered') bg-green-100 text-green-700
                    @elseif($order->status === 'cancelled') bg-red-100 text-red-700
                    @else bg-gray-100 text-gray-700 @endif">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left text-sm text-gray-500 border-b border-gray-100">
                                <th class="pb-3 font-medium">Product</th>
                                <th class="pb-3 font-medium">Price</th>
                                <th class="pb-3 font-medium">Qty</th>
                                <th class="pb-3 font-medium text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                                <tr class="border-b border-gray-50">
                                    <td class="py-3">
                                        <div class="flex items-center gap-3">
                                            @if($item->product->image)
                                                <img src="{{ $item->product->image }}" alt="" class="w-10 h-10 rounded-lg object-cover">
                                            @else
                                                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                                    <i class="fas fa-box text-gray-400"></i>
                                                </div>
                                            @endif
                                            <span class="font-medium text-gray-800">{{ $item->product->name }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 text-sm text-gray-600">${{ number_format($item->price, 2) }}</td>
                                    <td class="py-3 text-sm text-gray-600">{{ $item->quantity }}</td>
                                    <td class="py-3 text-right font-medium text-gray-800">${{ number_format($item->subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="pt-4 text-right font-semibold text-gray-800">Total:</td>
                                <td class="pt-4 text-right font-bold text-gray-800 text-lg">${{ number_format($order->total_amount, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Customer Info -->
        <div class="bg-white rounded-xl shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-800">Customer</h3>
            </div>
            <div class="p-6 space-y-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                        <span class="text-sm font-bold text-indigo-600">{{ substr($order->user->name, 0, 2) }}</span>
                    </div>
                    <div>
                        <p class="font-medium text-gray-800">{{ $order->user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $order->user->email }}</p>
                    </div>
                </div>
                <a href="/admin/users/{{ $order->user->id }}" class="text-sm text-indigo-600 hover:text-indigo-800">
                    <i class="fas fa-external-link-alt mr-1"></i> View Profile
                </a>
            </div>
        </div>

        <!-- Shipping Info -->
        <div class="bg-white rounded-xl shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-800">Shipping Address</h3>
            </div>
            <div class="p-6">
                @if(is_array($order->shipping_address))
                    <div class="space-y-1 text-sm text-gray-600">
                        <p>{{ $order->shipping_address['street'] ?? '' }}</p>
                        <p>{{ $order->shipping_address['city'] ?? '' }}, {{ $order->shipping_address['state'] ?? '' }}</p>
                        <p>{{ $order->shipping_address['zip'] ?? '' }}</p>
                    </div>
                @else
                    <p class="text-sm text-gray-500">{{ $order->shipping_address }}</p>
                @endif
            </div>
        </div>

        <!-- Order Info -->
        <div class="bg-white rounded-xl shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-800">Order Info</h3>
            </div>
            <div class="p-6 space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Payment</span>
                    <span class="font-medium text-gray-800">{{ ucfirst($order->payment_method ?? 'N/A') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Date</span>
                    <span class="font-medium text-gray-800">{{ $order->created_at->format('M d, Y h:i A') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Updated</span>
                    <span class="font-medium text-gray-800">{{ $order->updated_at->diffForHumans() }}</span>
                </div>
            </div>
        </div>

        <!-- Update Status -->
        <div class="bg-white rounded-xl shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-800">Update Status</h3>
            </div>
            <div class="p-6">
                <form method="POST" action="/admin/orders/{{ $order->id }}/status" class="space-y-3">
                    @csrf
                    @method('PATCH')
                    <select name="status" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <button type="submit" class="w-full bg-indigo-900 hover:bg-indigo-800 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                        <i class="fas fa-sync mr-1"></i> Update Status
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
