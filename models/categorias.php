<?php

namespace app\models;
use yii\db\ActiveRecord;

class Categorias extends ActiveRecord{
	
	private $id;
	private $ativo;
	private $name;
	
	public function rules(){
		return[
			[
				[
					'id',
					'ativo',
					'name'
				],
				'required'
			]
		];
	}
	
}

?>