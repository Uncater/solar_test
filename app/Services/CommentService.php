<?php

namespace App\Services;
use App\Repositories\CommentRepository as Comment;


class CommentService
{
    private $marginInc = 20;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function commentsToHTML()
    {
        $comments = $this->comment->getAllWithTrashed();
        $structuredComments = [];
        $view = '';
        foreach ($comments as $value) {
            $structuredComments[$value->id]['parent'] = $value;
            if ($value->parent_id) {
                $structuredComments[$value->parent_id]['child'][] = $value->id;
            }
        }
        // Removing trashed comments with no children
        foreach ($structuredComments as $key => $value) {
            if ($value['parent']->trashed()) {
                if (empty($value['child'])) {
                    unset($structuredComments[$key]);
                } else {
                    foreach ($value['child'] as $childId) {
                        $childs = [$childId, $key];
                        while ($childId) {
                            if (!empty($structuredComments[$childId])) {
                                $childComment = $structuredComments[$childId];
                                if (!empty($childComment['child'])) {
                                    $childId = array_shift($childComment['child']);
                                    $childs[] = $childId;
                                } else {
                                    if ($childComment['parent']->trashed()) {
                                        foreach ($childs as $child) {
                                            unset($structuredComments[$child]);
                                        }
                                    }
                                    break;
                                }
                            } else {
                                break;
                            }
                        }
                    }
                }
            }
        }
        //Parsing all comments to HTML
        foreach ($structuredComments as $key => &$value) {
            $view .= view('comment', ['comment' => $value['parent']]);
            if (!empty($value['child'])) {
                foreach ($value['child'] as $childId) {
                    $depth = 1;
                    while ($childId) {
                        if (!empty($structuredComments[$childId])) {
                            $childComment = $structuredComments[$childId];
                            $view .= view('comment', [
                                'comment' => $childComment['parent'],
                                'margin' => $depth * $this->marginInc,
                            ]);
                            unset($structuredComments[$childId]);

                            if (!empty($childComment['child'])) {
                                $depth++;
                                $childId = array_shift($childComment['child']);
                            } else {
                                break;
                            }
                        } else {
                            break;
                        }
                    }
                }
            }
            unset($structuredComments[$key]);
        }
        return $view;
    }


}