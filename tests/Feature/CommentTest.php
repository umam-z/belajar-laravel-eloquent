<?php

namespace Tests\Feature;

use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertNotNull;

class CommentTest extends TestCase
{
    /**
     * Eloquent test create new comments
     */
    public function testCreateComment(): void
    {
        $comment = new Comment();
        $comment->email = 'umam@test.com';
        $comment->title = 'Sample Title';
        $comment->comment = 'Sample Comment';
        // $comment->created_at = new \DateTime();
        // $comment->updated_at = new \DateTime();
        $comment->save();

        assertNotNull($comment->id);
    }

    /**
     * Eloquent test create new comments
     */
    public function testDefaultAttribute(): void
    {
        $comment = new Comment();
        $comment->email = 'umam@test.com';
        
        $comment->save();

        assertNotNull($comment->id);
    }
}