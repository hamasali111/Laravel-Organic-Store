<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\OrderHistoryController;
use App\Http\Controllers\OrderTrackingController;
use App\Http\Controllers\OrderNoteController;
use App\Http\Controllers\OrderReturnController;
use App\Http\Controllers\OrderInvoiceController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminCouponController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AdminReturnController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NewsletterController;
use Illuminate\Support\Facades\Route;


// Public
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [ProductController::class, 'index'])->name('shop');
Route::get('/shop/category/{slug}', [ProductController::class, 'category'])->name('shop.category');
Route::get('/shop/{slug}', [ProductController::class, 'show'])->name('product.show');

// Newsletter
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

// Order Tracking (public — no login needed)
Route::get('/track-order', [OrderTrackingController::class, 'index'])->name('orders.track');
Route::post('/track-order', [OrderTrackingController::class, 'track'])->name('orders.track.search');

// Cart (session-based, no auth needed)
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/coupon', [CartController::class, 'applyCoupon'])->name('cart.coupon');
Route::post('/cart/coupon/remove', [CartController::class, 'removeCoupon'])->name('cart.coupon.remove');

// Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');

// Auth required
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/orders', [OrderHistoryController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderHistoryController::class, 'show'])->name('orders.show');

    // Order Invoice (auth required — customer or admin)
    Route::get('/orders/{order}/invoice', [OrderInvoiceController::class, 'download'])->name('orders.invoice');

    // Order Notes / Chat
    Route::post('/orders/{order}/notes', [OrderNoteController::class, 'store'])->name('orders.notes.store');

    // Returns
    Route::get('/orders/{order}/returns/create', [OrderReturnController::class, 'create'])->name('orders.returns.create');
    Route::post('/orders/{order}/returns', [OrderReturnController::class, 'store'])->name('orders.returns.store');

    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');

    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

// Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('products', AdminProductController::class);
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update']);
    Route::resource('coupons', AdminCouponController::class);

    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');

    Route::get('/returns', [AdminReturnController::class, 'index'])->name('returns.index');
    Route::put('/returns/{return}', [AdminReturnController::class, 'update'])->name('returns.update');
});

require __DIR__.'/auth.php';
