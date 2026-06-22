@extends('admin.layout')

@section('title', 'Categories')

@section('content')
<div class="bg-white rounded-xl shadow-sm">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <h3 class="font-semibold text-gray-800">All Categories</h3>
        <a href="/admin/categories/create" class="bg-indigo-900 hover:bg-indigo-800 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
            <i class="fas fa-plus"></i>
            Add Category
        </a>
    </div>
    <div class="p-6">
        @if($categories->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-sm text-gray-500 border-b border-gray-100">
                            <th class="pb-3 font-medium">ID</th>
                            <th class="pb-3 font-medium">Name</th>
                            <th class="pb-3 font-medium">Slug</th>
                            <th class="pb-3 font-medium">Description</th>
                            <th class="pb-3 font-medium">Products</th>
                            <th class="pb-3 font-medium">Created</th>
                            <th class="pb-3 font-medium text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                                <td class="py-3 text-sm text-gray-600">#{{ $category->id }}</td>
                                <td class="py-3 font-medium text-gray-800">{{ $category->name }}</td>
                                <td class="py-3 text-sm text-gray-500">{{ $category->slug }}</td>
                                <td class="py-3 text-sm text-gray-500 max-w-xs truncate">{{ $category->description ?? '—' }}</td>
                                <td class="py-3"><span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded-full">{{ $category->products_count ?? 0 }}</span></td>
                                <td class="py-3 text-sm text-gray-500">{{ $category->created_at->format('M d, Y') }}</td>
                                <td class="py-3 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="/admin/categories/{{ $category->id }}/edit" class="px-3 py-1.5 text-sm bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-100 transition-colors">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="/admin/categories/{{ $category->id }}" onsubmit="return confirm('Delete this category? This may affect related products.')">
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
        @else
            <div class="text-center py-12">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-tags text-gray-400 text-2xl"></i>
                </div>
                <h4 class="text-lg font-medium text-gray-600">No Categories Yet</h4>
                <p class="text-gray-400 mt-1">Get started by creating your first category.</p>
                <a href="/admin/categories/create" class="inline-block mt-4 bg-indigo-900 hover:bg-indigo-800 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    Add Category
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
