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
     * Creates a new post.
     *
     * @param array $parameters
     * @return Post
     */
    public function createPost(array $parameters): Post
    {
        return static::create($parameters);
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
//    public function searchByUserId(int $userId): array
//    {
//        //
//    }

    /**
     * Returns all the matching posts, that contain given string in post body or in title.
     *
     * @param string $content
     * @return Post[]
     */
//    public function searchByContent(string $content): array
//    {
//        //
//    }

    /**
     * Returns all the matching posts, that contain given string in post body or in title.
     * !!!Notice, there is no need to implement searchByUserId(int $userId) and searchByContent(string $content)
     * as separate methods, since it is easy to combine this functionality in one single method
     * search(array $searchParameters).
     * This approach seems to be more generic.
     *
     * @param array $queryParameters
     * @return array
     */
    public function search(array $queryParameters): array
    {
        $query = Post::query();

        if (isset($queryParameters['user_id'])) {
            $query->where('user_id', $queryParameters['user_id']);
        }

        // TODO: implement full-text-search by title and body.

        return runPaginatedQuery($query, $queryParameters);
    }

    /**
     * Return the average number of posts users created monthly and weekly.
     *
     * @param array $searchParameters
     * @return array
     */
    public function getAveragePostsByUser(array $searchParameters): array
    {
        //
    }
}
