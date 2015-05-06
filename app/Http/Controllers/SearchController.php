<?php namespace Forums\Http\Controllers;

use TagRepositoryInterface,
	ArticleRepositoryInterface,
	ProductRepositoryInterface;
use Forums\Events,
	Forums\Http\Requests,
	Forums\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller {

	protected $repo;

	public function __construct(ArticleRepositoryInterface $repo)
	{
		parent::__construct();

		$this->repo = $repo;
	}

	public function advanced(ProductRepositoryInterface $productRepo, TagRepositoryInterface $tagRepo)
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