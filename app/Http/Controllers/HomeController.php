<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
		// Html view page content
		$this->data['user_data'] = Auth::guard('customer')->user();
        $this->data['page_title'] = 'Home';
        return view('front.home.index')->with($this->data);
    }
}
