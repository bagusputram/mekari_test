<?php

namespace App\Imports\Eperformance\DataMaster\Pejabat;

use App\User;
use App\Models\Setting\UserProfile;
use App\Models\Setting\UserRole;
use App\Models\Setting\Gender;
use App\Models\Eperformance\DataMaster\UnitKerja;
use App\Models\Eperformance\DataMaster\Pejabat;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Auth;

class FirstSheetPejabatImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {        
        foreach ($rows as $row) {            
            $row['gender_id'] = Gender::where('gender_name', 'like', $row['gender_name'])->first()->id;
            $row['unit_id'] = UnitKerja::where('unit_nama', 'like', '%'.$row['unit_name'].'%')->first()->id;
            $row['user_role'] = UserRole::where('user_role_name', 'like', $row['user_role_name'])->first()->id;

            $user_checker = User::where('email', $row['email'])->orWhere('username', $row['username'])->first();

            if( empty($user_checker) ){
                // create user first
                $user = new User;

                // email creator if not input create email based on username
                $email = (!empty($row['email'])) ? $row['email'] : $row['username'] .'@eperformance.kemenpar.go.id';

                $user->name = $row['pejabat_nama'];
                $user->email = $email;
                $user->username = $row['username'];
                $user->password = bcrypt('123456');
                $user->user_role_id = $row['user_role'];
                $user->email_verified_at = date('Y-m-d H:i:s');

                $user->save();

                // fetch last inserted id
                $user_id = $user->id;

                // create user profile picture
                $user_profile = new UserProfile;

                $user_profile->user_id = $user_id;
                $user_profile->application_language = 2;
                $user_profile->application_theme_color = 1;

                $user_profile->save();
                
                // create new Pejabat
                // initialize new data
                $pejabat = new Pejabat;

                // initialize data to store
                $pejabat->pejabat_nama = $row['pejabat_nama'];
                $pejabat->pejabat_NIP = $row['pejabat_nip'];
                $pejabat->pejabat_telepon = $row['pejabat_telepon'];
                $pejabat->pejabat_alamat = $row['pejabat_alamat'];
                $pejabat->pejabat_tahun_penetapan = $row['pejabat_tahun_penetapan'];
                $pejabat->pejabat_tahun_selesai = $row['pejabat_tahun_selesai'];
                $pejabat->gender_id = $row['gender_id'];
                $pejabat->unit_id = $row['unit_id'];
                $pejabat->user_id = $user_id;
                $pejabat->pejabat_is_active = $row['pejabat_is_active'];
                $pejabat->pejabat_created_by = Auth::user()->id;

                // save data
                $pejabat->save();
                
            }
        }
    }
}
