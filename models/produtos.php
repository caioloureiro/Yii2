<?php

namespace app\models;
use yii\db\ActiveRecord;

class Produtos extends ActiveRecord
{
    public static function tableName()
    {
        return 'produtos';
    }

    public function rules()
    {
        return [
            [['nome', 'quantidade', 'categoria'], 'required'],
            [['quantidade', 'categoria'], 'integer'],
            [['nome'], 'string', 'max' => 255],
            [['ativo'], 'default', 'value' => 1],
        ];
    }
}

?>