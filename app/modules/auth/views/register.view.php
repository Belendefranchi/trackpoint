<?php if (!empty($error)): ?>
  <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
    <?= htmlspecialchars($error) ?>
  </div>
<?php endif; ?>

<?php if (!empty($success)): ?>
  <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
    <?= htmlspecialchars($success) ?>
  </div>
<?php endif; ?>

<form method="POST" action="?module=auth&page=register" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 max-w-lg mx-auto mt-20">
  <h2 class="text-2xl font-bold mb-6 text-center text-blue-900">Registrar Nuevo Usuario</h2>

  <div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2">Nombre completo</label>
    <input name="nombre_completo" type="text" class="shadow border rounded w-full py-2 px-3 text-gray-700" required />
  </div>

  <div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2">Usuario</label>
    <input name="username" type="text" class="shadow border rounded w-full py-2 px-3 text-gray-700" required />
  </div>

  <div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2">Contraseña</label>
    <input name="password" type="password" class="shadow border rounded w-full py-2 px-3 text-gray-700" required />
  </div>

  <div class="mb-6">
    <label class="block text-gray-700 text-sm font-bold mb-2">Rol</label>
    <select name="rol" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
      <option value="">Seleccionar rol</option>
      <option value="admin">Administrador</option>
      <option value="operario">Operario</option>
      <option value="supervisor">Supervisor</option>
    </select>
  </div>

  <div class="flex items-center justify-between">
    <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">
      Registrar
    </button>
  </div>
</form>
