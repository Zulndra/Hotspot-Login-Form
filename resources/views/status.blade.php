{{-- resources/views/status.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Connection Status</title>

  {{-- Tambahkan meta anti-cache agar browser tidak menyimpan versi lama --}}
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="0">

  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">
</head>
<body class="min-h-screen flex items-center justify-center p-4 bg-gray-50">
  <div class="relative z-10 text-center bg-white p-6 rounded-2xl shadow-lg max-w-md w-full">
    <div class="flex flex-col items-center">
      <div class="w-16 h-16 rounded-full bg-green-500 flex items-center justify-center mb-4">
        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
      </div>
      <h1 class="text-2xl font-bold text-gray-800 mb-1">Connection Active</h1>
      <p class="text-sm text-gray-600 mb-4">You are connected to the internet</p>
    </div>

    <div class="space-y-3 mb-6">
      <div class="flex justify-between p-3 bg-gray-50 rounded-lg">
        <span class="text-gray-600">Username:</span>
        <span class="font-semibold text-gray-800">{{ session('username', 'Guest') }}</span>
      </div>
      <div class="flex justify-between p-3 bg-gray-50 rounded-lg">
        <span class="text-gray-600">IP Address:</span>
        <span class="font-semibold text-gray-800">{{ request()->ip() }}</span>
      </div>
      <div class="flex justify-between p-3 bg-gray-50 rounded-lg">
        <span class="text-gray-600">Status:</span>
        <span class="font-semibold text-green-600">Connected</span>
      </div>
    </div>

    <div class="space-y-2">
      <!-- tombol lanjut browsing — ubah sesuai kebutuhan -->
      <a href="http://example.com" class="block w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold">Continue Browsing</a>

      <!-- Logout: di produksi sebaiknya gunakan POST + CSRF; disini GET dipakai untuk testing -->
      <form method="GET" action="{{ route('logout') }}" class="mt-2">
        <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white py-3 rounded-lg font-semibold">Logout</button>
      </form>
    </div>
  </div>
</body>
</html>
