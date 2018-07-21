<?php
require_once ("../../Lib/dompdf_0-8-2/dompdf/autoload.inc.php");
require_once ("../../Config/Conn_Config.php");
require_once ("../../Config/FileUpload_Config.php");
require_once ("../../Engines/SessionManager.php");

use Dompdf\Dompdf;

date_default_timezone_set("Asia/Kuala_Lumpur");

function RenderPDF($html_c, $name){
    $eng_pdf = new Dompdf();
    $eng_pdf->set_option('defaultFont', 'Times New Roman');

    $eng_pdf->loadHtml($html_c);

    $eng_pdf->setPaper('A4');

    $eng_pdf->render();

    $eng_pdf->stream($name, array("Attachment" => false));

    exit(0);
}

function WriteInvoiceHTML($Comp_Id, $Inv_No){
    $Session = new SessionManager();
    $Session->StartSession();
    $UserPic = $Session->GetSession("User_Pic");

    $Conn = new mysqli(Connection::$Host, Connection::$DB_Id, Connection::$DB_Pw, Connection::$Schema);
    $Data_Comp = array(); $Data_Inv = array(); $Data_Desc = array(); $tax_Mode = array();
    
    $Query = "CALL sp_PDFOutputInvoice(?,?);";
    
    $stmt = $Conn->prepare($Query);
    $stmt->bind_param("is", $Comp_Id, $Inv_No);
    $stmt->execute();
    
    $Data_Set = 0;
    
    while($Res = $stmt->get_result()){
        
        if($Res->num_rows > 0){
            switch ($Data_Set){
                case 0:
                    while($row = $Res->fetch_assoc()){
                        foreach($row as $cols){
                            array_push($Data_Comp, $cols);
                        }
                    }
                    break;
                    
                case 1:
                    while($row = $Res->fetch_assoc()){
                        foreach($row as $cols){
                            array_push($Data_Inv, $cols);
                        }
                    }
                    break;
                    
                case 2:
                    while($row = $Res->fetch_assoc()){
                        $tmp = array();
                        
                        foreach($row as $cols){
                            array_push($tmp, $cols);
                        }
                        
                        array_push($Data_Desc, $tmp);
                        unset($tmp);
                    }
                    break;
                    
                case 3:
                    while($row = $Res->fetch_assoc()){
                        $tmp = array();
                        
                        foreach($row as $cols){
                            array_push($tmp, $cols);
                        }
                        
                        array_push($tax_Mode, $tmp);
                        unset($tmp);
                    }
                    break;
            }
        }

        $Res->free_result();
        $stmt->next_result();
        $Data_Set++;
    }
    
    $stmt->close();
    $Conn->close();
   
    $Comp_Name_Mod = explode(',', $Data_Comp[2], 2);
    
    $names = 'Invoice '.$Data_Comp[0].', '.substr($Data_Inv[0],7).', '.date("d M Y, H:i:s");
    $f_name = 'Invoice_'.$Data_Comp[0].'_'.substr($Data_Inv[0],7).'_'.date("d_M_Y_H_i_s").'.pdf';
    
$html_c = '
    <html>
    <head>
    <title>'.$names.'</title>
    <style type="text/css">
        .header_title_1{
            font-size: 13pt;
            padding-left: 10px;
        }
        
        .header_title_2{
            padding-left: 10px;
        }
        
        .header_tr_align{
            padding-top: -15px;
            padding-bottom: -10px;
        }
    </style>
    </head>
    <body>
        <table border="0" width="100%">
            <tr>
                <td rowspan="2" align="center">
                    <img src="'.(($UserPic == null)? (FileConfigure::$RootFolder_2."dummy_pic.png") :(FileConfigure::$TargetFolder_Company_2.$UserPic)).'" width="550%" height="550%" />
                </td>
                <td class="header_tr_align">
                    <strong class="header_title_1">'.$Data_Comp[0].' ('.$Data_Comp[1].')</strong>
                </td>
            </tr>
            <tr>
                <td class="header_tr_align">
                    <p class="header_title_2">'.$Comp_Name_Mod[0].'<br />'.$Comp_Name_Mod[1].'<br />'.$Data_Comp[5].'&nbsp;'.$Data_Comp[3].', '.$Data_Comp[4].'
                    <br /><span style="font-size: 10pt; font-weight: bold;">Tel: '.$Data_Comp[8].' E-Mail: '.$Data_Comp[7].'</span></p>
                </td>
            </tr>
        </table>
        <table border="0" width="100%" >
            <tr>
                <td style="text-align:center;padding-top:5px;padding-bottom:5px;"><strong>TAX INVOICE</strong></td>
            </tr>
        </table>
        <table border="1" width="100%" style="font-size: 10pt; margin-top: 10px;" cellspacing="1">
            <tr>
                <td colspan="2" width="55%">Invoice To:</td>
                <td style="text-align: right;" width="20%">Invoice No:</td>
                <td width="25%"><strong>'. substr($Data_Inv[0],7).'</strong></td>
            </tr>
            <tr>
                <td colspan="2" width="55%" rowspan="4"><strong>'.$Data_Inv[9].'<br/>'.$Data_Inv[10].'<br />'.$Data_Inv[12].'&nbsp;'.$Data_Inv[11].'<br />
                    '.$Data_Inv[13].'&nbsp;'.$Data_Inv[14].'</strong></td>
                <td style="text-align: right;" width="20%">Invoice Date:</td>
                <td width="25%"><strong>'.$Data_Inv[1].'</strong></td>
            </tr>
            <tr>
                <td style="text-align: right;" width="20%">Quotation No:</td>
                <td width="25%"><strong>'.substr($Data_Inv[2], 7).'</strong></td>
            </tr>
            <tr>
                <td style="text-align: right;" width="20%">Terms:</td>
                <td width="25%"><strong>'.$Data_Inv[3].'</strong></td>
            </tr>
            <tr>
                <td style="text-align: right;" width="20%">Currency:</td>
                <td width="25%"><strong>'.$Data_Inv[7].'</strong></td>
            </tr>
            <tr>
                <td width="5%">Attn: </td>
                <td width="50%"><strong>'.$Data_Inv[4].'</strong></td>
                <td style="text-align: right;" width="20%">Customer ID:</td>
                <td width="25%"><strong>'.substr($Data_Inv[8],7).'</strong></td>
            </tr>
        </table>
        <div style="margin-top: 10px; font-size: 10pt;">Description</div>
        <table border="1" width="100%" style="margin-top: 5px; font-size: 10pt;" cellspacing="1">
            <thead>
                <tr style="text-align: center">
                    <th width="5%">No</th>
                    <th width="15%">Item Code</th>
                    <th width="26%">Item Description</th>
                    <th width="16%">Unit Price (RM)</th>
                    <th width="10%">Quantity</th>
                    <th width="28%">Amount (RM)</th>
                </tr>
            </thead>
            <tbody style="height: 700px;">
                ';

        $is_Empty = 10 - count($Data_Desc);
        $ttl_wh_tax = 0.00;
        $ttl_qty = 0;
        $grand_tax = 0.00;
        $grand_norm = 0.00;
        
        for($i=0; $i<count($Data_Desc); $i++){
            $amts = number_format($Data_Desc[$i][3]*$Data_Desc[$i][4], 2);
            
            $html_c .= '
                    <tr>
                    <td style="text-align: center">'.($i+1).'</td>
                    <td>'.$Data_Desc[$i][0].'</td>
                    <td>'.$Data_Desc[$i][2].'</td>
                    <td style="text-align: right">'.number_format($Data_Desc[$i][3], 2).'</td>
                    <td style="text-align: right">'.$Data_Desc[$i][4].'</td>
                    <td style="text-align: right">'.$amts.'&nbsp;&nbsp;'.$Data_Desc[$i][5].'</td>
                    </tr>
                    ';
            $ttl_wh_tax += ($Data_Desc[$i][3]*$Data_Desc[$i][4]);
            $ttl_qty += (int) $Data_Desc[$i][4];
            
            if($Data_Desc[$i][5] == $tax_Mode[0][0]){
                $grand_tax += ($Data_Desc[$i][3]*$Data_Desc[$i][4]);
            }
            else{
                $grand_norm += ($Data_Desc[$i][3]*$Data_Desc[$i][4]);
            }
        }
        
        for($i=0; $i<$is_Empty; $i++){
            $html_c .= '
                    <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    </tr>
                    ';
        }
        
        $ttl_std_rate = $grand_tax * (double)$tax_Mode[0][2];

        $grand_total = (float)($grand_norm + $grand_tax + $ttl_std_rate);
                
        $html_c .='
            </tbody>
            <tfoot>
                <tr>
                    <td style="text-align:right; font-weight: bold;" colspan="5">Grand Total (excl Tax) MYR:</td>
                    <td style="text-align: right">'.number_format($ttl_wh_tax,2).'</td>
                </tr>
            </tfoot>
        </table>
        <table border="1" width="100%" style="margin-top: 5px; font-size: 10pt;" cellspacing="1">
            <tr>
                <td rowspan="5" width="50%">
                    <strong><u>Notice:</u></strong>
                    <ul style="margin-left:-20px;">
                        <li>Goods sold are not returnable.</li>
                        <li>Payment must be made in within <strong>30 DAYS</strong> from invoice.</li>
                        <li>Cheque payment made in <strong>'. strtoupper($Data_Comp[0]).'</strong></li>
                        <li>Company shall terminate or modify without prior notice.</li>    
                    </ul>
                </td>
                <td width="23%" style="text-align: right"><strong>Total Quantity:</strong></td>
                <td width="27%" style="text-align: right">'.$ttl_qty.' unit(s)</td>
            </tr>
            
            <tr>
                <td width="23%" style="text-align: right"><strong>'.$tax_Mode[0][1].'</strong></td>
                <td width="27%" style="text-align: right">'.number_format($ttl_std_rate,2).'</td>
            </tr>
            <tr>
                <td width="23%" style="text-align: right"><strong>'.$tax_Mode[1][1].'</strong></td>
                <td width="27%" style="text-align: right">'.number_format($grand_norm,2).'</td>
            </tr>
            <tr>
                <td width="23%" style="text-align: right"><strong>Total Include Tax MYR:</strong></td>
                <td width="27%" style="text-align: right">'.number_format($grand_total,2).'</td>
            </tr>
            <tr>
                <td width="23%" style="text-align: right"><strong>Convert In '.$Data_Inv[5].':</strong></td>
                <td width="27%" style="text-align: right">'. number_format(((double)$Data_Inv[6] * $grand_total),2).'</td>
            </tr>
        </table>
        <table border="0" width="100%" style="margin-top: 110px; font-size: 10pt;" cellspacing="1">
            <tr>
                <td style="height: 100px;" width="50%">
                    <div style="margin-top: 0px;">Sign & Cop Company:</div>
                    <div style="margin-top: 60px;">__________________________________________________</div>
                </td>
                <td width="50%">
                    <div style="margin-top: 0px;">Sign & Cop Company:</div>
                    <div style="margin-top: 60px;">__________________________________________________</div>
                </td>
            </tr>
            <tr style="text-align:center">
                <td width="50%">Prepared By '.strtoupper(explode(',',$Data_Comp[0])[0]).'</td>
                <td width="50%">Received By '.strtoupper(explode(',',$Data_Inv[9])[0]).'</td>
            </tr>
        </table>
    </body>
</html>  
';

RenderPDF($html_c, $f_name);
}

