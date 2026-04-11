







// ============================
// USUARIOS
// ============================

// document.addEventListener('DOMContentLoaded', () => {
//     const btnNovo = document.getElementById('btnNovoUsuario');
//     const modalEl = document.getElementById('modalNovoUsuario');
//     const form = document.getElementById('formNovoUsuario');
//     const container = document.getElementById('containerUsuarios');

//     // Cria o modal somente quando o DOM estiver pronto
//     const modal = new bootstrap.Modal(modalEl);

//     let usuarioEditando = null;

//     btnNovo?.addEventListener('click', () => {
//         form.reset();
//         usuarioEditando = null;
//         modal.show();
//     });

//     function carregarUsuarios() {
//         fetch(`${BASE_URL}/admin/listar_usuarios.php`)
//             .then(res => res.json())
//             .then(data => renderizar(data));
//     }

//     function renderizar(lista) {
//         container.innerHTML = '';
//         lista.forEach(user => {
//             const col = document.createElement('div');
//             col.className = 'col';
//             col.innerHTML = `
//                 <div class="card h-100 shadow-sm">
//                     <div class="card-body">
//                         <h5 class="card-title text-primary fw-bold">${user.nome}</h5>
//                         <p><i class="bi bi-envelope"></i> ${user.email}</p>
//                         <p><i class="bi bi-person-badge"></i> ${user.perfil}</p>
//                     </div>
//                     <div class="card-footer text-end bg-white border-0">
//                         <button class="btn btn-sm btn-warning me-1 btn-editar">Editar</button>
//                         <button class="btn btn-sm btn-danger btn-excluir">Excluir</button>
//                     </div>
//                 </div>
//             `;

//             col.querySelector('.btn-editar').addEventListener('click', () => editar(user));
//             col.querySelector('.btn-excluir').addEventListener('click', () => excluir(user.id, col));

//             container.appendChild(col);
//         });
//     }

//     function editar(user) {
//         usuarioEditando = user.id;
//         form.nome.value = user.nome;
//         form.email.value = user.email;
//         form.senha.value = '';
//         form.perfil.value = user.perfil;
//         modal.show();
//     }

//     form.addEventListener('submit', e => {
//         e.preventDefault();
//         const dados = new FormData(form);
//         let url = `${BASE_URL}/admin/salvar_usuario.php`;

//         if (usuarioEditando) {
//             dados.append('id', usuarioEditando);
//             url = `${BASE_URL}/admin/editar_usuario.php`;
//         }

//         fetch(url, { method: 'POST', body: dados })
//             .then(res => res.json())
//             .then(ret => {
//                 if (ret.success) {
//                     modal.hide();
//                     carregarUsuarios();
//                     usuarioEditando = null;
//                 } else alert('Erro: ' + ret.erro);
//             });
//     });

//     function excluir(id, col) {
//         if (confirm('Deseja realmente excluir este usuário?')) {
//             fetch(`${BASE_URL}/admin/excluir_usuario.php`, {
//                 method: 'POST',
//                 headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
//                 body: `id=${id}`
//             })
//                 .then(res => res.json())
//                 .then(ret => {
//                     if (ret.success) col.remove();
//                     else alert('Erro ao excluir: ' + ret.erro);
//                 });
//         }
//     }

//     // Carrega os usuários depois que tudo estiver inicializado
//     carregarUsuarios();
// });


// ============================
// USUARIOS TESTE
// ============================

// document.addEventListener('DOMContentLoaded', () => {
//     const btnNovo = document.getElementById('btnNovoUsuario');
//     const modalEl = document.getElementById('modalNovoUsuario');
//     const modal = new bootstrap.Modal(modalEl);

//     btnNovo.addEventListener('click', () => {
//         modal.show();
//     });
// });


