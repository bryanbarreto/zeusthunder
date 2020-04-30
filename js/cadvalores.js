$(document).ready(function () {
    //metodo de carregamento da grid
    $('#dg').datagrid({
        onLoadError: function () {
            $.messager.alert("Erro", "Erro ao carregar alunos", "error")
            $('#exibeMatricula').textbox('clear')
            $('#exibeMensalidade').textbox('clear')
        },
        onLoadSuccess: function (data) {
            var flag = true
            var semestreAtual = data.rows[0].semestreAtual
            for (var i = 0; i < data.rows.length; i++) {
                //console.log(data.rows[i].anosemestre)
                if (data.rows[i].anosemestre == semestreAtual && data.rows[i].b_ativo == 't') {
                    $('#exibeMatricula').textbox('setValue', data.rows[i].valormatriculaf)
                    $('#exibeMensalidade').textbox('setValue', data.rows[i].valormensalidadef)
                    flag = false
                }
            }

            //condicao para limpar o campo de valor da matricula e da mensalidade
            if (flag == true) {
                $('#exibeMatricula').textbox('clear')
                $('#exibeMensalidade').textbox('clear')
            }
        }
    })
})

var row
var opcao
var url = "academia-backend/app/cadvalores.app.php"

function novo() {
    $('#fm').form('clear')
    $('#dlg').dialog('open').dialog('setTitle', 'Novos Valores')
    opcao = "novo"
}

function editar() {
    opcao = "alterar"
    row = $('#dg').datagrid('getSelected')
    if (row) {
        $('#fm').form('load', row)
        $('#dlg').dialog('open').dialog('setTitle', 'Alterar Valores')
    } else {
        $.messager.alert("Aviso", "Escolha um registro para alterar", "warning")
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
            title: 'Ativar',
            msg: 'Gostaria de ativar este registro?',
            ok: 'Sim',
            cancel: 'Não',
            fn: function (r) {
                if (r) {
                    $.post(url, {
                        ajax: 'ativar',
                        id: row.id
                    }, function (result) {
                        if (result == true) {
                            $.messager.alert("Sucesso", "Registro ativado com sucesso", "info")
                            $('#dg').datagrid('reload')
                        } else {
                            $.messager.alert("Erro", result, "error")
                        }
                    }, 'JSON')
                }
            }
        })
    } else {
        $.messager.alert("Aviso", "Escolha um registro para ativar", "warning")
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
            title: 'Inativar',
            msg: 'Gostaria de inativar este registro?',
            ok: 'Sim',
            cancel: 'Não',
            fn: function (r) {
                if (r) {
                    $.post(url, {
                        ajax: 'inativar',
                        id: row.id
                    }, function (result) {
                        if (result == true) {
                            $.messager.alert("Sucesso", "Registro inativado com sucesso", "info")
                            $('#dg').datagrid('reload')
                        } else {
                            $.messager.alert("Erro", result, "error")
                        }
                    }, 'JSON')
                }
            }
        })
    } else {
        $.messager.alert("Aviso", "Escolha um registro para inativar", "warning")
    }
}

function salvar() {
    var matricula = $('#matricula').textbox('getValue')
    var mensalidade = $('#mensalidade').textbox('getValue')
    var anosem = $('#anosem').textbox('getValue')

    if (matricula.includes("_") || mensalidade.includes("_") || anosem.includes("_")) {
        $.messager.alert("Aviso", "Preencha corretamente todos os campos", "warning")
    }

    switch (opcao) {
        case 'novo':
            $.post(url, {
                ajax: 'incluir',
                matricula: matricula,
                mensalidade: mensalidade,
                anosem: anosem
            }, function (result) {
                if (result == true) {
                    $.messager.alert("Sucesso", "Valores cadastrados com sucesso", "info")
                    $('#dlg').dialog('close')
                    $('#dg').datagrid('reload')
                } else {
                    $.messager.alert("Erro", result, "error")
                }
            }, 'JSON')
            break;

        case 'alterar':
            $.post(url, {
                ajax: 'alterar',
                id: row.id,
                matricula: matricula,
                mensalidade: mensalidade,
                anosem: anosem
            }, function (result) {
                if (result == true) {
                    $.messager.alert("Sucesso", "Valores alterado com sucesso", "info")
                    $('#dlg').dialog('close')
                    $('#dg').datagrid('reload')
                } else {
                    $.messager.alert("Erro", result, "error")
                }
            }, 'JSON')
            break;
    }
}