<?php

namespace App\Utils;

use App\Model\Entity\User as EntityUser;

class Upload
{
    private string $uploadDir;
    private array $allowedExtensions;
    private float $maxFileSize;

    public function __construct($uploadDir, $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx'), $maxFileSize = 25)
    {
        $this->uploadDir = $uploadDir;
        $this->allowedExtensions = $allowedExtensions;
        $this->maxFileSize = $maxFileSize;
    }

    public function uploadFiles($uploadedFiles)
    {
        $uploadedFilesInfo = array();

        // VERIFICA SE TEM ARQUIVOS PARA UPLOAD
        if (!empty($uploadedFiles)) {



        }


        // $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);

        // // Verifica se a extensão do arquivo é permitida
        // if (!in_array(strtolower($fileExtension), $this->allowedExtensions)) {
        //     return "Tipo de arquivo não permitido.";
        // }

        // // Gera um nome único para o arquivo
        // $fileName = uniqid() . "." . $fileExtension;

        // // Move o arquivo temporário para o diretório de uploads
        // if (!move_uploaded_file($file['tmp_name'], $this->uploadDir . "/" . $fileName)) {
        //     return "Erro ao fazer upload do arquivo.";
        // }

        // // Retornar o caminho do arquivo no servidor
        // return $this->uploadDir . "/" . $fileName;
    }
}
