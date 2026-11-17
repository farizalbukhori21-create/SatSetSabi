<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Category;
use App\Models\Product;
use App\Models\Denomination;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{

    public function orders()
    {
        $orders = Order::with(['user','denomination.product'])->latest()->paginate(20);
        return view('admin.orders', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'payment_status' => ['required', Rule::in(['unpaid','pending_verification','paid','rejected'])],
            'order_status' => ['required', Rule::in(['pending_payment','processing','completed','failed','cancelled'])],
        ]);
        if ($data['order_status'] === 'processing' || $data['order_status'] === 'completed') {
            abort_unless($data['payment_status'] === 'paid', 422, 'Pesanan hanya dapat diproses setelah pembayaran terverifikasi.');
        }
        $data['paid_at'] = $data['payment_status'] === 'paid' ? ($order->paid_at ?? now()) : null;
        $order->update($data);
        return back()->with('success', 'Status pesanan diperbarui.');
    }

    public function index(Request $request)
    {
        if ($request->routeIs('admin.categories.index')) {
            return view('admin.categories', ['categories' => Category::latest()->get()]);
        }
        $stats = ['orders' => Order::count(), 'pending' => Order::whereIn('payment_status', ['unpaid','pending_verification'])->count(), 'revenue' => Order::where('payment_status','paid')->sum('amount'), 'users' => \App\Models\User::where('role','user')->count()];
        $recentOrders = Order::with(['user','denomination.product'])->latest()->take(8)->get();
        return view('admin.dashboard', compact('stats','recentOrders'));
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => ['required','string','max:100'], 'description' => ['nullable','string']]);
        Category::create([...$data, 'slug' => Str::slug($data['name']) . '-' . Str::lower(Str::random(4)), 'is_active' => true]);
        return back()->with('success', 'Kategori ditambahkan.');
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate(['name' => ['required','string','max:100'], 'description' => ['nullable','string'], 'is_active' => ['sometimes','boolean']]);
        $category->update($data);
        return back()->with('success', 'Kategori diperbarui.');
    }

    public function destroy(Category $category)
    {
        abort_if($category->products()->exists(), 422, 'Kategori masih memiliki produk.');
        $category->delete();
        return back()->with('success', 'Kategori dihapus.');
    }

    public function products()
    {
        return view('admin.products', ['products' => Product::with('category')->latest()->get(), 'categories' => Category::all()]);
    }

    public function storeProduct(Request $request)
    {
        $data = $request->validate(['category_id' => ['required','exists:categories,id'], 'name' => ['required','string','max:120'], 'description' => ['nullable','string']]);
        Product::create([...$data, 'slug' => Str::slug($data['name']) . '-' . Str::lower(Str::random(4)), 'is_active' => true]);
        return back()->with('success', 'Game ditambahkan.');
    }

    public function storeDenomination(Request $request)
    {
        $data = $request->validate(['product_id' => ['required','exists:products,id'], 'name' => ['required','string','max:100'], 'price' => ['required','integer','min:1']]);
        Denomination::create([...$data, 'is_active' => true]);
        return back()->with('success', 'Nominal ditambahkan.');
    }

    public function users()
    {
        $users = \App\Models\User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }
}
