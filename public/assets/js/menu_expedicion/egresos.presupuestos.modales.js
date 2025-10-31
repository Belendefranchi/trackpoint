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
      modalSeleccionar.querySelector('#input-descripcion-mercaderia').value = '';
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
        formData.append('descripcion_mercaderia', descripcion);


        // Hacer la solicitud AJAX para pasar los datos de mercadería a la vista
        $.ajax({
          url: '/trackpoint/public/index.php?route=/expedicion/egresos/presupuestos&seleccionarMercaderia',
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
        url: '/trackpoint/public/index.php?route=/expedicion/egresos/presupuestos&seleccionarCodigoMercaderia',
        method: 'POST',
        data: { 'codigo_mercaderia': codigo },
        dataType: 'json',
        success: function (response) {
          if (response.success) {

            console.log('Datos de la mercadería seleccionada - código:', {
              id: response.mercaderia_id,
              codigo: response.codigo_mercaderia,
              descripcion: response.descripcion_mercaderia,
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
          inputCodigoBusqueda.value = '';
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

      const empresaId = document.getElementById('empresa_id').value;
      const sucursalId = document.getElementById('sucursal_id').value;
      const rubroId = document.getElementById('rubro_id').value;
      const fechaPresupuesto = document.getElementById('fecha_presupuesto').value;
      const fechaVencimiento = document.getElementById('fecha_vencimiento').value;
      const clienteId = document.getElementById('cliente_id').value;
      const direccionCliente = document.getElementById('direccion_cliente').value;
      const mercaderiaId = document.getElementById('mercaderia_id').value;
      const codigoMercaderia = document.getElementById('codigo_mercaderia').value;
      const cantidad = document.getElementById('cantidad').value;
      const precioVenta = document.getElementById('precio_venta').value;

      const formData = new FormData();
      formData.append('empresa_id', empresaId);
      formData.append('sucursal_id', sucursalId);
      formData.append('rubro_id', rubroId);
      formData.append('fecha_presupuesto', fechaPresupuesto);
      formData.append('fecha_vencimiento', fechaVencimiento);
      formData.append('cliente_id', clienteId);
      formData.append('direccion_cliente', direccionCliente);
      formData.append('mercaderia_id', mercaderiaId);
      formData.append('codigo_mercaderia', codigoMercaderia);
      formData.append('cantidad', cantidad);
      formData.append('precio_venta', precioVenta);

      console.log('Datos del formulario:', Array.from(formData.entries()));

      $.ajax({
        url: '/trackpoint/public/index.php?route=/expedicion/egresos/presupuestos&agregarMercaderia',
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

  /* ##################### MODAL DE EDICIÓN PRESUPUESTO ##################### */

	// Interceptar el evento de apertura del modal de edición
	var modalEditarPresupuesto = document.getElementById('modalEditarPresupuesto');
	if (modalEditarPresupuesto) {
		modalEditarPresupuesto.addEventListener('show.bs.modal', function (event) {
			console.log('Modal abrir - event.relatedTarget:', event.relatedTarget);
			const button = event.relatedTarget;

			if (!button) {
				console.warn('No se detectó el botón que activó el modal.');
				return;
			}

			modalEditarPresupuesto.querySelector('#editarPresupuestoId').value = button.getAttribute('data-id');
			modalEditarPresupuesto.querySelector('#editarEmpresaPresupuesto').value = button.getAttribute('data-empresa');
      modalEditarPresupuesto.querySelector('#editarSucursalPresupuesto').value = button.getAttribute('data-sucursal');
      modalEditarPresupuesto.querySelector('#editarRubroPresupuesto').value = button.getAttribute('data-rubro');
      modalEditarPresupuesto.querySelector('#editarFechaPresupuesto').value = button.getAttribute('data-fechap');
      modalEditarPresupuesto.querySelector('#editarFechaVencimientoPresupuesto').value = button.getAttribute('data-fechav');
      modalEditarPresupuesto.querySelector('#editarClientePresupuesto').value = button.getAttribute('data-cliente');
      modalEditarPresupuesto.querySelector('#editarDireccionClientePresupuesto').value = button.getAttribute('data-direccionc');
		});
	}

	// Interceptar el envío del formulario con AJAX
	const formEditarPresupuesto = document.querySelector('#formEditarPresupuesto');
	if (formEditarPresupuesto) {
		formEditarPresupuesto.addEventListener('submit', function (e) {
			e.preventDefault();

			// Limpiar cualquier mensaje de error antes de hacer la solicitud
			$('#mensaje-error-editar-presupuesto').addClass('d-none').find('.mensaje-texto').text('');

			const formData = new FormData(this);

			$.ajax({
				url: '/trackpoint/public/index.php?route=/expedicion/egresos/presupuestos&editarPresupuesto',
				type: 'POST',
				data: formData,
				processData: false,
				contentType: false,
				dataType: 'json',
				success: function (response) {
					console.log('Respuesta del servidor:', response);

					if (response.success) {
						console.log('Presupuesto modificado con éxito:', response.message);

						const tabla = $('#miTablaDetalle').DataTable();

						location.reload();
					} else {
						console.log('Error al modificar el presupuesto:', response.message);
						$('#mensaje-error-editar-presupuesto').removeClass('d-none').find('.mensaje-texto').text(response.message);
					}
				},
				error: function (xhr, status, error) {
					console.log('Error al guardar los datos');
					console.log('Código de estado:', xhr.status);
					console.log('Mensaje de error:', error);
					console.log('Respuesta del servidor:', xhr.responseText);
					$('#mensaje-error-editar-presupuesto').removeClass('d-none').find('.mensaje-texto').text('Hubo un error al intentar guardar los datos.');
				}
			});
		});
	}

	// Limpiar el mensaje de error al cerrar el modal
	if (modalEditarPresupuesto) {
		modalEditarPresupuesto.addEventListener('hidden.bs.modal', function () {
			var mensajeError = document.getElementById('mensaje-error-editar-presupuesto');
			if (mensajeError) {
				mensajeError.classList.add('d-none'); // Ocultar el div
				mensajeError.querySelector('.mensaje-texto').textContent = ''; // Limpiar el texto
			}
		});
	}
  
  /* ##################### MODAL DE ELIMINACIÓN PRESUPUESTO ##################### */

  // Interceptar el evento de apertura del modal de eliminación
  var modalEliminarPresupuesto = document.getElementById('modalEliminarPresupuesto');
  if (modalEliminarPresupuesto) {
    modalEliminarPresupuesto.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;

      modalEliminarPresupuesto.querySelector('#eliminarPresupuestoId').value = button.getAttribute('data-id');
    });
  }

  // Interceptar el envío del formulario con AJAX
  const formEliminarPresupuesto = document.querySelector('#formEliminarPresupuesto');
  if (formEliminarPresupuesto) {
    formEliminarPresupuesto.addEventListener('submit', function (e) {
      e.preventDefault();

      // Limpiar cualquier mensaje de error antes de hacer la solicitud
      $('#mensaje-error-eliminar-presupuesto').addClass('d-none').find('.mensaje-texto').text('');

      const formData = new FormData(this);

      $.ajax({
        url: '/trackpoint/public/index.php?route=/expedicion/egresos/presupuestos&eliminarPresupuesto',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
          console.log('Respuesta del servidor:', response);

          if (response.success) {
            console.log('Presupuesto eliminado con éxito:', response.message);

            const tabla = $('#miTablaDetalle').DataTable();

            location.reload();
          } else {
            console.log('Error al eliminar el presupuesto:', response.message);
            $('#mensaje-error-eliminar-presupuesto').removeClass('d-none').find('.mensaje-texto').text(response.message);
          }
        },
        error: function (xhr, status, error) {
          console.log('Error al guardar los datos');
          console.log('Código de estado:', xhr.status);
          console.log('Mensaje de error:', error);
          console.log('Respuesta del servidor:', xhr.responseText);
          $('#mensaje-error-eliminar-presupuesto').removeClass('d-none').find('.mensaje-texto').text('Hubo un error al intentar guardar los datos.');
        }
      });
    });
  }

  // Limpiar el mensaje de error al cerrar el modal
  if (modalEliminarPresupuesto) {
    modalEliminarPresupuesto.addEventListener('hidden.bs.modal', function () {
      var mensajeError = document.getElementById('mensaje-error-eliminar-presupuesto');
      if (mensajeError) {
        mensajeError.classList.add('d-none'); // Ocultar el div
        mensajeError.querySelector('.mensaje-texto').textContent = ''; // Limpiar el texto
      }
    });
  }

    /* ##################### MODAL DE EDICIÓN MERCADERÍA ##################### */

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
			modalEditarMercaderia.querySelector('#editarFechaPresupuestoMercaderia').value = button.getAttribute('data-fproduccion');
      modalEditarMercaderia.querySelector('#editarUnidadesMercaderia').value = button.getAttribute('data-unidades');
		});
	}

	// Interceptar el envío del formulario con AJAX
	const formEditar = document.querySelector('#formEditarMercaderia');
	if (formEditar) {
		formEditar.addEventListener('submit', function (e) {
			e.preventDefault();

			// Limpiar cualquier mensaje de error antes de hacer la solicitud
			$('#mensaje-error-editar-mercaderia').addClass('d-none').find('.mensaje-texto').text('');

			const formData = new FormData(this);

			$.ajax({
				url: '/trackpoint/public/index.php?route=/expedicion/egresos/presupuestos&editarMercaderia',
				type: 'POST',
				data: formData,
				processData: false,
				contentType: false,
				dataType: 'json',
				success: function (response) {
					console.log('Respuesta del servidor:', response);

					if (response.success) {
						console.log('Egresos Ventas modificado con éxito:', response.message);

						const tabla = $('#miTablaDetalle').DataTable();

						location.reload();
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
	var modalEditarMercaderia = document.getElementById('modalEditarMercaderia');
	if (modalEditarMercaderia) {
		modalEditarMercaderia.addEventListener('hidden.bs.modal', function () {
			var mensajeError = document.getElementById('mensaje-error-editar-mercaderia');
			if (mensajeError) {
				mensajeError.classList.add('d-none'); // Ocultar el div
				mensajeError.querySelector('.mensaje-texto').textContent = ''; // Limpiar el texto
			}
		});
	}
  
  /* ##################### MODAL DE ELIMINACIÓN MERCADERÍA ##################### */

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
      $('#mensaje-error-eliminar-mercaderia').addClass('d-none').find('.mensaje-texto').text('');

      const formData = new FormData(this);

      $.ajax({
        url: '/trackpoint/public/index.php?route=/expedicion/egresos/presupuestos&eliminarMercaderia',
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

            location.reload();
          } else {
            console.log('Error al eliminar la mercadería:', response.message);
            $('#mensaje-error-eliminar-mercaderia').removeClass('d-none').find('.mensaje-texto').text(response.message);
          }
        },
        error: function (xhr, status, error) {
          console.log('Error al guardar los datos');
          console.log('Código de estado:', xhr.status);
          console.log('Mensaje de error:', error);
          console.log('Respuesta del servidor:', xhr.responseText);
          $('#mensaje-error-eliminar-mercaderia').removeClass('d-none').find('.mensaje-texto').text('Hubo un error al intentar guardar los datos.');
        }
      });
    });
  }

  // Limpiar el mensaje de error al cerrar el modal
  var modalEliminarMercaderia = document.getElementById('modalEliminarMercaderia');
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
