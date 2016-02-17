<?php

namespace App\Presenters;

use Nette;
use App\Model;
use Mesour\DataGrid\Grid,
    Mesour\DataGrid\Components\Link,
    Mesour\DataGrid\ArrayDataSource;


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
        $source = new ArrayDataSource($this->historyFacade->getHistoryTable());
        $grid = new Grid($this, $name);
        
        $primaryKey = 'id';
        $grid->setPrimaryKey($primaryKey);
        $grid->setDataSource($source);
        $grid->setDefaultOrder('id', 'DESC');
        
        $grid->addText('type', '');
        $grid->addNumber('state', 'Stav');
        $grid->addText('user', 'Uživatel');
        $grid->addText('part', 'Součástka');
        $grid->addNumber('position', 'Pozice');
        $grid->addNumber('level', 'Patro');
        $grid->addNumber('amount', 'Počet');
        $grid->addDate('created', 'Čas')
            ->setFormat('j.n.Y H:m:s');
        
        return $grid;
    }
}
