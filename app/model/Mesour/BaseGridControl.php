<?php

namespace App\Model\Mesour;

use Mesour;

abstract class BaseGridControl extends Mesour\Bridges\Nette\DataGridControl
{

    public function attached($presenter)
    {
        parent::attached($presenter);

        $grid = $this->getGrid();

    }

    public function setSource(IGridSource $source)
    {
        $this->getGrid()->setSource($source);
    }

}
