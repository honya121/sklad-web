<?php

namespace App\Presenters;

use Nette;
use App\Model;
use Mesour\DataGrid\Grid,
    Mesour\DataGrid\Components\Link,
    Mesour\DataGrid\ArrayDataSource;


class UserPresenter extends BasePresenter
{
	public function renderList()
    {
        if(!$this->user->isLoggedIn())
        {
            $this->redirect('Login:default');
        }
    }
    
    public function renderNew()
    {
        if(!$this->user->isLoggedIn())
        {
            $this->redirect('Login:default');
        }
    }
    
    public function renderEdit($userId)
    {if(!$this->user->isLoggedIn())
        {
            $this->redirect('Login:default');
        }
        
    }
    
    public function actionDelete($userId)
    {
        if(!$this->user->isLoggedIn())
        {
            $this->redirect('Login:default');
        }
        $this->userFacade->deleteUser($userId);
        $this->flashMessage('Uživatel byl úspěšně smazán');
        $this->redirect('User:list');
    }
    
    public function renderChangePassword()
    {
        if(!$this->user->isLoggedIn())
        {
            $this->redirect('Login:default');
        }
    }
    
    public function createComponentUserListGrid($name)
    {
        $grid = new Grid($this, $name);
        $source = new ArrayDataSource($this->userFacade->getUsersTable());
        
        $primaryKey = 'id';
        $grid->setPrimaryKey($primaryKey);
        $grid->setDataSource($source);
        
        $grid->addText('username', 'Uživatelské jméno');
        $grid->addText('name', 'Jméno');
        $grid->addText('email', 'Email');
        $grid->addText('role', 'Role');
        $actions = $grid->addActions('');
        $actions->addButton()
            ->setType('btn-primary')
            ->setText('Upravit')
            ->setAttribute('href', new Link('User:edit', array('userId' => '{'.$primaryKey.'}')));
        $actions->addButton()
            ->setType('btn-danger')
            ->setText('Smazat')
            ->setAttribute('href', new Link('User:delete', array('userId' => '{'.$primaryKey.'}')));
            
       return $grid;
    }
    
    public function createComponentNewUserForm()
    {
        $form = new Nette\Application\UI\Form;
        
        $form->addText('username', 'Uživatelské jméno')
            ->addRule(Nette\Application\UI\Form::FILLED, 'Uživatelské jméno musí být vyplněno');
        $form->addText('name', 'Jméno')
            ->addRule(Nette\Application\UI\Form::FILLED, 'Jméno musí být vyplněno');
        $form->addText('password', 'Heslo')
            ->addRule(Nette\Application\UI\Form::FILLED, 'Heslo musí být vyplněno');
        $form->addText('email', 'Email')
            ->addRule(Nette\Application\UI\Form::FILLED, 'Email musí být vyplněn');
        $form->addSelect('role', 'Role', $this->userFacade->getRolesArray());
        $form->addSubmit('submit', 'Vytvořit');
        
        $form->onSuccess[] = $this->newUserFormSucceeded;
        $form->addProtection();
        
        return $form;
    }
    public function newUserFormSucceeded($form)
    {
        $values = $form->getValues();
        $this->userFacade->addUser($values['username'],
                                   $values['password'],
                                   $values['role'],
                                   $values['name'],
                                   $values['email']);
        $this->flashMessage('Uživatel byl úspěšně vytvořen');
        $this->redirect('User:list');
    }
    
    public function createComponentEditUserForm()
    {
        $userId = $this->getParameter('userId');
        $user = $this->userFacade->get($userId);
        $form = new Nette\Application\UI\Form;
        
        $form->addText('username', 'Uživatelské jméno')
            ->addRule(Nette\Application\UI\Form::FILLED, 'Uživatelské jméno musí být vyplněno')
            ->setDefaultValue($user->username);
        $form->addText('name', 'Jméno')
            ->addRule(Nette\Application\UI\Form::FILLED, 'Jméno musí být vyplněno')
            ->setDefaultValue($user->name);
        $form->addText('password', 'Heslo');
        $form->addText('email', 'Email')
            ->addRule(Nette\Application\UI\Form::FILLED, 'Email musí být vyplněn')
            ->setDefaultValue($user->email);
        $form->addSelect('role', 'Role', $this->userFacade->getRolesArray())
            ->setDefaultValue($user->role);
        $form->addSubmit('submit', 'Upravit');
        
        $form->onSuccess[] = $this->editUserFormSucceeded;
        $form->addProtection();
        
        return $form;
    }
    
    public function editUserFormSucceeded($form)
    {
        $userId = $this->getParameter('userId');
        $values = $form->getValues();
        $this->userFacade->updateUser($userId, $values);
        $this->flashMessage('Uživatel byl úspěšně změněn');
        $this->redirect('User:list');
    }
    
    public function createComponentChangePasswordForm()
    {
        $form = new Nette\Application\UI\Form;
        
        $form->addPassword('oldPassword', 'Staré heslo')
            ->addRule(Nette\Application\UI\Form::FILLED, 'Staré heslo musí být vyplněno');
        $form->addPassword('newPassword1', 'Nové heslo')
            ->addRule(Nette\Application\UI\Form::FILLED, 'Nové heslo musí být vyplněno');
        $form->addPassword('newPassword2', 'Nové heslo podruhé')
            ->addRule(Nette\Application\UI\Form::FILLED, 'Nové heslo musí být vyplněno');
        $form->addSubmit('submit', 'Změnit heslo');
        
        $form->onSuccess[] = $this->changePasswordFormSucceeded;
        $form->addProtection();
        return $form;
    }
    public function changePasswordFormSucceeded($form)
    {
        $values = $form->getValues();
        $userId = $this->user->id;
        if($values['newPassword1'] != $values['newPassword2'])
        {
            $this->flashMessage('Hesla se neshodují');
            $this->redirect('User:changePassword');
        }
        if($this->userFacade->changePassword($userId, $values['oldPassword'], $values['newPassword1']))
        {
            $this->flashMessage('Heslo bylo úspěšně změněno');
            $this->redirect('Homepage:default');
        }
        else
        {
            $this->flashMessage('Chyba');
            $this->redirect('User:changePassword');   
        }
        
    }
}
