<?php

namespace App\Filament\Mahasiswa\Resources\ManajemenAktivitasMagangHarianResource\Pages;

use App\Filament\Mahasiswa\Resources\ManajemenAktivitasMagangHarianResource;
use App\Filament\Widgets\MahasiswaPilihPenempatanMagang;
use App\Models\Reference\PenempatanMagangModel;
use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ListManajemenAktivitasMagangHarians extends ListRecords
{
    protected static string $resource = ManajemenAktivitasMagangHarianResource::class;

    protected function getHeaderActions(): array
    {
        $actions = [];

        if(!request('penempatanId')){
            // action untuk dropdown pilih lowongan
            $actions = [
                Actions\Action::make('pilih_lowongan')
                    ->label('Pilih Lowongan')
                    ->icon('heroicon-s-building-office-2')
                    ->button()
                    ->color(request('penempatanId') ? 'gray' : 'primary')
                    ->extraAttributes([
                        'class' => request('penempatanId') ? '' : 'animate-bounce',
                    ])
                    ->form([
                        Select::make('lowongan_id')
                            ->label('Lowongan Magang')
                            ->options(function () {
                                // Dapatkan ID mahasiswa yang login
                                $user = Auth::user();
                                $mahasiswaId = $user->mahasiswa->id_mahasiswa;
                                
                                // Dapatkan data penempatan dan dikelompokkan berdasarkan lowongan
                                $options = [];
                                $penempatans = PenempatanMagangModel::where('id_mahasiswa', $mahasiswaId)
                                    ->with('pengajuan.lowongan')
                                    ->get();
                                
                                foreach ($penempatans as $penempatan) {
                                    if ($penempatan->pengajuan && $penempatan->pengajuan->lowongan) {
                                        $lowonganJudul = $penempatan->pengajuan->lowongan->judul_lowongan;
                                        $options[$penempatan->id_penempatan] = $lowonganJudul;
                                    }
                                }
                                
                                return $options;
                            })
                            ->searchable()
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        // Redirect ke halaman yang sama, tetapi dengan parameter penempatanIdnya untuk memfilter data
                        $this->redirect(
                            $this->getResource()::getUrl('index', ['penempatanId' => $data['lowongan_id']])
                        );
                    }),
            ];
        }else {
            $actions[] = Actions\Action::make('reset')
                ->label('Reset Pilihan')
                ->icon('heroicon-s-x-mark')
                ->color('danger')
                ->url(url()->current());
                
            $actions[] = Actions\CreateAction::make()
                // ->mutateFormDataUsing(function ($data) {
                //     $data['id_penempatan'] = request('penempatanId');
                //     return $data;
                // });
                ->label('Tambah Aktivitas')
                ->icon('heroicon-s-plus')
                ->url(fn (): string => 
                    $this->getResource()::getUrl('create', ['penempatanId' => request('penempatanId')])
                );
        }
        
        return $actions;
    }

    // public function table(Table $table): Table
    // {
    //     return $table
    //         ->modifyQueryUsing(function (Builder $query) {
    //             if ($penempatanId = request('penempatanId')) {
    //                 $query->where('id_penempatan', $penempatanId);

    //                 $query->orderBy('tanggal_log', 'desc');
    //             } else {
    //                 // Jika belum ada penempatan yang dipilih, jangan tampilkan data apapun
    //                 $query->whereRaw('1 = 0');
    //             }
    //         })
    //         ->emptyStateHeading(
    //             request('penempatanId')
    //                 ? 'Belum ada aktivitas magang'
    //                 : 'Silahkan pilih lowongan magang terlebih dahulu'
    //         )
    //         ->emptyStateDescription(
    //             request('penempatanId')
    //                 ? 'Aktivitas magang yang Anda catat akan muncul di sini.'
    //                 : 'Klik tombol "Pilih Lowongan" di atas untuk memilih lowongan magang yang ingin Anda kelola.'
    //         )
    //         ->emptyStateIcon(
    //             request('penempatanId') 
    //                 ? 'heroicon-o-document-text'
    //                 : 'heroicon-o-building-office-2'
    //         );
    // }

    public function getHeading(): string
    {
        // if ($penempatanId = request('penempatanId')) {
        //     $penempatan = PenempatanMagangModel::with(['pengajuan.lowongan'])->find($penempatanId);
            
        //     if ($penempatan && $penempatan->pengajuan && $penempatan->pengajuan->lowongan) {
        //         return 'Aktivitas Magang: ' . $penempatan->pengajuan->lowongan->judul_lowongan;
        //     }
        // }
        
        // return parent::getHeading();

        return request('penempatanId') 
            ? 'Aktivitas Magang Harian' 
            : parent::getHeading();
    }

    public function getSubheading(): string
    {
        // return request('penempatanId') 
        //     ? '' 
        //     : 'Silahkan pilih lowongan magang terlebih dahulu untuk melihat dan menambah aktivitas';

        if ($penempatanId = request('penempatanId')) {
            $penempatan = PenempatanMagangModel::find($penempatanId);
            if ($penempatan) {
                return 'Aktivitas Magang: ' . $penempatan->pengajuan->lowongan->judul_lowongan;
            }
        } else {
            return 'Silahkan pilih lowongan magang terlebih dahulu untuk melihat dan menambah aktivitas';
        }
        
        return parent::getHeading();
    }
}


