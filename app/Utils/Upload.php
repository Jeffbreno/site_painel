<?php

namespace App\Utils;

class Upload
{
    private $uploadDir;
    private $allowedExtensions;

    public function __construct($uploadDir, $allowedExtensions)
    {
        $this->uploadDir = $uploadDir;
        $this->allowedExtensions = $allowedExtensions;
    }

    public function uploadFile($file, $userId)
    {
        // Verifica se o usuário tem permissão para fazer o upload
        if (!$this->isUserAuthorized($userId)) {
            return "Usuário não autorizado.";
        }

        $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);

        // Verifica se a extensão do arquivo é permitida
        if (!in_array(strtolower($fileExtension), $this->allowedExtensions)) {
            return "Tipo de arquivo não permitido.";
        }

        // Gera um nome único para o arquivo
        $fileName = uniqid() . "." . $fileExtension;

        // Move o arquivo temporário para o diretório de uploads
        if (!move_uploaded_file($file['tmp_name'], $this->uploadDir . "/" . $fileName)) {
            return "Erro ao fazer upload do arquivo.";
        }

        // Retornar o caminho do arquivo no servidor
        return $this->uploadDir . "/" . $fileName;
    }

    private function isUserAuthorized($userId)
    {
        // Verificar no banco de dados se o usuário está cadastrado e tem permissão de acesso
        // Você precisa implementar a lógica de autenticação e verificação de permissões aqui
        // Retorne true se o usuário estiver autorizado e false caso contrário.
        // Exemplo fictício para demonstração:
        // $query = "SELECT COUNT(*) FROM usuarios WHERE id = :userId AND permissao_upload = 1";
        // $stmt = $this->dbConnection->prepare($query);
        // $stmt->bindValue(':userId', $userId);
        // $stmt->execute();
        // $count = $stmt->fetchColumn();
        // return ($count > 0);

        // Note que esse é apenas um exemplo fictício. A implementação real depende do seu sistema de autenticação e banco de dados.
    }
}
