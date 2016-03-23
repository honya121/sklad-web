<?php

namespace App\Presenters;

use Nette;
use App\Model;
use Mesour;


class HistoryPresenter extends BasePresenter
{

	public function renderList()
    {
        if(!$this->user->isLoggedIn())
        {
            $this->redirect('Login:default');
        }
    }

    public function renderStatistics()
    {
        if(!$this->user->isLoggedIn())
        {
            $this->redirect('Login:default');
        }
    }

    public function createComponentHistoryGrid($name)
    {
        $gridControl = new Model\Mesour\EmptyGridControl($this, $name);
        $grid = $gridControl->grid;

        $source = new Mesour\DataGrid\Sources\ArrayGridSource($this->historyFacade->getHistoryTable());

        $primaryKey = 'id';
        $grid->setPrimaryKey($primaryKey);
        $grid->setSource($source);
        $grid->setDefaultOrder('id', 'DESC');

        $grid->addText('type', ' ');
        $grid->addNumber('state', 'Stav');
        $grid->addText('user', 'Uživatel');
        $grid->addText('part', 'Součástka');
        $grid->addNumber('position', 'Pozice');
        $grid->addNumber('level', 'Patro');
        $grid->addNumber('amount', 'Počet');
        $grid->addDate('created', 'Čas')
            ->setFormat('j.n.Y H:m:s');

        return $gridControl->create();
    }
}
