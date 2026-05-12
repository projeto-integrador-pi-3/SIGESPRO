document.addEventListener('DOMContentLoaded', () => {
  const btnNovo       = document.getElementById('btnNovoContato');
  const formContato   = document.getElementById('formContato');
  const container     = document.getElementById('containerContatos');
  const modalEl       = document.getElementById('modalContato');
  const modal         = modalEl ? new bootstrap.Modal(modalEl) : null;
  const selectTipo    = document.getElementById('contatoTipo');
  const camposForn    = document.getElementById('camposFornecedor');
  const titulo        = document.getElementById('modalContatoTitulo');
  const campoBusca    = document.getElementById('buscaContatos');

  let editandoId  = null;
  let todosContatos = [];
  let filtroAtivo = '';
  let dt;

  const tipoBadge = {
    subprefeitura: 'bg-primary',
    secretaria:    'bg-success',
    fornecedor:    'bg-warning text-dark',
  };

  const tipoLabel = {
    subprefeitura: 'Subprefeitura',
    secretaria:    'Secretaria',
    fornecedor:    'Fornecedor',
  };

  function atualizarCamposTipo() {
    if (selectTipo.value === 'fornecedor') {
      camposForn.classList.remove('d-none');
    } else {
      camposForn.classList.add('d-none');
    }
  }

  selectTipo.addEventListener('change', atualizarCamposTipo);

  // Filtro por tipo
  document.querySelectorAll('[data-filtro]').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('[data-filtro]').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      filtroAtivo = btn.dataset.filtro;
      aplicarFiltro();
    });
  });

  // Busca própria
  campoBusca.addEventListener('input', () => {
    dt.search(campoBusca.value).draw();
  });

  function aplicarFiltro() {
    const busca = (campoBusca.value || '').toLowerCase();
    let lista = busca
      ? dt.rows({ search: 'applied' }).data().toArray()
      : todosContatos;
    if (filtroAtivo) lista = lista.filter(c => c.tipo === filtroAtivo);
    renderizarCards(lista);
  }

  btnNovo.addEventListener('click', () => {
    formContato.reset();
    camposForn.classList.add('d-none');
    editandoId = null;
    titulo.textContent = 'Novo Contato';
    modal.show();
  });

  formContato.addEventListener('submit', e => {
    e.preventDefault();
    const dados = new FormData(formContato);
    const url = editandoId
      ? `${BASE_URL}/contatos/editar_contato.php`
      : `${BASE_URL}/contatos/salvar_contato.php`;
    if (editandoId) dados.append('id', editandoId);

    fetch(url, { method: 'POST', body: dados })
      .then(r => r.json())
      .then(ret => {
        if (ret.success) { modal.hide(); carregarContatos(); }
        else alert(ret.erro || 'Erro ao salvar');
      });
  });

  function renderizarCards(lista) {
    container.innerHTML = '';

    if (lista.length === 0) {
      container.innerHTML = '<p class="text-secondary">Nenhum contato encontrado.</p>';
      return;
    }

    lista.forEach(c => {
      const col = document.createElement('div');
      col.className = 'col';

      let extraHtml = '';
      if (c.tipo === 'fornecedor') {
        const inicio = c.vigencia_inicio ? new Date(c.vigencia_inicio + 'T00:00:00').toLocaleDateString('pt-BR') : '—';
        const fim    = c.vigencia_fim    ? new Date(c.vigencia_fim    + 'T00:00:00').toLocaleDateString('pt-BR') : '—';
        const hoje   = new Date();
        const venc   = c.vigencia_fim ? new Date(c.vigencia_fim + 'T00:00:00') : null;
        const vencClass = venc && venc < hoje ? 'text-danger fw-bold' : '';

        extraHtml = `
          <hr class="my-2">
          ${c.numero_sei      ? `<p class="card-text mb-1"><i class="bi bi-file-earmark-text"></i> SEI: ${c.numero_sei}</p>` : ''}
          ${c.numero_contrato ? `<p class="card-text mb-1"><i class="bi bi-file-earmark-ruled"></i> Contrato: ${c.numero_contrato}</p>` : ''}
          <p class="card-text mb-1 ${vencClass}"><i class="bi bi-calendar-range"></i> Vigência: ${inicio} → ${fim}</p>
        `;
      }

      col.innerHTML = `
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-2">
              <h5 class="card-title text-primary fw-bold mb-0">${c.nome}</h5>
              <span class="badge ${tipoBadge[c.tipo] || 'bg-secondary'}">${tipoLabel[c.tipo] || c.tipo}</span>
            </div>
            ${c.endereco    ? `<p class="card-text mb-1"><i class="bi bi-geo-alt"></i> ${c.endereco}</p>` : ''}
            ${c.telefone    ? `<p class="card-text mb-1"><i class="bi bi-telephone"></i> ${c.telefone}</p>` : ''}
            ${c.email       ? `<p class="card-text mb-1"><i class="bi bi-envelope"></i> ${c.email}</p>` : ''}
            ${c.responsavel ? `<p class="card-text mb-1"><i class="bi bi-person"></i> ${c.responsavel}</p>` : ''}
            ${extraHtml}
            <div class="d-flex justify-content-end mt-3">
              <button class="btn btn-sm btn-primary me-2 btnEditar" aria-label="Editar ${c.nome}">Editar</button>
              <button class="btn btn-sm btn-danger btnExcluir" aria-label="Excluir ${c.nome}">Excluir</button>
            </div>
          </div>
        </div>
      `;

      col.querySelector('.btnEditar').addEventListener('click', () => editarContato(c));
      col.querySelector('.btnExcluir').addEventListener('click', () => excluirContato(c.id));
      container.appendChild(col);
    });
  }

  function editarContato(c) {
    editandoId = c.id;
    titulo.textContent = 'Editar Contato';
    formContato.tipo.value        = c.tipo;
    formContato.nome.value        = c.nome;
    formContato.endereco.value    = c.endereco    || '';
    formContato.telefone.value    = c.telefone    || '';
    formContato.email.value       = c.email       || '';
    formContato.responsavel.value = c.responsavel || '';

    atualizarCamposTipo();
    if (c.tipo === 'fornecedor') {
      formContato.numero_sei.value      = c.numero_sei      || '';
      formContato.numero_contrato.value = c.numero_contrato || '';
      formContato.vigencia_inicio.value = c.vigencia_inicio || '';
      formContato.vigencia_fim.value    = c.vigencia_fim    || '';
    }
    modal.show();
  }

  function excluirContato(id) {
    if (!confirm('Deseja realmente excluir este contato?')) return;
    fetch(`${BASE_URL}/contatos/excluir_contato.php`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `id=${id}`
    })
      .then(r => r.json())
      .then(ret => {
        if (ret.success) carregarContatos();
        else alert(ret.erro || 'Erro ao excluir');
      });
  }

  function carregarContatos() {
    fetch(`${BASE_URL}/contatos/listar_contatos.php`)
      .then(r => r.json())
      .then(data => {
        todosContatos = data;
        inicializarDataTable(data);
      });
  }

  function inicializarDataTable(data) {
    if (dt) dt.clear().destroy();

    dt = $('#tabelaDataContatos').DataTable({
      data,
      columns: [
        { data: 'nome' },
        { data: 'tipo' },
        { data: 'telefone' },
        { data: 'email' },
        { data: 'responsavel' },
      ],
      searching: true,
      paging: false,
      info: false,
      dom: 't', // só a tabela, sem controles visíveis
    });

    // Esconde o wrapper do DataTable (tabela é só para busca em memória)
    $('#tabelaDataContatos').closest('.dataTables_wrapper').hide();

    aplicarFiltro();

    dt.on('search.dt', () => aplicarFiltro());
  }

  carregarContatos();
});
