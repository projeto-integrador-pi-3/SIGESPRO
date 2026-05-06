<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método não permitido. Use GET.'], JSON_UNESCAPED_UNICODE);
    exit;
}

require_once __DIR__ . '/../conexao.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : null;

try {
    if ($id !== null) {
        $stmt = $conn->prepare("SELECT * FROM subprefeituras WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $item = $result->fetch_assoc();

        if (!$item) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Subprefeitura não encontrada.'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        echo json_encode(['success' => true, 'data' => $item], JSON_UNESCAPED_UNICODE);
    } else {
        $result = $conn->query("SELECT * FROM subprefeituras ORDER BY nome ASC");

        $dados = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $dados[] = $row;
            }
        }

        echo json_encode([
            'success' => true,
            'total'   => count($dados),
            'data'    => $dados,
        ], JSON_UNESCAPED_UNICODE);
    }
} catch (Exception $e) {
    http_response_code(503);
    echo json_encode(['success' => false, 'message' => 'Serviço temporariamente indisponível.'], JSON_UNESCAPED_UNICODE);
}
