<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TweetAllController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\UserFollowController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UserTweetsController;
use App\Models\Tweet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::middleware('auth:sanctum')->group(function(){
    Route::get('/tweets', [TweetController::class, 'index'])->name('tweet.index');
    Route::get('/tweets_all', [TweetAllController::class, 'index'])->name('tweet.index.all');
    Route::get('/tweets/{tweet}', [TweetController::class, 'show'])->name('tweet.show');
    Route::post('/tweets', [TweetController::class, 'store'])->name('tweet.store');
    Route::delete('/tweets/{tweet}', [TweetController::class, 'destroy'])->name('tweet.delete');
});


Route::middleware('auth:sanctum')->post('/tweets', function(Request $request){
    $request->validate([
        'body' => 'required'
    ]);

    return Tweet::create([
        'user_id' => auth()->id(),
        'body' => $request->body,
    ]);
});


// Route::get('/user/{user}', [UserProfileController::class, 'show'])->name('user.profile.show');
// Route::get('/users/{user}/tweets', [UserTweetsController::class, 'index'])->name('user.tweets.index');

Route::get('/users/{user}', function(User $user){
    return $user->only(
        'id',
        'name',
        'username',
        'avatar',
        'profile',
        'location',
        'link',
        'linkText',
        'created_at'
    );
});

Route::get('/users/{user}/tweets', function(User $user){
    return $user->tweets()->with('user:id,name,username,avatar')->latest()->paginate(10);
});


Route::post('/login', [AuthController::class, 'store'])->name('login');


Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'destroy'])->name('logout');

Route::post('/register', [RegisterController::class, 'store'])->name('register');


// Route::middleware('auth:sanctum')->group(function(){
//     Route::post('/follow/{user}', [UserFollowController::class, 'store'])->name('user.follow');
//     Route::post('/unfollow/{user}', [UserFollowController::class, 'destroy'])->name('user.unfollow');
//     Route::get('/is_following/{user}', [UserFollowController::class, 'isFollowing'])->name('user.isFollowing');
// });



Route::middleware('auth:sanctum')->post('/follow/{user}', function(User $user){
    auth()->user()->follow($user);

    return response()->json('Followed', 201);
});

Route::middleware('auth:sanctum')->post('/unfollow/{user}', function(User $user){
    auth()->user()->unfollow($user);

    return response()->json('Unfollowed', 201);
});

Route::middleware('auth:sanctum')->get('/is_following/{user}', function(User $user){
    return response()->json(auth()->user()->isFollowing($user), 200);
});