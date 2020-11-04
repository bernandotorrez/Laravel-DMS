<div class="row layout-top-spacing">

    <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
        <div class="widget-content-area br-4">
            <div class="widget-one">

                @if($delete_status == 'success')
                <div class="alert alert-success"> Delete Success! </div>
                @elseif($delete_status == 'fail')
                <div class="alert alert-danger"> Delete Failed! </div>
                @endif

                <button type="button" 
                class="btn btn-primary mr-4" 
                wire:click.prevent="$emit('openModal')"> Add
                </button>

                <button type="button" 
                class="btn btn-success mr-4" 
                wire:click.prevent="showEditForm"
                @if(count($checked) != 1) disabled @endif
                > Edit
                </button>

                <button type="button" 
                class="btn btn-danger" 
                wire:click.prevent="deleteCarModel"
                @if(count($checked) <= 0 ) disabled @endif
                > Delete
                </button>

                <!-- @dump($checked) -->

                <!-- Modal -->
                <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
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
                                <h6 class="mb-4">Car Model</h6>

                                <p class=""></p>

                                <form>
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

                                    <div class="form-group mb-4">
                                        <label for="model_name">Model Name</label>
                                        <input type="text" class="form-control" id="model_name" maxlength="50"
                                            placeholder="Example : Porsche" wire:model="bindCarModel.desc_model">
                                        @error('bindCarModel.desc_model') <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i>
                                    Discard</button>
                                @if($is_edit)
                                <button type="button" class="btn btn-success" id="update"
                                    wire:click.prevent="editCarModel"> Update </button>
                                @else
                                <button type="button" class="btn btn-primary" id="submit"
                                    wire:click.prevent="addCarModel"> Submit </button>
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
                            <th width="10%" wire:click="sortBy('id')">
                                <a href="javascript:void(0);">ID
                                    @if($sortBy != 'id')
                                    <i class="fas fa-arrows-alt-v"></i>
                                    @elseif($sortBy == 'id')
                                    @if($sortDirection == 'asc')
                                    <i class="fas fa-sort-alpha-up"></i>
                                    @elseif($sortDirection == 'desc')
                                    <i class="fas fa-sort-alpha-down-alt"></i>
                                    @endif
                                    @endif
                                </a>
                            </th>
                            <th wire:click="sortBy('desc_model')">
                                <a href="javascript:void(0);">Model Name
                                    @if($sortBy != 'desc_model')
                                    <i class="fas fa-arrows-alt-v"></i>
                                    @elseif($sortBy == 'desc_model')
                                    @if($sortDirection == 'asc')
                                    <i class="fas fa-sort-alpha-up"></i>
                                    @elseif($sortDirection == 'desc')
                                    <i class="fas fa-sort-alpha-down-alt"></i>
                                    @endif
                                    @endif
                                </a>
                            </th>
                        </thead>
                        <tbody>
                            @foreach($car_model_paginate as $data)
                            <tr>
                                <td>
                                    <input type="checkbox" 
                                    value="{{ $data->id }}" 
                                    class="new-control-input"
                                    wire:model="checked">
                                </td>
                                <td>{{ $data->id }}</td>
                                <td>{{ $data->desc_model }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-center">
                        {{ $car_model_paginate->links('livewire.pagination-links') }}
                    </div>

                </div>

            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
Livewire.on('closeModal', function() {
    $('#exampleModal').modal('hide')
})

Livewire.on('openModal', function() {
    @this.insert_status = false
    @this.update_status = false
    @this.is_edit = false
    @this.resetForm()
    $('#exampleModal').modal('show')
})

Livewire.on('openUpdateModal', function() {
    @this.insert_status = false
    @this.update_status = false
    $('#exampleModal').modal('show')
})
</script>
@endpush
