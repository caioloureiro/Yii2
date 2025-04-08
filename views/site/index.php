<?php

/** @var yii\web\View $this */

$this->title = 'API Yii2 para Angular';

//echo '<pre>'; print_r( $produtos ); echo'</pre>'; //TESTE DE GET NO BANCO
//echo '<pre>'; print_r( $categorias ); echo'</pre>'; //TESTE DE GET NO BANCO
//echo count($produtos); //TESTE DE GET NO BANCO

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
			
			<?php
				
				if( count($produtos) > 0 ){
					
					foreach( $produtos as $produto ){
						
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
								<button class="edit-btn" 
									data-id="'. $produto['id'] .'"
									data-nome="'. $produto['nome'] .'"
									data-quantidade="'. $produto['quantidade'] .'"
									data-categoria="'. $produto['categoria'] .'"
								>Editar</button>
								<button class="del-btn">Excluir</button>
							</td>
						</tr>
						';
						
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
	
	<hr class="divider">
	
	<div class="crud-actions">
		<button class="add-btn" id="openModalBtn">Criar Item</button>
	</div>
	
	<!-- A Modal -->
	<div id="itemModal" class="modal">
		<div class="modal-content">
			<div class="modal-header">
				<span class="modal-title">Adicionar Novo Item</span>
				<span class="close">&times;</span>
			</div>
			
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
						<option value="esportes">Esportes</option>
						<option value="eletronicos">Eletrônicos</option>
					</select>
				</div>
			</div>
			
			<div class="modal-footer">
				<button id="cancelBtn" class="btn btn-secondary">Cancelar</button>
				<button id="saveBtn" class="btn btn-primary">Gravar</button>
			</div>
		</div>
	</div>
	
	<script>
		// Pegar elementos do DOM
		const modal = document.getElementById("itemModal");
		const openModalBtn = document.getElementById("openModalBtn");
		const closeBtn = document.querySelector(".close");
		const cancelBtn = document.getElementById("cancelBtn");
		
		// Quando clicar no botão "Criar Item", abre a modal
		openModalBtn.addEventListener("click", function() {
			modal.style.display = "block";
		});
		
		// Quando clicar no ×, fecha a modal
		closeBtn.addEventListener("click", function() {
			modal.style.display = "none";
		});
		
		// Quando clicar no botão Cancelar, fecha a modal
		cancelBtn.addEventListener("click", function() {
			modal.style.display = "none";
		});
		
		// Quando clicar em qualquer lugar fora da modal, fecha ela
		window.addEventListener("click", function(event) {
			if (event.target == modal) {
				modal.style.display = "none";
			}
		});
		
		// Função para gravar os dados (você pode implementar a lógica aqui)
		document.getElementById("saveBtn").addEventListener("click", function() {
			const name = document.getElementById("itemName").value;
			const quantity = document.getElementById("itemQuantity").value;
			const category = document.getElementById("itemCategory").value;
			
			// Aqui você pode adicionar a lógica para salvar os dados
			console.log("Dados a serem salvos:", { name, quantity, category });
			
			// Fechar a modal após salvar
			modal.style.display = "none";
			
			// Limpar os campos
			document.getElementById("itemName").value = "";
			document.getElementById("itemQuantity").value = "";
			document.getElementById("itemCategory").value = "";
		});
		
		// Função para preencher a modal com dados do item a ser editado
		function editarItem(btn) {
			// Obter dados do botão clicado
			const id = btn.getAttribute('data-id');
			const nome = btn.getAttribute('data-nome');
			const quantidade = btn.getAttribute('data-quantidade');
			const categoriaId = btn.getAttribute('data-categoria');
			
			// Preencher os campos da modal
			document.getElementById('itemName').value = nome;
			document.getElementById('itemQuantity').value = quantidade;
			document.getElementById('itemCategory').value = categoriaId;
			
			// Armazenar o ID do item sendo editado (pode ser útil para o submit)
			document.getElementById('itemModal').setAttribute('data-editing-id', id);
			
			// Alterar o título da modal
			document.querySelector('.modal-title').textContent = 'Editar Item';
			
			// Mostrar a modal
			document.getElementById('itemModal').style.display = 'block';
		}
		
		// Adicionar event listeners para os botões de edição
		document.querySelectorAll('.edit-btn').forEach(btn => {
			btn.addEventListener('click', function() {
				editarItem(this);
			});
		});
		
		// Função para limpar a modal ao adicionar novo item
		document.getElementById('openModalBtn').addEventListener('click', function() {
			// Limpar campos
			document.getElementById('itemName').value = '';
			document.getElementById('itemQuantity').value = '';
			document.getElementById('itemCategory').value = '';
			
			// Remover ID de edição se existir
			document.getElementById('itemModal').removeAttribute('data-editing-id');
			
			// Restaurar título original
			document.querySelector('.modal-title').textContent = 'Adicionar Novo Item';
			
			// Mostrar modal
			document.getElementById('itemModal').style.display = 'block';
		});
		
	</script>
	
</div>