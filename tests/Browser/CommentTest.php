<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CommentTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->value('.text-section textarea', 'Test Comment')
                    ->click('.text-section .add-btn')
                    ->waitForText('Test Comment')
                    ->assertSee('Test Comment')
                    ->click('.comment-section .comment-content .edit')
                    ->value('.comment-section .comment-content textarea', 'Edited Comment')
                    ->click('.comment-section .comment-content .edit-btn')
                    ->waitForText('Edited Comment')
                    ->assertSee('Edited Comment')
                    ->click('.comment-section .comment-content .reply')
                    ->waitFor('.comment-section .text-section')
                    ->value('.comment-section .text-section textarea', 'New Comment')
                    ->click('.comment-section .text-section .add-btn')
                    ->waitForText('New Comment')
                    ->assertSeeIn('.comment-section .comment-content:nth-child(2)', 'New Comment')
                    ->click('.comment-section .comment-content:first-child .delete')
                    ->waitForText('This comment is deleted')
                    ->assertSeeIn('.comment-section .comment-content:first-child', 'This comment is deleted')
                    ->click('.comment-section .comment-content:nth-child(2) .delete')
                    ->pause(100)
                    ->assertDontSee('New Comment')
                    ->assertDontSee('This comment is deleted')
            ;

        });
    }
}
