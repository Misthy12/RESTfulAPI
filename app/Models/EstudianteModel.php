<?php namespace App\Models;

use CodeIgniter\Model;

class EstudianteModel extends Model 
{
    protected $table            =   'estudiante';
    protected $primaryKey       =   'id';
    
    protected $allowedFields    =  ['nombre', 'apellido', 'dui', 'genero', 'carnet', 'grado_id'];

    protected $useTimestamps    = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules  = [
        'nombre'                => 'required|alpha_numeric_space|min_length[3]|max_length[75]',
        'apellido'              => 'required|alpha_numeric_space|min_length[3]|max_length[75]',
        'dui'                   => 'required|min_length[10]|max_length[10]',
        'genero'                => 'required|min_length[1]|max_length[1]',
        'carnet'                => 'required|iscarnet_regex',
        'grado_id'              => 'required|is_valid_grado',
    ];
    protected $validationMessages = [
        'grado_id'  => ['is_valid_grado' => 'El grado que intenta ingresar no existe.'],
        'carnet'    => ['iscarnet_regex' => 'El Carnet que intenta ingresar es invalido']
    ];

    protected $skipValidation = false;
}