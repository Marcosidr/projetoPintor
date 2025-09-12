// Inicialização de componentes front-end customizados
// - Garante dropdowns funcionando mesmo após futuras injeções dinâmicas
// - Fecha dropdown ao clicar fora para melhorar UX em mobile

function initDropdowns() {
  if (!window.bootstrap) return;
  document.querySelectorAll('[data-bs-toggle="dropdown"]').forEach(function(el){
    if (!bootstrap.Dropdown.getInstance(el)) {
      try { new bootstrap.Dropdown(el); } catch (e) { console.warn('Falha init dropdown', e); }
    }
  });
}

document.addEventListener('DOMContentLoaded', function(){
  initDropdowns();

  // Fecha dropdown ao clicar fora
  document.addEventListener('click', function(ev){
    const openMenu = document.querySelector('.dropdown-menu.show');
    if (!openMenu) return;
    if (ev.target.closest('.dropdown')) return; // clique dentro
    const trigger = document.querySelector('[data-bs-toggle="dropdown"][aria-expanded="true"]');
    if (trigger) {
      try { bootstrap.Dropdown.getInstance(trigger)?.hide(); } catch (_) {}
    }
  });
});

// Expor função para possíveis re-renderizações futuras
window.AppUI = { initDropdowns };
