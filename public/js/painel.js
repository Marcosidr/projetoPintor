// painel.js - lógica dinâmica do painel admin (refatorado)
(function(){
  const BASE_URL = (document.querySelector('meta[name="base-url"]')?.content || '').replace(/\/$/,'');
  const root      = document.getElementById('painelRoot');
  const isAdmin   = root?.dataset.isAdmin === '1';
  const csrfToken = (document.querySelector('meta[name="csrf-token"]')?.content) || (document.querySelector('input[name="_csrf"]')?.value) || '';
  const tabela    = document.getElementById('tabelaUsuarios');
  const modalEl   = document.getElementById('modalUsuario');
  const form      = document.getElementById('formUsuario');
  let modalInstance = null;
  let editingId     = null;
  const DEBUG = !!window.localStorage?.getItem('painel_debug');
  // Modal confirmação
  let modalConfirm=null; let actionPending=null; let actionUserId=null;
  const modalConfirmEl = document.getElementById('modalConfirmacao');
  const tituloConf = document.getElementById('tituloConfirmacao');
  const msgConf = document.getElementById('mensagemConfirmacao');
  const detalheConf = document.getElementById('detalheConfirmacao');
  const iconConf = document.getElementById('iconConfirmacao');
  const btnExecDelete = document.getElementById('btnExecutarDelete');
  const btnExecReset = document.getElementById('btnExecutarReset');
  if(modalConfirmEl){ modalConfirm = new bootstrap.Modal(modalConfirmEl); }

  function openConfirm(type, userId, contextData={}){
    actionPending = type; actionUserId = userId;
    if(!modalConfirm) return;
    btnExecDelete.classList.add('d-none'); btnExecReset.classList.add('d-none');
    iconConf.className='confirm-icon '+(type==='delete'?'delete':'reset');
    if(type==='delete'){
      tituloConf.textContent='Excluir Usuário';
      msgConf.textContent='Tem certeza que deseja excluir este usuário?';
      detalheConf.textContent='Esta ação é permanente e não pode ser desfeita.';
      btnExecDelete.classList.remove('d-none');
    } else {
      tituloConf.textContent='Resetar Senha';
      msgConf.textContent='Redefinir a senha deste usuário para "reset123"?';
      detalheConf.textContent='O usuário deverá alterar após o próximo login.';
      btnExecReset.classList.remove('d-none');
    }
    modalConfirm.show();
  }

  btnExecDelete?.addEventListener('click', async ()=>{
    if(!actionUserId) return; const id=actionUserId; modalConfirm.hide();
    try { const j= await request(`/api/admin/users/delete/${id}`,{method:'POST'}); toast(j.message,'success'); carregarUsuarios(); }
    catch(err){ toast(err.message,'danger'); }
    finally { actionPending=null; actionUserId=null; }
  });
  btnExecReset?.addEventListener('click', async ()=>{
    if(!actionUserId) return; const id=actionUserId; modalConfirm.hide();
    try { const j= await request(`/api/admin/users/reset/${id}`,{method:'POST'}); toast(j.message,'success'); }
    catch(err){ toast(err.message,'danger'); }
    finally { actionPending=null; actionUserId=null; }
  });

  function buildUrl(path){
    if(!path.startsWith('/')) return BASE_URL + '/' + path; // relativo
    return BASE_URL + path; // absoluto root da app
  }

  function toast(msg,type='success'){
    const stack = document.getElementById('toastStack');
    if(!stack){ alert(msg); return; }
    const el = document.createElement('div');
    el.className = `toast align-items-center text-bg-${type} border-0`;
    el.role='alert'; el.ariaLive='assertive'; el.ariaAtomic='true';
    el.innerHTML = `<div class="d-flex"><div class="toast-body">${escapeHtml(msg)}</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fechar"></button></div>`;
    stack.appendChild(el);
    new bootstrap.Toast(el,{delay:4000}).show();
  }

  function escapeHtml(str){ return (str||'').replace(/[&<>"]/g, s=>({"&":"&amp;","<":"&lt;",">":"&gt;","\"":"&quot;"}[s])); }

  async function request(path,{method='POST',data=null}={}){
    const url = buildUrl(path);
    const opts = { method, headers: {} };
    if(csrfToken) opts.headers['X-CSRF-Token'] = csrfToken;
    if(data){
      const fd = new FormData();
      Object.entries(data).forEach(([k,v])=> fd.append(k,v));
      if(!fd.get('_csrf') && csrfToken) fd.append('_csrf', csrfToken);
      opts.body = fd;
    }
    let res;
    try { res = await fetch(url, opts); } catch(e){ throw new Error('Falha de rede'); }
    let text = await res.text();
    let json = null;
    try { json = JSON.parse(text); } catch(_e) {
      // Se retornou HTML provavelmente sessão expirou ou foi redirecionado.
      if(text.trim().startsWith('<!DOCTYPE') || text.includes('<html')){
        throw new Error('Sessão expirada ou resposta inesperada. Recarregue a página.');
      }
    }
    if(DEBUG) console.debug('[painel request]', {path, method, status: res.status, json});
    if(!res.ok || json?.success === false){
      const msg = json?.message || (json?.errors? json.errors.join(', ') : `Erro HTTP ${res.status}`);
      throw new Error(msg);
    }
    return json;
  }

  async function carregarUsuarios(){
    if(!isAdmin || !tabela) return;
    try {
      const { data=[] } = await request('/api/admin/users', {method:'GET'});
      renderUsuarios(data);
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
  <td><span class="badge ${u.tipo==='admin'?'bg-success':'bg-secondary'} user-tipo">${escapeHtml(u.tipo)}</span></td>
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
      const url = editingId ? `/api/admin/users/update/${editingId}` : '/api/admin/users';
      const json = await request(url,{method:'POST',data});
      toast(json.message|| (editingId?'Atualizado':'Criado'), 'success');
      modalInstance?.hide();
      carregarUsuarios();
    } catch(err){ toast(err.message,'danger'); }
  });

  tabela?.addEventListener('click', async e=>{
    const btn = e.target.closest('button'); if(!btn) return;
    const tr = btn.closest('tr'); const id = tr?.dataset.userId;
    if(btn.classList.contains('btn-edit')) return openModalEdit(tr);
    if(btn.classList.contains('btn-delete')){ openConfirm('delete', id); return; }
    if(btn.classList.contains('btn-toggle')){
      try { const j= await request(`/api/admin/users/toggle/${id}`,{method:'POST'}); toast(j.message,'success'); carregarUsuarios(); } catch(err){ toast(err.message,'danger'); }
      return;
    }
    if(btn.classList.contains('btn-reset')){ openConfirm('reset', id); }
  });

  document.getElementById('btnNovoUsuario')?.addEventListener('click', openModalCreate);
  document.getElementById('btnNovoUsuario2')?.addEventListener('click', openModalCreate);

  // Gráfico Chart.js
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
    new Chart(canvas.getContext('2d'), { type: 'bar', data: { labels, datasets: [{ label: 'Orçamentos (7 dias)', data: values, backgroundColor: 'rgba(25,135,84,.65)', borderRadius:4 }]}, options: { responsive:true, maintainAspectRatio:false, scales:{ y:{ beginAtZero:true, ticks:{ precision:0 }}} }});
  }

  document.addEventListener('DOMContentLoaded', ()=>{
    if(isAdmin) carregarUsuarios();
    if(window.Chart) renderGraph(); else window.addEventListener('load', renderGraph);
  });
})();
