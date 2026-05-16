document.addEventListener('DOMContentLoaded', () => {
  const container     = document.getElementById('containerTemplates');
  const btnNovo       = document.getElementById('btnNovoTemplate');
  const formTemplate  = document.getElementById('formTemplate');
  const modalEl       = document.getElementById('modalTemplate');
  const modal         = new bootstrap.Modal(modalEl);
  const titulo        = document.getElementById('modalTemplateTitulo');

  let editandoId = null;
  let editorReady = false;

  tinymce.init({
    selector: '#templateConteudo',
    height: 450,
    menubar: false,
    plugins: 'lists link table',
    toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright | bullist numlist | table | removeformat',
    branding: false,
    setup(editor) {
      editor.on('init', () => { editorReady = true; });
    },
  });

  btnNovo.addEventListener('click', () => {
    editandoId = null;
    titulo.textContent = 'Novo Template';
    formTemplate.reset();
    if (editorReady) tinymce.get('templateConteudo').setContent('');
    modal.show();
  });

  formTemplate.addEventListener('submit', e => {
    e.preventDefault();

    const conteudo = editorReady ? tinymce.get('templateConteudo').getContent() : '';
    if (!conteudo.trim()) {
      alert('O conteúdo do template não pode estar vazio.');
      return;
    }

    const dados = new FormData(formTemplate);
    dados.set('conteudo', conteudo);

    const url = editandoId
      ? `${BASE_URL}/documentos/atualizar_template.php`
      : `${BASE_URL}/documentos/salvar_template.php`;

    if (editandoId) dados.append('id', editandoId);

    fetch(url, { method: 'POST', body: dados })
      .then(r => r.json())
      .then(ret => {
        if (ret.success) { modal.hide(); carregarTemplates(); }
        else alert(ret.erro || 'Erro ao salvar template.');
      });
  });

  function carregarTemplates() {
    fetch(`${BASE_URL}/documentos/listar_templates.php`)
      .then(r => r.json())
      .then(renderizarTemplates);
  }

  function renderizarTemplates(lista) {
    container.innerHTML = '';

    if (lista.length === 0) {
      container.innerHTML = '<p class="text-secondary">Nenhum template cadastrado.</p>';
      return;
    }

    lista.forEach(t => {
      const variaveis = extrairVariaveis(t.conteudo);
      const col = document.createElement('div');
      col.className = 'col';
      col.innerHTML = `
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-2">
              <h5 class="card-title text-primary fw-bold mb-0">${t.nome}</h5>
              <span class="badge bg-secondary">${t.categoria}</span>
            </div>
            ${variaveis.length
              ? `<p class="card-text small text-muted mb-0">Campos: ${variaveis.map(v => `<code>{{${v}}}</code>`).join(', ')}</p>`
              : '<p class="card-text small text-muted mb-0">Sem variáveis</p>'}
            <div class="d-flex justify-content-end mt-3 gap-2">
              <button class="btn btn-sm btn-outline-primary btnEditar">Editar</button>
              <button class="btn btn-sm btn-danger btnExcluir">Excluir</button>
            </div>
          </div>
        </div>`;

      col.querySelector('.btnEditar').addEventListener('click', () => editarTemplate(t));
      col.querySelector('.btnExcluir').addEventListener('click', () => excluirTemplate(t.id, t.nome));
      container.appendChild(col);
    });
  }

  function editarTemplate(t) {
    editandoId = t.id;
    titulo.textContent = 'Editar Template';
    document.getElementById('templateNome').value = t.nome;
    document.getElementById('templateCategoria').value = t.categoria;

    modal.show();

    // aguarda o modal abrir para setar conteúdo no TinyMCE
    modalEl.addEventListener('shown.bs.modal', function onShown() {
      if (editorReady) tinymce.get('templateConteudo').setContent(t.conteudo);
      modalEl.removeEventListener('shown.bs.modal', onShown);
    });
  }

  function excluirTemplate(id, nome) {
    if (!confirm(`Excluir o template "${nome}"?`)) return;
    fetch(`${BASE_URL}/documentos/excluir_template.php`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `id=${id}`,
    })
      .then(r => r.json())
      .then(ret => {
        if (ret.success) carregarTemplates();
        else alert(ret.erro || 'Erro ao excluir.');
      });
  }

  function extrairVariaveis(conteudo) {
    const matches = [...conteudo.matchAll(/\{\{(\w+)\}\}/g)];
    return [...new Set(matches.map(m => m[1]))];
  }

  carregarTemplates();
});
