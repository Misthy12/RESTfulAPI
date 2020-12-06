<?php namespace App\Controllers\API;

use App\Models\ProfesorModel;
use CodeIgniter\RESTful\ResourceController;

class Profesores extends ResourceController
{
    public function __construct(){
        $this->model = $this->setModel(new ProfesorModel());
		helper('access_rol');
		helper('secure_password');
    }
	public function index()
	{
		try {
			if (!validateAccess(array('Admin','Teacher'),$this->request->getServer('HTTP_AUTHORIZATION')))
			return $this->failServerError('El Rol no tiene Acceso a este recurso');

			$Estudiantes = $this->model->findAll();
			return $this->respond($Estudiantes);
		} catch (\Throwable $th) {
		return $this->failServerError('Ha ocurrido un error en el servidor');
		}
	}
	public function create()
	{
		try {
			if (!validateAccess(array('Admin'),$this->request->getServer('HTTP_AUTHORIZATION')))
			return $this->failServerError('El Rol no tiene Acceso a este recurso');
			$profesor= $this->request->getJSON();
			if($this->model->insert($profesor)):
				$profesor->id = $this->model->insertID();
				return $this->respondCreated($profesor);
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
			if (!validateAccess(array('Admin','Teacher'),$this->request->getServer('HTTP_AUTHORIZATION')))
			return $this->failServerError('El Rol no tiene Acceso a este recurso');
			if($id==null)
				return $this->failValidationError('No se se ha pasado ID Valido');
			$profesor = $this->model->find($id);

			if($profesor==null)
				return $this->failNotFound('No se se ha encontrado un profesor con id: ' .$id);
			
			return $this->respond($profesor);

		} catch (\Exception $e) {
			//throw $th;
			return $this->failServerError('Ha ocurrido un error en el servidor');
		}
	}
	public function update($id = null)
	{
		try {
			if (!validateAccess(array('Admin'),$this->request->getServer('HTTP_AUTHORIZATION')))
			return $this->failServerError('El Rol no tiene Acceso a este recurso');
			if($id==null)
				return $this->failValidationError('No se se ha pasado ID Valido');
			$verificarprofesor = $this->model->find($id);

			if($verificarprofesor==null)
				return $this->failNotFound('No se se ha encontrado un profesor con id: ' .$id);
			
			$profesor = $this->request->getJSON();
			if($this->model->update($id,$profesor)):
				$profesor->id= $id;
				return $this->respondUpdated($profesor);
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
			if (!validateAccess(array('Admin'),$this->request->getServer('HTTP_AUTHORIZATION')))
			return $this->failServerError('El Rol no tiene Acceso a este recurso');
			if($id==null)
				return $this->failValidationError('No se se ha pasado ID Valido');
			$verificarprofesor = $this->model->find($id);

			if($verificarprofesor==null)
				return $this->failNotFound('No se se ha encontrado un profesor con id: ' .$id);
			
			if($this->model->delete($id)):
				return $this->respondDeleted($verificarprofesor);
			else:
				return $this->failServerError('No se Ha Podido borrar el Registro');
			endif;

		} catch (\Exception $e) {
			//throw $th;
			return $this->failServerError('Ha ocurrido un error en el servidor');
		}
	}
}
