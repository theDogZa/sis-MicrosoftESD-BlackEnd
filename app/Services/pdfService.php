<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use PDF;
class pdfServer
{
    function createPdf($data = '', $type = 1)
    {

        $inv = $this->_setDataInvPdf($data);

        $pdf = PDF::loadView('_etax.inv_sis', (array) $inv);

        $folder = "c:/ETAX_PDF/";
        $nameFile = $folder.$data.'.pdf';

        $output = $pdf->output();
        file_put_contents($nameFile, $output);

        return true;
    }

    function viewPdf($data = array(), $type = 1){

        $inv = $this->_setDataInvPdf($data);

        $pdf = PDF::loadView('_etax.inv_sis', (array) $inv);

        $nameFile = 'testE-tax.pdf';
        
        return $pdf->stream($nameFile);
    }

    function _setDataInvPdf($name = '',$type = 1){

        set_time_limit(0);

        $docType = 1;
        
        $compact = (object) array();

        $arrDocSet[1]['top'] = 'การเงิน';
        $arrDocSet[1]['foot'] = 'ลูกค้า';
        $arrDocSet[1]['doc_name_th'] = 'ใบวางบิล';
        $arrDocSet[1]['doc_name_en'] = 'BILL ORDER';
        $arrDocSet[1]['doc_type'] = '(ต้นฉบับ/ORIGINAL)';
        $arrDocSet[1]['doc_type_name_th'] = 'ใบกำกับภาษี';
        $arrDocSet[1]['doc_type_name_en'] = 'TAX INVOICE';
        $arrDocSet[1]['themes'] = 'themes-brown';

        // $arrDocSet[2]['top'] = 'การเงิน';
        // $arrDocSet[2]['foot'] = 'สต๊อก';
        // $arrDocSet[2]['doc_name_th'] = 'ต้นฉบับใบเสร็จรับเงิน';
        // $arrDocSet[2]['doc_name_en'] = 'ORIGINAL RECEIPT';
        // $arrDocSet[2]['doc_type'] = '(ต้นฉบับ/ORIGINAL)';
        // $arrDocSet[2]['doc_type_name_th'] = 'ใบส่งสินค้า/ใบกำกับภาษี';
        // $arrDocSet[2]['doc_type_name_en'] = 'DELIVERY ORDER/TAX INVOICE';  
        // $arrDocSet[2]['themes'] = 'themes-green';


        // $arrDocSet[2]['top'] = 'การเงิน';
        // $arrDocSet[2]['foot'] = 'บัญชี';
        // $arrDocSet[3]['top'] = 'การเงิน';
        // $arrDocSet[3]['foot'] = 'การเงิน';
        // $arrDocSet[4]['top'] = 'การเงิน';
        // $arrDocSet[4]['foot'] = 'ลูกค้า';
        // $arrDocSet[5]['top'] = 'การเงิน';
        // $arrDocSet[5]['foot'] = 'ลูกค้า';

        //$file = storage_path() . "/json_inv/inv_12345678.json";
        $file = storage_path('/json_inv/'). $name . '.json';

        $strJsonFileContents = file_get_contents($file);
        $dataInv = json_decode($strJsonFileContents);
        //dd($file, $strJsonFileContents,$dataInv);

        if($dataInv->BuyerTradeParty->BranchCode == '00000'){
            $dataInv->BuyerTradeParty->BranchCode = 'สำนักงานใหญ่';
        }
        
        $rowToPage = 20;
        $listItems = [];
        $newItemsList = [];
        $countline1 = 0;
        $countLineDesc = 0;
        $countItems = 0;
        $totalItem = count((array)$dataInv->IncludedSupplyChainTradeLineItem);
        $p = 1;
        $i = 1;
	
	$hPO = (object)[];
        $hPO->LineID = "PO"; //<-- line PO cu
        $hPO->ProductID = null;
        $hPO->Name = null;
        $hPO->BilledQuantity = null;
        $hPO->ChargeAmount = null;
        $hPO->NetLineTotalAmount = null;
        $hPO->ActualAmount = null;
        $newItemsList[] = $hPO;
        
        foreach ($dataInv->IncludedSupplyChainTradeLineItem as $item) {
            $addSN = '';
            // $ProductID = wordwrap($item->ProductID, 370, "\n");
            // $countline1 += preg_match_all('/\n/', $ProductID) + 1;

            if(@isset($item->SerialNo)){

                foreach ($item->SerialNo as $IMEISN) {
                    if (@isset($IMEISN->IMEI) && @$IMEISN->IMEI != "") {
                        $addSN .= "&nbsp;IMEI : ". $IMEISN->IMEI."\n";
                    }elseif(@isset($IMEISN->SN) && @$IMEISN->SN != ""){
                        $addSN .= "&nbsp;SN : " . $IMEISN->SN . "\n";
                    }
                }
                $item->Name .= "\n".$addSN;
            }

            $desc = wordwrap($item->Name, 370, "\n");
            $countRowItem = preg_match_all('/\n/', $desc) + 1;

            $countItems += $item->BilledQuantity;

            if ($countRowItem + $countLineDesc > $rowToPage) {
                
                $arrDesc = explode("\n", $desc);
                $rowCutItem = $rowToPage - $countLineDesc;

                $arrPart1 = array_chunk($arrDesc, $rowCutItem);
                $item->Name = implode("\n", $arrPart1[0]);
                $countLineDesc += preg_match_all('/\n/', implode("\n", $arrPart1[0])) + 1;
                $newItemsList[] = $item;

                $listItems[$p] = $newItemsList;
                $newItemsList = [];
                $countLineDesc = 0;
                $p++;

                $arrPart2 = array_slice($arrDesc, $rowCutItem);
                $arrRowToPage = array_chunk($arrPart2, $rowToPage);

                for($rd = 0; $rd <= (count($arrRowToPage)-1);$rd++){
                
                    $newItem = (object)[];
                    $newItem->LineID = null;
                    $newItem->ProductID = null;
                    $newItem->Name = implode("\n", $arrRowToPage[$rd]);
                    $newItem->BilledQuantity = null;
                    $newItem->ChargeAmount = null;
                    $newItem->NetLineTotalAmount = null;
                    $newItem->ActualAmount = null;

                    $newItemsList[] = $newItem;

                    $countLineDesc += preg_match_all('/\n/', implode("\n", $arrRowToPage[$rd])) + 1;

                    if ($countLineDesc == $rowToPage) {
                        $listItems[$p] = $newItemsList;
                        $newItemsList = [];
                        $countLineDesc = 0;
                        $p++;
                    }
                }

            }else{
                $countLineDesc += $countRowItem; 
                $newItemsList[] = $item;
            }

            if($totalItem == $i){

                if($countLineDesc == $rowToPage){
                    $listItems[$p] = $newItemsList;
                    $newItemsList = [];
                    $p++;
                }
                $sum = (object)[];
                $sum->LineID = "S"; //<-- line total items
                $sum->ProductID = null;
                $sum->Name = __('tax_invoice.total_items_text');
                $sum->BilledQuantity = $countItems;
                $sum->ChargeAmount = null;
                $sum->NetLineTotalAmount = null;
                $sum->ActualAmount = null;
                $newItemsList[] = $sum;

                $listItems[$p] = $newItemsList;

            }elseif($countLineDesc == $rowToPage){

                $listItems[$p] = $newItemsList;
                $newItemsList = [];
                $countLineDesc = 0;
                $p++;
            }
            $i++;
        }

        $compact->listItems = $listItems;
        $compact->data = $dataInv;
        $compact->docSet = $arrDocSet;
        $compact->docType = $docType;


        return (array) $compact;
    }
}