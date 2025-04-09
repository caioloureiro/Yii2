<?php

/** @var yii\web\View $this */

use yii\helpers\html;

$this->title = 'API Yii2 para Angular';

//echo '<pre>'; print_r( $produtos ); echo'</pre>'; exit; //TESTE DE GET NO BANCO
//echo '<pre>'; print_r( $categorias ); echo'</pre>'; //TESTE DE GET NO BANCO
//echo count($produtos); //TESTE DE GET NO BANCO

?>

<style><?php require '../web/css/site.css'; ?></style>

<div class="crud-container">
	<h1>CRUD Yii2</h1>
	
	<div class="crud-actions">
		<?= Html::a( 'Criar item', ['/site/create'], ['class' => 'add-btn'] ) ?>
	</div>
	
	<hr class="divider">
	
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
			
			<?php
				
				if( count($produtos) > 0 ){
					
					foreach( $produtos as $produto ){
						
						if( $produto['ativo'] != 0 ){
						
							$categoria = '';
							
							foreach( $categorias as $cat ){
								
								if( $cat['id'] == $produto['categoria'] ){
									
									$categoria = $cat['name'];
									
								}
								
							}
							
							echo'
							<tr>
								<td>'. $produto['id'] .'</td>
								<td>'. $produto['nome'] .'</td>
								<td>'. $produto['quantidade'] .'</td>
								<td>'. $categoria .'</td>
								<td class="actions">
									';
									
									echo Html::a( 'Editar', ['update', 'id' => $produto->id], ['class' => 'edit-btn'] );
									echo Html::a('Excluir', ['site/delete', 'id' => $produto['id']], [
										'class' => 'del-btn',
										'data' => [
											'confirm' => 'Tem certeza que deseja excluir este item?',
											'method' => 'post',
										],
									]);
									
									echo'
								</td>
							</tr>
							';
							
						}
						
					}
					
					
				}
				else{
					
					echo'
					<tr>
						<td colspan=5>Nenhum item encontrado.</td>
					</tr>
					';
					
				}
				
			?>
			
		</tbody>
	</table>
	
	<!-- A Modal -->
	<div id="itemModal" class="modal">
	
		<div class="modal-content">
		
			<div class="modal-header">
				<span class="modal-title">Adicionar Novo Item</span>
				<span class="close">&times;</span>
			</div>
			
			<form method="POST">
			
				<div class="modal-body">
				
					<div class="form-group">
						<label for="itemName">Nome:</label>
						<input type="text" id="itemName" placeholder="Digite o nome do item">
					</div>
					
					<div class="form-group">
						<label for="itemQuantity">Quantidade:</label>
						<input type="number" id="itemQuantity" placeholder="Digite a quantidade">
					</div>
					
					<div class="form-group">
						<label for="itemCategory">Categoria:</label>
						<select id="itemCategory">
							<option value="">Selecione uma categoria</option>
							<?php
								
								foreach( $categorias as $cat ){
								
									echo'<option value="'. $cat['id'] .'">'. $cat['name'] .'</option>';
									
								}
								
							?>
						</select>
					</div>
				</div>
				
				<div class="modal-footer">
					<div 
						id="cancelBtn" 
						class="btn btn-secondary"
					>Cancelar</div>
					<button 
						id="saveBtn" 
						class="btn btn-primary"
						type="submit"
					>Gravar</button>
				</div>
				
			</form>
			
		</div>
		
	</div>
	
</div>