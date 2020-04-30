<?php
    class Pagamentos{
    public $id;
    public $matricula;
    public $id_aluno;
    public $data_matricula;
    public $vencimento;
    public $trancado;
    public $data_trancado; 
    public $b_ativo;
    public $exame_medico;

        function carregarTodos(){
            $sql = "SELECT *,
                        mat.id as idmatricula,
                        alu.id as idaluno,
                        mat.b_ativo as statusmatricula,
                        CASE WHEN
                            mat.b_ativo = true THEN 'ATIVO' ELSE 'INATIVO'
                        END AS matbativo
                    FROM  
                        matricula mat
                    RIGHT JOIN aluno alu on mat.id_aluno=alu.id 
                    WHERE alu.b_ativo = true";
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
                        exame_medico,
                        vencimento
                    ) VALUES (
                        default,
                        '$this->matricula',
                        '$this->id_aluno',
                        '$this->data_matricula',
                        default,  
                        NULL,
                        '$this->vencimento'
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
        function inativar(){
            $sql = "UPDATE matricula SET b_ativo = false where id = '$this->id'";
            $query=pg_query($sql);
            if(pg_affected_rows($query)==0){
                throw new Exception("Erro ao inativar matrícula");
            }
        } 

        function exameMedico(){
            $sql = "UPDATE matricula SET exame_medico = 'true' WHERE id='$this->id'";
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

        function valorMatricula(){
            $sql = "SELECT * FROM valormatricula WHERE b_ativo = true ORDER BY id DESC LIMIT 1";
            $query = pg_query($sql);
            if(pg_num_rows($query)==0){
                return false;
            }
            $res = pg_fetch_all($query);
            return $res;
        }

        function gerarVencimento(){

            //transforma a data da matricula em array para isolar dia, mes e ano
            $array = explode('/',$this->data_matricula);
            $dia = $array[0]; 
            $mes = $array[1]; 
            $ano = $array[2];
        
            //caso o dia da matricula seja maior que 28, ele muda para 28, para evitar problemas com o mes de fevereiro
            $dia = $dia > 28 ? 28 : $dia;
        
            //adiciona +1 mes na data de matricula, para ser a data do proximo vencimento
            if($mes == 12){
                $mes = 1;
                $ano ++;
            }else{ 
                $mes++;
            }
        
            //verifica se o mes possui somente 1 digito e adiciona '0' na frente 
            $mes = strlen($mes) == 1? '0'.$mes:$mes;
        
            return $dia."/".$mes."/".$ano;
        
        }

        function formatarData($data){

        }
    }  
?> 