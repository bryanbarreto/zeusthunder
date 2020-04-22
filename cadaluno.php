<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zeus Thunder - Cadastro de Alunos</title>
    <?php include 'includes/jeasyui.includes.php'; ?>
    <script src="js/cadaluno.js"></script>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <!--data grid-->
    <table id="dg" title="Cadastro de Alunos" class="easyui-datagrid" style="width:100% ;height:450px" url=""
        toolbar="#toolbar" pagination="false" rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
                <th field="c_nome" width="20"><b>Nome</b></th>
                <th field="c_cpf" width="20"><b>CPF</b></th>
                <th field="d_datanascimento" width="20"><b>Data de Nascimento</b></th>
                <th field="c_telefone" width="20"><b>Telefone</b></th>
                <th field="status" width="20"><b>Status</b></th>
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
    <div id="dlg" class="easyui-dialog" style="width:700px"
        data-options="draggable:false,closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
        <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">

            <div style="margin-bottom: 10px">
                <h2>Dados Pessoaiss:</h2>
            </div>

            <div style="width:100%; margin-bottom:10px">
                <input class="easyui-textbox" style="width:99%" data-options="label:'Nome:', labelPosition:'top'">
            </div>

            <div style="width:100%; margin-bottom:10px">
                <div style="width:33.33%;float:left">
                    <input class="easyui-maskedbox" mask="999.999.999-99" label="CPF:" labelPosition="top"
                        style="width:99%">
                </div>
                <div style="width:33.33%;float:left">
                    <input class="easyui-maskedbox" mask="(99) 9 9999-9999" label="Telefone:" labelPosition="top"
                        style="width:99%">
                </div>
                <div style="width:33.33%;float:left">
                    <input class="easyui-maskedbox" mask="99/99/9999" label="Data de Nascimento:" labelPosition="top"
                        style="width:99%">
                </div>
            </div>

            <h2 style="opacity:0">a</h2>

            <div style="margin-bottom: 10px; margin-top:40px">
                <h2>Informações de Endereço:</h2>
            </div>

            <div style="width:100%; margin-bottom:10px">
                <div style="width:20%; float:left">
                    <input class="easyui-maskedbox" id="c_cep" name="c_cep" mask="99999-999" label="CEP:"
                        labelPosition="top" style="width:99%" onkeyup="pesquisarCep()">
                </div>

                <div style="width:60%; float:left">
                    <input class="easyui-textbox" label="Rua:" labelPosition="top" style="width:99%">
                </div>

                <div style="width:20%; float:left">
                    <input class="easyui-numberbox" label="Número:" labelPosition="top" style="width:99%">
                </div>
            </div>

            <div style="width:100%; margin-bottom:10px">
                <div style="width:33.33%; float:left">
                    <input class="easyui-textbox" label="Bairro:" labelPosition="top" style="width:99%">
                </div>

                <div style="width:33.33%; float:left">
                    <input class="easyui-textbox" label="Cidade:" labelPosition="top" style="width:99%">
                </div>

                <div style="width:33.33%; float:left">
                    <input class="easyui-textbox" label="Estado:" labelPosition="top" style="width:99%">
                </div>
            </div>

            <div style="width:100%; margin-bottom:10px">
                <input class="easyui-textbox" style="width:100%"
                    data-options="label:'Complemento:', labelPosition:'top'">
            </div>

            <h2 style="opacity:0">a</h2>

        </form>
    </div>
    <!--dialog-->

    <!--
    <input class="easyui-maskedbox" mask="99/99/9999" label="Data Nascimento:" labelPosition="top" style="width:95%">
    <input class="easyui-textbox" name="c_nome" id="c_nome" style="width:95%" data-options="label:'Nome:', labelPosition:'top'">
    -->

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