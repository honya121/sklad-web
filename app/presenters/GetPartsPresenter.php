<?php

namespace App\Presenters;

use Nette;
use App\Model;
use Mesour;

class GetPartsPresenter extends BasePresenter
{
    public function renderSimple()
    {
        if(!$this->user->isLoggedIn())
        {
            $this->redirect('Login:default');
        }
        $this->template->sockets = $this->socketFacade->getOccupiedSocketsArray();
    }
    public function renderExtended()
    {

    }

    public function handlegetParts(array $data)
    {
          foreach($data as $key => $val)
          {
            $this->queueFacade->request($key, $this->user->id, $val);
          }
          $this->terminate();
    }
    public function createComponentSimpleGetPartsGrid($name)
    {
        $data = $this->partFacade->getSimpleGetPartsTable();
        $gridControl = new Model\Mesour\EmptyGridControl($this, $name);
        $grid = $gridControl->grid;
        $source = new Mesour\DataGrid\Sources\ArrayGridSource($data);
        $primaryKey = 'socketId';

        $grid->setSource($source);
        $grid->setPrimaryKey($primaryKey);

        $grid->addNumber('socketPosition', 'Pozice');
        $grid->addText('partName', 'Název součástky');
        $grid->addText('partType', 'Typ');
        $grid->addText('available', 'Množství');

        $grid->setDefaultOrder('socketPosition');
        $filter = $grid->enableFilter(FALSE);

        $container = $grid->addContainer('Vybrat');
        $emptyInput = new Model\Mesour\InputFieldColumn('emptyInput');
        $container->addComponent($emptyInput, 'emptyInput');
        return $gridControl->create();
    }
}
