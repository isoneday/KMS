<?php
/**
 * @author Prima Noor 
 */
   
class ViewPdf extends HtmlResponse
{
   
   	function ProcessRequest()
   	{	
   	    $ObjPdf = Dispatcher::Instance()->load->library('TCPDF');
        
        // set document information
        $ObjPdf->SetCreator(PDF_CREATOR);
        $ObjPdf->SetAuthor('Nicola Asuni');
        $ObjPdf->SetTitle('TCPDF Example 001');
        $ObjPdf->SetSubject('TCPDF Tutorial');
        $ObjPdf->SetKeywords('TCPDF, PDF, example, test, guide');
        
        // set default header data
        $ObjPdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
        $ObjPdf->setFooterData($tc=array(0,64,0), $lc=array(0,64,128));
        
        // set header and footer fonts
        $ObjPdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $ObjPdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        
        // set default monospaced font
        $ObjPdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        
        //set margins
        $ObjPdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $ObjPdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $ObjPdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        
        //set auto page breaks
        $ObjPdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        
        //set image scale factor
        $ObjPdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        
        //set some language-dependent strings
        //$ObjPdf->setLanguageArray($l);
        
        // ---------------------------------------------------------
        
        // set default font subsetting mode
        $ObjPdf->setFontSubsetting(true);
        
        // Set font
        // dejavusans is a UTF-8 Unicode font, if you only need to
        // print standard ASCII chars, you can use core fonts like
        // helvetica or times to reduce file size.
        $ObjPdf->SetFont('dejavusans', '', 14, '', true);
        
        // Add a page
        // This method has several options, check the source code documentation for more information.
        $ObjPdf->AddPage();
        
        // set text shadow effect
        $ObjPdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
        
        // Set some content to print
        $html = '
        <h1>Welcome to <a href="http://www.tcpdf.org" style="text-decoration:none;background-color:#CC0000;color:black;">&nbsp;<span style="color:black;">TC</span><span style="color:white;">PDF</span>&nbsp;</a>!</h1>
        <i>This is the first example of TCPDF library.</i>
        <p>This text is printed using the <i>writeHTMLCell()</i> method but you can also use: <i>Multicell(), writeHTML(), Write(), Cell() and Text()</i>.</p>
        <p>Please check the source code documentation and other examples for further information.</p>
        <p style="color:#CC0000;">TO IMPROVE AND EXPAND TCPDF I NEED YOUR SUPPORT, PLEASE <a href="http://sourceforge.net/donate/index.php?group_id=128076">MAKE A DONATION!</a></p>
        ';
        
        // Print text using writeHTMLCell()
        $ObjPdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);        
        
        $ObjPdf->save();
        exit;
        
   	}
}
?>