<?php
namespace Microblog\Services;

use Exception;
use Microblog\Database\ConexaoBD;
use Microblog\Helpers\Utils;
use Microblog\Models\Categoria;
use PDO;
use PDOException;

final class CategoriaServico {
    private PDO $conexao;
    
    public function __construct()
    {
        $this->conexao = ConexaoBD::getConexao();
    }

    public function listarTodos(): array {
        try {
            $consulta = $this->conexao->query(
                "SELECT id, nome FROM categorias ORDER BY nome");
            return $consulta->fetchAll();
        } catch (PDOException $erro) {
            Utils::registrarLog($erro);
            throw new Exception("Erro ao listar categorias");
        }
    }

    public function inserir(Categoria $categoria): void {
        try {
            $consulta = $this->conexao->prepare(
                "INSERT INTO categorias (nome) VALUES (:nome)");
            $consulta->bindValue(":nome", $categoria->getNome());
            $consulta->execute();
        } catch (PDOException $erro) {
            Utils::registrarLog($erro);
            throw new Exception("Erro ao inserir uma categoria.");
        }
    }

    public function buscarPorId(int $id): ?array {
        try {
            $consulta = $this->conexao->prepare(
                "SELECT * FROM categorias WHERE id = :id");
            $consulta->bindValue(":id", $id);
            $consulta->execute();
            return $consulta->fetch();
        } catch (PDOException $erro) {
            Utils::registrarLog($erro);
            throw new Exception("Erro ao buscar categoria por ID.");
        }
    }

    public function atualizar(Categoria $categoria): void {
        try {
            $consulta = $this->conexao->prepare(
                "UPDATE categorias SET nome = :nome WHERE id = :id");
            $consulta->bindValue(":nome", $categoria->getNome());
            $consulta->bindValue(":id", $categoria->getId());
            $consulta->execute();
        } catch (PDOException $erro) {
            Utils::registrarLog($erro);
            throw new Exception("Erro ao atualizar categoria.");
        }
    }
} 