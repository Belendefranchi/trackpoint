<!-- app/auth/views/login.view.php -->
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar Sesión</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#D3EBF9] min-h-screen flex items-center justify-center">

  <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-md">
    <div class="flex justify-center mb-6">
      <img src="/trackpoint/public/assets/images/logo_fondo_transparente.png" alt="Logo" class="h-20 opacity-80">
    </div>

    <h2 class="text-2xl font-bold text-[#22265D] text-center mb-6">Iniciar Sesión</h2>

    <form action="/login" method="POST" class="space-y-4">
      <div>
        <label class="block text-[#22265D] font-semibold mb-1" for="email">Correo electrónico</label>
        <input type="email" id="email" name="email" required
          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#00B0E6]">
      </div>

      <div>
        <label class="block text-[#22265D] font-semibold mb-1" for="password">Contraseña</label>
        <input type="password" id="password" name="password" required
          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#00B0E6]">
      </div>

      <button type="submit"
        class="w-full bg-[#22265D] text-white font-bold py-2 px-4 rounded-lg hover:bg-[#00B0E6] transition">
        Ingresar
      </button>
    </form>

    <p class="text-center text-sm mt-6">
      <a href="#" class="text-[#00B0E6] hover:underline">¿Olvidaste tu contraseña?</a>
    </p>

  </div>

</body>
</html>
