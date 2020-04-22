<?php
    class CadExercicio{
        //atributos
        private $descricao;
        private $id;

        //getter
        public function getDescricao(){
            return $this->descricao;
        }
        public function getId(){
            return $this->id;
        }

        //setter
        public function setDescricao($descricao){
            $this->descricao = $descricao;
        }
        public function setId($id){
            $this->id = $id;
        }

        //funcoes
        public function carregarTodos(){
            $sql = "SELECT *,
                        c_descricao as descricao,
                        CASE WHEN
                            b_ativo = true THEN 'ATIVO' ELSE 'INATIVO'
                        END AS status
                    FROM
                        exercicio
                    ORDER BY
                        b_ativo desc, c_descricao asc";
            $query = pg_query($sql);
            if(pg_num_rows($query)==0){
                return false;
            }
            $res = pg_fetch_all($query);
            return $res;
        }
        public function incluir(){
            $sql = "INSERT INTO exercicio (c_descricao) values ('$this->descricao')";
            $query = pg_query($sql);
            if(pg_affected_rows($query)==0){
                throw new Exception("Erro ao incluir exercício");
            }
        } 
        public function alterar(){
            $sql = "UPDATE exercicio
                    SET c_descricao = '$this->descricao'
                    WHERE id = '$this->id'";
            $query = pg_query($sql);
            if(pg_affected_rows($query)==0){
                throw new Exception("Erro ao alterar exercício");
            }
        }

        public function ativar(){
            $sql = "UPDATE exercicio SET b_ativo = true WHERE ID = '$this->id'";
            $query = pg_query($sql);
            if(pg_affected_rows($query)==0){
                throw new Exception("Erro ao ativar registro");
            }
        }
        public function inativar(){
            $sql = "UPDATE exercicio SET b_ativo = false WHERE ID = '$this->id'";
            $query = pg_query($sql);
            if(pg_affected_rows($query)==0){
                throw new Exception("Erro ao ativar registro");
            }
        }
    }
?>   