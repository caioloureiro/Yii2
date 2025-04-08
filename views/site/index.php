<?php

/** @var yii\web\View $this */

$this->title = 'API Yii2 para Angular';

?>

<style><?php require '../web/css/site.css'; ?></style>

<div class="crud-container">
	<h1>CRUD Angular2025</h1>
	
	<table class="crud-table">
		<thead>
			<tr>
				<th>ID</th>
				<th>Nome</th>
				<th>Quantidade</th>
				<th>Categoria</th>
				<th>Ações</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>35</td>
				<td>Teste</td>
				<td>10</td>
				<td>Esporte</td>
				<td class="actions">
					<button class="edit-btn">Editar</button>
					<button class="del-btn">Excluir</button>
				</td>
			</tr>
			
		</tbody>
	</table>
	
	<hr class="divider">
	
	<div class="crud-actions">
		<button class="add-btn">Criar Item</button>
	</div>
</div>