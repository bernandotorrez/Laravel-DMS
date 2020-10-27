<?php

namespace App\Http\Livewire\Page\Login;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LoginIndex extends Component
{

    protected $pageTitle = 'Login Into DMS';
    public $email, $password;

    protected $rules = [
        'email'     =>  'required|email',
        'password'  =>  'required|min:6'
    ];

    protected $messages = [
        'email.email'   => 'Please enter with Valid Email Address',
        'password.min'  => 'Please fill password minimal 6 Characters'
    ];

    public function render()
    {
        $data = array('title' => $this->pageTitle);
        return view('livewire.page.login.login-index')->layout('login_layouts.app', $data);
    }

    public function mount()
    {
        if(Auth::check()) {
            return redirect()->route('home.index');
        }

        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset(['email', 'password']);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function login()
    {
        $this->validate();

        if(Auth::attempt(['email' => $this->email, 'password' => $this->password, 'status' => '1'])) {
            return redirect()->route('home.index');
        } else {
            session()->flash('login_failed', 'Email or Password is Wrong!');
        }
    }
}
