<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi - Yayasan LINTASAN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            green: '#007A48',
                            darkgreen: '#004D2E',
                            orange: '#F58220',
                            lightbg: '#F4F9F6'
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-brand-lightbg font-sans min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        <div class="p-8">
            <!-- Logo / Brand -->
            <div class="text-center mb-8">
                <img src="/images/logo-lintasan.png" alt="Yayasan LINTASAN" class="h-20 mx-auto mb-4 object-contain">
                <h1 class="text-xl font-extrabold text-gray-900 leading-tight">Lupa Kata Sandi</h1>
                <p class="text-xs text-gray-400 mt-1">Masukkan alamat email Anda untuk menerima tautan atur ulang kata sandi.</p>
            </div>

            @if(session('status'))
                <div class="bg-green-50 border border-green-200 text-brand-green p-3 rounded-lg text-xs font-semibold mb-4">
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('admin.password.email') }}" method="POST" class="space-y-5 text-xs">
                @csrf

                <div>
                    <label for="email" class="block font-bold text-gray-700 uppercase mb-2">Alamat Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" id="email" name="email" required value="{{ old('email') }}" class="w-full border border-gray-200 rounded-lg pl-10 pr-4 py-2.5 focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="official@lintasan.or.id">
                    </div>
                    @error('email') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-brand-green hover:bg-brand-darkgreen text-white font-bold py-3 rounded-lg shadow transition">
                        Kirim Tautan Atur Ulang <i class="fas fa-paper-plane ml-1"></i>
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-gray-50 border-t border-gray-150 px-8 py-4 text-center text-[10px] text-gray-400 flex justify-between items-center">
            <a href="{{ route('admin.login') }}" class="text-brand-green hover:underline font-bold"><i class="fas fa-arrow-left mr-1"></i> Kembali ke Login</a>
            <a href="/" class="text-gray-400 hover:underline">Portal Utama</a>
        </div>
    </div>

</body>
</html>
