<?php

namespace App\Http\Controllers;

use App\Models\Silsilah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SilsilahController extends Controller
{
    public function index()
    {
        // 1. Ambil semua kandidat root (yang tidak punya ayah DAN ibu)
        $allPotentialRoots = Silsilah::with(['pasangan', 'anak'])
            ->whereNull('ayah_id')
            ->whereNull('ibu_id')
            ->get();

        // 2. Filter agar benar-benar hanya 'Akar' asli yang tampil
        $processedIds = [];
        $roots = $allPotentialRoots->filter(function ($person) use (&$processedIds) {
            // Jika ID ini sudah pernah diproses sebagai pasangan dari root sebelumnya, skip.
            if (in_array($person->id, $processedIds)) {
                return false;
            }

            /**
             * LOGIKA KUNCI:
             * Kita harus mengecek apakah pasangan dari orang ini punya orang tua.
             * Jika pasangannya punya orang tua, berarti orang ini "ikut" ke silsilah pasangannya.
             * Jadi dia bukan ROOT utama.
             */
            if ($person->pasangan) {
                if (!is_null($person->pasangan->ayah_id) || !is_null($person->pasangan->ibu_id)) {
                    return false;
                }
                // Tandai pasangannya agar tidak muncul sebagai kartu root terpisah
                $processedIds[] = $person->pasangan_id;
            }

            $processedIds[] = $person->id;
            return true;
        });

        return view('silsilah.index', compact('roots'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jenis_kelamin' => 'required|in:L,P',
            'tgl_lahir' => 'nullable|date',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->only([
            'nama',
            'jenis_kelamin',
            'tgl_lahir',
            'status',
            'tgl_meninggal',
            'alamat'
        ]);

        // SIMPAN FOTO (JIKA ADA)
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('silsilah', 'public');
        }

        Silsilah::create($data);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }


    public function tambahOrangTua(Request $request, $anakId)
    {
        $anak = Silsilah::findOrFail($anakId);

        DB::transaction(function () use ($request, $anak) {
            // Data Ayah
            $ayahData = [
                'nama' => $request->nama_ayah,
                'jenis_kelamin' => 'L',
                'tgl_lahir' => $request->tgl_lahir_ayah,
                'status' => $request->status_ayah,
                'tgl_meninggal' => $request->tgl_meninggal_ayah,
            ];
            if ($request->hasFile('foto_ayah')) {
                $ayahData['foto'] = $request->file('foto_ayah')->store('silsilah', 'public');
            }
            $ayah = Silsilah::create($ayahData);

            // Data Ibu
            $ibuData = [
                'nama' => $request->nama_ibu,
                'jenis_kelamin' => 'P',
                'tgl_lahir' => $request->tgl_lahir_ibu,
                'status' => $request->status_ibu,
                'tgl_meninggal' => $request->tgl_meninggal_ibu,
                'pasangan_id' => $ayah->id
            ];
            if ($request->hasFile('foto_ibu')) {
                $ibuData['foto'] = $request->file('foto_ibu')->store('silsilah', 'public');
            }
            $ibu = Silsilah::create($ibuData);

            // Update Relasi
            $ayah->update(['pasangan_id' => $ibu->id]);
            $anak->update([
                'ayah_id' => $ayah->id,
                'ibu_id' => $ibu->id
            ]);
        });

        return redirect()->back()->with('success', 'Orang tua berhasil ditambahkan');
    }

    public function tambahPasangan(Request $request, $id)
    {
        $orang = Silsilah::findOrFail($id);

        DB::transaction(function () use ($request, $orang) {
            $jkPasangan = $orang->jenis_kelamin === 'L' ? 'P' : 'L';

            $data = [
                'nama' => $request->nama,
                'jenis_kelamin' => $jkPasangan,
                'tgl_lahir' => $request->tgl_lahir,
                'status' => $request->status,
                'tgl_meninggal' => $request->tgl_meninggal,
                'alamat' => $request->alamat,
                'pasangan_id' => $orang->id
            ];

            if ($request->hasFile('foto')) {
                $data['foto'] = $request->file('foto')->store('silsilah', 'public');
            }

            $pasangan = Silsilah::create($data);
            $orang->update(['pasangan_id' => $pasangan->id]);
        });

        return redirect()->back()->with('success', 'Pasangan berhasil ditambahkan');
    }

    public function tambahAnak(Request $request, $id)
    {

        $orang = Silsilah::findOrFail($id);

        DB::transaction(function () use ($request, $orang) {
            $ayahId = $orang->jenis_kelamin === 'L' ? $orang->id : $orang->pasangan_id;
            $ibuId = $orang->jenis_kelamin === 'P' ? $orang->id : $orang->pasangan_id;

            if (!$orang->pasangan_id) {
                $jkPasangan = $orang->jenis_kelamin === 'L' ? 'P' : 'L';
                $pasangan = Silsilah::create([
                    'nama' => 'Pasangan dari ' . $orang->nama,
                    'jenis_kelamin' => $jkPasangan,
                    'tgl_lahir' => null,
                    'pasangan_id' => $orang->id
                ]);

                $orang->update(['pasangan_id' => $pasangan->id]);

                $ayahId = $orang->jenis_kelamin === 'L' ? $orang->id : $pasangan->id;
                $ibuId = $orang->jenis_kelamin === 'P' ? $orang->id : $pasangan->id;
            }

            $data = [
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tgl_lahir' => $request->tgl_lahir,
                'status' => $request->status,
                'tgl_meninggal' => $request->tgl_meninggal,
                'alamat' => $request->alamat,
                'ayah_id' => $ayahId,
                'ibu_id' => $ibuId
            ];

            if ($request->hasFile('foto')) {
                $data['foto'] = $request->file('foto')->store('silsilah', 'public');
            }

            Silsilah::create($data);
        });

        return redirect()->back()->with('success', 'Anak berhasil ditambahkan');
    }

    public function show($id)
    {
        $person = Silsilah::with(['pasangan', 'ayah', 'ibu', 'anak'])->findOrFail($id);
        return view('silsilah.show', compact('person'));
    }

    public function update(Request $request, $id)
    {
        $person = Silsilah::findOrFail($id);

        $data = $request->only([
            'nama',
            'jenis_kelamin',
            'tgl_lahir',
            'status',
            'tgl_meninggal',
            'alamat'
        ]);

        if ($request->hasFile('foto')) {
            // HAPUS FOTO LAMA (JIKA ADA)
            if ($person->foto && Storage::disk('public')->exists($person->foto)) {
                Storage::disk('public')->delete($person->foto);
            }

            // SIMPAN FOTO BARU
            $data['foto'] = $request->file('foto')->store('silsilah', 'public');
        }

        $person->update($data);

        return redirect()->back()->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $person = Silsilah::findOrFail($id);

        // HAPUS FOTO JIKA ADA
        if ($person->foto && Storage::disk('public')->exists($person->foto)) {
            Storage::disk('public')->delete($person->foto);
        }

        // PUTUSKAN RELASI PASANGAN
        Silsilah::where('pasangan_id', $id)->update(['pasangan_id' => null]);

        $person->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
