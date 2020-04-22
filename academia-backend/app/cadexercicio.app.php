<?php

    include '../classe/bd.class.php';
    include '../classe/cadexercicio.class.php';

    $objeto = new CadExercicio();
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
            echo json_encode($json);
        break;

        case 'incluir': 
            try{
                echo "chegou aqui";
                $objeto->setDescricao($_REQUEST['descricao']);
                $objeto->incluir();
                $json = true;
            }catch(Exception $e){
                $json = $e->getMessage();
            }
            echo json_encode($json);
        break;

        case 'editar':
            try{
                $objeto->setDescricao($_REQUEST['descricao']);
                $objeto->setId($_REQUEST['id']);
                $objeto->alterar();
                $json = true;
            }catch(Exception $e){
                $json = $e->getMessage();
            }
            echo json_encode($json);
        break;

        case 'ativar':
            try{
                $objeto->setId($_REQUEST['id']);
                $objeto->ativar();
                $json = true;
            }catch(Exception $e){
                $json = $e->getMessage();
            }
            echo json_encode($json);
        break;

        case 'inativar':
            try{
                $objeto->setId($_REQUEST['id']);
                $objeto->inativar();
                $json = true;
            }catch(Exception $e){
                $json = $e->getMessage();
            }
            echo json_encode($json);
        break;
    }
?>