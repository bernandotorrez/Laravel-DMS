<?php

namespace App\Http\Livewire\Page\Register;

use Livewire\Component;
use App\Repository\Eloquent\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterIndex extends Component
{
    protected $pageTitle = 'Register DMS';
    public $name, $email, $no_hp, $password;

    protected $rules = [
        'name'      =>  'required|min:10',
        'email'     =>  'required|email',  
        'no_hp'     =>  'required|numeric|min:10',
        'password'  =>  'required|min:6'
    ];

    protected $messages = [
        'name.min'          =>  'Please enter your Name minimal 10 Characters',
        'email.email'       =>  'Email is not Valid',
        'no_hp.numeric'     =>  'Please enter with Number Only',
        'no_hp.min'         =>  'Please enter your Number minimal 10 Characters',
        'no_hp.max'         =>  'Please enter your Number maximal 15 Characters',
        'password.min'      =>  'Password minimal 6 Characters',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {   
        $data = array('title' => $this->pageTitle);
        return view('livewire.page.register.register-index')->layout('layouts.app', $data);
    }

    public function mount() {
        if(Auth::check()) {
            return redirect()->route('home');
        }
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset(['name', 'email', 'no_hp', 'password']);
    }

    public function register(UserRepository $userRepository)
    {
        $this->validate();

        $checkEmail = $userRepository->findDuplicate(['email' => $this->email]);

        if($checkEmail == 1) {
            session()->flash('register_failed', 'Email is Already Exist!');
        } else {
            $userRepository->create([
                'name' => $this->name,
                'email' => $this->email,
                'no_hp' => $this->no_hp,
                'password' => Hash::make($this->password)
            ]);
    
            session()->flash('register_success', 'Register Success');

            return redirect()->route('login.index');
        }
    }
}
