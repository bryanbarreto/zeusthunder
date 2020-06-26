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


function verificarAtraso(value, row, index) {
    if (value.includes('ATRASO')) {
        return 'background-color:#ccc;color:red;';
    } else {
        return 'background-color:#fff;color:darkgreen';
    }
}

function novoPagamento() {
    row = $('#dg').datagrid('getSelected')
    if (row) {
        $.messager.confirm({
            title: '',
            msg: '',
            ok: '',
            cancel: '',
            fn: function (r) {

            }
        })
    } else {
        $.messager.alert("Aviso", "Escolha um aluno para realizar o pagamento", "warning")
    }
}