<?php namespace Forums\Http\Controllers;

use Forums\Events,
	Forums\Http\Requests;
use Illuminate\Http\Request;

class SearchController extends Controller {

	protected $repo;

	public function __construct()
	{
		parent::__construct();

		//$this->repo = $repo;
	}

	public function advanced()
	{
		// Get the products
		$products = $productRepo->listAll('name', 'id');

		// Get the tags
		$tags = $tagRepo->listAll('name', 'id');

		return view('pages.search-advanced', compact('products', 'tags'));
	}

	public function doAdvancedSearch(Request $request)
	{
		// Get the search term
		$term = $request->get('q');

		// Do the search
		$results = $this->repo->searchAdvanced($request->all());

		return view('pages.search-results', compact('term', 'results'));
	}

	public function doSearch(Request $request)
	{
		// Get the search term
		$term = $request->get('q');

		// Do the search
		$results = $this->repo->search($term);

		return view('pages.search-results', compact('term', 'results'));
	}

}
