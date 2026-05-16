document.addEventListener('DOMContentLoaded', () => {
  const stepSelecionar  = document.getElementById('stepSelecionar');
  const stepPreencher   = document.getElementById('stepPreencher');
  const spinnerGerar    = document.getElementById('spinnerGerar');
  const containerSelect = document.getElementById('containerSelecionarTemplate');
  const camposVariaveis = document.getElementById('camposVariaveis');
  const previewConteudo = document.getElementById('previewConteudo');
  const btnPrevisualizar = document.getElementById('btnPrevisualizar');
  const btnGerarSalvar  = document.getElementById('btnGerarSalvar');
  const btnVoltar       = document.getElementById('btnVoltarSelecao');
  const nomeDocInput    = document.getElementById('nomeDocumento');

  let templateAtivo = null;

  function extrairVariaveis(conteudo) {
    const matches = [...conteudo.matchAll(/\{\{(\w+)\}\}/g)];
    return [...new Set(matches.map(m => m[1]))];
  }

  function labelVariavel(varName) {
    return varName.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase());
  }

  function preencherTemplate(conteudo) {
    const formData = new FormData(document.getElementById('formVariaveis'));
    let resultado = conteudo;
    extrairVariaveis(conteudo).forEach(v => {
      const valor = formData.get(v) || `{{${v}}}`;
      resultado = resultado.replaceAll(`{{${v}}}`, `<strong>${valor}</strong>`);
    });
    return resultado;
  }

  function carregarTemplates() {
    fetch(`${BASE_URL}/documentos/listar_templates.php`)
      .then(r => r.json())
      .then(lista => {
        containerSelect.innerHTML = '';

        if (lista.length === 0) {
          containerSelect.innerHTML = '<p class="text-secondary">Nenhum template disponível. Um administrador precisa criar templates primeiro.</p>';
          return;
        }

        lista.forEach(t => {
          const col = document.createElement('div');
          col.className = 'col';
          col.innerHTML = `
            <div class="card h-100 shadow-sm border-primary-subtle" style="cursor:pointer;">
              <div class="card-body">
                <h5 class="card-title text-primary fw-bold">${t.nome}</h5>
                <span class="badge bg-secondary">${t.categoria}</span>
                <p class="card-text small text-muted mt-2 mb-0">Clique para usar este template</p>
              </div>
            </div>`;
          col.querySelector('.card').addEventListener('click', () => selecionarTemplate(t));
          containerSelect.appendChild(col);
        });
      });
  }

  function selecionarTemplate(t) {
    templateAtivo = t;
    const variaveis = extrairVariaveis(t.conteudo);

    camposVariaveis.innerHTML = '';

    if (variaveis.length === 0) {
      camposVariaveis.innerHTML = '<p class="text-muted small">Este template não possui variáveis.</p>';
    } else {
      variaveis.forEach(v => {
        const div = document.createElement('div');
        div.className = 'mb-3';
        div.innerHTML = `
          <label class="form-label">${labelVariavel(v)}</label>
          <input type="text" class="form-control form-control-sm" name="${v}" placeholder="${labelVariavel(v)}">`;
        camposVariaveis.appendChild(div);
      });
    }

    nomeDocInput.value = t.nome + ' — ' + new Date().toLocaleDateString('pt-BR');
    previewConteudo.innerHTML = '<span class="text-secondary fst-italic">Preencha os campos e clique em "Pré-visualizar".</span>';
    btnGerarSalvar.disabled = true;

    stepSelecionar.classList.add('d-none');
    stepPreencher.classList.remove('d-none');
  }

  btnVoltar.addEventListener('click', () => {
    stepPreencher.classList.add('d-none');
    stepSelecionar.classList.remove('d-none');
    templateAtivo = null;
  });

  btnPrevisualizar.addEventListener('click', () => {
    if (!templateAtivo) return;
    previewConteudo.innerHTML = preencherTemplate(templateAtivo.conteudo);
    btnGerarSalvar.disabled = false;
  });

  btnGerarSalvar.addEventListener('click', async () => {
    const nome      = nomeDocInput.value.trim();
    const categoria = templateAtivo.categoria;

    if (!nome) {
      alert('Informe o nome do documento.');
      nomeDocInput.focus();
      return;
    }

    // atualiza preview final antes de gerar
    previewConteudo.innerHTML = preencherTemplate(templateAtivo.conteudo);

    stepPreencher.classList.add('d-none');
    spinnerGerar.classList.remove('d-none');

    try {
      const blob = await html2pdf()
        .set({
          margin: [15, 15, 15, 15],
          filename: nome + '.pdf',
          html2canvas: { scale: 2 },
          jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' },
        })
        .from(previewConteudo)
        .output('blob');

      // trigger download imediato
      const blobUrl = URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = blobUrl;
      a.download = nome + '.pdf';
      a.click();
      URL.revokeObjectURL(blobUrl);

      // enviar para o servidor
      const base64 = await blobToBase64(blob);
      const resp = await fetch(`${BASE_URL}/documentos/salvar_documento_gerado.php`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ pdf_base64: base64, nome, categoria }),
      });
      const ret = await resp.json();

      spinnerGerar.classList.add('d-none');

      if (ret.success) {
        alert('Documento gerado e salvo com sucesso!');
        window.location.href = `${BASE_URL}/documentos/documentos.php`;
      } else {
        alert('PDF baixado, mas houve um erro ao salvar: ' + (ret.erro || 'desconhecido'));
        stepPreencher.classList.remove('d-none');
      }
    } catch (err) {
      spinnerGerar.classList.add('d-none');
      stepPreencher.classList.remove('d-none');
      alert('Erro ao gerar o PDF: ' + err.message);
    }
  });

  function blobToBase64(blob) {
    return new Promise((resolve, reject) => {
      const reader = new FileReader();
      reader.onload  = () => resolve(reader.result.split(',')[1]);
      reader.onerror = reject;
      reader.readAsDataURL(blob);
    });
  }

  carregarTemplates();
});
