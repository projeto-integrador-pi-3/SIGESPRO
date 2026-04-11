// ============================
// SCRIPT PARA SECRETARIAS
// ============================

document.addEventListener('DOMContentLoaded', () => {
  const btnNova = document.getElementById('btnNovaSecretaria');
  const modalEl = document.getElementById('modalNovaSecretaria');
  const form = document.getElementById('formNovaSecretaria');
  const container = document.getElementById('containerSecretarias');
  const campoBusca = document.querySelector('#campoBuscaSecretaria');
  const modal = new bootstrap.Modal(modalEl);

  let secretariaEditando = null;
  let secretariasCarregadas = [];

  btnNova?.addEventListener('click', () => {
    form.reset();
    secretariaEditando = null;
    modal.show();
  });

  carregarSecretarias();

  function carregarSecretarias() {
    fetch(`${BASE_URL}/secretarias/listar_secretarias.php`)
      .then(res => res.json())
      .then(data => {
        secretariasCarregadas = data;
        renderizar(data);
      });
  }

  function renderizar(lista) {
    container.innerHTML = '';
    lista.forEach(sec => {
      const col = document.createElement('div');
      col.className = 'col';
      col.innerHTML = `
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h5 class="card-title text-primary fw-bold">${sec.nome}</h5>
            <p><i class="bi bi-geo-alt"></i> ${sec.endereco}</p>
            <p><i class="bi bi-telephone"></i> ${sec.telefone}</p>
            <p><i class="bi bi-envelope"></i> ${sec.email}</p>
            <p><i class="bi bi-person"></i> ${sec.responsavel}</p>
          </div>
          <div class="card-footer text-end bg-white border-0">
            <button class="btn btn-sm btn-warning me-1 btn-editar">Editar</button>
            <button class="btn btn-sm btn-danger btn-excluir">Excluir</button>
          </div>
        </div>
      `;

      col.querySelector('.btn-editar').addEventListener('click', () => editar(sec));
      col.querySelector('.btn-excluir').addEventListener('click', () => excluir(sec.id, col));

      container.appendChild(col);
    });
  }

  function editar(sec) {
    secretariaEditando = sec.id;
    form.nome.value = sec.nome;
    form.endereco.value = sec.endereco;
    form.telefone.value = sec.telefone;
    form.email.value = sec.email;
    form.responsavel.value = sec.responsavel;
    modal.show();
  }

  form.addEventListener('submit', e => {
    e.preventDefault();
    const dados = new FormData(form);
    let url = `${BASE_URL}/secretarias/salvar_secretaria.php`;

    if (secretariaEditando) {
      dados.append('id', secretariaEditando);
      url = `${BASE_URL}/secretarias/editar_secretaria.php`;
    }

    fetch(url, { method: 'POST', body: dados })
      .then(res => res.json())
      .then(ret => {
        if (ret.success) {
          modal.hide();
          carregarSecretarias();
          secretariaEditando = null;
        } else alert('Erro: ' + ret.erro);
      });
  });

  function excluir(id, col) {
    if (confirm('Deseja realmente excluir esta secretaria?')) {
      fetch(`${BASE_URL}/secretarias/excluir_secretaria.php`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${id}`
      })
        .then(res => res.json())
        .then(ret => {
          if (ret.success) col.remove();
          else alert('Erro ao excluir: ' + ret.erro);
        });
    }
  }

  // 🔎 Filtro de busca em tempo real
  campoBusca?.addEventListener('input', e => {
    const termo = e.target.value.toLowerCase();
    const filtradas = secretariasCarregadas.filter(sec =>
      sec.nome.toLowerCase().includes(termo) ||
      sec.endereco.toLowerCase().includes(termo) ||
      sec.telefone.toLowerCase().includes(termo) ||
      sec.email.toLowerCase().includes(termo) ||
      sec.responsavel.toLowerCase().includes(termo)
    );
    renderizar(filtradas);
  });
});