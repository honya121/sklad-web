<?php

namespace App\Model\Mesour;

use Mesour\DataGrid\Column\BaseColumn;
use Mesour;

class InputFieldColumn extends BaseColumn
{
    public function getHeaderAttributes()
    {
        return [
            'class' => 'grid-column-' . $this->getName(),
        ];
    }
    public function getBodyAttributes($data, $need = true, $rawData = [])
	{
        $attributes = parent::getBodyAttributes($data);
        return $attributes;
	}
    public function getBodyContent($data, $rawData)
    {
        $input = Mesour\Components\Utils\Html::el('input');
        $input->type('number');
        $input->id('getPartsInput-'.$data['socketId']);
        $input->class('getPartsInput form-control');
        $input->onChange('getPartsInputChange($(this))');
        $input->onLoad('getPartsInputInitialize($(this))');
        $input->min(0);
        $input->max($data['available']);
        $input->size(10);
            return $input;
    }
}
