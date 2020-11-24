<?php namespace App\Controllers\API;

use App\Models\ProfesorModel;
use CodeIgniter\RESTful\ResourcesController;

class Profesores extends ResourcesController
{
    public function __construct(){
        $this->model = $this->setModel(new ProfesorModel());
    }
	public function index()
	{
		$profesores = $this->model->finAll();

		return $this->respond($profesores);
	}
	public function create()
	{
		try {
			$profesor= $this->request-getJSON();
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
	public function edit()
	{
		try {
			

		} catch (\Exception $e) {
			//throw $th;
			return $this->failServerError('Ha ocurrido un error en el servidor');
		}
	}
}
