<?php
    class Aluno{
        //atributos
        public $id;
        public $nome;
        public $cpf;
        public $telefone;
        public $dataNascimento;
        public $cep;
        public $rua;
        public $numero;
        public $bairro;
        public $cidade;
        public $estado;
        public $complemento;
        public $motivo;
        //getter

        //setter

        //funcoes
        function carregarTodos(){
            $sql = "SELECT *,
                        CASE 
                            WHEN b_ativo = true THEN 'ATIVO' ELSE 'INATIVO'
                        END AS status
                    FROM aluno ORDER BY c_nome";
            $query = pg_query($sql);
            if(pg_num_rows($query)==0){  
                return false;
            }
            $res = pg_fetch_all($query);
            return $res;
        }

        function incluir(){
            $sql = "INSERT INTO aluno (
                        id,
                        c_nome,
                        c_cpf,
                        c_telefone,
                        c_datanascimento,
                        c_cep,
                        c_rua,
                        n_número,
                        c_bairro,
                        c_cidade,
                        c_estado,
                        c_complemento,
                        b_examemedico,
                        d_datamatricula,
                        d_trancado, 
                        b_ativo
                    ) VALUES (
                        default,
                        '$this->nome', 
                        '$this->cpf',
                        '$this->telefone',
                        '$this->dataNascimento',
                        '$this->cep',
                        '$this->rua',
                        '$this->numero',
                        '$this->bairro',
                        '$this->cidade',
                        '$this->estado',
                        '$this->complemento',
                        default,
                        default, 
                        NULL,
                        default
                    )";
            $query = pg_query($sql);
            if(pg_affected_rows($query)==0){
                throw new Exception("Erro ao cadastrar Aluno");
            }
        }

        function alterar(){

        }

        function ativar(){
            $sql = "UPDATE aluno 
                    SET 
                        b_tivo = false,
                        d_trancado = null, 
                        t_motivo = '$this->motivo'
                    WHERE id = '$this->id'";
            $query = pg_query($query);
            if(pg_affected_rows($query)==0){
                throw new Exception("Erro ao restaurar matrícula");
            } 
        }

        function inativar(){
            $sql = "UPDATE aluno 
                    SET
                        b_tivo = false, 
                        d_trancado = now()
                    WHERE id = '$this->id'";
            $query = pg_query($query); 
            if(pg_affected_rows($query)==0){
                throw new Exception("Erro ao trancar matrícula");
            } 
        }


        // funcoes de verificacao
        function isAluno(){
            $sql = "SELECT * FROM aluno WHERE c_cpf = '$this->cpf'";
            $query = pg_query($sql);
            if(pg_num_rows($query)>0){
                throw new Exception("Este CPF já foi cadastrado no sistema");
            }
        }

        function validarCpf(){
            //remove os digitos da mascara ("." e "-")
            $numeroCpf = $this->formatarCpf();

            // a soma dos digitos do cpf devem sempre retornar 2 numeros iguais: 11, 22, 33, 44
            // Verifica se a soma dos digitos resultam em numeros iguais passando por parametr
            $this->verificarSomaCpf($numeroCpf); 

            //realiza a validação do cpf, fazendo a lógica de multiplicar os numeros e comparar com os digitos verificadores
            $this->verificarDigitoVerificador1($numeroCpf);
            $this->verificarDigitoVerificador2($numeroCpf);
        }

        function formatarCpf(){
            $remover = array(".","-"); 
            return  str_replace($remover, "", $this->cpf);
        }

        function verificarSomaCpf($cpf){
            //transforma o cpf para array
            $arrayCpf = str_split($cpf); 

            // roda um foreach para somar todos os numeros, transforma para array e verifica se as posicoes sao iguais
            $somaDosNumeros = 0;
            foreach($arrayCpf as $numero){
                $somaDosNumeros += $numero;
            } 
            //transforma a soma dos numeros para array e compara se as 2 posicoes sao iguais
            $somaDosNumeros = str_split($somaDosNumeros);
            if($somaDosNumeros[0] != $somaDosNumeros[1]){
                //throw new Exception("O CPF digitado não é válido");
            }
        }

        function verificarDigitoVerificador1($cpf){
            //pega os digitos do cpf: 999.999.999-xx
            $digitos = str_split(substr($cpf,0,9));

            // pega os digitos verificadores do cpf: xxx.xxx.xxx-99
            $dgverificador = substr($cpf,9); 
            
            $soma = 0;
            $i=10;
            foreach($digitos as $digito){
                //echo $digito." x ".$i."<br>";
                $soma += $digito * $i;
                $i--;                         
            } 
           $dgv = 11 -  $soma % 11;

           //pega o digito verificador
           $dgv1 = $dgv > 9 ? 0 : $dgv; 

           // verifica se o digito verificador 1 é igual ao informado no formulario
           if($dgv1 != $dgverificador[0]){
            throw new Exception("O CPF digitado não é válido - Digito verificador 1 não confere");
           }
        }  

        function verificarDigitoVerificador2($cpf){
             //pega os digitos do cpf: 999.999.999-9x
             $digitos = str_split(substr($cpf,0,10));

             // pega os digitos verificadores do cpf: xxx.xxx.xxx-x9
             $dgverificador = substr($cpf,10); 

             $soma = 0;
             $i=11;
             foreach($digitos as $digito){
                 //echo $digito." x ".$i."<br>";
                 $soma += $digito * $i;
                 $i--;                         
             } 

             $dgv = 11 -  $soma % 11;

           //pega o digito verificador
           $dgv2 = $dgv > 9 ? 0 : $dgv; 

           // verifica se o digito verificador 2 é igual ao informado no formulario
           if($dgv2 != $dgverificador[0]){
            throw new Exception("O CPF digitado não é válido - Digito verificador 2 não confere");
           }
             
        }
    }  
?>   