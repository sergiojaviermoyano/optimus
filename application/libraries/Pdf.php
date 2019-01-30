<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**


* CodeIgniter PDF Library
 *
 * Generate PDF's in your CodeIgniter applications.
 *
 * @package         CodeIgniter
 * @subpackage      Libraries
 * @category        Libraries
 * @author          Chris Harvey
 * @license         MIT License
 * @link            https://github.com/chrisnharvey/CodeIgniter-  PDF-Generator-Library



*/

require_once APPPATH.'third_party/dompdf/autoload.inc.php';

use Dompdf\Dompdf;
class Pdf extends DOMPDF
{
/**
 * Get an instance of CodeIgniter
 *
 * @access  protected
 * @return  void
 */
protected function ci()
{
    return get_instance();
}

/**
 * Load a CodeIgniter view into domPDF
 *
 * @access  public
 * @param   string  $view The view to load
 * @param   array   $data The view data
 * @return  void
 */
    public function load_view($view, $data = array())
    {
        $dompdf = new Dompdf();
        $html = $this->ci()->load->view($view, $data, TRUE);

        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();
        $time = time();

        // Output the generated PDF to Browser
        $dompdf->stream("welcome-". $time);
    }

    public function generate_pdf($view, $data = array()){

        
        $file_directory=ASSETS.'reports';        
		if(!is_dir($file_directory)){
			mkdir($file_directory);			
        }

        $file_directory.='/comprobantes';        
		if(!is_dir($file_directory)){
			mkdir($file_directory);			
        }
        
       
        $dompdf = new Dompdf();
        $html = $this->ci()->load->view($view, $data, TRUE);
        //echo $html;
        //echo utf8_decode($html);
        //die("antes");

        //$html=' <html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/></head><body><h1>Codeigniter 3 - Generate PDF from view using dompdf library with example</h1><table style="border:1px solid red;width:100%;">	<tr>		<th style="border:1px solid red">Id</th>		<th style="border:1px solid red">Name</th>		<th style="border:1px solid red">Email</th>	</tr>	<tr>		<td style="border:1px solid red">1</td>		<td style="border:1px solid red">Hardik</td>		<td style="border:1px solid red">hardik@gmail.com</td>	</tr>	<tr>		<td style="border:1px solid red">2</td>		<td style="border:1px solid red">Paresh</td>		<td style="border:1px solid red">paresh@gmail.com</td></tr></table></body></html>';
        //echo utf8_decode($html);
        //die();
        $dompdf->load_html(utf8_decode($html));
        //$dompdf->loadHtml($html);
        //$dompdf->loadHtml(utf8_encode("<h1>Señor CARACTER</h1>"));
        
        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A5');//, 'portrains');
        // Render the HTML as PDF
       // var_dump($dompdf->loadHtml);
        //die("NFIN");
        try {
            //$dompdf->render();
            $dompdf->render();
           // $dompdf->stream();
            //die("FIN");
            echo "post render";
            
            $time = time();
        
            $output = $dompdf->output();
            
            $file_name='comprobante_'.$time.'.pdf';
            
            file_put_contents($file_directory.'/'.$file_name, $output);
            
            return './assets/reports/comprobantes/'.$file_name;
            
        } catch(Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "\n";
            // Do something here with $e and notify the user of the error in whatever way you see fit
        }
        
		
    }



     public function pdf_demo($view, $data = array()){
        $file_directory=ASSETS.'reports/orders_minorista';
        
		if(!is_dir($file_directory)){
			mkdir($file_directory);			
        }
        
       
        $dompdf = new Dompdf();
        
        $paper_size = array(0,0,360,360);
        $dompdf->set_paper($paper_size);
        //$html = $this->ci()->load->view($view, $data, TRUE);
        ob_start(); 
        $html='
            <html>
            <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <title>Compronante</title>
            </head>
            <body>
            <table cellspacing="0" cellpadding="0" style="table-layout: fixed; width: 100%;">
	<thead>
		<tr>
			<th class="text-center">Chinese</th><th class="text-center">Korean</th><th class="text-center">English</th><th class="text-center">Russian</th>
		</tr>
	<tbody>
		<tr>
			<td class="text-center">asdada</td><td class="text-center">asdadsa</td><td class="text-center">sasdadsa</td><td class="text-center">xcvxvxc</td>
		</tr>
	</tbody>
</table>
            
            </body>
            </html>';


            $dompdf->load_html(utf8_decode($html));
        $dompdf->render();

        $output = $dompdf->output();
        $time = time();   
        $file_name='comprobante_'.$time.'.pdf';
        
        file_put_contents($file_directory.'/'.$file_name, $output);
        
        echo './assets/reports/orders_minorista/'.$file_name;
        die("FIN");
    }
}