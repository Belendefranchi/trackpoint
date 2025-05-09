/* ##################### MODAL DE CREACION ##################### */
document.addEventListener('DOMContentLoaded', function () {

	// Interceptar el evento de apertura del modal de creación
	var modalCrearOperador = document.getElementById('modalCrearOperador');
	if (modalCrearOperador) {
		modalCrearOperador.addEventListener('show.bs.modal', function (event) {
			var button = event.relatedTarget;

			modalCrearOperador.querySelector('#crearNombre').value = button.getAttribute('data-nombre_completo');
			modalCrearOperador.querySelector('#crearEmail').value = button.getAttribute('data-email');
			modalCrearOperador.querySelector('#crearUsuario').value = button.getAttribute('data-username');
			modalCrearOperador.querySelector('#crearPassword').value = button.getAttribute('data-password');
			modalCrearOperador.querySelector('#crearRol').value = button.getAttribute('data-rol');
		});
	}

	// Interceptar el envío del formulario con AJAX
	document.querySelector('#formCrearOperador').addEventListener('submit', function (e) {
		e.preventDefault(); // Prevenir el envío normal del formulario

		var formData = new FormData(this); // Recoger los datos del formulario

		// Hacer la solicitud AJAX
		$.ajax({
			url: '/trackpoint/public/index.php?route=/configuracion/ABMs/operadores&crear', // Cambia esta URL si es necesario
			type: 'POST',
			data: formData,
			processData: false, // No procesar los datos
			contentType: false, // No establecer el tipo de contenido

				success: function (response) {
					console.log('Respuesta del servidor:', response); // <-- Agregado
					alert('Perfil creado con éxito');
					$('#modalCrearPerfil').modal('hide');
				},

				error: function (xhr, status, error) {
					console.error('Error AJAX:', xhr.responseText);
				}
		});
	});

});

/* ##################### MODAL DE EDICIÓN ##################### */

document.addEventListener('DOMContentLoaded', function () {

	// Interceptar el evento de apertura del modal de edición
	var modalEditarOperador = document.getElementById('modalEditarOperador');
	if (modalEditarOperador) {
		modalEditarOperador.addEventListener('show.bs.modal', function (event) {
			var button = event.relatedTarget;

			modalEditarOperador.querySelector('#editarOperadorId').value = button.getAttribute('data-id');
			modalEditarOperador.querySelector('#editarNombre').value = button.getAttribute('data-nombre_completo');
			modalEditarOperador.querySelector('#editarEmail').value = button.getAttribute('data-email');
			modalEditarOperador.querySelector('#editarUsuario').value = button.getAttribute('data-username');
			modalEditarOperador.querySelector('#editarPassword').value = button.getAttribute('data-password');
			modalEditarOperador.querySelector('#editarRol').value = button.getAttribute('data-rol');
			modalEditarOperador.querySelector('#editarActivo').value = button.getAttribute('data-activo');
		});
	}

});

/* ##################### MODAL DE ELIMINACIÓN ##################### */

document.addEventListener('DOMContentLoaded', function () {

	// Interceptar el evento de apertura del modal de eliminación
  var modalEliminarOperador = document.getElementById('modalEliminarOperador');
  if (modalEliminarOperador) {
    modalEliminarOperador.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;

      modalEliminarOperador.querySelector('#eliminarOperadorId').value = button.getAttribute('data-id');
      modalEliminarOperador.querySelector('#eliminarUsuario').value = button.getAttribute('data-username');
    });
  }





	
});