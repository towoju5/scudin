<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class SearchUser extends Component
{
    public $term = "";

    public function render()
    {
        sleep(1);
        $result = Product::search($this->term)->paginate(10);

        $data = [   
            'result' => $result,
        ];

        return view('livewire.search-user', $data);
    }
}
