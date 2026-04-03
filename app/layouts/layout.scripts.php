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
  const SIDEBAR_STATE_KEY = 'trackpointSidebarState';
  const rootElement = document.documentElement;

  function clearPreopenSidebar() {
    rootElement.classList.remove('sidebar-preopen');
    rootElement.removeAttribute('data-sidebar-preopen-key');
  }


  function getSidebarState() {
    try {
      return JSON.parse(sessionStorage.getItem(SIDEBAR_STATE_KEY) || 'null');
    } catch (error) {
      return null;
    }
  }

  function setSidebarState(state) {
    try {
      sessionStorage.setItem(SIDEBAR_STATE_KEY, JSON.stringify(state));
    } catch (error) {}
  }




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
      const icon = group.querySelector('.screen-search-leading-icon');

      if (!field) {
        field = document.createElement('div');
        field.className = 'screen-search-field d-flex align-items-center flex-grow-1';
        group.insertBefore(field, input);
      }

      if (icon) {
        icon.remove();
      }

      if (input.parentElement !== field) {
        field.appendChild(input);
      }
    });
  }

  function applyDataTablesPaginationTheme(root) {
    (root || document).querySelectorAll('.dataTables_wrapper .dataTables_paginate').forEach(function (paginate) {
      paginate.querySelectorAll('.paginate_button, .page-item, .page-link').forEach(function (node) {
        node.style.setProperty('color', 'rgb(34 38 93 / 50%)', 'important');
        node.style.setProperty('border-color', 'rgb(34 38 93 / 10%)', 'important');
        node.style.setProperty('box-shadow', 'none', 'important');
      });

      paginate.querySelectorAll('.page-link').forEach(function (link) {
        link.style.setProperty('color', 'rgb(34 38 93 / 50%)', 'important');
        link.style.setProperty('border', '1px solid rgb(34 38 93 / 10%)', 'important');
        link.style.setProperty('background', '#FFFFFF', 'important');
        link.style.setProperty('background-color', '#FFFFFF', 'important');
        link.style.setProperty('box-shadow', 'none', 'important');
        link.style.setProperty('opacity', '1', 'important');
      });

      paginate.querySelectorAll('.page-item.disabled, .paginate_button.disabled').forEach(function (node) {
        node.style.setProperty('opacity', '1', 'important');
      });

      paginate.querySelectorAll('.page-item.disabled .page-link, .paginate_button.disabled .page-link, .paginate_button.disabled, .paginate_button.previous, .paginate_button.next, .paginate_button.current').forEach(function (node) {
        node.style.setProperty('color', 'rgb(34 38 93 / 50%)', 'important');
        node.style.setProperty('border', '1px solid rgb(34 38 93 / 10%)', 'important');
        node.style.setProperty('background', '#FFFFFF', 'important');
        node.style.setProperty('background-color', '#FFFFFF', 'important');
        node.style.setProperty('opacity', '1', 'important');
        node.style.setProperty('box-shadow', 'none', 'important');
      });
    });
  }

  let dataTablesLayoutTimer = null;

  function refreshDataTablesLayout() {
    if (!window.jQuery || !window.jQuery.fn || !window.jQuery.fn.dataTable) return;

    window.requestAnimationFrame(function () {
      try {
        const tablesApi = window.jQuery.fn.dataTable.tables({ visible: true, api: true });
        if (tablesApi && tablesApi.columns) {
          tablesApi.columns.adjust();
        }
      } catch (error) {}

      document.querySelectorAll('.dataTables_scroll').forEach(function (scrollWrapper) {
        const bodyTable = scrollWrapper.querySelector('.dataTables_scrollBody table');
        const headInner = scrollWrapper.querySelector('.dataTables_scrollHeadInner');
        const headTable = headInner ? headInner.querySelector('table') : null;

        if (!bodyTable || !headInner || !headTable) return;

        const bodyWidth = Math.ceil(bodyTable.getBoundingClientRect().width);
        if (!bodyWidth) return;

        headInner.style.width = bodyWidth + 'px';
        headTable.style.width = bodyWidth + 'px';
      });

      applyDataTablesPaginationTheme(document);
    });
  }

  function scheduleDataTablesLayoutRefresh(delay) {
    if (dataTablesLayoutTimer) {
      window.clearTimeout(dataTablesLayoutTimer);
    }

    dataTablesLayoutTimer = window.setTimeout(function () {
      refreshDataTablesLayout();
      window.setTimeout(refreshDataTablesLayout, 120);
      window.setTimeout(refreshDataTablesLayout, 360);
    }, typeof delay === 'number' ? delay : 0);
  }

  if (!modules.length) return;

  function normalizePath(path) {
    if (!path) return '';
    return path.replace(window.location.origin, '').replace(/\/$/, '');
  }

  function closePanels(rememberState = true) {
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
    clearPreopenSidebar();

    if (rememberState) {
      setSidebarState({ mode: 'closed' });
    }

    scheduleDataTablesLayoutRefresh(80);
  }

  function openPanel(key, rememberState = true) {
    const targetModule = document.querySelector('.sidebar-module[data-module-key="' + key + '"]');
    const targetTrigger = document.querySelector('[data-sidebar-trigger="' + key + '"]');
    const targetPanel = document.querySelector('[data-sidebar-panel="' + key + '"]');

    if (!targetModule || !targetTrigger || !targetPanel) return;

    closePanels(false);
    targetModule.classList.add('sidebar-active');
    targetTrigger.setAttribute('aria-expanded', 'true');
    targetPanel.classList.add('show');
    targetPanel.setAttribute('aria-hidden', 'false');
    body.classList.add('sidebar-panel-open');
    clearPreopenSidebar();

    if (rememberState) {
      setSidebarState({ mode: 'open', key: key });
    }

    scheduleDataTablesLayoutRefresh(80);
  }

  function collapsePanelKeepActive(key, rememberState = true) {
    const targetModule = document.querySelector('.sidebar-module[data-module-key="' + key + '"]');
    const targetTrigger = document.querySelector('[data-sidebar-trigger="' + key + '"]');
    const targetPanel = document.querySelector('[data-sidebar-panel="' + key + '"]');

    if (!targetModule || !targetTrigger || !targetPanel) return;

    modules.forEach(function (module) {
      if (module !== targetModule) {
        module.classList.remove('sidebar-active');
      }
    });

    triggers.forEach(function (trigger) {
      if (trigger !== targetTrigger) {
        trigger.setAttribute('aria-expanded', 'false');
      }
    });

    panels.forEach(function (panel) {
      if (panel !== targetPanel) {
        panel.classList.remove('show');
        panel.setAttribute('aria-hidden', 'true');
      }
    });

    targetModule.classList.add('sidebar-active');
    targetTrigger.setAttribute('aria-expanded', 'false');
    targetPanel.classList.remove('show');
    targetPanel.setAttribute('aria-hidden', 'true');
    body.classList.remove('sidebar-panel-open');
    clearPreopenSidebar();

    if (rememberState) {
      setSidebarState({ mode: 'collapsed', key: key });
    }

    scheduleDataTablesLayoutRefresh(80);
  }

  triggers.forEach(function (trigger) {
    trigger.addEventListener('click', function (event) {
      event.preventDefault();
      event.stopPropagation();

      const key = trigger.getAttribute('data-sidebar-trigger');
      const panel = document.querySelector('[data-sidebar-panel="' + key + '"]');
      const isOpen = panel && panel.classList.contains('show');

      if (isOpen) {
        collapsePanelKeepActive(key);
        return;
      }

      openPanel(key);
    });
  });

  closeButtons.forEach(function (button) {
    button.addEventListener('click', function (event) {
      event.preventDefault();
      event.stopPropagation();

      const key = button.getAttribute('data-sidebar-close');
      if (!key) return;

      collapsePanelKeepActive(key);
    });
  });

  panels.forEach(function (panel) {
    panel.addEventListener('click', function (event) {
      event.stopPropagation();
    });
  });

  document.addEventListener('click', function (event) {
    if (
      event.target.closest('.modal') ||
      event.target.closest('.modal-backdrop') ||
      event.target.classList.contains('modal-backdrop') ||
      document.body.classList.contains('modal-open')
    ) {
      return;
    }

    if (!event.target.closest('.sidebar-nav') && !event.target.closest('.sidebar-context-panel')) {
      const activeModule = document.querySelector('.sidebar-module.sidebar-active');
      if (activeModule) {
        collapsePanelKeepActive(activeModule.getAttribute('data-module-key'));
      } else {
        closePanels();
      }
    }
  });

  document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') {
      closePanels();
    }
  });

  let activeModuleKey = null;

  document.querySelectorAll('.sidebar-context-item').forEach(function (item) {
    const hrefPath = normalizePath(item.getAttribute('href'));
    if (hrefPath && currentPath === hrefPath) {
      item.classList.add('sidebar-item-active');
      const module = item.closest('[data-sidebar-panel]');
      if (module && !activeModuleKey) {
        activeModuleKey = module.getAttribute('data-sidebar-panel');
      }
    }
  });

  if (!activeModuleKey) {
    const matchingModule = modules.find(function (module) {
      const routeMatch = module.getAttribute('data-route-match');
      return routeMatch && currentPath.indexOf(routeMatch.replace(/\/$/, '')) !== -1;
    });

    if (matchingModule) {
      activeModuleKey = matchingModule.getAttribute('data-module-key');
    }
  }

  const savedSidebarState = getSidebarState();

  if (savedSidebarState && savedSidebarState.mode === 'open' && savedSidebarState.key) {
    const keyToOpen = activeModuleKey || savedSidebarState.key;
    openPanel(keyToOpen, false);
  } else if (savedSidebarState && savedSidebarState.mode === 'collapsed' && savedSidebarState.key) {
    const collapsedKey = activeModuleKey || savedSidebarState.key;
    const collapsedModule = document.querySelector('.sidebar-module[data-module-key="' + collapsedKey + '"]');
    const collapsedTrigger = document.querySelector('[data-sidebar-trigger="' + collapsedKey + '"]');

    if (collapsedModule) {
      modules.forEach(function (module) {
        module.classList.remove('sidebar-active');
      });
      collapsedModule.classList.add('sidebar-active');
    }

    if (collapsedTrigger) {
      triggers.forEach(function (trigger) {
        trigger.setAttribute('aria-expanded', 'false');
      });
      collapsedTrigger.setAttribute('aria-expanded', 'false');
    }

    panels.forEach(function (panel) {
      panel.classList.remove('show');
      panel.setAttribute('aria-hidden', 'true');
    });

    body.classList.remove('sidebar-panel-open');
  } else if (savedSidebarState && savedSidebarState.mode === 'closed') {
    closePanels(false);
  } else if (activeModuleKey) {
    openPanel(activeModuleKey, false);
  }

  requestAnimationFrame(function () {
    clearPreopenSidebar();
  });

  enhanceScreenSearchBars(document);
  enhanceDataTablesSearch(document);
  scheduleDataTablesLayoutRefresh(0);

  const searchObserver = new MutationObserver(function () {
    enhanceScreenSearchBars(document);
    enhanceDataTablesSearch(document);
    scheduleDataTablesLayoutRefresh(0);
  });

  searchObserver.observe(document.body, { childList: true, subtree: true });

  window.addEventListener('resize', function () {
    scheduleDataTablesLayoutRefresh(0);
  });

  document.addEventListener('shown.bs.tab', function () {
    scheduleDataTablesLayoutRefresh(0);
  });

  document.addEventListener('shown.bs.collapse', function () {
    scheduleDataTablesLayoutRefresh(0);
  });

  document.addEventListener('shown.bs.modal', function () {
    scheduleDataTablesLayoutRefresh(0);
  });

  document.addEventListener('click', function (event) {
    if (event.target.closest('.paginate_button')) {
      scheduleDataTablesLayoutRefresh(0);
    }
  });

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
