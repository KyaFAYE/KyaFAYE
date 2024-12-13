use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AdminDishController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;


// Routes pour l'administration
Route::prefix('admin')->group(function () {
    // Routes d'enregistrement
    Route::get('register', [UserController::class, 'showRegistrationForm'])->name('admin.register');
    Route::post('register', [UserController::class, 'register'])->name('admin.register.submit');

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/admin/dishes', [AdminDishController::class, 'index'])->name('admin.dishes.index');
        Route::post('/admin/dishes', [AdminDishController::class, 'store'])->name('admin.dishes.store');
        Route::delete('/admin/dishes/{id}', [AdminDishController::class, 'destroy'])->name('admin.dishes.destroy');
    });


    // Routes de connexion
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [LoginController::class, 'login'])->name('admin.login.submit');

    // Routes protégées par le middleware 'auth' et 'admin'
    Route::middleware(['auth', 'admin'])->group(function () {
        // Tableau de bord de l'admin
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        // Gestion des menus
        Route::resource('menu', MenuController::class);

        //Gestion des plats
        Route::resource('dishes', DishController::class);

        // Gestion des catégories
        Route::resource('categories', CategoryController::class);

        // Gestion des réservations
        Route::resource('reservations', ReservationController::class);

        // Gestion des commandes
        Route::resource('orders', OrderController::class);
    });
});

// Routes pour les utilisateurs authentifiés
Route::middleware('auth')->group(function () {
    // Gestion du profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Menu pour les utilisateurs



    // routes/web.php
    Route::get('/menu', [DishController::class, 'index'])->name('menu.index');
    Route::post('/menu/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('cart.add');


    // Panier
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'store'])->name('cart.store');
    Route::delete('/cart/remove/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

    // Passer une commande
    Route::post('/order', [OrderController::class, 'store']);

    Route::post('/order', [OrderController::class, 'store'])->name('orders.store');

    // Historique des commandes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
});
