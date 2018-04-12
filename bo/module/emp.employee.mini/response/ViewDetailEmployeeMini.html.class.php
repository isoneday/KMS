<?php

/**
 * @author Prima Noor 
 */
class ViewDetailEmployeeMini extends HtmlResponse {

    function TemplateModule() {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/' . GtfwDispt()->mModule . '/template');
        $this->SetTemplateFile('view_detail_employeemini.html');
    }

    function ProcessRequest() {
        $ObjEmployeeMini = GtfwDispt()->load->business('EmployeeMini', 'emp.employee.mini');

        $id = $_GET['id']->Integer()->Raw();

        $detail = $ObjEmployeeMini->getDetailEmployeeMini($id);
        $app_list = $ObjEmployeeMini->getSetOfficer();
        if ($app_list) {
            foreach ($app_list as $key => $value) {
                switch ($value['id']) {
                    case '1' : {
                            $ObjCrm = GtfwDispt()->load->business('CrmOfficer', 'crm.officer');
                            $crm = $ObjCrm->getDetailOfficer($detail['crm_officer_id']);
                            $app_list[$key]['parent'] = $crm['parent'];
                            $app_list[$key]['is_all'] = $crm['is_all'];
                            $app_list[$key]['is_admin'] = $crm['is_admin'];
                            if (!empty($detail['crm_officer_id']))
                                $app_list[$key]['active'] = GtfwLangText('active');
                            else
                                $app_list[$key]['active'] = GtfwLangText('not_active');
                        }
                        break;
                    case '2' : {
                            $ObjHr = GtfwDispt()->load->business('EmpOfficer', 'emp.officer');
                            $hr = $ObjHr->getDetailEmpOfficer($detail['hr_officer_id']);
                            $app_list[$key]['parent'] = $hr['parent'];
                            $app_list[$key]['is_all'] = $hr['is_all'];
                            $app_list[$key]['is_admin'] = $hr['is_admin'];
                            if (!empty($detail['hr_officer_id']))
                                $app_list[$key]['active'] = GtfwLangText('active');
                            else
                                $app_list[$key]['active'] = GtfwLangText('not_active');
                        }
                        break;
                    case '3' : {
                            $ObjFin = GtfwDispt()->load->business('FinOfficer', 'fin.officer');
                            $fin = $ObjFin->getDetailFinOfficer($detail['fin_officer_id']);
                            $app_list[$key]['parent'] = $fin['parent'];
                            $app_list[$key]['is_all'] = $fin['is_all'];
                            $app_list[$key]['is_admin'] = $fin['is_admin'];
                            if (!empty($detail['fin_officer_id']))
                                $app_list[$key]['active'] = GtfwLangText('active');
                            else
                                $app_list[$key]['active'] = GtfwLangText('not_active');
                        }
                        break;
                    case '4' : {
                            $ObjFxa = GtfwDispt()->load->business('FxaOfficer', 'fxa.officer');
                            $fxa = $ObjFxa->getDetailFxaOfficer($detail['fxa_officer_id']);
                            $app_list[$key]['parent'] = $fxa['parent'];
                            $app_list[$key]['is_all'] = $fxa['is_all'];
                            $app_list[$key]['is_admin'] = $fxa['is_admin'];
                            if (!empty($detail['fxa_officer_id']))
                                $app_list[$key]['active'] = GtfwLangText('active');
                            else
                                $app_list[$key]['active'] = GtfwLangText('not_active');
                        }
                        break;
                    case '5' : {
                            $ObjInv = GtfwDispt()->load->business('InvOfficer', 'inv.officer');
                            $inv = $ObjInv->getDetailInvOfficer($detail['inv_officer_id']);
                            $app_list[$key]['parent'] = $inv['parent'];
                            $app_list[$key]['is_all'] = $inv['is_all'];
                            $app_list[$key]['is_admin'] = $inv['is_admin'];
                            if (!empty($detail['inv_officer_id']))
                                $app_list[$key]['active'] = GtfwLangText('active');
                            else
                                $app_list[$key]['active'] = GtfwLangText('not_active');
                        }
                        break;
                    case '6' : {
                            $ObjGa = GtfwDispt()->load->business('GaOfficer', 'ga.officer');
                            $ga = $ObjGa->getDetailGaOfficer($detail['ga_officer_id']);
                            $app_list[$key]['parent'] = $ga['parent'];
                            $app_list[$key]['is_all'] = $ga['is_all'];
                            $app_list[$key]['is_admin'] = $ga['is_admin'];
                            if (!empty($detail['ga_officer_id']))
                                $app_list[$key]['active'] = GtfwLangText('active');
                            else
                                $app_list[$key]['active'] = GtfwLangText('not_active');
                        }
                        break;
                    case '7' : {
                            $ObjProd = GtfwDispt()->load->business('ProdOfficer', 'prod.officer');
                            $prod = $ObjProd->getDetailProdOfficer($detail['prod_officer_id']);
                            $app_list[$key]['parent'] = $prod['parent'];
                            $app_list[$key]['is_all'] = $prod['is_all'];
                            $app_list[$key]['is_admin'] = $prod['is_admin'];
                            if (!empty($detail['prod_officer_id']))
                                $app_list[$key]['active'] = GtfwLangText('active');
                            else
                                $app_list[$key]['active'] = GtfwLangText('not_active');
                        }
                        break;
                    case '8' : {
                            $ObjProj = GtfwDispt()->load->business('ProjOfficer', 'proj.officer');
                            $proj = $ObjProj->getDetailProjOfficer($detail['proj_officer_id']);
                            $app_list[$key]['parent'] = $proj['parent'];
                            $app_list[$key]['is_all'] = $proj['is_all'];
                            $app_list[$key]['is_admin'] = $proj['is_admin'];
                            if (!empty($detail['proj_officer_id']))
                                $app_list[$key]['active'] = GtfwLangText('active');
                            else
                                $app_list[$key]['active'] = GtfwLangText('not_active');
                        }
                        break;
                    case '9' : {
                            $ObjPcs = GtfwDispt()->load->business('PcsOfficer', 'pcs.officer');
                            $pcs = $ObjPcs->getDetailPcsOfficer($detail['pcs_officer_id']);
                            $app_list[$key]['parent'] = $pcs['parent'];
                            $app_list[$key]['is_all'] = $pcs['is_all'];
                            $app_list[$key]['is_admin'] = $pcs['is_admin'];
                            if (!empty($detail['pcs_officer_id']))
                                $app_list[$key]['active'] = GtfwLangText('active');
                            else
                                $app_list[$key]['active'] = GtfwLangText('not_active');
                        }
                        break;
                    case '10' : {
                            $ObjQc = GtfwDispt()->load->business('QcOfficer', 'qc.officer');
                            $qc = $ObjQc->getDetailQcOfficer($detail['qc_officer_id']);
                            $app_list[$key]['parent'] = $qc['parent'];
                            $app_list[$key]['is_all'] = $qc['is_all'];
                            $app_list[$key]['is_admin'] = $qc['is_admin'];
                            if (!empty($detail['qc_officer_id']))
                                $app_list[$key]['active'] = GtfwLangText('active');
                            else
                                $app_list[$key]['active'] = GtfwLangText('not_active');
                        }
                        break;
                    case '11' : {
                            $ObjSales = GtfwDispt()->load->business('SalesOfficer', 'sales.officer');
                            $sales = $ObjSales->getDetailSalesOfficer($detail['sales_officer_id']);
                            $app_list[$key]['parent'] = $sales['parent'];
                            $app_list[$key]['is_all'] = $sales['is_all'];
                            $app_list[$key]['is_admin'] = $sales['is_admin'];
                            if (!empty($detail['sales_officer_id']))
                                $app_list[$key]['active'] = GtfwLangText('active');
                            else
                                $app_list[$key]['active'] = GtfwLangText('not_active');
                        }
                        break;
                    case '12' : {
                            $ObjCms = GtfwDispt()->load->business('CmsOfficer', 'cms.officer');
                            $cms = $ObjCms->getDetailCmsOfficer($detail['cms_officer_id']);
                            $app_list[$key]['parent'] = $cms['parent'];
                            $app_list[$key]['is_all'] = $cms['is_all'];
                            $app_list[$key]['is_admin'] = $cms['is_admin'];
                            if (!empty($detail['cms_officer_id']))
                                $app_list[$key]['active'] = GtfwLangText('active');
                            else
                                $app_list[$key]['active'] = GtfwLangText('not_active');
                        }
                        break;
                    case '13' : {
                            $ObjTaf = GtfwDispt()->load->business('TafOfficer', 'taf.officer');
                            $taf = $ObjTaf->getDetailTafOfficer($detail['taf_officer_id']);
                            //$app_list[$key]['parent'] = $taf['parent'];
                            $app_list[$key]['is_all'] = $taf['is_all'];
                            $app_list[$key]['is_admin'] = $taf['is_admin'];
                            if (!empty($detail['taf_officer_id']))
                                $app_list[$key]['active'] = GtfwLangText('active');
                            else
                                $app_list[$key]['active'] = GtfwLangText('not_active');
                        }
                        break;
                }
            }
        }

        return compact('detail', 'app_list');
    }

