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
                        <input type="text" class="form-control" id="model_name" maxlength="50" placeholder="Example : Porsche"
                            wire:model="model_name">
                        @error('model_name') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    @if($is_edit)
                    <button type="submit" class="btn btn-success" id="update"> Update </button>
                    @else
                    <button type="submit" class="btn btn-primary" id="submit"> Submit </button>
                    @endif
                    
                </form>

                <p></p>

                <div class="table-responsive mt-4">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Model Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($car_model_data as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->desc_model }}</td>
                                <td>
                                    <button class="btn btn-success" wire:click="showEditForm({{$data}})"> Edit </button> |
                                    <button class="btn btn-danger" wire:click="deleteCarModel('{{ $data->id }}')"> Delete </button>
                                </td>
                            </tr>
                            @endforeach
                        <tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

</div>
