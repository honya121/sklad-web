<?php

namespace App\Presenters;

use Nette;
use App\Model;


class LoginPresenter extends BasePresenter
{
    public function actionLogout()
    {
        if($this->getUser()->isLoggedIn())
		{
			$this->getUser()->logout();
			$this->flashMessage("Úspěšně jste byli odhlášeni");
		}
		$this->redirect("Login:default");
    }
	public function renderDefault()
	{
        if($this->user->isLoggedIn())
        {
            $this->flashMessage('Již jste přihlášeni');
            $this->redirect('Homepage:default');
        }
	}
    
    public function createComponentLoginForm()
    {
        $form = new Nette\Application\UI\Form;
        $form->addText("username", "Jméno")
			->addRule(Nette\Application\UI\Form::FILLED, "Jméno musí být vyplněno");
		$form->addPassword("password", "Heslo")
			->addRule(Nette\Application\UI\	Form::FILLED, "Heslo musí být vyplněno");
		$form->addCheckBox("remember", "Zůstat přihlášen");
		$form->addSubmit("submit", "Přihlásit se");
		$form->onSuccess[] = $this->loginFormSucceeded;
		return $form;
    }
    public function loginFormSucceeded($form)
	{
		$values = $form->getValues();
		if ($values->remember) {
			$this->getUser()->setExpiration('14 days', FALSE);
		} else {
			$this->getUser()->setExpiration('20 minutes', TRUE);
		}
		try
		{
			$this->user->login($values->username, $values->password);
		}
		catch(Nette\Security\AuthenticationException $e)
		{
			$this->flashMessage("Špatné jméno nebo heslo");
			$this->redirect("Login:default");
		}
		$this->redirect("Homepage:default");

	}

}
