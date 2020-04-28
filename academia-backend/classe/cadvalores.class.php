<?php
    class CadValores{
        public $id;
        public $matricula;
        public $mensalidade;
        public $anosem;

        function carregarTodos(){
            $sql = "SELECT * FROM valores";
            $query = pg_query($sql);
            if(pg_num_rows($query)==0){
                return false;
            }
            $res = pg_fetch_all($query);
            return $res; 
        }

        function inativar(){
            $sql = "UPDATE valores SET b_ativo = false WHERE id = '$this->id'";
            $query = pg_query($sql);
            if(pg_affected_rows($query)==0){
                throw new Exception("Erro ao inativar registro");
            }
        }
        function ativar(){
            $sql = "UPDATE valores SET b_ativo = true WHERE id = '$this->id'";
            $query = pg_query($sql);
            if(pg_affected_rows($query)==0){
                throw new Exception("Erro ao inativar registro");
            } 
        }

        function incluir(){
            $sql = "INSERT INTO valores (
                        id,
                        valormatricula,
                        valormensalidade,
                        anosemestre,
                        b_ativo   
                    ) VALUES(
                        default,
                        '$this->matricula',
                        '$this->mensalidade',
                        '$this->anosem',
                        default
                    )";
            $query = pg_query($sql);
            if(pg_affected_rows($query)==0){
                throw new Exception("Erro ao cadastrar Valores");
            }
        } 

        function alterar(){
            $sql = "UPDATE
                        valores
                    SET
                        valormatricula = '$this->matricula',
                        valormensalidade = '$this->mensalidade',
                        anosemestre = '$this->anosem'
                    WHERE
                        id = '$this->id'";
            $query = pg_query($sql);
            if(pg_affected_rows($query)==0){
                throw new Exception("Erro ao alterar valores");
            }
        }
 
        function formatarValores($matricula,$mensalidade,$anosem){
            if($matricula == "" || $mensalidade == "" || $anosem == ""){
                throw new Exception("Erro"); 
            } 
            $remove = array("R$", " ");
            $this->matricula = str_replace($remove,"",$matricula);
            $this->mensalidade = str_replace($remove,"",$mensalidade);
            $this->anosem = str_replace($remove,"",$anosem);
        } 
    }
?>

 