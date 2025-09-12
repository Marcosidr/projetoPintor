<?php
// filepath: c:\xampp\htdocs\projetoPintor\app\Repositories\LogRepository.php

class LogRepository
{
    /**
     * Busca logs com filtros opcionais.
     * @param array $filtros
     * @return array
     */
    public static function buscarComFiltros(array $filtros): array
    {
        global $pdo;

        $sql = "SELECT * FROM logs WHERE 1=1";
        $params = [];

        if (!empty($filtros['usuario'])) {
            $sql .= " AND usuario LIKE :usuario";
            $params['usuario'] = '%' . $filtros['usuario'] . '%';
        }
        if (!empty($filtros['acao'])) {
            $sql .= " AND acao LIKE :acao";
            $params['acao'] = '%' . $filtros['acao'] . '%';
        }
        if (!empty($filtros['nivel'])) {
            $sql .= " AND nivel = :nivel";
            $params['nivel'] = $filtros['nivel'];
        }
        if (!empty($filtros['data_ini'])) {
            $sql .= " AND DATE(datahora) >= :data_ini";
            $params['data_ini'] = $filtros['data_ini'];
        }
        if (!empty($filtros['data_fim'])) {
            $sql .= " AND DATE(datahora) <= :data_fim";
            $params['data_fim'] = $filtros['data_fim'];
        }

        $sql .= " ORDER BY datahora DESC LIMIT 100";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Insere um novo log no banco.
     * @param string $usuario
     * @param string $acao
     * @param string $nivel
     * @param string $detalhes
     * @return bool
     */
    public static function inserir($usuario, $acao, $nivel, $detalhes): bool
    {
        global $pdo;
        $sql = "INSERT INTO logs (usuario, acao, nivel, detalhes, datahora) VALUES (:usuario, :acao, :nivel, :detalhes, NOW())";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            'usuario' => $usuario,
            'acao' => $acao,
            'nivel' => $nivel,
            'detalhes' => $detalhes
        ]);
    }

    /**
     * Busca os níveis de log distintos.
     * @return array
     */
    public static function getNiveis(): array
    {
        global $pdo;
        $sql = "SELECT DISTINCT nivel FROM logs ORDER BY nivel";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Busca os usuários distintos que geraram logs.
     * @return array
     */
    public static function getUsuarios(): array
    {
        global $pdo;
        $sql = "SELECT DISTINCT usuario FROM logs ORDER BY usuario";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}