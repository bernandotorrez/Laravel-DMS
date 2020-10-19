<?php

namespace App\Http\Livewire\Page\Login;
use App\Repository\Eloquent\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

    public function login(UserRepository $userRepository)
    {
        $this->validate();
        
        $user = $userRepository->getEmail($this->email);

        if(count($user) == 1 && Hash::check($this->password, $user[0]->password)) {
            session()->flash('login_failed', 'Success!');
        } else {
            session()->flash('login_failed', 'Email or Password is Wrong!');
        }
    }
}
