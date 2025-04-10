<div class="flex gap-6">
  <form method="post" action="?module=recepcionMP&page=form" class="w-1/2 bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Recepción de Materia Prima</h2>

    <div class="mb-4">
      <label for="clasificacion" class="block font-medium">Clasificación:</label>
      <input type="text" id="clasificacion" name="clasificacion" class="w-full border rounded p-2" required />
    </div>

    <div class="mb-4">
      <label for="peso" class="block font-medium">Peso:</label>
      <input type="number" step="0.01" id="peso" name="peso" class="w-full border rounded p-2" required />
    </div>

    <div class="mb-4">
      <label for="tropa" class="block font-medium">Número de Tropa:</label>
      <input type="text" id="tropa" name="tropa" class="w-full border rounded p-2" required />
    </div>

    <div class="mb-4">
      <label for="origen" class="block font-medium">Origen:</label>
      <input type="text" id="origen" name="origen" class="w-full border rounded p-2" required />
    </div>

    <div class="mb-4">
      <label for="transporte" class="block font-medium">Transporte:</label>
      <input type="text" id="transporte" name="transporte" class="w-full border rounded p-2" required />
    </div>

    <div class="mb-4">
      <label for="remito" class="block font-medium">Remito:</label>
      <input type="text" id="remito" name="remito" class="w-full border rounded p-2" required />
    </div>

    <div class="mb-4">
      <label for="certificado" class="block font-medium">Certificado Sanitario:</label>
      <input type="text" id="certificado" name="certificado" class="w-full border rounded p-2" required />
    </div>

    <div class="mb-4">
      <label for="info_legal" class="block font-medium">Información Legal:</label>
      <textarea id="info_legal" name="info_legal" class="w-full border rounded p-2" rows="3" required></textarea>
    </div>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Guardar</button>
  </form>

  <!-- Panel derecho de registros (simulado) -->
  <aside class="w-1/2 bg-white p-6 rounded shadow overflow-y-auto max-h-[80vh]">
    <h2 class="text-xl font-semibold mb-4">Registros Ingresados</h2>
    <ul class="space-y-4">
      <li class="p-4 bg-gray-100 rounded shadow">
        <p><strong>Clasificación:</strong> Jamón</p>
        <p><strong>Peso:</strong> 135.60 kg</p>
        <p><strong>Tropa:</strong> TRP12345</p>
        <p><strong>Origen:</strong> Azul</p>
        <p><strong>Remito:</strong> RMT89012</p>
      </li>
    </ul>
  </aside>
</div>
