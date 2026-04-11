// =============================
// SCRIPT PARA SUBPREFEITURAS (Cards + DataTable)
// =============================

document.addEventListener('DOMContentLoaded', () => {
  const btnNovaSub = document.getElementById('btnNovaSub');
  const formSub = document.getElementById('formSub');
  const container = document.getElementById('containerSubprefeituras');
  const modalSubEl = document.getElementById('modalSub');
  const modalSub = modalSubEl ? new bootstrap.Modal(modalSubEl) : null;
  let editandoId = null;

  let subprefeituras = [];
  let dt; // DataTable

  if (!btnNovaSub || !formSub || !container) return;

  btnNovaSub.addEventListener('click', () => {
    formSub.reset();
    editandoId = null;
    modalSub.show();
  });

  formSub.addEventListener('submit', (e) => {
    e.preventDefault();
    const dados = new FormData(formSub);
    let url = `${BASE_URL}/subprefeituras/salvar_subprefeitura.php`;
    if (editandoId) {
      dados.append('id', editandoId);
      url = `${BASE_URL}/subprefeituras/editar_subprefeitura.php`;
    }

    fetch(url, { method: 'POST', body: dados })
      .then(res => res.json())
      .then(ret => {
        if (ret.success) {
          modalSub.hide();
          carregarSubprefeituras();
        } else {
          alert(ret.erro || 'Erro ao salvar');
        }
      });
  });

  // Google Maps SearchBox
  var input = document.getElementById('endereco');
  if (input) {
    var searchBox = new google.maps.places.SearchBox(input);
  }

  // Função para adicionar cards ao container
  function renderizarCards(lista) {
    container.innerHTML = '';
    lista.forEach(s => {
      const col = document.createElement('div');
      col.className = 'col';
      col.innerHTML = `
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h5 class="card-title text-primary fw-bold">${s.nome}</h5>
            <p class="card-text mb-1"><i class="bi bi-geo-alt"></i> ${s.endereco}</p>
            <p class="card-text mb-1"><i class="bi bi-telephone"></i> ${s.telefone}</p>
            <p class="card-text mb-1"><i class="bi bi-envelope"></i> ${s.email}</p>
            <p class="card-text mb-1"><i class="bi bi-person"></i> ${s.responsavel}</p>
            <p class="card-text"><i class="bi bi-diagram-3"></i> Área: ${s.area}</p>
            <div class="d-flex justify-content-end mt-3">
              <button class="btn btn-sm btn-primary me-2 btnEditar" data-id="${s.id}">Editar</button>
              <button class="btn btn-sm btn-danger btnExcluir" data-id="${s.id}">Excluir</button>
            </div>
          </div>
        </div>
      `;
      col.querySelector('.btnEditar').addEventListener('click', () => editarSub(s));
      col.querySelector('.btnExcluir').addEventListener('click', () => excluirSub(s.id));
      container.appendChild(col);
    });
  }

  // Funções Editar e Excluir
  function editarSub(s) {
    editandoId = s.id;
    formSub.nome.value = s.nome;
    formSub.endereco.value = s.endereco;
    formSub.telefone.value = s.telefone;
    formSub.email.value = s.email;
    formSub.responsavel.value = s.responsavel;
    formSub.area.value = s.area;
    modalSub.show();
  }

  function excluirSub(id) {
    if (confirm('Deseja realmente excluir esta subprefeitura?')) {
      fetch(`${BASE_URL}/subprefeituras/excluir_subprefeitura.php`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${id}`
      })
        .then(res => res.json())
        .then(ret => {
          if (ret.success) carregarSubprefeituras();
          else alert(ret.erro || 'Erro ao excluir');
        });
    }
  }

  // Carrega os dados do servidor
  function carregarSubprefeituras() {
    fetch(`${BASE_URL}/subprefeituras/listar_subprefeituras.php`)
      .then(res => res.json())
      .then(data => {
        subprefeituras = data;
        inicializarDataTable(subprefeituras);
      });
  }

  // Inicializa DataTable em memória
  function inicializarDataTable(data) {
    if (dt) dt.clear().destroy();

    // Criar tabela invisível apenas para DataTable
    let tabela = document.getElementById('tabelaDataSub');
    if (!tabela) {
      tabela = document.createElement('table');
      tabela.id = 'tabelaDataSub';
      tabela.className = 'd-none';
      document.body.appendChild(tabela);
      tabela.innerHTML = `
        <thead>
          <tr>
            <th>Nome</th>
            <th>Endereço</th>
            <th>Telefone</th>
            <th>Email</th>
            <th>Responsável</th>
            <th>Área</th>
          </tr>
        </thead>
      `;
    }

    dt = $('#tabelaDataSub').DataTable({
      data: data,
      columns: [
        { data: 'nome' },
        { data: 'endereco' },
        { data: 'telefone' },
        { data: 'email' },
        { data: 'responsavel' },
        { data: 'area' }
      ],
      paging: true,
      searching: true,
      info: false,
      lengthChange: false
    });

    // Renderiza os cards da página atual
    renderizarCards(dt.rows({ page: 'current' }).data().toArray());

    // Atualiza cards ao mudar de página ou buscar
    dt.on('draw', () => {
      renderizarCards(dt.rows({ page: 'current' }).data().toArray());
    });
  }

  // Carrega os dados iniciais
  carregarSubprefeituras();
});
