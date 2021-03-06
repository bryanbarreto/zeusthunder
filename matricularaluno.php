<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zeus Thunder - Cadastro de Alunos</title>
    <?php include 'includes/jeasyui.includes.php'; ?>
    <script src="js/matricularaluno.js"></script>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <h2>Matricular Alunos</h2>

    <!--data grid-->
    <table id="dg" title="Cadastro de Alunos" class="easyui-datagrid" style="width:100% ;height:400px"
        url="academia-backend/app/matricularaluno.app.php?ajax=carregarTodos" toolbar="#toolbar" pagination="false"
        rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr> 
                <th field="c_nome" width="30"><b>Nome</b></th>
                <th field="c_cpf" width="13"><b>CPF</b></th>
                <th field="matricula" width="13"><b>MATRÍCULA</b></th>
                <th field="exame" align="center" width="10"><b>EXAME</b></th>
                <th field="matbativo" width="10"><b>STATUS</b></th>
            </tr>
        </thead>
    </table>
    <!--datagrid-->

    <!--toolbar-->
    <div id="toolbar" style="height:80px">
        <div style="margin-bottom:10px">
            <a href="javascript:void(0)" class="easyui-linkbutton c1" iconCls="icon-add" plain="true"
                onclick="matricular()">Matricular Aluno</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-no" plain="true"
                onclick="inativar()">Inativar</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" plain="true"
                onclick="ativar()">Ativar</a>
            <a href="javascript:void(0)" class="easyui-linkbutton c3" iconCls="icon-reload" plain="true"
                onclick="trancarMatricula()">Trancar
                Matrícula</a>
            <a href="javascript:void(0)" class="easyui-linkbutton c4" iconCls="icon-reload" plain="true"
                onclick="reabrirMatricula()">Reabrir
                Matrícula</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-more" plain="true"
                onclick="exameMedico()">Exame Médico</a>
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