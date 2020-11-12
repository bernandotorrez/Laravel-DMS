<div class="row layout-top-spacing">

    <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
        <div class="widget-content-area br-4">
            <div class="widget-one">

                <h6>Test Detail</h6>

                <p class=""></p>

                @dump($detailData)
                <!-- @dump($errors) -->

                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr align="center">
                                <th>No</th>
                                <th>Item Type</th>
                                <th>Description</th>
                                <th>Qty</th>
                                <th>Estimation Price</th>
                                <th>Total Estimation Price</th>
                                <th><button class="btn btn-success" wire:click.prevent="addDetail">Add</button></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($detailData as $key => $data)
                            <tr align="center" wire:key="{{ $key }}">
                                <td>{{ $loop->iteration }} </td>
                                <td>
                                    <input type="text" class="form-control" 
                                    wire:model.lazy="detailData.{{$key}}.item_type">
                                    @error('detailData.'.$key.'.item_type') <span class="error">{{ $message }}</span>
                                        @enderror
                                </td>
                                <td> 
                                    <input type="text" class="form-control" 
                                    wire:model.lazy="detailData.{{$key}}.description">
                                    @error('detailData.'.$key.'.description') <span class="error">{{ $message }}</span>
                                        @enderror
                                </td>
                                <td>
                                    <input type="number" class="form-control" min="1" max="999"
                                    wire:model.lazy="detailData.{{$key}}.qty">
                                    @error('detailData.'.$key.'.qty') <span class="error">{{ $message }}</span>
                                        @enderror
                                </td>
                                <td>
                                    <input type="number" class="form-control" min="1"
                                    wire:model.lazy="detailData.{{$key}}.estimation_price">
                                    @error('detailData.'.$key.'.estimation_price') <span class="error">{{ $message }}</span>
                                        @enderror
                                </td>
                                <td>
                                    <input type="text" class="form-control" readonly
                                    wire:model.lazy="detailData.{{$key}}.total_estimation_price">
                                    @error('detailData.'.$key.'.total_estimation_price') <span class="error">{{ $message }}</span>
                                        @enderror
                                </td>
                                <td><button class="btn btn-danger" wire:click.prevent="deleteDetail({{$key}})">Delete</button></td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="5" align="right">Grand Total : </td>
                                <td colspan="2"><input type="text" class="form-control" wire:model="grandTotal" readonly></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

</div>

@push('script')
<script>

</script>
@endpush