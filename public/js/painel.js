// painel.js - lógica dinâmica do painel admin
(function(){
  const isAdmin = !!document.querySelector('#btnNovoUsuario, #btnNovoUsuario2');
  const csrfToken = (document.querySelector('input[name="_csrf"][value]')||{}).value || '';
  const tabela = document.getElementById('tabelaUsuarios');
  const modalEl = document.getElementById('modalUsuario');
  const form = document.getElementById('formUsuario');
  let modalInstance = null;
  let editingId = null;

  function toast(msg, type='success'){
    const stack = document.getElementById('toastStack'); if(!stack) return alert(msg);
    const id = 't'+Date.now()+Math.random().toString(16).slice(2);
    const div = document.createElement('div');
    div.className = `toast align-items-center text-bg-${type} border-0`;
    div.role='alert'; div.ariaLive='assertive'; div.ariaAtomic='true'; div.id=id;
    div.innerHTML = `<div class="d-flex"><div class="toast-body">${escapeHtml(msg)}</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fechar"></button></div>`;
    stack.appendChild(div);
    const t = new bootstrap.Toast(div,{delay:4000}); t.show();
  }

  function escapeHtml(str){ return (str||'').replace(/[&<>"]/g, s=>({"&":"&amp;","<":"&lt;",">":"&gt;","\"":"&quot;"}[s])); }

  async function api(url, data){
    const opts = {method:'POST'};
    if(data){
      const fd = new FormData();
      Object.entries(data).forEach(([k,v])=> fd.append(k,v));
      if(!fd.get('_csrf') && csrfToken) fd.append('_csrf', csrfToken);
      opts.body = fd;
    }
    const res = await fetch(url, opts);
    let json = null;
    try { json = await res.json(); } catch(e){}
    if(!res.ok || json?.success===false){
      const msg = json?.message || (json?.errors? json.errors.join(', '): `Erro HTTP ${res.status}`);
      throw new Error(msg);
    }
    return json;
  }

  async function carregarUsuarios(){
    if(!tabela) return;
    try {
      const res = await fetch('/api/admin/users');
      const json = await res.json();
      if(!json.success) throw new Error(json.message||'Falha ao listar');
      renderUsuarios(json.data||[]);
    } catch(e){ toast(e.message,'danger'); }
  }

  function renderUsuarios(users){
    const tbody = tabela.querySelector('tbody');
    tbody.innerHTML = '';
    if(!users.length){ tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted py-3">Nenhum usuário.</td></tr>'; return; }
    users.forEach(u=>{
      const tr = document.createElement('tr');
      tr.dataset.userId = u.id;
      tr.innerHTML = `
        <td>${u.id}</td>
        <td class="user-nome">${escapeHtml(u.nome)}</td>
        <td class="user-email">${escapeHtml(u.email)}</td>
        <td><span class="badge ${u.tipo==='admin'?'bg-danger':'bg-secondary'} user-tipo">${escapeHtml(u.tipo)}</span></td>
        <td class="small text-muted user-criado">${escapeHtml(u.created_at||'')}</td>
        ${isAdmin?`<td class="text-center">
          <div class="btn-group btn-group-sm" role="group">
            <button class="btn btn-outline-secondary btn-edit" title="Editar"><i class="bi bi-pencil-square"></i></button>
            <button class="btn btn-outline-warning btn-toggle" title="Toggle Admin"><i class="bi bi-shield-lock"></i></button>
            <button class="btn btn-outline-secondary btn-reset" title="Reset Senha"><i class="bi bi-key"></i></button>
            <button class="btn btn-outline-danger btn-delete" title="Excluir"><i class="bi bi-trash"></i></button>
          </div>
        </td>`:''}
      `;
      tbody.appendChild(tr);
    });
  }

  function openModalCreate(){ editingId=null; form.reset(); document.getElementById('tituloModalUsuario').textContent='Novo Usuário'; document.getElementById('labelSenhaHint').style.display=''; showModal(); }
  function openModalEdit(tr){
    editingId = tr.dataset.userId;
    form.reset();
    document.getElementById('tituloModalUsuario').textContent='Editar Usuário';
    document.getElementById('usuarioId').value = editingId;
    document.getElementById('usuarioNome').value = tr.querySelector('.user-nome').textContent;
    document.getElementById('usuarioEmail').value = tr.querySelector('.user-email').textContent;
    document.getElementById('usuarioTipo').value = tr.querySelector('.user-tipo').textContent.trim();
    document.getElementById('labelSenhaHint').style.display='none';
    showModal();
  }
  function showModal(){ if(!modalEl) return; modalInstance = modalInstance || new bootstrap.Modal(modalEl); modalInstance.show(); }

  form?.addEventListener('submit', async e=>{
    e.preventDefault();
    if(!form.checkValidity()) { form.classList.add('was-validated'); return; }
    const data = Object.fromEntries(new FormData(form).entries());
    try {
      if(editingId){
        const json = await api(`/api/admin/users/update/${editingId}`, data);
        toast(json.message||'Atualizado','success');
      } else {
        const json = await api('/api/admin/users', data);
        toast(json.message||'Criado','success');
      }
      modalInstance?.hide();
      await carregarUsuarios();
    } catch(err){ toast(err.message,'danger'); }
  });

  tabela?.addEventListener('click', async e=>{
    const btn = e.target.closest('button'); if(!btn) return;
    const tr = btn.closest('tr'); const id = tr?.dataset.userId;
    if(btn.classList.contains('btn-edit')){ openModalEdit(tr); }
    else if(btn.classList.contains('btn-delete')){
      if(confirm('Excluir usuário?')){ try { const j= await api(`/api/admin/users/delete/${id}`,{}); toast(j.message,'success'); carregarUsuarios(); } catch(err){ toast(err.message,'danger'); } }
    }
    else if(btn.classList.contains('btn-toggle')){
      try { const j = await api(`/api/admin/users/toggle/${id}`,{}); toast(j.message,'success'); carregarUsuarios(); } catch(err){ toast(err.message,'danger'); }
    }
    else if(btn.classList.contains('btn-reset')){
      if(confirm('Resetar senha para reset123?')){ try { const j= await api(`/api/admin/users/reset/${id}`,{}); toast(j.message,'success'); } catch(err){ toast(err.message,'danger'); } }
    }
  });

  document.getElementById('btnNovoUsuario')?.addEventListener('click', openModalCreate);
  document.getElementById('btnNovoUsuario2')?.addEventListener('click', openModalCreate);

  // Gráfico Chart.js
  function initChart(){
    const canvas = document.getElementById('chartOrcamentos7d'); if(!canvas || !window.Chart) return;
    try {
      const raw = JSON.parse(canvas.dataset.json||'null');
    } catch(_e){}
    // Dados do PHP já estão em window.graficoOrcamentos se inserirmos - vamos inserir agora:
  }

  // Injetar dados do gráfico a partir do markup PHP (fallback atual usa variáveis inline):
  (function injectGraph(){
    if(!window.Chart) return; // Chart.js carrega com defer, podemos esperar DOMContentLoaded
  })();

  function renderGraph(){
    const canvas = document.getElementById('chartOrcamentos7d'); if(!canvas || !window.Chart) return;
    // Captura dados do backend (renderizados em PHP no HTML via dataset JSON)
    let dados = {};
    // Como não colocamos dataset ainda, vamos reconstruir lendo elementos PHP no lado do servidor: colocaremos script inline seguro? Evitar inline => vamos criar dataset via JSON gerado server-side.
    // Solução: backend pode inserir <script id="graficoData" type="application/json">{...}</script> sem inline JS executável.
    const jsonEl = document.getElementById('graficoData');
    if(jsonEl){ try { dados = JSON.parse(jsonEl.textContent||'{}'); } catch(e){} }
    const labels = Object.keys(dados);
    const values = Object.values(dados);
    if(!labels.length) return;
    new Chart(canvas.getContext('2d'), {
      type: 'bar',
      data: { labels, datasets: [{ label: 'Orçamentos', data: values, backgroundColor: 'rgba(13,110,253,.6)', borderRadius:4 }]},
      options: { responsive:true, maintainAspectRatio:false, scales:{ y:{ beginAtZero:true, ticks:{ precision:0 }}} }
    });
  }

  document.addEventListener('DOMContentLoaded', ()=>{
    if(isAdmin) carregarUsuarios();
    // gráfico após Chart.js carregar
    if(window.Chart){ renderGraph(); }
    else window.addEventListener('load', renderGraph);
  });
})();
