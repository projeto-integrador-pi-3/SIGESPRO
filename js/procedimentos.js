// =============================
// SCRIPT PARA PROCEDIMENTOS
// =============================

document.addEventListener('DOMContentLoaded', () => {
  const btnNovoProcedimento = document.getElementById('btnNovoProcedimento');
  const modalEl = document.getElementById('modalNovoProcedimento');
  const formNovoProcedimento = document.getElementById('formNovoProcedimento');
  const containerCards = document.getElementById('containerProcedimentos');
  const modalDetalhesEl = document.getElementById('modalDetalhesProcedimento');

  const modalDetalhes = new bootstrap.Modal(modalDetalhesEl);
  const modal = new bootstrap.Modal(modalEl);

  let procedimentoEditandoId = null;
  let tabelaDT = null;
  const tabela = document.querySelector('#tabelaProcedimentos tbody');

  // BOTÃO NOVO
  btnNovoProcedimento?.addEventListener('click', () => {
    formNovoProcedimento.reset();
    procedimentoEditandoId = null;
    formNovoProcedimento.querySelector('input[name="id"]')?.remove();
    if (tinymce.get('descricao')) tinymce.get('descricao').setContent('');
    modal.show();
  });

  // CARREGA LISTA
  carregarProcedimentos();

  function carregarProcedimentos() {
    fetch(`${BASE_URL}/procedimentos/listar_procedimentos.php`)
      .then(res => res.json())
      .then(procedimentos => {
        containerCards.innerHTML = '';
        tabela.innerHTML = '';

        procedimentos.forEach(p => {
          adicionarCard(p);

          // Preenche tabela invisível (usada pelo DataTable)
          tabela.innerHTML += `
            <tr data-id="${p.id}">
              <td>${p.titulo}</td>
              <td>${p.resumo}</td>
              <td>${p.tipo}</td>
            </tr>
          `;
        });

        aplicarDataTable();
      });
  }

  // APLICA DATATABLE PARA PESQUISA
  function aplicarDataTable() {
    if (tabelaDT) tabelaDT.destroy(); // evita recriação duplicada

    tabelaDT = new DataTable('#tabelaProcedimentos', {
      paging: false,
      info: false,
      searching: true,
      language: {
        search: "Pesquisar:"
      }
    });

    // Filtra cards conforme busca no DataTable
    tabelaDT.on('search.dt', function () {
      const termo = tabelaDT.search().toLowerCase().trim();

      document.querySelectorAll('.card-procedimento').forEach(card => {
        const texto = card.innerText.toLowerCase();
        card.style.display = texto.includes(termo) ? '' : 'none';
      });
    });
  }

  // CRIA CARD VISUAL
  function adicionarCard(p) {
    const col = document.createElement('div');
    col.className = 'col card-procedimento';
    col.innerHTML = `
      <div class="card h-100 shadow-sm">
        <div class="card-body">
          <h5 class="card-title text-primary fw-bold">${p.titulo}</h5>
          <p class="card-text">${p.resumo}</p>
          <span class="badge ${badgeClass(p.tipo)}">${p.tipo}</span>
        </div>
        <div class="card-footer text-end bg-white border-0">
          <button class="btn btn-sm btn-outline-info btn-detalhes">Ver detalhes</button>
        </div>
      </div>
    `;

    // BOTÃO VER DETALHES
    col.querySelector('.btn-detalhes').addEventListener('click', () => {
      document.getElementById('detalhesTitulo').innerText = p.titulo;
      document.getElementById('detalhesDescricao').innerHTML = p.descricao;

      procedimentoEditandoId = p.id;

      // BOTÃO EDITAR
      document.getElementById('btnEditarDetalhes').onclick = () => {
        let inputId = formNovoProcedimento.querySelector('input[name="id"]');
        if (!inputId) {
          inputId = document.createElement('input');
          inputId.type = 'hidden';
          inputId.name = 'id';
          formNovoProcedimento.appendChild(inputId);
        }
        inputId.value = p.id;

        formNovoProcedimento.titulo.value = p.titulo;
        formNovoProcedimento.resumo.value = p.resumo;
        formNovoProcedimento.tipo.value = p.tipo;

        tinymce.get('descricao').setContent(p.descricao);

        modalDetalhes.hide();
        modal.show();
      };

      // BOTÃO EXCLUIR
      document.getElementById('btnExcluirDetalhes').onclick = () => {
        if (confirm('Deseja realmente excluir este procedimento?')) {
          fetch(`${BASE_URL}/procedimentos/excluir_procedimento.php`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id=${p.id}`
          })
            .then(res => res.json())
            .then(ret => {
              if (ret.success) {
                col.remove();
                modalDetalhes.hide();
              } else {
                alert('Erro ao excluir: ' + ret.erro);
              }
            });
        }
      };

      modalDetalhes.show();
    });

    containerCards.appendChild(col);
  }

  // SALVAR (NOVO OU EDITAR)
  formNovoProcedimento?.addEventListener('submit', e => {
    e.preventDefault();
    const dados = new FormData(formNovoProcedimento);
    let url = `${BASE_URL}/procedimentos/salvar_procedimento.php`;

    if (procedimentoEditandoId) {
      url = `${BASE_URL}/procedimentos/editar_procedimento.php`;
    }

    fetch(url, { method: 'POST', body: dados })
      .then(res => res.json())
      .then(ret => {
        if (ret.success) {
          modal.hide();
          procedimentoEditandoId = null;
          formNovoProcedimento.reset();
          carregarProcedimentos();
        } else {
          alert('Erro ao salvar: ' + ret.erro);
        }
      });
  });

  // COR DA TAG
  function badgeClass(tipo) {
    switch (tipo) {
      case 'Suporte': return 'bg-info text-dark';
      case 'Infraestrutura': return 'bg-warning text-dark';
      case 'Administração': return 'bg-secondary';
      case 'Manutenção': return 'bg-success';
      default: return 'bg-light text-dark';
    }
  }
});
