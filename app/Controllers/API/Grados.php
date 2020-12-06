<?php namespace App\Controllers\API;

use App\Models\GradoModel;
use CodeIgniter\RESTful\ResourceController;

class Grados extends ResourceController
{
    public function __construct(){
		$this->model = $this->setModel(new GradoModel());
		helper('access_rol');
		helper('secure_password');
    }
	public function index()
	{
		
		try {
			if (!validateAccess(array('Admin','Teacher'),$this->request->getServer('HTTP_AUTHORIZATION')))
			return $this->failServerError('El Rol no tiene Acceso a este recurso');

			$Grados = $this->model->findAll();
			return $this->respond($Grados);
		} catch (\Throwable $th) {
		return $this->failServerError('Ha ocurrido un error en el servidor');
		}
	}
	public function create()
	{
		try {
			if (!validateAccess(array('Admin'),$this->request->getServer('HTTP_AUTHORIZATION')))
			return $this->failServerError('El Rol no tiene Acceso a este recurso');

			$Grados= $this->request->getJSON();
			if($this->model->insert($Grados)):
				$Grados->id = $this->model->insertID();
				return $this->respondCreated($Grados);
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
			if (!validateAccess(array('Admin'),$this->request->getServer('HTTP_AUTHORIZATION')))
			return $this->failServerError('El Rol no tiene Acceso a este recurso');

			if($id==null)
				return $this->failValidationError('No se se ha pasado ID Valido');
			$Grados = $this->model->find($id);

			if($Grados==null)
				return $this->failNotFound('No se se ha encontrado un Grado con id: ' .$id);
			
			return $this->respond($Grados);

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
			$verificarGrados = $this->model->find($id);

			if($verificarGrados==null)
				return $this->failNotFound('No se se ha encontrado un Grado con id: ' .$id);
			
			$Grados = $this->request->getJSON();
			if($this->model->update($id,$Grados)):
				$Grados->id= $id;
				return $this->respondUpdated($Grados);
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
			$verificarGrados = $this->model->find($id);

			if($verificarGrados==null)
				return $this->failNotFound('No se se ha encontrado un Grado con id: ' .$id);
			
			if($this->model->delete($id)):
				return $this->respondDeleted($verificarGrados);
			else:
				return $this->failServerError('No se Ha Podido borrar el Registro');
			endif;

		} catch (\Exception $e) {
			//throw $th;
			return $this->failServerError('Ha ocurrido un error en el servidor');
		}
	}
}