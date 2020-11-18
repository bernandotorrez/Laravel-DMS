<div class="row layout-top-spacing">

    <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
        <div class="widget-content-area br-4">
            <div class="widget-one">

                <!-- @if($delete_status == 'success')
                <div class="alert alert-success"> Delete Success! </div>
                @elseif($delete_status == 'fail')
                <div class="alert alert-danger"> Delete Failed! </div>
                @endif -->

                @if($insert_status == 'success')
                <div class="alert alert-success"> Insert Success! </div>
                @elseif($insert_status == 'fail')
                <div class="alert alert-danger"> Insert Failed! </div>
                @endif

                @if($update_status == 'success')
                <div class="alert alert-success"> Update Success! </div>
                @elseif($update_status == 'fail')
                <div class="alert alert-danger"> Update Failed! </div>
                @endif

                <button type="button" 
                class="btn btn-primary mr-4" 
                id="addButton"
                wire:click.prevent="addForm"> Add
                </button>

                <button type="button" 
                class="btn btn-success mr-4" 
                id="editButton"
                wire:click.prevent="editForm"
                @if(count($checked) != 1) disabled @endif
                > Edit
                </button>

                <button type="button" 
                class="btn btn-danger" 
                id="deleteButton"
                wire:click.prevent="$emit('triggerDelete')"
                @if(count($checked) <= 0 ) disabled @endif
                > Delete
                </button>

                <!-- @dump($checked) -->

                <!-- Modal -->
                <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{ $pageTitle }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    @if($insertDuplicate == true)
                                    <div class="alert alert-warning"> <strong> {{ $bind['email'] }} </strong> already Exist </div>
                                    @endif

                                    <div class="row mb-4">
                                        <div class="col">
                                            <label for="model_name">Name</label>
                                            <input type="text" class="form-control" id="name" maxlength="100"
                                                placeholder="Name" wire:model.debounce.500ms="bind.name">
                                            @error('bind.name') <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col">
                                            <label for="model_name">Email</label>
                                            <input type="text" class="form-control" id="email" maxlength="150" autocomplete="off"
                                                placeholder="Example : tes@gmail.com" wire:model.debounce.500ms="bind.email">
                                            @error('bind.email') <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col">
                                            <label for="model_name">Password</label>
                                            <input type="password" class="form-control" id="password" maxlength="100"
                                                autocomplete="off" placeholder="Password" wire:model.debounce.500ms="bind.password">
                                            @error('bind.password') <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col">
                                            <label for="model_name">No HP</label>
                                            <input type="text" class="form-control" id="no_hp" maxlength="15"
                                                placeholder="No HP" wire:model.debounce.500ms="bind.no_hp">
                                            @error('bind.no_hp') <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col">
                                            <label for="model_name">Level</label>
                                            <select class="form-control" id="level" maxlength="50"
                                                placeholder="Level" wire:model.lazy="bind.level">
                                                <option value="">- Choose Level -</option>
                                                <option value="Admin">Admin</option>
                                                <option value="User">User</option>
                                            </select>
                                            @error('bind.level') <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col">
                                            <label for="model_name">User Group</label>
                                            <select class="form-control" id="id_user_group" maxlength="50"
                                                wire:model.lazy="bind.id_user_group">
                                                <option value="">- Choose Level -</option>
                                                @foreach($dataUserGroup as $data)
                                                    <option value="{{ $data->id_user_group }}">{{ $data->user_group }}</option>
                                                @endforeach
                                            </select>
                                            @error('bind.id_user_group') <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i>
                                    Discard</button>
                                @if($is_edit)
                                <button type="button" class="btn btn-success" id="update"
                                    wire:click.prevent="editProcess" wire:offline.attr="disabled"> Update </button>
                                @else
                                <button type="button" class="btn btn-primary" id="submit"
                                    wire:click.prevent="addProcess" 
                                    wire:offline.attr="disabled"
                                    @error('bind.*') disabled @enderror> Submit </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal -->

                <p></p>

                <div class="table-responsive mt-4">
                    <div class="d-flex">
                        <div class="p-2 align-content-center align-items-center" class="text-center">Per Page : </div>
                        <div class="p-2">
                            <select class="form-control" wire:model.lazy="perPageSelected">
                                @foreach($perPage as $page)
                                <option value="{{ $page }}">{{ $page }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="ml-auto p-2 text-center alert alert-info" wire:loading
                            wire:target="car_model_paginate">Loading ... </div>
                        <div class="ml-auto p-2">
                            <input type="text" class="form-control" wire:model="search" placeholder="Search...">
                        </div>
                    </div>
                    <table class="table table-striped table-bordered" id="users-table">
                        <thead>
                            <th width="5%">
                                <input type="checkbox"
                                class="new-control-input"
                                wire:model="allChecked"
                                wire:click="allChecked">
                            </th>
                            <th width="10%">No</th>
                            <th wire:click="sortBy('name')">
                                <a href="javascript:void(0);">Name
                                    @include('livewire.datatable-icon', ['field' => 'name'])
                                </a>
                            </th>
                            <th wire:click="sortBy('email')">
                                <a href="javascript:void(0);">Email
                                    @include('livewire.datatable-icon', ['field' => 'email'])
                                </a>
                            </th>
                            <th wire:click="sortBy('no_hp')">
                                <a href="javascript:void(0);">No HP
                                    @include('livewire.datatable-icon', ['field' => 'no_hp'])
                                </a>
                            </th>
                            <th wire:click="sortBy('level')">
                                <a href="javascript:void(0);">Level
                                    @include('livewire.datatable-icon', ['field' => 'level'])
                                </a>
                            </th>
                            <th wire:click="sortBy('user_group')">
                                <a href="javascript:void(0);">User Group
                                    @include('livewire.datatable-icon', ['field' => 'user_group'])
                                </a>
                            </th>
                        </thead>
                        <tbody>
                            @foreach($dataUser as $data)
                            <tr>
                                <td>
                                    <input type="checkbox" 
                                    value="{{ $data->id }}" 
                                    class="new-control-input"
                                    wire:model="checked">
                                </td>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->email }}</td>
                                <td>{{ $data->no_hp }}</td>
                                <td>{{ $data->level }}</td>
                                <td>{{ $data->user_group }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-center">
                        {{ $dataUser->links('livewire.pagination-links') }}
                    </div>

                </div>

            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
    Livewire.on('triggerDelete', function () {

        Swal.fire({
            icon: 'question',
            title: 'Are You Sure?',
            text: 'this Record will be deleted!',
            type: "warning",
            showCancelButton: true,
            confirmButtonText: 'Delete!'
        }).then((result) => {
            if (result.isConfirmed) {
                // call function deleteProcess() in Livewire Controller
                @this.deleteProcess()
            }
        });
    });
</script>
@endpush
