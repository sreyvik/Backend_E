@extends('admin.layout')

@section('title', 'Users')

@section('content')
<div class="bg-white rounded-xl shadow-sm">
    <div class="px-6 py-4 border-b border-gray-100">
        <h3 class="font-semibold text-gray-800">All Users ({{ $users->total() }})</h3>
    </div>
    <div class="p-6">
        @if($users->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-sm text-gray-500 border-b border-gray-100">
                            <th class="pb-3 font-medium">ID</th>
                            <th class="pb-3 font-medium">User</th>
                            <th class="pb-3 font-medium">Email</th>
                            <th class="pb-3 font-medium">Orders</th>
                            <th class="pb-3 font-medium">Joined</th>
                            <th class="pb-3 font-medium text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                                <td class="py-3 text-sm text-gray-600">#{{ $user->id }}</td>
                                <td class="py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                                            <span class="text-sm font-bold text-indigo-600">{{ substr($user->name, 0, 2) }}</span>
                                        </div>
                                        <span class="font-medium text-gray-800">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="py-3 text-sm text-gray-500">{{ $user->email }}</td>
                                <td class="py-3"><span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded-full">{{ $user->orders_count ?? 0 }}</span></td>
                                <td class="py-3 text-sm text-gray-500">{{ $user->created_at->format('M d, Y') }}</td>
                                <td class="py-3 text-right">
                                    <a href="/admin/users/{{ $user->id }}" class="px-3 py-1.5 text-sm bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-100 transition-colors">
                                        <i class="fas fa-eye mr-1"></i> View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $users->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-users text-gray-400 text-2xl"></i>
                </div>
                <h4 class="text-lg font-medium text-gray-600">No Users Yet</h4>
                <p class="text-gray-400 mt-1">Users will appear here when they register.</p>
            </div>
        @endif
    </div>
</div>
@endsection
