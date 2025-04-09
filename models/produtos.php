<?php

namespace app\models;

use yii\db\ActiveRecord;

class Produtos extends ActiveRecord
{
    /**
     * @return string nome da tabela no banco de dados
     */
    public static function tableName()
    {
        return 'produtos';
    }

    /**
     * @return array regras de validação
     */
    public function rules()
    {
        return [
            [['nome', 'quantidade', 'categoria'], 'required'],
            [['quantidade'], 'integer', 'min' => 0],
            [['categoria'], 'integer'],
            [['nome'], 'string', 'max' => 255],
            [['ativo'], 'boolean'],
            // Remove 'id' das regras pois é auto-incremento
        ];
    }

    /**
     * @return array rótulos para os atributos
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ativo' => 'Ativo',
            'nome' => 'Nome',
            'quantidade' => 'Quantidade',
            'categoria' => 'Categoria',
        ];
    }

    /**
     * Relação com a tabela categorias
     */
    public function getCategoria()
    {
        return $this->hasOne(Categorias::className(), ['id' => 'categoria']);
    }
}