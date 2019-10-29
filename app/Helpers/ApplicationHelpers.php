<?php

use App\Models\Setting\RouteList;
use App\Models\Setting\UserMenuPermission;

use App\Models\Setting\Menu;

use App\Models\Eperformance\DataMaster\UnitKerja;
use App\Models\Eperformance\DataMaster\Eselonisasi;
use App\Models\Eperformance\DataMaster\UnitBlok;
use App\Models\Eperformance\DataMaster\Periode;
use App\Models\Eperformance\Page\Page;

use App\Models\Eperformance\InputData\Iku;

use Spatie\MediaLibrary\Models\Media;
use App\User;

use Carbon\Carbon;


function GetUserButtonPermission($user_role_id, $route){
    $routeList              = RouteList::where('route_menu_name',\Route::currentRouteName())->first();

    $user_menu_permission   = UserMenuPermission::where('menu_id',$routeList->menu_id)->where('user_role_id',$user_role_id)->where('permission','true')->get();

    return $user_menu_permission;
}

function changeTimestampFormat($date){
    $newDate        = '-';
    if(!empty($date)){
        $newDate    = Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d F Y H:i:s');
    }
    return $newDate;
}

// get Media Image URL
function getMediaImage($image_id, $format = NULL){
    $media = Media::find($image_id);    

    if( $image_id != NULL){
        return ($format == NULL) ? $media->getURL() : $media->getURL($format);
    }
    else {
        return asset('img/noimage.png');
    }
}

// get Author Name
function getAuthor($author_id){
    if( $author_id != NULL){
        $author = User::find($author_id);
        return $author->name;
    } else {
        return '-';
    }
}

function getPostStatus($status){
    if( $status == 1 ){
        return "<span class='label label-success'>Published</span>";
    }
    else if( $status == 2 ){
        return "<span class='label label-danger'>Draft</span>";
    }
}

function getBreadCrumb($route_list_id){
    $route_list = RouteList::where('id', $route_list_id)->first();

    $breadcrumb = '<li class="active"><a href="#">'.$route_list->name.'</a></li>';

    $menu_parent = Menu::where('id', $route_list->menu_id)->first();

    if( !empty($menu_parent) ){
        $breadcrumb = '<li class="active"><a href="'.url($menu_parent->menu_controller).'">'.$menu_parent->menu_name.'</a></li>' . $breadcrumb;
    }

    while( $menu_parent->menu_parent_id != 0){
        $menu_parent = Menu::where('id', $menu_parent->menu_parent_id)->first();

        if( !empty($menu_parent) ){
            $breadcrumb = '<li class="active"><a href="'.url($menu_parent->menu_controller) .'">'.$menu_parent->menu_name.'</a></li>' . $breadcrumb;
        }
    }

    return $breadcrumb;
}

function allowButton($route_menu_id, $user_id, $menu_type_id){
    $user_menu_permission = UserMenuPermission::where('user_role_id',$user_id)->where('menu_id', $route_menu_id)->where('menu_type_id', $menu_type_id)->where('permission', 'true')->first();

    if( !empty($user_menu_permission) ){
        return true;
    } else {
        return false;
    }
}

function getButtonLinkDatatableMasterData($route_menu_id, $user_id, $trash, $hashid, $copy = NULL, $perbarui = NULL){    
    if( $trash == 0 ){
        $button = ' <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="glyphicon glyphicon-option-horizontal"></span>
                    </button>
                        <div class="dropdown-menu text-center">';
        // Copy Checker
        if( allowButton($route_menu_id, $user_id, 11) && !empty($copy)){
            $button .= " <button type='button' class='btn btn-primary btn-sm btn-copy btn-action' id='btn-copy' copy_id='$hashid'><i class='fa fa-copy' style='pointer-events:none;'></i> Copy </button> <br>";
        }
        // Edit Checker
        if( allowButton($route_menu_id, $user_id, 3)){
            $button .= " <button type='button' class='btn btn-primary btn-sm btn-edit btn-action' id='btn-edit' edit_id='$hashid'><i class='fa fa-pencil' style='pointer-events:none;'></i> Edit </button> ";
        }
        if( allowButton($route_menu_id, $user_id, 3) && !empty($perbarui)){
            $button .= " <button type='button' class='btn btn-primary btn-sm btn-perbarui btn-action' id='btn-perbarui' perbarui_id='$hashid'><i class='fa fa-repeat' style='pointer-events:none;'></i> Perbarui Realisasi </button> ";
        }
        // Delete Checker
        if( allowButton($route_menu_id, $user_id, 6)){
            $button .= " <br> <button type='button' class='btn btn-danger btn-sm btn-delete btn-action' id='btn-delete' delete_id='$hashid'><i class='fa fa-trash' style='pointer-events:none;'></i> Delete </button> ";
        }
        $button .= '</div></div>';

        return $button;
    } else if( $trash == 1) {
        $button = ' <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="glyphicon glyphicon-option-horizontal"></span>
                    </button>
                        <div class="dropdown-menu text-center">';
        // Restore Checker
        if( allowButton($route_menu_id, $user_id, 10)){
            $button .= " <button type='submit' class='btn btn-success btn-sm btn-restore btn-action' restore_id='$hashid'><i class='fa fa-undo' style='pointer-events:none;'></i> Restore </button> ";
        }
        // Destroy Checker
        if( allowButton($route_menu_id, $user_id, 9)){
            $button .= " <br> <button type='button' class='btn btn-danger btn-sm btn-destroy btn-action' destroy_id='$hashid'><i class='fa fa-trash' style='pointer-events:none;'></i> Delete Permanentyly</button> ";
        }
        $button .= '</div></div>';

        return $button;

    }
}

