<x-layout>
    <header class="w-full relative">
        <!-- Navbar with glassmorphism effect -->
        <div class="fixed w-full z-50 backdrop-blur-md bg-white/30 shadow-sm">
            @include('components.navbar')
        </div>

        <!-- Hero section -->
        <div class="w-full h-screen flex items-center justify-center p-4 relative"
            style="background-image: url('{{ asset('images/bg-dapur.png') }}'); background-size: cover; background-position: center;">
            <!-- Overlay -->
            <div class="absolute inset-0 bg-black/20"></div>

            <!-- Content with glassmorphism -->
            <div
                class="max-w-4xl text-center backdrop-blur-sm bg-[#b8b8b89d] p-12 rounded-3xl border border-white/20 shadow-xl z-10 mx-4">
                <h1 class="text-6xl md:text-7xl text-[#FCD47F] font-bold leading-tight mb-4">
                    Meal Planner
                </h1>
                <h2 class="text-3xl md:text-4xl text-white font-bold leading-tight mb-6 drop-shadow-md">
                    Rencana Makan Sehat untuk Anak, Sesuai Selera, Kebutuhan, dan
                    Kesehatan Anak!
                </h2>
                <p class="mt-4 text-white text-xl md:text-2xl font-medium drop-shadow-md">
                    Dibantu AI Deepseek untuk mendapatkan resep yang sesuai untuk Anak
                    Anda
                </p>
                <div class="mt-8 flex flex-col sm:flex-row justify-center gap-4">
                    <a href="/ask"
                        class="bg-[#7B5E3C] text-white px-8 py-3 rounded-lg hover:bg-[#9C7248] transition-all shadow-lg hover:shadow-xl">
                        Coba Gratis
                    </a>
                    <button
                        class="bg-white/10 backdrop-blur-sm border border-white/20 text-white px-6 py-3 rounded-lg hover:bg-white/20 transition-all shadow-sm">
                        Detail harga
                    </button>
                </div>
            </div>
        </div>
    </header>

    <main class="md:px-28 px-10 py-10 space-y-8">
      
        <!-- about -->
        <section class="w-full py-16 bg-white">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="text-center mb-12">
                    <h1 class="text-4xl md:text-5xl font-extrabold text-[#4BA095] mb-6">
                        About Our Product
                    </h1>
                    <p class="text-xl leading-relaxed text-gray-700 max-w-4xl mx-auto">
                        Kami percaya setiap anak berhak mendapatkan makanan sehat dan
                        aman, apapun kondisi dan keterbatasan bahan di rumah. Dengan
                        teknologi AI, kami bantu orang tua menyusun menu harian yang
                        sesuai dengan usia, alergi, dan bahan lokal — tanpa repot, tanpa
                        bingung.
                    </p>
                </div>

                <!-- Features Section -->
                <div class="mt-12">
                    <h2 class="text-3xl font-bold text-center text-[#4BA095] mb-8">
                        Fitur Utama
                    </h2>

                    <div class="grid md:grid-cols-2 gap-6 max-w-4xl mx-auto">
                        <!-- Feature 1 -->
                        <div
                            class="bg-[#4BA095] text-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-shadow">
                            <div class="flex items-start gap-4">
                                <div class="text-2xl flex-shrink-0">🎯</div>
                                <div>
                                    <h3 class="font-bold text-lg mb-2">Personalisasi Resep</h3>
                                    <p class="text-white/90">
                                        Sesuai usia anak, lokasi, alergi, dan bahan yang tersedia.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Feature 2 -->
                        <div
                            class="bg-[#4BA095] text-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-shadow">
                            <div class="flex items-start gap-4">
                                <div class="text-2xl flex-shrink-0">🛡️</div>
                                <div>
                                    <h3 class="font-bold text-lg mb-2">Keamanan Pangan</h3>
                                    <p class="text-white/90">
                                        Menghindari bahan yang menyebabkan alergi.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Feature 3 -->
                        <div
                            class="bg-[#4BA095] text-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-shadow">
                            <div class="flex items-start gap-4">
                                <div class="text-2xl flex-shrink-0">🥬</div>
                                <div>
                                    <h3 class="font-bold text-lg mb-2">Gunakan Bahan Yang Ada</h3>
                                    <p class="text-white/90">
                                        Menyesuaikan dengan ketersediaan bahan pengguna.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Feature 4 -->
                        <div
                            class="bg-[#4BA095] text-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-shadow">
                            <div class="flex items-start gap-4">
                                <div class="text-2xl flex-shrink-0">⚡</div>
                                <div>
                                    <h3 class="font-bold text-lg mb-2">Cepat & Praktis</h3>
                                    <p class="text-white/90">
                                        Resep langsung jadi tanpa perlu browsing berjam-jam.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- alasan mengapa menggunakan -->
        <section class="w-full bg-[#4BA095] py-8 md:px-6 px-3 text-white rounded-3xl shadow-lg">
            <div class="text-center w-full px-3">
                <h1 class="text-4xl font-bold">
                    Kenapa Harus Menggunakan Meal Planner
                </h1>
                <p class="text-xl mt-4">
                    Temukan berbagai resep dengan bahan yang mudah ditemukan dan
                    sesuai dengan kebutuhan gizi anak Anda
                </p>
            </div>
            <div class="flex lg:flex-row flex-col mt-8 w-full justify-between px-6 gap-4">
                <div class="w-full lg:w-[50%]">
                    @foreach ($whyChooses as $item)
                        @include('components.card-why', $item)
                    @endforeach
                </div>
                <div class="w-full lg:w-[45%] flex items-center justify-center">
                    <img src="{{ asset('images/aset2Compress.jpg') }}" alt="gambar" class="rounded-2xl shadow-xl" />
                </div>
            </div>
        </section>

        <!-- our teams -->
        <section class="w-full py-16 text-gray-700 flex flex-col items-center">
            <h1 class="text-4xl md:text-5xl font-extrabold text-[#4BA095] mb-12">
                Meet Our Team
            </h1>
            <!-- card container -->
            <div class="w-full flex-wrap flex gap-6 justify-center">
                @foreach ($teams as $team)
                    <x-team-card :title="$team['name']" :description="$team['role']" :image="$team['image']" />
                @endforeach
            </div>
        </section>


    </main>

    <x-footer></x-footer>
</x-layout>
