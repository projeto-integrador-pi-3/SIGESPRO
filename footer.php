  </div> <!-- Fecha o container aberto no header.php -->

  <!-- Rodapé -->
  <footer class="footer mt-auto py-3 bg-dark text-light">
      <p class="mb-0 text-center">© 2026 Coordenação de Tecnologia da Informação - Secretaria Municipal das Subprefeituras</p>
  </footer>

<!-- Bootstrap Bundle JS (contém modal e popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>


<!-- Scripts específicos de página -->
  <?php
    if (isset($pageScripts)) {
        foreach ($pageScripts as $script) {
            echo "<script src='" . BASE_URL . "/js/$script'></script>\n";
        }
    }
  ?>

  </body>
  </html>