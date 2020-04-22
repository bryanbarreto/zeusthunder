$(document).ready(function () {

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


// FUNCAO PARA FORMATAR A DATA DD//MM/YYYY
function myformatter(date) {
    var y = date.getFullYear();
    var m = date.getMonth() + 1;
    var d = date.getDate();
    return (d < 10 ? ('0' + d) : d) + '/' + (m < 10 ? ('0' + m) : m) + '/' + y;
}

function myparser(s) {
    if (!s) return new Date();
    var ss = (s.split('\/'));
    var d = parseInt(ss[0], 10);
    var m = parseInt(ss[1], 10);
    var y = parseInt(ss[2], 10);
    if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
        return new Date(y, m - 1, d);
    } else {
        return new Date();
    }
}
// FUNCAO PARA FORMATAR A DATA DD//MM/YYYY


var opcao;
var row;
var url = "academia-backend/app/cadaluno.app.php"

function novo() {
    opcao = "novo"
    $('#fm').form('clear')
    $('#dlg').dialog('open').dialog('setTitle', 'Novo Aluno')
}

function editar() {
    opcao = "editar"
    row = $('#dg').datagrid('getSelected')
    if (row) {
        $('#dlg').dialog('open').dialog('setTitle', 'Alterar Aluno')
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

    var nome = $('#c_nome').textbox('getValue')
    var cpf = $('#c_cpf').textbox('getValue')
    var telefone = $('#c_telefone').textbox('getValue')
    var dataNascimento = $('#c_datanascimento').textbox('getValue')
    var cep = $('#c_cep').textbox('getValue')
    var rua = $('#c_rua').textbox('getValue')
    var numero = $('#n_numero').textbox('getValue')
    var bairro = $('#c_bairro').textbox('getValue')
    var cidade = $('#c_cidade').textbox('getValue')
    var estado = $('#c_estado').textbox('getValue')
    var complemento = $('#c_complemento').textbox('getValue')

    if (nome == "" || cpf == "" || telefone == "" || dataNascimento == "" || cep == "" || rua == "" || numero == "" || bairro == "" || cidade == "" || estado == "") {
        $.messager.alert("Aviso", "Preencha os campos obrigatórios", "warning")
    } else {
        alert('chamada do metodo de salvar')
        return false
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
    $.get('https://viacep.com.br/ws/' + cep + '/json/', function (result) {

        if (result.erro) {
            $.messager.alert("Erro", "Digite um CEP válido", "error")
            $('#c_rua').textbox('setValue', '')
            $('#c_bairro').textbox('setValue', '')
            $('#c_cidade').textbox('setValue', '')
            $('#c_estado').textbox('setValue', '')
        } else {
            $('#c_rua').textbox('setValue', result.logradouro)
            $('#c_bairro').textbox('setValue', result.bairro)
            $('#c_cidade').textbox('setValue', result.localidade)
            $('#c_estado').textbox('setValue', result.uf)
        }
    }, 'JSON')
}