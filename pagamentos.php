<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zeus Thunder - Pagamentos</title>
    <?php include 'includes/jeasyui.includes.php'; ?>
    <script src="js/pagamentos.js"></script>
</head>

<body>
    <?php include 'navbar.php'; ?>
 
    <h2>Gerenciar Pagamentos</h2>

    <!--data grid-->
    <table id="dg" title="Cadastro de Alunos" class="easyui-datagrid" style="width:100% ;height:400px"
        url="academia-backend/app/pagamentos.app.php?ajax=carregarTodos" toolbar="#toolbar" pagination="false"
        rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr> 
                <th field="c_nome" width="30"><b>Nome</b></th>
                <th field="c_cpf" width="13"><b>CPF</b></th>
                <th field="matricula" width="13"><b>MATRÍCULA</b></th>
                <th field="pagamento" width="20" data-options="styler:verificarAtraso"><b>PGTO</b></th>
            </tr>
        </thead>
    </table>
    <!--datagrid-->

    <!--toolbar-->
    <div id="toolbar" style="height:80px">
        <div style="margin-bottom:10px">
            <a href="javascript:void(0)" class="easyui-linkbutton c1" iconCls="icon-add" plain="true"
                onclick="novoPagamento()">Novo Pagamento</a>
        </div>
        <div>
            <span style="margin-right:10px; font-weight:bold">Filtros: </span>
            <select class="easyui-combobox" id="filtro" style="width:120px" data-options="editable:false, panelHeight:'auto'">
                <option value="" selected>Todos</option>
                <option value="matricula">Matrícula</option>
                <option value="cpf">CPF</option>
            </select>
            <input class="easyui-maskedbox" id="campoPesquisa" data-options="prompt:'Pesquisar'">
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="pesquisar()">Pesquisar</a>
        </div>
    </div>
    <!--toolbar-->

</body>

</html>