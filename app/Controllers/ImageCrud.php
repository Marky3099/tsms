<?php 
namespace App\Controllers;
use App\Models\Upload;
use CodeIgniter\Controller;

class ImageCrud extends Controller
{
	public function index(){
        if($_SESSION['position'] != USER_ROLE_ADMIN){
            return $this->response->redirect(site_url('/dashboard'));
        }
		$Upload = new Upload();

		$data['Upload'] = $Upload->orderBy('upload_id', 'ASC')->findAll();
		$data['main'] = 'image/image_view';
		return view('dashboard/template',$data);
	}
	public function create(){
        if($_SESSION['position'] != USER_ROLE_ADMIN){
            return $this->response->redirect(site_url('/dashboard'));
        }
		$data['main'] = 'image/image_add';
		return view('dashboard/template',$data);
	}
	public function store() {
        if($_SESSION['position'] != USER_ROLE_ADMIN){
            return $this->response->redirect(site_url('/dashboard'));
        }
        $Upload = new Upload();
        $file = $this->request->getFile('image');
        $type = $file->getMimeType();
        $data['ext'] = $file->guessExtension();
        if ($file->isValid() && !$file->hasMoved()) {
        	$imageName = $file->getRandomName();
        	$file->move('uploads/',$imageName);
        }



        $upload_create = [
            'upload_title' => $this->request->getVar('upload_title'),
            'upload_description' => $this->request->getVar('upload_description'),
            'image' => $imageName,
            
        ];
        $Upload->insert($upload_create);
        $data['success'] ="File added";
        return $this->response->redirect(site_url('/service-reports'));
    }
    public function singleUpload($upload_id = null){
        if($_SESSION['position'] != USER_ROLE_ADMIN){
            return $this->response->redirect(site_url('/dashboard'));
        }
        $Upload = new Upload();
        $data['Upload_obj'] = $Upload->where('upload_id', $upload_id)->first();
        $data['main'] = 'image/image_edit';
        return view("dashboard/template",$data);
    }
    public function update($upload_id){
        if($_SESSION['position'] != USER_ROLE_ADMIN){
            return $this->response->redirect(site_url('/dashboard'));
        }
    	$Upload = new Upload();
        $Upload_obj = $Upload->find($upload_id);
        $old_img_name = $Upload_obj['image'];
        $file = $this->request->getFile('image');

        if ($file->isValid() && !$file->hasMoved()) {
        	
        	if (file_exists("uploads/".$old_img_name)) {
        		unlink("uploads/".$old_img_name);
        	}
        	$imageName = $file->getRandomName();
        	$file->move('uploads/',$imageName);
        }
        else{
        	$imageName = $old_img_name;
        }
         $upload_update = [
            'upload_title' => $this->request->getVar('upload_title'),
            'upload_description' => $this->request->getVar('upload_description'),
            'image' => $imageName,
            
        ];
        $Upload->update($upload_id, $upload_update);
        $data['success'] ="File added";
        
        return $this->response->redirect(site_url('/service-reports'));
    }
    public function delete($upload_id){
        if($_SESSION['position'] != USER_ROLE_ADMIN){
            return $this->response->redirect(site_url('/dashboard'));
        }
    	$Upload = new Upload();
    	$Upload_obj = $Upload->find($upload_id);
    	$imagefile = $Upload_obj['image'];
    	if (file_exists("uploads/".$imagefile)) {
    		unlink("uploads/".$imagefile);
    	}
    	$Upload->delete($upload_id);
    	return $this->response->redirect(site_url('/service-reports'));
    }
}