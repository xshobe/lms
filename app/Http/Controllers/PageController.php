<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function index($slug = NULL)
    {
    	// Html view page content
        $this->data['page_title'] = $this->getPageTitle($slug);
        return view('front.pages.full_width')->with($this->data);
    }

    private function getPageTitle($slug)
    {
    	if ($slug === NULL)
    	return;

    	return ucfirst(str_replace('-', ' ', $slug));
    }

    public function pageUnderConstruction()
    {
        $this->data['page_title'] = 'Page Under Constrction';
        return view('front.pages.page_under_construct')->with($this->data);
    }
}
