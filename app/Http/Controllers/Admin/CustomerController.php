<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('customer_code', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by loyalty level
        if ($request->filled('loyalty_level')) {
            switch ($request->loyalty_level) {
                case 'vip':
                    $query->where('total_spent', '>=', 10000000);
                    break;
                case 'gold':
                    $query->where('total_spent', '>=', 5000000)->where('total_spent', '<', 10000000);
                    break;
                case 'silver':
                    $query->where('total_spent', '>=', 1000000)->where('total_spent', '<', 5000000);
                    break;
                case 'bronze':
                    $query->where('total_spent', '<', 1000000);
                    break;
            }
        }

        // Filter by newsletter subscription
        if ($request->filled('newsletter')) {
            $query->where('newsletter_subscription', $request->newsletter === 'yes');
        }

        $customers = $query->withCount('orders')
                          ->orderBy('created_at', 'desc')
                          ->paginate(20);

        return view('admin.customers.index', compact('customers'));
    }

    public function show(Customer $customer)
    {
        $customer->load(['orders' => function ($query) {
            $query->latest()->limit(10);
        }]);

        return view('admin.customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('customers')->ignore($customer->id)],
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'district' => 'nullable|string|max:100',
            'ward' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive,banned',
            'is_active' => 'boolean',
            'loyalty_points' => 'nullable|integer|min:0',
            'preferred_payment_method' => 'nullable|in:cod,bank_transfer,momo,zalopay,vnpay',
            'marketing_consent' => 'boolean',
            'newsletter_subscription' => 'boolean',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Handle password update
        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $customer->update($validated);

        return redirect()->route('admin.customers.show', $customer)
                        ->with('success', 'Thông tin khách hàng đã được cập nhật thành công!');
    }

    public function ban(Customer $customer, Request $request)
    {
        $customer->ban();
        
        // If AJAX request, return JSON
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Khách hàng đã bị cấm!'
            ]);
        }
        
        // If regular form submission, redirect with flash message
        return redirect()->back()->with('success', 'Khách hàng đã bị cấm thành công!');
    }

    public function unban(Customer $customer, Request $request)
    {
        $customer->unban();
        
        // If AJAX request, return JSON
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Đã bỏ cấm khách hàng!'
            ]);
        }
        
        // If regular form submission, redirect with flash message
        return redirect()->back()->with('success', 'Đã bỏ cấm khách hàng thành công!');
    }

    public function addLoyaltyPoints(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'points' => 'required|integer|min:1',
            'reason' => 'nullable|string|max:255'
        ]);

        $customer->addLoyaltyPoints($validated['points']);

        return response()->json([
            'success' => true,
            'message' => "Đã thêm {$validated['points']} điểm thưởng cho khách hàng!",
            'new_points' => $customer->fresh()->loyalty_points
        ]);
    }

    public function deductLoyaltyPoints(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'points' => 'required|integer|min:1',
            'reason' => 'nullable|string|max:255'
        ]);

        if ($customer->deductLoyaltyPoints($validated['points'])) {
            return response()->json([
                'success' => true,
                'message' => "Đã trừ {$validated['points']} điểm thưởng của khách hàng!",
                'new_points' => $customer->fresh()->loyalty_points
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Không đủ điểm thưởng để trừ!'
        ], 400);
    }

    public function activate(Customer $customer)
    {
        $customer->activate();

        return redirect()->back()
            ->with('success', 'Khách hàng đã được kích hoạt thành công!');
    }

    public function deactivate(Customer $customer)
    {
        $customer->deactivate();

        return redirect()->back()
            ->with('success', 'Khách hàng đã được vô hiệu hóa thành công!');
    }
} 