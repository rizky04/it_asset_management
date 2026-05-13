<?php

namespace App\Http\Controllers;

use App\Models\Handover;
use App\Models\HandoverSignature;
use Illuminate\Http\Request;

class HandoverSignatureController extends Controller
{
    /** Generate signature tokens untuk semua 4 penanda tangan */
    public function generate(Handover $handover)
    {
        $handover->generateSignatures();
        $handover->load('signatures');

        return redirect()->route('handovers.show', $handover)
            ->with('success', 'Link tanda tangan berhasil dibuat.');
    }

    /** Halaman publik untuk menandatangani (tidak perlu login) */
    public function sign(string $token)
    {
        $signature = HandoverSignature::where('token', $token)->firstOrFail();
        $handover = $signature->handover;

        if ($signature->isSigned()) {
            return view('handovers.sign', compact('signature', 'handover', 'token'))
                ->with('already_signed', true);
        }

        return view('handovers.sign', compact('signature', 'handover', 'token'));
    }

    /** Simpan tanda tangan */
    public function store(Request $request, string $token)
    {
        $signature = HandoverSignature::where('token', $token)->firstOrFail();

        if ($signature->isSigned()) {
            return back()->with('error', 'Dokumen ini sudah ditandatangani.');
        }

        $request->validate([
            'signature_data' => 'required|string',
        ]);

        $signature->update([
            'signature_data' => $request->signature_data,
            'signed_at'      => now(),
            'signed_ip'      => $request->ip(),
        ]);

        return redirect()->route('sign.done', $token);
    }

    /** Halaman konfirmasi setelah ttd */
    public function done(string $token)
    {
        $signature = HandoverSignature::where('token', $token)->firstOrFail();

        return view('handovers.sign-done', compact('signature'));
    }

    /** Reset tanda tangan (admin only) */
    public function reset(Handover $handover, string $role)
    {
        $handover->signatures()->where('role', $role)->update([
            'signature_data' => null,
            'signed_at'      => null,
            'signed_ip'      => null,
        ]);

        return back()->with('success', 'Tanda tangan direset.');
    }
}