function getRouteTitle($route_name){
    $route_list = RouteList::where('route_menu_name', $route_name)->first();

    return !empty($route_list) ? $route_list->name : 'Mekari Test '.date('Y');
}

function createYear($max = NULL){
    $year = 1980;
    if( empty($max)){
        while( $year-1 != 2100 ){
            $all_year[] = $year;
            $year++;
        }
    } else {
        while( $year-1 != $max ){
            $all_year[] = $year;
            $year++;
        }
    }
    

    return $all_year;
}

function returnUnitSelect($unit_id, $index){
    if( $unit_id != 1){
        $unit_kerja = UnitKerja::where('unit_is_active',1)->where('unit_parent_id', $unit_id)->get();

        $option = '';
        foreach( $unit_kerja as $item ){
            $option .= "<option class='optionChild".$index."' value='".$item->id."'>".$item->eselonData->eselonisasi_deskripsi .'. '.Str::title($item->unit_nama)."</option>";
            $unit_kerja = UnitKerja::where('unit_is_active',1)->where('unit_parent_id', $item->id)->get();
            if( !empty($unit_kerja) ){
                $option .= returnUnitSelect($item->id, $index+1);
            }

        }
        return $option;
    } else {
        return false;
    }
}

function strPadUnitCode($str_pad,$num){
    if( strlen((string)$num) > $str_pad ){
        return $num;
    } else {
        return sprintf('%0'.$str_pad.'d', $num);
    }
}

function latestUnitCodeIncremental($unit_kode_parent, $unit_kode_child = NULL, $str_pad){
    if( !empty($unit_kode_child) ){
        $numbers = explode('.',$unit_kode_child);
        $last_number = end($numbers);
    } else {
        $last_number = 0;
    }

    return ($unit_kode_parent .'.'.strPadUnitCode( $str_pad, $last_number + 1));
}

// Function to return automatic code when user generate work unit
function generateUnitCode($unit_id = NULL){
    //if no parent_id forn unit
    if( empty($unit_id) ){
        $unit_kerja = UnitKerja::where('unit_is_active',1)->where('id', 1)->first();

        return $unit_kerja->unit_kode + 1;
    } else {
        // if there's parent
        // find unit kerja where id equal unit_id
        $unit_kerja = UnitKerja::find($unit_id);
        // get latest child with unit_kerja->id as a unit_parent_id
        $unit_kerja_child_latest = UnitKerja::where('unit_is_active',1)->where('unit_parent_id', $unit_kerja->id)->orderby('id','desc')->first();
        // get eselon unit kerja
        $eselon_unit_kerja = !empty($unit_kerja_child_latest) ? $unit_kerja_child_latest->eselonisasi_id : $unit_kerja->eselonisasi_id + 1;
        // get unit work digit by unit kerja child eselon
        $eselon = Eselonisasi::where('id',$eselon_unit_kerja)->first();
        // parsing unit_kode_child
        $unit_kode_child = !empty($unit_kerja_child_latest) ? $unit_kerja_child_latest->unit_kode : NULL;

        return latestUnitCodeIncremental($unit_kerja->unit_kode, $unit_kode_child, $eselon->eselonisasi_jumlah_digit);

    }
}

function getStatus($status){
    if( $status == 1 ){
        return "<span class='label label-success'>Active</span>";
    }
    else if( $status == 0 ){
        return "<span class='label label-danger'>Incative</span>";
    }
}

function getButtonUnitBlok($id, $hashid, $type){
    $unit_blok = UnitBlok::getUnitBlokStatus($id, $type);

    // dd($unit_blok);

    if( $unit_blok ){
        return " <button type='button' class='btn btn-primary btn-sm btn-edit-unit btn-danger' id='btn-edit-unit-blok' edit_id='$hashid' type_id='$type'> BLOCK </button> ";
    } else {
        return " <button type='button' class='btn btn-primary btn-sm btn-edit-unit btn-success' id='btn-edit-unit-blok' edit_id='$hashid' type_id='$type'> UNBLOCK </button> ";
    }
}

function getRangePeriodYear($period_id){
    $period = Periode::find($period_id);

    return $period->periode_tahun_awal . ' - ' . $period->periode_tahun_akhir;
}

function createUrl($url){
    return "<a href='$url' target='_blank'>$url</a>";
}

function changeDateMySqlFormat($date){
    return date('Y-m-d H:i:s', strtotime($date));
}

function getPageName($page_id){
    return Page::pageMenuData($page_id);
}

// create IKU Code
function createIkuCode($unit_id){
    $latest_iku = Iku::where('unit_id', $unit_id)->orderby('id','desc')->first();
    $unit = UnitKerja::find($unit_id);

    if( !empty($latest_iku) ){
        $numbers = explode('-',$latest_iku->iku_kode);
        $last_number = end($numbers);        
        $iku_code = $unit->unit_initial .'-'.'IKU-'.strPadUnitCode(3,$last_number+1);
    } else {
        $iku_code = $unit->unit_initial .'-'.'IKU-'.strPadUnitCode(3,1);
    }

    return $iku_code;
}