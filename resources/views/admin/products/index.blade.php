@extends('admin.layout')

@section('title', 'Products')

@section('content')
<div class="bg-white rounded-xl shadow-sm">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <h3 class="font-semibold text-gray-800">All Products ({{ $products->total() }})</h3>
        <a href="/admin/products/create" class="bg-indigo-900 hover:bg-indigo-800 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
            <i class="fas fa-plus"></i>
            Add Product
        </a>
    </div>
    <div class="p-6">
        @if($products->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-sm text-gray-500 border-b border-gray-100">
                            <th class="pb-3 font-medium">ID</th>
                            <th class="pb-3 font-medium">Image</th>
                            <th class="pb-3 font-medium">Name</th>
                            <th class="pb-3 font-medium">Category</th>
                            <th class="pb-3 font-medium">Price</th>
                            <th class="pb-3 font-medium">Stock</th>
                            <th class="pb-3 font-medium">Rating</th>
                            <th class="pb-3 font-medium text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                                <td class="py-3 text-sm text-gray-600">#{{ $product->id }}</td>
                                <td class="py-3">
                                    @if($product->image)
                                        <img src="{{ $product->image }}" alt="" class="w-10 h-10 rounded-lg object-cover">
                                    @else
                                        <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-box text-gray-400"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="py-3 font-medium text-gray-800 max-w-[200px] truncate">{{ $product->name }}</td>
                                <td class="py-3 text-sm text-gray-500">{{ $product->category->name ?? 'N/A' }}</td>
                                <td class="py-3 font-medium text-gray-800">${{ number_format($product->price, 2) }}</td>
                                <td class="py-3">
                                    <span class="px-2 py-1 text-xs rounded-full {{ $product->stock > 10 ? 'bg-green-100 text-green-700' : ($product->stock > 0 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                        {{ $product->stock }}
                                    </span>
                                </td>
                                <td class="py-3 text-sm text-gray-500">
                                    @if($product->averageRating() > 0)
                                        {{ number_format($product->averageRating(), 1) }} <i class="fas fa-star text-yellow-400 text-xs"></i>
                                    @else
                                        —
                                    @endif
                                </td>
                                <td class="py-3 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="/admin/products/{{ $product->id }}/edit" class="px-3 py-1.5 text-sm bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-100 transition-colors">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="/admin/products/{{ $product->id }}" onsubmit="return confirm('Delete this product? This action cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 text-sm bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-box text-gray-400 text-2xl"></i>
                </div>
                <h4 class="text-lg font-medium text-gray-600">No Products Yet</h4>
                <p class="text-gray-400 mt-1">Get started by adding your first product.</p>
                <a href="/admin/products/create" class="inline-block mt-4 bg-indigo-900 hover:bg-indigo-800 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    Add Product
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