function WriteQuotationHTML($Comp_Id, $Inv_No){
    $Session = new SessionManager();
    $Session->StartSession();
    $UserPic = $Session->GetSession("User_Pic");

    $Conn = new mysqli(Connection::$Host, Connection::$DB_Id, Connection::$DB_Pw, Connection::$Schema);
    $Data_Comp = array(); $Data_Inv = array(); $Data_Desc = array(); $tax_Mode = array();
    
    $Query = "CALL sp_PDFOutputQuotation(?,?);";
    
    $stmt = $Conn->prepare($Query);
    $stmt->bind_param("is", $Comp_Id, $Inv_No);
    $stmt->execute();
    
    $Data_Set = 0;
    
    while($Res = $stmt->get_result()){
        
        if($Res->num_rows > 0){
            switch ($Data_Set){
                case 0:
                    while($row = $Res->fetch_assoc()){
                        foreach($row as $cols){
                            array_push($Data_Comp, $cols);
                        }
                    }
                    break;
                    
                case 1:
                    while($row = $Res->fetch_assoc()){
                        foreach($row as $cols){
                            array_push($Data_Inv, $cols);
                        }
                    }
                    break;
                    
                case 2:
                    while($row = $Res->fetch_assoc()){
                        $tmp = array();
                        
                        foreach($row as $cols){
                            array_push($tmp, $cols);
                        }
                        
                        array_push($Data_Desc, $tmp);
                        unset($tmp);
                    }
                    break;
                    
                case 3:
                    while($row = $Res->fetch_assoc()){
                        $tmp = array();
                        
                        foreach($row as $cols){
                            array_push($tmp, $cols);
                        }
                        
                        array_push($tax_Mode, $tmp);
                        unset($tmp);
                    }
                    break;
            }
        }

        $Res->free_result();
        $stmt->next_result();
        $Data_Set++;
    }
    
    $stmt->close();
    $Conn->close();
   
    $Comp_Name_Mod = explode(',', $Data_Comp[2], 2);
    
    $names = 'Quotation '.$Data_Comp[0].', '.substr($Data_Inv[0],7).', '.date("d M Y, H:i:s");
    $f_name = 'Quotation_'.$Data_Comp[0].'_'.substr($Data_Inv[0],7).'_'.date("d_M_Y_H_i_s").'.pdf';
    
$html_c = '
    <html>
    <head>
    <title>'.$names.'</title>
    <style type="text/css">
        .header_title_1{
            font-size: 13pt;
            padding-left: 10px;
        }
        
        .header_title_2{
            padding-left: 10px;
        }
        
        .header_tr_align{
            padding-top: -15px;
            padding-bottom: -10px;
        }
    </style>
    </head>
    <body>
        <table border="0" width="100%">
            <tr>
                <td rowspan="2" align="center">
                    <img src="'.(($UserPic == null)? (FileConfigure::$RootFolder_2."dummy_pic.png" ):(FileConfigure::$TargetFolder_Company_2.$UserPic)).'" width="550%" height="550%" />
                </td>
                <td class="header_tr_align">
                    <strong class="header_title_1">'.$Data_Comp[0].' ('.$Data_Comp[1].')</strong>
                </td>
            </tr>
            <tr>
                <td class="header_tr_align">
                    <p class="header_title_2">'.$Comp_Name_Mod[0].'<br />'.$Comp_Name_Mod[1].'<br />'.$Data_Comp[5].'&nbsp;'.$Data_Comp[3].', '.$Data_Comp[4].'
                    <br /><span style="font-size: 10pt; font-weight: bold;">Tel: '.$Data_Comp[8].' E-Mail: '.$Data_Comp[7].'</span></p>
                </td>
            </tr>
        </table>
        <table border="0" width="100%" >
            <tr>
                <td style="text-align:center;padding-top:5px;padding-bottom:5px;"><strong>QUOTATION</strong></td>
            </tr>
        </table>
        <table border="1" width="100%" style="font-size: 10pt; margin-top: 10px;" cellspacing="1">
            <tr>
                <td colspan="2" width="55%">Quotation To:</td>
                <td style="text-align: right;" width="20%">Quotation No:</td>
                <td width="25%"><strong>'. substr($Data_Inv[0],7).'</strong></td>
            </tr>
            <tr>
                <td colspan="2" width="55%" rowspan="3"><strong>'.$Data_Inv[8].'<br />'.$Data_Inv[9].'&nbsp;'.$Data_Inv[10].'<br />
                    '.$Data_Inv[12].'&nbsp;'.$Data_Inv[13].'</strong></td>
                <td style="text-align: right;" width="20%">Quotation Date:</td>
                <td width="25%"><strong>'.$Data_Inv[1].'</strong></td>
            </tr>
            <tr>
                <td style="text-align: right;" width="20%">Terms:</td>
                <td width="25%"><strong>'.$Data_Inv[2].'</strong></td>
            </tr>
            <tr>
                <td style="text-align: right;" width="20%">Currency:</td>
                <td width="25%"><strong>'.$Data_Inv[6].'</strong></td>
            </tr>
            <tr>
                <td width="5%">Attn: </td>
                <td width="50%"><strong>'.$Data_Inv[3].'</strong></td>
                <td style="text-align: right;" width="20%">Customer ID:</td>
                <td width="25%"><strong>'.substr($Data_Inv[7],7).'</strong></td>
            </tr>
        </table>
        <div style="margin-top: 10px; font-size: 10pt;">Description</div>
        <table border="1" width="100%" style="margin-top: 5px; font-size: 10pt;" cellspacing="1">
            <thead>
                <tr style="text-align: center">
                    <th width="5%">No</th>
                    <th width="15%">Item Code</th>
                    <th width="26%">Item Description</th>
                    <th width="16%">Unit Price (RM)</th>
                    <th width="10%">Quantity</th>
                    <th width="28%">Amount (RM)</th>
                </tr>
            </thead>
            <tbody style="height: 700px;">
                ';

        $is_Empty = 10 - count($Data_Desc);
        $ttl_wh_tax = 0.00;
        $ttl_qty = 0;
        $grand_tax = 0.00;
        $grand_norm = 0.00;
        
        for($i=0; $i<count($Data_Desc); $i++){
            $amts = number_format($Data_Desc[$i][3]*$Data_Desc[$i][4], 2);
            
            $html_c .= '
                    <tr>
                    <td style="text-align: center">'.($i+1).'</td>
                    <td>'.$Data_Desc[$i][0].'</td>
                    <td>'.$Data_Desc[$i][2].'</td>
                    <td style="text-align: right">'.number_format($Data_Desc[$i][3], 2).'</td>
                    <td style="text-align: right">'.$Data_Desc[$i][4].'</td>
                    <td style="text-align: right">'.$amts.'&nbsp;&nbsp;'.$Data_Desc[$i][5].'</td>
                    </tr>
                    ';
            $ttl_wh_tax += ($Data_Desc[$i][3]*$Data_Desc[$i][4]);
            $ttl_qty += (int) $Data_Desc[$i][4];
            
            if($Data_Desc[$i][5] == $tax_Mode[0][0]){
                $grand_tax += ($Data_Desc[$i][3]*$Data_Desc[$i][4]);
            }
            else{
                $grand_norm += ($Data_Desc[$i][3]*$Data_Desc[$i][4]);
            }
        }
        
        for($i=0; $i<$is_Empty; $i++){
            $html_c .= '
                    <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    </tr>
                    ';
        }
        
        $ttl_std_rate = $grand_tax * (double)$tax_Mode[0][2];

        $grand_total = (float)($grand_norm + $grand_tax + $ttl_std_rate);
                
        $html_c .='
            </tbody>
            <tfoot>
                <tr>
                    <td style="text-align:right; font-weight: bold;" colspan="5">Grand Total (excl Tax) MYR:</td>
                    <td style="text-align: right">'.number_format($ttl_wh_tax,2).'</td>
                </tr>
            </tfoot>
        </table>
        <table border="1" width="100%" style="margin-top: 14px; font-size: 10pt;" cellspacing="1">
            <tr>
                <td rowspan="5" width="50%">
                    <strong><u>Notice:</u></strong>
                    <ul style="margin-left:-20px;">
                        <li>Goods sold are not returnable.</li>
                        <li>Payment must be made in within <strong>30 DAYS</strong> from invoice.</li>
                        <li>You may request for changing until tax invoice release.</li>
                        <li>Company shall terminate or modify without prior notice.</li>    
                    </ul>
                </td>
                <td width="23%" style="text-align: right"><strong>Total Quantity:</strong></td>
                <td width="27%" style="text-align: right">'.$ttl_qty.' unit(s)</td>
            </tr>
            
            <tr>
                <td width="23%" style="text-align: right"><strong>'.$tax_Mode[0][1].'</strong></td>
                <td width="27%" style="text-align: right">'.number_format($ttl_std_rate,2).'</td>
            </tr>
            <tr>
                <td width="23%" style="text-align: right"><strong>'.$tax_Mode[1][1].'</strong></td>
                <td width="27%" style="text-align: right">'.number_format($grand_norm,2).'</td>
            </tr>
            <tr>
                <td width="23%" style="text-align: right"><strong>Total Include Tax MYR:</strong></td>
                <td width="27%" style="text-align: right">'.number_format($grand_total,2).'</td>
            </tr>
            <tr>
                <td width="23%" style="text-align: right"><strong>Convert In '.$Data_Inv[4].':</strong></td>
                <td width="27%" style="text-align: right">'. number_format(((double)$Data_Inv[5] * $grand_total),2).'</td>
            </tr>
        </table>
        <table border="0" width="100%" style="margin-top: 110px; font-size: 10pt;" cellspacing="1">
            <tr>
                <td style="height: 100px;" width="50%">
                    <div style="margin-top: 0px;">Sign & Cop Company:</div>
                    <div style="margin-top: 60px;">__________________________________________________</div>
                </td>
                <td width="50%">
                    <div style="margin-top: 0px;">Sign & Cop Company:</div>
                    <div style="margin-top: 60px;">__________________________________________________</div>
                </td>
            </tr>
            <tr style="text-align:center">
                <td width="50%">Prepared By '.strtoupper(explode(',',$Data_Comp[0])[0]).'</td>
                <td width="50%">Received By '.strtoupper(explode(',',$Data_Inv[8])[0]).'</td>
            </tr>
        </table>
    </body>
</html>  
';

RenderPDF($html_c, $f_name);
}

