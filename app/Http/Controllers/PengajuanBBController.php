<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;


class PengajuanBBController extends Controller
{
    public function index(){

        // data pending manajemen
        $pending = DB::select('SELECT * FROM pengajuan_bb WHERE status_approval = "pending" ');

        // KAPROG
        $data = DB::select('SELECT * FROM pengajuan_bb');


        return view('pengajuan.barang_baru.index', compact('data', 'pending'));
    }

    private function getManajemen(): Collection
    {
        return collect(DB::select('SELECT * FROM manajemen'));
    }

    private function getKaprog(): Collection
    {
        return collect(DB::select('SELECT * FROM kaprog'));
    }

    public function formTambah(){
        $kaprog = DB::table('pengguna_kaprog')
        ->select('nama')
        ->where('username',Auth::user()->username)
        ->get();
        $array = Arr::pluck($kaprog, 'nama');
        $kode_baru = Arr::get($array, '0');

        $manajemen = $this->getManajemen();
        $kaprog = $this->getKaprog();
        return view('pengajuan.barang_baru.formtambah', compact('manajemen', 'kaprog', 'kode_baru'));
    }

    private function getPengajuanBb($id)
    {
        return collect(DB::select('SELECT * FROM pengajuan_bb WHERE id_pengajuan_bb = ?', [$id]))->firstOrFail();
    }

    public function store(Request $request)
    {
        try {

        $tambah_pengajuan_bb = DB::insert("CALL tambah_pengajuan_bb(:manajemen, :kaprog, :nama_barang, :spesifikasi, :harga_satuan, :total_harga, :jumlah, :ruangan)", [
            'manajemen' => $request->input('manajemen'),
            'kaprog' => $request->input('kaprog'),
            'nama_barang' => $request->input('nama_barang'),
            'spesifikasi' => $request->input('spesifikasi'),
            'harga_satuan' => $request->input('harga_satuan'),
            'total_harga' => $request->input('total_harga'),
            'jumlah' => $request->input('jumlah'),
            'ruangan' => $request->input('ruangan'),

            // dd($request->all())
        ]);

        if ($tambah_pengajuan_bb)
            return redirect('pengajuan/BB');
        else
            return "input data gagal";
        } catch (\Exception $e) {
        return  $e->getMessage();
        }
    }

    public function edit($id = null)
    {

        $edit = $this->getPengajuanBb($id);

        return view('pengajuan.barang_baru.editform', compact('edit'));
    }

    public function detail($id = null)
    {

        $detail = $this->getPengajuanBb($id);
        return view('pengajuan.barang_baru.detail', compact('detail'));
    }


    public function editsimpan(Request $request)
    {
        try {
            $data = [
                'nama_barang' => $request->input('nama_barang'),
                'spesifikasi' => $request->input('spesifikasi'),
                'harga_satuan' => $request->input('harga_satuan'),
                'total_harga' => $request->input('total_harga'),
                'jumlah' => $request->input('jumlah')
            ];
            $upd = DB::table('pengajuan_bb')
                        ->where('id_pengajuan_bb', '=', $request->input('id_pengajuan_bb'))
                        ->update($data);
            if($upd){
                return redirect('pengajuan/BB');
            }
            // dd("berhasil", $upd);
        } catch (\Exception $e) {
            return $e->getMessage();
            dd("gagal");
        }
    }

    public function hapus($id=null){
        // delete yg pending
        try{
            $hapus = DB::table('pengajuan_bb')
                            ->where('id_pengajuan_bb',$id, 'AND status_approval = "pending" ')
                            ->delete();
            if($hapus){
                return redirect('pengajuan/BB');
            }
        }catch(\Exception $e){
            $e->getMessage();
        }
    }



    // APPROVAL
    public function statusSetuju($id=null){
        try{

            $manajemen = DB::table('pengguna_manajemen')
                ->select('nama')
                ->where('username',Auth::user()->username)
                ->get();
                $array = Arr::pluck($manajemen, 'nama');
                $kode_lama = Arr::get($array, '0');

            $x = DB::table('manajemen')
                ->select('nip')
                ->where('nama', $kode_lama)
                ->get();
                $array = Arr::pluck($x, 'nip');
                $kode_baru = Arr::get($array, '0');

            // dd($kode_baru);

            $status = [
                'manajemen'=>$kode_baru,
                'status_approval' => ('setuju'),
                'tgl_approve' => NOW()
            ];
            $hapus = DB::table('pengajuan_bb')
                            ->where('id_pengajuan_bb',$id)
                            ->update($status);
            if($hapus){
                return redirect('pengajuan/BB');
            }
        }catch(\Exception $e){
            $e->getMessage();
        }
    }
    public function statusTidakSetuju($id=null){
        try{

            $manajemen = DB::table('pengguna_manajemen')
                ->select('nama')
                ->where('username',Auth::user()->username)
                ->get();
                $array = Arr::pluck($manajemen, 'nama');
                $kode_lama = Arr::get($array, '0');

            $x = DB::table('manajemen')
                ->select('nip')
                ->where('nama', $kode_lama)
                ->get();
                $array = Arr::pluck($x, 'nip');
                $kode_baru = Arr::get($array, '0');

            // dd($kode_baru);

            $status = [
                'manajemen'=>$kode_baru,
                'status_approval' => ('tidak')
            ];
            $hapus = DB::table('pengajuan_bb')
                            ->where('id_pengajuan_bb',$id)
                            ->update($status);
            if($hapus){
                return redirect('pengajuan/BB');
            }
        }catch(\Exception $e){
            $e->getMessage();
        }
    }
}