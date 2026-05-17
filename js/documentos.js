// ============================
// SCRIPT PARA DOCUMENTOS (DataTable)
// ============================

let tabelaDocumentos;
let documentos = [];

document.addEventListener('DOMContentLoaded', () => {
  const btnNovo = document.getElementById('btnNovoDocumento');
  const modalEl = document.getElementById('modalNovoDocumento');
  const modal = new bootstrap.Modal(modalEl);
  const form = document.getElementById('formNovoDocumento');
  const campoBusca = document.getElementById('campoBuscaDocumento');

  // Inicializa DataTable
  tabelaDocumentos = new DataTable('#tabelaDocumentos', {
    paging: true,
    searching: true,
    info: false,
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json"
    }
  });

  carregarDocumentos();

  // Botão "Novo Documento"
  btnNovo?.addEventListener('click', () => {
    form.reset();
    modal.show();
  });

  // Submissão do formulário (upload/edição)
  form?.addEventListener('submit', e => {
    e.preventDefault();
    const dados = new FormData(form);

    fetch(`${BASE_URL}/documentos/upload_documento.php`, {
      method: 'POST',
      body: dados
    })
      .then(res => res.json())
      .then(ret => {
        if (ret.success) {
          modal.hide();
          carregarDocumentos();
        } else {
          alert('Erro: ' + ret.erro);
        }
      });
  });

  // Filtro externo opcional
  campoBusca?.addEventListener('input', e => {
    tabelaDocumentos.search(e.target.value).draw();
  });

  // Carrega documentos via AJAX
  function carregarDocumentos() {
    fetch(`${BASE_URL}/documentos/listar_documentos.php`)
      .then(res => res.json())
      .then(data => {
        documentos = data;
        tabelaDocumentos.clear().draw();

        data.forEach(doc => {
          const dataFormatada = new Date(doc.data_upload).toLocaleDateString('pt-BR');

          const linha = document.createElement('tr');
          linha.dataset.documento = JSON.stringify(doc);

          linha.innerHTML = `
            <td>${doc.nome}</td>
            <td>${doc.categoria}</td>
            <td>${doc.responsavel}</td>
            <td>${dataFormatada}</td>
            <td class="text-center">
              <a href="${BASE_URL}/documentos/download_documento.php?id=${doc.id}" class="btn btn-sm btn-outline-success me-1">
                <i class="bi bi-download"></i> Baixar
              </a>

              <a href="${BASE_URL}/documentos/editar_documento.php?id=${doc.id}" class="btn btn-sm btn-outline-warning me-1">
                <i class="bi bi-pencil"></i> Editar
              </a>

              <button class="btn btn-sm btn-outline-danger btn-excluir" data-id="${doc.id}">
                <i class="bi bi-trash"></i> Excluir
              </button>
            </td>
          `;

          tabelaDocumentos.row.add(linha).draw();
        });
      });
  }

  // Delegação de eventos para DataTable
  document.addEventListener('click', e => {

    // Excluir
    if (e.target.closest('.btn-excluir')) {
      const btn = e.target.closest('.btn-excluir');
      const id = btn.dataset.id;
      if (confirm('Deseja realmente excluir este documento?')) {
        fetch(`${BASE_URL}/documentos/excluir_documento.php`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: `id=${id}`
        })
          .then(res => res.json())
          .then(ret => {
            if (ret.success) carregarDocumentos();
            else alert('Erro ao excluir: ' + ret.erro);
          });
      }
    }

  });

});
