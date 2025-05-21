<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LikeController extends Controller
{
    /**
     * Toggle like for a food item.
     *
     * @param  \App\Models\Food  $food
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleLike(Food $food)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated',
            ], 401);
        }
        
        try {
            DB::beginTransaction();
            
            $like = $food->likes()->where('user_id', $user->id)->first();
            
            if ($like) {
                // Unlike
                $like->delete();
                $isLiked = false;
            } else {
                // Like
                $like = $food->likes()->create([
                    'user_id' => $user->id,
                ]);
                $isLiked = true;
            }
            
            // Refresh the food model to get updated likes count
            $food->refresh();
            $likesCount = $food->likes_count;
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'is_liked' => $isLiked,
                'likes_count' => $likesCount,
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Like toggle error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to process like action',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
