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
            title: "Ativar",
            msg: "Deseja ativar o aluno " + row.c_nome + " ?",
            ok: "Sim",
            cancel: "Não",
            fn: function (resp) {
                if (resp) {
                    $.post(url, {
                        ajax: 'ativar',
                        id: row.id
                    }, function (result) {
                        if (result == true) {
                            $.messager.alert("Sucesso", "Aluno ativado com sucesso", "info")
                            $('#dg').datagrid('reload')
                        } else {
                            $.messager.alert("Erro", result, "error");
                        }
                    }, 'JSON')
                }
            }
        })
    } else {
        $.messager.alert("Aviso", "Escolha um aluno para ativar", "warning")
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
            title: "Inativar",
            msg: "Deseja inativar o aluno " + row.c_nome + " ?",
            ok: "Sim",
            cancel: "Não",
            fn: function (resp) {
                if (resp) {
                    $.post(url, {
                        ajax: 'inativar',
                        id: row.id
                    }, function (result) {
                        if (result == true) {
                            $.messager.alert("Sucesso", "Aluno inativado com sucesso", "info")
                            $('#dg').datagrid('reload')
                        } else {
                            $.messager.alert("Erro", result, "error");
                        }
                    }, 'JSON')
                }
            }
        })
    } else {
        $.messager.alert("Aviso", "Escolha um aluno para inativar", "warning")
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

        // verifica se data de nascimento contem _ (caso o usuario nao digite a data de nascimento completa, o valor sera retornado com underline por conta da mascara)
    } else if (dataNascimento.includes('_')) {
        $.messager.alert("warning", "Data de Nascimento não foi preenchida corretamente", "warning")
    } else if (cpf.includes('_')) {
        $.messager.alert("warning", "Cpf não foi preenchido corretamente", "warning")
    } else if (telefone.includes('_')) {
        $.messager.alert("warning", "Número de celular não foi preenchido corretamente", "warning")
    } else {

        // post para incluir ou alterar registro
        switch (opcao) {
            case 'novo':
                $.post(url, {
                    ajax: 'incluir',
                    nome: nome,
                    cpf: cpf,
                    telefone: telefone,
                    dataNascimento: dataNascimento,
                    cep: cep,
                    rua: rua,
                    numero: numero,
                    bairro: bairro,
                    cidade: cidade,
                    estado: estado,
                    complemento: complemento
                }, function (result) {
                    if (result == true) {
                        $.messager.alert("Sucesso", "Aluno cadastrado com sucesso", "info")
                        $('#dg').datagrid('reload')
                        $('#dlg').dialog('close')
                    } else {
                        $.messager.alert("Erro", result, "error")
                    }
                }, 'JSON')
                break;

            case 'editar':
                $.post(url, {
                    ajax: 'alterar',
                    id: row.id,
                    nome: nome,
                    cpf: cpf,
                    telefone: telefone,
                    dataNascimento: dataNascimento,
                    cep: cep,
                    rua: rua,
                    numero: numero,
                    bairro: bairro,
                    cidade: cidade,
                    estado: estado,
                    complemento: complemento
                }, function (result) {
                    if (result == true) {
                        $.messager.alert("Sucesso", "Aluno alterado com sucesso", "info")
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