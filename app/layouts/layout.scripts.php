<!-- jQuery (obligatorio para DataTables) -->
<script src="/trackpoint/public/assets/js/plugins/jquery.js"></script>

<!-- Bootstrap JS -->
<script src="/trackpoint/public/assets/js/plugins/bootstrap.bundle.min.js"></script>

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
<script>
document.addEventListener('DOMContentLoaded', function () {
  const body = document.body;
  const modules = Array.from(document.querySelectorAll('.sidebar-module-has-panel'));
  const triggers = Array.from(document.querySelectorAll('[data-sidebar-trigger]'));
  const panels = Array.from(document.querySelectorAll('[data-sidebar-panel]'));
  const closeButtons = Array.from(document.querySelectorAll('[data-sidebar-close]'));
  const currentPath = window.location.pathname.replace(/\/$/, '');




  function enhanceDataTablesSearch(root) {
    (root || document).querySelectorAll('.dataTables_wrapper .dataTables_filter').forEach(function (filter) {
      const input = filter.querySelector('input[type="search"], input.form-control, input');
      if (!input) return;

      if (!input.getAttribute('placeholder') || !input.getAttribute('placeholder').trim()) {
        input.setAttribute('placeholder', 'Buscar');
      }

      input.setAttribute('aria-label', 'Buscar');

      const label = filter.querySelector('label');
      if (label) {
        label.setAttribute('aria-label', 'Buscar');
      }
    });
  }

  function enhanceScreenSearchBars(root) {
    (root || document).querySelectorAll('main .input-group').forEach(function (group) {
      const hasSearchButton = group.querySelector('.bi-search');
      const input = group.querySelector('input.form-control, input[type="text"], input[type="search"], .form-control');

      if (!hasSearchButton || !input) return;

      group.classList.add('screen-search-group');

      if (!input.getAttribute('placeholder') || !input.getAttribute('placeholder').trim()) {
        input.setAttribute('placeholder', 'Buscar');
      }

      if (!input.getAttribute('type')) {
        input.setAttribute('type', 'search');
      }

      let field = group.querySelector('.screen-search-field');
      let icon = group.querySelector('.screen-search-leading-icon');

      if (!field) {
        field = document.createElement('div');
        field.className = 'screen-search-field d-flex align-items-center flex-grow-1';
        group.insertBefore(field, input);
      }

      if (!icon) {
        icon = document.createElement('span');
        icon.className = 'screen-search-leading-icon bi bi-search';
      }

      if (icon.parentElement !== field) {
        field.insertBefore(icon, field.firstChild || null);
      }

      if (input.parentElement !== field) {
        field.appendChild(input);
      }
    });
  }

  if (!modules.length) return;

  function normalizePath(path) {
    if (!path) return '';
    return path.replace(window.location.origin, '').replace(/\/$/, '');
  }

  function closePanels() {
    modules.forEach(function (module) {
      module.classList.remove('sidebar-active');
    });

    triggers.forEach(function (trigger) {
      trigger.setAttribute('aria-expanded', 'false');
    });

    panels.forEach(function (panel) {
      panel.classList.remove('show');
      panel.setAttribute('aria-hidden', 'true');
    });

    body.classList.remove('sidebar-panel-open');
  }

  function openPanel(key) {
    const targetModule = document.querySelector('.sidebar-module[data-module-key="' + key + '"]');
    const targetTrigger = document.querySelector('[data-sidebar-trigger="' + key + '"]');
    const targetPanel = document.querySelector('[data-sidebar-panel="' + key + '"]');

    if (!targetModule || !targetTrigger || !targetPanel) return;

    closePanels();
    targetModule.classList.add('sidebar-active');
    targetTrigger.setAttribute('aria-expanded', 'true');
    targetPanel.classList.add('show');
    targetPanel.setAttribute('aria-hidden', 'false');
    body.classList.add('sidebar-panel-open');
  }

  triggers.forEach(function (trigger) {
    trigger.addEventListener('click', function (event) {
      event.preventDefault();
      event.stopPropagation();

      const key = trigger.getAttribute('data-sidebar-trigger');
      const panel = document.querySelector('[data-sidebar-panel="' + key + '"]');
      const isOpen = panel && panel.classList.contains('show');

      if (isOpen) {
        closePanels();
        return;
      }

      openPanel(key);
    });
  });

  closeButtons.forEach(function (button) {
    button.addEventListener('click', function (event) {
      event.preventDefault();
      event.stopPropagation();
      closePanels();
    });
  });

  panels.forEach(function (panel) {
    panel.addEventListener('click', function (event) {
      event.stopPropagation();
    });
  });

  document.addEventListener('click', function (event) {
    if (!event.target.closest('.sidebar-nav') && !event.target.closest('.sidebar-context-panel')) {
      closePanels();
    }
  });

  document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') {
      closePanels();
    }
  });

  document.querySelectorAll('.sidebar-context-item').forEach(function (item) {
    const hrefPath = normalizePath(item.getAttribute('href'));
    if (hrefPath && currentPath === hrefPath) {
      item.classList.add('sidebar-item-active');
      const module = item.closest('[data-sidebar-panel]');
      if (module) {
        openPanel(module.getAttribute('data-sidebar-panel'));
      }
    }
  });

  if (!body.classList.contains('sidebar-panel-open')) {
    const matchingModule = modules.find(function (module) {
      const routeMatch = module.getAttribute('data-route-match');
      return routeMatch && currentPath.indexOf(routeMatch.replace(/\/$/, '')) !== -1;
    });

    if (matchingModule) {
      openPanel(matchingModule.getAttribute('data-module-key'));
    }
  }



  enhanceScreenSearchBars(document);
  enhanceDataTablesSearch(document);

  const searchObserver = new MutationObserver(function () {
    enhanceScreenSearchBars(document);
  enhanceDataTablesSearch(document);
  });

  searchObserver.observe(document.body, { childList: true, subtree: true });

  document.querySelectorAll('[data-sidebar-search]').forEach(function (input) {
    input.addEventListener('input', function () {
      const key = input.getAttribute('data-sidebar-search');
      const list = document.querySelector('[data-sidebar-list="' + key + '"]');
      if (!list) return;

      const term = input.value.trim().toLowerCase();
      list.querySelectorAll('[data-sidebar-item]').forEach(function (item) {
        const text = item.textContent.toLowerCase();
        item.style.display = text.indexOf(term) !== -1 ? '' : 'none';
      });
    });
  });
});
</script>
