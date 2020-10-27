<div class="row layout-top-spacing">

    <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
        <div class="widget-content-area br-4">
            <div class="widget-one">

                <h6 class="mb-4">Car Model</h6>

                <p class=""></p>

                <form wire:submit.prevent="addCarModel">
                    @if($insert_status == 'success')
                    <div class="alert alert-success"> Insert Success! </div>
                    @elseif($insert_status == 'fail')
                    <div class="alert alert-danger"> Insert Failed! </div>
                    @endif

                    <div class="form-group mb-4">
                        <label for="formGroupExampleInput">Model Name</label>
                        <input type="text" class="form-control" maxlength="50" placeholder="Example : Porsche"
                            wire:model="model_name">
                        @error('model_name') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="btn btn-primary"> Submit </button>
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
                                    <button class="btn btn-success"> Edit </button> |
                                    <button class="btn btn-danger"> Delete </button>
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