// namespace App\Filament\Mahasiswa\Resources\ManajemenAktivitasMagangHarianResource\Pages;

// use App\Filament\Mahasiswa\Resources\ManajemenAktivitasMagangHarianResource;
// use App\Models\Reference\PenempatanMagangModel;
// use Filament\Actions;
// use Filament\Forms\Components\Select;
// use Filament\Resources\Pages\ListRecords;
// use Filament\Tables\Table;
// use Illuminate\Database\Eloquent\Builder;
// use Illuminate\Support\Facades\Auth;

// class ListManajemenAktivitasMagangHarians extends ListRecords
// {
//     protected static string $resource = ManajemenAktivitasMagangHarianResource::class;

//     protected function getHeaderActions(): array
//     {
//         $actions = [];

//         if(!request('penempatanId')){
//             // action untuk dropdown pilih lowongan
//             $actions[] = Actions\Action::make('pilih_lowongan')
//                 ->label('Pilih Lowongan')
//                 ->icon('heroicon-s-building-office-2')
//                 ->button()
//                 ->form([
//                     Select::make('lowongan_id')
//                         ->label('Lowongan Magang')
//                         ->options(function () {
//                             // Dapatkan ID mahasiswa yang login
//                             $user = Auth::user();
//                             $mahasiswaId = $user->mahasiswa->id_mahasiswa ?? null;
                            
//                             // Dapatkan data penempatan
//                             $options = [];
//                             $penempatans = PenempatanMagangModel::where('id_mahasiswa', $mahasiswaId)
//                                 ->with('pengajuan.lowongan')
//                                 ->get();
                            
//                             foreach ($penempatans as $penempatan) {
//                                 if ($penempatan->pengajuan && $penempatan->pengajuan->lowongan) {
//                                     $lowonganJudul = $penempatan->pengajuan->lowongan->judul_lowongan;
//                                     $options[$penempatan->id_penempatan] = $lowonganJudul;
//                                 }
//                             }
                            
//                             return $options;
//                         })
//                         ->searchable()
//                         ->required(),
//                 ])
//                 ->action(function (array $data) {
//                     $this->redirect(
//                         $this->getResource()::getUrl('index', ['penempatanId' => $data['lowongan_id']])
//                     );
//                 });
//         } else {
//             $actions[] = Actions\Action::make('reset')
//                 ->label('Reset Pilihan')
//                 ->icon('heroicon-s-x-mark')
//                 ->color('danger')
//                 ->url(url()->current());
                
//             $actions[] = Actions\CreateAction::make()
//                 ->label('Tambah Aktivitas')
//                 ->icon('heroicon-s-plus')
//                 ->url(fn (): string => 
//                     $this->getResource()::getUrl('create', ['penempatanId' => request('penempatanId')])
//                 );
//         }
        
//         return $actions;
//     }

//     // Tambahkan custom heading & subheading jika perlu
//     public function getSubheading(): string
//     {
//         if ($penempatanId = request('penempatanId')) {
//             $penempatan = PenempatanMagangModel::find($penempatanId);
//             if ($penempatan && $penempatan->pengajuan && $penempatan->pengajuan->lowongan) {
//                 return 'Aktivitas Magang: ' . $penempatan->pengajuan->lowongan->judul_lowongan;
//             }
//         } 
//         return 'Silahkan pilih lowongan magang terlebih dahulu untuk melihat aktivitas';
//     }
    
// }