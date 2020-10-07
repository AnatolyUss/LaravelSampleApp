<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'body', 'user_id'];

    /**
     * Get the posts of the user.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Returns a post with given id, if exists.
     *
     * @param int $postId
     * @return mixed
     */
    public function searchById(int $postId)
    {
        return Post::find($postId);
    }

    /**
     * Returns all posts that belong to given user, if exists.
     *
     * @param int $userId
     * @return Post[]
     */
    public function searchByUserId(int $userId): array
    {
        //
    }

    /**
     * Returns all the matching posts, that contain given string in post body or in title.
     *
     * @param $string
     * @return Post[]
     */
    public function searchByContent(string $string): array
    {
        //
    }

    /**
     * Return the average number of posts users created monthly and weekly.
     *
     * @return array
     */
    public function getAveragePostsByUser(): array
    {
        //
    }
}
