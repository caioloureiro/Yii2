<?php

/** @var yii\web\View $this */

$this->title = 'API Yii2 para Angular';

//echo '<pre>'; print_r( $produtos ); echo'</pre>'; //TESTE DE GET NO BANCO
//echo '<pre>'; print_r( $categorias ); echo'</pre>'; //TESTE DE GET NO BANCO
//echo count($produtos); //TESTE DE GET NO BANCO

?>

<style><?php require '../web/css/site.css'; ?></style>

<div class="crud-container">
	<h1>CRUD Yii2</h1>
	
	<div class="crud-actions">
		<button class="add-btn" id="openModalBtn">Criar Item</button>
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
	
	<!-- A Modal -->
	<div id="itemModal" class="modal">
	
		<div class="modal-content">
		
			<div class="modal-header">
				<span class="modal-title">Adicionar Novo Item</span>
				<span class="close">&times;</span>
			</div>
			
			<form method="POST">
			
				<div class="modal-body">
					
					<input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
				
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
		
		// Função para gravar os dados
		document.getElementById("saveBtn").addEventListener("click", async function(e) {
			e.preventDefault();
			
			try {
				const response = await fetch('/site/create', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded',
						'X-Requested-With': 'XMLHttpRequest'
					},
					body: new URLSearchParams({
						'Produtos[nome]': document.getElementById('itemName').value,
						'Produtos[quantidade]': document.getElementById('itemQuantity').value,
						'Produtos[categoria]': document.getElementById('itemCategory').value,
						'_csrf': document.querySelector('meta[name="csrf-token"]').content
					})
				});

				// Verifica se a resposta é JSON
				const contentType = response.headers.get('content-type');
				if (!contentType || !contentType.includes('application/json')) {
					const text = await response.text();
					throw new Error(`Resposta inválida: ${text}`);
				}

				const data = await response.json();
				
				if (data.success) {
					location.reload();
				} else {
					alert('Erro: ' + JSON.stringify(data.errors));
				}
			} catch (error) {
				console.error('Erro na requisição:', error);
				alert('Erro ao comunicar com o servidor: ' + error.message);
			}
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
			
			// Selecionar a categoria correta no dropdown
			const selectCategoria = document.getElementById('itemCategory');
			if (categoriaId) {
				selectCategoria.value = categoriaId;
			} else {
				selectCategoria.value = ""; // Caso não tenha categoria definida
			}
			
			// Armazenar o ID do item sendo editado
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