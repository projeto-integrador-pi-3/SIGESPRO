// =============================
// SCRIPT PARA SISTEMAS
// =============================

let tabelaSistema; // referencia do DataTable

document.addEventListener('DOMContentLoaded', () => {

  const btnNovoSistema = document.getElementById('btnNovoSistema');
  const modalNovoSistemaEl = document.getElementById('modalNovoSistema');
  const formNovoSistema = document.getElementById('formNovoSistema');
  const tabela = document.querySelector('#tabelaSistemas tbody');
  const modalNovoSistema = new bootstrap.Modal(modalNovoSistemaEl);

  carregarSistemas(); // carrega ao iniciar

  // Botão "Novo Sistema"
  btnNovoSistema?.addEventListener('click', () => {
    formNovoSistema.reset();
    sistemaEditandoId = null;
    modalNovoSistema.show();
  });

  let sistemaEditandoId = null;

  // EDITAR
  function editarSistema(dados) {
    sistemaEditandoId = dados.id;
    formNovoSistema.nome.value = dados.nome;
    formNovoSistema.area.value = dados.area;
    formNovoSistema.responsavel.value = dados.responsavel;
    formNovoSistema.email.value = dados.email;
    formNovoSistema.telefone.value = dados.telefone;
    formNovoSistema.local.value = dados.local;
    formNovoSistema.status.value = dados.status;
    modalNovoSistema.show();
  }

  // SALVAR (Novo ou Editar)
  formNovoSistema?.addEventListener('submit', (e) => {
    e.preventDefault();

    const dados = new FormData(formNovoSistema);
    let url = `${BASE_URL}/sistemas/salvar_sistema.php`;

    if (sistemaEditandoId) {
      dados.append('id', sistemaEditandoId);
      url = `${BASE_URL}/sistemas/editar_sistema.php`;
    }

    fetch(url, { method: 'POST', body: dados })
      .then(res => res.json())
      .then(retorno => {
        if (retorno.success) {
          modalNovoSistema.hide();
          carregarSistemas(); // atualiza tabela
        } else {
          alert("Erro ao salvar: " + retorno.erro);
        }
      });
  });

  // LISTAR SISTEMAS
  function carregarSistemas() {
    fetch(`${BASE_URL}/sistemas/listar_sistemas.php`)
      .then(res => res.json())
      .then(sistemas => {

        // Se tabela já existe → limpar e recarregar
        if (tabelaSistema) {
          tabelaSistema.clear().draw();
        } else {
          // Inicializa o DataTable na primeira vez
          tabelaSistema = new DataTable('#tabelaSistemas', {
            paging: true,
            searching: true,
            info: false,
            language: {
              url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json"
            }
          });
        }

        // Preenche as linhas
        sistemas.forEach(s => adicionarLinha(s));
      });
  }

  // ADICIONAR LINHA NA TABELA
  function adicionarLinha(dados) {
    const linha = document.createElement('tr');
    linha.dataset.sistema = JSON.stringify(dados);

    linha.innerHTML = `
      <td>${dados.nome}</td>
      <td>${dados.area}</td>
      <td>${dados.responsavel}</td>
      <td>${dados.email}</td>
      <td>${dados.telefone}</td>
      <td>${dados.local}</td>
      <td><span class="badge ${dados.status === 'Ativo' ? 'bg-success' : 'bg-danger'}">${dados.status}</span></td>
      <td class="text-center">
        <button class="btn btn-sm btn-warning btn-editar me-1"><i class="bi bi-pencil"></i></button>
        <button class="btn btn-sm btn-danger btn-excluir"><i class="bi bi-trash"></i></button>
      </td>
    `;

    tabelaSistema.row.add(linha).draw();
  }

  // EXCLUIR
  function excluirSistema(id) {
    if (confirm('Deseja realmente excluir este sistema?')) {
      fetch(`${BASE_URL}/sistemas/excluir_sistema.php`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${id}`
      })
      .then(res => res.json())
      .then(ret => {
        if (ret.success) carregarSistemas();
        else alert('Erro ao excluir: ' + ret.erro);
      });
    }
  }

  // DELEGAÇÃO DE EVENTOS (necessário para DataTable)
  document.addEventListener('click', (e) => {

    // Editar
    if (e.target.closest('.btn-editar')) {
      const linha = e.target.closest('tr');
      const dados = JSON.parse(linha.dataset.sistema);
      editarSistema(dados);
    }

    // Excluir
    if (e.target.closest('.btn-excluir')) {
      const linha = e.target.closest('tr');
      const dados = JSON.parse(linha.dataset.sistema);
      excluirSistema(dados.id);
    }

  });

});
