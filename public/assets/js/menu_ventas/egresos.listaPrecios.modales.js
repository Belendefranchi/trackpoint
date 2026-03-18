window.addEventListener('load', function () {
  localStorage.removeItem('listaSeleccionada');
});

// --- VARIABLES GLOBALES ---
let presupuestoSeleccionado = null;

document.addEventListener('DOMContentLoaded', function () {

  /* ###################### MODAL DE CREACIÓN DE LISTAS DE PRECIOS ###################### */

  // Interceptar el envío del formulario con AJAX
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

  // Limpiar el mensaje de error al cerrar el modal
  var modalCrearListaPrecios = document.getElementById('modalCrearListaPrecios');
  modalCrearListaPrecios.addEventListener('hidden.bs.modal', function () {
    var mensajeError = document.getElementById('mensaje-error-crear');
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


  /* ###################### DETALLE LISTA DE PRECIOS ###################### */
/*   document.addEventListener('click', function (e) {

    const btn = e.target.closest('.btn-ver-lista');
    if (!btn) return;
    e.preventDefault();
    const listaId = btn.dataset.id;
    console.log('Botón de ver lista de precios clickeado: ' + listaId);

    $.ajax({
      url: '/trackpoint/public/index.php?route=/ventas/egresos/listaPrecios&verLista',
      type: 'POST',
      data: { lista_id: listaId },
      dataType: 'json',

      success: function (response) {
        if (response.success) {
          console.log(response);
          document.getElementById('detalle-lista').innerHTML = response.html;
          const tabDetalle = new bootstrap.Tab(
            document.querySelector('#detalle-tab')
          );
          tabDetalle.show();
          setTimeout(function () {
            if ($.fn.DataTable.isDataTable('#miTablaDetalle')) {
              $('#miTablaDetalle').DataTable().columns.adjust();
            }
          }, 200);
        }
      },

      error: function (xhr, status, error) {
        console.log('Error al cargar la lista');
        console.log('Código:', xhr.status);
        console.log('Error:', error);
        console.log('Respuesta:', xhr.responseText);
      }

    });
  });

  document.getElementById('resumen-tab').addEventListener('shown.bs.tab', function () {

    if ($.fn.DataTable.isDataTable('#miTablaDetalle')) {
      $('#miTablaDetalle').DataTable().destroy();
    }

    document.getElementById('detalle-lista').innerHTML = `
        <p class="text-muted text-center">
            Aún no se seleccionó ninguna lista de precios
        </p>
    `;

    document.getElementById('listaActivo').innerText = '';

  }); */






  /* ###################### SELECCIÓN DE LISTA DE PRECIOS ###################### */

  // --- SELECCIONAR LISTA ---
  document.querySelectorAll('.tabla-lista').forEach(fila => {
    fila.addEventListener('click', function (event) {

      // Evitar que clic en <a> o <button> o inputs dispare selección
      if (event.target.closest('a, button, input, label')) {
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

  function actualizarEtiqueta(listaSeleccionada) {

    let etiqueta = document.getElementById('listaActivo');
    if (etiqueta) {
      etiqueta.textContent = listaSeleccionada;
    }
  }

  // --- CARGAR DETALLE DE LA LISTA SELECCIONADA ---

  function recargarDetalle(lista_id) {
    console.count('recargarDetalle llamado');

    $.ajax({
      url: "/trackpoint/public/index.php?route=/ventas/egresos/listaPrecios&verLista",
      type: "POST",
      data: { lista_id },
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

  $(document).ready(function () {

    // Detectar apertura de la pestaña DETALLE
    $('a[data-bs-toggle="tab"][href="#detalle"]').on('shown.bs.tab', function () {

      let seleccionado = document.querySelector('input[name="seleccion_lista"]:checked');
      let lista_id = seleccionado?.getAttribute('data-listaid') ?? null;

      console.log(lista_id);
      if (!lista_id) {
        console.warn("No hay lista seleccionada al intentar mostrar detalle");
        return;
      }
      recargarDetalle(lista_id);
    });
  });







  /* ###################### GUARDAR LISTA DE PRECIOS ###################### */
  document.addEventListener('click', function (e) {
    const btn = e.target.closest('#btnMostrarGuardarListaPrecios');
    if (!btn) return;
    e.preventDefault();
    const form = document.getElementById('formGuardarListaPrecios');
    const formData = new FormData(form);
    /* console.log('Guardando lista de precios con datos:', Array.from(formData.entries())); */
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