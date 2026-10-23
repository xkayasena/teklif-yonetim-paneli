<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // Müşteri listesi
    public function index()
    {
        $customers = Customer::latest()->paginate(10);

        return view('customers.index', compact('customers'));
    }
    public function create()
    {
        return view('customers.create');
    }

    // Yeni müşteri ekle
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        Customer::create($validated);

        return redirect()->route('customers.index')
            ->with('success', 'Müşteri başarıyla eklendi.');
    }

    // Müşteri düzenleme sayfası
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    // Müşteri bilgilerini güncelle
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $customer->update($validated);

        return redirect()->route('customers.index')
            ->with('success', 'Müşteri bilgileri başarıyla güncellendi.');
    }

    // Müşteri sil
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Müşteri başarıyla silindi.');
    }
}
