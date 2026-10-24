@extends('layouts.admin')

@section('title', 'User Directory - Cartiva Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-8">
        <div class="flex items-center space-x-2 text-xs font-bold text-slate-500 mb-1">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-purple-600">Admin Dashboard</a>
            <span>/</span>
            <span class="text-slate-800">Users</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Registered Platform Users</h1>
        <p class="text-xs text-slate-500 mt-1">Multi-Auth directory across customers, sellers, and administrators.</p>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-400 uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="py-3 px-6">Name</th>
                        <th class="py-3 px-6">Email</th>
                        <th class="py-3 px-6">Role</th>
                        <th class="py-3 px-6">Phone</th>
                        <th class="py-3 px-6">Address</th>
                        <th class="py-3 px-6">Registered</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $u)
                        <tr class="hover:bg-slate-50/50">
                            <td class="py-4 px-6 font-bold text-slate-900 flex items-center space-x-2">
                                <div class="w-7 h-7 rounded-full bg-slate-700 text-white font-bold text-[10px] flex items-center justify-center">
                                    {{ strtoupper(substr($u->name, 0, 1)) }}
                                </div>
                                <span>{{ $u->name }}</span>
                            </td>
                            <td class="py-4 px-6 text-slate-600 font-mono">{{ $u->email }}</td>
                            <td class="py-4 px-6">
                                @if($u->role === 'admin')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-purple-100 text-purple-900 uppercase">Admin</span>
                                @elseif($u->role === 'seller')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-teal-100 text-teal-900 uppercase">Seller</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 uppercase">Customer</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-slate-500">{{ $u->phone ?? '—' }}</td>
                            <td class="py-4 px-6 text-slate-500 max-w-xs truncate">{{ $u->address ?? '—' }}</td>
                            <td class="py-4 px-6 text-slate-400 font-mono text-[11px]">{{ $u->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400 font-medium">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $users->links() }}
        </div>
    </div>

</div>
@endsection
