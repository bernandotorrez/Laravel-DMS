<?php

namespace App\Http\Livewire\Page\About;

use Livewire\Component;

class AboutIndex extends Component
{

    public $pageTitle = "About";

    public function render()
    {
        return view('livewire.page.about.about-index', [
            'title' => $this->pageTitle
        ]);
    }
}
