<?php
class Clientes_model extends CI_Model
{
    /**
     * author: Ramon Silva
     * email: silva018-mg@yahoo.com.br
     *
     */

    public function __construct()
    {
        parent::__construct();
    }

    public function getAll()
    {
        $this->db->select('*');
        $this->db->from('clientes');
        $this->db->order_by('idClientes', 'desc');
        return $this->db->get()->result();
    }

    public function get($table, $fields, $where = '', $perpage = 0, $start = 0, $one = false, $array = 'array')
    {
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->order_by('idClientes', 'desc');
        $this->db->limit($perpage, $start);
        if ($where) {
            $this->db->where($where);
        }

        $query = $this->db->get();

        $result = !$one ? $query->result() : $query->row();
        return $result;
    }

    public function getById($id)
    {
        $this->db->where('idClientes', $id);
        $this->db->limit(1);
        return $this->db->get('clientes')->row();
    }

    public function autoCompleteCliente($q)
    {
        $this->db->select('*');
        $this->db->limit(5);
        $this->db->like('nomeCliente', $q);
        $query = $this->db->get('clientes');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row_set[] = ['label' => $row['nomeCliente'] . ' | ' . $row['documento'] . ' | ' . $row['email'], 'id' => $row['idClientes']];
            }
            echo json_encode($row_set);
        }
    }

    public function getVeiculos($id = null)
    {
        $this->db->select('veiculos.*');
        $this->db->from('veiculos_clientes');
        $this->db->where('cliente_id', $id);
        $this->db->join('veiculos', 'veiculos.idVeiculos = veiculos_clientes.veiculo_id');
    
        return $this->db->get()->result();
    }

    public function checkVeiculoVinculado($veiculo_id, $cliente_id)
    {
        $this->db->where('veiculo_id', $veiculo_id);
        $this->db->where('cliente_id', $cliente_id);

        return $this->db->get('veiculos_clientes')->row();
    }

    public function desvincularVeiculo($veiculo_id, $cliente_id)
    {
        $this->db->where('veiculo_id', $veiculo_id);
        $this->db->where('cliente_id', $cliente_id);
        $this->db->delete('veiculos_clientes');
        if ($this->db->affected_rows() == '1') {
            return true;
        }
        
        return false;
    }

    public function add($table, $data)
    {
        $this->db->insert($table, $data);
        if ($this->db->affected_rows() == '1') {
            return $this->db->insert_id($table);
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

    public function count($table)
    {
        return $this->db->count_all($table);
    }

    public function getOsByCliente($id)
    {
        $this->db->select('os.*, veiculos.placa');
        $this->db->from('os');
        $this->db->join('veiculos', 'veiculos.idVeiculos = os.veiculo_id');
        $this->db->where('os.clientes_id', $id);
        $this->db->order_by('idOs', 'desc');
        return $this->db->get()->result();
    }

    /**
     * Retorna todas as OS vinculados ao cliente
     * @param int $id
     * @return array
     */
    public function getAllOsByClient($id)
    {
        $this->db->where('clientes_id', $id);
        return $this->db->get('os')->result();
    }

    /**
     * Remover todas as OS por cliente
     * @param array $os
     * @return boolean
     */
    public function removeClientOs($os)
    {
        try {
            foreach ($os as $o) {
                $this->db->where('os_id', $o->idOs);
                $this->db->delete('servicos_os');

                $this->db->where('os_id', $o->idOs);
                $this->db->delete('produtos_os');

                $this->db->where('idOs', $o->idOs);
                $this->db->delete('os');
            }
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

    /**
     * Retorna todas as Vendas vinculados ao cliente
     * @param int $id
     * @return array
     */
    public function getAllVendasByClient($id)
    {
        $this->db->where('clientes_id', $id);
        return $this->db->get('vendas')->result();
    }

    /**
     * Remover todas as Vendas por cliente
     * @param array $vendas
     * @return boolean
     */
    public function removeClientVendas($vendas)
    {
        try {
            foreach ($vendas as $v) {
                $this->db->where('vendas_id', $v->idVendas);
                $this->db->delete('itens_de_vendas');

                $this->db->where('idVendas', $v->idVendas);
                $this->db->delete('vendas');
            }
        } catch (Exception $e) {
            return false;
        }
        return true;
    }
}