function WriteReceiptHTML($Comp_ID, $Rec_No){
    $Session = new SessionManager();
    $Session->StartSession();
    $UserPic = $Session->GetSession("User_Pic");
    
    $Conn = new mysqli(Connection::$Host, Connection::$DB_Id, Connection::$DB_Pw, Connection::$Schema);
    $Data_Comp = array();$Data_Inv = array();
    
    $Query = "CALL sp_PDFOutputReceipt(?,?);";
    
    $stmt = $Conn->prepare($Query);
    $stmt->bind_param("is", $Comp_ID, $Rec_No);
    $stmt->execute();
    
    $Data_Set = 0;
    
    while($Res = $stmt->get_result()){
        
        if($Res->num_rows > 0){
            switch ($Data_Set){
                case 0:
                    while($row = $Res->fetch_assoc()){
                        foreach($row as $cols){
                            array_push($Data_Comp, $cols);
                        }
                    }
                    break;
                    
                case 1:
                    while($row = $Res->fetch_assoc()){
                        foreach($row as $cols){
                            array_push($Data_Inv, $cols);
                        }
                    }
                    break;
                    
            }
        }

        $Res->free_result();
        $stmt->next_result();
        $Data_Set++;
    }
    
    $stmt->close();
    $Conn->close();
   
    $Comp_Name_Mod = explode(',', $Data_Comp[2], 2);
    
    $names = 'Receipt '.$Data_Comp[0].', '.substr($Data_Inv[0],7).', '.date("d M Y, H:i:s");
    $f_name = 'Receipt_'.$Data_Comp[0].'_'.substr($Data_Inv[0],7).'_'.date("d_M_Y_H_i_s").'.pdf';
    
    
    $html_c = '
    <html>
    <head>
    <title>'.$names.'</title>
    <style type="text/css">
        .header_title_1{
            font-size: 13pt;
            padding-left: 10px;
        }
        
        .header_title_2{
            padding-left: 10px;
        }
        
        .header_tr_align{
            padding-top: -15px;
            padding-bottom: -10px;
        }
    </style>
    </head>
    <body>
        <table border="0" width="100%">
            <tr>
                <td rowspan="2" align="center">
                    <img src="'.(($UserPic == null)? (FileConfigure::$RootFolder_2."dummy_pic.png") : (FileConfigure::$TargetFolder_Company_2.$UserPic)).'" width="550%" height="550%" />
                </td>
                <td class="header_tr_align">
                    <strong class="header_title_1">'.$Data_Comp[0].' ('.$Data_Comp[1].')</strong>
                </td>
            </tr>
            <tr>
                <td class="header_tr_align">
                    <p class="header_title_2">'.$Comp_Name_Mod[0].'<br />'.$Comp_Name_Mod[1].'<br />'.$Data_Comp[5].'&nbsp;'.$Data_Comp[3].', '.$Data_Comp[4].'
                    <br /><span style="font-size: 10pt; font-weight: bold;">Tel: '.$Data_Comp[8].' E-Mail: '.$Data_Comp[7].'</span></p>
                </td>
            </tr>
        </table>
        <table border="0" width="100%" >
            <tr>
                <td style="text-align:center;padding-top:5px;padding-bottom:5px;"><strong>OFFICIAL RECEIPT</strong></td>
            </tr>
        </table>
        <table border="0" width="100%" style="margin-top: 30px;" >
            <tr>
                <td style="text-align:right;" width="40%">Receipt To: </td>
                <td style="text-align:left;" width="60%">&nbsp;&nbsp;<strong>'.substr($Data_Inv[2], 7).' - '.$Data_Inv[3].'</strong></td>
            </tr>
            <tr>
                <td style="text-align:right;" width="40%">Receipt No: </td>
                <td style="text-align:left;" width="60%">&nbsp;&nbsp;<strong>'.substr($Data_Inv[0], 7).'</strong></td>
            </tr>
            <tr>
                <td style="text-align:right;" width="40%">Receipt Date: </td>
                <td style="text-align:left;" width="60%">&nbsp;&nbsp;<strong>'.$Data_Inv[1].'</strong></td>
            </tr>
            <tr>
                <td style="text-align:right;" width="40%">Payment Invoice: </td>
                <td style="text-align:left;" width="60%">&nbsp;&nbsp;<strong>'.substr($Data_Inv[7], 7).'</strong></td>
            </tr>
            <tr>
                <td style="text-align:right;" width="40%">Payment Date: </td>
                <td style="text-align:left;" width="60%">&nbsp;&nbsp;<strong>'.$Data_Inv[6].'</strong></td>
            </tr>
            <tr>
                <td style="text-align:right;" width="40%">Payable Amount: </td>
                <td style="text-align:left;" width="60%">&nbsp;&nbsp;<strong>MYR '.number_format($Data_Inv[4], 2).'</strong></td>
            </tr>
            <tr>
                <td style="text-align:right;" width="40%">Amount Received: </td>
                <td style="text-align:left;" width="60%">&nbsp;&nbsp;<strong>MYR '.number_format($Data_Inv[5], 2).'</strong></td>
            </tr>
            <tr>
                <td style="text-align:right;" width="40%">Balance Return: </td>
                <td style="text-align:left;" width="60%">&nbsp;&nbsp;<strong>MYR '.number_format($Data_Inv[5] - $Data_Inv[4], 2).'</strong></td>
            </tr>
            <tr>
                <td style="text-align:right;" width="40%">Payment Method: </td>
                <td style="text-align:left;" width="60%">&nbsp;&nbsp;<strong>'.$Data_Inv[8].'</strong></td>
            </tr>
            <tr>
                <td style="text-align:right;" width="40%">Remarks: </td>
                <td style="text-align:left;" width="60%">&nbsp;&nbsp;<strong>'.$Data_Inv[9].'</strong></td>
            </tr>
        </table>
        <div style="margin-top: 100px; position: relative; text-align: center; width: 100%; font-weight: bold;"><i>THIS IS AUTO GENERATED RECEIPT, NO SIGNATURE REQUIRED.</i></div>
    </body>
</html>  ';
        
RenderPDF($html_c, $f_name);
}

switch($_GET["type"]){
    case "invoice":
        WriteInvoiceHTML($_GET["Comp_ID"], $_GET["Inv_No"]);
        break;
    
    case "quotation":
        WriteQuotationHTML($_GET["Comp_ID"], $_GET["Qt_No"]);
        break;
    
    case "receipt":
        WriteReceiptHTML($_GET["Comp_ID"], $_GET["Rec_No"]);
        break;
    
    default:
        echo "<script>window.close();</script>";
        break;
}

