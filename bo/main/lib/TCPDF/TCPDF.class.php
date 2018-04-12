<?php

/**
 * PT. Gamatechno Indonesia
 *
 * Description of PdfxResponse
 *
 * @author apriskiswandi
 */
require_once 'tcpdf/config/lang/eng.php';
require_once 'tcpdf/tcpdf.php';

class GT_TCPDF extends TCPDF implements ResponseIntf {


    /**
     * Pdf
     *
     * @var PdfxResponse_filename
     */
    private $filename;

    /**
     * Pdf
     *
     * @var PdfxResponse_dest default "I"
     */
    private $dest = "I";

    public function __construct() {
        parent::__construct(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    }

    /**
     * Set Filename
     *
     * @param $filename String) namafile.pdf
     */
    function setFileName($filename='') {
        $this->filename = $filename;
    }

    function getFileName() {
        if (trim($this->filename) == '')
            $this->filename = "data_" . date('Ymdhis') . ".pdf";
        return $this->filename;
    }

    /**
     * Set Dest Untuk Mode Output
     *
     * I: send the file inline to the browser (default). The plug-in is used if available. The name given by name is used when one selects the "Save as" option on the link generating the PDF.
     * D: send to the browser and force a file download with the name given by name.
     * F: save to a local server file with the name given by name.
     * S: return the document as a string (name is ignored).
     * FI: equivalent to F + I option
     * FD: equivalent to F + D option
     * E: return the document as base64 mime multi-part email attachment (RFC 2045)
     * 
     * @param $dest (String) I, D, F, S, FI, FD, E
     */
    function setDest($dest) {
        $this->dest = $dest;
    }

    function save($path="") {
        if (trim($path != '')) {
            $this->Pdf->Output($path, "F");
        } else {
            $this->Pdf->Output($this->GetFileName(), $this->dest);
        }
    }

}

?>
