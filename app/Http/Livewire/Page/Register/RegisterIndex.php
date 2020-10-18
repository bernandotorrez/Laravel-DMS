<?php

namespace App\Http\Livewire\Page\Register;

use Livewire\Component;

class RegisterIndex extends Component
{
    protected $pageTitle = 'Register DMS';

    public function render()
    {   
        $data = array('title' => $this->pageTitle);
        return view('livewire.page.register.register-index')->layout('login_layouts.app', $data);
    }
}
