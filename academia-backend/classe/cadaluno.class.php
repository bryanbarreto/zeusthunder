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
                        n_numero,
                        c_bairro,
                        c_cidade,
                        c_estado,
                        c_complemento,
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
                        default
                    )";
            $query = pg_query($sql);
            if(pg_affected_rows($query)==0){
                throw new Exception("Erro ao cadastrar Aluno: ".pg_last_error());
            }
        }
 
        function alterar(){
            $sql = "UPDATE aluno 
                        SET
                            c_nome = '$this->nome', 
                            c_cpf = '$this->cpf',
                            c_telefone = '$this->telefone',
                            c_datanascimento = '$this->dataNascimento',
                            c_cep = '$this->cep',
                            c_rua = '$this->rua',
                            n_numero = '$this->numero',
                            c_bairro = '$this->bairro',
                            c_cidade = '$this->cidade',
                            c_estado = '$this->estado',
                            c_complemento = '$this->complemento'
                        WHERE
                            id = '$this->id'";
            $query = pg_query($sql);
            if(pg_affected_rows($query)==0){
                throw new Exception("Erro ao alterar Aluno: ".pg_last_error()); 
            }
        }

        function ativar(){
            $sql = "UPDATE aluno SET b_ativo = true WHERE id = '$this->id'";
            $query = pg_query($sql); 
            if(pg_affected_rows($query)==0){
                throw new Exception("Erro ao ativar aluno: ".pg_last_error()); 
            } 
        }

        function inativar(){
            $sql = "UPDATE aluno SET b_ativo = false WHERE id = '$this->id'";
            $query = pg_query($sql); 
            if(pg_affected_rows($query)==0){
                throw new Exception("Erro ao inativar aluno: ".pg_last_error()); 
            } 
        }
 
 
        // funcoes de verificacao
        function isAluno($flag){
            //verifica se está incluindo registro ou alterando
            if($flag == 'incluir'){
                $sql = "SELECT * FROM aluno WHERE c_cpf = '$this->cpf'";

            //caso esteja alterando, busca o cpf no banco excluindo o id do registro atual
            }else if($flag == 'alterar'){
                $sql = "SELECT * FROM aluno WHERE c_cpf = '$this->cpf' AND id != '$this->id'";
            }
            $query = pg_query($sql);
            if(pg_num_rows($query)>0){
                throw new Exception("Este CPF já foi cadastrado no sistema");
            }
        }

        function validarCpf(){
            //remove os digitos da mascara ("." e "-")
            $numeroCpf = $this->formatarCpf();

            // verifica se o cpf digitado contem todos os digitos iguais
            $this->verificarDigitos($numeroCpf);

            // a soma dos digitos do cpf devem sempre retornar 2 numeros iguais: 11, 22, 33, 44
            // Verifica se a soma dos digitos resultam em numeros iguais passando por parametro
            $this->verificarSomaCpf($numeroCpf); 

            //realiza a validação do cpf, fazendo a lógica de multiplicar os numeros e comparar com os digitos verificadores
            $this->verificarDigitoVerificador1($numeroCpf);
            $this->verificarDigitoVerificador2($numeroCpf);
        }

        function verificarDigitos($cpf){
            if(
                $cpf == "00000000000" ||
                $cpf == "11111111111" ||
                $cpf == "22222222222" ||
                $cpf == "33333333333" ||
                $cpf == "44444444444" ||
                $cpf == "55555555555" ||
                $cpf == "66666666666" ||
                $cpf == "77777777777" ||
                $cpf == "88888888888" ||
                $cpf == "99999999999"
            ){
                throw new Exception("O CPF não pode ter todos os dígitos iguais");
            }
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
                $flag = 
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

        //formata o celular para transformar em link clicavel de converda do wpp 
        function retornarNumeros($celular){
            $remove = array("(",")"," ","-");
            return str_replace($remove,"",$celular);
        }
    }  
?>   