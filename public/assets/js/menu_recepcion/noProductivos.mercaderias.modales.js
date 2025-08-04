document.addEventListener('DOMContentLoaded', function () {
  // Restaurar pestaña activa al cargar
  const lastTab = localStorage.getItem('pestanaRecepcionActiva');
  if (lastTab) {
    const trigger = document.querySelector(`a[data-bs-toggle="tab"][href="#${lastTab}"]`);
    if (trigger) {
      new bootstrap.Tab(trigger).show();
    }
  }

  // Guardar pestaña activa al cambiar
  const tabLinks = document.querySelectorAll('a[data-bs-toggle="tab"]');
  tabLinks.forEach(link => {
    link.addEventListener('shown.bs.tab', function (e) {
      const href = e.target.getAttribute('href'); // ej: #tabResumen
      const tabId = href.replace('#', '');
      localStorage.setItem('pestanaRecepcionActiva', tabId);
    });
  });

  // Restaurar valores fijados desde localStorage
	const campos = ['proveedor_id', 'fecha_recepcion', 'nro_remito', 'fecha_remito', 'codigo_mercaderia', 'descripcion_mercaderia'];

	campos.forEach(campo => {
		const checkbox = document.getElementById(`${campo}_checkbox`);
		const input = document.getElementById(campo);

		if (!checkbox || !input) return;

		const guardado = localStorage.getItem(`fijar_${campo}`);
		const valor = localStorage.getItem(`valor_${campo}`);

		if (guardado === 'true' && valor !== null) {
			checkbox.checked = true;
			input.value = valor;
		}

		// Evento para cambiar el estado del checkbox
		checkbox.addEventListener('change', () => {
			if (checkbox.checked) {
				localStorage.setItem(`fijar_${campo}`, 'true');
				localStorage.setItem(`valor_${campo}`, input.value);
			} else {
				localStorage.removeItem(`fijar_${campo}`);
				localStorage.removeItem(`valor_${campo}`);
			}
		});

		// Actualizar el valor fijado si cambia el input
		input.addEventListener('input', () => {
			if (checkbox.checked) {
				localStorage.setItem(`valor_${campo}`, input.value);
			}
		});
	});




  /* ##################### MODAL SELECCIÓN DE MERCADERÍA ##################### */

  var modalSeleccionar = document.getElementById('modalSeleccionarMercaderia');
  var mensajeErrorSeleccionar = document.getElementById('mensaje-error-seleccionar');

  if (modalSeleccionar) {
    modalSeleccionar.addEventListener('hidden.bs.modal', function () {
      if (mensajeErrorSeleccionar) {
        mensajeErrorSeleccionar.classList.add('d-none');
        mensajeErrorSeleccionar.querySelector('.mensaje-texto').textContent = '';
      }

      document.querySelectorAll('.seleccionar-mercaderia').forEach(radio => radio.checked = false);

      modalSeleccionar.querySelector('#input-mercaderia-id').value = '';
      modalSeleccionar.querySelector('#input-codigo-mercaderia').value = '';
      modalSeleccionar.querySelector('#input-descripcion-mercaderia').value = '';
    });

    // Manejar el cambio de selección de la mercadería
    document.querySelectorAll('.seleccionar-operador').forEach(radio => {
      radio.addEventListener('change', function () {
        // Cargar datos al formulario cuando se confirma el modal
        document.getElementById('input-mercaderia-id').value = this.dataset.mercaderiaid;
        document.getElementById('input-codigo-mercaderia').value = this.dataset.codigom;
        document.getElementById('input-descripcion-mercaderia').value = this.dataset.descripcionm;
      })
    });

    // Enviar formulario con AJAX
    const formSeleccionar = document.getElementById('formSeleccionarMercaderia');
    if (formSeleccionar) {
      formSeleccionar.addEventListener('submit', function (e) {
        e.preventDefault();

        // Limpiar cualquier mensaje de error antes de hacer la solicitud
        $('#mensaje-error-seleccionar').addClass('d-none').find('.mensaje-texto').text('');

        const radioSeleccionado = document.querySelector('.seleccionar-mercaderia:checked');
        const mercaderiaId = radioSeleccionado?.dataset.mercaderiaid;
        const codigo = radioSeleccionado.dataset.codigom || '';
        const descripcion = radioSeleccionado.dataset.descripcionm || '';

        if (!mercaderiaId) {
          if (mensajeErrorSeleccionar) {
            mensajeErrorSeleccionar.classList.remove('d-none');
            mensajeErrorSeleccionar.querySelector('.mensaje-texto').textContent = 'Debe seleccionar una mercadería.';
          }
          return;
        }

        const formData = new FormData();
        formData.append('mercaderia_id', mercaderiaId);
        formData.append('codigo_mercaderia', codigo);
        formData.append('descripcion_mercaderia', descripcion);

        $.ajax({
          url: '/trackpoint/public/index.php?route=/recepcion/noProductivos/ingreso_mercaderia&seleccionarMercaderia',
          method: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          dataType: 'json',
          success: function (response) {
            if (response.success) {
              const modal = bootstrap.Modal.getInstance(document.getElementById('modalSeleccionarMercaderia'));
              if (modal) modal.hide();
              location.reload();
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


  /* ##################### BÚSQUEDA POR CÓDIGO ##################### */

  const inputCodigoBusqueda = document.getElementById('codigo_mercaderia');
  const inputDescripcionBusqueda = document.getElementById('descripcion_mercaderia');
  const mensajeBusqueda = document.getElementById('mensaje-busqueda');

  function buscarMercaderiaPorCodigo(codigo) {
    if (codigo.length >= 2) {
      $.ajax({
        url: '/trackpoint/public/index.php?route=/recepcion/noProductivos/ingreso_mercaderia&seleccionarCodigoMercaderia',
        method: 'POST',
        data: { 'codigo_mercaderia': codigo },
        dataType: 'json',
        success: function (response) {
          if (response.success) {
            inputDescripcionBusqueda.value = response.descripcion_mercaderia;
            document.getElementById('mercaderia_id').value = response.mercaderia_id;
            mensajeBusqueda.classList.add('d-none');
          } else {
            inputDescripcionBusqueda.value = '';
            document.getElementById('mercaderia_id').value = '';
            $('#mensaje-busqueda').removeClass('d-none').find('.mensaje-texto').text(response.message);
          }
        },
        error: function () {
          inputDescripcionBusqueda.value = '';
          document.getElementById('mercaderia_id').value = '';
          $('#mensaje-busqueda').removeClass('d-none').find('.mensaje-texto').text('Error de conexión al buscar la mercadería.');
        }
      });
    } else {
      inputDescripcionBusqueda.value = '';
      document.getElementById('input-mercaderia-id').value = '';
      mensajeBusqueda.classList.add('d-none');
    }
  }

  inputCodigoBusqueda.addEventListener('keydown', function (e) {
    if (e.key === 'Enter') {
      e.preventDefault();
      buscarMercaderiaPorCodigo(this.value.trim());
    }
  });


  /* ##################### AGREGAR MERCADERÍA ##################### */

  const formAgregar = document.querySelector('#formAgregarMercaderia');
  if (formAgregar) {
    formAgregar.addEventListener('submit', function (e) {
      e.preventDefault();
      $('#mensaje-error-agregar').addClass('d-none').find('.mensaje-texto').text('');

      const formData = new FormData(this);
      console.log('Datos del formulario:', Array.from(formData.entries()));

      $.ajax({
        url: '/trackpoint/public/index.php?route=/recepcion/noProductivos/ingreso_mercaderia&agregarMercaderia',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
          if (response.success) {
            localStorage.setItem('pestanaActiva', $('.nav-link.active').attr('id'));
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
	const formEditar = document.querySelector('#formEditarOperador');
	if (formEditar) {
		formEditar.addEventListener('submit', function (e) {
			e.preventDefault();

			// Limpiar cualquier mensaje de error antes de hacer la solicitud
			$('#mensaje-error-editar').addClass('d-none').find('.mensaje-texto').text('');

			const formData = new FormData(this);

			$.ajax({
				url: '/trackpoint/public/index.php?route=/recepcion/noProductivos/ingreso_mercaderia&editarMercaderia',
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
	var modalEditarOperador = document.getElementById('modalEditarOperador');
	if (modalEditarOperador) {
		modalEditarOperador.addEventListener('hidden.bs.modal', function () {
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
        url: '/trackpoint/public/index.php?route=/recepcion/noProductivos/ingreso_mercaderia&eliminarMercaderia',
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
        url: '/trackpoint/public/index.php?route=/recepcion/noProductivos/ingreso_mercaderia&guardarRecepcion',
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
        url: '/trackpoint/public/index.php?route=/recepcion/noProductivos/ingreso_mercaderia&cancelarRecepcion',
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
        error: function () {
          $('#modalMensajeLabel').text('Error inesperado');
          $('#textoModalMensaje').text('Hubo un problema al intentar guardar la recepción.');
          const modalMensaje = new bootstrap.Modal(document.getElementById('modalMensajeRecepcion'));
          modalMensaje.show();
        }
      });
    });
  }

});
