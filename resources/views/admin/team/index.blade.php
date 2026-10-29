@extends('admin.layout.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900 leading-tight">Di Balik LINTASAN (Board, Leadership & Team)</h1>
            <p class="text-xs text-gray-500 mt-1">Kelola data figur pendiri, dewan pembina, dewan pengawas, pengurus, dan tim pelaksana yayasan.</p>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" onclick="openLivePreviewModal('/di-balik-lintasan')" class="bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100 text-xs font-bold px-3.5 py-2.5 rounded-lg transition flex items-center gap-1.5 shadow-sm">
                <i class="fas fa-desktop"></i> Live Preview Halaman
            </button>
            <a href="{{ route('admin.people.create') }}" class="bg-brand-green hover:bg-brand-darkgreen text-white font-bold text-xs px-4 py-2.5 rounded-lg shadow transition flex items-center gap-1.5">
                <i class="fas fa-plus"></i> Tambah Figur Baru
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-brand-green p-4 rounded-xl text-xs font-semibold mb-6 shadow-sm flex items-center gap-2">
            <i class="fas fa-circle-check text-sm"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl text-xs font-semibold mb-6 shadow-sm flex items-center gap-2">
            <i class="fas fa-circle-xmark text-sm"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Filter & Search Toolbar -->
    <div class="bg-white rounded-xl border border-gray-200 p-4 mb-6 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
        <form method="GET" action="{{ route('admin.people.index') }}" class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
            <div class="relative flex-1 sm:w-64">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau jabatan..." class="w-full pl-8 pr-3 py-2 border border-gray-200 rounded-lg text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none">
                <i class="fas fa-search absolute left-2.5 top-2.5 text-gray-400 text-xs"></i>
            </div>

            <select name="category" onchange="this.form.submit()" class="border border-gray-200 rounded-lg px-3 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none bg-white">
                <option value="">Semua Kategori ({{ $members->count() }})</option>
                @foreach($categories as $catKey => $catInfo)
                    <option value="{{ $catKey }}" {{ request('category') === $catKey ? 'selected' : '' }}>
                        {{ $catInfo['id'] }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold px-3 py-2 rounded-lg transition">
                Filter
            </button>
            @if(request('search') || request('category'))
                <a href="{{ route('admin.people.index') }}" class="text-xs text-red-600 hover:underline px-2 py-1">
                    Reset
                </a>
            @endif
        </form>

        <div class="text-[11px] text-gray-400 font-medium">
            Total: <span class="font-bold text-gray-800">{{ $members->count() }}</span> figur
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden text-xs">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-150">
                <thead class="bg-gray-50 font-bold text-gray-700 uppercase tracking-wider text-left">
                    <tr>
                        <th class="px-6 py-4">Foto</th>
                        <th class="px-6 py-4">Nama Figur</th>
                        <th class="px-6 py-4">Kategori Struktur</th>
                        <th class="px-6 py-4">Peran / Jabatan</th>
                        <th class="px-6 py-4 text-center">Urutan</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-150 text-gray-600 bg-white">
                    @forelse($members as $person)
                        <tr class="hover:bg-gray-50 transition">
                            <!-- Photo -->
                            <td class="px-6 py-4">
                                @if($person->photo_path)
                                    <div class="w-12 h-12 rounded-full bg-cover bg-top border border-gray-200 shadow-xs" style="background-image: url('{{ $person->photo_path }}');"></div>
                                @else
                                    <div class="w-12 h-12 rounded-full bg-emerald-100 text-brand-green flex items-center justify-center font-extrabold text-sm border border-emerald-200">
                                        {{ strtoupper(substr($person->name, 0, 1)) }}
                                    </div>
                                @endif
                            </td>

                            <!-- Name -->
                            <td class="px-6 py-4">
                                <div class="font-extrabold text-gray-900">{{ $person->name }}</div>
                                <div class="text-[10px] text-gray-400 mt-0.5 line-clamp-1 max-w-xs">{{ $person->bio_id }}</div>
                            </td>

                            <!-- Category -->
                            <td class="px-6 py-4">
                                <span class="text-[10px] font-extrabold uppercase px-2.5 py-1 rounded-full border {{ $person->category_badge }}">
                                    {{ $person->category_label }}
                                </span>
                            </td>

                            <!-- Role -->
                            <td class="px-6 py-4 font-semibold text-gray-800">
                                <div>{{ $person->role_id }}</div>
                                @if($person->role_en)
                                    <div class="text-[10px] text-gray-400 font-normal italic">{{ $person->role_en }}</div>
                                @endif
                            </td>

                            <!-- Order -->
                            <td class="px-6 py-4 text-center font-bold text-gray-700">
                                {{ $person->sort_order }}
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4 text-center">
                                @if($person->is_active)
                                    <span class="bg-green-50 text-brand-green px-2 py-0.5 rounded-full text-[10px] font-bold border border-green-100 uppercase tracking-wider">Aktif</span>
                                @else
                                    <span class="bg-gray-100 text-gray-400 px-2 py-0.5 rounded-full text-[10px] font-bold border border-gray-200 uppercase tracking-wider">Nonaktif</span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('admin.people.edit', $person->id) }}" class="text-blue-600 hover:text-blue-800 font-bold inline-block">
                                    <i class="fas fa-edit mr-0.5"></i> Edit
                                </a>
                                <form action="{{ route('admin.people.destroy', $person->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus profil figur ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-bold ml-1">
                                        <i class="fas fa-trash-alt mr-0.5"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                                <i class="fas fa-users-slash text-3xl mb-2 text-gray-300 block"></i>
                                Belum ada data figur yang tersimpan. Klik tombol "Tambah Figur Baru" untuk menambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

