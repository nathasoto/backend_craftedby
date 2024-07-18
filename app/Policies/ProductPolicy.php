<?php
//
//namespace App\Policies;
//
//use App\Models\Product;
//use App\Models\User;
//use Illuminate\Auth\Access\Response;
//
//class ProductPolicy
//{
//    /**
//     * Determine whether the user can view any models.
//     */
//    public function viewAny(User $user): bool
//    {
//        // All users can view all products
//        return true;
//    }
//
//    /**
//     * Determine whether the user can view the model.
//     */
//    public function view(User $user, Product $product): bool
//    {
//        // Allow viewing the product if the user is the owner of the product
//        return $user->id === $product->user_id;
//    }
//
//    /**
//     * Determine whether the user can create models.
//     */
//    public function create(User $user): bool
//    {
//        // Only users with the "artisan" role can create products
//        return $user->hasRole('artisan');
//    }
//
//    /**
//     * Determine whether the user can update the model.
//     */
//    public function update(User $user, Product $product): bool
//    {
//        // Only users with the "artisan" role and who are the owners of the product can update it
//        return $user->hasRole('artisan') && $user->id === $product->user_id;
//    }
//
//    /**
//     * Determine whether the user can delete the model.
//     */
//    public function delete(User $user, Product $product): bool
//    {
//        // Only users with the "artisan" role and who are the owners of the product can delete it
//        return $user->hasRole('artisan') && $user->id === $product->user_id;
//    }
//
//    /**
//     * Determine whether the user can restore the model.
//     */
//    public function restore(User $user, Product $product): bool
//    {
//        //
//    }
//
//    /**
//     * Determine whether the user can permanently delete the model.
//     */
//    public function forceDelete(User $user, Product $product): bool
//    {
//        //
//    }
//}
