<?php

use Microblog\Helpers\Utils;
use Microblog\Services\CategoriaServico;

require_once __DIR__ . "../../vendor/autoload.php";
$id = Utils::normalizarEntrada($_GET['id'] ?? null, "inteiro");
Utils::verificarId($id);

try {
    $categoria = new CategoriaServico();
    $categoria->excluir($id);
    header("location:categorias.php");
    exit;
} catch (Throwable $erro) {
    Utils::registrarLog($erro);
    Utils::alertaErro("Não foi possível excluir a categoria. Tente novamente!");
}