<?php namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;

class ApiGrado extends ResourceController
{

    public function __construct(){

	}
	
	public function getall($id = null)
	{
		$gradoModel = new \App\Models\GradoModel();
		$profeModel = new \App\Models\ProfesorModel();
		$studentModel = new \App\Models\EstudianteModel();
		try {
			if($id==null)
				return $this->failValidationError('No se se ha pasado ID Valido');
			
			$vgrado = $gradoModel->where('id', $id)->first();

			if($vgrado==null)
				return failNotFound('No se se han encontrado Resultados con id: ' .$id);
			$Estudiantes = $studentModel->where('grado_id', $id)->select('CONCAT(nombre," ", apellido) as Nombre,genero, carnet')->findAll();
			$Profesor = $profeModel->where('id', $vgrado['profesor_id'])->select(['CONCAT(nombre," ", apellido) as Nombres', 'profesion','telefono'])->first();
			if($vgrado != null):
				return $this->setResponseFormat('json')->respond(['grado'=>$vgrado['grado'],'seccion'=>$vgrado['seccion'],'Profesor'=>$Profesor,'alumnos'=>$Estudiantes]);
			else:
				return failValidationError($gradoModel->validation->listErrors());
			endif;

		} catch (\Exception $e) {
			//throw $th;
			return failServerError('Ha ocurrido un error en el servidor');
		}
	}
}