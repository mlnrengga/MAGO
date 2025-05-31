<?php

namespace App\Filament\Widgets;

use App\Models\Reference\PerusahaanModel;
use App\Models\Reference\ProvinsiModel;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\DB;

class AdminTopPerusahaanMagangTable extends BaseWidget
{
    protected static ?int $sort = 3; // Urutkan widget setelah chart-chart
    protected int|string|array $columnSpan = 'full';
    protected static ?string $heading = 'Top Perusahaan Magang Paling Diminati';

    public function table(Table $table): Table
    {
        // Buat query dengan selectSub untuk mengatasi masalah aggregate columns
        $query = PerusahaanModel::query()
            ->select([
                'm_perusahaan.id_perusahaan',
                'm_perusahaan.nama',
                'm_perusahaan.alamat',
            ])
            // Subquery untuk jumlah mahasiswa magang
            ->selectSub(function($query) {
                $query->selectRaw('COUNT(DISTINCT pm.id_penempatan)')
                    ->from('t_penempatan_magang as pm')
                    ->join('t_pengajuan_magang as pj', 'pm.id_pengajuan', '=', 'pj.id_pengajuan')
                    ->join('t_lowongan_magang as lm', 'pj.id_lowongan', '=', 'lm.id_lowongan')
                    ->whereColumn('lm.id_perusahaan', 'm_perusahaan.id_perusahaan');
            }, 'jumlah_mahasiswa_magang')
            // Subquery untuk jumlah lowongan
            ->selectSub(function($query) {
                $query->selectRaw('COUNT(DISTINCT lm.id_lowongan)')
                    ->from('t_lowongan_magang as lm')
                    ->whereColumn('lm.id_perusahaan', 'm_perusahaan.id_perusahaan');
            }, 'jumlah_lowongan')
            // Subquery untuk bidang keahlian
            ->selectSub(function($query) {
                $query->selectRaw('GROUP_CONCAT(DISTINCT bk.nama_bidang_keahlian SEPARATOR ", ")')
                    ->from('t_lowongan_magang as lm')
                    ->join('r_lowongan_bidang as lb', 'lm.id_lowongan', '=', 'lb.id_lowongan')
                    ->join('m_bidang_keahlian as bk', 'lb.id_bidang', '=', 'bk.id_bidang')
                    ->whereColumn('lm.id_perusahaan', 'm_perusahaan.id_perusahaan');
            }, 'bidang_keahlian');

        // Join untuk mendapatkan data daerah dan provinsi
        // Gunakan join khusus ke satu lowongan per perusahaan untuk menghindari duplikasi
        $query->leftJoinSub(
            DB::table('t_lowongan_magang')
                ->select('id_perusahaan', 'id_daerah_magang')
                ->distinct(),
            'lowongan',
            function($join) {
                $join->on('m_perusahaan.id_perusahaan', '=', 'lowongan.id_perusahaan');
            }
        )
        ->leftJoin('m_daerah_magang as dm', 'lowongan.id_daerah_magang', '=', 'dm.id_daerah_magang')
        ->leftJoin('m_provinsi as pr', 'dm.id_provinsi', '=', 'pr.id_provinsi')
        ->addSelect([
            'dm.nama_daerah',
            'dm.jenis_daerah',
            'pr.nama_provinsi',
            'pr.id_provinsi'
        ]);

        return $table
            ->query($query)
            ->columns([
                Tables\Columns\TextColumn::make('iteration')
                    ->label('#')
                    ->rowIndex()
                    ->alignCenter()
                    ->badge()
                    ->color(function ($state) {
                        return match ((int)$state) {
                            1 => 'warning',
                            2 => 'gray',
                            3 => 'danger',
                            default => 'primary',
                        };
                    })
                    ->formatStateUsing(function ($state) {
                        return match ((int)$state) {
                            1 => '🥇 1',
                            2 => '🥈 2',
                            3 => '🥉 3',
                            default => $state,
                        };
                    })
                    ->weight('bold')
                    ->size('lg'),

                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Perusahaan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->wrap(),
                
                Tables\Columns\TextColumn::make('bidang_keahlian')
                    ->label('Bidang Keahlian')
                    ->wrap(),
                
                Tables\Columns\TextColumn::make('jumlah_mahasiswa_magang')
                    ->label('Jumlah Mahasiswa')
                    ->sortable()
                    ->alignCenter()
                    ->badge()
                    ->color('success'),
                
                Tables\Columns\TextColumn::make('jumlah_lowongan')
                    ->label('Jumlah Lowongan')
                    ->sortable()
                    ->alignCenter()
                    ->badge()
                    ->color('info'),
                    
                Tables\Columns\TextColumn::make('nama_daerah')
                    ->label('Daerah')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('jenis_daerah')
                    ->label('Kota')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('nama_provinsi')
                    ->label('Provinsi')
                    ->searchable()
                    ->sortable(),
            ])
            ->striped()
            ->filters([
                SelectFilter::make('id_provinsi')
                ->label('Provinsi')
                ->options(
                    ProvinsiModel::pluck('nama_provinsi', 'id_provinsi')->toArray()
                )
                ->attribute('pr.id_provinsi')
                ->multiple(),

                SelectFilter::make('jenis_daerah')
                ->label('Jenis Daerah')
                ->options([
                    'Kota' => 'Kota',
                    'Kabupaten' => 'Kabupaten'
                ]),
            ])
            ->defaultSort('jumlah_mahasiswa_magang', 'desc')
            ->paginated([5, 10, 25, 50, 'all']);
    }
}
