
      <!-- Contenido principal -->
      <main class="col-md-9 col-lg-10 p-4">
        <?php if (isset($content) && file_exists($content)) {
          require_once $content;
        } else { ?>
            <div class="d-flex justify-content-center align-items-center" style="height: 70vh; position: relative;">
<!--                 <img src="/trackpoint/public/assets/images/logo_fondo_transparente.png" 
                  alt="Fondo" 
                  style="opacity: 0.4; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);" /> -->
            </div>
        <?php } ?>
      </main>
    </div>
  </div>


<!-- jQuery (obligatorio para DataTables) -->
<script src="/trackpoint/public/assets/js/plugins/jquery.js"></script>

<!-- Bootstrap JS -->
<script src="/trackpoint/public/assets/js/plugins/bootstrap.min.js"></script>

<!-- Núcleo de DataTables -->
<script src="/trackpoint/public/assets/js/plugins/jquery.dataTables.min.js"></script>

<!-- Extensión ColResize -->
<script src="/trackpoint/public/assets/js/plugins/jquery.dataTables.colResize.js"></script>

<!-- Extensión ColReorder -->
<script src="/trackpoint/public/assets/js/plugins/dataTables.colReorder.min.js"></script>
<script src="/trackpoint/public/assets/js/plugins/colReorder.bootstrap5.min.js"></script>

<!-- Botones de DataTables -->
<script src="/trackpoint/public/assets/js/plugins/dataTables.buttons.min.js"></script>
<script src="/trackpoint/public/assets/js/plugins/buttons.bootstrap5.min.js"></script>
<script src="/trackpoint/public/assets/js/plugins/buttons.colVis.min.js"></script>
<script src="/trackpoint/public/assets/js/plugins/buttons.html5.min.js"></script>
<script src="/trackpoint/public/assets/js/plugins/buttons.print.min.js"></script>

<!-- pdfmake para exportar a PDF -->
<script src="/trackpoint/public/assets/js/plugins/pdfmake.min.js"></script>
<script src="/trackpoint/public/assets/js/plugins/vfs_fonts.js"></script>

<!-- JSZip para exportar a Excel -->
<script src="/trackpoint/public/assets/js/plugins/jszip.min.js"></script>

<!-- Logos base64 -->
<script src="/trackpoint/public/assets/js/logos/logo_base64_100x109.js"></script>