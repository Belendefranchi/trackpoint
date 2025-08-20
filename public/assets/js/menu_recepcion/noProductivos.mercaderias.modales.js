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
	const campos = ['proveedor_id', 'fecha_recepcion', 'nro_remito', 'fecha_remito', 'codigo_mercaderia', 'descripcion_mercaderia', 'unidades', 'peso_neto'];

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


  // Sincronizar checkboxes de código y descripción, y mantener mercaderia_id
  $('#codigo_mercaderia_checkbox, #descripcion_mercaderia_checkbox').on('change', function () {
      const estado = $(this).prop('checked');

      // Sincronizar ambos checkboxes
      $('#codigo_mercaderia_checkbox, #descripcion_mercaderia_checkbox').prop('checked', estado);

      // Si están tildados y hay datos en LocalStorage, aseguramos mercaderia_id
      if (estado) {
        const mercaderiaGuardada = localStorage.getItem('valor_mercaderia_id');

        if (mercaderiaGuardada) {
            const datos = JSON.parse(mercaderiaGuardada);

            // Aseguramos que mercaderia_id esté presente en el input hidden
            if (datos.mercaderia_id) {
                $('#mercaderia_id').val(datos.mercaderia_id);
            }
        }
      }
  });


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
      // Limpia los radios de selección de mercadería
      document.querySelectorAll('.seleccionar-mercaderia').forEach(radio => radio.checked = false);
      // Limpia los inputs hidden del modal
      modalSeleccionar.querySelector('#input-mercaderia-id').value = '';
      modalSeleccionar.querySelector('#input-codigo-mercaderia').value = '';
      modalSeleccionar.querySelector('#input-descripcion-mercaderia').value = '';
      modalSeleccionar.querySelector('#input-cantidad-propuesta').value = '';
      modalSeleccionar.querySelector('#input-peso-propuesto').value = '';
    });

    const checkboxDescripcion = document.getElementById('descripcion_mercaderia_checkbox');
    const inputDescripcionModal = document.getElementById('descripcion_mercaderia');
    const inputCodigoModal = document.getElementById('codigo_mercaderia');
    const inputMercaderiaIdModal = document.getElementById('mercaderia_id');
    const inputCantidadPropuestaModal = document.getElementById('unidades');
    const inputPesoPropuestoModal = document.getElementById('peso_neto');
    
    // Listener para guardar en localstorage descripción, código y id si se tilda el checkbox Descripción
    if (checkboxDescripcion) {
      checkboxDescripcion.addEventListener('change', () => {
        if (checkboxDescripcion.checked) {
          localStorage.setItem('fijar_descripcion_mercaderia', 'true');
          localStorage.setItem('valor_descripcion_mercaderia', inputDescripcionModal.value);

          localStorage.setItem('fijar_codigo_mercaderia', 'true');
          localStorage.setItem('valor_codigo_mercaderia', inputCodigoModal.value);

          localStorage.setItem('fijar_mercaderia_id', 'true');
          localStorage.setItem('valor_mercaderia_id', inputMercaderiaIdModal.value);
        } else {
          localStorage.removeItem('fijar_descripcion_mercaderia');
          localStorage.removeItem('valor_descripcion_mercaderia');

          localStorage.removeItem('fijar_codigo_mercaderia');
          localStorage.removeItem('valor_codigo_mercaderia');

          localStorage.removeItem('fijar_mercaderia_id');
          localStorage.removeItem('valor_mercaderia_id');
        }
      });
    }

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
        const cantidad = radioSeleccionado?.dataset.cantidadm || '';
        const peso = radioSeleccionado?.dataset.pesom || '';

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
        formData.append('unidades', cantidad);
        formData.append('peso_neto', peso);

        // Hacer la solicitud AJAX para pasar los datos de mercadería a la vista
        $.ajax({
          url: '/trackpoint/public/index.php?route=/recepcion/noProductivos/ingreso_mercaderia&seleccionarMercaderia',
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
                cantidad: response.cantidad_propuesta,
                peso: response.peso_propuesto
              });

              // Actualizar los inputs del modal con los datos de la mercadería seleccionada
              inputMercaderiaIdModal.value = response.mercaderia_id;
              inputDescripcionModal.value = response.descripcion_mercaderia;
              inputCodigoModal.value = response.codigo_mercaderia;
              inputCantidadPropuestaModal.value = response.cantidad_propuesta;
              inputPesoPropuestoModal.value = response.peso_propuesto;

              // Guardar en localStorage si el checkbox está tildado
              if (checkboxDescripcion && checkboxDescripcion.checked) {
                localStorage.setItem('valor_descripcion_mercaderia', response.descripcion_mercaderia);
                localStorage.setItem('valor_mercaderia_id', response.mercaderia_id);

                // Guardar también el código
                localStorage.setItem('fijar_codigo_mercaderia', 'true');
                localStorage.setItem('valor_codigo_mercaderia', response.codigo_mercaderia);
                localStorage.setItem('valor_unidades', response.cantidad_propuesta);
                localStorage.setItem('valor_peso_neto', response.peso_propuesto);
              }

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

  const checkboxCodigo = document.getElementById('codigo_mercaderia_checkbox');
  const inputCodigoBusqueda = document.getElementById('codigo_mercaderia');
  const inputDescripcionBusqueda = document.getElementById('descripcion_mercaderia');
  const inputMercaderiaIdBusqueda = document.getElementById('mercaderia_id');
  const inputUnidadesBusqueda = document.getElementById('unidades');
  const inputPesoNetoBusqueda = document.getElementById('peso_neto');
  const mensajeBusqueda = document.getElementById('mensaje-busqueda');
  
  if (checkboxCodigo) {
    // Listener para guardar en localstorage descripción, código y id si se tilda el checkbox Código
    checkboxCodigo.addEventListener('change', () => {
      if (checkboxCodigo.checked) {
        localStorage.setItem('fijar_codigo_mercaderia', 'true');
        localStorage.setItem('valor_codigo_mercaderia', inputCodigoBusqueda.value);

        localStorage.setItem('fijar_descripcion_mercaderia', 'true');
        localStorage.setItem('valor_descripcion_mercaderia', inputDescripcionBusqueda.value);

        localStorage.setItem('fijar_mercaderia_id', 'true');
        localStorage.setItem('valor_mercaderia_id', inputMercaderiaIdBusqueda.value);
      } else {
        localStorage.removeItem('fijar_codigo_mercaderia');
        localStorage.removeItem('valor_codigo_mercaderia');

        localStorage.removeItem('fijar_descripcion_mercaderia');
        localStorage.removeItem('valor_descripcion_mercaderia');

        localStorage.removeItem('fijar_mercaderia_id');
        localStorage.removeItem('valor_mercaderia_id');
      }
    });
  }

  function buscarMercaderiaPorCodigo(codigo) {
    if (codigo.length >= 2) {
      $.ajax({
        url: '/trackpoint/public/index.php?route=/recepcion/noProductivos/ingreso_mercaderia&seleccionarCodigoMercaderia',
        method: 'POST',
        data: { 'codigo_mercaderia': codigo },
        dataType: 'json',
        success: function (response) {
          if (response.success) {

            console.log('Datos de la mercadería seleccionada - código:', {
              id: response.mercaderia_id,
              codigo: response.codigo_mercaderia,
              descripcion: response.descripcion_mercaderia,
              unidades: response.cantidad_propuesta,
              peso_neto: response.peso_propuesto
            });

            inputMercaderiaIdBusqueda.value = response.mercaderia_id;
            inputDescripcionBusqueda.value = response.descripcion_mercaderia;
            inputCodigoBusqueda.value = response.codigo_mercaderia;
            inputUnidadesBusqueda.value = response.cantidad_propuesta;
            inputPesoNetoBusqueda.value = response.peso_propuesto;

            mensajeBusqueda.classList.add('d-none');

            // Si el checkbox está marcado, guardar automáticamente
            if (checkboxCodigo && checkboxCodigo.checked) {
              localStorage.setItem('valor_codigo_mercaderia', response.codigo_mercaderia);
              localStorage.setItem('valor_mercaderia_id', response.mercaderia_id);

              // Guardar también la descripción
              localStorage.setItem('fijar_descripcion_mercaderia', 'true');
              localStorage.setItem('valor_descripcion_mercaderia', response.descripcion_mercaderia);
              localStorage.setItem('valor_unidades', response.cantidad_propuesta);
              localStorage.setItem('valor_peso_neto', response.peso_propuesto);
            }


          } else {
            inputDescripcionBusqueda.value = '';
            inputMercaderiaIdBusqueda.value = '';
            $('#mensaje-busqueda').removeClass('d-none').find('.mensaje-texto').text(response.message);
          }
        },
        error: function () {
          inputDescripcionBusqueda.value = '';
          inputMercaderiaIdBusqueda.value = '';
          $('#mensaje-busqueda').removeClass('d-none').find('.mensaje-texto').text('Error de conexión al buscar la mercadería.');
        }
      });
    } else {
      inputDescripcionBusqueda.value = '';
      inputMercaderiaIdBusqueda.value = '';
      inputUnidadesBusqueda.value = '';
      inputPesoNetoBusqueda.value = '';
      mensajeBusqueda.classList.add('d-none');
    }
  }

  inputCodigoBusqueda.addEventListener('keydown', function (e) {
    if (e.key === 'Enter') {
      e.preventDefault();
      buscarMercaderiaPorCodigo(this.value.trim());
    }
  });

  /* ##################### VACIAR MERCADERÍA ##################### */

  const btnVaciarMercaderia = document.getElementById('btn-vaciar-mercaderia');
  if (btnVaciarMercaderia) {
    btnVaciarMercaderia.addEventListener('click', function () {
      // Limpiar todo el localStorage
      localStorage.clear();

      // Resetear el formulario
      document.getElementById('formAgregarMercaderia').reset();
    });
  }

  /* ##################### AGREGAR MERCADERÍA ##################### */

  const formAgregar = document.querySelector('#formAgregarMercaderia');
  if (formAgregar) {
    formAgregar.addEventListener('submit', function (e) {
      e.preventDefault();
      $('#mensaje-error-agregar').addClass('d-none').find('.mensaje-texto').text('');

      const proveedorId = document.getElementById('proveedor_id').value;
      const fechaRecepcion = document.getElementById('fecha_recepcion').value;
      const nroRemito = document.getElementById('nro_remito').value;
      const fechaRemito = document.getElementById('fecha_remito').value;
      const mercaderiaId = localStorage.getItem('valor_mercaderia_id');
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
        url: '/trackpoint/public/index.php?route=/recepcion/noProductivos/ingreso_mercaderia&agregarMercaderia',
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
