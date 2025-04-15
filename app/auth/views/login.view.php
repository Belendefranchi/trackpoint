<?php
require_once __DIR__ . '/../../middleware/auth.middleware.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar Sesión</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" href="/trackpoint/public/assets/images/logo_fondo_transparente.png" type="image/x-icon">
  
  <?php
    require_once __DIR__ . '/../controllers/login.controller.php';
  ?>
</head>
<body class="bg-[#D3EBF9] min-h-screen flex items-center justify-center">

  <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-md">
    <div class="flex justify-center mb-6">
      <img src="/trackpoint/public/assets/images/logo_fondo_transparente.png" alt="Logo" class="h-20 opacity-80">
    </div>

    <h2 class="text-2xl font-bold text-[#22265D] text-center mb-6">Iniciar Sesión</h2>

    <form method="POST" class="space-y-4">
      <div>
        <label class="block text-[#22265D] font-semibold mb-1" for="email">Correo electrónico</label>
        <input type="text" id="email" name="email"
          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#00B0E6]">
      </div>

      <div>
        <label class="block text-[#22265D] font-semibold mb-1" for="password">Contraseña</label>
        <input type="password" id="password" name="password"
          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#00B0E6]">
      </div>

      
      <div class="text-center p-2">
        <?php
          if (isset($message)) {
        ?>

        <div class="block text-[#00B0E6]">
          <p><?php echo $message; ?></p>
        </div>

        <?php
          }
        ?>
      </div>

      <input type="submit"
        class="w-full bg-[#22265D] text-white font-bold py-2 px-4 rounded-lg hover:bg-[#00B0E6] transition" value='Ingresar'></input>
    </form>
    
    <div class="text-center text-sm text-gray-600 mt-4 space-y-1">
      <a href="/trackpoint/public/register" class="block text-[#00B0E6] font-medium hover:underline">¿No tenés una cuenta? Registrate</a>
      <a href="#" class="block text-[#00B0E6] hover:underline">¿Olvidaste tu contraseña?</a>
    </div>
  </div>
</body>
</html>
