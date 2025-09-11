document.addEventListener('DOMContentLoaded', function () {

  /* ##################### MODAL BUSQUEDA POR DESCRIPCIÓN ##################### */

  var modalSeleccionar = document.getElementById('modalSeleccionarMercaderia');
  var mensajeErrorSeleccionar = document.getElementById('mensaje-error-seleccionar');

  if (modalSeleccionar) {
    // Listener para vaciar seleccion cuando se cierra el modal
    modalSeleccionar.addEventListener('hidden.bs.modal', function () {
      // Limpia el mensaje de error
      if (mensajeErrorSeleccionar) {
        mensajeErrorSeleccionar.classList.add('d-none');
        mensajeErrorSeleccionar.querySelector('.mensaje-texto').textContent = '';
      }

      // Limpia los inputs hidden del modal
      modalSeleccionar.querySelector('#input-mercaderia-id').value = '';
      modalSeleccionar.querySelector('#input-codigo-mercaderia').value = '';
    });

    const inputMercaderiaIdModal = document.getElementById('mercaderia_id');
    const inputCodigoModal = document.getElementById('codigo_mercaderia');
    

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

        // Hacer la solicitud AJAX para pasar los datos de mercadería a la vista
        $.ajax({
          url: '/trackpoint/public/index.php?route=/expedicion/egresos/ventas&seleccionarMercaderia',
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
              });

              // Actualizar los inputs del modal con los datos de la mercadería seleccionada
              inputMercaderiaIdModal.value = response.mercaderia_id;
              inputCodigoModal.value = response.codigo_mercaderia;



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
  }


  /* ##################### INPUT BÚSQUEDA POR CÓDIGO ##################### */

  const inputCodigoBusqueda = document.getElementById('codigo_mercaderia');
  const inputMercaderiaIdBusqueda = document.getElementById('mercaderia_id');
  const mensajeBusqueda = document.getElementById('mensaje-busqueda');
  

  function buscarMercaderiaPorCodigo(codigo) {
    if (codigo.length >= 2) {
      $.ajax({
        url: '/trackpoint/public/index.php?route=/expedicion/egresos/ventas&seleccionarCodigoMercaderia',
        method: 'POST',
        data: { 'codigo_mercaderia': codigo },
        dataType: 'json',
        success: function (response) {
          if (response.success) {

            console.log('Datos de la mercadería seleccionada - código:', {
              id: response.mercaderia_id,
              codigo: response.codigo_mercaderia,
            });

            inputMercaderiaIdBusqueda.value = response.mercaderia_id;
            inputCodigoBusqueda.value = response.codigo_mercaderia;

            mensajeBusqueda.classList.add('d-none');


          } else {
            inputMercaderiaIdBusqueda.value = '';
            $('#mensaje-busqueda').removeClass('d-none').find('.mensaje-texto').text(response.message);
          }
        },
        error: function () {
          inputMercaderiaIdBusqueda.value = '';
          $('#mensaje-busqueda').removeClass('d-none').find('.mensaje-texto').text('Error de conexión al buscar la mercadería.');
        }
      });
    } else {
      inputMercaderiaIdBusqueda.value = '';
      mensajeBusqueda.classList.add('d-none');
    }
  }

  inputCodigoBusqueda.addEventListener('keydown', function (e) {
    if (e.key === 'Enter') {
      e.preventDefault();
      buscarMercaderiaPorCodigo(this.value.trim());
    }
  });


/* POR ACA */


  /* ##################### AGREGAR MERCADERÍA ##################### */

  const formAgregar = document.querySelector('#formAgregarMercaderia');
  if (formAgregar) {
    formAgregar.addEventListener('submit', function (e) {
      e.preventDefault();
      $('#mensaje-error-agregar').addClass('d-none').find('.mensaje-texto').text('');

      
      const mercaderiaId = localStorage.getItem('valor_mercaderia_id') || document.getElementById('mercaderia_id').value;
      const proveedorId = document.getElementById('proveedor_id').value;
      const fechaRecepcion = document.getElementById('fecha_recepcion').value;
      const nroRemito = document.getElementById('nro_remito').value;
      const fechaRemito = document.getElementById('fecha_remito').value;
      const unidades = document.getElementById('unidades').value;
      const pesoNeto = document.getElementById('peso_neto').value;
      /* const operadorId = document.getElementById('operador_id').value; */

      const formData = new FormData();
      formData.append('mercaderia_id', mercaderiaId);
      formData.append('proveedor_id', proveedorId);
      formData.append('fecha_recepcion', fechaRecepcion);
      formData.append('nro_remito', nroRemito);
      formData.append('fecha_remito', fechaRemito);
      formData.append('unidades', unidades);
      formData.append('peso_neto', pesoNeto);
      /* formData.append('operador_id', operadorId); */

      console.log('Datos del formulario:', Array.from(formData.entries()));

      $.ajax({
        url: '/trackpoint/public/index.php?route=/expedicion/egresos/ventas&agregarMercaderia',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
          if (response.success) {
            location.reload();
          } else {
            $('#mensaje-error-agregar').removeClass('d-none').find('.mensaje-texto').text(response.message);
          }
        },
        error: function (xhr, status, error) {
          $('#mensaje-error-agregar').removeClass('d-none').find('.mensaje-texto').text('Hubo un error al intentar guardar los datos.');
        }
      });
    });
  }

  /* ##################### MODAL DE EDICIÓN ##################### */

	// Interceptar el evento de apertura del modal de edición
	var modalEditarMercaderia = document.getElementById('modalEditarMercaderia');
	if (modalEditarMercaderia) {
		modalEditarMercaderia.addEventListener('show.bs.modal', function (event) {
			console.log('Modal abrir - event.relatedTarget:', event.relatedTarget);
			const button = event.relatedTarget;

			if (!button) {
				console.warn('No se detectó el botón que activó el modal.');
				return;
			}

			modalEditarMercaderia.querySelector('#editarItemId').value = button.getAttribute('data-id');
			modalEditarMercaderia.querySelector('#editarProveedorMercaderia').value = button.getAttribute('data-proveedor');
			modalEditarMercaderia.querySelector('#editarFechaRecepcionMercaderia').value = button.getAttribute('data-frecepcion');
			modalEditarMercaderia.querySelector('#editarNroRemitoMercaderia').value = button.getAttribute('data-remito');
			modalEditarMercaderia.querySelector('#editarFechaRemitoMercaderia').value = button.getAttribute('data-fremito');
      modalEditarMercaderia.querySelector('#editarUnidadesMercaderia').value = button.getAttribute('data-unidades');
      modalEditarMercaderia.querySelector('#editarPesoNetoMercaderia').value = button.getAttribute('data-peso');
		});
	}

	// Interceptar el envío del formulario con AJAX
	const formEditar = document.querySelector('#formEditarMercaderia');
	if (formEditar) {
		formEditar.addEventListener('submit', function (e) {
			e.preventDefault();

			// Limpiar cualquier mensaje de error antes de hacer la solicitud
			$('#mensaje-error-editar').addClass('d-none').find('.mensaje-texto').text('');

			const formData = new FormData(this);

			$.ajax({
				url: '/trackpoint/public/index.php?route=/expedicion/egresos/ventas&editarMercaderia',
				type: 'POST',
				data: formData,
				processData: false,
				contentType: false,
				dataType: 'json',
				success: function (response) {
					console.log('Respuesta del servidor:', response);

					if (response.success) {
						console.log('Recepción Mercadería modificado con éxito:', response.message);

						const tabla = $('#miTablaDetalle').DataTable();
						localStorage.setItem('paginaRecepcionDetalle', tabla.page());

						location.reload();
					} else {
						console.log('Error al modificar la mercadería:', response.message); 
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

	// Limpiar el mensaje de error al cerrar el modal
	var modalEditarMercaderia = document.getElementById('modalEditarMercaderia');
	if (modalEditarMercaderia) {
		modalEditarMercaderia.addEventListener('hidden.bs.modal', function () {
			var mensajeError = document.getElementById('mensaje-error-editar');
			if (mensajeError) {
				mensajeError.classList.add('d-none'); // Ocultar el div
				mensajeError.querySelector('.mensaje-texto').textContent = ''; // Limpiar el texto
			}
		});
	}
  
  /* ##################### MODAL DE ELIMINACIÓN ##################### */

  // Interceptar el evento de apertura del modal de eliminación
  var modalEliminarMercaderia = document.getElementById('modalEliminarMercaderia');
  if (modalEliminarMercaderia) {
    modalEliminarMercaderia.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;

      modalEliminarMercaderia.querySelector('#eliminarItemId').value = button.getAttribute('data-id');
    });
  }

  // Interceptar el envío del formulario con AJAX
  const formEliminar = document.querySelector('#formEliminarMercaderia');
  if (formEliminar) {
    formEliminar.addEventListener('submit', function (e) {
      e.preventDefault();

      // Limpiar cualquier mensaje de error antes de hacer la solicitud
      $('#mensaje-error-eliminar').addClass('d-none').find('.mensaje-texto').text('');

      const formData = new FormData(this);

      $.ajax({
        url: '/trackpoint/public/index.php?route=/expedicion/egresos/ventas&eliminarMercaderia',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
          console.log('Respuesta del servidor:', response);

          if (response.success) {
            console.log('Mercadería eliminada con éxito:', response.message);

            const tabla = $('#miTablaDetalle').DataTable();
            localStorage.setItem('paginaRecepcionDetalle', tabla.page());

            location.reload();
          } else {
            console.log('Error al crear la mercadería:', response.message);
            $('#mensaje-error-eliminar').removeClass('d-none').find('.mensaje-texto').text(response.message);
          }
        },
        error: function (xhr, status, error) {
          console.log('Error al guardar los datos');
          console.log('Código de estado:', xhr.status);
          console.log('Mensaje de error:', error);
          console.log('Respuesta del servidor:', xhr.responseText); 
          $('#mensaje-error-eliminar').removeClass('d-none').find('.mensaje-texto').text('Hubo un error al intentar guardar los datos.');
        }
      });
    });
  }

  // Limpiar el mensaje de error al cerrar el modal
  var modalEliminarMercaderia = document.getElementById('modalEliminarMercaderia');
  if (modalEliminarMercaderia) {
    modalEliminarMercaderia.addEventListener('hidden.bs.modal', function () {
      var mensajeError = document.getElementById('mensaje-error-eliminar');
      if (mensajeError) {
        mensajeError.classList.add('d-none'); // Ocultar el div
        mensajeError.querySelector('.mensaje-texto').textContent = ''; // Limpiar el texto
      }
    });
  }

  
  /* ##################### GUARDAR RECEPCIÓN ##################### */

  document.getElementById('btnMostrarConfirmacion').addEventListener('click', function () {
    const modal = new bootstrap.Modal(document.getElementById('modalGuardarRecepcion'));
    modal.show();
  });

  const btnGuardar = document.getElementById('btnConfirmarGuardar');
  if (btnGuardar) {
    btnGuardar.addEventListener('click', function () {
      bootstrap.Modal.getInstance(document.getElementById('modalGuardarRecepcion')).hide();

      $.ajax({
        url: '/trackpoint/public/index.php?route=/expedicion/egresos/ventas&guardarRecepcion',
        type: 'POST',
        dataType: 'json',
        success: function (response) {
          if (response.success) {
            console.log(response)
            $('#modalMensajeLabel').text('Recepción guardada');
            $('#textoModalMensaje').text('La recepción fue guardada correctamente.');
          } else {
            $('#modalMensajeLabel').text('Error al guardar');
            $('#textoModalMensaje').text(response.message || 'Ocurrió un error inesperado.');
          }

          const modalMensaje = new bootstrap.Modal(document.getElementById('modalMensajeRecepcion'));
          modalMensaje.show();

          // Esperar a que el modal se cierre para recargar
          const modalElement = document.getElementById('modalMensajeRecepcion');
          modalElement.addEventListener('hidden.bs.modal', function () {
            location.reload();
          }, { once: true });

        },
        error: function () {
          $('#modalMensajeLabel').text('Error inesperado');
          $('#textoModalMensaje').text('Hubo un problema al intentar guardar la recepción.');
          const modalMensaje = new bootstrap.Modal(document.getElementById('modalMensajeRecepcion'));
          modalMensaje.show();
        }
      });
    });
  }

  
  /* ##################### CANCELAR RECEPCIÓN ##################### */

  document.getElementById('btnMostrarCancelarRecepcion').addEventListener('click', function () {
    const modal = new bootstrap.Modal(document.getElementById('modalCancelarRecepcion'));
    modal.show();
  });

  const btnCancelar = document.getElementById('btnConfirmarCancelar');
  if (btnCancelar) {
    btnCancelar.addEventListener('click', function () {
      bootstrap.Modal.getInstance(document.getElementById('modalCancelarRecepcion')).hide();

      $.ajax({
        url: '/trackpoint/public/index.php?route=/expedicion/egresos/ventas&cancelarRecepcion',
        type: 'POST',
        dataType: 'json',
        success: function (response) {
          if (response.success) {
            console.log(response)
            $('#modalMensajeLabel').text('Recepción cancelada');
            $('#textoModalMensaje').text('La recepción fue cancelada correctamente.');
          } else {
            $('#modalMensajeLabel').text('Error al cancelar');
            $('#textoModalMensaje').text(response.message || 'Ocurrió un error inesperado.');
          }

          const modalMensaje = new bootstrap.Modal(document.getElementById('modalMensajeRecepcion'));
          modalMensaje.show();

          // Esperar a que el modal se cierre para recargar
          const modalElement = document.getElementById('modalMensajeRecepcion');
          modalElement.addEventListener('hidden.bs.modal', function () {
            location.reload();
          }, { once: true });

        },
        error: function (xhr, status, error) {
          console.log("Estado:", status);
          console.log("Error:", error);
          console.log("Respuesta cruda:", xhr.responseText);
          $('#modalMensajeLabel').text('Error inesperado');
          $('#textoModalMensaje').text('Hubo un problema al intentar eliminar la recepción.');
          const modalMensaje = new bootstrap.Modal(document.getElementById('modalMensajeRecepcion'));
          modalMensaje.show();
        }
      });
    });
  }

});
