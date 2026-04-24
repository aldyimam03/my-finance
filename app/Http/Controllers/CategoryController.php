<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    private function allowedIcons(): array
    {
        return [
            'category',
            'label',
            'payments',
            'account_balance_wallet',
            'credit_card',
            'savings',
            'trending_up',
            'shopping_cart',
            'shopping_bag',
            'restaurant',
            'local_cafe',
            'directions_car',
            'local_gas_station',
            'movie',
            'subscriptions',
            'wifi',
            'phone_android',
            'school',
            'fitness_center',
            'medical_services',
            'home',
            'pets',
            'celebration',
            'volunteer_activism',
            'groups',
            'handyman',
            'bolt',
            'more_horiz',
        ];
    }

    public function index()
    {
        $categories = Auth::user()->categories()->orderBy('name')->get();
        return view('categories', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->where(fn ($query) => $query->where('user_id', Auth::id()))
            ],
            'icon' => ['nullable', 'string', Rule::in($this->allowedIcons())],
        ]);

        // type disimpan sebagai 'general' agar NOT NULL constraint terpenuhi
        $validated['type'] = 'general';
        $validated['icon'] = $validated['icon'] ?? 'label';

        Auth::user()->categories()->create($validated);

        return redirect()->back()->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    public function update(Request $request, Category $category)
    {
        $this->authorize('update', $category);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->where(fn ($query) => $query->where('user_id', Auth::id()))->ignore($category->id)
            ],
            'icon' => ['nullable', 'string', Rule::in($this->allowedIcons())],
        ]);

        if (!array_key_exists('icon', $validated) || $validated['icon'] === null) {
            $validated['icon'] = $category->icon ?? 'label';
        }

        $category->update($validated);

        return redirect()->back()->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);
        $category->delete();

        return redirect()->back()->with('success', 'Kategori berhasil dihapus.');
    }
}
