<?php
    include '../classe/bd.class.php';
    include '../classe/pagamentos.class.php';

    $objeto = new Pagamentos();
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

                    if($dados['vencimento'] != NULL){
                        $dados['pagamento'] = strtotime(str_replace('/','-',$dados['vencimento'])) < strtotime(date('d-m-Y')) ? "ATRASO (".$dados['vencimento'].")" :"EM DIA (".$dados['vencimento'].")";
                    }else{
                        $dados['pagamento'] = " - "; 
                    }
                }
            } 
            echo json_encode($json); 
        break;
    }
?>