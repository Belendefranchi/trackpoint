document.addEventListener('DOMContentLoaded', function () {


// Interceptar el envío del formulario con AJAX
  const formHabilitar = document.getElementById('formLogsHabilitar');
  if (formHabilitar) {
    formHabilitar.addEventListener('submit', function (e) {
      e.preventDefault();

      const formData = new FormData(this);

      $.ajax({
        url: '/trackpoint/public/index.php?route=/sistema/ABMs/logs&habilitar',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
          console.log('Respuesta del servidor:', response);

          if (response.success) {
            console.log('Log habilitado con éxito:', response.message);

            location.reload();
          } else {
            console.log('Error al habilitar el log:', response.message);
          }
        },
        error: function (xhr, status, error) {
          console.log('Error al guardar los datos');
          console.log('Código de estado:', xhr.status);
          console.log('Mensaje de error:', error);
          console.log('Respuesta del servidor:', xhr.responseText);
        }
      });
    });
  }

  const formDeshabilitar = document.getElementById('formLogsDeshabilitar');
  if (formDeshabilitar) {
    formDeshabilitar.addEventListener('submit', function (e) {
      e.preventDefault();

      const formData = new FormData(this);

      $.ajax({
        url: '/trackpoint/public/index.php?route=/sistema/ABMs/logs&deshabilitar',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
          console.log('Respuesta del servidor:', response);

          if (response.success) {
            console.log('Log deshabilitado con éxito:', response.message);

            location.reload();
          } else {
            console.log('Error al deshabilitar el log:', response.message);
          }
        },
        error: function (xhr, status, error) {
          console.log('Error al guardar los datos');
          console.log('Código de estado:', xhr.status);
          console.log('Mensaje de error:', error);
          console.log('Respuesta del servidor:', xhr.responseText);
        }
      });
    });
  }

});
