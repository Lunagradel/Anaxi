<?php

namespace App\Http\Controllers;

// use Faker\Provider\DateTime;
use Illuminate\Http\Request;
// use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
// use Illuminate\Foundation\Validation\ValidatesRequests;
// use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

// use App\Http\Controllers\LoginController as LoginController;
use Search\Search as Search;

class SearchController
{
    // public $LoginController;
    //
    // public function __construct() {
    // 	$this->LoginController = new LoginController();
    // }

    public function getSearchResult( Request $request )
    {
        $searchValue = $request->input('searchValue');

        $Search = new Search();
        $Response = $Search->getSearchResult($searchValue);

        return $Response;


    }
}
