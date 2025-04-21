<?php
require_once __DIR__ . '/../controllers/abm.operadores.controller.php';
?>

<div class="max-w-4xl mx-auto p-6 bg-white rounded-2xl shadow-lg mt-6">
    <h2 class="text-xl font-bold text-[#22265D] mb-4">Listado de Operadores</h2>
    <button type="button" name="actualizar" class="text-green-600 hover:underline">Nuevo operador</button>
    <table class="w-full table-auto border border-gray-300">
        <thead class="bg-[#D3EBF9] text-[#22265D]">
            <tr>
                <th class="p-2 border">ID</th>
                <th class="p-2 border">Nombre</th>
                <th class="p-2 border">Email</th>
                <th class="p-2 border">Rol</th>
                <th class="p-2 border">Fecha de creación</th>
                <th class="p-2 border">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($operadores as $operador): ?>
                <?php if (isset($_GET['editar']) && $_GET['editar'] == $operador['id']): ?>
                    <!-- Modo edición -->
                    <tr class="text-center border-t bg-gray-100">
                        <form method="POST">
                            <td class="p-2 border"><?= $operador['id'] ?></td>
                            <td class="p-2 border"><input type="text" name="nombre_completo" value="<?= $operador['nombre_completo'] ?>" required class="w-full p-1"></td>
                            <td class="p-2 border"><input type="email" name="email" value="<?= $operador['email'] ?>" required class="w-full p-1"></td>
                            <td class="p-2 border"><input type="text" name="rol" value="<?= $operador['rol'] ?>" required class="w-full p-1"></td>
                            <td class="p-2 border"><input type="text" name="fecha" value="<?= $operador['creado_en'] ?>" required class="w-full p-1"></td>
                            <td class="p-2 border">
                                <input type="hidden" name="id" value="<?= $operador['id'] ?>">
                                <input type="submit" name="actualizar" class="text-green-600 hover:underline">Guardar</input>
                                <a href="?" class="text-gray-500 hover:underline ml-2">Cancelar</a>
                            </td>
                        </form>
                    </tr>
                <?php else: ?>
                    <!-- Modo visual -->
                    <tr class="text-center border-t">
                        <td class="p-2 border"><?= $operador['id'] ?></td>
                        <td class="p-2 border"><?= htmlspecialchars($operador['nombre_completo']) ?></td>
                        <td class="p-2 border"><?= htmlspecialchars($operador['email']) ?></td>
                        <td class="p-2 border"><?= htmlspecialchars($operador['rol']) ?></td>
                        <td class="p-2 border"><?= htmlspecialchars($operador['creado_en']) ?></td>
                        <td class="p-2 border">
                            <p><a href="?editar=<?= $operador['id'] ?>" class="text-blue-600 hover:underline">Editar</a></p>
                            <p><a href="?eliminar=<?= $operador['id'] ?>" class="text-blue-600 hover:underline">Eliminar</a></p>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
