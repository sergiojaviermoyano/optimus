<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Articles extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function Articles_List(){

		$query= $this->db->get('articles');

		if ($query->num_rows()!=0)
		{
			return $query->result_array();
		}
		else
		{
			return array();
		}
	}

	function Articles_List_Stock(){
		$this->db->select('*, (select sum(stkCant) from stock as s Where s.artId = articles.artId) as stock,
						(Case
							When (select sum(stkCant) from stock as s Where s.artId = articles.artId) = null then 1
							When (select sum(stkCant) from stock as s Where s.artId = articles.artId) > artMinimo Then 4
							Else 1
						End) as ordenN
						');
		$this->db->order_by('ordenN', 'asc');
		$this->db->from('articles');
		$query= $this->db->get();

		if ($query->num_rows()!=0)
		{
			return $query->result_array();
		}
		else
		{
			return array();
		}
	}

	function getTotalArticles($data){
		$this->db->order_by('artDescription', 'desc');
		if($data['search']['value']!=''){
			$this->db->like('artDescription', $data['search']['value']);
			$this->db->or_like('artBarCode', $data['search']['value']);
			//$this->db->limit($data['length'],$data['start']);
		}
		$query= $this->db->get('articles');
		return $query->num_rows();
	}
	function Articles_List_datatable($data){
		$this->db->order_by('artDescription', 'desc');
		$this->db->limit($data['length'],$data['start']);
		if($data['search']['value']!=''){
			$this->db->like('artDescription', $data['search']['value']);
			$this->db->or_like('artBarCode', $data['search']['value']);
		}
		$this->db->limit($data['length'],$data['start']);
		$query= $this->db->get('articles');
		//echo $this->db->last_query();

		if ($query->num_rows()!=0)
		{
			return $query->result_array();
		}
		else
		{
			return false;
		}
	}

	function getArticle($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$action = $data['act'];
			$idArt = $data['id'];

			$data = array();
			//Cotizacion dolar
			$query= $this->db->get('configuracion');
			if ($query->num_rows() != 0)
			{
				$c = $query->result_array();
				$data['cotizacionDolar'] = $c[0]['cotizacionDolar'];
			}else{
				$data['cotizacionDolar'] = 1;
			}

			//Datos del articulo
			$query= $this->db->get_where('articles',array('artId'=>$idArt));
			if ($query->num_rows() != 0)
			{
				$c = $query->result_array();
				$data['article'] = $c[0];

			} else {
				$art = array();

				$art['artId'] = '';
				$art['artBarCode'] = '';
				$art['artDescription'] = '';
				$art['artCoste'] = '';
				$art['artCosteIsDolar'] = '';
				$art['artMarginMayorista'] = '';
				$art['artMarginMinorista'] = '';
				$art['artMarginMayoristaIsPorcent'] = '';
				$art['artMarginMinoristaIsPorcent'] = '';
				$art['artEstado'] = 'AC';
			  $art['rubId']	= '';
        $art['artMinimo']	= '';
        $art['marcaId'] = '';
				$data['article'] = $art;
			}
			$data['article']['action'] = $action;

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

	function setArticle($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$id 	= $data['id'];
            $act 					= $data['act'];
            $name 				= $data['name'];
            $price 				= $data['price'];
						$priceIsDolar = $data['priceIsD'];
            $marginMa			= $data['margma'];
            $marginMaP 		= $data['margPma'];
						$marginMi			= $data['margmi'];
            $marginMiP 		= $data['margPmi'];
            $status 			= $data['status'];
            $code 				= $data['code'];
            $rubId 			=	$data['rubId'];
            $marcaId 			=	$data['marcaId'];
            $artMinimo 		=	$data['artMinimo'];

			$data = array(
				   'artBarCode'						=> $code,
				   'artDescription' 			=> $name,
				   'artCoste'							=> $price,
					 'artMarginMinorista'		=> $marginMi,
					 'artMarginMinoristaIsPorcent' 	=> ($marginMiP === 'true'),
				   'artEstado' 						=> $status,
					 'artMinimo'						=> $artMinimo,
					 'rubId'								=> $rubId,
					 'artMarginMayorista'		=> $marginMa,
					 'artMarginMayoristaIsPorcent' 	=> ($marginMaP === 'true'),
					 'artCosteIsDolar'			=> ($priceIsDolar === 'true'),
					 'marcaId'							=> $marcaId

				);

			switch($act){
				case 'Add':
					//Agregar Artículo
					if($this->db->insert('articles', $data) == false) {
						//return json_encode(array('result'=>'error','message'=>''));
						return false;
					}
					break;

				 case 'Edit':
				 	//Actualizar Artículo
				 	if($this->db->update('articles', $data, array('artId'=>$id)) == false) {
				 		return false;
				 	}
				 	break;

				 case 'Del':
				 	//Eliminar Artículo
				 	if($this->db->delete('articles', array('artId'=>$id)) == false) {
				 		return false;
				 	}
				 	break;

			}
			return true;

		}
	}

	function buscadorArticlesNoPrice($data = null){
		$str = '';
		if($data != null){
			$str = $data['str'];
		}

		$articles = array();

		$this->db->select('artId, artDescription, artBarcode, descripcion');
		$this->db->from('articles');
		$this->db->join('marcaart as m', 'm.id = marcaId', 'inner');
		$this->db->like('artDescription', $str, 'both');
		$this->db->or_like('artBarCode', $str, 'both');
		$this->db->where(array('artEstado'=>'AC'));
		$query = $this->db->get();
		if ($query->num_rows()!=0)
		{
			$articles = $query->result_array();
			return $articles;
		}

		return array();
	}

	function getArticleJson($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$idArt = $data['id'];

			$data = array();
			$query= $this->db->get_where('articles',array('artId'=>$idArt));
			if ($query->num_rows() != 0)
			{
				$c = $query->result_array();
				$data['article'] = $c[0];
				//Cotizacion-------------------------------
				$cotizacion = 1;
				$query= $this->db->get('configuracion');
				if ($query->num_rows() != 0)
				{
					$c = $query->result_array();
					$cotizacion = $c[0]['cotizacionDolar'];
				}
				//-----------------------------------------
				$data['article']['dolar'] = $cotizacion;
			}
			return $data;
		}
	}

	function getArticleJsonMayorista($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$idArt = $data['id'];

			$data = array();
			$query= $this->db->get_where('articles',array('artId'=>$idArt));
			if ($query->num_rows() != 0)
			{
				$c = $query->result_array();
				$data['article'] = $c[0];
				//Cotizacion-------------------------------
				$cotizacion = 1;
				$query= $this->db->get('configuracion');
				if ($query->num_rows() != 0)
				{
					$c = $query->result_array();
					$cotizacion = $c[0]['cotizacionDolar'];
				}
				//-----------------------------------------
				$data['article']['dolar'] = $cotizacion;
			}
			return $data;
		}
	}

	function validateArticle($data = null){
		if($data['act'] == 'Add'){
			$query= $this->db->get_where('articles',array('artBarCode'=>$data['code']));
			if($query->num_rows() > 0){
				return false;
			} else {
				return true;
			}
		} else {
			$query= $this->db->get_where('articles',array('artBarCode'=>$data['code'], 'artId != ' => $data['id']));
			if($query->num_rows() > 0){
				return false;
			} else {
				return true;
			}
		}
	}

	function buscadorArticlesPrice($data = null){
		$str = '';
		if($data != null){
			$str = $data['str'];
		}

		//Cotizacion-------------------------------
		$cotizacion = 1;
		$query= $this->db->get('configuracion');
		if ($query->num_rows() != 0)
		{
			$c = $query->result_array();
			$cotizacion = $c[0]['cotizacionDolar'];
		}
		//-----------------------------------------
		$articles = array();

		$this->db->select('artId, artDescription, artBarcode, artCoste, artMarginMinorista, artMarginMinoristaIsPorcent, artCosteIsDolar, \''.floatval($cotizacion).'\' as dolar, (select sum(stkCant) from stock where stock.artId = articles.artId) as stock, descripcion');
		$this->db->from('articles');
		$this->db->join('marcaart as m', 'm.id = marcaId', 'inner');
		$this->db->like('artDescription', $str, 'both');
		$this->db->or_like('artBarCode', $str, 'both');
		$this->db->where(array('artEstado'=>'AC'));
		$query = $this->db->get();
		if ($query->num_rows()!=0)
		{
			$articles = $query->result_array();
			return $articles;
		}

		return array();
	}

	function buscadorArticlesPriceMayorista($data = null){
		$str = '';
		if($data != null){
			$str = $data['str'];
		}

		//Cotizacion-------------------------------
		$cotizacion = 1;
		$query= $this->db->get('configuracion');
		if ($query->num_rows() != 0)
		{
			$c = $query->result_array();
			$cotizacion = $c[0]['cotizacionDolar'];
		}
		//-----------------------------------------
		$articles = array();

		$this->db->select('artId, artDescription, artBarcode, artCoste, artMarginMayorista, artMarginMayoristaIsPorcent, artCosteIsDolar, \''.floatval($cotizacion).'\' as dolar, (select sum(stkCant) from stock where stock.artId = articles.artId) as stock, (select sum(stkCant) from stockreserva where stockreserva.artId = articles.artId) as reserva');
		$this->db->from('articles');
		$this->db->like('artDescription', $str, 'both');
		$this->db->or_like('artBarCode', $str, 'both');
		$this->db->where(array('artEstado'=>'AC'));
		$query = $this->db->get();
		if ($query->num_rows()!=0)
		{
			$articles = $query->result_array();
			return $articles;
		}

		return array();
	}
