
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
<script src="/trackpoint/public/assets/js/jquery.js"></script>

<!-- Bootstrap JS -->
<script src="/trackpoint/public/assets/js/bootstrap.min.js"></script>

<!-- Núcleo de DataTables -->
<script src="/trackpoint/public/assets/js/jquery.dataTables.min.js"></script>

<!-- Extensión ColResize -->
<script src="/trackpoint/public/assets/js/jquery.dataTables.colResize.js"></script>

<!-- Extensión ColReorder -->
<script src="/trackpoint/public/assets/js/dataTables.colReorder.min.js"></script>
<script src="/trackpoint/public/assets/js/colReorder.bootstrap5.min.js"></script>

<!-- Botones de DataTables -->
<script src="/trackpoint/public/assets/js/dataTables.buttons.min.js"></script>
<script src="/trackpoint/public/assets/js/buttons.bootstrap5.min.js"></script>
<script src="/trackpoint/public/assets/js/buttons.colVis.min.js"></script>
<script src="/trackpoint/public/assets/js/buttons.html5.min.js"></script>
<script src="/trackpoint/public/assets/js/buttons.print.min.js"></script>

<!-- pdfmake para exportar a PDF -->
<script src="/trackpoint/public/assets/js/pdfmake.min.js"></script>
<script src="/trackpoint/public/assets/js/vfs_fonts.js"></script>

<!-- JSZip para exportar a Excel -->
<script src="/trackpoint/public/assets/js/jszip.min.js"></script>

<!-- Logos base64 -->
<script src="/trackpoint/public/assets/js/logo_base64_100x109.js"></script>