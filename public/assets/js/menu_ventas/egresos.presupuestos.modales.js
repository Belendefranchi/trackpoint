/* window.addEventListener('load', function () {
  localStorage.removeItem('presupuestoSeleccionado');
}); */

// --- VARIABLES GLOBALES ---
let presupuestoSeleccionado = null;

document.addEventListener('DOMContentLoaded', function () {

  /* ###################### MODAL DE CREACIÓN DE PRESUPUESTOS ###################### */

  // Interceptar el envío del formulario con AJAX
  const formCrear = document.querySelector('#formCrearPresupuesto');
  if (formCrear) {
    formCrear.addEventListener('submit', function (e) {
      e.preventDefault();

      // Limpiar cualquier mensaje de error antes de hacer la solicitud
      $('#mensaje-error-crear').addClass('d-none').find('.mensaje-texto').text('');

      const formData = new FormData(this);

      $.ajax({
        url: '/trackpoint/public/index.php?route=/ventas/egresos/presupuestos&crearPresupuesto',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
          console.log('Respuesta del servidor:', response);

          if (response.success) {
            console.log('Presupuesto creado con éxito:', response.message);

            /* const tabla = $('#miTablaResumen').DataTable();
            localStorage.setItem('paginaPresupuestos', tabla.page()); */

            location.reload();
          } else {
            console.log('Error al crear el presupuesto:', response.message);
            $('#mensaje-error-crear').removeClass('d-none').find('.mensaje-texto').text(response.message);
          }
        },
        error: function (xhr, status, error) {
          console.log('Error al guardar los datos');
          console.log('Código de estado:', xhr.status);
          console.log('Mensaje de error:', error);
          console.log('Respuesta del servidor:', xhr.responseText);
          $('#mensaje-error-crear').removeClass('d-none').find('.mensaje-texto').text('Hubo un error al intentar guardar los datos.');
        }
      });
    });
  }

  // Limpiar el mensaje de error al cerrar el modal
  var modalCrearPresupuesto = document.getElementById('modalCrearPresupuesto');
  modalCrearPresupuesto.addEventListener('hidden.bs.modal', function () {
    var mensajeError = document.getElementById('mensaje-error-crear');
    if (mensajeError) {
      mensajeError.classList.add('d-none'); // Ocultar el div
      mensajeError.querySelector('.mensaje-texto').textContent = ''; // Limpiar el texto
    }
  });


  /* ###################### SELECCIÓN DE PRESUPUESTO ###################### */

  // --- SELECCIONAR PRESUPUESTO ---
  let presupuestoSeleccionado = null;

  // --- MANEJO DE SELECCIÓN (DELEGACIÓN) ---
  document.addEventListener('click', function (event) {

    const card = event.target.closest('.tabla-card');
    if (!card) return;

    // Evitar clicks en elementos interactivos internos
    if (event.target.closest('a, button')) return;

    const radio = card.querySelector('.seleccionar-presupuesto');
    if (!radio) return;

    // Marcar radio
    radio.checked = true;

    // Obtener ID
    const presupuestoId = radio.dataset.presupuestoid;
    const listaPrecioId = radio.dataset.listaid;
    if (!presupuestoId) return;

    presupuestoSeleccionado = presupuestoId;
    listaPrecioSeleccionada = listaPrecioId;

    console.log('Presupuesto seleccionado:', presupuestoSeleccionado);
    console.log('Lista de precios seleccionada:', listaPrecioSeleccionada);

    // Activar botón "Agregar" del formulario superior
    const btnGuardar = document.getElementById('btn-guardar-mercaderia');
    if (btnGuardar) {
      btnGuardar.disabled = false;
    }

    // Sincronizar con form
    const inputPresupuesto = document.getElementById('presupuesto_id');
    const inputLista = document.getElementById('lista_id');

    if (inputPresupuesto && presupuestoId) {
      inputPresupuesto.value = presupuestoId;
    }

    if (inputLista && listaPrecioId) {
      inputLista.value = listaPrecioId;
    }

    // UI selección
    document.querySelectorAll('.tabla-card.selected-row')
      .forEach(c => c.classList.remove('selected-row'));

    card.classList.add('selected-row');

    actualizarEtiquetaPresupuesto();
  });

  // --- ACTUALIZAR ETIQUETA ---
  function actualizarEtiquetaPresupuesto() {
    const etiqueta = document.getElementById('presupuestoActivo');
    if (etiqueta && presupuestoSeleccionado) {
      etiqueta.textContent = `Presupuesto Nº: ${presupuestoSeleccionado}`;
    }
  }

  document.getElementById('btn-guardar-mercaderia').disabled = false;

  // --- RESTAURAR SELECCIÓN DESPUÉS DE AJAX ---
  function restaurarSeleccionPresupuesto() {
    if (!presupuestoSeleccionado) return;

    const radio = document.querySelector(
      `.seleccionar-presupuesto[data-presupuestoid="${presupuestoSeleccionado}"]`
    );

    if (radio) {
      radio.checked = true;

      const card = radio.closest('.tabla-card');
      if (card) {
        card.classList.add('selected-row');
      }
    }

    // mantener sincronizado el form
    const inputHidden = document.getElementById('presupuesto_id');
    if (inputHidden) {
      inputHidden.value = presupuestoSeleccionado;
    }

    actualizarEtiquetaPresupuesto();
  }

  function actualizarEtiquetaPresupuesto() {
    /*     let id = localStorage.getItem('presupuestoSeleccionado');
        if (!id) return; */

    let etiqueta = document.getElementById('presupuestoActivo');
    if (etiqueta) {
      etiqueta.textContent = `Presupuesto Nº: ${presupuestoSeleccionado}`;
    }
  }

  function recargarDetalle(presupuesto_id) {
    console.count('recargarDetalle llamado');

    $.ajax({
      url: "/trackpoint/public/index.php?route=/ventas/egresos/presupuestos&actualizarDetalle",
      type: "POST",
      data: { presupuesto_id },
      dataType: "json",

      success: function (response) {
        if (response.success) {
          $("#detalle-presupuesto").html(response.html);
          restaurarSeleccionPresupuesto();
        } else {
          console.error(response.message);
        }
      },
      error: function () {
        alert("Error al obtener el detalle del presupuesto");
      }
    });
  }

  function recargarResumen(presupuesto_id) {
    $.ajax({
      url: "/trackpoint/public/index.php?route=/ventas/egresos/presupuestos&actualizarResumen",
      type: "POST",
      data: { presupuesto_id },
      dataType: "json",
      success: function (response) {
        if (response.success) {
          $("#resumen-presupuesto").html(response.html);
          restaurarSeleccionPresupuesto();
        } else {
          console.error(response.message);
        }
      },
      error: function () {
        alert("Error al obtener el resumen del presupuesto");
      }
    });
  }

  // --- CARGAR DETALLE DEL PRESUPUESTO SELECCIONADO ---
  $(document).ready(function () {

    // Detectar apertura de la pestaña DETALLE
    $('a[data-bs-toggle="tab"][href="#detalle"]').on('shown.bs.tab', function () {

      let seleccionado = document.querySelector('input[name="seleccion_presupuesto"]:checked');
      let presupuesto_id = seleccionado?.getAttribute('data-presupuestoid') ?? null;

      console.log(presupuesto_id);
      if (!presupuesto_id) {
        console.warn("No hay presupuesto seleccionado");
        return;
      }
      recargarDetalle(presupuesto_id);
    });
  });

  // --- PREVENIR ENVÍO SIN PRESUPUESTO SELECCIONADO ---
  document.getElementById('formAgregarMercaderia').addEventListener('submit', function (e) {
    if (!presupuestoSeleccionado) {
      e.preventDefault();
      alert('Primero seleccioná un presupuesto en la tabla inferior antes de agregar mercaderías.');
      return;
    }

    // Opcional: mostrar en consola los datos que van al servidor
    const formData = new FormData(this);
    console.log('Datos enviados:', Object.fromEntries(formData));
  });

  // --- BOTÓN "VACIAR" ---
  document.getElementById('btn-vaciar-mercaderia').addEventListener('click', function () {
    document.getElementById('codigo_mercaderia').value = '';
    document.getElementById('mercaderia_id').value = '';
    document.getElementById('descripcion_mercaderia').value = '';
    document.getElementById('cantidad').value = 1;
    document.getElementById('precio_venta').value = 1;
  });

  // --- DESHABILITAR "AGREGAR" HASTA QUE HAYA UN PRESUPUESTO SELECCIONADO ---
  document.getElementById('btn-guardar-mercaderia').disabled = true;



  /* ###################### GENERAR PRESUPUESTO ###################### */
  document.getElementById('btnMostrarGenerarPresupuesto').addEventListener('click', function () {
    const modal = new bootstrap.Modal(document.getElementById('modalGenerarPresupuesto'));
    modal.show();
  });

  const btnConfirmarGenerar = document.getElementById('btnConfirmarGenerar');
  if (btnConfirmarGenerar) {
    btnConfirmarGenerar.addEventListener('click', function () {
      bootstrap.Modal.getInstance(document.getElementById('modalGenerarPresupuesto')).hide();

      $.ajax({
        url: '/trackpoint/public/index.php?route=/ventas/egresos/presupuestos&generarPresupuesto',
        type: 'POST',
        data: { 'presupuesto_id': document.getElementById('generarPresupuestoId').value },
        dataType: 'json',
        success: function (response) {
          if (response.success) {
            console.log(response)
            $('#modalMensajeLabel').text('Presupuesto generado');
            $('#textoModalMensaje').text('El presupuesto fue generado correctamente.');
          } else {
            $('#modalMensajeLabel').text('Error al generar');
            $('#textoModalMensaje').text(response.message || 'Ocurrió un error inesperado.');
          }

          const modalMensaje = new bootstrap.Modal(document.getElementById('modalMensajePresupuesto'));
          modalMensaje.show();

          // Esperar a que el modal se cierre para recargar
          const modalElement = document.getElementById('modalMensajePresupuesto');
          modalElement.addEventListener('hidden.bs.modal', function () {
            window.open(
              '/trackpoint/public/index.php?route=/ventas/egresos/presupuestos&previewPresupuesto&id=' + response.presupuesto_id,
              '_blank'
            );

            // opcional: refrescar la pantalla actual
            location.reload();
          }, { once: true });

        },
        error: function (xhr, status, error) {
          console.log('Error al guardar los datos');
          console.log('Código de estado:', xhr.status);
          console.log('Mensaje de error:', error);
          console.log('Respuesta del servidor:', xhr.responseText);
          $('#modalMensajeLabel').text('Error inesperado');
          $('#textoModalMensaje').text('Hubo un problema al intentar guardar los datos.');
          const modalMensaje = new bootstrap.Modal(document.getElementById('modalMensajePresupuesto'));
          modalMensaje.show();
        }
      });
    });
  }


  /* ###################### MODAL DE EDICIÓN PRESUPUESTO ###################### */

  // Interceptar el envío del formulario con AJAX
  const formEditarPresupuesto = document.querySelector('#formEditarPresupuesto');
  if (formEditarPresupuesto) {
    formEditarPresupuesto.addEventListener('submit', function (e) {
      e.preventDefault();

      // Limpiar cualquier mensaje de error antes de hacer la solicitud
      $('#mensaje-error-editar').addClass('d-none').find('.mensaje-texto').text('');

      const formData = new FormData(this);

      $.ajax({
        url: '/trackpoint/public/index.php?route=/ventas/egresos/presupuestos&editarPresupuesto',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
          console.log('Respuesta del servidor:', response);

          if (response.success) {
            console.log('Presupuesto modificado con éxito');

            /* const tabla = $('#miTablaResumen').DataTable();
            localStorage.setItem('paginaPresupuestos', tabla.page()); */

            location.reload();
          } else {
            console.log('Error al modificar el presupuesto:', response.message);
            $('#mensaje-error-editar').removeClass('d-none').find('.mensaje-texto').text(response.message);
          }
        },
        error: function (xhr, status, error) {
          console.log('Error al guardar los datos');
          console.log('Código de estado:', status);
          console.log('Mensaje de error:', error);
          console.log('Respuesta del servidor:', xhr.responseText);
          $('#mensaje-error-editar').removeClass('d-none').find('.mensaje-texto').text('Hubo un error al intentar guardar los datos.');
        }
      });
    });
  }

  // Limpiar el mensaje de error al cerrar el modal
  var modalEditarPresupuesto = document.getElementById('modalEditarPresupuesto');
  if (modalEditarPresupuesto) {
    modalEditarPresupuesto.addEventListener('hidden.bs.modal', function () {
      var mensajeError = document.getElementById('mensaje-error-editar');
      if (mensajeError) {
        mensajeError.classList.add('d-none'); // Ocultar el div
        mensajeError.querySelector('.mensaje-texto').textContent = ''; // Limpiar el texto
      }
    });
  }


  /* ###################### ELIMINAR PRESUPUESTO ###################### */
  const btnConfirmarEliminar = document.getElementById('btnConfirmarEliminar');
  if (btnConfirmarEliminar) {
    btnConfirmarEliminar.addEventListener('click', function () {
      bootstrap.Modal.getInstance(document.getElementById('modalEliminarPresupuesto')).hide();

      $.ajax({
        url: '/trackpoint/public/index.php?route=/ventas/egresos/presupuestos&eliminarPresupuesto',
        type: 'POST',
        data: { 'presupuesto_id': document.getElementById('eliminarPresupuestoId').value },
        dataType: 'json',
        success: function (response) {
          if (response.success) {
            console.log(response)
            $('#modalMensajeLabel').text('Presupuesto cancelado');
            $('#textoModalMensaje').text('El presupuesto fue cancelado correctamente.');
          } else {
            $('#modalMensajeLabel').text('Error al cancelar');
            $('#textoModalMensaje').text(response.message || 'Ocurrió un error inesperado.');
          }

          const modalMensaje = new bootstrap.Modal(document.getElementById('modalMensajePresupuesto'));
          modalMensaje.show();

          // Esperar a que el modal se cierre para recargar
          const modalElement = document.getElementById('modalMensajePresupuesto');
          modalElement.addEventListener('hidden.bs.modal', function () {
            location.reload();
          }, { once: true });

        },
        error: function (xhr, status, error) {
          console.log('Error al guardar los datos');
          console.log('Código de estado:', xhr.status);
          console.log('Mensaje de error:', error);
          console.log('Respuesta del servidor:', xhr.responseText);
          $('#modalMensajeLabel').text('Error inesperado');
          $('#textoModalMensaje').text('Hubo un problema al intentar eliminar el presupuesto.');
          const modalMensaje = new bootstrap.Modal(document.getElementById('modalMensajePresupuesto'));
          modalMensaje.show();
        }
      });
    });
  }


  /* ###################### INPUT BÚSQUEDA POR CÓDIGO ###################### */
  const inputMercaderiaIdBusqueda = document.getElementById('mercaderia_id');
  const inputCodigoBusqueda = document.getElementById('codigo_mercaderia');
  const inputDescripcionBusqueda = document.getElementById('descripcion_mercaderia');
  const inputPrecioCompraBusqueda = document.getElementById('precio_compra_mercaderia');
  const inputPrecioVentaBusqueda = document.getElementById('precio_venta_mercaderia');
  const mensajeBusqueda = document.getElementById('mensaje-busqueda');

  function buscarMercaderiaPorCodigo(codigo) {
    return $.ajax({
      url: '/trackpoint/public/index.php?route=/ventas/egresos/presupuestos&seleccionarCodigoMercaderia',
      method: 'POST',
      data: { codigo_mercaderia: codigo },
      dataType: 'json'
    });
  }

  inputCodigoBusqueda.addEventListener('keyup', function () {
    const codigo = this.value.trim();

    if (codigo.length < 2) return;

    buscarMercaderiaPorCodigo(codigo)
      .done(function (response) {
        if (response.success) {
          inputMercaderiaIdBusqueda.value = response.mercaderia_id;
          inputCodigoBusqueda.value = response.codigo_mercaderia;
          inputDescripcionBusqueda.value = response.descripcion_mercaderia;
          inputPrecioCompraBusqueda.value = response.precio_compra_mercaderia;
          inputPrecioVentaBusqueda.value = response.precio_venta_mercaderia;
          mensajeBusqueda.classList.add('d-none');
        } else {
          inputMercaderiaIdBusqueda.value = '';
          $('#mensaje-busqueda').removeClass('d-none')
            .find('.mensaje-texto').text(response.message);
        }
      })
      .fail(function () {
        inputMercaderiaIdBusqueda.value = '';
        inputCodigoBusqueda.value = '';
        inputDescripcionBusqueda.value = '';
        inputPrecioCompraBusqueda.value = '';
        inputPrecioVentaBusqueda.value = '';
        $('#mensaje-busqueda').removeClass('d-none')
          .find('.mensaje-texto').text('Error de conexión al buscar la mercadería.');
      });
  });


  /* ###################### MODAL BUSQUEDA POR DESCRIPCIÓN ###################### */
  var modalSeleccionar = document.getElementById('modalSeleccionarMercaderia');
  var mensajeErrorSeleccionar = document.getElementById('mensaje-error-seleccionar');

  if (modalSeleccionar) {

    // Listener para cargar mercaderías al abrir el modal
    modalSeleccionar.addEventListener('show.bs.modal', function () {

      // Validación base
      if (!presupuestoSeleccionado || !listaPrecioSeleccionada) {
        mensajeErrorSeleccionar.classList.remove('d-none');
        mensajeErrorSeleccionar.querySelector('.mensaje-texto').textContent =
          'Debe seleccionar un presupuesto con lista de precios.';
        return;
      }

      // Mostrar estado de carga
      const tbody = document.querySelector('#miTablaEnModalMercaderia tbody');
      tbody.innerHTML = `<tr><td colspan="6" class="text-center">Cargando...</td></tr>`;

      console.log('listaPrecioSeleccionada:', listaPrecioSeleccionada);

      // AJAX
      $.ajax({
        url: '/trackpoint/public/index.php?route=/ventas/egresos/presupuestos&renderizarMercaderia',
        method: 'POST',
        data: {
          lista_id: listaPrecioSeleccionada
        },
        dataType: 'json',
        success: function (response) {

          if (!response.success) {
            tbody.innerHTML = `<tr><td colspan="6" class="text-center">${response.message}</td></tr>`;
            return;
          }

          renderTablaMercaderias(response.data);
        },
        error: function (xhr, status, error) {
          console.log('STATUS:', status);
          console.log('ERROR:', error);
          console.log('RESPONSE:', xhr.responseText);

          tbody.innerHTML = `<tr><td colspan="6">Error al cargar</td></tr>`;
        }
      });

    });

    // Listener para vaciar selección cuando se cierra el modal
    modalSeleccionar.addEventListener('hidden.bs.modal', function () {
      // Limpia el mensaje de error
      if (mensajeErrorSeleccionar) {
        mensajeErrorSeleccionar.classList.add('d-none');
        mensajeErrorSeleccionar.querySelector('.mensaje-texto').textContent = '';
      }
      // Limpia los inputs hidden del modal
      modalSeleccionar.querySelector('#input-mercaderia-id').value = '';
      modalSeleccionar.querySelector('#input-codigo-mercaderia').value = '';
      modalSeleccionar.querySelector('#input-descripcion-mercaderia').value = '';
      modalSeleccionar.querySelector('#input-precio-compra-mercaderia').value = '';
      modalSeleccionar.querySelector('#input-precio-venta-mercaderia').value = '';

    });

    const inputMercaderiaIdModal = document.getElementById('mercaderia_id');
    const inputCodigoModal = document.getElementById('codigo_mercaderia');
    const inputDescripcionModal = document.getElementById('descripcion_mercaderia');
    const inputPrecioCompraModal = document.getElementById('precio_compra_mercaderia');
    const inputPrecioVentaModal = document.getElementById('precio_venta_mercaderia');


    // Enviar formulario con AJAX para seleccionar mercadería
    const formSeleccionar = document.getElementById('formSeleccionarMercaderia');
    if (formSeleccionar) {
      formSeleccionar.addEventListener('submit', function (e) {
        e.preventDefault();

        // Limpiar cualquier mensaje de error antes de hacer la solicitud
        $('#mensaje-error-seleccionar').addClass('d-none').find('.mensaje-texto').text('');

        // Obtener el radio seleccionado y sus datos
        const radioSeleccionado = document.querySelector('.seleccionar-mercaderia:checked');
        const mercaderiaId = radioSeleccionado?.dataset.mercaderiaid || '';
        const codigo = radioSeleccionado?.dataset.codigom || '';
        const descripcion = radioSeleccionado?.dataset.descripcionm || '';
        const precioCompra = radioSeleccionado?.dataset.preciocompram || '1';
        const precioVenta = radioSeleccionado?.dataset.precioventam || '1';

        // Validar que se haya seleccionado una mercadería
        if (!mercaderiaId) {
          if (mensajeErrorSeleccionar) {
            mensajeErrorSeleccionar.classList.remove('d-none');
            mensajeErrorSeleccionar.querySelector('.mensaje-texto').textContent = 'Debe seleccionar una mercadería.';
          }
          return;
        }

        // Crear objeto FormData para agregar los datos de la mercadería a los dataset
        const formData = new FormData();
        formData.append('mercaderia_id', mercaderiaId);
        formData.append('codigo_mercaderia', codigo);
        formData.append('descripcion_mercaderia', descripcion);
        formData.append('precio_compra_mercaderia', precioCompra);
        formData.append('precio_venta_mercaderia', precioVenta);


        // Hacer la solicitud AJAX para pasar los datos de mercadería a la vista
        $.ajax({
          url: '/trackpoint/public/index.php?route=/ventas/egresos/presupuestos&seleccionarMercaderia',
          method: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          dataType: 'json',
          success: function (response) {
            if (response.success) {

              console.log('Datos de la mercadería seleccionada - descripción:', {
                id: response.mercaderia_id,
                codigo: response.codigo_mercaderia,
                descripcion: response.descripcion_mercaderia,
                precio_compra: response.precio_compra_mercaderia,
                precio_venta: response.precio_venta_mercaderia
              });

              // Actualizar los inputs del form con los datos de la mercadería seleccionada
              inputMercaderiaIdModal.value = response.mercaderia_id;
              inputCodigoModal.value = response.codigo_mercaderia;
              inputDescripcionModal.value = response.descripcion_mercaderia;
              inputPrecioCompraModal.value = response.precio_compra_mercaderia;
              inputPrecioVentaModal.value = response.precio_venta_mercaderia;

              // Cerrar el modal
              const modal = bootstrap.Modal.getInstance(document.getElementById('modalSeleccionarMercaderia'));
              if (modal) modal.hide();
            } else {
              mensajeErrorSeleccionar.classList.remove('d-none');
              mensajeErrorSeleccionar.querySelector('.mensaje-texto').textContent = response.message || 'Error al seleccionar.';
            }
          },
          error: function () {
            mensajeErrorSeleccionar.classList.remove('d-none');
            mensajeErrorSeleccionar.querySelector('.mensaje-texto').textContent = 'Error de conexión al intentar seleccionar la mercadería.';
          }
        });
      });
    }

    function renderTablaMercaderias(mercaderias) {

      const tbody = document.querySelector('#miTablaEnModalMercaderia tbody');
      tbody.innerHTML = '';

      if (!mercaderias || mercaderias.length === 0) {
        tbody.innerHTML = `<tr><td colspan="6" class="text-center">Sin mercaderías en la lista</td></tr>`;
        return;
      }

      mercaderias.forEach(m => {

        const row = `<tr class="text-start">
                      <td class="border text-primary">${m.mercaderia_id}</td>
                      <td class="border text-primary">${m.codigo}</td>
                      <td class="border text-primary">${m.descripcion}</td>
                      <td class="border text-primary">${m.precio_compra}</td>
                      <td class="border text-primary">${m.precio_venta}</td>
                      <td class="border text-primary">
                        <input type="radio" name="seleccion_mercaderia"
                          class="form-check-input seleccionar-mercaderia"
                          data-mercaderiaid="${m.mercaderia_id}"
                          data-codigom="${m.codigo}"
                          data-descripcionm="${m.descripcion}"
                          data-preciocompram="${m.precio_compra}"
                          data-precioventam="${m.precio_venta}">
                      </td>
                    </tr>
                  `;


        tbody.innerHTML += row;
      });
    }
  }


  /* ###################### VACIAR MERCADERÍA ###################### */
  const btnVaciarMercaderia = document.getElementById('btn-vaciar-mercaderia');
  if (btnVaciarMercaderia) {
    btnVaciarMercaderia.addEventListener('click', function () {
      // Limpiar todo el localStorage
      localStorage.clear();

      // Resetear el formulario
      document.getElementById('formAgregarMercaderia').reset();
    });
  }


  /* ###################### AGREGAR MERCADERÍA ###################### */
  const formAgregar = document.querySelector('#formAgregarMercaderia');
  if (formAgregar) {
    formAgregar.addEventListener('submit', function (e) {
      e.preventDefault();
      $('#mensaje-error-agregar').addClass('d-none').find('.mensaje-texto').text('');

      const presupuestoId = document.getElementById('presupuesto_id').value;
      const mercaderiaId = document.getElementById('mercaderia_id').value;
      const codigoMercaderia = document.getElementById('codigo_mercaderia').value;
      const descripcionMercaderia = document.getElementById('descripcion_mercaderia').value;
      const cantidad = document.getElementById('cantidad').value;
      const precioCompra = document.getElementById('precio_compra_mercaderia').value;
      const precioVenta = document.getElementById('precio_venta_mercaderia').value;

      const formData = new FormData();

      formData.append('presupuesto_id', presupuestoSeleccionado);
      //formData.append('presupuesto_id', presupuestoId);
      formData.append('mercaderia_id', mercaderiaId);
      formData.append('codigo_mercaderia', codigoMercaderia);
      formData.append('descripcion_mercaderia', descripcionMercaderia);
      formData.append('cantidad', cantidad);
      formData.append('precio_compra_mercaderia', precioCompra);
      formData.append('precio_venta_mercaderia', precioVenta);

      console.log('Datos del formulario:', Array.from(formData.entries()));

      $.ajax({
        url: '/trackpoint/public/index.php?route=/ventas/egresos/presupuestos&agregarMercaderia',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
          console.log('Respuesta del servidor:', response);
          if (response.success) {
            if (response.presupuesto_id) {
              document.getElementById('presupuesto_id').value = response.presupuesto_id;
            }

            console.log('Respuesta del servidor:', response);
            console.log('Valor actual de presupuesto_id en el formulario:', document.getElementById('presupuesto_id')?.value);

            recargarDetalle(presupuestoId);
            recargarResumen(presupuestoId);

          } else {
            $('#mensaje-error-agregar').removeClass('d-none').find('.mensaje-texto').text(response.message);
          }
        },
        error: function (xhr, status, error) {
          console.log('Error al guardar los datos');
          console.log('Código de estado:', xhr.status);
          console.log('Mensaje de error:', error);
          console.log('Respuesta del servidor:', xhr.responseText);
          $('#mensaje-error-agregar').removeClass('d-none').find('.mensaje-texto').text('Hubo un error al intentar guardar los datos.');
        }
      });
    });
  }


  /* ###################### MODAL DE EDICIÓN MERCADERÍA ###################### */
  // Interceptar el evento de apertura del modal de edición
  var modalEditarMercaderia = document.getElementById('modalEditarMercaderia');
  if (modalEditarMercaderia) {

    const itemId = document.querySelector('#editarItemId').value;
    var codigoSelect = document.getElementById('editarCodigoMercaderia');
    var descripcionInput = document.getElementById('editarDescripcionMercaderiaContenedor');

    if (codigoSelect && descripcionInput) {

      codigoSelect.addEventListener('change', function () {
        const codigo = this.value;

        if (!codigo) {
          descripcionInput.value = '';
          return;
        }

        buscarMercaderiaPorCodigo(codigo)
          .done(function (response) {
            let $descripcion = $(descripcionInput);
            $descripcion.empty();
            if (response.success) {
              // Cargo la opción por defecto
              $descripcion.append($('<input>', {
                type: 'text',
                class: 'form-control text-primary',
                name: 'descripcion_mercaderia',
                id: 'editarDescripcionMercaderia',
                value: response.descripcion_mercaderia
              }));
            } else {
              descripcionInput.value = '';
            }
          })
          .fail(function () {
            descripcionInput.value = '';
            console.error('Error al buscar la mercadería');
          });
      });
    }
  }

  document.addEventListener('click', function (e) {

    const btnEditar = e.target.closest('.btn-editar-mercaderia');
    if (!btnEditar) return;

    console.count('click editar mercaderia');

    const modal = document.getElementById('modalEditarMercaderia');

    modal.querySelector('[name="item_id"]').value = btnEditar.dataset.id;
    modal.querySelector('[name="codigo_mercaderia"]').value = btnEditar.dataset.codigom;
    modal.querySelector('[name="descripcion_mercaderia"]').value = btnEditar.dataset.descripcionm;
    modal.querySelector('[name="cantidad"]').value = btnEditar.dataset.cantidad;
    modal.querySelector('[name="precio_compra_mercaderia"]').value = btnEditar.dataset.preciocompram;
    modal.querySelector('[name="precio_venta_mercaderia"]').value = btnEditar.dataset.precioventam;

  });

  // Interceptar el envío del formulario con AJAX
  const formEditar = document.querySelector('#formEditarMercaderia');
  if (formEditar) {
    formEditar.addEventListener('submit', function (e) {
      console.count('submit editar mercaderia');
      e.preventDefault();

      // Limpiar cualquier mensaje de error antes de hacer la solicitud
      $('#mensaje-error-editar-mercaderia').addClass('d-none').find('.mensaje-texto').text('');

      const formData = new FormData(this);
      console.log('Datos del formulario de edición mercadería:', Array.from(formData.entries()));

      $.ajax({
        url: '/trackpoint/public/index.php?route=/ventas/egresos/presupuestos&editarMercaderia',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
          console.log('Respuesta del servidor:', response);

          if (response.success) {
            console.log('Mercadería modificada con éxito');

            /* const tabla = $('#miTablaDetalle').DataTable(); */

            recargarDetalle(presupuesto_id);

          } else {
            console.log('Error al modificar la mercadería:', response.message);
            $('#mensaje-error-editar-mercaderia').removeClass('d-none').find('.mensaje-texto').text(response.message);
          }
        },
        error: function (xhr, status, error) {
          console.log('Error al guardar los datos');
          console.log('Código de estado:', xhr.status);
          console.log('Mensaje de error:', error);
          console.log('Respuesta del servidor:', xhr.responseText);
          $('#mensaje-error-editar-mercaderia').removeClass('d-none').find('.mensaje-texto').text('Hubo un error al intentar guardar los datos.');
        }
      });
    });
  }
  // Limpiar el mensaje de error al cerrar el modal
  if (modalEditarMercaderia) {
    modalEditarMercaderia.addEventListener('hidden.bs.modal', function () {
      var mensajeError = document.getElementById('mensaje-error-editar-mercaderia');
      if (mensajeError) {
        mensajeError.classList.add('d-none'); // Ocultar el div
        mensajeError.querySelector('.mensaje-texto').textContent = ''; // Limpiar el texto
      }
    });
  }


  /* ###################### MODAL DE ELIMINACIÓN MERCADERÍA ###################### */
  // Interceptar el evento de apertura del modal de eliminación
  var modalEliminarMercaderia = document.getElementById('modalEliminarMercaderia');

  // Interceptar el envío del formulario con AJAX
  const formEliminarMercaderia = document.querySelector('#formEliminarMercaderia');
  if (formEliminarMercaderia) {
    formEliminarMercaderia.addEventListener('submit', function (e) {
      e.preventDefault();

      // Limpiar cualquier mensaje de error antes de hacer la solicitud
      $('#mensaje-error-eliminar-mercaderia').addClass('d-none').find('.mensaje-texto').text('');

      const formData = new FormData(this);

      $.ajax({
        url: '/trackpoint/public/index.php?route=/ventas/egresos/presupuestos&eliminarMercaderia',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
          console.log('Respuesta del servidor:', response);

          if (response.success) {
            console.log('Mercadería eliminada con éxito:', response.message);

            /* const tabla = $('#miTablaDetalle').DataTable(); */

            recargarDetalle(presupuesto_id);
          } else {
            console.log('Error al eliminar la mercadería:', response.message);
            $('#mensaje-error-eliminar-mercaderia').removeClass('d-none').find('.mensaje-texto').text(response.message);
          }
        },
        error: function (xhr, status, error) {
          console.log('Error al guardar los datos');
          console.log('Código de estado:', status);
          console.log('Mensaje de error:', error);
          console.log('Respuesta del servidor:', xhr.responseText);
          $('#mensaje-error-eliminar-mercaderia').removeClass('d-none').find('.mensaje-texto').text('Hubo un error al intentar guardar los datos.');
        }
      });
    });
  }
  // Limpiar el mensaje de error al cerrar el modal
  if (modalEliminarMercaderia) {
    modalEliminarMercaderia.addEventListener('hidden.bs.modal', function () {
      var mensajeError = document.getElementById('mensaje-error-eliminar-mercaderia');
      if (mensajeError) {
        mensajeError.classList.add('d-none'); // Ocultar el div
        mensajeError.querySelector('.mensaje-texto').textContent = ''; // Limpiar el texto
      }
    });
  }

});