/*
	function searchByCode($data = null){
		$str = '';
		if($data != null){
			$str = $data['code'];
		}

		$articles = array();

		$this->db->select('*');
		$this->db->from('articles');
		$this->db->where(array('artBarCode'=>$str, 'artEstado'=>'AC'));
		$this->db->or_where(array('artDescription' => $str));
		$query = $this->db->get();
		if ($query->num_rows()!=0)
		{
			if($query->num_rows() > 1){
				//Multiples coincidencias
			} else {
				//Unica coincidencia
				$a = $query->result_array();
				$articles = $a[0];

				//Calcular precios
				$pUnit = $articles['artCoste'];
				if($articles['artIsByBox'] == 1){
					$pUnit = $articles['artCoste'] / $articles['artCantBox'];
					$articles['artCoste'] = $pUnit;
				}

				if($articles['artMarginIsPorcent'] == 1){
					$articles['pVenta'] = $pUnit + ($pUnit * ($articles['artMargin'] / 100));
				} else {
					$articles['pVenta'] = $pUnit + $articles['artMargin'];
				}

			}
			return $articles;
		}

		return $articles;
	}
	*/
	function searchByAll($data = null){
		$str = '';
		if($data != null){
			$str = $data['code'];
		}

		$art = array();

		$this->db->select('*, (select sum(stkCant) from stock where stock.artId = articles.artId) as stock');
		$this->db->from('articles');
		$this->db->where('artEstado','AC');
		if($str != ''){
			$this->db->like('artBarCode',$str);
			$this->db->or_like('artDescription',$str);
		}
		$query = $this->db->get();
		if ($query->num_rows()!=0)
		{
			$proccess = $query->result_array();
			foreach($proccess as $a){
				$articles = $a;
				$art[] = $articles;
			}
		}

		return $art;
	}

	public function update_prices_by_rubro($data){

		foreach($data['arts'] as $item ){
			$this->db->set('artCoste', $item['coste'],FALSE);
			$this->db->where('artId',$item['id']);

			if(!$this->db->update("articles")){
				return false;
			}
		}
		return true;
	}

		public function get_for_update_prices($data = null){
			if($data == null){
				return false;
			} else {
				//Cotizacion-------------------------------
				$cotizacion = 1;
				$query= $this->db->get('configuracion');
				if ($query->num_rows() != 0)
				{
					$c = $query->result_array();
					$cotizacion = $c[0]['cotizacionDolar'];
				}
				//-----------------------------------------

				$where = array();
				//marca
				if($data['mar'] != ''){
					$where['marcaId'] = $data['mar'];
				}
				//subrubro
				if($data['sub'] != ''){
					$where['subrId'] = $data['sub'];
				} else {
					//Ver si es por rubro
					if($data['rub'] != ''){
							$this->db->where_in('subrId', $this->getSubrubros($data['rub'] ));
					} else {
						//nada
					}
				}
				$this->db->select('artId, artBarCode, artDescription, artCoste, artMarginMinorista, artMarginMinoristaIsPorcent, artCosteIsDolar, \''.floatval($cotizacion).'\' as dolar');
				$this->db->from('articles');
				$this->db->where($where);
				$query = $this->db->get();
				return $query->result_array();
			}
		}

	function getSubrubros($id){
		$da = array();
		$this->db->select('subrId');
		$query = $this->db->get_where('subrubros', array('rubId' => $id, 'subrEstado' => 'AC'));
		foreach ($query->result_array() as $value) {
			array_push($da, $value['subrId']);
		};
		return $da;
	}
}
?>
