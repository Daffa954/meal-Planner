<x-layout>
    @section('title', 'Daftar Anak - Meal Planner')
    <x-navbar-user></x-navbar-user>

    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex justify-between flex-wrap items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Profil Anak</h1>
                        <p class="text-gray-600 mt-2">Kelola profil anak untuk personalisasi meal plan</p>
                    </div>
                    <div class="flex space-x-3 mt-2">
                        <a href="{{ route('children.create') }}"
                            class="bg-[#4BA095] text-white px-6 py-3 rounded-lg hover:bg-[#3a887d] transition font-semibold flex items-center">
                            ➕ Tambah Anak
                        </a>
                        <a href="{{ route('dashboard') }}"
                            class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition font-semibold flex items-center">
                            ← Kembali
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow-sm border p-4 text-center">
                    <div class="text-2xl font-bold text-[#4BA095]">{{ $children->count() }}</div>
                    <div class="text-sm text-gray-600">Total Anak</div>
                </div>
                <div class="bg-white rounded-lg shadow-sm border p-4 text-center">
                    <div class="text-2xl font-bold text-[#7B5E3C]">
                        {{ $children->where('gender', 'male')->count() }}
                    </div>
                    <div class="text-sm text-gray-600">Anak Laki-laki</div>
                </div>
                <div class="bg-white rounded-lg shadow-sm border p-4 text-center">
                    <div class="text-2xl font-bold text-[#F5B947]">
                        {{ $children->where('gender', 'female')->count() }}
                    </div>
                    <div class="text-sm text-gray-600">Anak Perempuan</div>
                </div>
                <div class="bg-white rounded-lg shadow-sm border p-4 text-center">
                    <div class="text-2xl font-bold text-[#E76F51]">
                        {{ $children->filter(fn($child) => $child->preference)->count() }}
                    </div>
                    <div class="text-sm text-gray-600">Dengan Preferensi</div>
                </div>
            </div>

            <!-- Children Grid -->
            @if ($children->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($children as $child)
                        <div class="bg-white rounded-2xl shadow-sm border hover:shadow-md transition">
                            <!-- Header -->
                            <div class="bg-gradient-to-r from-[#4BA095] to-[#7B5E3C] rounded-t-2xl p-6 text-white">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-xl font-bold">{{ $child->name }}</h3>
                                        <p class="text-white/90 mt-1">
                                            {{ $child->age_years }} tahun {{ $child->age_months }} bulan •
                                            {{ $child->gender == 'male' ? '👦 Laki-laki' : '👧 Perempuan' }}
                                        </p>
                                    </div>
                                    <div class="text-3xl">
                                        {{ $child->gender == 'male' ? '👦' : '👧' }}
                                    </div>
                                </div>
                            </div>

                            <!-- Body -->
                            <div class="p-6">
                                <!-- Physical Info -->
                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                                        <div class="text-lg font-bold text-[#4BA095]">{{ $child->weight }} kg</div>
                                        <div class="text-xs text-gray-600">Berat Badan</div>
                                    </div>
                                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                                        <div class="text-lg font-bold text-[#7B5E3C]">{{ $child->height }} cm</div>
                                        <div class="text-xs text-gray-600">Tinggi Badan</div>
                                    </div>
                                </div>

                                <!-- Preference Info -->
                                @if ($child->preference)
                                    <div class="mb-4">
                                        <h4 class="font-semibold text-gray-900 text-sm mb-2">Preferensi Makanan:</h4>
                                        <div class="space-y-1 text-xs">
                                            @if ($child->preference->allergens)
                                                <div class="flex items-center">
                                                    <span class="text-red-500 mr-2">⚠️</span>
                                                    <span class="text-gray-600">
                                                        Alergi: {{ implode(', ', $child->preference->allergens) }}
                                                    </span>
                                                </div>
                                            @endif
                                            @if ($child->preference->favorite_foods)
                                                <div class="flex items-center">
                                                    <span class="text-green-500 mr-2">❤️</span>
                                                    <span class="text-gray-600">
                                                        Suka: {{ implode(', ', $child->preference->favorite_foods) }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div class="mb-4 p-3 bg-yellow-50 rounded-lg">
                                        <p class="text-yellow-800 text-sm text-center">
                                            ⚠️ Belum ada preferensi makanan
                                        </p>
                                    </div>
                                @endif

                                <!-- Action Buttons -->
                                <div class="flex space-x-2">
                                    <a href="{{ route('children.show', $child) }}"
                                        class="flex-1 bg-blue-500 text-white text-center py-2 rounded-lg hover:bg-blue-600 transition font-semibold text-sm">
                                        👁️ Detail
                                    </a>
                                    <a href="{{ route('children.edit', $child) }}"
                                        class="flex-1 bg-yellow-500 text-white text-center py-2 rounded-lg hover:bg-yellow-600 transition font-semibold text-sm">
                                        ✏️ Edit
                                    </a>
                                    <button onclick="deleteChild({{ $child->id }})"
                                        class="flex-1 bg-red-500 text-white py-2 rounded-lg hover:bg-red-600 transition font-semibold text-sm">
                                        🗑️ Hapus
                                    </button>
                                </div>

                                <!-- Quick Actions -->
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('meal-plans.create', ['child_id' => $child->id]) }}"
                                            class="flex-1 bg-[#7B5E3C] text-white text-center py-2 rounded-lg hover:bg-[#6a4f32] transition font-semibold text-xs">
                                            📅 Buat Plan
                                        </a>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-2xl shadow-sm border p-12 text-center">
                    <div class="text-gray-400 text-8xl mb-6">👶</div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Belum ada profil anak</h2>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">
                        Tambahkan profil anak untuk memulai membuat meal plan yang personalized sesuai kebutuhan anak
                        Anda.
                    </p>
                    <a href="{{ route('children.create') }}"
                        class="bg-[#4BA095] text-white px-8 py-3 rounded-lg hover:bg-[#3a887d] transition font-semibold inline-flex items-center text-lg">
                        👶 Tambah Anak Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>

    <script>
        function deleteChild(childId) {
            Swal.fire({
                title: 'Hapus Profil Anak?',
                text: "Data anak dan semua meal plan terkait akan dihapus permanen",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Menghapus...',
                        text: 'Sedang menghapus profil anak',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // AJAX request to delete child
                    fetch(`/children/${childId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => {
                            // Check if response is JSON
                            const contentType = response.headers.get('content-type');
                            if (contentType && contentType.includes('application/json')) {
                                return response.json();
                            } else {
                                // If not JSON, assume success for redirect
                                return {
                                    success: true,
                                    message: 'Profil anak berhasil dihapus!'
                                };
                            }
                        })
                        .then(data => {
                            Swal.close();

                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: data.message || 'Profil anak berhasil dihapus',
                                    confirmButtonColor: '#4BA095',
                                    timer: 1500
                                }).then(() => {
                                    // Reload page after success
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: data.message || 'Gagal menghapus profil anak',
                                    confirmButtonColor: '#4BA095'
                                });
                            }
                        })
                        .catch(error => {
                            Swal.close();
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Terjadi kesalahan saat menghapus profil anak',
                                confirmButtonColor: '#4BA095'
                            });
                        });
                }
            });
        }
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
                confirmButtonColor: '#4BA095'
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonColor: '#4BA095'
            });
        @endif
    </script>

</x-layout>

