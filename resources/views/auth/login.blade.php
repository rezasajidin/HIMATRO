<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-50">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Login - Sekretariat Himatro</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>
<body class="h-full antialiased font-sans bg-gray-50">
  <div class="min-h-screen flex">
    <!-- Left: Image -->
    <div class="hidden lg:flex w-1/2 bg-cover bg-center" style="background-image: url('{{ asset('img/logo.jpg') }}')">
      
    </div>

    <!-- Right: Form -->
    <div class="flex-1 flex items-center justify-center px-6 py-12 lg:py-24">
      <div class="w-full max-w-md">
        <!-- Logo / Title -->
        <div class="mb-8 text-center">
          <img src="{{ asset('img/logo.jpg') }}" alt="Logo Himatro" class="mx-auto h-16 w-16 rounded-full object-cover mb-4">
          <h1 class="text-2xl font-semibold text-slate-800">Masuk ke Dashboard</h1>
          <p class="text-sm text-gray-500">Masukkan email dan password Anda</p>
        </div>

        <!-- Session status (sama seperti Breeze) -->
        @if (session('status'))
          <div class="mb-4 text-sm text-green-700 bg-green-100 border border-green-200 p-3 rounded">
            {{ session('status') }}
          </div>
        @endif

        <!-- Validation Errors (sama seperti Breeze) -->
        @if ($errors->any())
          <div class="mb-4 text-sm text-red-700 bg-red-100 border border-red-200 p-3 rounded">
            <ul class="list-disc pl-5">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <!-- Login form: uses route('login') and email field like Breeze -->
        <form method="POST" action="{{ route('login') }}" class="bg-white shadow-sm rounded-lg p-6 border">
          @csrf

          <!-- Email -->
          <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                   class="block w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-navy-500 focus:border-navy-500"
                   placeholder="you@example.com">
          </div>

          <!-- Password -->
          <div class="mb-4">
            <div class="flex justify-between items-center mb-1">
              <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
              @if (Route::has('password.request'))
                <a class="text-sm text-navy-600 hover:underline" href="{{ route('password.request') }}">Lupa password?</a>
              @endif
            </div>
            <input id="password" name="password" type="password" autocomplete="current-password" required
                   class="block w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-navy-500 focus:border-navy-500"
                   placeholder="Masukkan password">
          </div>

          <!-- Remember -->
          <div class="flex items-center mb-6">
            <input id="remember" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }} class="h-4 w-4 text-navy-600 focus:ring-navy-500 border-gray-300 rounded">
            <label for="remember" class="ml-2 block text-sm text-gray-600">Ingat saya</label>
          </div>

          <!-- Submit -->
          <div>
            <button type="submit"
                    class="w-full py-3 rounded-lg text-white font-semibold"
                    style="background-color:#08053e;">
              Masuk
            </button>
          </div>
        </form>

        <!-- Footer small note / register -->
        <p class="mt-6 text-center text-sm text-gray-500">
           username: admin@himatro.com, password: password123.
          @if (Route::has('register'))
            <br>
            Atau <a href="{{ route('register') }}" class="text-navy-600 hover:underline">daftar akun baru</a>.
          @endif
        </p>
      </div>
    </div>
  </div>

  <style>
    :root { --navy: #001f3f; }
    .focus\:ring-navy-500:focus { box-shadow: 0 0 0 4px rgba(0,31,63,0.12); outline: none; border-color: var(--navy); }
  </style>
</body>
</html>