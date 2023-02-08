<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
// use Termwind\Components\Dd;

class BarangMasukController extends Controller
{

    public function index(){
        $data = DB::table('data_barang_masuk')->get();
        // dd($data);
        $info = DB::table('pengajuan_bb')->leftJoin('ruangan', 'pengajuan_bb.ruangan', '=', 'ruangan.id_ruangan')->get();
        $jenisBarang = DB::table('jenis_barang')->get();
        $approved = DB::table('pengajuan_bb')->where('status_approval','setuju')->paginate(5);


        return view('barangMasuk.index', compact('data', 'info', 'approved', 'jenisBarang'));
    }

    public function searchPengajuan(Request $request){
        $search = $request->input('search');

        $data = DB::table('barang_masuk')->get();
        $info = DB::table('pengajuan_bb')->leftJoin('ruangan', 'pengajuan_bb.ruangan', '=', 'ruangan.id_ruangan')->get();
        $approved = DB::table('pengajuan_bb')
                ->where('status_approval','setuju')
                ->where('nama_barang','like',"%".$search."%")
                ->orWhere('jumlah','like',"%".$search."%")
                ->paginate(5, ['*'], 'approved');
        $jenisBarang = DB::table('jenis_barang')
                ->paginate(5, ['*'], 'jenisBarang');

        return view('barangMasuk.index', compact('data', 'info', 'approved', 'jenisBarang'));
    }

    public function searchBarangMasuk(Request $request){
        $search = $request->input('search');

        $data = DB::table('barang_masuk')
                ->where('nama_barang','like',"%".$search."%")
                ->orWhere('tgl_masuk','like',"%".$search."%")
                ->orWhere('jml_masuk','like',"%".$search."%")
                ->orWhere('status_pembelian','like',"%".$search."%")
                ->get();
        $info = DB::table('pengajuan_bb')->get();
        $approved = DB::table('pengajuan_bb')->where('status_approval','setuju')->paginate(5, ['*'], 'approved');
        $jenisBarang = DB::table('jenis_barang')->paginate(5, ['*'], 'jenisBarang');

        return view('barangMasuk.index', compact('data', 'info', 'approved', 'jenisBarang'));
    }


    public function getJumlahPengajuan(){
        $data = DB::select('SELECT COUNT(id_pengajuan_bb) AS jumlah FROM pengajuan_bb WHERE status_approval = "setuju"');
        return view('partials.sidebar', compact('data'));
    }

    private function getJenisBarang(): Collection
    {
        return collect(DB::select('SELECT * FROM jenis_barang'));
    }

    private function getSupplier(): Collection
    {
        return collect(DB::select('SELECT * FROM supplier'));
    }

    private function getPengajuanBb($id)
    {
        return collect(DB::select('SELECT * FROM pengajuan_bb WHERE id_pengajuan_bb = ? AND status_approval = "setuju" ', [$id]))->firstOrFail();
    }

    public function formTambah($id = null)
    {
        // dd($id);
        // $manajemen = DB::table('pengguna_manajemen')
        // ->select('nama')
        // ->where('username',Auth::user()->username)
        // ->get();
        // $array = Arr::pluck($manajemen, 'nama');
        // $kode_baru = Arr::get($array, '0');
        $adder = Auth::user()->username;
        $tambah = $this->getPengajuanBb($id);
        $jenisBarang = $this->getJenisBarang();
        $supplier = $this->getSupplier();

        // SISA PENGAJUAN
        $x= (DB::select('SELECT SUM(jml_masuk) AS jml FROM barang_masuk WHERE id_pengajuan = ' .$tambah->id_pengajuan_bb));
        $array = Arr::pluck($x, 'jml');
        $jml_masuk = Arr::get($array, '0');
        $jml_pengajuan = $tambah->jumlah;
        $max_input = $jml_pengajuan - $jml_masuk;
        // dd($tambah);
        // dd($jenisBarang);
        // dd($kode_baru);
        return view('barangMasuk.formtambah', compact('jenisBarang', 'supplier', 'tambah', 'adder', 'max_input'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'mimes:jpeg,jpg,png'
        ],
        [
            'image.mimes' => 'File harus bertipe: jpeg, jpg, png!',
        ]);
        try {
        $image = $request->file('image')->store('barang');

            // dd($request->all());
        $tambahBarangMasuk = DB::insert("CALL tambah_barangmasuk( :nama_barang, :jml_barang, :spesifikasi, :kondisi_barang, :supplier, :adder, :jenis_barang, :foto_barang, :ruangan)", [

            'nama_barang' => $request->input('nama_barang'),
            'jml_barang' => $request->input('jml_barang'),
            'spesifikasi' => $request->input('spesifikasi'),
            'kondisi_barang' => ('baik'),
            'supplier' => $request->input('supplier'),
            'adder' => $request->input('adder'),
            'jenis_barang' => $request->input('jenis_barang'),
            'foto_barang' => $image,
            'ruangan' => $request->input('ruangan'),
            // dd($request->all())
        ]);
            // dd($tambahBarangMasuk);

        if ($tambahBarangMasuk){
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'top-center',
            ])->addSuccess('Barang Berhasil Masuk.');
            return redirect('barangMasuk');
        }else
            return "input data gagal";
        } catch (\Exception $e) {
        return  $e->getMessage();
        }
    }

    // public function storeLangsung(Request $request)
    // {
    //     try {

    //         $i = 1;

    //     $tambahBarangMasuk = DB::table('barang_masuk')->insert([
    //         'manajemen' => $request->input('manajemen'),
    //         'nama_barang' => $request->input('nama_barang'),
    //         'jml_masuk' => $request->input('jml_masuk'),
    //         'tgl_masuk' => $request->input('tgl_masuk'),
    //         'manajemen' => $request->input('manajemen')
    //     ]);
    //     $tambahBarang = DB::table('barang')->insert([
    //         // 'id_jenis_brg' => $request->input('jenis'),
    //         'nama_barang' => $request->input('nama_barang'),
    //         'jml_barang' => $request->input('jml_masuk')
    //     ]);

    //     $a = DB::select('SELECT LPAD("a","a")');
    //     dd($a);
    //     while($i <= $request->input('jml_masuk')){


    //         DB::table('detail_barang')->insert([
    //             'manajemen' => $request->input('manajemen'),
    //             'nama_barang' => $request->input('nama_barang'),
    //             'jml_masuk' => $request->input('jml_masuk'),
    //             'tgl_masuk' => $request->input('tgl_masuk'),
    //             'manajemen' => $request->input('manajemen')
    //         ]);

    //         $i++;
    //     }

    //         // dd($tambahBarangMasuk);

    //     if ($tambahBarangMasuk)
    //         return redirect('barangMasuk');
    //     else
    //         return "input data gagal";
    //     } catch (\Exception $e) {
    //     return  $e->getMessage();
    //     }
    // }
}
