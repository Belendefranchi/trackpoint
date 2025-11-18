document.addEventListener('DOMContentLoaded', function () {

  window.addEventListener("error", function(e) {
    console.log("ERROR CAPTURADO:", e.message, "→", e.filename + ":" + e.lineno);
  });

    
  /* ##################### MODAL DE CREACION ##################### */
  // Interceptar el evento de apertura del modal de creación
  var modalCrearMercaderia = document.getElementById('modalCrearMercaderia');
  if (modalCrearMercaderia) {
    modalCrearMercaderia.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;

      $('#crearGrupoMercaderia').val('');
      $('#crearSubgrupoMercaderia').empty().append('<option value=""></option>');

    });

    // Vincular grupo y subgrupo
    var grupoSelect = document.getElementById("crearGrupoMercaderia");
    var subgrupoSelect = document.getElementById("crearSubgrupoMercaderia");

    if (grupoSelect) {
      grupoSelect.addEventListener("change", function () {
        var grupoId = grupoSelect.value;

        if (grupoId) {
          $.ajax({
            url: '/trackpoint/public/index.php?route=/configuracion/ABMs/mercaderias&cargar_subgrupos',
            type: 'POST',
            dataType: 'json',
            data: {
              grupo_id: grupoId
            },
            success: function (response) {
              console.log('Respuesta del servidor:', response);

              let $subgrupo = $(subgrupoSelect);
              $subgrupo.empty(); // Limpio el select

              if (response.success) {
                // Cargo la opción por defecto
                $subgrupo.append('<option value=""></option>');

                // Recorro y agrego los subgrupos
                $.each(response.data, function (i, subgrupo) {
                  $subgrupo.append(
                    $('<option>', {
                      value: subgrupo.subgrupo_id,
                      text: subgrupo.codigo
                    })
                  );
                });

                // Reinicio el valor seleccionado para evitar que quede el viejo
                subgrupoSelect.value = "";
              } else {
                $subgrupo.append('<option value="">No hay subgrupos disponibles</option>');
              }
            },
            error: function (xhr, status, error) {
              console.error('Error al obtener subgrupos:', error);
            }
          });
        } else {
          // Si se deselecciona el grupo, limpio también el subgrupo
          $(subgrupoSelect).empty().append('<option value=""></option>');
          subgrupoSelect.value = "";
        }
      });
    }
  }

  // Interceptar el envío del formulario con AJAX
  const formCrear = document.querySelector('#formCrearMercaderia');
  if (formCrear) {
    formCrear.addEventListener('submit', function (e) {
      e.preventDefault();

      // Limpiar cualquier mensaje de error antes de hacer la solicitud
      $('#mensaje-error-crear').addClass('d-none').find('.mensaje-texto').text('');

      const formData = new FormData(this);

      $.ajax({
        url: '/trackpoint/public/index.php?route=/configuracion/ABMs/mercaderias&crear',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
          console.log('Respuesta del servidor:', response);

          if (response.success) {
            console.log('Mercadería creada con éxito:', response.message);

            location.reload();
          } else {
            console.log('Error al crear la mercadería:', response.message);
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
  var modalCrearMercaderia = document.getElementById('modalCrearMercaderia');
	if (modalCrearMercaderia) {
    modalCrearMercaderia.addEventListener('hidden.bs.modal', function () {
      var mensajeError = document.getElementById('mensaje-error-crear');
      if (mensajeError) {
        mensajeError.classList.add('d-none'); // Ocultar el div
        mensajeError.querySelector('.mensaje-texto').textContent = ''; // Limpiar el texto
      }
    });
  }


  /* ##################### MODAL DE EDICIÓN ##################### */
  // Interceptar el evento de apertura del modal de edición
  var modalEditarMercaderia = document.getElementById('modalEditarMercaderia');
  if (modalEditarMercaderia) {
    modalEditarMercaderia.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;

      modalEditarMercaderia.querySelector('#editarMercaderiaId').value = button.getAttribute('data-id');
      modalEditarMercaderia.querySelector('#editarCodigoMercaderia').value = button.getAttribute('data-codigo');
      modalEditarMercaderia.querySelector('#editarDescripcionMercaderia').value = button.getAttribute('data-descripcion');
      modalEditarMercaderia.querySelector('#editarUnidadMedidaMercaderia').value = button.getAttribute('data-unidad');
      modalEditarMercaderia.querySelector('#editarGrupoMercaderia').value = button.getAttribute('data-grupo');
      modalEditarMercaderia.querySelector('#editarEnvasePriMercaderia').value = button.getAttribute('data-envasepri');
      modalEditarMercaderia.querySelector('#editarEnvaseSecMercaderia').value = button.getAttribute('data-envasesec');
      modalEditarMercaderia.querySelector('#editarMarcaMercaderia').value = button.getAttribute('data-marca');
      modalEditarMercaderia.querySelector('#editarCodigoExternoMercaderia').value = button.getAttribute('data-codext');
      modalEditarMercaderia.querySelector('#editarCantidadPropuestaMercaderia').value = button.getAttribute('data-cantidadprop');
      modalEditarMercaderia.querySelector('#editarPesoPropuestoMercaderia').value = button.getAttribute('data-pesoprop');
      modalEditarMercaderia.querySelector('#editarPesoMinMercaderia').value = button.getAttribute('data-pesomin');
      modalEditarMercaderia.querySelector('#editarPesoMaxMercaderia').value = button.getAttribute('data-pesomax');
      modalEditarMercaderia.querySelector('#editarPrecioCompraMercaderia').value = button.getAttribute('data-precioc');
      modalEditarMercaderia.querySelector('#editarPrecioVentaMercaderia').value = button.getAttribute('data-preciov');
      modalEditarMercaderia.querySelector('#editarEtiquetaSecMercaderia').value = button.getAttribute('data-etiquetasec');
      modalEditarMercaderia.querySelector('#editarActivoMercaderia').value = button.getAttribute('data-activo');

      var grupoSelect = document.getElementById("editarGrupoMercaderia");
      var subgrupoSelect = document.getElementById("editarSubgrupoMercaderia");
      var subgrupoIdSeleccionado = button.getAttribute('data-subgrupo');

      if (grupoSelect) {

        // Forzar carga de subgrupos al abrir el modal
        if (grupoSelect.value) {
          $.ajax({
            url: '/trackpoint/public/index.php?route=/configuracion/ABMs/mercaderias&cargar_subgrupos',
            type: 'POST',
            dataType: 'json',
            data: {
              grupo_id: grupoSelect.value
            },
            success: function (response) {
              let $subgrupo = $(subgrupoSelect);
              $subgrupo.empty();

              if (response.success) {
                $subgrupo.append('<option value=""></option>');
                $.each(response.data, function (i, subgrupo) {
                  $subgrupo.append(
                    $('<option>', {
                      value: subgrupo.subgrupo_id,
                      text: subgrupo.codigo
                    })
                  );
                });

                // Seleccionar el subgrupo asignado a la mercadería
                if (subgrupoIdSeleccionado) {
                  $subgrupo.val(subgrupoIdSeleccionado);
                }
              } else {
                $subgrupo.append('<option value="">No hay subgrupos disponibles</option>');
              }
            },
            error: function (xhr, status, error) {
              console.error('Error al obtener subgrupos:', error);
              $(subgrupoSelect).empty().append('<option value="">Error al cargar subgrupos</option>');
            }
          });
        }

        // Cargar subgrupos al cambiar el grupo
        grupoSelect.addEventListener("change", function () {
          
          // Disparar la carga de subgrupos en base al grupo ya asignado
          var grupoId = grupoSelect.value;

          if (grupoId) {
            $.ajax({
              url: '/trackpoint/public/index.php?route=/configuracion/ABMs/mercaderias&cargar_subgrupos',
              type: 'POST',
              dataType: 'json',
              data: {
                grupo_id: grupoId
              },
              success: function (response) {
                console.log('Respuesta del servidor:', response);

                let $subgrupo = $(subgrupoSelect);
                $subgrupo.empty(); // Limpio el select

                if (response.success) {
                  // Cargo la opción por defecto
                  $subgrupo.append('<option value=""></option>');

                  // Recorro y agrego los subgrupos
                  $.each(response.data, function (i, subgrupo) {
                    $subgrupo.append(
                      $('<option>', {
                        value: subgrupo.subgrupo_id,
                        text: subgrupo.codigo
                      })
                    );
                  });

                  // Recién acá selecciono el valor que ya tenía la mercadería
                  if (subgrupoIdSeleccionado) {
                    $subgrupo.val(subgrupoIdSeleccionado);
                  }

                } else {
                  $subgrupo.append('<option value="">No hay subgrupos disponibles</option>');
                }
              },
              error: function (xhr, status, error) {
                console.error('Error al obtener subgrupos:', error);
                console.error('Respuesta del servidor:', xhr.responseText);
                $(subgrupoSelect).empty().append('<option value="">Error al cargar subgrupos</option>');
              }
            });
          } else {
            // Si se deselecciona el grupo, limpio también el subgrupo
            $(subgrupoSelect).empty().append('<option value=""></option>');
            subgrupoSelect.value = "";
          }
        });
      }
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
        url: '/trackpoint/public/index.php?route=/configuracion/ABMs/mercaderias&editar',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
          console.log('Respuesta del servidor:', response);

          if (response.success) {
            console.log('Mercadería modificada con éxito:', response.message);

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

      modalEliminarMercaderia.querySelector('#eliminarMercaderiaId').value = button.getAttribute('data-ide');
      modalEliminarMercaderia.querySelector('#eliminarCodigoMercaderia').value = button.getAttribute('data-codigoe');
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
				url: '/trackpoint/public/index.php?route=/configuracion/ABMs/mercaderias&eliminar',
				type: 'POST',
				data: formData,
				processData: false,
				contentType: false,
				dataType: 'json',
				success: function (response) {
					console.log('Respuesta del servidor:', response);

					if (response.success) {
						console.log('Mercadería eliminada con éxito:', response.message);

						location.reload();
					} else {
						console.log('Error al eliminar la mercadería:', response.message);
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


});