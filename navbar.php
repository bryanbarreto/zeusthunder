<div class="easyui-panel" style="padding:5px; margin-bottom:20px;">
    <a href="index.php" class="easyui-linkbutton" data-options="plain:true">Home</a>
    <a href="javascript:void(0)" class="easyui-menubutton" data-options="menu:'#mm1',iconCls:'icon-add'">Cadastros</a>
    <a href="javascript:void(0)" class="easyui-menubutton" data-options="menu:'#mm2',iconCls:'icon-add'">Matrícula</a>
    <a href="javascript:void(0)" class="easyui-menubutton" data-options="menu:'#mm3',iconCls:'icon-sum'">Financeiro</a>
    <a href="teste.php" class="easyui-linkbutton" style="float:right" data-options="plain:true">Teste</a>
</div>

<div id="mm1" style="width:150px;">
   <div onclick="window.location.href = 'cadaluno.php'" data-options="iconCls:'icon-add'">Alunos</div>
    <div class="menu-sep"></div>
    <div onclick="window.location.href = 'cadexercicio.php'" data-options="iconCls:'icon-add'">Exercícios</div>
</div>
 
<div id="mm2" style="width:150px;">
   <div onclick="window.location.href = 'matricularaluno.php'" data-options="iconCls:'icon-add'">Matricular Aluno</div>
</div>

<div id="mm3" style="width:180px;">
    <div onclick="window.location.href = 'cadvalores.php'" data-options="iconCls:'icon-sum'">Gerenciar Valores</div>
    <div class="menu-sep"></div>
    <div onclick="window.location.href = 'pagamentos.php'" data-options="iconCls:'icon-sum'">Pagamentos</div>
</div>
  