    function ParseTemplate($rdata = NULL) {
        extract($rdata);

        if (!empty($detail)) {
            $detail['gender'] == 'm' ? $detail['gender'] = GtfwLangText('male') : $detail['gender'] = GtfwLangText('female');

            if ((!empty($detail['photo'])) && is_readable(Configuration::Instance()->GetValue('application', 'employee_save_path') . $detail['photo_path'])) {
                $path = Configuration::Instance()->GetValue('application', 'employee_save_path') . $detail['photo_path'];
                if (($detail['photo_type'] == 'jpg') || ($detail['photo_type'] == 'PNG') || ($detail['photo_type'] == 'gif')) {
                    $detail['photo_file'] = "<b><a href=" . $path . " target=_blank> " . $detail['photo'] . "</a></b>";
                    $detail['photop'] = "<img src=" . $path . " width=200px height=170px alt='" . $detail['photo_origin'] . "' title='" . $detail['photo_origin'] . "'>";
                    $this->mrTemplate->SetAttribute('photo_preview', 'visibility', 'visible');
                    $this->mrTemplate->addVar('photo_preview', 'PHOTOP', $detail['photop']);
                } else {
                    $detail['photo_file'] = "<b><a href=" . $path . " target=_blank> " . $detail['photo_origin'] . "</a></b>";
                    $detail['photop'] = '';
                }
                $this->mrTemplate->SetAttribute('current_photo', 'visibility', 'visible');
                $this->mrTemplate->addVar('current_photo', 'PHOTO_FILE', $detail['photo_file']);
            }
            $this->mrTemplate->addVars('content', $detail);
        }

        if (!empty($app_list) && count($app_list) > 0) {
            $this->mrTemplate->addVar('data', 'IS_EMPTY', 'NO');
            $no = 1;
            foreach ($app_list as $val) {
                $val['no'] = $no;
                $val['is_all'] == 1 ? $val['is_all'] = GtfwLangText('yes') : $val['is_all'] = GtfwLangText('no');
                $val['is_admin'] == 1 ? $val['is_admin'] = GtfwLangText('yes') : $val['is_admin'] = GtfwLangText('no');

                $this->mrTemplate->addVars('item', $val);
                $this->mrTemplate->parseTemplate('item', 'a');
                $no++;
            }
        } else {
            $this->mrTemplate->addVar('data', 'IS_EMPTY', 'YES');
        }
    }

}

?>