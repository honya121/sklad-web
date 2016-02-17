<?php

namespace App\Presenters;

use Nette;
use App\Model;
use Mesour\DataGrid\Grid,
    Mesour\DataGrid\Components\Link,
    Mesour\DataGrid\ArrayDataSource;


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
        $source = new ArrayDataSource($this->queueFacade->getQueueTable());
        $grid = new Grid($this, $name);
        
        $primaryKey = 'id';
        $grid->setPrimaryKey($primaryKey);
        $grid->setDataSource($source);
        
        $grid->addNumber('state', 'Stav');
        $grid->addText('user_username', 'Uživatel');
        $grid->addText('part_name', 'Součástka');
        $grid->addNumber('socket_position', 'Pozice');
        $grid->addNumber('socket_level', 'Patro');
        $grid->addNumber('amount', 'Počet');
        $grid->addDate('created', 'Vytvořeno')
            ->setFormat('j.n.Y H:m:s');
        
        $actions = $grid->addActions('');
        
        $actions->addButton()
            ->setType('btn-danger')
            ->setText('Vymazat')
            ->setAttribute('href', new Link('Queue:delete', array('queueEntryId' => '{'.$primaryKey.'}')));
       
        return $grid;
    }
}
