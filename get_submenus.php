<?php
include 'include/conexao.php'; // Verifique se o caminho está correto

if (isset($_GET['menu_id'])) {
    $menuId = (int)$_GET['menu_id'];
    $query = "SELECT submenu_cod, submenu_nome FROM submenus WHERE menu_cod = ?";
    $params = array($menuId);
    $stmt = sqlsrv_query($conn, $query, $params);

    $submenus = [];
    if ($stmt) {
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $submenus[] = [
                'submenu_id' => $row['submenu_cod'],
                'submenu_nome' => $row['submenu_nome']
            ];
        }
    }

    // Define o cabeçalho como JSON
    header('Content-Type: application/json');
    echo json_encode($submenus);
}
?>