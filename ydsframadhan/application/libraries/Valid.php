<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class valid {

    var $ci;

    function __construct() {
        $this->ci = & get_instance();
    }

    /**
     * Function insert
     *
     * Function ini digunakan untuk memvalidasi inputan dan melakukan penyimpanan di database
     *
     * @param array $form - array form
     * @param string $model - model yang akan di insert
     * @param array $datacustom - array tambahan untuk inputan
     * @return boolean $status - status validasi
     * @return boolean $status_proses - status proses insert
     * @return array $form - form yang sudah di tambahkan message hasil validasi
     * @return array $datavalue - untuk value yang di tambahkan
     */
    public function insert($form, $model, $act = null, $datacustom = null, $exception = null, $upload_setting=array()) {
        $this->ci->load->library('form_validation');
        $valid = false; //untuk valid form
        $proses = false; //untuk cek apakah berhasil insert
        $datavalue = array();
        $filepath = array();
        $hasil=null;

       // print_r($form);
        foreach ($form as $key => $value) {
            
            if (isset($value['validation']))
                $this->ci->form_validation->set_rules(isset($value['name']) ? $value['name'] : $value['id'], $value['label'], $value['validation']);
        }

        if ($this->ci->form_validation->run()) {
            //insert ke tabel

            $this->ci->load->model($model);
            $data = array();

            foreach ($form as $key => $value) {
                if (!in_array($value['id'], $exception)) {//pengecualian untuk beberapa kolom
                    if (isset($value['type']) && $value['type'] == 'password') //pengecualian untuk password
                        $data[isset($value['name']) ? $value['name'] : $value['id']] = md5($this->ci->config->item('salt1') . $this->ci->input->post(isset($value['name']) ? $value['name'] : $value['id']) . $this->ci->config->item('salt2'));
                    else if (isset($value['type']) && $value['type'] == 'file') { //untuk type file
                        $upload_location= $upload_setting[isset($value['name']) ? $value['name'] : $value['id']]['location'];
                        $upload_filename= $upload_setting[isset($value['name']) ? $value['name'] : $value['id']]['filename'];
                        
                        $hasilupload = $this->upload_file(isset($value['name']) ? $value['name'] : $value['id'],$upload_location,$upload_filename);
                        //print_r($hasilupload);
                        if (isset($hasilupload['error'])&&$hasilupload['error']) {
                            $this->ci->session->set_flashdata('error', $hasilupload['error']);
                            $validupload = false;
                            $form[$key]['help'] = form_error(isset($value['name']) ? $value['name'] : $value['id']);
                            $data[isset($value['name']) ? $value['name'] : $value['id']] = null;
                        } else {
                            $data[isset($value['name']) ? $value['name'] : $value['id']] = $hasilupload['file_name'];
                            $validupload = true;
                            $filepath[] = $hasilupload['full_path'];
                        }
                    } else {
                        $input = $this->ci->input->post(isset($value['name']) ? $value['name'] : $value['id']);
                        $data[isset($value['name']) ? $value['name'] : $value['id']] = ($input != '') ? $input : null;
                    }
                }
            }
            //untuk log
            $data['log_time'] = date('Y-m-d H:i:s');
            $data['log_act'] = $act;
            $data['log_ip'] = $_SERVER['REMOTE_ADDR'];
            $data['log_ref'] = $this->ci->router->fetch_class() . '/' . $this->ci->router->fetch_method();

            if ($datacustom != null)
                $data = array_merge($data, $datacustom);

            $hasil = $this->ci->$model->insert($data);

            $proses = ($hasil == 0) ? false : true;

            if (isset($validupload) && $validupload) {
                if (!$proses) { //jika gagal simpan, maka di hapus semua
                    foreach ($filepath as $row) {
                        unlink($row);
                    }
                }
            }
            $valid = true;
        } else {//tambah message error
            foreach ($form as $key => $value) {
                $form[$key]['help'] = form_error(isset($value['name']) ? $value['name'] : $value['id']);
                $datavalue[isset($value['name']) ? $value['name'] : $value['id']] = $this->ci->input->post(isset($value['name']) ? $value['name'] : $value['id']);
            }
        }
        return array('status' => $valid, 'hasil'=>$hasil, 'status_proses' => $proses, 'form' => $form, 'datavalue' => $datavalue);
    }

    /**
     * Function insert
     *
     * Function ini digunakan untuk memvalidasi inputan dan melakukan penyimpanan di database
     *
     * @param array $form - array form
     * @param string $model - model yang akan di insert
     * @param array $datacustom - array tambahan untuk inputan
     * @return boolean $status - status validasi
     * @return boolean $status_proses - status proses insert
     * @return array $form - form yang sudah di tambahkan message hasil validasi
     * @return array $datavalue - untuk value yang di tambahkan
     */
    public function update($form, $model, $act = null, $datacustom = null, $exception = null, $datalama = null, $upload_setting=array()) {

        $this->ci->load->model($model);
        $id = $datalama[$this->ci->$model->tableid];
        if ($id == null) {
            $this->ci->session->set_flashdata('error', 'ID tidak ditemukan!');
            return array('status' => false, 'status_proses' => false, 'form' => $form, 'datavalue' => array());
        }

        $this->ci->load->library('form_validation');
        $valid = false; //untuk valid form
        $proses = false; //untuk cek apakah berhasil insert
        $datavalue = array();
        $filepath = array();

        foreach ($form as $key => $value) {
            if (isset($value['validation']))
                $this->ci->form_validation->set_rules(isset($value['name']) ? $value['name'] : $value['id'], $value['label'], $value['validation']);
        }

        if ($this->ci->form_validation->run()) {
            //insert ke tabel

            $data = array();

            foreach ($form as $key => $value) {
                if (!in_array($value['id'], $exception)) {//pengecualian untuk beberapa kolom
                    if (isset($value['type']) && $value['type'] == 'password') //pengecualian untuk password
                        $data[isset($value['name']) ? $value['name'] : $value['id']] = md5($this->ci->config->item('salt1') . $this->ci->input->post(isset($value['name']) ? $value['name'] : $value['id']) . $this->ci->config->item('salt2'));
                    else if (isset($value['type']) && $value['type'] == 'file') { //untuk type file
                        $upload_location= $upload_setting[isset($value['name']) ? $value['name'] : $value['id']]['location'];
                        $upload_filename= $upload_setting[isset($value['name']) ? $value['name'] : $value['id']]['filename'];
                        
                        $hasilupload = $this->upload_file(isset($value['name']) ? $value['name'] : $value['id'],$upload_location,$upload_filename);
                        //print_r($hasilupload);
                        if (isset($hasilupload['error'])&&$hasilupload['error']) {
                            $this->ci->session->set_flashdata('error', $hasilupload['error']);
                            $validupload = false;
                            $form[$key]['help'] = form_error(isset($value['name']) ? $value['name'] : $value['id']);
                            $data[isset($value['name']) ? $value['name'] : $value['id']] = null;
                        } else {
                            $data[isset($value['name']) ? $value['name'] : $value['id']] = $hasilupload['file_name'];
                            $validupload = true;
                            $filepath[] = $hasilupload['full_path'];
                        }

                        $filelama[] = $upload_location.'/'.($datalama[isset($value['name']) ? $value['name'] : $value['id']]);
                    } else {
                        $input = $this->ci->input->post(isset($value['name']) ? $value['name'] : $value['id']);
                        $data[isset($value['name']) ? $value['name'] : $value['id']] = ($input != '') ? $input : null;
                    }
                }
            }
            //untuk log
            $data['log_time'] = date('Y-m-d H:i:s');
            $data['log_act'] = $act;
            $data['log_ip'] = $_SERVER['REMOTE_ADDR'];
            $data['log_ref'] = $this->ci->router->fetch_class() . '/' . $this->ci->router->fetch_method();

            if ($datacustom != null)
                $data = array_merge($data, $datacustom);

            $proses = ($this->ci->$model->update($data, $id) != 1) ? false : true;

            if (isset($validupload) && $validupload) {
                if (!$proses) { //jika gagal simpan, maka di hapus semua
                    foreach ($filepath as $row) {
                        unlink($row);
                    }
                } else { //hapus file lama
                    foreach ($filelama as $row) {
                        //echo $row;
                        unlink($row);
                    }
                }
            }
            
            $valid = true;
        } else {//tambah message error
            foreach ($form as $key => $value) {
                $form[$key]['help'] = form_error(isset($value['name']) ? $value['name'] : $value['id']);
                $datavalue[isset($value['name']) ? $value['name'] : $value['id']] = $this->ci->input->post(isset($value['name']) ? $value['name'] : $value['id']);
            }
        }
        return array('status' => $valid, 'status_proses' => $proses, 'form' => $form, 'datavalue' => $datavalue);
    }

    public function delete($model, $data = null, $act = null, $kolomfile = null, $upload_setting=array()) {
//        $data['log_time'] = date('Y-m-d H:i:s');
//        $data['log_act'] = $act;
//        $data['log_ip'] = $_SERVER['REMOTE_ADDR'];
//        $data['log_ref'] = $this->ci->router->fetch_class() . '/' . $this->ci->router->fetch_method();

        if ($data==null or empty($data) or ! is_array($data))
            $this->ci->session->set_flashdata('error', 'ID tidak ditemukan!');
        else {
            $this->ci->load->model($model);
            
            
            $proses = ($this->ci->$model->delete($data[$this->ci->$model->tableid]) != 1) ? false : true;
            $error=$this->ci->db->error();
             
            if ($proses) {
                if($kolomfile!=null){
                    foreach ($kolomfile as $row) {
                        if ($data[$row] != '')
                            unlink($upload_setting[$row]['location'].'/'.$data[$row]);
                    }
                }
                $this->ci->session->set_flashdata('info', 'Data berhasil dihapus!');
            }else {
                if(isset($error['code']) && $error['code']==1451){
                    $this->ci->session->set_flashdata('error', 'Data gagal dihapus, data masih digunakan!');
                }
                else
                    $this->ci->session->set_flashdata('error', 'Data gagal dihapus!');
            }
        }
    }

    public function upload_file($formname, $upload_location, $filename=null) {
        $status = false;
        $data = array();

        $config['upload_path'] = $upload_location;
        $config['allowed_types'] = '*';
        $config['max_size'] = 1024 * 1;
        
        if($filename!=null)
            $config['file_name']=$filename;
        //$config['encrypt_name'] = TRUE;

        $this->ci->load->library('upload');
        $this->ci->upload->initialize($config);

        if (!$this->ci->upload->do_upload($formname)) {
            $this->ci->form_validation->set_message('checkdoc', $data['error'] = $this->ci->upload->display_errors());
            $status = false;
        } else {
            $data = $this->ci->upload->data();
            $status = true;
        }
        @unlink($_FILES[$formname]);

        return $data;
    }
    
    public function cek_form($form) {
        $this->ci->load->library('form_validation');
        $valid = false; //untuk valid form

        
        foreach ($form as $key => $value) {
            if (isset($value['validation']))
                $this->ci->form_validation->set_rules(isset($value['name']) ? $value['name'] : $value['id'], $value['label'], $value['validation']);
        
        }
        
        if ($this->ci->form_validation->run()) {
            $valid = true;
        } else {//tambah message error
            
            foreach ($form as $key => $value) {
                $form[$key]['help'] = form_error(isset($value['name']) ? $value['name'] : $value['id']);
                $datavalue[isset($value['name']) ? $value['name'] : $value['id']] = $this->ci->input->post(isset($value['name']) ? $value['name'] : $value['id']);
            }
            $valid=false;
        }
        return array('status' => $valid, 'form' => $form);
    }

}

?>