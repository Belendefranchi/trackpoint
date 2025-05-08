  /* ##################### MODAL DE CREACION ##################### */
  document.addEventListener('DOMContentLoaded', function () {

    /* -------- MODAL CREAR OPERADOR -------- */
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

    /* -------- MODAL CREAR PERFIL -------- */
    var modalCrearPerfil = document.getElementById('modalCrearPerfil');
    if (modalCrearPerfil) {
      modalCrearPerfil.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;

        modalCrearPerfil.querySelector('#crearNombrePerfil').value = button.getAttribute('data-nombre');
        modalCrearPerfil.querySelector('#crearDescripcionPerfil').value = button.getAttribute('data-descripcion');
      });
    }

    // Interceptar el envío del formulario con AJAX
    document.querySelector('#formCrearPerfil').addEventListener('submit', function (e) {
      e.preventDefault(); // Prevenir el envío normal del formulario
      
      console.log('Formulario enviado:', this);
      console.log('Form crear perfil:', formCrearPerfil);

      var formData = new FormData(this); // Recoger los datos del formulario

      // Hacer la solicitud AJAX
      $.ajax({
        url: '/trackpoint/public/index.php?route=/configuracion/ABMs/perfiles&crear',
        type: 'POST',
        data: formData,
        processData: false, // No procesar los datos
        contentType: false, // No establecer el tipo de contenido
        success: function (response) {
          console.log('Respuesta del servidor:', response); // Log de la respuesta completa
          try {
            var jsonResponse = JSON.parse(response); // Intentar analizar la respuesta
            if (jsonResponse.success) {
              alert('Perfil creado con éxito');
              $('#modalCrearPerfil').modal('hide'); // Cerrar el modal
            } else {
              alert('Error al crear el perfil: ' + jsonResponse.message);
            }
          } catch (e) {
            console.error('Error al procesar la respuesta del servidor:', e);
            alert('Hubo un problema con la respuesta del servidor.');
          }
        },
        
        error: function () {
          alert('Error al guardar los datos');
        }
      });
    });

/*       document.querySelector('#formCrearOperador').addEventListener('submit', function (e) {
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
      }); */
      


    
  });



  /* ##################### MODAL DE EDICIÓN ##################### */

  document.addEventListener('DOMContentLoaded', function () {

    /* -------- MODAL EDITAR OPERADOR -------- */
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

    /* -------- MODAL EDITAR PERFIL -------- */
    var modalEditarPerfil = document.getElementById('modalEditarPerfil');
    if (modalEditarPerfil) {
      modalEditarPerfil.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;

        modalEditarPerfil.querySelector('#editarPerfilId').value = button.getAttribute('data-id');
        modalEditarPerfil.querySelector('#editarNombrePerfil').value = button.getAttribute('data-nombre');
        modalEditarPerfil.querySelector('#editarDescripcionPerfil').value = button.getAttribute('data-descripcion');
        modalEditarPerfil.querySelector('#editarActivoPerfil').value = button.getAttribute('data-activo');
      });
    }
  });


  /* ##################### MODAL DE ELIMINACIÓN ##################### */

  document.addEventListener('DOMContentLoaded', function () {

    /* -------- MODAL ELIMINAR OPERADOR -------- */
    var modalEliminarOperador = document.getElementById('modalEliminarOperador');
    if (modalEliminarOperador) {
      modalEliminarOperador.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;

        modalEliminarOperador.querySelector('#eliminarOperadorId').value = button.getAttribute('data-id');
        modalEliminarOperador.querySelector('#eliminarUsuario').value = button.getAttribute('data-username');
      });
    }

    /* -------- MODAL ELIMINAR PERFIL -------- */
    var modalEliminarPerfil = document.getElementById('modalEliminarPerfil');
    if (modalEliminarPerfil) {
      modalEliminarPerfil.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;

        modalEliminarPerfil.querySelector('#eliminarPerfilId').value = button.getAttribute('data-id');
        modalEliminarPerfil.querySelector('#eliminarNombrePerfil').value = button.getAttribute('data-nombre');
      });
    }
  });