<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class OfferController extends Controller
{
    public function index()
    {
        $offers = Offer::with('customer')
            ->latest()
            ->paginate(10);

        return view('offers.index', compact('offers'));
    }

    public function create()
    {
        $customers = Customer::orderBy('full_name')->get();

        return view('offers.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => ['required', 'integer', 'exists:customers,id'],
            'offer_date' => ['required', 'date'],
            'vat_rate' => ['required', 'numeric', Rule::in([0, 10, 20])],
            'items' => ['required', 'array', 'min:1', 'max:25'],
            'items.*.description' => ['required', 'string'],
            'items.*.unit' => [
                'required',
                Rule::in(['m²', 'adet', 'metre', 'kg', 'saat', 'takım']),
            ],
            'items.*.quantity' => ['required', 'numeric', 'gt:0', 'max:999999999'],
            'items.*.unit_price' => ['required', 'numeric', 'min:0', 'max:999999999999'],
        ], [
            'customer_id.required' => 'Lütfen müşteri seçin.',
            'customer_id.exists' => 'Seçilen müşteri bulunamadı.',
            'offer_date.required' => 'Teklif tarihini girin.',
            'items.required' => 'En az bir teklif kalemi ekleyin.',
            'items.max' => 'Bir teklife en fazla 25 kalem ekleyebilirsiniz.',
            'items.*.description.required' => 'Her kalemin açıklaması zorunludur.',
            'items.*.unit.required' => 'Her kalem için birim seçin.',
            'items.*.quantity.required' => 'Her kalem için miktar girin.',
            'items.*.quantity.gt' => 'Miktar sıfırdan büyük olmalıdır.',
            'items.*.unit_price.required' => 'Her kalem için birim fiyat girin.',
        ]);

        $subtotal = 0;

        $calculatedItems = collect($validated['items'])->map(function ($item) use (&$subtotal) {
            $lineTotal = round(
                (float) $item['quantity'] * (float) $item['unit_price'],
                2
            );

            $subtotal += $lineTotal;

            return [
                'description' => $item['description'],
                'unit' => $item['unit'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'line_total' => $lineTotal,
            ];
        });

        $subtotal = round($subtotal, 2);
        $vatRate = (float) $validated['vat_rate'];
        $vatAmount = round($subtotal * $vatRate / 100, 2);
        $grandTotal = round($subtotal + $vatAmount, 2);

        $offer = DB::transaction(function () use (
            $validated,
            $calculatedItems,
            $subtotal,
            $vatRate,
            $vatAmount,
            $grandTotal
        ) {
            $offer = Offer::create([
                'customer_id' => $validated['customer_id'],
                'offer_number' => 'TKL-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6)),
                'offer_date' => $validated['offer_date'],
                'status' => 'draft',
                'subtotal' => $subtotal,
                'vat_rate' => $vatRate,
                'vat_amount' => $vatAmount,
                'grand_total' => $grandTotal,
            ]);

            $offer->items()->createMany($calculatedItems->all());

            return $offer;
        });

        return redirect()
            ->route('offers.show', $offer)
            ->with('success', 'Teklif başarıyla oluşturuldu.');
    }

    public function show(Offer $offer)
    {
        $offer->load('customer', 'items');

        return view('offers.show', compact('offer'));
    }
    public function pdf(Offer $offer)
    {
        $offer->load(['customer', 'items']);

        $pdf = Pdf::loadView('offers.pdf', [
            'offer' => $offer,
        ])->setPaper('a4', 'portrait');

        return $pdf->download($offer->offer_number . '.pdf');
    }
    public function destroy(\App\Models\Offer $offer)
    {
        $offer->items()->delete();
        $offer->delete();

        return redirect()
            ->route('offers.index')
            ->with('success', 'Teklif başarıyla silindi.');
    }
}
