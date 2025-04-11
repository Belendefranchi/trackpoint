<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Registro de usuario</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#D3EBF9] min-h-screen flex items-center justify-center">
  
<div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-md">
    <div class="flex justify-center mb-6">
      <img src="/trackpoint/public/assets/images/logo_fondo_transparente.png" alt="Logo" class="h-20 opacity-80">
    </div>

    <h1 class="text-2xl font-bold text-center text-[#22265D] mb-4">Crear Usuario</h1>

    <form method="POST" action="/register">
      <div>
        <label class="block text-[#22265D] font-semibold mb-1" for="email">Nombre completo</label>
        <input type="text" id="nombre_completo" name="nombre_completo" required
          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#00B0E6]">
      </div>

      <div>
        <label class="block text-[#22265D] font-semibold mb-1" for="email">Email</label>
        <input type="email" id="email" name="email" required
          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#00B0E6]">
      </div>

      <div>
        <label class="block text-[#22265D] font-semibold mb-1" for="email">Usuario</label>
        <input type="text" id="username" name="username" required
          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#00B0E6]">
      </div>

      <div>
        <label class="block text-[#22265D] font-semibold mb-1" for="password">Contraseña</label>
        <input type="password" id="password" name="password" required
          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#00B0E6]">
      </div>
<!-- ------------------------------------------------------------------------------------------ -->
      <div>
        <label class="block text-[#22265D] font-semibold mb-1">Rol</label>
        <select name="rol" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#00B0E6]" required>
          <option value="">Seleccionar rol</option>
          <option value="admin">Administrador</option>
          <option value="operario">Operario</option>
          <option value="supervisor">Supervisor</option>
        </select>
      </div>
      <button type="submit"
        class="w-full bg-[#22265D] text-white font-bold mt-4 py-2 px-4 rounded-lg hover:bg-[#00B0E6] transition">Registrar</button>
    </form>

    <p class="text-center text-sm text-gray-500 mt-6">
      <a href="/trackpoint/public/login" class="text-[#00B0E6] hover:underline">¿Ya tenés cuenta? Iniciar sesión</a>
    </p>
  </div>
</body>
</html>
