<?php
    include '../classe/bd.class.php';
    include '../classe/matricularaluno.class.php';

    $objeto = new MatricularAluno();
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
                    $dados['c_nome'] = strtoupper($dados['c_nome']);

                    $dados['exame'] = $dados['exame_medico']==NULL ? "<i style='font-size:18px;color:red;' class='fas fa-times-circle'></i>" : "<i style='font-size:18px;color:green;' class='fas fa-check-circle'></i>";

                    $dados['status'] = $dados['b_ativo'] == 'f'?"INATIVO":"ATIVO";

                    $dados['matricula'] = $dados['matricula']==null?"Não Matriculado":$dados['matricula'];
                }
            } 
            echo json_encode($json); 
        break;
  
        case 'matricular':
            try{   
                $objeto->id_aluno = $_REQUEST['idaluno'];
                $cpf = $_REQUEST['cpf'];
                $objeto->data_matricula = date('d/m/Y');
                $objeto->matricula = $objeto->gerarMatricula($cpf);
                $objeto->matricular();
                $json['bool'] = true;
                $json['dados'] = $objeto->matricula;
            }catch(Exception $e){
                $json['bool'] = false;
                $json['dados'] = $e->getMessage();
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

        case 'exameMedico':
            try{
                $objeto->id = $_REQUEST['id'];
                $objeto->exame_medico = date('d/m/Y');
                $objeto->exameMedico();
                $json = true;
            }catch(Exception $e){
                $json = $e->getMessage();
            }
            echo json_encode($json);
        break; 
    } 
  
?>    