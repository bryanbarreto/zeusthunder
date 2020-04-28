<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zeus Thunder - Gerenciar Cotas</title>
    <?php include 'includes/jeasyui.includes.php'; ?>
    <script src="js/cadvalores.js"></script>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <h2>Gerenciar Cotas</h2>

    <!--data grid-->
    <table id="dg" title="Cadastro de Valores" class="easyui-datagrid" style="width:100% ;height:400px"
        url="academia-backend/app/cadvalores.app.php?ajax=carregarTodos" toolbar="#toolbar" pagination="false"
        rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr> 
                <th field="valormatriculaf" width="25"><b>MATRÍCULA</b></th>
                <th field="valormensalidadef" width="25"><b>MENSALIDADE</b></th>
                <th field="anosemestre" width="25"><b>SEMESTRE</b></th>
                <th field="status" align="center" width="25"><b>STATUS</b></th>
            </tr>
        </thead>
    </table>
    <!--datagrid-->
  
    <!--toolbar-->
    <div id="toolbar">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true"
        onclick="novo()">Novos Valores</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true"
        onclick="editar()">Alterar Valores</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-no" plain="true"
        onclick="inativar()">Inativar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" plain="true"
        onclick="ativar()">Ativar</a>
    </div>
    <!--toolbar-->

    <!--dialog-->
    <div id="dlg" class="easyui-dialog" style="width:300px"
        data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
        <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
            <div style="margin-bottom:10px">
                <input name="matricula" id="matricula" class="easyui-maskedbox" mask="R$ 999,99"  data-options="label:'Matrícula:',labelPosition:'top'" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="mensalidade" id="mensalidade" class="easyui-maskedbox"  mask="R$ 999,99"  data-options="label:'Mensalidade:',labelPosition:'top'" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="anosem" id="anosem" class="easyui-maskedbox" mask="9999.9"  data-options="label:'Ano/Semestre:',labelPosition:'top'" style="width:100%">
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