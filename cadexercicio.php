<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zeus Thunder - Cadastro de Exercícios</title>
    <?php include 'includes/jeasyui.includes.php'; ?>
    <script src="js/cadexercicio.js"></script>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <h2>Gerenciar Exercícios</h2>

    <!--data grid-->
    <table id="dg" title="Cadastro de Exercícios" class="easyui-datagrid" style="width:100% ;height:450px"
        url="academia-backend/app/cadexercicio.app.php?ajax=carregarTodos" toolbar="#toolbar" pagination="false"
        rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
                <th field="c_descricao" width="70"><b>Descrição</b></th>
                <th field="status" width="30"><b>Status</b></th>
            </tr>
        </thead>
    </table>
    <!--datagrid-->

    <!--toolbar-->
    <div id="toolbar">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="novo()">Novo</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true"
            onclick="editar()">Alterar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-no" plain="true"
            onclick="inativar()">Excluir</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" plain="true"
            onclick="ativar()">Restaurar</a>
    </div>
    <!--toolbar-->
    <!--dialog-->
    <div id="dlg" class="easyui-dialog" style="width:600px"
        data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
        <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
            <div style="margin-bottom:10px">
                <input name="descricao" id="descricao" class="easyui-textbox" label="Descrição:" style="width:100%">
            </div>
        </form>
    </div>
    <!--dialog-->

    <!-- dialog buttons -->
    <div id="dlg-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="salvar()"
            style="width:90px">Salvar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="$('#dlg').dialog('close')"
            style="width:100px">Cancelar</a>
    </div>
    <!-- dialog buttons -->
</body>

</html>