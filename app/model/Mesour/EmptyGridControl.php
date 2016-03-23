<?php

namespace App\Model\Mesour;

class EmptyGridControl extends BaseGridControl
{
    public $grid;

    public function __construct($presenter, $name)
    {
        parent::__construct($presenter, $name);
        $this->grid = $this->getGrid();
    }

    public function attached($presenter)
    {
        parent::attached($presenter);
    }

}
