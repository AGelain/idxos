<?php
class Veiculos_model extends CI_Model
{    
    public function __construct()
    {
        parent::__construct();
    }

    public function getAll()
    {
        $this->db->select('*');
        $this->db->from('veiculos');
        $this->db->order_by('idVeiculos', 'desc');
        return $this->db->get()->result();
    }
    
    public function get($table, $fields, $where = '', $perpage = 0, $start = 0, $one = false, $array = 'array')
    {
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->order_by('idVeiculos', 'desc');
        $this->db->limit($perpage, $start);
        if ($where) {
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }

    public function getById($id)
    {
        $this->db->where('idVeiculos', $id);
        $this->db->limit(1);
        return $this->db->get('veiculos')->row();
    }

    public function autoCompleteVeiculoByCliente($q, $id)
    {
        $this->db->select('v.*');
        $this->db->limit(5);
        $this->db->like('v.placa', $q);
        $this->db->where('veiculos_clientes.cliente_id', $id);
        $this->db->join('veiculos v', 'v.idVeiculos = veiculos_clientes.veiculo_id');
        $query = $this->db->get('veiculos_clientes');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row_set[] = ['label' => $row['placa'] . ' | ' . $row['marca'] . ' | ' . $row['modelo'], 'id' => $row['idVeiculos']];
            }
            echo json_encode($row_set);
        }
    }

    public function autoCompleteVeiculo($q)
    {
        $this->db->select('*');
        $this->db->limit(5);
        $this->db->like('placa', $q);
        $query = $this->db->get('veiculos');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row_set[] = ['label' => $row['placa'] . ' | ' . $row['marca'] . ' | ' . $row['modelo'], 'id' => $row['idVeiculos']];
            }
            echo json_encode($row_set);
        }
    }

    public function getClientes($id = null)
    {
        $this->db->select('clientes.*');
        $this->db->from('veiculos_clientes');
        $this->db->join('clientes', 'clientes.idClientes = veiculos_clientes.cliente_id');
        $this->db->where('veiculo_id', $id);

        return $this->db->get()->result();
    }

    public function checkClienteVinculado($veiculo_id, $cliente_id)
    {
        $this->db->where('veiculo_id', $veiculo_id);
        $this->db->where('cliente_id', $cliente_id);

        return $this->db->get('veiculos_clientes')->row();
    }
    
    public function add($table, $data)
    {
        $this->db->insert($table, $data);
        if ($this->db->affected_rows() == '1') {
            return true;
        }
        
        return false;
    }
    
    public function edit($table, $data, $fieldID, $ID)
    {
        $this->db->where($fieldID, $ID);
        $this->db->update($table, $data);

        if ($this->db->affected_rows() >= 0) {
            return true;
        }
        
        return false;
    }
    
    public function delete($table, $fieldID, $ID)
    {
        $this->db->where($fieldID, $ID);
        $this->db->delete($table);
        if ($this->db->affected_rows() == '1') {
            return true;
        }
        
        return false;
    }

    public function desvincularCliente($veiculo_id, $cliente_id)
    {
        $this->db->where('veiculo_id', $veiculo_id);
        $this->db->where('cliente_id', $cliente_id);
        $this->db->delete('veiculos_clientes');
        if ($this->db->affected_rows() == '1') {
            return true;
        }
        
        return false;
    }
    
    public function count($table)
    {
        return $this->db->count_all($table);
    }
}
