<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Product;
use App\Services\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function login(Request $request) {
        if ($request->method() == "GET") {
            // if already logged in, direct to index page
            if ($this->adminService->me() != "") {
                return redirect()->route('admin.index');
            }

            // Handling toast message
            $message = Session::get('message');

            return view('admin.login', [
                'message' => $message,
            ]);
        } else {
            // Validate user's inputs
            $request->validate([
                'username' => "required",
                'password' => "required|min:6",
            ]);

            $loggingIn = $this->adminService->login($request->username, $request->password);

            if (!$loggingIn['status']) {
                // If status given by login() is false, redirect user back to login page and show error message
                return redirect()->route('admin.login')->withErrors([
                    $loggingIn['message']
                ]);
            }

            // Redirect to index page and pass message into toast
            return redirect()->route('admin.index')->with(['message' => $loggingIn['message']]);
        }
    }
    public function logout() {
        $this->adminService->logout();

        return redirect()->route('admin.login')->with([
            'message' => "Berhasil logout"
        ]);
    }

    public function index(Request $request) {
        $admin = $this->adminService->me();
        $categories = Category::orderBy('name', 'ASC')->get();
        $message = Session::get('message');
        $category = null;
        
        $filter = [];
        if ($request->q != "") {
            array_push($filter, [
                'name', 'LIKE', "%".$request->q."%"
            ]);
        }
        if ($request->category != "") {
            array_push($filter, [
                'category_id', $request->category
            ]);
            $category = Category::where('id', $request->category)->first();
        }

        $prod = Product::where($filter);
        $products = $prod->orderBy('updated_at', 'DESC')->with(['category'])->paginate(10);

        return view('admin.index', [
            'admin' => $admin,
            'request' => $request,
            'message' => $message,
            'products' => $products,
            'category' => $category,
            'categories' => $categories,
        ]);
    }
}
