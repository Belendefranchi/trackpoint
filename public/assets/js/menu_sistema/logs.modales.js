document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.formLogHabilitar').forEach(form => {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      const formData = new FormData(this);

      $.ajax({
        url: this.action,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
          if (response.success) {
            location.reload();
          } else {
            alert('Error al habilitar el log: ' + (response.message || ''));
          }
        },
        error: function (xhr) {
          alert('Error al procesar la solicitud: ' + xhr.responseText);
        }
      });
    });
  });

  document.querySelectorAll('.formLogDeshabilitar').forEach(form => {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      const formData = new FormData(this);

      $.ajax({
        url: this.action,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
          if (response.success) {
            location.reload();
          } else {
            alert('Error al deshabilitar el log: ' + (response.message || ''));
          }
        },
        error: function (xhr) {
          alert('Error al procesar la solicitud: ' + xhr.responseText);
        }
      });
    });
  });
});
