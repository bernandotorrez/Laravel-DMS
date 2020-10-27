<div class="row layout-top-spacing">

    <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
        <div class="widget-content-area br-4">
            <div class="widget-one">

                <h6 class="mb-4">Car Model</h6>

                <p class=""></p>

                <form wire:submit.prevent="addCarModel">
                    <div class="form-group mb-4">
                        <label for="formGroupExampleInput">Model Name</label>
                        <input type="text" class="form-control" max="50" placeholder="Example : Porsche"
                            wire:model="model_name">
                    </div>
                    <button type="button" class="btn btn-primary"> Submit </button>
                </form>

            </div>
        </div>
    </div>

</div>
