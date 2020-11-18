<?php

namespace App\Http\Livewire\Page\Admin\UserGroup;

use App\Models\UserGroup;
use App\Repository\Eloquent\AdminUserGroupRepository;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\WithSorting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\Cache as CacheModel;

class UserGroupIndex extends Component
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
    public string $pageTitle = "Admin User Group";
    public bool $is_edit = false, $allChecked = false, $insertDuplicate = false;
    public string $insert_status = '', $update_status = '', $delete_status = '';
    public array $checked = [];
    
    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1]
    ];
    
    public $bind = [
        'id_user_group' => '',
        'user_group' => ''
    ];

    /**
     * Validation Attributes
     */
    protected $rules = [
        'bind.user_group' => 'required|min:3|max:50'
    ];

    protected $messages = [
        'bind.user_group.required' => 'The User Group Cant be Empty!',
        'bind.user_group.min' => 'The User Group must be at least 3 Characters',
        'bind.user_group.max' => 'The User Group Cant be maximal 50 Characters',
    ];

    public function mount()
    {
        $this->sortBy = 'user_group';
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

    public function render(AdminUserGroupRepository $adminUserGroupRepository)
    {
        $cache_name = 'admin-user-group-index-page-'.$this->page.'-pageselected-'.$this->perPageSelected.'-search-'.$this->search;
        $cache_name .= '-sortby-'.$this->sortBy.'-sortdirection-'.$this->sortDirection.'-user-'.Auth::id();

        $dataUserGroup = Cache::remember($cache_name, 60, function () use ($adminUserGroupRepository, $cache_name) {
            CacheModel::firstOrCreate(['cache_name' => $cache_name, 'id_user' => Auth::id()]);
            return $adminUserGroupRepository->pagination(
                $this->search,
                $this->sortBy,
                $this->sortDirection,
                $this->perPageSelected
            );
        });
        
        return view('livewire.page.admin.user-group.user-group-index', [
            'dataUserGroup' => $dataUserGroup
        ])->layout('layouts.app', ['title' => $this->pageTitle]);
    }

    public function allChecked(AdminUserGroupRepository $adminUserGroupRepository)
    {
        $datas = $adminUserGroupRepository->checked(
            $this->search,
            $this->sortBy,
            $this->sortDirection,
            $this->perPageSelected
        );

        $id = $adminUserGroupRepository->getPrimaryKey();
      
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

    public function addProcess(AdminUserGroupRepository $adminUserGroupRepository)
    {
        $this->validate();

        $data = array(
            'user_group' => $this->bind['user_group']
        );

        $count = $adminUserGroupRepository->findDuplicate($data);
        
        if($count >= 1) {
            $this->insertDuplicate = true;
        } else {
            $insert = $adminUserGroupRepository->create($data);

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

    public function editForm(AdminUserGroupRepository $adminUserGroupRepository)
    {
        $this->insert_status = '';
        $this->update_status = '';
        $this->is_edit = true;
       
        $data = $adminUserGroupRepository->getByID($this->checked[0]);
        $this->bind['id_user_group'] = $data->id_user_group;
        $this->bind['user_group'] = $data->user_group;

        $this->emit('openModal');
    }

    public function editProcess(AdminUserGroupRepository $adminUserGroupRepository)
    {
        $this->validate();

        $data = array(
            'id_user_group' => $this->bind['id_user_group'],
            'user_group' => $this->bind['user_group']
        );

        $count = $adminUserGroupRepository->findDuplicateEdit($data, $this->bind['id_user_group']);
        
        if($count >= 1) {
            $this->insertDuplicate = true;
        } else {
            $update = $adminUserGroupRepository->update($this->bind['id_user_group'], $data);

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

    public function deleteProcess(AdminUserGroupRepository $adminUserGroupRepository)
    {
        $delete = $adminUserGroupRepository->massDelete($this->checked);

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
