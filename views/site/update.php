<?php

/** @var yii\web\View $this */
$this->title = 'Create | API Yii2 para Angular';

use yii\helpers\html;
use yii\widgets\ActiveForm;

?>

<style><?php require '../web/css/inputs.css'; ?></style>

<div class="inputs-container">
	<h1>CRUD Yii2</h1>
	
	<h2>Editar Item</h2>
	
	<?php $form = ActiveForm::begin(['id' => 'create-form']); ?>
		<div class="form-group">
			<?= $form->field($produto, 'nome')->textInput(['placeholder' => 'Digite o nome do item']) ?>
		</div>
		
		<div class="form-group">
			<?= $form->field($produto, 'quantidade')->textInput(['type' => 'number', 'placeholder' => 'Digite a quantidade']) ?>
		</div>
		
		<div class="form-group">
			<?= $form->field($produto, 'categoria')->dropDownList(
				\yii\helpers\ArrayHelper::map($categorias, 'id', 'name'),
				['prompt' => 'Selecione uma categoria']
			) ?>
		</div>
		
		<div class="button-group">
			<?= Html::submitButton( 'Gravar', ['class' => 'btn-save'] ) ?>
			<a href="./"><button type="button" class="btn-cancel">Cancelar</button></a>
		</div>
	<?php $form = ActiveForm::end() ?>
</div>