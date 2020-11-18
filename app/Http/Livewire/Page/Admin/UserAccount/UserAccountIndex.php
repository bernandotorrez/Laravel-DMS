<?php

namespace App\Http\Livewire\Page\Admin\UserAccount;

use App\Repository\Eloquent\UserRepository;
use App\Traits\WithSorting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Cache as CacheModel;
use App\Repository\Eloquent\AdminUserGroupRepository;
use Illuminate\Support\Facades\Hash;

class UserAccountIndex extends Component
{

    use WithPagination;
    use WithSorting;

    /**
     * Pagination Attributes
     */
    protected $paginationTheme = 'bootstrap';
    public array $perPage = [10, 15, 20, 25, 50];
    public int $perPageSelected = 10;
    public string $search = '';

    /**
     * Page Attributes
     */
    public string $pageTitle = "Admin User Account";
    public bool $is_edit = false, $allChecked = false, $insertDuplicate = false;
    public string $insert_status = '', $update_status = '', $delete_status = '', $viewName = 'view_user';
    public array $checked = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1]
    ];
    
    public $bind = [
        'id' => '',
        'name' => '',
        'email' => '',
        'password' => '',
        'no_hp' => '',
        'id_user_group' => '',
        'level' => '',
    ];

    /**
     * Validation Attributes
     */
    protected $rules = [
        'bind.name' => 'required|string|min:3|max:100',
        'bind.email' => 'required|email|min:3|max:150',
        'bind.password' => 'required|min:6|max:100',
        'bind.no_hp' => 'required|regex:/[0-9]/|min:10|max:15',
        'bind.id_user_group' => 'required',
        'bind.level' => 'required'
    ];

    protected $messages = [
        'bind.name.required' => 'The Name Cant be Empty!',
        'bind.name.min' => 'The Name must be at least 3 Characters',
        'bind.name.max' => 'The Name maximal 100 Characters',

        'bind.email.required' => 'The Email Cant be Empty!',
        'bind.email.min' => 'The Email must be at least 3 Characters',
        'bind.email.max' => 'The Email maximal 100 Characters',
        'bind.email.email' => 'Your Email not valid',

        'bind.password.required' => 'The Password Cant be Empty!',
        'bind.password.min' => 'The Password must be at least 6 Characters',
        'bind.password.max' => 'The Password maximal 100 Characters',

        'bind.no_hp.required' => 'The No HP Cant be Empty!',
        'bind.no_hp.min' => 'The No HP must be at least 10 Characters',
        'bind.no_hp.max' => 'The No HP maximal 15 Characters',
        'bind.no_hp.regex' => 'The No HP Only Accept Number',

        'bind.password.max' => 'The Password maximal 100 Characters',

        'bind.id_user_group.required' => 'The User Group Cant be Empty',
        
        'bind.level.required' => 'The User Group Cant be Empty',
    ];

    public function mount()
    {
        $this->sortBy = 'name';
        $this->fill(request()->only('search', 'page'));
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
        $this->insertDuplicate = false;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetForm()
    {
        $this->reset(['bind']);
    }

    public function render(
        UserRepository $userRepository,
        AdminUserGroupRepository $adminUserGroupRepository
    )
    {
        $cache_name = 'admin-user-account-index-page-'.$this->page.'-pageselected-'.$this->perPageSelected.'-search-'.$this->search;
        $cache_name .= '-sortby-'.$this->sortBy.'-sortdirection-'.$this->sortDirection.'-user-'.Auth::id();

        $dataUser = Cache::remember($cache_name, 60, function () use ($userRepository, $cache_name) {
            CacheModel::firstOrCreate(['cache_name' => $cache_name, 'id_user' => Auth::id()]);
            return $userRepository->allUserEcxeptMePagination(
                $this->search,
                $this->sortBy,
                $this->sortDirection,
                $this->perPageSelected
            );
        });

        return view('livewire.page.admin.user-account.user-account-index', [
            'dataUser' => $dataUser,
            'dataUserGroup' => $adminUserGroupRepository->all()
        ])->layout('layouts.app', ['title' => $this->pageTitle]);
    }

    public function allChecked(UserRepository $userRepository)
    {
        $datas = $userRepository->allUserEcxeptMeChecked(
            $this->search,
            $this->sortBy,
            $this->sortDirection,
            $this->perPageSelected
        );

        $id = $userRepository->getPrimaryKey();
      
        // Dari Unchecked ke Checked
        if($this->allChecked == true) {
            foreach($datas as $data) {
                if(!in_array($data->$id, $this->checked)) {
                    array_push($this->checked, (string) $data->$id);
                }
            }
        } else {
            // Checked ke Unchecked
            $this->checked = [];
        }

    }

    public function addForm()
    {
        $this->insert_status = '';
        $this->update_status = '';
        $this->is_edit = false;
        $this->resetForm();

        $this->emit('openModal');
    }

    public function addProcess(UserRepository $userRepository)
    {
        $this->validate();

        $data = array(
            'name' => ucwords($this->bind['name']),
            'email' => $this->bind['email'],
            'password' => Hash::make($this->bind['password']),
            'no_hp' => $this->bind['no_hp'],
            'id_user_group' => $this->bind['id_user_group'],
            'level' => $this->bind['level'],
        );

        $count = $userRepository->findDuplicate(array('email' => $data['email']));
        
        if($count >= 1) {
            $this->insertDuplicate = true;
        } else {
            $insert = $userRepository->create($data);

            if($insert) {
                $this->insert_status = 'success';
                $this->resetForm();
                $this->emit('closeModal');

                $this->deleteCache();
            } else {
                $this->insert_status = 'fail';
            }
        }
    }

    public function editForm(UserRepository $userRepository)
    {
        $this->insert_status = '';
        $this->update_status = '';
        $this->is_edit = true;
       
        $data = $userRepository->getByID($this->checked[0]);
        $id = $userRepository->getPrimaryKey();

        $this->bind['id'] = $data->$id;
        $this->bind['name'] = $data->name;
        $this->bind['email'] = $data->email;
        $this->bind['password'] = '';
        $this->bind['no_hp'] = $data->no_hp;
        $this->bind['id_user_group'] = $data->id_user_group;
        $this->bind['level'] = $data->level;

        $this->emit('openModal');
    }

    public function editProcess(UserRepository $userRepository)
    {
        $this->validate();

        $data = array(
            'id' => $this->bind['id'],
            'name' => ucwords($this->bind['name']),
            'email' => $this->bind['email'],
            'password' => Hash::make($this->bind['password']),
            'no_hp' => $this->bind['no_hp'],
            'id_user_group' => $this->bind['id_user_group'],
            'level' => $this->bind['level'],
        );

        $count = $userRepository->findDuplicateEdit(array('email' => $data['email']), $this->bind['id']);
        
        if($count >= 1) {
            $this->insertDuplicate = true;
        } else {
            $update = $userRepository->update($this->bind['id'], $data);

            if($update) {
                $this->update_status = 'success';
                $this->is_edit = false;
                $this->resetForm();
                $this->emit('closeModal');

                $this->deleteCache();
            } else {
                $this->update_status = 'fail';
            }
        }  
    }

    public function deleteProcess(UserRepository $userRepository)
    {
        $update = $userRepository->update($this->checked[0], array('status' => '0'));
        $delete = $userRepository->massDelete($this->checked);

        if($delete) {
            $this->delete_status = 'success';
            $this->resetForm();

            $this->deleteCache();
        } else {
            $this->delete_status = 'fail';
        }

        $this->emit('deleted', $this->delete_status);
    }

    private function deleteCache()
    {
        $dataCache = CacheModel::where('id_user', Auth::id())->get();

        foreach($dataCache as $cache)
        {
            Cache::forget($cache->cache_name);
        }

        CacheModel::where('id_user', Auth::id())->delete();
    }
}
