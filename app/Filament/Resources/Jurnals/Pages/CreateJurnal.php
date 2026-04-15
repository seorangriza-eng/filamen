<?php

namespace App\Filament\Resources\Jurnals\Pages;

use App\Filament\Resources\Jurnals\JurnalResource;
use App\Models\Coa;
use App\Models\Jurnal_detail;
use Filament\Resources\Pages\CreateRecord;

class CreateJurnal extends CreateRecord
{
    protected static string $resource = JurnalResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // unset($data['coa_1Id'], $data['coa_2Id'], $data['nominal']);
        // return $data;
        return collect($data)->except(['coa_1Id', 'coa_2Id'])->toArray();

    }

    //simpan data didatabase jurnal_details ya
    protected function afterCreate() : void {
        $data = $this->form->getState();

        $coa_1 = $data['coa_1Id'];
        $coa_2 = $data['coa_2Id'];
        $nominal = $data['nominal'];
        
        $checkCoa1 = Coa::find($coa_1);
        
        if($checkCoa1->normal_balance === 'debit'){
            $entry1 = ['coa_id' => $coa_1, 'debit' => $nominal, 'kredit' => 0];
            $entry2 = ['coa_id' => $coa_2, 'debit' => 0, 'kredit' => $nominal];
        } else {
            $entry1 = ['coa_id' => $coa_1, 'debit' => 0, 'kredit' => $nominal];
            $entry2 = ['coa_id' => $coa_2, 'debit' => $nominal, 'kredit' => 0];
        }
        // dd($entry1);
        Jurnal_detail::create(array_merge($entry1, ['jurnal_id' => $this->record->id]));
        Jurnal_detail::create(array_merge($entry2, ['jurnal_id' => $this->record->id]));
    }
}
