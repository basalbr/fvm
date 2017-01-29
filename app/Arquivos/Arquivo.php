<?php

namespace App\Arquivos;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\File\UploadedFile;

abstract class Arquivo {

    protected $extensao;
    protected $path;
    protected $regras;
    protected $nome_arquivo;
    protected $nomes_bonitos;
    protected $arquivo;
    protected $erros;

    public function __construct($arquivo, $path = '', $regras = '', $nomes_bonitos = '') {
        try {
            $this->setArquivo($arquivo);

            if ($nomes_bonitos) {
                $this->setNomesBonitos($nomes_bonitos);
            }
            if ($regras) {
                $this->setRegras($regras);
            }
            if ($path) {
                $this->setPath($path);
            }
            $this->upload();
        } catch (Exception $ex) {
            Log::error('Erro de Arquivo: ' . $ex);
            return false;
        }
    }

    public function upload() {
        if (count($this->getRegras())) {
            $this->validate();
        }
        if(count($this->getErros())){
            return $this->getErros();
        }
        $this->getArquivo()->move($this->getPath(), $this->getNomeArquivo());
        return $this->getNomeArquivo();
    }

    protected function validate() {
        try {
            $v = Validator::make(['arquivo' => $this->getArquivo()], $this->getRegras());
            if (count($this->getNomesBonitos())) {
                $v->setAttributeNames($this->getNomesBonitos());
            }
            if ($v->fails()) {
                $this->setErros($v->errors()->all());
                return $this->getErros();
            }
        } catch (Exception $ex) {
            Log::error($ex);
        }
    }

    protected function getExtensao() {
        return $this->extensao;
    }

    protected function setExtensao($ext) {
        $this->extensao = $ext;
    }

    protected function setRegras($arr) {
        $this->regras = $arr;
    }

    protected function getRegras() {
        return $this->regras;
    }

    protected function setErros($arr) {
        $this->erros = $arr;
    }

    public function getErros() {
        return $this->erros;
    }

    protected function setArquivo($arquivo) {
        $this->arquivo = $arquivo;
        if (count($this->validate())) {
            return $this->getErros();
            
        } else {
            $this->setExtensao($arquivo->guessClientExtension());
            $this->setNomeArquivo();
        }
    }

    protected function getArquivo() {
        return $this->arquivo;
    }

    protected function setPath($path) {
        $this->path = getcwd() . $path;
    }

    protected function getPath() {
        return $this->path;
    }

    public function getNomesBonitos() {
        return $this->nomes_bonitos;
    }

    protected function setNomesBonitos($arr) {
        $this->nomes_bonitos = $arr;
    }

    protected function setNomeArquivo() {
        $this->nome_arquivo = date('dmyhis') . '.' . $this->getExtensao();
    }

    public function getNomeArquivo() {
        return $this->nome_arquivo;
    }

}
