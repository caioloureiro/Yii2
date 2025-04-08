<?php

namespace app\models;
use yii\db\ActiveRecord;

class Produtos extends ActiveRecord{
	
	private $id;
	private $ativo;
	private $nome;
	private $quantidade;
	private $categoria;
	
	public function rules(){
		return[
			[
				[
					'id',
					'ativo',
					'nome',
					'quantidade',
					'categoria'
				],
				'required'
			]
		];
	}
	
}

?>