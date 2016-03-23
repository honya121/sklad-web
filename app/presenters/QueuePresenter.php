<?php

namespace App\Presenters;

use Nette;
use App\Model;
use Mesour;


class QueuePresenter extends BasePresenter
{

	public function renderList()
    {
        if(!$this->user->isLoggedIn())
        {
            $this->redirect('Login:default');
        }
    }

    public function actionDelete($queueEntryId)
    {
        if(!$this->user->isLoggedIn())
        {
            $this->redirect('Login:default');
        }
        $this->queueFacade->deleteQueueEntry($queueEntryId);
        $this->flashMessage('Záznam byl z fronty úspěšně vymazán');
        $this->redirect('Queue:list');
    }

    public function createComponentQueueListGrid($name)
    {
        $gridControl = new Model\Mesour\EmptyGridControl($this, $name);
        $source = new Mesour\DataGrid\Sources\ArrayGridSource($this->queueFacade->getQueueTable());
        $grid = $gridControl->grid;

        $primaryKey = 'id';
        $grid->setPrimaryKey($primaryKey);
        $grid->setSource($source);

        $grid->addNumber('state', 'Stav');
        $grid->addText('user_username', 'Uživatel');
        $grid->addText('part_name', 'Součástka');
        $grid->addNumber('socket_position', 'Pozice');
        $grid->addNumber('socket_level', 'Patro');
        $grid->addNumber('amount', 'Počet');
        $grid->addDate('created', 'Vytvořeno')
            ->setFormat('j.n.Y H:m:s');

        $link = new Mesour\Bridges\Nette\Link($this);
        $actions = $grid->addContainer('actions', ' ');

        $actions->addButton('delete')
            ->setType('danger')
            ->setText('Vymazat')
            ->setAttribute('href', $link->create('Queue:delete', array('queueEntryId' => '{id}')));

        return $gridControl->create();
    }
}
