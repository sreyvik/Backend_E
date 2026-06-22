@extends('admin.layout')

@section('title', 'Orders')

@section('content')
<div class="bg-white rounded-xl shadow-sm">
    <div class="px-6 py-4 border-b border-gray-100">
        <h3 class="font-semibold text-gray-800">All Orders ({{ $orders->total() }})</h3>
    </div>
    <div class="p-6">
        @if($orders->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-sm text-gray-500 border-b border-gray-100">
                            <th class="pb-3 font-medium">Order #</th>
                            <th class="pb-3 font-medium">Customer</th>
                            <th class="pb-3 font-medium">Items</th>
                            <th class="pb-3 font-medium">Total</th>
                            <th class="pb-3 font-medium">Status</th>
                            <th class="pb-3 font-medium">Payment</th>
                            <th class="pb-3 font-medium">Date</th>
                            <th class="pb-3 font-medium text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                                <td class="py-3 font-medium text-gray-800">#{{ $order->id }}</td>
                                <td class="py-3">
                                    <p class="font-medium text-gray-800">{{ $order->user->name ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-500">{{ $order->user->email ?? '' }}</p>
                                </td>
                                <td class="py-3 text-sm text-gray-600">{{ $order->items->count() }}</td>
                                <td class="py-3 font-medium text-gray-800">${{ number_format($order->total_amount, 2) }}</td>
                                <td class="py-3">
                                    <span class="px-2 py-1 text-xs rounded-full font-medium
                                        @if($order->status === 'pending') bg-yellow-100 text-yellow-700
                                        @elseif($order->status === 'processing') bg-blue-100 text-blue-700
                                        @elseif($order->status === 'shipped') bg-purple-100 text-purple-700
                                        @elseif($order->status === 'delivered') bg-green-100 text-green-700
                                        @elseif($order->status === 'cancelled') bg-red-100 text-red-700
                                        @else bg-gray-100 text-gray-700 @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="py-3 text-sm text-gray-600">{{ ucfirst($order->payment_method ?? 'N/A') }}</td>
                                <td class="py-3 text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                                <td class="py-3 text-right">
                                    <a href="/admin/orders/{{ $order->id }}" class="px-3 py-1.5 text-sm bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-100 transition-colors">
                                        <i class="fas fa-eye mr-1"></i> View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shopping-cart text-gray-400 text-2xl"></i>
                </div>
                <h4 class="text-lg font-medium text-gray-600">No Orders Yet</h4>
                <p class="text-gray-400 mt-1">Orders will appear here when customers make purchases.</p>
            </div>
        @endif
    </div>
</div>
@endsection
