<div class="row layout-top-spacing">

    <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
        <div class="widget-content-area br-4">
            <div class="widget-one">

                <h6 class="mb-4">Car Model</h6>

                <p class=""></p>

                <form @if($is_edit) wire:submit.prevent="editCarModel" @else wire:submit.prevent="addCarModel" @endif>
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

                    @if($delete_status == 'success')
                    <div class="alert alert-success"> Delete Success! </div>
                    @elseif($delete_status == 'fail')
                    <div class="alert alert-danger"> Delete Failed! </div>
                    @endif

                    <div class="form-group mb-4">
                        <label for="model_name">Model Name</label>
                        <input type="text" class="form-control" id="model_name" maxlength="50"
                            placeholder="Example : Porsche" wire:model="bindCarModel.desc_model">
                        @error('bindCarModel.desc_model') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    @if($is_edit)
                    <button type="submit" class="btn btn-success" id="update"> Update </button>
                    @else
                    <button type="submit" class="btn btn-primary" id="submit"> Submit </button>
                    @endif

                </form>

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
                    <div class="ml-auto p-2 text-center alert alert-info" wire:loading wire:target="car_model_paginate">Loading ... </div>
                    <div class="ml-auto p-2">
                        <input type="text" class="form-control" wire:model="search" placeholder="Search...">
                    </div>
                </div>
                    <table class="table table-striped table-bordered" id="users-table">
                        <thead>
                            <th width="5%">
                                <!-- <input type="checkbox" 
                                class="new-control-input" 
                                wire:model="allChecked" 
                                wire:click="allChecked"> -->
                            </th>
                            <th width="10%">
                                <button class="btn btn-outline-info" wire:click="sort('id')">ID 
                                    @if($sortBy != 'id')
                                    <i class="fas fa-arrows-alt-v"></i>
                                    @elseif($sortBy == 'id')
                                        @if($sortDirection == 'asc')
                                        <i class="fas fa-sort-alpha-up"></i>
                                        @elseif($sortDirection == 'desc')
                                        <i class="fas fa-sort-alpha-down-alt"></i>
                                        @endif
                                    @endif
                                    </button>
                            </th>
                            <th>
                                <button class="btn btn-outline-info" wire:click="sort('desc_model')">Model Name 
                                    @if($sortBy != 'desc_model')
                                    <i class="fas fa-arrows-alt-v"></i>
                                    @elseif($sortBy == 'desc_model')
                                        @if($sortDirection == 'asc')
                                        <i class="fas fa-sort-alpha-up"></i>
                                        @elseif($sortDirection == 'desc')
                                        <i class="fas fa-sort-alpha-down-alt"></i>
                                        @endif
                                    @endif
                                </button>
                            </th>
                        </thead>
                        <tbody>
                            @foreach($car_model_paginate as $data)
                            <tr>
                                <td>
                                    <input type="checkbox" 
                                    value="{{ $data->id }}" 
                                    class="new-control-input" 
                                    wire:model="checked"
                                    @if(in_array($data->id, $checked)) checked @endif>
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

               

                <!-- <div class="table-responsive mt-4">
                    <button class="btn btn-success" onclick="editForm()">Edit</button>
                    <table class="table table-striped table-bordered" id="users-table">
                        <thead>
                            <th width="5%">Action</th>
                            <th width="5%">ID</th>
                            <th>Model Name</th>
                        </thead>
                    </table>
                </div> -->
            </div>
        </div>
    </div>

</div>

@push('scripts')
<!-- <script>
document.addEventListener('livewire:load', function() {
    $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('datatable.car-model') !!}',
        columns: [
            { data: 'action', name: 'action' },
            { data: 'id', name: 'id' },
            { data: 'desc_model', name: 'desc_model' }
        ]
    });
})
    


function editForm() {
    var id = getIdCheckbox();
   window.location.href = '{!! url('/car-model/edit') !!}'+'/'+id
}

function getIdCheckbox() {
    var closestTr = $(':checkbox:checked').closest('tr');
    return closestTr.find('.new-control-input').attr('data-id');
}
</script> -->
@endpush