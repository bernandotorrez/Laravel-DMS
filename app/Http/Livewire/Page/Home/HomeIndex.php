<?php

namespace App\Http\Livewire\Page\Home;

use Livewire\Component;

class HomeIndex extends Component
{
    protected $pageTitle = "Home";
    
    public function render()
    {
        return view('livewire.page.home.home-index')->layout('layouts.app', array('title' => $this->pageTitle));
    }
}
