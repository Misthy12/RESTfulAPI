<?php namespace App\Controllers\API;

use App\Models\RolModel;
use CodeIgniter\RESTful\ResourceController;

class Roles extends ResourceController
{
    public function __construct(){
        $this->model = $this->setModel(new RolModel());
    }
	public function index()
	{
		$Roles = $this->model->findAll();

		return $this->respond($Roles);
	}
	public function create()
	{
		try {
			$Rol= $this->request->getJSON();
			if($this->model->insert($Rol)):
				$Rol->id = $this->model->insertID();
				return $this->respondCreated($Rol);
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
			$Rol = $this->model->find($id);

			if($Rol==null)
				return $this->failNotFound('No se se ha encontrado un Rol con id: ' .$id);
			
			return $this->respond($Rol);

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
			$verificarRol = $this->model->find($id);

			if($verificarRol==null)
				return $this->failNotFound('No se se ha encontrado un Rol con id: ' .$id);
			
			$Rol = $this->request->getJSON();
			if($this->model->update($id,$Rol)):
				$Rol->id= $id;
				return $this->respondUpdated($Rol);
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
			$verificarRol = $this->model->find($id);

			if($verificarRol==null)
				return $this->failNotFound('No se se ha encontrado un Rol con id: ' .$id);
			
			if($this->model->delete($id)):
				return $this->respondDeleted($verificarRol);
			else:
				return $this->failServerError('No se Ha Podido borrar el Registro');
			endif;

		} catch (\Exception $e) {
			//throw $th;
			return $this->failServerError('Ha ocurrido un error en el servidor');
		}
	}
}