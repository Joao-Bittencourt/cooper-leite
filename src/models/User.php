<?php

namespace CooperLeite\models;

use \core\Model;

class User extends Model {
    
    public function salvar($userData = []) {
             
        if (empty($userData)) {
            $this->erros[] = 'Dados inexistentes para salvar.';
            return false;
        }
        
        $dataToPersist = $this->processDataToPersist($userData);
        
        $insert = $this->insert($dataToPersist);
        $insert->execute();  
    }
    
    public function processDataToPersist(array $data = []): array {
        
        return $data;
    }
}