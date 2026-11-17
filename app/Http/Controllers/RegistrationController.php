<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\Workshop;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;

class RegistrationController extends Controller
{   
    public function index(Request $request)
    {
        $dataRegistration = Registration::with('workshop')
            ->where('user_id', $request->user()->id)
            ->when($request->search, function($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
                });
            })            
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('user.registrations.index', compact('dataRegistration'));
    }

    public function store(Request $request, Workshop $workshop)
    {
        $user = $request->user();

        $existing = Registration::where('user_id', $user->id)
            ->where('workshop_id', $workshop->id)
            ->whereIn('status', ['pending', 'paid'])
            ->first();

        if ($existing) {
            if ($existing->status === 'pending' && !$existing->payment_url) {
                $existing->delete();
            } else {
                return to_route('registrations.show', $existing);
            }
        }

        if ($workshop->capacity !== null) {
            $taken = $workshop->registrations()
                ->whereIn('status', ['pending', 'paid'])
                ->count();

            if ($taken >= $workshop->capacity) {
                return back()->with('error', 'Kuota workshop sudah penuh.');
            }
        }

        $registration = Registration::create([
            'user_id' => $user->id,
            'workshop_id' => $workshop->id,
            'order_id' => 'WS-' . Str::uuid(),
            'status' => 'pending',
        ]);

        try {
            $this->configMidtrans();
            $payment = Snap::createTransaction([
                'transaction_details' => [
                    'order_id' => $registration->order_id,
                    'gross_amount' => (int) $workshop->harga,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                ],
                'enabled_payments' => ['gopay', 'other_qris'],
            ]);
        } catch (\Exception $error) {
            $registration->delete();

            report($error);
            return back()->with('error', $error->getMessage());
        }

        $registration->update(['payment_url' => $payment->redirect_url]);

        return redirect()->away($payment->redirect_url);
    }

    public function show(Request $request, Registration $registration)
    {
        $this->authorizeOwner($request, $registration);

        return view('user.registrations.show', [
            'title' => 'Detail Pendaftaran',
            'registration' => $registration->load('workshop'),
        ]);
    }

    public function pay(Request $request, Registration $registration)
    {
        $this->authorizeOwner($request, $registration);

        if ($registration->status === 'paid') {
            return to_route('registrations.ticket', $registration);
        }

        if ($registration->status !== 'pending' || !$registration->payment_url) {
            return to_route('registrations.show', $registration)
                ->with('message', 'Pendaftaran ini tidak bisa dibayar lagi. Silakan daftar ulang.');
        }

        return redirect()->away($registration->payment_url);
    }

    public function check(Request $request, Registration $registration)
    {
        $this->authorizeOwner($request, $registration);

        try {
            $this->configMidtrans();
            $result = Transaction::status($registration->order_id);
        } catch (\Exception $e) {
            report($e);
            return to_route('registrations.show', $registration)
                ->with('message', 'Status belum bisa diperiksa. Pastikan metode bayar sudah dipilih di Snap.');
        }

        $sameOrder = $result->order_id === $registration->order_id;
        $sameAmount = (int) $result->gross_amount === (int) $registration->workshop->harga;

        if (!$sameOrder || !$sameAmount) {
            return to_route('registrations.show', $registration)
                ->with('message', 'Status tidak valid.');
        }

        $newStatus = $this->mapStatus($result->transaction_status ?? 'unknown');

        if ($newStatus) {
            $registration->update(['status' => $newStatus]);
        }

        if ($registration->status === 'paid') {
            return to_route('registrations.ticket', $registration)
                ->with('message', 'Pembayaran berhasil.');
        }

        return to_route('registrations.show', $registration)
            ->with('message', 'Status pembayaran: ' . $registration->status . '.');
    }

    public function ticket(Request $request, Registration $registration)
    {
        $this->authorizeOwner($request, $registration);

        abort_unless($registration->status === 'paid', 403, 'Tiket belum tersedia.');

        return view('user.registrations.ticket', [
            'title' => 'Tiket Digital',
            'registration' => $registration->load('workshop', 'user'),
        ]);
    }

    private function mapStatus(string $midtransStatus): ?string
    {
        return match ($midtransStatus) {
            'settlement', 'capture' => 'paid',
            'pending' => 'pending',
            'expire' => 'expired',
            'deny', 'cancel', 'failure' => 'failed',
            default => null,
        };
    }

    private function authorizeOwner(Request $request, Registration $registration): void
    {
        abort_unless($registration->user_id === $request->user()->id, 403);
    }

    private function configMidtrans(): void
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = false;
    }
}