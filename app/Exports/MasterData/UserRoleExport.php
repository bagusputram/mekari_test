<?php

namespace App\Exports\MasterData;

use App\Models\Setting\UserRole;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class UserRoleExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function map($user_role): array
    {        
        return [
            $user_role->user_role_name,
        ];
    }

    public function collection()
    {
        $user_role = new UserRole();        
        return $user_role->userNoSuperAdmin();
    }

    public function headings(): array
    {
        return [
            'User Role Name',            
        ];
    }

    public function title(): string
    {
        return 'User Role Master Data';
    }
}
