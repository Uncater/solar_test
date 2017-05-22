<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CommentTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Comment CRUD test
     *
     * @return void
     */
    public function testCrud()
    {
        $commentText = 'Test Comment';
        $createResponse = $this->json('POST', '/api/comments', [
            'comment' => $commentText,
        ]);
        $createResponse
            ->assertStatus(200)
            ->assertJson([
                'created' => true,
            ]);
        $content = json_decode($createResponse->getContent());
        $id = $content->id;

        $readResponse = $this->json('GET', "/api/comments/$id");
        $readResponse
            ->assertStatus(200)
            ->assertJson([
                'id' => $id,
                'comment' => $commentText
            ]);

        $newCommentText = 'Updated Comment';
        $updateResponse = $this->json('PATCH', "/api/comments/$id", [
            'comment' => $newCommentText,
        ]);
        $updateResponse
            ->assertStatus(200)
            ->assertJson([
                'updated' => true,
            ]);

        $readResponse = $this->json('GET', "/api/comments/$id");
        $readResponse
            ->assertStatus(200)
            ->assertJson([
                'comment' => $newCommentText
            ]);

        $deleteResponse = $this->json('DELETE', "/api/comments/$id");
        $deleteResponse
            ->assertStatus(200)
            ->assertJson([
                'deleted' => true,
            ]);
    }


}
