<?php

namespace App\Http\Controllers;

use App\Repositories\CommentRepository as Comment;
use Illuminate\Http\Request;
use Validator;

class CommentController extends Controller
{
    protected $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->comment->all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'comment' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages());
        }

        $comment = $this->comment->create([
            'comment' => $request->input('comment'),
            'parent_id' => $request->input('parentId'),
        ]);
        return response()->json([
            'created' => true,
            'id' => $comment->id,
            'createdAt' => $comment->created_at,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return $this->comment->find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $comment = $this->comment->update($request->all(), $id);
        return response()->json([
            'updated' => true,
            'updatedAt' => $comment->updated_at,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->comment->delete($id);
        return response([
            'deleted' => true,
        ]);
    }
}
