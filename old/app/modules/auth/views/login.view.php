<?php if (!empty($error)): ?>
  <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
    <?= htmlspecialchars($error) ?>
  </div>
<?php endif; ?>

<form method="POST" action="?module=auth&page=login" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 max-w-md mx-auto mt-20">
  <h2 class="text-2xl font-bold mb-6 text-center text-blue-900">Iniciar Sesión</h2>

  <div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
      Usuario
    </label>
    <input name="username" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight" required />
  </div>

  <div class="mb-6">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
      Contraseña
    </label>
    <input name="password" type="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight" required />
  </div>

  <div class="flex items-center justify-between">
    <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">
      Ingresar
    </button>
  </div>
</form>
