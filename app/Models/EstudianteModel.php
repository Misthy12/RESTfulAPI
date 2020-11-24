<?php namespace App\Models;

use CodeIgniter\Model;

class EstudianteModel extends Model 
{
    protected $table            =   'estudiante';
    protected $primaryKey       =   'id';
    
    protected $allowedFields    =  ['nombre', 'apellido', 'dui', 'genero', 'carnet', 'grado'];

    protected $useTimestamps    = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules  = [
        'nombre'                => 'required|alpha_numeric_space|min_length[3]|max_length[75]',
        'apellido'              => 'required|alpha_numeric_space|min_length[3]|max_length[75]',
        'dui'                   => 'required|min_length[10]|max_length[10]',
        'genero'                => 'required|min_length[1]|max_length[1]',
        'carnet'                => 'required|min_length[9]|max_length[9]',
        'grado'                 => 'required|integer',
    ];

    protected $skipValidation = false;
}