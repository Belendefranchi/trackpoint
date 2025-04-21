<div class="max-w-md mx-auto p-6 bg-white rounded-2xl shadow-lg">
    <h2 class="text-xl font-bold text-[#22265D] mb-4">Agregar Operador</h2>
    <form method="POST" action="">
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Nombre</label>
            <input type="text" name="nombre" required class="w-full mt-1 p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-[#00B0E6]">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" required class="w-full mt-1 p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-[#00B0E6]">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Rol</label>
            <input type="text" name="rol" required class="w-full mt-1 p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-[#00B0E6]">
        </div>
        <button type="submit" name="guardar" class="bg-[#22265D] text-white px-4 py-2 rounded-lg hover:bg-[#00B0E6] transition">Guardar</button>
    </form>
</div>
