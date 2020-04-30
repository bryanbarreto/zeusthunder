$(document).ready(function () {

    $('#filtro').combobox({
        onChange: function (value) {
            if (value == "matricula") {
                $('#campoPesquisa').maskedbox({
                    mask: '9999.9.999.999',
                    value: ''
                })
            } else if (value == "cpf") {
                $('#campoPesquisa').maskedbox({
                    mask: '999.999.999-99',
                    value: ''
                })
            } else {
                $('#campoPesquisa').maskedbox({
                    value: '',
                    mask: '',
                })
            }
        }
    })

    //retorna o valor atual da mensalidade e da matricula, baseado no ano/semestre atual
    $.post('academia-backend/app/cadvalores.app.php', {
        ajax: 'retornarValorMatricula'
    }, function (result) {
        if (result != false) {
            precoMensalidade = result[0].valormensalidade
        } else {
            $.messager.confirm({
                title: 'Erro',
                msg: 'Não há valores cadastrados para este semestre. Gostaria de cadastrar agora?',
                ok: 'Sim',
                cancel: 'Não',
                fn: function (r) {
                    if (r) {
                        window.location.href = "cadvalores.php"
                    }
                }
            })
        }
    }, 'JSON')

    //condicao para mudar a mascara do input de pesquisar aluno (por cpf ou nome)
    $('#campo').combobox({
        onChange: function (value) {
            if (value == "c_cpf") {
                $('#valor').maskedbox({
                    mask: '999.999.999-99'
                })
            } else if (value == "c_nome") {
                $('#valor').maskedbox({
                    mask: "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa"
                })
            }
        }
    })

    //metodo de erro ao carregar datagrid
    $('#dg').datagrid({
        onLoadError: function () {
            $.messager.alert("Erro", "Erro ao carregar alunos", "error")
        }
    })
})

var row;
var opcao;
var url = "academia-backend/app/matricularaluno.app.php"
var precoMatricula

function exameMedico() {
    row = $('#dg').datagrid('getSelected')
    if (row) {
        if (row.matricula == "Não Matriculado") {
            $.messager.alert("Aviso", "Só é possível vincular exame médico para aluno matriculado", "warning")
            return false
        }
        if (row.exame_medico == 't') {
            $.messager.alert("Aviso", "Este aluno já realizou o exame médico", "warning")
            return false
        }
        $.messager.confirm({
            title: "Exame",
            msg: "Confirma que este aluno realizou o exame médico?",
            ok: "Sim",
            cancel: "Não",
            fn: function (r) {
                if (r) {
                    $.post(url, {
                        ajax: "exameMedico",
                        id: row.idmatricula
                    }, function (result) {
                        if (result == true) {
                            $.messager.alert("Sucesso", "Aluno " + row.c_nome + " realizou o exame médico com sucesso", "info")
                            $('#dg').datagrid('reload')
                        } else {
                            $.messager.alert("Erro", result, "error")
                        }
                    }, 'JSON')
                }
            }
        })
    } else {
        $.messager.alert("Aviso", "Escolha um aluno para vincular exame médico", "warning")
    }
}

function ativar() {
    row = $('#dg').datagrid('getSelected')
    if (row) {
        if (row.matricula == "Não Matriculado") {
            $.messager.alert("Aviso", "Este aluno ainda não foi matriculado", "warning")
            return false
        }
        $.messager.confirm({
            title: 'Ativar',
            msg: 'Gostaria de ativar esta matrícula?',
            ok: 'Sim',
            cancel: 'Não',
            fn: function (r) {
                if (r) {
                    $.post(url, {
                        ajax: 'ativar',
                        id: row.idmatricula
                    }, function (result) {
                        if (result == true) {
                            $.messager.alert("Sucesso", "Matrícula ativada com sucesso", "info")
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
        if (row.matricula == "Não Matriculado") {
            $.messager.alert("Aviso", "Este aluno ainda não foi matriculado", "warning")
            return false
        }
        if (row.trancado == 'f') {
            $.messager.alert("Aviso", "É necessário trancar a matrícula antes de inativá- la", "warning")
            return false
        }
        $.messager.confirm({
            title: 'Inativar',
            msg: 'Gostaria de inativar esta matrícula?',
            ok: 'Sim',
            cancel: 'Não',
            fn: function (r) {
                if (r) {
                    $.post(url, {
                        ajax: 'inativar',
                        id: row.idmatricula
                    }, function (result) {
                        if (result == true) {
                            $.messager.alert("Sucesso", "Matrícula inativada com sucesso", "info")
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

function matricular() {
    row = $('#dg').datagrid('getSelected')
    if (row) {
        if (row.matricula != "Não Matriculado") {
            $.messager.alert("Aviso", "Este aluno já foi matriculado", "warning")
            return false
        }
        $.messager.confirm({
            title: "Matricular",
            msg: "Valor da matrícula: R$" + precoMatricula + "<br>Gostaria de matricular o aluno " + row.c_nome + " ?",
            ok: "Sim",
            cancel: "Não",
            fn: function (r) {
                if (r) {
                    $.post(url, {
                        ajax: "matricular",
                        idaluno: row.idaluno,
                        cpf: row.c_cpf
                    }, function (result) {
                        console.log(result)
                        if (result['bool'] == true) {
                            $.messager.alert("Sucesso", "Aluno matriculado com sucesso. Matricula: " + result['dados'], "info")
                            $('#dg').datagrid('reload')
                        } else {
                            $.messager.alert("Erro", result['dados'], "error")
                        }
                    }, 'JSON')
                }
            }
        })
    } else {
        $.messager.alert("Aviso", "Escolha um aluno para matricular", "warning")
    }
}

function verificarAtraso(value, row, index) {
    if (value.includes('ATRASO')) {
        return 'background-color:#ccc;color:red;';
    } else {
        return 'background-color:#fff;color:darkgreen';
    }
}