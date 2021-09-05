<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Transfer extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Transfer_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'transfer/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'transfer/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'transfer/index.html';
            $config['first_url'] = base_url() . 'transfer/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Transfer_model->total_rows($q);
        $transfer = $this->Transfer_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'transfer_data' => $transfer,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'transfer/transfer_list',
            'konten' => 'transfer/transfer_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Transfer_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_transfer' => $row->id_transfer,
		'no_transaksi' => $row->no_transaksi,
		'id_member' => $row->id_member,
		'keterangan' => $row->keterangan,
		'tanggal' => $row->tanggal,
		'jam' => $row->jam,
		'jumlah' => $row->jumlah,
		'created_at' => $row->created_at,
		'updated_at' => $row->updated_at,
	    );
            $this->load->view('transfer/transfer_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('transfer'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'transfer/transfer_form',
            'konten' => 'transfer/transfer_form',
            'button' => 'Create',
            'action' => site_url('transfer/create_action'),
	    'id_transfer' => set_value('id_transfer'),
	    'no_transaksi' => set_value('no_transaksi'),
	    'id_member' => set_value('id_member'),
	    'keterangan' => set_value('keterangan'),
	    'tanggal' => set_value('tanggal'),
	    'jam' => set_value('jam'),
        'jumlah' => set_value('jumlah'),
	    'ke' => set_value('ke'),
	    'created_at' => set_value('created_at'),
	    'updated_at' => set_value('updated_at'),
	);
        $this->load->view('v_index', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'no_transaksi' => $this->input->post('no_transaksi',TRUE),
		'id_member' => $this->input->post('id_member',TRUE),
		'keterangan' => $this->input->post('keterangan',TRUE),
		'tanggal' => $this->input->post('tanggal',TRUE),
		'jam' => $this->input->post('jam',TRUE),
        'jumlah' => $this->input->post('jumlah',TRUE),
        'ke' => $this->input->post('ke',TRUE),
		'jenis' => $this->input->post('jenis',TRUE),
		'created_at' => get_waktu(),
	    );

            $this->Transfer_model->insert($data);

            $jenis = $this->input->post('jenis');
            if ($jenis  == 'member') {
                $this->db->where('no_transaksi', $this->input->post('no_transaksi'));
                $this->db->where('ke', $this->input->post('ke'));
                $this->db->update('jadwal_transfer', array('is_done' => 'y', 'updated_at' => get_waktu()));
            }

            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('transfer/index/'.$this->input->post('no_transaksi',TRUE)));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Transfer_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'transfer/transfer_form',
                'konten' => 'transfer/transfer_form',
                'button' => 'Update',
                'action' => site_url('transfer/update_action'),
		'id_transfer' => set_value('id_transfer', $row->id_transfer),
		'no_transaksi' => set_value('no_transaksi', $row->no_transaksi),
		'id_member' => set_value('id_member', $row->id_member),
		'keterangan' => set_value('keterangan', $row->keterangan),
		'tanggal' => set_value('tanggal', $row->tanggal),
		'jam' => set_value('jam', $row->jam),
        'jumlah' => set_value('jumlah', $row->jumlah),
        'ke' => set_value('ke', $row->ke),
		'jenis' => set_value('jenis', $row->jenis)
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('transfer'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_transfer', TRUE));
        } else {
            $data = array(
		'no_transaksi' => $this->input->post('no_transaksi',TRUE),
		'id_member' => $this->input->post('id_member',TRUE),
		'keterangan' => $this->input->post('keterangan',TRUE),
		'tanggal' => $this->input->post('tanggal',TRUE),
		'jam' => $this->input->post('jam',TRUE),
        'jumlah' => $this->input->post('jumlah',TRUE),
        'ke' => $this->input->post('ke',TRUE),
		'jenis' => $this->input->post('jenis',TRUE),
		'updated_at' => get_waktu(),
	    );

            $this->Transfer_model->update($this->input->post('id_transfer', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('transfer'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Transfer_model->get_by_id($id);

        $no_transaksi = $row->no_transaksi;
        if ($row) {
            $this->db->where('no_transaksi', $row->no_transaksi);
            $this->db->where('ke', $row->ke);
            $this->db->update('jadwal_transfer', array('is_done' => 't', 'updated_at' => get_waktu()));

            $this->Transfer_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('transfer/index/'.$no_transaksi));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('transfer/index/'.$no_transaksi));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('no_transaksi', 'no transaksi', 'trim|required');
	$this->form_validation->set_rules('id_member', 'id member', 'trim|required');
	$this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');
	$this->form_validation->set_rules('tanggal', 'tanggal', 'trim|required');
	$this->form_validation->set_rules('jam', 'jam', 'trim|required');
	$this->form_validation->set_rules('jumlah', 'jumlah', 'trim|required');

	$this->form_validation->set_rules('id_transfer', 'id_transfer', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Transfer.php */
/* Location: ./application/controllers/Transfer.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2021-09-02 12:08:31 */
/* https://jualkoding.com */