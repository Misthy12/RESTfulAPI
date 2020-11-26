<?php namespace App\Controllers\API;

use App\Models\EstudianteModel;
use CodeIgniter\RESTful\ResourceController;

class Estudiantes extends ResourceController
{
    public function __construct(){
        $this->model = $this->setModel(new EstudianteModel());
    }
	public function index()
	{
		$Estudiantes = $this->model->findAll();

		return $this->respond($Estudiantes);
	}
	public function create()
	{
		try {
			$Estudiante= $this->request->getJSON();
			if($this->model->insert($Estudiante)):
				$Estudiante->id = $this->model->insertID();
				return $this->respondCreated($Estudiante);
			else:
				return $this->failValidationError($this->model->validation->listErrors());
			endif;

		} catch (\Exception $e) {
			//throw $th;
			return $this->failServerError('Ha ocurrido un error en el servidor');
		}
	}
	public function edit($id = null)
	{
		try {
			if($id==null)
				return $this->failValidationError('No se se ha pasado ID Valido');
			$Estudiante = $this->model->find($id);

			if($Estudiante==null)
				return $this->failNotFound('No se se ha encontrado un Estudiante con id: ' .$id);
			
			return $this->respond($Estudiante);

		} catch (\Exception $e) {
			//throw $th;
			return $this->failServerError('Ha ocurrido un error en el servidor');
		}
	}
	public function update($id = null)
	{
		try {
			if($id==null)
				return $this->failValidationError('No se se ha pasado ID Valido');
			$verificarEstudiante = $this->model->find($id);

			if($verificarEstudiante==null)
				return $this->failNotFound('No se se ha encontrado un Estudiante con id: ' .$id);
			
			$Estudiante = $this->request->getJSON();
			if($this->model->update($id,$Estudiante)):
				$Estudiante->id= $id;
				return $this->respondUpdated($Estudiante);
			else:
				return $this->failValidationError($this->model->validation->listErrors());
			endif;

		} catch (\Exception $e) {
			//throw $th;
			return $this->failServerError('Ha ocurrido un error en el servidor');
		}
	}
	public function delete($id = null)
	{
		try {
			if($id==null)
				return $this->failValidationError('No se se ha pasado ID Valido');
			$verificarEstudiante = $this->model->find($id);

			if($verificarEstudiante==null)
				return $this->failNotFound('No se se ha encontrado un Estudiante con id: ' .$id);
			
			if($this->model->delete($id)):
				return $this->respondDeleted($verificarEstudiante);
			else:
				return $this->failServerError('No se Ha Podido borrar el Registro');
			endif;

		} catch (\Exception $e) {
			//throw $th;
			return $this->failServerError('Ha ocurrido un error en el servidor');
		}
	}
}