<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
            View::composer('layouts.header', function ($view) {
                // Lấy tất cả categories làm menu
                $menus = Category::all();
                
                // Khởi tạo biến đếm giỏ hàng = 0
                $count_cart = 0;
                
                // Kiểm tra user đã đăng nhập chưa
                if (Auth::check()) {
                    // Nếu đã đăng nhập, đếm số items trong giỏ hàng
                    $count_cart = Cart::where('user_id', Auth::user()->id)->count();
                }
                
                // Truyền dữ liệu vào view
                $view->with('menus', $menus)
                     ->with('count_cart', $count_cart);
        });
    }
}
