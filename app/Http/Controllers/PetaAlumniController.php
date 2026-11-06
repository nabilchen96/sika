<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use RuntimeException;

class PetaAlumniController extends Controller
{
    private const PROGRAMS = [
        'D-IV Teknologi Rekayasa Bandar Udara',
        'D-III Penyelamatan dan Pemadam Kebakaran Penerbangan',
        'D-III Manajemen Bandar Udara',
    ];

    public function index()
    {
        return view('peta-alumni.map');
    }

    public function data()
    {
        $groups = [];
        foreach ($this->records() as $row) {
            $key = json_encode([strtolower($row['province']), strtolower($row['city'])]);
            if (!isset($groups[$key])) {
                $groups[$key] = array_intersect_key($row, array_flip(['province', 'city', 'lat', 'lng']));
                $groups[$key]['counts'] = [];
            }
            $program = $row['program'];
            $groups[$key]['counts'][$program] = ($groups[$key]['counts'][$program] ?? 0) + 1;
        }

        return response()->json(['programs' => self::PROGRAMS, 'locations' => array_values($groups)])
            ->header('Cache-Control', 'no-cache');
    }

    public function admin()
    {
        return response()->view('peta-alumni.admin', [
            'rows' => $this->records(),
            'programs' => self::PROGRAMS,
        ])->header('Cache-Control', 'private, no-store');
    }

    public function store(Request $request)
    {
        $row = $request->validate([
            'name' => 'required|string|max:120',
            'work' => 'required|string|max:120',
            'province' => 'required|string|max:120',
            'city' => 'required|string|max:120',
            'program' => ['required', Rule::in(self::PROGRAMS)],
            'lat' => 'required|numeric|between:-90,90',
            'lng' => 'required|numeric|between:-180,180',
        ]);
        $row['lat'] = (float) $row['lat'];
        $row['lng'] = (float) $row['lng'];

        $path = $this->dataPath();
        $lock = fopen($path . '.lock', 'c');
        if ($lock === false) {
            throw new RuntimeException('Penyimpanan peta alumni tidak tersedia.');
        }

        $temp = false;
        try {
            if (!flock($lock, LOCK_EX)) {
                throw new RuntimeException('Penyimpanan peta alumni tidak dapat dikunci.');
            }
            $rows = $this->records();
            $rows[] = $row;
            $json = json_encode($rows, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            $temp = tempnam(dirname($path), 'peta-alumni-');
            if ($json === false || $temp === false || file_put_contents($temp, $json) !== strlen($json) || !rename($temp, $path)) {
                throw new RuntimeException('Data peta alumni gagal disimpan.');
            }
        } finally {
            if ($temp !== false && is_file($temp)) {
                unlink($temp);
            }
            fclose($lock);
        }

        return redirect()->route('peta-alumni.admin')->with('status', 'Data alumni berhasil disimpan.');
    }

    private function dataPath()
    {
        return storage_path('app/peta-alumni.json');
    }

    private function records()
    {
        $path = $this->dataPath();
        if (!is_file($path)) {
            return [];
        }
        $json = file_get_contents($path);
        $rows = $json === false ? null : json_decode($json, true);
        if (!is_array($rows)) {
            throw new RuntimeException('File peta alumni tidak dapat dibaca.');
        }

        return $rows;
    }
}
