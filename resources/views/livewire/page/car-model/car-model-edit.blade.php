<div>
    <form wire:submit.prevent="editCarModel">

        @if($update_status == 'success')
        <div class="alert alert-success"> Update Success! </div>
        @elseif($update_status == 'fail')
        <div class="alert alert-danger"> Update Failed! </div>
        @endif

        <div class="form-group mb-4">
            <label for="model_name">Model Name</label>
            <input type="text" class="form-control" id="model_name" maxlength="50" placeholder="Example : Porsche"
                wire:model="data.desc_model">
            @error('model_name') <span class="error">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-success" id="update"> Update </button>

    </form>
</div>
