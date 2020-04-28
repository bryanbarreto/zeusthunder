<?php
    include '../classe/bd.class.php';
    include '../classe/cadvalores.class.php';

    $objeto = new CadValores();
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
                $remove = array("R$");
                foreach($json as &$dados){
                    $dados['status'] = $dados['b_ativo']=='t'?"ATIVO":"INATIVO";

                    $dados['valormatriculaf'] = "R$".$dados['valormatricula'];
                    $dados['valormensalidadef'] = "R$".$dados['valormensalidade'];

                    $dados['matricula'] = "R$ ".$dados['valormatricula'];
                    $dados['mensalidade'] = "R$ ".$dados['valormensalidade'];
                    $dados['anosem'] = $dados['anosemestre'];
                } 
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

        case 'incluir':
            try{
                $matricula = $_REQUEST['matricula'];
                $mensalidade = $_REQUEST['mensalidade'];
                $anosem = $_REQUEST['anosem'];

                //valida os valores e remove R$, '.' e ' ' dos valores vindos do formulario e atribui pra variavel da classe
                $objeto->formatarValores($matricula,$mensalidade,$anosem);

                $objeto->incluir();
                $json = true;
            }catch(Exception $e){
                $json = $e->getMessage();
            }
            echo json_encode($json);
        break;

        case 'alterar':
            try{
                $matricula = $_REQUEST['matricula'];
                $mensalidade = $_REQUEST['mensalidade'];
                $anosem = $_REQUEST['anosem'];

                //valida os valores e remove R$, '.' e ' ' dos valores vindos do formulario e atribui pra variavel da classe
                $objeto->formatarValores($matricula,$mensalidade,$anosem);

                $objeto->id = $_REQUEST['id'];

                $objeto->alterar();
                $json = true;
            }catch(Exception $e){
                $json = $e->getMessage();
            }
            echo json_encode($json);
        break;
    }  

?>