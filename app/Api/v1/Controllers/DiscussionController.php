<?php namespace Api\V1\Controllers;

use DiscussionRepositoryInterface;
use Api\V1\Transformers\DiscussionTransformer;
use Illuminate\Http\Request;

class DiscussionController extends ApiBaseController {

	protected $repo;

	public function __construct(DiscussionRepositoryInterface $repo)
	{
		$this->repo = $repo;
	}

	public function index($topic = 'all')
	{
		$discussions = $this->repo->all();

		return $this->response->collection($discussions, new DiscussionTransformer);
	}

	public function show($topic = 'all', $id)
	{
		$discussion = $this->repo->getById($id);

		if ( ! $discussion)
		{
			return $this->response->errorNotFound("No discussion with that ID could be found");
		}

		return $this->response->item($discussion, new DiscussionTransformer);
	}

	public function store(Request $request)
	{
		$discussion = $this->repo->create($request->all());

		if ( ! $discussion)
		{
			return $this->response->errorInternal("Discussion was not created because of an internal server error");
		}

		return $this->response->item($discussion, new DiscussionTransformer);
	}

	public function update(Request $request, $id)
	{
		$discussion = $this->repo->update($id, $request->all());

		if ( ! $discussion)
		{
			return $this->response->errorInternal("Discussion was not updated because of an internal server error");
		}

		return $this->response->item($discussion, new DiscussionTransformer);
	}

	public function destroy(Request $request, $id)
	{
		$discussion = $this->repo->delete($id);

		if ( ! $discussion)
		{
			return $this->response->errorInternal("Discussion was not deleted because of an internal server error");
		}

		return $this->response->item($discussion, new DiscussionTransformer);
	}

}
