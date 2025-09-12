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

  // Envio AJAX do formulário de orçamento
  const formOrc = document.getElementById('formOrcamento');
  const overlay = document.getElementById('sucessoOverlay');
  if (formOrc) {
    formOrc.addEventListener('submit', async function(e){
      // Se a action for padrão e quisermos AJAX, intercepta
      if (!formOrc.dataset.ajaxBound) {
        e.preventDefault();
        await enviarOrcamentoAjax(formOrc, overlay);
      }
    }, { passive: false });
  }
});

// Expor função para possíveis re-renderizações futuras
window.AppUI = { initDropdowns };

async function enviarOrcamentoAjax(form, overlay){
  const submitBtn = form.querySelector('button[type="submit"]');
  toggleLoading(submitBtn, true);
  const formData = new FormData(form);
  try {
    const resp = await fetch(form.action, {
      method: 'POST',
      headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
      body: formData
    });
    let data = null;
    try { data = await resp.json(); } catch (_) {}
    if (!resp.ok || !data || data.ok === false) {
      const msg = (data && data.error) ? data.error : 'Falha ao enviar. Tente novamente';
      mostrarAlerta(form, msg, 'danger');
    } else {
      mostrarAlerta(form, 'Enviado com sucesso!', 'success');
      if (overlay) {
        overlay.style.display = 'flex';
        setTimeout(()=>{ overlay.style.display='none'; }, 2500);
      }
      form.reset();
    }
  } catch (err) {
    console.error(err);
    mostrarAlerta(form, 'Erro inesperado. Verifique sua conexão.', 'danger');
  } finally {
    toggleLoading(submitBtn, false);
  }
}

function toggleLoading(btn, loading){
  if (!btn) return;
  if (loading) btn.classList.add('btn-loading'); else btn.classList.remove('btn-loading');
}

function mostrarAlerta(form, texto, tipo){
  let area = form.querySelector('.area-alerta-orcamento');
  if (!area) {
    area = document.createElement('div');
    area.className = 'area-alerta-orcamento';
    form.prepend(area);
  }
  area.innerHTML = `<div class="alert alert-${tipo} py-2 mb-3">${escapeHtml(texto)}</div>`;
}

function escapeHtml(str){
  return String(str).replace(/[&<>'"]/g, s => ({'&':'&amp;','<':'&lt;','>':'&gt;','\'':'&#39;','"':'&quot;'}[s] || s));
}
