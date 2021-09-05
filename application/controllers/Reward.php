<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reward extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Reward_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'reward/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'reward/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'reward/index.html';
            $config['first_url'] = base_url() . 'reward/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Reward_model->total_rows($q);
        $reward = $this->Reward_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'reward_data' => $reward,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'reward/reward_list',
            'konten' => 'reward/reward_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Reward_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_reward' => $row->id_reward,
		'target' => $row->target,
		'bonus_tunai' => $row->bonus_tunai,
		'keterangan' => $row->keterangan,
		'gambar' => $row->gambar,
	    );
            $this->load->view('reward/reward_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('reward'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'reward/reward_form',
            'konten' => 'reward/reward_form',
            'button' => 'Create',
            'action' => site_url('reward/create_action'),
	    'id_reward' => set_value('id_reward'),
	    'target' => set_value('target'),
	    'bonus_tunai' => set_value('bonus_tunai'),
	    'keterangan' => set_value('keterangan'),
	    'gambar' => set_value('gambar'),
	);
        $this->load->view('v_index', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $img = upload_gambar_biasa('reward', 'image/reward/', 'jpg|png|jpeg', 10000, 'gambar');
            $data = array(
		'target' => $this->input->post('target',TRUE),
		'bonus_tunai' => $this->input->post('bonus_tunai',TRUE),
		'keterangan' => $this->input->post('keterangan',TRUE),
		'gambar' => $img,
	    );

            $this->Reward_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('reward'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Reward_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'reward/reward_form',
                'konten' => 'reward/reward_form',
                'button' => 'Update',
                'action' => site_url('reward/update_action'),
		'id_reward' => set_value('id_reward', $row->id_reward),
		'target' => set_value('target', $row->target),
		'bonus_tunai' => set_value('bonus_tunai', $row->bonus_tunai),
		'keterangan' => set_value('keterangan', $row->keterangan),
		'gambar' => set_value('gambar', $row->gambar),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('reward'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_reward', TRUE));
        } else {
            $data = array(
		'target' => $this->input->post('target',TRUE),
		'bonus_tunai' => $this->input->post('bonus_tunai',TRUE),
		'keterangan' => $this->input->post('keterangan',TRUE),
		'gambar' => $retVal = ($_FILES['gambar']['name'] == '') ? $_POST['foto_old'] : upload_gambar_biasa('user', 'image/reward/', 'jpeg|png|jpg|gif', 10000, 'gambar'),
	    );

            $this->Reward_model->update($this->input->post('id_reward', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('reward'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Reward_model->get_by_id($id);

        if ($row) {
            $this->Reward_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('reward'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('reward'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('target', 'target', 'trim|required');
	$this->form_validation->set_rules('bonus_tunai', 'bonus tunai', 'trim|required');
	$this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');
	$this->form_validation->set_rules('gambar', 'gambar', 'trim|required');

	$this->form_validation->set_rules('id_reward', 'id_reward', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Reward.php */
/* Location: ./application/controllers/Reward.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2021-09-05 07:31:34 */
/* https://jualkoding.com */