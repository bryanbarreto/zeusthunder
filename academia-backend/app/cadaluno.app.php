<?php

    include '../classe/bd.class.php';
    include '../classe/cadaluno.class.php';

    $objeto = new Aluno();
    $bd = new Bd();
    
    $ajax = $_REQUEST['ajax'];

    try{
        $bd->conectar();
    }catch(Exception $e){
        $json = $e->getMessage();
        echo json_encode($json);
    }

    switch($ajax){
        case 'carregarTodos':
            $json = $objeto->carregarTodos();
            if($json != false){
                foreach($json as &$dados){
                    $dados['examemedico'] = $dados['b_examemedico'] != 'f'? "<i style='font-size:18px;color:green;' class='fas fa-check-circle'></i>":"<i style='font-size:18px;color:red;' class='fas fa-times-circle'></i>"; 

                    $dados['c_nome'] = mb_convert_case($dados['c_nome'],MB_CASE_UPPER,'UTF-8');
                }
            } 
            echo json_encode($json);          
        break;
  
        case 'incluir':            
            try{
                $objeto->nome = $_REQUEST['nome'];
                $objeto->cpf = $_REQUEST['cpf'];
                $objeto->telefone = $_REQUEST['telefone']; 
                $objeto->dataNascimento = $_REQUEST['dataNascimento'];
                $objeto->cep = $_REQUEST['cep'];
                $objeto->rua = $_REQUEST['rua'];
                $objeto->numero = $_REQUEST['numero'];
                $objeto->bairro = $_REQUEST['bairro'];
                $objeto->cidade = $_REQUEST['cidade'];
                $objeto->estado = $_REQUEST['estado'];
                $objeto->complemento = $_REQUEST['complemento'];

                // faz a validacao do cpf 
                $objeto->validarCpf();

                // verifica se o aluno ja possui cadastro baseado no cpf
                $objeto->isAluno('incluir');

                $objeto->incluir();
                 
                $json = true;
            }catch(Exception $e){
                $json = $e->getMessage();
            }
            echo json_encode($json);
        break;

        case 'alterar':
            try{
                $objeto->id = $_REQUEST['id'];
                $objeto->nome = $_REQUEST['nome'];
                $objeto->cpf = $_REQUEST['cpf'];
                $objeto->telefone = $_REQUEST['telefone']; 
                $objeto->dataNascimento = $_REQUEST['dataNascimento'];
                $objeto->cep = $_REQUEST['cep'];
                $objeto->rua = $_REQUEST['rua'];
                $objeto->numero = $_REQUEST['numero'];
                $objeto->bairro = $_REQUEST['bairro'];
                $objeto->cidade = $_REQUEST['cidade'];
                $objeto->estado = $_REQUEST['estado'];
                $objeto->complemento = $_REQUEST['complemento'];

                // faz a validacao do cpf 
                $objeto->validarCpf();

                // verifica se o aluno ja possui cadastro baseado no cpf
                $objeto->isAluno('alterar');

                $objeto->alterar();
                 
                $json = true;
            }catch(Exception $e){
                $json = $e->getMessage();
            }
            echo json_encode($json);
        break;

        case 'ativar':
            try{
                $objeto->id = $_REQUEST['id'];
                $objeto->ativar();
                $json = true;
            }catch(Exception $e){
                $json = $e->getMessage();
            }
            echo json_encode($json);
        break;

        case 'inativar':
            try{
                $objeto->id = $_REQUEST['id'];
                $objeto->inativar();
                $json = true;
            }catch(Exception $e){
                $json = $e->getMessage();
            }
            echo json_encode($json);
        break;
    }

?>