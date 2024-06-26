<?php

namespace App\Http\Controllers;

use App\Models\Ranking;
use App\Models\Criteria;
use App\Models\Alternative;
use App\Models\penilaiandua;
use App\Models\HasilPenilaian;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;


class MetodeDuaController extends Controller
{
    public function indexkriteria()
    {
        $user = auth()->user();

        $breadcrumb = (object)[
            'title' => 'Daftar Kriteria (Metode II)',
            'subtitle' => 'Data Kriteria',
        ];
        $criterias = Criteria::all(); // Mengambil semua data kegiatan dari model criteria

        return view('metode_dua_spk.kriteria.kriteriadestinasi2', ['breadcrumb' => $breadcrumb], compact('criterias'));
    }
    public function edit($id)
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Kriteria ',
            'subtitle' => 'Edit Kriteria',
        ];
        $criteria = Criteria::findOrFail($id);
        return view('metode_dua_spk.kriteria.kriteria_edit2', ['breadcrumb' => $breadcrumb], compact('criteria'));
    }

    // Menyimpan perubahan setelah edit

    public function updatekriteria(Request $request, $id)
    {
        $request->validate([
            'jenis' => 'required|in:benefit,cost',
            'bobot' => 'required|numeric|min:0',
        ]);

        $criteria = Criteria::findOrFail($id);

        // Hitung total bobot saat ini tanpa kriteria yang sedang diupdate
        $currentTotalBobot = Criteria::where('id', '!=', $id)->sum('bobot');

        // Hitung total bobot baru jika update sukses
        $newTotalBobot = $currentTotalBobot - $criteria->bobot + $request->bobot;

        // Periksa apakah total bobot baru melebihi 1
        if ($newTotalBobot > 1) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['bobot' => 'Total bobot should not exceed 1.']);
        }

        // Lakukan update hanya jika total bobot baru tidak melebihi 1
        $criteria->update([
            'jenis' => $request->jenis,
            'bobot' => $request->bobot,
        ]);

        return redirect()->route('kriteria')
            ->with('success', 'Criteria updated successfully');
    }




    // Calculate benefit value

    public function indexAlternatif()
    {
        $user = auth()->user();

        $breadcrumb = (object)[
            'title' => 'Daftar Alternatif (Metode II)',
            'subtitle' => 'Data Alternatif',
        ];
        $alternatives = Alternative::all(); // Mengambil semua data kegiatan dari model criteria

        return view('metode_dua_spk.alternatif.alternatifdestinasi2', ['breadcrumb' => $breadcrumb], compact('alternatives'));
    }

    public function editAlternative($id)
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Alternatif ',
            'subtitle' => 'Edit Alternatif',
        ];
        $alternatives = Alternative::findOrFail($id);
        return view('metode_dua_spk.alternatif.alternatif_edit2', ['breadcrumb' => $breadcrumb], compact('alternatives'));
    }

    public function updateAlternative(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'alternatif' => 'required|string|max:255',
        ]);

        // Find the existing alternative or fail
        $alternative = Alternative::findOrFail($id);

        // Update the alternative with the new data
        $alternative->update([
            'alternatif' => $request->input('alternatif'),
        ]);

        // Redirect back to the alternatives list with a success message
        return redirect()->route('alternatif')
            ->with('success', 'Alternative updated successfully');
    }


    public function indexPenilaian()
    {
        $user = auth()->user();
        $breadcrumb = (object)[
            'title' => 'Daftar Penilaian (Metode II)',
            'subtitle' => 'Data Penilaian',
        ];

        // Ambil data penilaian, alternatif, dan kriteria
        $penilaians = Penilaiandua::all();
        $alternatives = Alternative::all();
        $criterias = Criteria::all();

        // Persiapkan data untuk normalisasi dan perhitungan skor
        $data = [];
        foreach ($penilaians as $penilaian) {
            $data[] = [
                'alternative_id' => $penilaian->alternative_id,
                'criteria_id' => $penilaian->criteria_id,
                'tiket' => $penilaian->tiket,
                'fasilitas' => $penilaian->fasilitas,
                'kebersihan' => $penilaian->kebersihan,
                'keamanan' => $penilaian->keamanan,
                'akomodasi' => $penilaian->akomodasi,
            ];
        }

        Log::info('Data sebelum normalisasi:', $data);

        // Lakukan normalisasi dan perhitungan skor
        $normalizedData = $this->normalizeData($data, $criterias); // Kirim data dan kriteria sebagai argumen

        Log::info('Data setelah normalisasi:', $normalizedData);

        // Simpan data yang telah dinormalisasi ke dalam tabel hasil_penilaian
        HasilPenilaian::truncate(); // Hapus data lama
        foreach ($normalizedData as $normalizedItem) {
            HasilPenilaian::create($normalizedItem);
        }

        // Hitung ranking
        // $bobot_kriteria = [];
        // foreach ($criterias as $criteria) {
        //     $bobot_kriteria[$criteria->nama_kriteria] = $criteria->bobot;
        // }
        // $rankings = $this->calculateRanking($normalizedData, $bobot_kriteria);

        // Simpan ranking ke dalam tabel
        // Ranking::truncate(); // Hapus data lama
        // foreach ($rankings as $ranking) {
        //     Ranking::create([
        //         'alternative_id' => $ranking['alternative_id'],
        //         'criteria_id' => $ranking['criteria_id'],
        //         'score' => $ranking['score'],
        //     ]);
        // }

        return view('metode_dua_spk.penilaian.penilaiandestinasi2', compact('penilaians', 'breadcrumb','alternatives','criterias', 'normalizedData'));
    }

    public function editPenilaian($id)
    {
        $penilaian = penilaiandua::findOrFail($id);
        $alternative = Alternative::all();
        $criterias = Criteria::all();

        $breadcrumb = (object)[
            'title' => 'Edit Penilaian',
            'subtitle' => 'Perbarui Data Penilaian',
        ];

        return view('metode_dua_spk.penilaian.penilaian_edit2', compact('penilaian', 'alternative', 'criterias', 'breadcrumb'));
    }
    public function updatePenilaian(Request $request, $id)
    {
        $request->validate([
            'alternative_id' => 'required|exists:alternative,id',
            'criteria_id' => 'exists:criterias,id',
            'tiket' => 'required|numeric',
            'fasilitas' => 'required|numeric',
            'kebersihan' => 'required|numeric',
            'keamanan' => 'required|numeric',
            'akomodasi' => 'required|numeric',
        ]);


        $penilaian = penilaiandua::findOrFail($id);
        $penilaian->update([
            'alternative_id' => $request->alternative_id,
            'criteria_id' => $request->criteria_id,
            'tiket' => $request->tiket,
            'fasilitas' => $request->fasilitas,
            'kebersihan' => $request->kebersihan,
            'keamanan' => $request->keamanan,
            'akomodasi' => $request->akomodasi,
        ]);

        return redirect()->route('penilaian')->with('success', 'Penilaian berhasil diperbarui');
    }

    private function normalizeData($data, $criterias)
    {
        $maxValues = [];
        $minValues = [];

        foreach ($criterias as $criteria) {
            $kriteria = $criteria->kriteria;
            $values = array_column($data, $kriteria);

            if (!empty($values)) {
                $maxValues[$kriteria] = max($values);
                $minValues[$kriteria] = min($values);
            } else {
                $maxValues[$kriteria] = null;
                $minValues[$kriteria] = null;
            }
        }

        Log::info('Max Values:', $maxValues);
        Log::info('Min Values:', $minValues);

        $normalizedData = [];

        foreach ($data as $item) {
            $normalizedItem = [
                'alternative_id' => $item['alternative_id'],
                'criteria_id' => $item['criteria_id'],
                'tiket' => isset($item['tiket']) ? $item['tiket'] : 0, // Default value jika tiket tidak terdefinisi
                'fasilitas' => isset($item['fasilitas']) ? $item['fasilitas'] : 0,
                'kebersihan' => isset($item['kebersihan']) ? $item['kebersihan'] : 0,
                'keamanan' => isset($item['keamanan']) ? $item['keamanan'] : 0,
                'akomodasi' => isset($item['akomodasi']) ? $item['akomodasi'] : 0, // Default value jika akomodasi tidak terdefinisi
            ];

            foreach ($criterias as $criteria) {
                $kriteria = $criteria->kriteria;
                if (isset($item[$kriteria]) && $maxValues[$kriteria] !== null && $minValues[$kriteria] !== null) {
                    if ($criteria->type == 'benefit') {
                        $normalizedItem[$kriteria] = ($item[$kriteria] - $minValues[$kriteria]) / ($maxValues[$kriteria] - $minValues[$kriteria]);
                    } else {
                        $normalizedItem[$kriteria] = ($maxValues[$kriteria] - $item[$kriteria]) / ($maxValues[$kriteria] - $minValues[$kriteria]);
                    }
                }
            }

            Log::info('Normalized Item:', $normalizedItem);

            $normalizedData[] = $normalizedItem;
        }

        return $normalizedData;
    }


    public function indexRanking()
{
    $breadcrumb = (object)[
        'title' => 'Daftar Kriteria (Metode II)',
        'subtitle' => 'Data Ranking',
    ];
    $normalizedData = HasilPenilaian::all()->toArray(); // Isi dengan data yang sesuai dari perhitungan ranking
    $bobot_kriteria = Criteria::pluck('bobot', 'id')->toArray(); // Isi dengan bobot kriteria yang sesuai
    $alternatives = Alternative::all();

    $rankingScores = $this->calculateRanking($normalizedData, $bobot_kriteria);

    Ranking::truncate();
    foreach ($rankingScores as $ranking) {
        Ranking::create([
            'alternative_id' => $ranking['alternative_id'],
            // 'criteria_id' => $ranking['criteria_id'],
            'score' => $ranking['score']
        ]);
    }

    return view('metode_dua_spk.ranking.rankingdestinasi2', compact('rankingScores','breadcrumb', 'alternatives'));
}

private function calculateRanking($normalizedData, $bobot_kriteria)
         {
        $rankingScores = [];

    // Ambil bobot kriteria dari tabel 'criteria'
    $criteriaWeights = Criteria::pluck('bobot', 'id')->toArray();

    foreach ($normalizedData as $data) {
        if (!isset($rankingScores[$data['alternative_id']])) {
            $rankingScores[$data['alternative_id']] = [
                'alternative_id' => $data['alternative_id'],
                'score' => 0,
            ];
        }
        $rankingScores[$data['alternative_id']]['score'] += ($data['tiket']) * ($criteriaWeights['1']) +
        ($data['fasilitas']) * ($criteriaWeights['2']) +
        ($data['kebersihan']) * ($criteriaWeights['3']) +
        ($data['keamanan']) * ($criteriaWeights['4']) +
        ($data['akomodasi']) * ($criteriaWeights['5']);
    }
    usort($rankingScores, function($a, $b) {
        return $b['score'] <=> $a['score'];
    });

    return $rankingScores;
}

}
