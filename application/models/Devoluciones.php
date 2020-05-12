<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Devoluciones extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }
    
    public function getTotalDevoluciones($data = null){
        $response = array();
        $this->db->select('d.*,DATE_FORMAT(devFecha, "%d-%m-%Y %H:%i") as fecha, u.usrNick');
        $this->db->order_by('devFecha','desc');
        if($data['search']['value']!=''){
            $this->db->where('devId',$data['search']['value']);
            $this->db->or_like('DATE_FORMAT(devFecha, "%d-%m-%Y %H:%i")',$data['search']['value']);
            $this->db->limit($data['length'],$data['start']);
        }
        $this->db->from('devolucion as d');
        $this->db->join('sisusers as u', ' u.usrId = d.usrId');
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    public function getDevolucion( $data = null){
    
        $this->db->select('d.*,DATE_FORMAT(devFecha, "%d-%m-%Y %H:%i") as fecha, u.usrNick ');
        $this->db->order_by('devFecha','desc');
        if($data['search']['value']!=''){
            $this->db->where('devId',$data['search']['value']);
            $this->db->or_like('DATE_FORMAT(devFecha, "%d-%m-%Y %H:%i")',$data['search']['value']);
        }
        $this->db->from('devolucion as d');
        $this->db->join('sisusers as u', ' u.usrId = d.usrId');
        $query = $this->db->get();
        return $query->result_array();
    }

    function getDevolucion_($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$action = $data['act'];
			$iddev = $data['id'];
			$data = array();

            //Datos de la marca
            $this->db->select('o.*, c.cliApellido, c.cliNombre, DATE_FORMAT(o.oFecha, "%d-%m-%Y %H:%i") as fecha, d.devObservacion');
            $this->db->from('devolucion d');
            $this->db->join('orden o', 'o.oId = d.oId');
            $this->db->join('clientes as c', ' c.cliId = o.cliId');
            $this->db->where('d.devId',$iddev);
			$query= $this->db->get();
			if ($query->num_rows() != 0)
			{
				$c = $query->result_array();
                $data['devolucion'] = $c[0];
                
                $query = $this->db->get_where('devoluciondetalle', array('devId' => $iddev));
                $data['devolucion']['detalle'] = $query->result_array();

			} else {
				$dev = array();
				$dev['devId'] = '';
                $dev['oId'] = '';
                $dev['devFecha'] = '';
                $dev['devObservacion'] = '';
                $dev['cliNombre'] = '';
                $dev['cliApellido'] = '';
                $dev['fecha'] = '';
                $dev['detalle'] = array();
				$data['devolucion'] = $dev;
			}
			$data['devolucion']['action'] = $action;

			//Readonly
			$readonly = false;
			if($action == 'Del' || $action == 'View'){
				$readonly = true;
			}
			$data['read'] = $readonly;
			$data['action'] = $action;

			return $data;
		}
    }
    
    function getOrder($oId = null){
		if($oId == null)
		{
			return false;
		}
		else
		{
            $data = array();
            
            //devoluciones
            $this->db->select('oId');
            $this->db->from('devolucion');
			$query= $this->db->get();
            $notIn = array();
            foreach ($query->result_array() as $row)
            {
                $notIn[] = $row['oId'];
            }

            //Datos del Ordern
            $this->db->select('o.*, c.cliApellido, c.cliNombre, DATE_FORMAT(o.oFecha, "%d-%m-%Y %H:%i") as fecha');
            $this->db->from('orden o');
            $this->db->join('clientes as c', ' c.cliId = o.cliId');
            
            $this->db->where(array('o.oId'=>$oId, 'o.oEsPresupuesto' => 0));
            $this->db->where_not_in('o.oId',$notIn);
			$query= $this->db->get();
			if ($query->num_rows() > 0)
			{
				$order = $query->result_array();
				$data['order'] = $order[0];
				$this->db->select("od.*, a.artBarCode");
				$this->db->from('ordendetalle od');
				$this->db->join('articles a','a.artId=od.artId', 'left outer');
				$this->db->where('oId',$oId);
				$query = $this->db->get();
				$detalleCompra=($query->num_rows()>0)?$query->result_array():array();
				$data['detalle']=$detalleCompra;
			}
			return $data;
		}
    }
    
    function setDevoluciones($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$id 	= $data['id'];
            $det 	= $data['det'];
            $obs    = $data['obs'];

            $userdata = $this->session->userdata('user_data');
            $usrId = $userdata[0]['usrId'];

			$data = array(
                   'oId' 				=> $id,
                   'usrId'              => $usrId,
                   'devObservacion'     => $obs
				);

            //Agregar devoluciones
            $idDevolucion = 0;
            if($this->db->insert('devolucion', $data) == false) {
                return false;
            }else{
                $idDevolucion = $this->db->insert_id();
            }

            if($idDevolucion > 0){
                foreach ($det as $d) {
                    $dev = array(
                        'devId'             => $idDevolucion,
                        'artId'             => $d['artId'],
                        'devdCant'          => $d['odDevuelto'],
                        'artDescripcion'    => $d['artDescripcion']
                    );
                    if($this->db->insert('devoluciondetalle', $dev) == false) {
                        return false;
                    }

                    $stock = array(
                        'artId' 		=> $d['artId'],
                        'stkCant'		=> $d['odDevuelto'],
                        'stkOrigen'		=> 'DV',
                        'refId'			=> $idDevolucion
                    );

                    if($this->db->insert('stock', $stock) == false) {
                        return false;
                    }
                }
            }

			return true;

		}
	}
}

?>