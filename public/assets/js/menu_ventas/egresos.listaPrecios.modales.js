window.addEventListener('load', function () {
  localStorage.removeItem('listaSeleccionada');
});

// --- VARIABLES GLOBALES ---
let presupuestoSeleccionado = null;

document.addEventListener('DOMContentLoaded', function () {


  /* ###################### MODAL DE CREACIÓN DE LISTAS DE PRECIOS ###################### */

  // --- Interceptar el envío del formulario con AJAX ---
  const formCrear = document.querySelector('#formCrearListaPrecios');
  if (formCrear) {
    formCrear.addEventListener('submit', function (e) {
      e.preventDefault();

      // Limpiar cualquier mensaje de error antes de hacer la solicitud
      $('#mensaje-error-crear').addClass('d-none').find('.mensaje-texto').text('');

      const formData = new FormData(this);

      $.ajax({
        url: '/trackpoint/public/index.php?route=/ventas/egresos/listaPrecios&crearLista',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
          console.log('Respuesta del servidor:', response);

          if (response.success) {
            console.log('Lista de precios creada con éxito:', response.message);

            const tabla = $('#miTablaResumen').DataTable();
            localStorage.setItem('paginaListaPrecios', tabla.page());

            location.reload();
          } else {
            console.log('Error al crear la lista de precios:', response.message);
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

  // --- Limpiar el mensaje de error al cerrar el modal ---
  var modalCrearListaPrecios = document.getElementById('modalCrearListaPrecios');
  modalCrearListaPrecios.addEventListener('hidden.bs.modal', function () {
    var mensajeError = document.getElementById('mensaje-error-crear');
    if (mensajeError) {
      mensajeError.classList.add('d-none'); // Ocultar el div
      mensajeError.querySelector('.mensaje-texto').textContent = ''; // Limpiar el texto
    }
  });


  /* ###################### MODAL EDITAR LISTA DE PRECIOS ###################### */

  // --- Interceptar el envío del formulario con AJAX ---
  const formEditar = document.querySelector('#formEditarListaPrecios');
  if (formEditar) {
    formEditar.addEventListener('submit', function (e) {
      e.preventDefault();

      // Limpiar cualquier mensaje de error antes de hacer la solicitud
      $('#mensaje-error-editar').addClass('d-none').find('.mensaje-texto').text('');

      const formData = new FormData(this);

      $.ajax({
        url: '/trackpoint/public/index.php?route=/ventas/egresos/listaPrecios&editarLista',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
          console.log('Respuesta del servidor:', response);

          if (response.success) {
            console.log('Lista de precios editada con éxito:', response.message);

            const tabla = $('#miTablaResumen').DataTable();
            localStorage.setItem('paginaListaPrecios', tabla.page());

            location.reload();
          } else {
            console.log('Error al editar la lista de precios:', response.message);
            $('#mensaje-error-editar').removeClass('d-none').find('.mensaje-texto').text(response.message);
          }
        },
        error: function (xhr, status, error) {
          console.log('Error al guardar los datos');
          console.log('Código de estado:', xhr.status);
          console.log('Mensaje de error:', error);
          console.log('Respuesta del servidor:', xhr.responseText);
          $('#mensaje-error-editar').removeClass('d-none').find('.mensaje-texto').text('Hubo un error al intentar guardar los datos.');
        }
      });
    });
  }

  // --- Limpiar el mensaje de error al cerrar el modal ---
  var modalEditarListaPrecios = document.getElementById('modalEditarListaPrecios');
  modalEditarListaPrecios.addEventListener('hidden.bs.modal', function () {
    var mensajeError = document.getElementById('mensaje-error-editar');
    if (mensajeError) {
      mensajeError.classList.add('d-none'); // Ocultar el div
      mensajeError.querySelector('.mensaje-texto').textContent = ''; // Limpiar el texto
    }
  });



  /* ###################### MODAL ELIMINAR LISTA DE PRECIOS ###################### */
  const btnConfirmarEliminar = document.getElementById('btnConfirmarEliminar');
  if (btnConfirmarEliminar) {
    btnConfirmarEliminar.addEventListener('click', function () {
      bootstrap.Modal.getInstance(document.getElementById('modalEliminarListaPrecios')).hide();

      $.ajax({
        url: '/trackpoint/public/index.php?route=/ventas/egresos/listaPrecios&eliminarLista',
        type: 'POST',
        data: { 'lista_id': document.getElementById('eliminarListaPreciosId').value },
        dataType: 'json',
        success: function (response) {
          if (response.success) {
            console.log(response)
            $('#modalMensajeLabel').text('Lista de precios eliminada');
            $('#textoModalMensaje').text('La lista de precios fue eliminada correctamente.');
          } else {
            $('#modalMensajeLabel').text('Error al cancelar');
            $('#textoModalMensaje').text(response.message || 'Ocurrió un error inesperado.');
          }

          const modalMensaje = new bootstrap.Modal(document.getElementById('modalMensajeListaPrecios'));
          modalMensaje.show();

          // Esperar a que el modal se cierre para recargar
          const modalElement = document.getElementById('modalMensajeListaPrecios');
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
          $('#textoModalMensaje').text('Hubo un problema al intentar eliminar la lista de precios.');
          const modalMensaje = new bootstrap.Modal(document.getElementById('modalMensajeListaPrecios'));
          modalMensaje.show();
        }
      });
    });
  }



  /* ###################### SELECCIÓN DE LISTA DE PRECIOS ###################### */

  // --- SELECCIONAR LISTA ---
  document.querySelectorAll('.tabla-lista').forEach(fila => {
    fila.addEventListener('click', function (event) {

      // Evitar que clic en <a> o <button> o inputs dispare selección
      if (event.target.closest('a, button')) {
        return;
      }

      // Seleccionar radio si existe
      const radio = this.querySelector('.seleccionar-lista');
      console.log('Radio seleccionado:', radio.dataset.nombre);
      if (radio) {
        radio.checked = true;
      }

      listaSeleccionada = radio?.dataset?.nombre;

      // Actualizar la etiqueta superior (UI)
      actualizarEtiqueta(listaSeleccionada);
    });
  });

  // --- ACTUALIZAR ETIQUETA ---
  function actualizarEtiqueta(listaSeleccionada) {

    let etiqueta = document.getElementById('listaActivo');
    if (etiqueta) {
      etiqueta.textContent = listaSeleccionada;
    }
  }

  // --- CARGAR DETALLE DE LA LISTA SELECCIONADA ---
  function recargarDetalle(lista_id, lista_tipo) {
    console.count('recargarDetalle llamado');

    $.ajax({
      url: "/trackpoint/public/index.php?route=/ventas/egresos/listaPrecios&verLista",
      type: "POST",
      data: { lista_id, lista_tipo },
      dataType: "json",

      success: function (response) {
        if (response.success) {
          $("#detalle-lista").html(response.html);

        } else {
          console.error(response.message);
        }
      },

      error: function () {
        alert("Error al obtener el detalle de la lista de precios");
      }
    });
  }

  // --- RECARGAR DETALLE AL SELECCIONAR LA PESTAÑA DETALLE ---
  $(document).ready(function () {

    // Detectar apertura de la pestaña DETALLE
    $('a[data-bs-toggle="tab"][href="#detalle"]').on('shown.bs.tab', function () {

      let seleccionado = document.querySelector('input[name="seleccion_lista"]:checked');
      let lista_id = seleccionado?.getAttribute('data-id') ?? null;
      let lista_tipo = seleccionado?.getAttribute('data-tipo') ?? null;

      console.log(lista_id);
      console.log(lista_tipo);

      if (!lista_id) {
        console.warn("No hay lista seleccionada al intentar mostrar detalle");
        return;
      }
      recargarDetalle(lista_id, lista_tipo);
    });
  });



  /* ###################### OBTENER PRECIOS DE COMPRA ###################### */

  // --- SELECCIONAR LISTA EN DETALLE ---
  document.addEventListener('change', function (e) {

    if (e.target.id !== 'selectListaCompra') return;
    const listaId = e.target.value;
    $.ajax({
      url: '/trackpoint/public/index.php?route=/ventas/egresos/listaPrecios&obtenerPreciosCompra',
      type: 'POST',
      data: { lista_id: listaId },
      dataType: 'json',

      success: function (response) {

        $('.precio-compra').text('0');
        $('.margen').text('-');

        response.datos.forEach(function (item) {
          const celdaCompra = document.querySelector(
            '.precio-compra[data-mercaderia-id="' + item.mercaderia_id + '"]'
          );
          if (!celdaCompra) return;
          celdaCompra.textContent = item.precio_compra;
          const fila = celdaCompra.closest('tr');
          calcularMargenFila(fila);
        });
      },

      error: function () {
        alert('Error al cargar precios de compra');
      }
    });
  });

  // --- CALCULAR MARGEN DE GANANCIA POR FILA ---
  function calcularMargenFila(fila) {

    if (!fila) return;

    const compraCelda = fila.querySelector('.precio-compra');
    const ventaInput = fila.querySelector('.precio-venta');
    const margenCelda = fila.querySelector('.margen');

    if (!compraCelda || !ventaInput || !margenCelda) return;

    let compra = parseFloat(
      compraCelda.textContent.trim().replace(',', '.')
    ) || 0;

    let venta = parseFloat(
      ventaInput.value.trim().replace(',', '.')
    ) || 0;

    if (compra <= 0 || venta <= 0) {
      margenCelda.textContent = '-';
      return;
    }

    let margen = venta - compra;

    margenCelda.textContent = "$ " + margen.toFixed(2);
  }

  // --- OBTENER MARGEN AL MODIFICAR PRECIOS DE VENTA ---
  document.addEventListener('input', function (e) {
    if (!e.target.classList.contains('precio-venta')) return;
    const fila = e.target.closest('tr');
    calcularMargenFila(fila);
  });



  /* ###################### GUARDAR LISTA DE PRECIOS ###################### */

  document.addEventListener('click', function (e) {
    const btn = e.target.closest('#btnMostrarGuardarListaPrecios');
    if (!btn) return;
    e.preventDefault();
    const form = document.getElementById('formGuardarListaPrecios');
    const formData = new FormData(form);
    $.ajax({
      url: '/trackpoint/public/index.php?route=/ventas/egresos/listaPrecios&guardarLista',
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      dataType: 'json',
      success: function (response) {
        if (response.success) {
          console.log(response);
          $('#modalMensajeLabel').text('Lista de precios guardada');
          $('#textoModalMensaje').text('La lista de precios fue guardada correctamente.');
        } else {
          $('#modalMensajeLabel').text('Error al guardar');
          $('#textoModalMensaje').text(response.message || 'Ocurrió un error inesperado.');
        }

        const modalMensaje = new bootstrap.Modal(document.getElementById('modalMensajeListaPrecios'));
        modalMensaje.show();

        // Esperar a que el modal se cierre para recargar
        const modalElement = document.getElementById('modalMensajeListaPrecios');
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
        $('#textoModalMensaje').text('Hubo un problema al intentar guardar la lista de precios.');
        const modalMensaje = new bootstrap.Modal(document.getElementById('modalMensajeListaPrecios'));
        modalMensaje.show();
      }
    });
  });

});