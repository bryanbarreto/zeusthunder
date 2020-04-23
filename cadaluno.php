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

    <h2>Gerenciar Alunos</h2>

    <!--data grid-->
    <table id="dg" title="Cadastro de Alunos" class="easyui-datagrid" style="width:100% ;height:450px"
        url="academia-backend/app/cadaluno.app.php?ajax=carregarTodos" toolbar="#toolbar" pagination="false"
        rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
                <th field="c_nome" width="40"><b>Nome</b></th>
                <th field="c_cpf" width="13"><b>CPF</b></th>
                <th field="c_datanascimento" width="17"><b>Data de Nascimento</b></th>
                <th field="celformatado" width="15"><b>Telefone</b></th>
                <th field="status" width="10"><b>Status</b></th>
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
            onclick="inativar()">Inativar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" plain="true"
            onclick="ativar()">Ativar</a>
    </div>
    <!--toolbar-->
    <!--dialog-->
    <div id="dlg" class="easyui-dialog" style="width:700px; top:30px"
        data-options="draggable:false,closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
        <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">

            <div style="margin-bottom: 10px">
                <h2>Dados Pessoais:</h2>
            </div>

            <div style="width:100%; margin-bottom:10px">
                <input class="easyui-textbox" style="width:99%" id="c_nome" name="c_nome"
                    data-options="label:'Nome:', labelPosition:'top',required:true">
            </div>

            <div style="width:100%; margin-bottom:10px">
                <div style="width:33.33%;float:left">
                    <input class="easyui-maskedbox" id="c_cpf" name="c_cpf" mask="999.999.999-99" label="CPF:"
                        labelPosition="top" style="width:99%" data-options="required:true">
                </div>
                <div style=" width:33.33%;float:left">
                    <input class="easyui-maskedbox" id="c_telefone" name="c_telefone" mask="(99) 9 9999-9999"
                        label="Celular:" labelPosition="top" style="width:99%" data-options="required:true">
                </div>
                <div style="width:33.33%;float:left">
                    <input class="easyui-maskedbox" id="c_datanascimento" name="c_datanascimento" mask="99/99/9999"
                        label="Data de Nascimento:" labelPosition="top" style="width:99%" data-options="required:true">
                </div>
            </div>

            <div style="margin-bottom: 10px; margin-top:40px">
                <h2>Informações de Endereço:</h2>
            </div>

            <div style="width:100%; margin-bottom:10px">
                <div style="width:20%; float:left">
                    <input class="easyui-maskedbox" id="c_cep" name="c_cep" mask="99999-999" label="CEP:"
                        labelPosition="top" style="width:99%" required="true" onkeyup="pesquisarCep()">
                </div>

                <div style="width:60%; float:left">
                    <input class="easyui-textbox" id="c_rua" readonly name="c_rua" label="Rua:" labelPosition="top"
                        style="width:99%">
                </div>

                <div style="width:20%; float:left">
                    <input class="easyui-numberbox" id="n_numero" required="true" name="n_numero" label="Número:"
                        labelPosition="top" style="width:99%">
                </div>
            </div>

            <div style="width:100%; margin-bottom:10px">
                <div style="width:33.33%; float:left">
                    <input class="easyui-textbox" id="c_bairro" readonly name="c_bairro" label="Bairro:"
                        labelPosition="top" style="width:99%">
                </div>

                <div style="width:33.33%; float:left">
                    <input class="easyui-textbox" id="c_cidade" readonly name="c_cidade" label="Cidade:"
                        labelPosition="top" style="width:99%">
                </div>

                <div style="width:33.33%; float:left">
                    <input class="easyui-textbox" id="c_estado" readonly name="c_estado" label="Estado:"
                        labelPosition="top" style="width:99%">
                </div>
            </div>

            <div style="width:100%; margin-bottom:10px">
                <input class="easyui-textbox" id="c_complemento" name="c_complemento" style="width:100%"
                    data-options="label:'Complemento:', labelPosition:'top'">
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