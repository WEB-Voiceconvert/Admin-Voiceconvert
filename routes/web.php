<?php

use App\Http\Controllers\AlatController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\EventCategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\Operator\BeritaController as OperatorBeritaController;
use App\Http\Controllers\Operator\EventCategoryController as OperatorEventCategoryController;
use App\Http\Controllers\Operator\EventController as OperatorEventController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

Auth::routes(['verify' => true]);

Route::middleware('is_admin')->prefix('/admin')->name('admin.')->group(function () {
    Route::prefix('/operator')->name('operator.')->group(function () {
        Route::get('/', [OperatorController::class, 'index'])->name('index');
        Route::post('/create', [OperatorController::class, 'store'])->name('store');
        Route::get('/view/{id}', [OperatorController::class, 'show'])->name('view');
        Route::post('/resend-email-verification', [OperatorController::class, 'resendVerify'])->name('resend');
        Route::get('/delete/{id}', [OperatorController::class, 'destroy'])->name('delete');
    });

    Route::prefix('/member')->name('member.')->group(function () {
        Route::get('/', [MemberController::class, 'index'])->name('index');
        Route::get('/view/{id}', [MemberController::class, 'show'])->name('view');
        Route::get('/delete/{id}', [MemberController::class, 'destroy'])->name('delete');
        Route::post('/update/{id}', [MemberController::class, 'update'])->name('update');
    });

    Route::prefix('/berita')->name('berita.')->group(function () {
        Route::get('/', [BeritaController::class, 'index'])->name('index');
        Route::get('/create', [BeritaController::class, 'create'])->name('create');
        Route::post('/create', [BeritaController::class, 'store'])->name('store');
        Route::get('/view/{id}', [BeritaController::class, 'show'])->name('view');
        Route::get('/update/{id}', [BeritaController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [BeritaController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [BeritaController::class, 'destroy'])->name('delete');
        Route::post('/add-voice', [BeritaController::class, 'storeVoice'])->name('voice.store');
        Route::get('/delete-voice/{id}', [BeritaController::class, 'destroyVoice'])->name('voice.delete');
    });

    Route::prefix('/event')->name('event.')->group(function () {
        Route::get('/', [EventController::class, 'index'])->name('index');
        Route::get('/view/{id}', [EventController::class, 'show'])->name('view');
        Route::get('/create', [EventController::class, 'create'])->name('create');
        Route::post('/create', [EventController::class, 'store'])->name('store');
        Route::get('/update/{id}', [EventController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [EventController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [EventController::class, 'destroy'])->name('delete');
        Route::post('/add-voice', [EventController::class, 'storeVoice'])->name('voice.store');
        Route::get('/delete-voice/{id}', [EventController::class, 'destroyVoice'])->name('voice.delete');

        Route::prefix('/category')->name('category.')->group(function () {
            Route::post('/create', [EventCategoryController::class, 'store'])->name('store');
            Route::post('/update/{id}', [EventCategoryController::class, 'update'])->name('update');
            Route::get('/update/{id}', [EventCategoryController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [EventCategoryController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [EventCategoryController::class, 'destroy'])->name('delete');
        });
    });

    Route::prefix('/paket')->name('paket.')->group(function () {
        Route::get('/', [PaketController::class, 'index'])->name('index');
        Route::post('/create', [PaketController::class, 'store'])->name('store');
        Route::get('/update/{id}', [PaketController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [PaketController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [PaketController::class, 'destroy'])->name('delete');
    });

    Route::prefix('/product')->name('product.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/create', [ProductController::class, 'store'])->name('store');
        Route::get('/view/{id}', [ProductController::class, 'show'])->name('view');
        Route::get('/update/{id}', [ProductController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [ProductController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [ProductController::class, 'destroy'])->name('delete');
        Route::prefix('/image')->name('image.')->group(function () {
            Route::post('/upload', [ProductController::class, 'storeImage'])->name('upload');
            Route::get('/delete/{id}', [ProductController::class, 'deleteImage'])->name('delete');
        });
    });

    Route::prefix('/gallery')->name('gallery.')->group(function () {
        Route::get('/', [GalleryController::class, 'index'])->name('index');
        Route::get('/create', [GalleryController::class, 'create'])->name('create');
        Route::post('/create', [GalleryController::class, 'store'])->name('store');
        Route::get('/view/{id}', [GalleryController::class, 'show'])->name('view');
        Route::get('/update/{id}', [GalleryController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [GalleryController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [GalleryController::class, 'destroy'])->name('delete');
        Route::prefix('/image')->name('image.')->group(function () {
            Route::post('/upload', [GalleryController::class, 'storeImage'])->name('upload');
            Route::get('/delete/{id}', [GalleryController::class, 'deleteImage'])->name('delete');
        });
    });

    Route::prefix('/alat')->name('alat.')->group(function () {
        Route::get('/', [AlatController::class, 'index'])->name('index');
        Route::get('/create', [AlatController::class, 'create'])->name('create');
        Route::post('/create', [AlatController::class, 'store'])->name('store');
        Route::get('/view/{id}', [AlatController::class, 'show'])->name('view');
        Route::get('/update/{id}', [AlatController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [AlatController::class, 'update'])->name('update');
        Route::post('/generate-api-key', [AlatController::class, 'updateApiKey'])->name('updateApi');
        Route::get('/delete/{id}', [AlatController::class, 'destroy'])->name('delete');
    });
});

Route::middleware('is_operator')->prefix('/operator')->name('operator.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('operator.event.index');
    })->name('dashboard');
    Route::prefix('/event')->name('event.')->group(function () {
        Route::get('/', [OperatorEventController::class, 'index'])->name('index');
        Route::get('/view/{id}', [OperatorEventController::class, 'show'])->name('view');
        Route::get('/create', [OperatorEventController::class, 'create'])->name('create');
        Route::post('/create', [OperatorEventController::class, 'store'])->name('store');
        Route::get('/update/{id}', [OperatorEventController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [OperatorEventController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [OperatorEventController::class, 'destroy'])->name('delete');
        Route::post('/add-voice', [OperatorEventController::class, 'storeVoice'])->name('voice.store');
        Route::get('/delete-voice/{id}', [OperatorEventController::class, 'destroyVoice'])->name('voice.delete');

        Route::prefix('/category')->name('category.')->group(function () {
            Route::post('/create', [OperatorEventCategoryController::class, 'store'])->name('store');
            Route::post('/update/{id}', [OperatorEventCategoryController::class, 'update'])->name('update');
            Route::get('/update/{id}', [OperatorEventCategoryController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [OperatorEventCategoryController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [OperatorEventCategoryController::class, 'destroy'])->name('delete');
        });
    });
    Route::prefix('/berita')->name('berita.')->group(function () {
        Route::get('/', [OperatorBeritaController::class, 'index'])->name('index');
        Route::get('/create', [OperatorBeritaController::class, 'create'])->name('create');
        Route::post('/create', [OperatorBeritaController::class, 'store'])->name('store');
        Route::get('/view/{id}', [OperatorBeritaController::class, 'show'])->name('view');
        Route::get('/update/{id}', [OperatorBeritaController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [OperatorBeritaController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [OperatorBeritaController::class, 'destroy'])->name('delete');
        Route::post('/add-voice', [OperatorBeritaController::class, 'storeVoice'])->name('voice.store');
        Route::get('/delete-voice/{id}', [OperatorBeritaController::class, 'destroyVoice'])->name('voice.delete');
    });
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
