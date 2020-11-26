<?php namespace App\Models;

use CodeIgniter\Model;

class GradoModel extends Model 
{
    protected $table            =   'grado';
    protected $primaryKey       =   'id';
    
    protected $allowedFields    =  ['grado', 'seccion', 'profesor_id'];

    protected $useTimestamps    = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules  = [
        'grado'                => 'required|alpha_numeric_space|min_length[3]|max_length[60]',
        'seccion'              => 'required|alpha_numeric_space|min_length[1]|max_length[2]',
        'profesor_id'          => 'required|integer|is_valid_profesor',
    ];
    protected $validationMessages = [
        'profesor_id' => ['is_valid_profesor' => 'El Profesor que intenta ingresar no existe.']
    ];

    protected $skipValidation = false;
}