<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Veiculos extends MY_Controller
{

    /**
     * author: Ramon Silva
     * email: silva018-mg@yahoo.com.br
     *
     */

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->model('veiculos_model');
        $this->data['menuVeiculos'] = 'Veiculos';
    }

    public function index()
    {
        $this->gerenciar();
    }

    public function gerenciar()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vVeiculo')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar veiculos.');
            redirect(base_url());
        }

        $this->load->library('pagination');

        $this->data['configuration']['base_url'] = site_url('veiculos/gerenciar/');
        $this->data['configuration']['total_rows'] = $this->veiculos_model->count('veiculos');

        $this->pagination->initialize($this->data['configuration']);

        // $this->data['results'] = $this->veiculos_model->get('veiculos', '*', '', $this->data['configuration']['per_page'], $this->uri->segment(3));
        $this->data['results'] = $this->veiculos_model->getAll();

        $this->data['view'] = 'veiculos/veiculos';
        return $this->layout();
    }

    public function autoCompleteVeiculo()
    {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->veiculos_model->autoCompleteVeiculo($q);
        }
    }

    public function autoCompleteVeiculoByCliente($id)
    {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->veiculos_model->autoCompleteVeiculoByCliente($q, $id);
        }
    }

    public function adicionar()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'aVeiculo')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para adicionar veiculos.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        if ($this->form_validation->run('veiculos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $data = [
                'placa' => set_value('placa'),
                'marca' => set_value('marca'),
                'modelo' => set_value('modelo'),
                'cor' => set_value('cor'),
                'ano' => set_value('ano'),
                'combustivel' => set_value('combustivel'),
            ];

            if ($this->veiculos_model->add('veiculos', $data) == true) {
                $this->session->set_flashdata('success', 'Veiculo adicionado com sucesso!');
                log_info('Adicionou um veiculo');
                redirect(site_url('veiculos/adicionar/'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }
        $this->data['view'] = 'veiculos/adicionar';
        return $this->layout();
    }

    public function editar()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eVeiculo')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar veiculos.');
            redirect(base_url());
        }
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('veiculos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $data = [
                'placa' => $this->input->post('placa'),
                'marca' => $this->input->post('marca'),
                'modelo' => $this->input->post('modelo'),
                'cor' => $this->input->post('cor'),
                'ano' => $this->input->post('ano'),
                'combustivel' => $this->input->post('combustivel'),
            ];

            if ($this->veiculos_model->edit('veiculos', $data, 'idVeiculos', $this->input->post('idVeiculos')) == true) {
                $this->session->set_flashdata('success', 'Veiculo editado com sucesso!');
                log_info('Alterou um veiculo. ID: ' . $this->input->post('idVeiculos'));
                redirect(site_url('veiculos/editar/') . $this->input->post('idVeiculos'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um errro.</p></div>';
            }
        }

        $this->data['result'] = $this->veiculos_model->getById($this->uri->segment(3));
        $this->data['clientes'] = $this->veiculos_model->getClientes($this->uri->segment(3));

        $this->data['view'] = 'veiculos/editarVeiculo';
        return $this->layout();
    }

    public function vincularCliente()
    {
        $idClientes = $this->input->post('idClientes');
        $idVeiculos = $this->input->post('idVeiculos');

        $data = [
            'cliente_id' => $idClientes,
            'veiculo_id' => $idVeiculos
        ];

        if ($this->veiculos_model->checkClienteVinculado($idVeiculos, $idClientes)) {
            echo json_encode(['result' => false, 'message' => 'Esse cliente já está vinculado']);
            exit;
        }

        if ($this->veiculos_model->add('veiculos_clientes', $data) == true) {
            log_info('Vinculou cliente em um Veículo. ID (Veiculo): ' . $idVeiculos);
            echo json_encode(['result' => true]);
        } else {
            echo json_encode(['result' => false, 'message' => 'Ocorreu um erro ao tentar vincular cliente.']);
        }
    }

    public function desvincularCliente()
    {
        $idClientes = $this->input->post('idClientes');
        $idVeiculos = $this->input->post('idVeiculos');

        if ($this->veiculos_model->desvincularCliente($idVeiculos, $idClientes)) {
            log_info('Desvinculou cliente de um Veículo. ID (Veiculo): ' . $idVeiculos);
            echo json_encode(['result' => true]);
        } else {
            echo json_encode(['result' => false]);
        }
    }

    public function excluir()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'dVeiculo')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para excluir veiculos.');
            redirect(base_url());
        }

        $id = $this->input->post('id');
        if ($id == null) {
            $this->session->set_flashdata('error', 'Erro ao tentar excluir veiculo.');
            redirect(site_url('veiculos/gerenciar/'));
        }

        $this->veiculos_model->delete('veiculos', 'idVeiculos', $id);

        log_info('Removeu um veiculos. ID: ' . $id);

        $this->session->set_flashdata('success', 'Veiculo excluido com sucesso!');
        redirect(site_url('veiculos/gerenciar/'));
    }
}
