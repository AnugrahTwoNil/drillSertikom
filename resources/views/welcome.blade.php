<!DOCTYPE html>
<html lang="id" class="scroll-smooth scroll-pt-20">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Workshop Sekolah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-[#FBF9F1]">

    <!-- Floating Login/Register Buttons -->
    <div class="fixed top-4 right-4 z-50 flex items-center gap-2">
        @auth
            <a href="{{ route('workshops.index') }}" class="bg-yellow-400 text-gray-900 px-4 py-2 rounded-lg font-bold text-sm hover:bg-yellow-300 transition whitespace-nowrap shadow-lg">Workshops</a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg font-bold text-sm hover:bg-gray-700 transition whitespace-nowrap cursor-pointer shadow-lg">
                    Log Out
                </button>
            </form>
        @else
            <a href="{{ route('register') }}" class="bg-white text-gray-800 border border-gray-300 px-4 py-2 rounded-lg font-bold text-sm hover:bg-gray-50 transition whitespace-nowrap shadow-lg">
                Daftar
            </a>
            <a href="{{ route('login') }}" class="bg-yellow-400 text-gray-900 px-4 py-2 rounded-lg font-bold text-sm hover:bg-yellow-300 transition whitespace-nowrap shadow-lg">
                Masuk
            </a>
        @endauth
    </div>

    <!-- Hero -->
    <main
        id="home"
        class="min-h-[500px] flex flex-col items-center justify-center text-center pt-15"
        style="
            background-color:hsla(48,30%,94%,1);
            background-image:
            radial-gradient(at 36% 16%, hsla(48,96%,53%,0.16) 0px, transparent 50%),
            radial-gradient(at 80% 100%, hsla(48,96%,53%,0.17) 0px, transparent 50%),
            radial-gradient(at 0% 0%, hsla(48,96%,53%,0.35) 0px, transparent 50%);
        "
    >
        <h1 class="text-[3rem] font-bold mb-3 text-gray-800 leading-tight">
            Ikuti Workshop<span class="text-yellow-500">TIX</span>
        </h1>
        <p class="text-gray-600 text-[18px] max-w-xl mb-6">
            Pilih workshop yang kamu minati, daftar, bayar lewat QR code, dan dapatkan tiket digitalmu dalam hitungan menit.
        </p>
        <a href="#cara-kerja" class="bg-gray-800 text-white px-6 py-3 rounded-lg font-bold text-sm hover:bg-gray-700 transition shadow-lg">
            Lihat Cara Kerja
        </a>
    </main>
    <div class="h-24 w-full bg-gradient-to-b from-transparent via-[#FBF9F1]/60 to-[#FBF9F1] -mt-24 relative"></div>

    <!-- Cara Kerja -->
    <div id="cara-kerja" class="max-w-6xl mx-auto px-4 mt-10">
        <h2 class="text-2xl font-bold text-gray-800 text-center mb-2">Cara Kerja</h2>
        <p class="text-gray-500 text-center mb-10">Empat langkah mudah untuk bergabung.</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            <div class="bg-white rounded-xl shadow-lg p-6 text-center transition hover:-translate-y-2 duration-300 ease-in-out">
                <div class="w-14 h-14 mx-auto mb-4 rounded-full bg-yellow-100 flex items-center justify-center">
                    <i class="fa-solid fa-magnifying-glass text-yellow-500 text-xl"></i>
                </div>
                <p class="text-xs font-bold text-yellow-500 uppercase tracking-wider mb-1">Langkah 1</p>
                <h3 class="text-gray-800 font-bold mb-2">Pilih Workshop</h3>
                <p class="text-gray-500 text-sm">Lihat daftar workshop IT yang tersedia dan pilih yang sesuai minatmu.</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 text-center transition hover:-translate-y-2 duration-300 ease-in-out">
                <div class="w-14 h-14 mx-auto mb-4 rounded-full bg-yellow-100 flex items-center justify-center">
                    <i class="fa-solid fa-user-plus text-yellow-500 text-xl"></i>
                </div>
                <p class="text-xs font-bold text-yellow-500 uppercase tracking-wider mb-1">Langkah 2</p>
                <h3 class="text-gray-800 font-bold mb-2">Daftar</h3>
                <p class="text-gray-500 text-sm">Masuk ke akunmu lalu klik daftar pada workshop yang kamu pilih.</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 text-center transition hover:-translate-y-2 duration-300 ease-in-out">
                <div class="w-14 h-14 mx-auto mb-4 rounded-full bg-yellow-100 flex items-center justify-center">
                    <i class="fa-solid fa-qrcode text-yellow-500 text-xl"></i>
                </div>
                <p class="text-xs font-bold text-yellow-500 uppercase tracking-wider mb-1">Langkah 3</p>
                <h3 class="text-gray-800 font-bold mb-2">Bayar via QR</h3>
                <p class="text-gray-500 text-sm">Scan QR code dengan aplikasi pembayaranmu. Prosesnya cepat dan aman.</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 text-center transition hover:-translate-y-2 duration-300 ease-in-out">
                <div class="w-14 h-14 mx-auto mb-4 rounded-full bg-yellow-100 flex items-center justify-center">
                    <i class="fa-solid fa-ticket text-yellow-500 text-xl"></i>
                </div>
                <p class="text-xs font-bold text-yellow-500 uppercase tracking-wider mb-1">Langkah 4</p>
                <h3 class="text-gray-800 font-bold mb-2">Dapat Tiket</h3>
                <p class="text-gray-500 text-sm">Setelah pembayaran terverifikasi, tiket digitalmu langsung muncul.</p>
            </div>
        </div>
    </div>

    <!-- CTA (only for guests) -->
    @guest
        <div class="max-w-6xl mx-auto px-4 mt-16 mb-20">
            <div class="bg-white/60 rounded-xl shadow-sm p-10 text-center">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Siap bergabung?</h2>
                <p class="text-gray-500 mb-6">Buat akun atau masuk untuk mulai memilih workshop.</p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('register') }}" class="bg-yellow-400 text-gray-900 px-6 py-3 rounded-lg font-bold text-sm hover:bg-yellow-300 transition">
                        Buat Akun
                    </a>
                    <a href="{{ route('login') }}" class="bg-gray-800 text-white px-6 py-3 rounded-lg font-bold text-sm hover:bg-gray-700 transition">
                        Masuk
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="mb-20"></div>
    @endguest

    <!-- Footer -->
    <div class="bg-gray-950 py-10">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <h1 class="text-white text-2xl font-extrabold mb-1">Workshop Sekolah<span class="text-yellow-400">.</span></h1>
            <p class="text-gray-400 text-sm">Ikuti workshop sekolah, jangan sampai terlewat.</p>
        </div>
    </div>

</body>
</html>