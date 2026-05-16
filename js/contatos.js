document.addEventListener('DOMContentLoaded', () => {
  const btnNovo       = document.getElementById('btnNovoContato');
  const formContato   = document.getElementById('formContato');
  const container     = document.getElementById('containerContatos');
  const modalEl       = document.getElementById('modalContato');
  const modal         = modalEl ? new bootstrap.Modal(modalEl) : null;
  const selectTipo    = document.getElementById('contatoTipo');
  const camposForn    = document.getElementById('camposFornecedor');
  const camposSubpref = document.getElementById('camposSubprefeitura');
  const labelNome     = document.getElementById('labelNome');
  const titulo        = document.getElementById('modalContatoTitulo');
  const campoBusca    = document.getElementById('buscaContatos');
  const labelResponsavel       = document.getElementById('labelResponsavel');
  const campoRespFinanceiro    = document.getElementById('campoResponsavelFinanceiro');

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

  const nomeLabel = {
    subprefeitura: 'Nome da Subprefeitura',
    secretaria:    'Nome da Secretaria',
    fornecedor:    'Nome do Fornecedor',
  };

  function atualizarCamposTipo() {
    const tipo = selectTipo.value;
    labelNome.textContent = nomeLabel[tipo] || 'Nome';
    labelResponsavel.textContent = tipo === 'fornecedor' ? 'Responsável Comercial' : 'Responsável';

    if (tipo === 'subprefeitura') {
      camposSubpref.classList.remove('d-none');
    } else {
      camposSubpref.classList.add('d-none');
    }

    if (tipo === 'fornecedor') {
      camposForn.classList.remove('d-none');
      campoRespFinanceiro.classList.remove('d-none');
    } else {
      camposForn.classList.add('d-none');
      campoRespFinanceiro.classList.add('d-none');
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
    camposSubpref.classList.add('d-none');
    campoRespFinanceiro.classList.add('d-none');
    labelNome.textContent = 'Nome';
    labelResponsavel.textContent = 'Responsável';
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
      if (c.tipo === 'subprefeitura' && c.area) {
        extraHtml = `<p class="card-text mb-1"><i class="bi bi-diagram-3"></i> Área: ${c.area}</p>`;
      }
      if (c.tipo === 'fornecedor') {
        const inicio = c.vigencia_inicio ? new Date(c.vigencia_inicio + 'T00:00:00').toLocaleDateString('pt-BR') : '—';
        const fim    = c.vigencia_fim    ? new Date(c.vigencia_fim    + 'T00:00:00').toLocaleDateString('pt-BR') : '—';
        const hoje   = new Date();
        const venc   = c.vigencia_fim ? new Date(c.vigencia_fim + 'T00:00:00') : null;
        const vencClass = venc && venc < hoje ? 'text-danger fw-bold' : '';

        extraHtml = `
          <hr class="my-2">
          ${c.responsavel_financeiro ? `<p class="card-text mb-1"><i class="bi bi-person"></i> Resp. Financeiro: ${c.responsavel_financeiro}</p>` : ''}
          ${c.numero_sei    ? `<p class="card-text mb-1"><i class="bi bi-file-earmark-text"></i> SEI: ${c.numero_sei}</p>` : ''}
          ${c.valor_contrato ? `<p class="card-text mb-1"><i class="bi bi-cash"></i> Valor: ${c.valor_contrato}</p>` : ''}
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
            ${c.area        ? `<p class="card-text mb-1"><i class="bi bi-diagram-3"></i> Área: ${c.area}</p>` : ''}
            ${c.endereco    ? `<p class="card-text mb-1"><i class="bi bi-geo-alt"></i> ${c.endereco}</p>` : ''}
            ${c.telefone    ? `<p class="card-text mb-1"><i class="bi bi-telephone"></i> ${c.telefone}</p>` : ''}
            ${c.email       ? `<p class="card-text mb-1"><i class="bi bi-envelope"></i> ${c.email}</p>` : ''}
            ${c.responsavel ? `<p class="card-text mb-1"><i class="bi bi-person"></i> ${c.responsavel}</p>` : ''}
            ${extraHtml}
            <div class="d-flex justify-content-end mt-3">
              <button class="btn btn-sm btn-primary me-2 btnEditar" aria-label="Editar ${c.nome}">Editar</button>
              ${IS_ADMIN ? `<button class="btn btn-sm btn-danger btnExcluir" aria-label="Excluir ${c.nome}">Excluir</button>` : ''}
            </div>
          </div>
        </div>
      `;

      col.querySelector('.btnEditar').addEventListener('click', () => editarContato(c));
      const btnExcluir = col.querySelector('.btnExcluir');
      if (btnExcluir) btnExcluir.addEventListener('click', () => excluirContato(c.id));
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
    if (c.tipo === 'subprefeitura') {
      formContato.area.value = c.area || '';
    }
    if (c.tipo === 'fornecedor') {
      formContato.numero_sei.value             = c.numero_sei             || '';
      formContato.responsavel_financeiro.value = c.responsavel_financeiro || '';
      formContato.valor_contrato.value         = c.valor_contrato         || '';
      formContato.vigencia_inicio.value        = c.vigencia_inicio        || '';
      formContato.vigencia_fim.value           = c.vigencia_fim           || '';
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
      dom: 't',
    });

    $('#tabelaDataContatos').closest('.dataTables_wrapper').hide();

    aplicarFiltro();

    dt.on('search.dt', () => aplicarFiltro());
  }

  carregarContatos();
});
