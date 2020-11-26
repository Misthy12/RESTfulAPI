<?php 
namespace App\Models\CustomRules;
use App\Models\ProfesorModel;
use App\Models\GradoModel;

class MyRules {
public function is_valid_profesor(int $id): bool{
    $model = new ProfesorModel();
    $profesor = $model->find($id);  
    return $profesor == null ? false : true;
}
public function is_valid_grado(int $id): bool{
    $model = new GradoModel();
    $grado = $model->find($id);  
    return $grado == null ? false : true;
}
public function iscarnet_regex(string $carnet): bool{
    $resp = preg_match("/^(u|U)20[1|2]{1}[0-9]{5}+$/", $carnet );

    return $resp == 0 ? false : true;
    /*if ($resp == 0){
        return false;}
    else{
        return true; }*/


}
public function duiRegex(string $dui): bool{
    return preg_match("/[0-9]{8}-[0-9]{1}/", $dui ) == 1 ? true : false;
}
public function generoRegex(string $genero): bool{
    return preg_match("/(F|M|f|m)/", $genero ) == 1 ? true : false;
}
}