$(document).ready(function () {
    console.log('testando cepii')

    // funcao de onchange para verificar se o cep foi digitado corretamente e realizar a busca utilizando a api do viacep
    $('#c_cep').maskedbox({
        onChange: function (newValue, oldValue) {
            //converte o cep para inteiro e substitui o - da mascara por vazio
            var cep = parseInt(newValue.replace('-', ''))

            //faz a verificacao do length do cep (necessario convertelo para string)
            if (cep.toString().length == 8) {
                buscarCep(cep)
            }
        }
    });
})

var opcao;
var row;
var url = "academia-backend/app/cadaluno.app.php"

function novo() {
    opcao = "novo"
    $('#fm').form('clear')
    $('#dlg').dialog('open').dialog('setTitle', 'Novo Exercício')
}

function editar() {
    opcao = "editar"
    row = $('#dg').datagrid('getSelected')
    if (row) {
        $('#dlg').dialog('open').dialog('setTitle', 'Alterar Exercício')
        $('#fm').form('load', row)
    } else {
        $.messager.alert("Aviso", "Escolha um exercício para editar", "warning")
    }
}

function ativar() {
    row = $('#dg').datagrid('getSelected')
    if (row) {
        if (row.b_ativo == 't') {
            $.messager.alert("Aviso", "Este registro já está ativo", "warning")
            return false
        }
        $.messager.confirm({
            title: "Restaurar",
            msg: "Deseja restaurar esse registro?",
            ok: "Sim",
            cancel: "Não",
            fn: function (resp) {
                if (resp) {
                    $.post(url, {
                        ajax: 'ativar',
                        id: row.id
                    }, function (result) {
                        if (result == true) {
                            $.messager.alert("Sucesso", "Registro ativado com sucesso", "info")
                            $('#dg').datagrid('reload')
                        } else {
                            $.messager.alert("Erro", result, "error");
                        }
                    }, 'JSON')
                }
            }
        })
    } else {
        $.messager.alert("Aviso", "Escolha um registro para restaurar", "warning")
    }
}

function inativar() {
    row = $('#dg').datagrid('getSelected')
    if (row) {
        if (row.b_ativo == 'f') {
            $.messager.alert("Aviso", "Este registro já está inativo", "warning")
            return false
        }
        $.messager.confirm({
            title: "Excluir",
            msg: "Deseja excluir esse registro?",
            ok: "Sim",
            cancel: "Não",
            fn: function (resp) {
                if (resp) {
                    $.post(url, {
                        ajax: 'inativar',
                        id: row.id
                    }, function (result) {
                        if (result == true) {
                            $.messager.alert("Sucesso", "Registro inativado com sucesso", "info")
                            $('#dg').datagrid('reload')
                        } else {
                            $.messager.alert("Erro", result, "error");
                        }
                    }, 'JSON')
                }
            }
        })
    } else {
        $.messager.alert("Aviso", "Escolha um registro para excluir", "warning")
    }
}

function salvar() {
    var descricao = $('#descricao').textbox('getValue')

    if (descricao == "") {
        $.messager.alert("Aviso", "Preencha a descrição do exercício", "warning")
    } else {
        switch (opcao) {
            case 'novo':
                $.post(url, {
                    ajax: 'incluir',
                    descricao: descricao
                }, function (result) {
                    if (result == true) {
                        $.messager.alert("Sucesso", "Exercício cadastrado com sucesso", "info")
                        $('#dg').datagrid('reload')
                        $('#dlg').dialog('close')
                    } else {
                        $.messager.alert("Erro", result, "error")
                    }
                }, 'JSON')
                break;

            case 'editar':
                $.post(url, {
                    ajax: 'editar',
                    descricao: descricao,
                    id: row.id
                }, function (result) {
                    if (result == true) {
                        $.messager.alert("Sucesso", "Exercício editado com sucesso", "info")
                        $('#dg').datagrid('reload')
                        $('#dlg').dialog('close')
                    } else {
                        $.messager.alert("Erro", result, "error")
                    }
                }, 'JSON')
                break;
        }
    }
}


//consome api do viacep atraves do cep recebido por parametro
function buscarCep(cep) {
    $.getJSON('https://viacep.com.br/ws/' + cep + '/json/viacep.com.br/ws/', function (result) {
        console.log(result)
    }, 'JSON')
}