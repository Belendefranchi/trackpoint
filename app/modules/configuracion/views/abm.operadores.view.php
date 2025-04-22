<?php
require_once __DIR__ . '/../controllers/abm.operadores.controller.php';
?>

<div class="bg-white rounded-2xl shadow-lg mt-2 p-4">
    <h2 class="text-xl font-bold text-[#22265D] m-4">Operadores</h2>
    <button type="button" name="crear" class="btn btn-primary btn-sm fw-bold hover:underline ms-4">Nuevo operador</button>
    <table class="m-4">
        <thead class="table-primary">
            <tr class="text-center text-light table-primary">
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
                    <form method="POST" action="/trackpoint/public/index.php?route=/configuracion/ABMs/operadores&editar=<?= $operador['id'] ?>">
                        <tr id="fila<?= $operador['id'] ?>" class="text-center border-t bg-gray-100">
                            <td class="p-2 border"><?= $operador['id'] ?></td>
                            <td class="p-2 border">
                                <input type="text" name="nombre_completo" value="<?= htmlspecialchars($operador['nombre_completo']) ?>" required class="w-full p-1">
                            </td>
                            <td class="p-2 border">
                                <input type="email" name="email" value="<?= htmlspecialchars($operador['email']) ?>" required class="w-full p-1">
                            </td>
                            <td class="p-2 border">
                                <input type="text" name="rol" value="<?= htmlspecialchars($operador['rol']) ?>" required class="w-full p-1">
                            </td>
                            <td class="p-2 border">
                                <input type="text" name="creado_en" value="<?= htmlspecialchars($operador['creado_en']) ?>" readonly class="w-full p-1">
                            </td>
                            <td class="p-2 border">
                                <input type="hidden" name="id" value="<?= $operador['id'] ?>">
                                <input type="submit" name="editar" class="btn btn-sm btn-success" value="Aceptar">
                                <a href="index.php?route=/configuracion/ABMs/operadores#fila<?= $operador['id'] //si hay muchas filas, al cancelar vuelve a la fila donde estaba?>" class="btn btn-sm btn-secondary">Cancelar</a>
                            </td>
                        </tr>
                    </form>
                <?php else: ?>
                    <!-- Modo visual -->
                    <tr class="text-center border-t">
                        <td class="p-2 border"><?= $operador['id'] ?></td>
                        <td class="p-2 border"><?= htmlspecialchars($operador['nombre_completo']) ?></td>
                        <td class="p-2 border"><?= htmlspecialchars($operador['email']) ?></td>
                        <td class="p-2 border"><?= htmlspecialchars($operador['rol']) ?></td>
                        <td class="p-2 border"><?= htmlspecialchars($operador['creado_en']) ?></td>
                        <td class="p-2 border">
                            <form method="POST" action="/trackpoint/public/index.php?route=/configuracion/ABMs/operadores&eliminar=<?= $operador['id'] ?>">
                                <a href="/trackpoint/public/index.php?route=/configuracion/ABMs/operadores&editar=<?= $operador['id'] ?>" class="btn btn-sm btn-warning ms-2">Editar</a>
                                <input type="hidden" name="id" value="<?= $operador['id'] ?>">
                                <input type="submit" name="eliminar" class="btn btn-sm btn-danger ms-2" value="Eliminar">
                            </form>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
            </tbody>

    </table>
</div>
