<?php

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Transfer extends REST_Controller {

  public function __construct() {

   parent::__construct();
   $this->load->library('Authorization_Token');	
   $this->load->model('Transfer_model');

}

public function index_post()
{
    $headers = $this->input->request_headers(); 
    if (isset($headers['Authorization'])) {
       $decodedToken = $this->authorization_token->validateToken($headers['Authorization']);
       if ($decodedToken['status']){
         $validasi = $this->form_validation;
         $validasi->set_rules($this->rules());

         if ($this->form_validation->run() === false) {
            $response               = array();
            $response['status']     = false;
            $response['message']    = validation_errors();

            $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $post           = $this->input->post();

         $nilai_transfer = $post['nilai_transfer'];
         $kode_unik      = $this->kode_unik();
         $date           = date('Y-m-d H:i:s');
         $date1          = str_replace('-', '/', $date);
         $berlaku_hingga = date('Y-m-d H:i:s',strtotime($date1 . "+3 days"));            
         $id_transaksi   = null;
         $count          = 1;
         $tahun          = date('y');
         $bulan          = date('m'); 
         $last           = $this->Transfer_model->getLastId($tahun,$bulan);
         $bank           = $this->Transfer_model->get_rekening($post['bank_pengirim']);


         if ($last != null and $last->last_id > 0) {
            $count          = $last->last_id;
            $id             = sprintf('%06d',$count);
            $id_transaksi   = 'TF'.$tahun.$bulan.$id;
        }else{
            $id_transaksi   = 'TF'.$tahun.$bulan.sprintf('%06d',1);
        }

        $save = array(
            'id_transaksi'      => $id_transaksi,
            'nilai_transfer'    => $nilai_transfer,
            'kode_unik'         => $kode_unik,
            'biaya_admin'       => 0,
            'total_transfer'    => $nilai_transfer+$kode_unik,
            'bank_perantara'    => $post['bank_pengirim'],
            'rekening_perantara'=> $bank->no_rekening,
            'berlaku_hingga'    => $berlaku_hingga,
        );

        $data  = $this->Transfer_model->insert($save);

        if ($data) {
            $gen = array(
                'tahun'     => $tahun,
                'bulan'     => $bulan,
                'last_id'   => $count+1,
            );
            $data                   = $this->Transfer_model->insert_last_Id($gen);

            $response               = array();
            $response['status']     = true;
            $response['message']    = 'Transfer Berhasil Dilakukan';
            $response['data']       = $save;

            $this->response($response, REST_Controller::HTTP_OK);
        } else {
            $response = array();
            $response['status'] = false;
            $response['message'] = 'Transfer Gagal Dilakukan';

            $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
        }
        }

         
    }
    else {
        $this->response($decodedToken);
    }
}
else {
   $this->response(['Authentication failed'], REST_Controller::HTTP_OK);
}
}

public function kode_unik()
{
    $key = random_int(100, 999);
    $key = str_pad($key, 3, 0, STR_PAD_LEFT);
    return $key;
} 

public function rules()
{
    return [
        [
            'field' => 'nilai_transfer',
            'label' => 'Nilai Transfer',
            'rules' => 'required',
            'errors' => [
                'required' => 'Kolom {field} harus di isi'
            ]
        ],
        [
            'field' => 'bank_tujuan',
            'label' => 'Bank Tujuan',
            'rules' => 'required',
            'errors' => [
                'required' => 'Kolom {field} harus di isi'
            ]
        ],
        [
            'field' => 'rekening_tujuan',
            'label' => 'Rekening Tujuan',
            'rules' => 'required',
            'errors' => [
                'required' => 'Kolom {field} harus di isi'
            ]
        ],
        [
            'field' => 'atasnama_tujuan',
            'label' => 'Atas Nama Tujuan',
            'rules' => 'required',
            'errors' => [
                'required' => 'Kolom {field} harus di isi'
            ]
        ],
        [
            'field' => 'bank_pengirim',
            'label' => 'Bank Pengirim',
            'rules' => 'required',
            'errors' => [
                'required' => 'Kolom {field} harus di isi'
            ]
        ],
        ];
    }


}