<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;

class Pdf
{
    public function __construct(){
        // include autoloader
        require_once dirname(__FILE__).'/dompdf/autoload.inc.php';

        // instantiate and use the dompdf class
        $options = new Options();
        $options->setIsRemoteEnabled(true);
        $pdf = new Dompdf($options);

        $CI =& get_instance();
        $CI->dompdf = $pdf;
    }
}
?>
