// painel.js - lógica dinâmica do painel admin (refatorado)
(function(){
  const BASE_URL = (document.querySelector('meta[name="base-url"]')?.content || '').replace(/\/$/,'');
  const root      = document.getElementById('painelRoot');
  const isAdmin   = root?.dataset.isAdmin === '1';
  const csrfToken = (document.querySelector('meta[name="csrf-token"]')?.content) || (document.querySelector('input[name="_csrf"]')?.value) || '';
  // Usuarios elementos
  const tabela    = document.getElementById('tabelaUsuarios');
  const modalEl   = document.getElementById('modalUsuario');
  const form      = document.getElementById('formUsuario');
  // Serviços elementos
  const tabelaServicos = document.getElementById('tabelaServicos');
  const modalServicoEl = document.getElementById('modalServico');
  const formServico    = document.getElementById('formServico');
  let modalServicoInstance = null; let editingServicoId = null;
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

  function openConfirm(type, entityId, contextData={}) {
    actionPending = type;
    actionUserId = entityId;
    if (!modalConfirm) return;

    // Reset botões
    btnExecDelete.classList.add('d-none');
    btnExecReset.classList.add('d-none');

    const isDelete = (type === 'delete' || type === 'delete-servico');
    iconConf.className = 'confirm-icon ' + (isDelete ? 'delete' : 'reset');

    if (isDelete) {
      const alvo = contextData.entityLabel || 'registro';
      const tituloEntidade = (contextData.titlePrefix || '') + (contextData.entityTitle || '');
      tituloConf.textContent = tituloEntidade ? 'Excluir ' + tituloEntidade : 'Confirmar exclusão';
      msgConf.textContent = 'Tem certeza que deseja excluir ' + (alvo === 'registro' ? 'este ' + alvo : 'este ' + alvo) + '?';
      detalheConf.textContent = 'Esta ação é permanente e não pode ser desfeita.';
      btnExecDelete.classList.remove('d-none');
    } else {
      tituloConf.textContent = 'Resetar Senha';
      msgConf.textContent = 'Redefinir a senha deste usuário para "reset123"?';
      detalheConf.textContent = 'O usuário deverá alterar após o próximo login.';
      btnExecReset.classList.remove('d-none');
    }

    modalConfirm.show();
  }

  btnExecDelete?.addEventListener('click', async ()=>{
    if(!actionUserId) return; const id=actionUserId; modalConfirm.hide();
    try {
      if(actionPending==='delete-servico'){
        const j= await request(`/api/admin/servicos/delete/${id}`, {method:'POST'});
        toast(j.message,'success');
        carregarServicos();
      } else {
        const j= await request(`/api/admin/users/delete/${id}`,{method:'POST'});
        toast(j.message,'success'); carregarUsuarios();
      }
    }
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
        // Se retornou HTML provavelmente sessão expirada ou foi redirecionado.
        if(text.trim().startsWith('<!DOCTYPE') || text.includes('<html')){
          const snippet = text.slice(0,160).replace(/\n+/g,' ').trim();
          throw new Error('Sessão expirada ou resposta inesperada. Preview: '+snippet);
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

  /* ===================== SERVIÇOS ======================= */
  function showModalServico(){ if(!modalServicoEl) return; modalServicoInstance = modalServicoInstance || new bootstrap.Modal(modalServicoEl); modalServicoInstance.show(); }
  function openModalCreateServico(){ editingServicoId=null; formServico?.reset(); document.getElementById('tituloModalServico')?.textContent='Novo Serviço'; showModalServico(); }
  function openModalEditServico(tr){
    editingServicoId = tr.dataset.servicoId;
    formServico?.reset();
    document.getElementById('tituloModalServico').textContent='Editar Serviço';
    document.getElementById('servicoId').value = editingServicoId;
    document.getElementById('servicoIcone').value = tr.querySelector('.serv-icone').dataset.iconRaw || '';
    document.getElementById('servicoTitulo').value = tr.querySelector('.serv-titulo').textContent;
    document.getElementById('servicoDescricao').value = tr.querySelector('.serv-descricao').dataset.descFull || tr.querySelector('.serv-descricao').textContent;
    // Características
    const caracts = Array.from(tr.querySelectorAll('.serv-caracts li')).map(li=>li.textContent.trim()).join('\n');
    document.getElementById('servicoCaracteristicas').value = caracts;
    showModalServico();
  }

  async function carregarServicos(){
    if(!tabelaServicos) return;
    try {
      const {data=[]} = await request('/api/admin/servicos',{method:'GET'});
      renderServicos(data);
    } catch(e){ toast(e.message,'danger'); }
  }

  function renderServicos(servicos){
    const tbody = tabelaServicos.querySelector('tbody');
    tbody.innerHTML='';
    if(!servicos.length){ tbody.innerHTML='<tr><td colspan="6" class="text-center text-muted py-3">Nenhum serviço.</td></tr>'; return; }
    servicos.forEach(s=>{
      const tr=document.createElement('tr');
      tr.dataset.servicoId = s.id;
      const caractsList = (s.caracteristicas||[]);
      const caractsHtml = caractsList.length
        ? '<ul class="caracts-list serv-caracts">'+ caractsList.map(c=>'<li>'+escapeHtml(c)+'</li>').join('') + '</ul>'
        : '<span class="text-muted small">-</span>';
      const iconRaw = escapeHtml(s.icone||'');
      const iconHtml = iconRaw ? '<i class="'+iconRaw+'"></i>' : '<i class="bi bi-gear"></i>';
      const titulo = escapeHtml(s.titulo||'');
      const descFull = escapeHtml(s.descricao||'');
      const descInner = '<span class="d-inline-block text-truncate" style="max-width:240px" title="'+descFull+'">'+descFull+'</span>';
      tr.innerHTML = ''+
        '<td>'+s.id+'</td>'+
        '<td class="serv-icone" data-icon-raw="'+iconRaw+'">'+iconHtml+'</td>'+
        '<td class="serv-titulo">'+titulo+'</td>'+
        '<td class="serv-descricao" data-desc-full="'+descFull+'">'+descInner+'</td>'+
        '<td>'+caractsHtml+'</td>'+
        '<td class="text-center">'+
           '<div class="btn-group btn-group-sm" role="group">'+
             '<button class="btn btn-outline-secondary btn-edit-serv" title="Editar"><i class="bi bi-pencil-square"></i></button>'+
             '<button class="btn btn-outline-danger btn-delete-serv" title="Excluir"><i class="bi bi-trash"></i></button>'+
           '</div>'+
        '</td>';
      tbody.appendChild(tr);
    });
  }

  formServico?.addEventListener('submit', async e=>{
    e.preventDefault();
    if(!formServico.checkValidity()){ formServico.classList.add('was-validated'); return; }
    const data = Object.fromEntries(new FormData(formServico).entries());
    try {
      const url = editingServicoId ? `/api/admin/servicos/update/${editingServicoId}` : '/api/admin/servicos';
      const j = await request(url,{method:'POST', data});
      toast(j.message || (editingServicoId?'Atualizado':'Criado'),'success');
      modalServicoInstance?.hide();
      carregarServicos();
    } catch(err){ toast(err.message,'danger'); }
  });

  tabelaServicos?.addEventListener('click', e=>{
    const btn = e.target.closest('button'); if(!btn) return; const tr = btn.closest('tr'); const id = tr?.dataset.servicoId;
    if(btn.classList.contains('btn-edit-serv')) return openModalEditServico(tr);
    if(btn.classList.contains('btn-delete-serv')){ openConfirm('delete-servico', id, { entityLabel:'serviço', entityTitle: tr.querySelector('.serv-titulo')?.textContent || ''}); }
  });

  document.getElementById('btnNovoServico')?.addEventListener('click', openModalCreateServico);
  document.getElementById('btnNovoServico2')?.addEventListener('click', openModalCreateServico);

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
  carregarServicos();
    if(window.Chart) renderGraph(); else window.addEventListener('load', renderGraph);
  });
})();
