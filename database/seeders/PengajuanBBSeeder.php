<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PengajuanBBSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $pengajuan_bb = collect([
        //     [

        //         'id_pengajuan_bb' => 1,
        //         'manajemen' => '123456789123456789',
        //         'kaprog' => '123456789153456789',
        //         'nama_barang' => 'Laptop Lenovo',
        //         'spesifikasi' => 'Lorem Ipsum',
        //         'harga_satuan' => '5.000.000',
        //         'total_harga' => '250.000.000',
        //         'jumlah' => 50,
        //         'tgl' => Carbon::parse('2000-01-01'),
        //         'ruangan' => 'D1',
        //         'status_approval' => 'setuju',
        //         'tgl_approve' => Carbon::parse('2000-01-01'),
        //         'status_pembelian' => NULL,
        //     ],
        //     [

        //         'id_pengajuan_bb' => 2,
        //         'manajemen' => '123456789123456789',
        //         'kaprog' => '123456789153456789',
        //         'nama_barang' => 'Meja',
        //         'spesifikasi' => 'Lorem Ipsum',
        //         'harga_satuan' => '5.000.000',
        //         'total_harga' => '50.000.000',
        //         'jumlah' => 10,
        //         'tgl' => Carbon::parse('2000-01-01'),
        //         'ruangan' => 'D1',
        //         'status_approval' => 'setuju',
        //         'tgl_approve' => Carbon::parse('2000-01-01'),
        //         'status_pembelian' => NULL,
        //     ]
        // ]);
        // $pengajuan_bb->each(fn ($m) => DB::table('pengajuan_bb')->insert($m));
    }
}
