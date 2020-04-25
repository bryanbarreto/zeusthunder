$(document).ready(function () {

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

function exameMedico() {
    row = $('#dg').datagrid('getSelected')
    if (row) {
        if (row.matricula == "Não Matriculado") {
            $.messager.alert("Aviso", "Só é possível vincular exame médico para aluno matriculado", "warning")
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
                        // FAZER A LOGICA PARA ATIVAR MATRICULA
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
                        // FAZER A LOGICA PARA INATIVAR MATRICULA
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
            msg: "Gostaria de matricular o aluno " + row.c_nome + " ?",
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