<?php

namespace App\Http\Livewire\Page\TestDetail;

use Livewire\Component;

class TestDetailIndex extends Component
{
    protected string $pageTitle = 'Test Detail';
    public array $detailData = [];
    public $grandTotal = 0;

    protected $rules = [
        'detailData.*.item_type' => 'required|string|min:3',
        'detailData.*.description' => 'required|string|min:3',
        'detailData.*.qty' => 'required|numeric|min:1|max:999',
        'detailData.*.estimation_price' => 'required|string|min:1',
    ];

    protected $messages = [
        'detailData.*.item_type.required' => 'Item Type cant be Empty!',
        'detailData.*.item_type.min' => 'Please input Item Type at Least 3 Characters',
        'detailData.*.description.required' => 'Description cant be Empty!',
        'detailData.*.description.min' => 'Please input Description at Least 3 Characters',
        'detailData.*.qty.required' => 'Quantity cant be Empty!',
        'detailData.*.qty.min' => 'Please input Quantity at Least 1',
        'detailData.*.qty.max' => 'Please input Quantity at Max 999',
        'detailData.*.estimation_price.required' => 'Estimation Price cant be Empty!',
        'detailData.*.estimation_price.min' => 'Please input Estimation Price at Least 1',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
        $this->sumGrandTotal();
    }

    public function sumGrandTotal()
    {
        $this->grandTotal = 0;

        foreach($this->detailData as $key => $data)
        {
            $total_estimation_price = floatval($this->detailData[$key]['qty'] * $this->removeFormat($this->detailData[$key]['estimation_price']));
            $this->detailData[$key]['total_estimation_price'] = $this->currencyFormat($total_estimation_price,2,',','.');

            $this->grandTotal += $total_estimation_price;
        }

        $this->grandTotal = $this->currencyFormat($this->grandTotal,2,',','.');
    }

    private function removeFormat($value)
    {
        $text = str_replace(".", "", $value);
        return $text;
    }

    private function currencyFormat($value)
    {
        return number_format($value,2,',','.');
    }

    public function mount()
    {
        $data = array(
            'no' => 1,
            'item_type' => '',
            'description' => '',
            'qty' => 1,
            'estimation_price' => 0,
            'total_estimation_price' => 0
        );

        array_push($this->detailData, $data);
    }

    public function addDetail()
    {
        $end = end($this->detailData);

        $data = array(
            'no' => floatval($end['no'] + 1),
            'item_type' => '',
            'description' => '',
            'qty' => 1,
            'estimation_price' => 0,
            'total_estimation_price' => 0
        );

        array_push($this->detailData, $data);
    }

    public function deleteDetail($key)
    {
        unset($this->detailData[$key]);
        $this->sumGrandTotal();
    }

    public function render()
    {
        return view('livewire.page.test-detail.testdetail-index')->layout('layouts.app', ['title' => $this->pageTitle]);
    }
}
