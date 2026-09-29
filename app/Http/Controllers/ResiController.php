<?php

namespace App\Http\Controllers;

use App\Models\Resi;
use App\Models\Pelanggan;
use App\Models\Cabang;
use App\Models\Layanan;
use App\Services\ResiService;
use App\Http\Requests\SimpanResiRequest;
use Illuminate\Http\Request;

/**
 * ResiController — menangani seluruh operasi CRUD untuk data resi pengiriman.
 *
 * Menggunakan Route Model Binding untuk resolusi otomatis instance Resi,
 * serta mendelegasikan logika bisnis ke ResiService.
 */
class ResiController extends Controller
{
    /**
     * Injeksi ResiService melalui constructor.
     *
     * @param ResiService $resiService Service untuk logika bisnis resi.
     */
    public function __construct(private ResiService $resiService) {}

    /**
     * Tampilkan daftar resi dengan pagination, filter status, dan pencarian.
     *
     * @param  Request                          $request Parameter query: q (cari), status.
     * @return \Illuminate\View\View            View resi.index dengan data paginated.
     */
    public function index(Request $request)
    {
        $resi = Resi::with(['pelanggan', 'cabangAsal', 'cabangTujuan', 'layanan'])
            ->cari($request->query('q'))
            ->status($request->query('status'))
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('resi.index', compact('resi'));
    }

    /**
     * Tampilkan form pembuatan resi baru beserta data dropdown.
     *
     * @return \Illuminate\View\View View resi.create dengan data pelanggan, cabang, layanan.
     */
    public function create()
    {
        return view('resi.create', [
            'pelanggan' => Pelanggan::orderBy('nama')->get(),
            'cabang' => Cabang::orderBy('nama')->get(),
            'layanan' => Layanan::aktif()->orderBy('nama')->get(),
        ]);
    }

    /**
     * Simpan resi baru ke database melalui ResiService.
     *
     * @param  SimpanResiRequest                      $request Data tervalidasi dari form.
     * @return \Illuminate\Http\RedirectResponse               Redirect ke halaman detail resi.
     */
    public function store(SimpanResiRequest $request)
    {
        $resi = $this->resiService->buatResi($request->validated(), $request->user()->id);
        return redirect()->route('resi.show', $resi)
            ->with('sukses', "Resi {$resi->nomor_resi} berhasil dibuat.");
    }

    /**
     * Tampilkan detail satu resi beserta tracking log-nya.
     *
     * Menggunakan lazy eager loading untuk memuat semua relasi yang dibutuhkan view.
     *
     * @param  Resi                  $resi  Instance resi dari Route Model Binding.
     * @return \Illuminate\View\View        View resi.show.
     */
    public function show(Resi $resi)
    {
        $resi->load(['pelanggan', 'cabangAsal', 'cabangTujuan', 'layanan', 'user', 'trackingLog.user']);
        return view('resi.show', compact('resi'));
    }

    /**
     * Tampilkan form edit resi beserta data dropdown.
     *
     * @param  Resi                  $resi  Instance resi yang akan diedit.
     * @return \Illuminate\View\View        View resi.edit.
     */
    public function edit(Resi $resi)
    {
        return view('resi.edit', [
            'resi' => $resi,
            'pelanggan' => Pelanggan::orderBy('nama')->get(),
            'cabang' => Cabang::orderBy('nama')->get(),
            'layanan' => Layanan::aktif()->orderBy('nama')->get(),
        ]);
    }

    /**
     * Perbarui data resi yang sudah ada.
     *
     * @param  SimpanResiRequest                      $request Data tervalidasi.
     * @param  Resi                                   $resi    Instance resi yang diperbarui.
     * @return \Illuminate\Http\RedirectResponse               Redirect ke detail resi.
     */
    public function update(SimpanResiRequest $request, Resi $resi)
    {
        $resi->update($request->validated());
        return redirect()->route('resi.show', $resi)->with('sukses', 'Resi diperbarui.');
    }

    /**
     * Hapus resi dari database.
     *
     * @param  Resi                                   $resi  Instance resi yang akan dihapus.
     * @return \Illuminate\Http\RedirectResponse              Redirect kembali dengan pesan sukses.
     */
    public function destroy(Resi $resi)
    {
        $nomor = $resi->nomor_resi;
        $resi->delete();
        return back()->with('sukses', "Resi {$nomor} dihapus.");
    }
}