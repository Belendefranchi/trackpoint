<?php
return [
  [
    'id' => 'submenuRecetas',
    'titulo' => 'Recetas',
    'items' => [
      ['nombre' => 'Nueva Receta', 'url' => '/trackpoint/public/produccion/recetas/nuevaReceta'],
      ['nombre' => 'Recetas', 'url' => '/trackpoint/public/produccion/recetas/recetas'],
    ],
  ],
  [
    'id' => 'submenuPlanificacion',
    'titulo' => 'Planificación de la producción',
    'items' => [
      ['nombre' => 'Plan con Selección de Stock', 'url' => '/trackpoint/public/produccion/planificacion/planConSeleccion'],
      ['nombre' => 'Plan sin Selección de Stock', 'url' => '/trackpoint/public/produccion/planificacion/planSinSeleccion'],
    ],
  ],
  [
    'id' => 'submenuIngreso',
    'titulo' => 'Ingreso a producción',
    'items' => [
      ['nombre' => 'Plan con Selección de Stock', 'url' => '/trackpoint/public/produccion/ingreso/planConSeleccion'],
      ['nombre' => 'Plan sin Selección de Stock', 'url' => '/trackpoint/public/produccion/ingreso/planSinSeleccion'],
    ],
  ],
  [
    'id' => 'submenuEtqPrimarias',
    'titulo' => 'Emisión de Etiquetas Primarias',
    'items' => [
      ['nombre' => 'Plan con Selección de Stock', 'url' => '/trackpoint/public/produccion/etqPrimarias/planConSeleccion'],
      ['nombre' => 'Plan sin Selección de Stock', 'url' => '/trackpoint/public/produccion/etqPrimarias/planSinSeleccion'],
    ],
  ],
  [
    'id' => 'submenuEtqSecundarias',
    'titulo' => 'Emisión de Etiquetas Secundarias',
    'items' => [
      ['nombre' => 'Plan con Selección de Stock', 'url' => '/trackpoint/public/produccion/etqSecundarias/planConSeleccion'],
      ['nombre' => 'Plan sin Selección de Stock', 'url' => '/trackpoint/public/produccion/etqSecundarias/planSinSeleccion'],
    ],
  ],
];
