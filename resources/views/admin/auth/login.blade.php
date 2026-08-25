<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Yayasan LINTASAN</title>
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
                <h1 class="text-xl font-extrabold text-gray-900 leading-tight">CMS Admin Panel</h1>
                <p class="text-xs text-gray-400 mt-1">Masuk untuk mengelola data portal Yayasan LINTASAN</p>
            </div>

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-brand-green p-3 rounded-lg text-xs font-semibold mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-5 text-xs">
                @csrf

                <div>
                    <label for="email" class="block font-bold text-gray-700 uppercase mb-2">Alamat Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" id="email" name="email" required value="{{ old('email') }}" class="w-full border border-gray-200 rounded-lg pl-10 pr-4 py-2.5 focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="email@lintasan.org">
                    </div>
                    @error('email') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label for="password" class="block font-bold text-gray-700 uppercase">Kata Sandi</label>
                        <a href="{{ route('admin.password.request') }}" class="text-[10px] text-brand-green hover:underline font-semibold">Lupa Sandi?</a>
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" id="password" name="password" required class="w-full border border-gray-200 rounded-lg pl-10 pr-4 py-2.5 focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="••••••••">
                    </div>
                    @error('password') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember" class="h-4 w-4 rounded border-gray-300 text-brand-green focus:ring-brand-green">
                    <label for="remember" class="ml-2 block text-[11px] font-semibold text-gray-600">Ingat Saya</label>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-brand-green hover:bg-brand-darkgreen text-white font-bold py-3 rounded-lg shadow transition">
                        Masuk Panel <i class="fas fa-right-to-bracket ml-1"></i>
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-gray-50 border-t border-gray-150 px-8 py-4 text-center text-[10px] text-gray-400">
            Kembali ke <a href="/" class="text-brand-green hover:underline font-bold">Portal Utama</a>
        </div>
    </div>

</body>
</html>
