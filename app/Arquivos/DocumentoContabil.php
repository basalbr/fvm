<?php

namespace App\Arquivos;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class DocumentoContabil extends Arquivo {

    protected $path = '/uploads/documentos_contabeis/';
    protected $regras = ['arquivo' => 'required|max:2048'];
    protected $nomes_bonitos = ['arquivo'=>'Documento'];
    
    public function __construct($arquivo) {
        parent::__construct($arquivo, $this->path, $this->regras, $this->nomes_bonitos);
    }
}
