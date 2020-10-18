<?php

namespace App\Http\Livewire\Page\Login;

use Livewire\Component;

class LoginIndex extends Component
{

    protected $pageTitle = 'Login Into DMS';

    public function render()
    {
        $data = array('title' => $this->pageTitle);
        return view('livewire.page.login.login-index')->layout('login_layouts.app', $data);
    }
}
