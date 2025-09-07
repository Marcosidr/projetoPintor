<?php
session_start();
require_once __DIR__ . "/../bin/config.php";

// Apenas admin pode ver
if ($_SESSION["usuario"]["tipo"] !== "admin") {
    die("Acesso negado!");
}

// Filtros
$filtroUsuario = $_GET["usuario"] ?? "";
$filtroAcao    = $_GET["acao"] ?? "";
$filtroNivel   = $_GET["nivel"] ?? "";
$filtroDataIni = $_GET["data_ini"] ?? "";
$filtroDataFim = $_GET["data_fim"] ?? "";

// Monta SQL
$sql = "SELECT * FROM logs WHERE 1=1";
$params = [];

if (!empty($filtroUsuario)) {
    $sql .= " AND usuario LIKE :usuario";
    $params["usuario"] = "%" . $filtroUsuario . "%";
}

if (!empty($filtroAcao)) {
    $sql .= " AND acao LIKE :acao";
    $params["acao"] = "%" . $filtroAcao . "%";
}

if (!empty($filtroNivel)) {
    $sql .= " AND nivel = :nivel";
    $params["nivel"] = $filtroNivel;
}

if (!empty($filtroDataIni)) {
    $sql .= " AND DATE(datahora) >= :data_ini";
    $params["data_ini"] = $filtroDataIni;
}

if (!empty($filtroDataFim)) {
    $sql .= " AND DATE(datahora) <= :data_fim";
    $params["data_fim"] = $filtroDataFim;
}

$sql .= " ORDER BY datahora DESC LIMIT 200";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Logs do Sistema</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-4">
    <h3 class="mb-4">📜 Logs do Sistema</h3>

    <!-- Filtros -->
    <form method="GET" class="row g-3 mb-4">
      <div class="col-md-3">
        <label class="form-label">Usuário</label>
        <input type="text" name="usuario" class="form-control" value="<?= htmlspecialchars($filtroUsuario) ?>">
      </div>
      <div class="col-md-3">
        <label class="form-label">Ação</label>
        <input type="text" name="acao" class="form-control" value="<?= htmlspecialchars($filtroAcao) ?>">
      </div>
      <div class="col-md-2">
        <label class="form-label">Nível</label>
        <select name="nivel" class="form-select">
          <option value="">Todos</option>
          <option value="INFO" <?= $filtroNivel=="INFO"?"selected":"" ?>>INFO</option>
          <option value="WARNING" <?= $filtroNivel=="WARNING"?"selected":"" ?>>WARNING</option>
          <option value="ERROR" <?= $filtroNivel=="ERROR"?"selected":"" ?>>ERROR</option>
        </select>
      </div>
      <div class="col-md-2">
        <label class="form-label">Data início</label>
        <input type="date" name="data_ini" class="form-control" value="<?= htmlspecialchars($filtroDataIni) ?>">
      </div>
      <div class="col-md-2">
        <label class="form-label">Data fim</label>
        <input type="date" name="data_fim" class="form-control" value="<?= htmlspecialchars($filtroDataFim) ?>">
      </div>
      <div class="col-md-2 d-flex align-items-end">
        <button type="submit" class="btn btn
