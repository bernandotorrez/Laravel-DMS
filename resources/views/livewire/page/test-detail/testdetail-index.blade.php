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
                                <th><button class="btn btn-success" wire:click.prevent="addDetail">+</button></th>
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
                                    <input type="text" class="form-control" min="1"
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
                                <td><button class="btn btn-danger" wire:click.prevent="deleteDetail({{$key}})"
                                @if(count($detailData) == 1) disabled @endif
                                >-</button></td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="5" align="right">Grand Total : </td>
                                <td colspan="2">
                                    <input type="text" id="grandtotal" 
                                    class="form-control" 
                                    wire:model="grandTotal" readonly>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
Livewire.on('changeCurrencyFormat', function() {
    var grandTotalEl = document.getElementById('grandtotal')
    var valueGrandTotal = grandTotalEl.value

    grandTotalEl.value = valueGrandTotal

})

function formatRupiah(angka, prefix){
			var number_string = angka.replace(/[^,\d]/g, '').toString(),
			split   		= number_string.split(','),
			sisa     		= split[0].length % 3,
			rupiah     		= split[0].substr(0, sisa),
			ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
 
			// tambahkan titik jika yang di input sudah menjadi angka ribuan
			if(ribuan){
				separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.');
			}
 
			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
			return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
		}
</script>
@endpush