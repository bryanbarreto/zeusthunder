<?php
    class MatricularAluno{
    public $id;
    public $matricula;
    public $id_aluno;
    public $data_matricula;
    public $trancado;
    public $data_trancado; 
    public $b_ativo;
    public $exame_medico;

        function carregarTodos(){
            $sql = "SELECT *,
                        mat.id as idmatricula,
                        alu.id as idaluno,
                        mat.b_ativo as statusmatricula
                    FROM
                        matricula mat
                    RIGHT JOIN aluno alu on mat.id_aluno=alu.id";
            $query = pg_query($sql);
            if(pg_num_rows($query)==0){
                return false;
            }
            $res = pg_fetch_all($query);  
            return $res; 
        }

        function matricular(){
            $sql = "INSERT INTO matricula (
                        id,
                        matricula,
                        id_aluno,
                        data_matricula,
                        b_ativo,
                        exame_medico
                    ) VALUES (
                        default,
                        '$this->matricula',
                        '$this->id_aluno',
                        '$this->data_matricula',
                        default,  
                        NULL
                    )";  
            $query = pg_query($sql);
            if(pg_affected_rows($query)==0){
                throw new Exception("Erro ao matricular aluno"+pg_last_error());
            }
        }

        function ativar(){
            $sql = "UPDATE matricula SET b_ativo = true where id = '$this->id'";
            $query=pg_query($sql);
            if(pg_affected_rows($query)==0){
                throw new Exception("Erro ao ativar matrícula");
            }
        }
        function intivar(){
            $sql = "UPDATE matricula SET b_ativo = false where id = '$this->id'";
            $query=pg_query($sql);
            if(pg_affected_rows($query)==0){
                throw new Exception("Erro ao inativar matrícula");
            }
        }

        function exameMedico(){
            $sql = "UPDATE matricula SET exame_medico = '$this->exame_medico' WHERE id='$this->id'";
            $query = pg_query($sql);
            if(pg_affected_rows($query)==0){
                throw new Exception("Erro ao vincular exame ao aluno");
            }
        }

        function gerarMatricula($cpf){
            $remover = array(".","-");
            $cpf = str_replace($remover,"",$cpf); 

            $ano = date('Y');
            $semestre = date('m') <=6 ? 1 : 2;
            $fimCpf = substr($cpf,8);
            for($i=0;$i<=2;$i++){
                $rand .= rand(0,9);
            }
            $matricula = $ano.".".$semestre.".".$fimCpf.".".$rand;
            
            return $matricula;
        }
    }  
?> 