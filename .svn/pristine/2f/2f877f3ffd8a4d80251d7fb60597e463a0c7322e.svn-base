<?php

/**
 * @author Prima Noor 
 */
class ViewInputEmployeeOfficer extends HtmlResponse {

    function TemplateModule() {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/' . GtfwDispt()->mModule . '/template');
        $this->SetTemplateFile('view_input_employee_officer.html');
    }

    function ProcessRequest() {
        $ObjEmployeeMini = GtfwDispt()->load->business('EmployeeMini', 'emp.employee.mini');
        $ObjEmp = GtfwDispt()->load->business('Employee', 'emp.employee');
        $ObjCrm = GtfwDispt()->load->business('CrmOfficer', 'crm.officer');
        $ObjHr = GtfwDispt()->load->business('EmpOfficer', 'emp.officer');
        $ObjFin = GtfwDispt()->load->business('FinOfficer', 'fin.officer');
        $ObjFxa = GtfwDispt()->load->business('FxaOfficer', 'fxa.officer');
        $ObjInv = GtfwDispt()->load->business('InvOfficer', 'inv.officer');
        $ObjGa = GtfwDispt()->load->business('GaOfficer', 'ga.officer');
        $ObjProd = GtfwDispt()->load->business('ProdOfficer', 'prod.officer');
        $ObjProj = GtfwDispt()->load->business('ProjOfficer', 'proj.officer');
        $ObjPcs = GtfwDispt()->load->business('PcsOfficer', 'pcs.officer');
        $ObjQc = GtfwDispt()->load->business('QcOfficer', 'qc.officer');
        $ObjSales = GtfwDispt()->load->business('SalesOfficer', 'sales.officer');
        $ObjCms = GtfwDispt()->load->business('CmsOfficer', 'cms.officer');
        $ObjTaf = GtfwDispt()->load->business('TafOfficer', 'taf.officer');

        $id = $_GET['id']->Integer()->Raw();
        $elmId = $_GET['elmId']->SqlString()->Raw();

        $msg = Messenger::Instance()->Receive(__FILE__);
        $post = isset($msg[0][0]) ? $msg[0][0] : NULL;
        $message['content'] = isset($msg[0][1]) ? $msg[0][1] : NULL;
        $message['style'] = isset($msg[0][2]) ? $msg[0][2] : NULL;

        $app_list = $ObjEmployeeMini->getSetOfficer();
        if (!empty($post)) {
            $input = $post;
            $related = array();
            if (isset($post['serAttachmentVal']) && !empty($post['serAttachmentVal'])) {
                foreach ($post['serAttachmentVal'] as $key => $val) {
                    $related_temp = array(
                        'serAttachmentVal' => $val,
                        'serAttachmentText' => $post['serAttachmentText'][$key]
                    );

                    $related[] = $related_temp;
                    unset($related_temp);
                }
            }
        } elseif (!empty($id)) {
            $input = $ObjEmployeeMini->getDetailEmployeeMini($id);
            if ($input['crm_officer_id']) {
                $crm = $ObjCrm->getDetailCrmOfficer($input['crm_officer_id']);
                if (!empty($crm)) {
                    $input = array_merge($input, $crm);
                }
            }
            if ($input['hr_officer_id']) {
                $hr = $ObjHr->getDetailHrOfficer($input['hr_officer_id']);
                if (!empty($hr)) {
                    $input = array_merge($input, $hr);
                }
            }
            if ($input['fin_officer_id']) {
                $fin = $ObjFin->getDetailEmpFinOfficer($input['fin_officer_id']);
                if (!empty($fin)) {
                    $input = array_merge($input, $fin);
                }
            }
            if ($input['fxa_officer_id']) {
                $fxa = $ObjFxa->getDetailEmpFxaOfficer($input['fxa_officer_id']);
                if (!empty($fxa)) {
                    $input = array_merge($input, $fxa);
                    $related = $ObjFxa->getOfficerAssetVarianDetail($input['fxa_officer_id']);
                }
            }
            if ($input['inv_officer_id']) {
                $inv = $ObjInv->getDetailEmpInvOfficer($input['inv_officer_id']);
                if (!empty($inv)) {
                    $input = array_merge($input, $inv);
                }
            }
            if ($input['ga_officer_id']) {
                $ga = $ObjGa->getDetailEmpGaOfficer($input['ga_officer_id']);
                if (!empty($ga)) {
                    $input = array_merge($input, $ga);
                }
            }
            if ($input['prod_officer_id']) {
                $prod = $ObjProd->getDetailEmpProdOfficer($input['prod_officer_id']);
                if (!empty($prod)) {
                    $input = array_merge($input, $prod);
                }
            }
            if ($input['proj_officer_id']) {
                $proj = $ObjProj->getDetailEmpProjOfficer($input['proj_officer_id']);
                if (!empty($proj)) {
                    $input = array_merge($input, $proj);
                }
            }
            if ($input['pcs_officer_id']) {
                $pcs = $ObjPcs->getDetailEmpPcsOfficer($input['pcs_officer_id']);
                if (!empty($pcs)) {
                    $input = array_merge($input, $pcs);
                }
            }
            if ($input['qc_officer_id']) {
                $qc = $ObjQc->getDetailEmpQcOfficer($input['qc_officer_id']);
                if (!empty($qc)) {
                    $input = array_merge($input, $qc);
                }
            }
            if ($input['sales_officer_id']) {
                $sales = $ObjSales->getDetailEmpSalesOfficer($input['sales_officer_id']);
                if (!empty($sales)) {
                    $input = array_merge($input, $sales);
                }
            }
            if ($input['cms_officer_id']) {
                $cms = $ObjCms->getDetailEmpCmsOfficer($input['cms_officer_id']);
                if (!empty($cms)) {
                    $input = array_merge($input, $cms);
                }
            }
            if ($input['taf_officer_id']) {
                $taf = $ObjTaf->getDetailEmpTafOfficer($input['taf_officer_id']);
                if (!empty($taf)) {
                    $input = array_merge($input, $taf);
                }
            }
        }

        Messenger::Instance()->SendToComponent('crm.officer', 'comboCrmOfficer', 'view', 'html', 'crm_off_id', array(
            'dataId' => (!empty($input['crm_off_id']) ? $input['crm_off_id'] : null),
            'elmId' => 'crm_off_id',
            'name' => 'crm_off_id',
            'first' => 'select',
            'showAdd' => false), Messenger::CurrentRequest);

        Messenger::Instance()->SendToComponent('emp.officer', 'comboEmpOfficer', 'view', 'html', 'hr_off_id', array(
            'dataId' => (!empty($input['hr_off_id']) ? $input['hr_off_id'] : null),
            'elmId' => 'hr_off_id',
            'name' => 'hr_off_id',
            'first' => 'select',
            'showAdd' => false), Messenger::CurrentRequest);

        Messenger::Instance()->SendToComponent('fin.officer', 'comboFinOfficer', 'view', 'html', 'fin_off_id', array(
            'dataId' => (!empty($input['fin_off_id']) ? $input['fin_off_id'] : null),
            'elmId' => 'fin_off_id',
            'name' => 'fin_off_id',
            'first' => 'select',
            'showAdd' => false), Messenger::CurrentRequest);

        Messenger::Instance()->SendToComponent('fxa.officer', 'comboFxaOfficer', 'view', 'html', 'fxa_off_id', array(
            'dataId' => (!empty($input['fxa_off_id']) ? $input['fxa_off_id'] : null),
            'elmId' => 'fxa_off_id',
            'name' => 'fxa_off_id',
            'first' => 'select',
            'showAdd' => false), Messenger::CurrentRequest);

        Messenger::Instance()->SendToComponent('fxa.ref.asset.varian', 'comboAssetVarian', 'view', 'html', 'asset_var_id', array(
            'dataId' => (!empty($input['asset_var_id']) ? $input['asset_var_id'] : null),
            'elmId' => 'asset_var_id',
            'name' => 'asset_var_id',
            'first' => 'select',
            'showAdd' => false), Messenger::CurrentRequest);

        Messenger::Instance()->SendToComponent('ga.officer', 'comboGaOfficer', 'view', 'html', 'ga_off_id', array(
            'dataId' => (!empty($input['ga_off_id']) ? $input['ga_off_id'] : null),
            'elmId' => 'ga_off_id',
            'name' => 'ga_off_id',
            'first' => 'select',
            'showAdd' => false), Messenger::CurrentRequest);

        Messenger::Instance()->SendToComponent('prod.officer', 'comboProdOfficer', 'view', 'html', 'prod_off_id', array(
            'dataId' => (!empty($input['prod_off_id']) ? $input['prod_off_id'] : null),
            'elmId' => 'prod_off_id',
            'name' => 'prod_off_id',
            'first' => 'select',
            'showAdd' => false), Messenger::CurrentRequest);

        Messenger::Instance()->SendToComponent('proj.officer', 'comboProjOfficer', 'view', 'html', 'proj_off_id', array(
            'dataId' => (!empty($input['proj_off_id']) ? $input['proj_off_id'] : null),
            'elmId' => 'proj_off_id',
            'name' => 'proj_off_id',
            'first' => 'select',
            'showAdd' => false), Messenger::CurrentRequest);

        Messenger::Instance()->SendToComponent('pcs.officer', 'comboPcsOfficer', 'view', 'html', 'pcs_off_id', array(
            'dataId' => (!empty($input['pcs_off_id']) ? $input['pcs_off_id'] : null),
            'elmId' => 'pcs_off_id',
            'name' => 'pcs_off_id',
            'first' => 'select',
            'showAdd' => false), Messenger::CurrentRequest);

        Messenger::Instance()->SendToComponent('qc.officer', 'comboQcOfficer', 'view', 'html', 'qc_off_id', array(
            'dataId' => (!empty($input['qc_off_id']) ? $input['qc_off_id'] : null),
            'elmId' => 'qc_off_id',
            'name' => 'qc_off_id',
            'first' => 'select',
            'showAdd' => false), Messenger::CurrentRequest);

        Messenger::Instance()->SendToComponent('sales.officer', 'comboSalesOfficer', 'view', 'html', 'sales_off_id', array(
            'dataId' => (!empty($input['sales_off_id']) ? $input['sales_off_id'] : null),
            'elmId' => 'sales_off_id',
            'name' => 'sales_off_id',
            'first' => 'select',
            'showAdd' => false), Messenger::CurrentRequest);

        Messenger::Instance()->SendToComponent('cms.officer', 'comboCmsOfficer', 'view', 'html', 'cms_off_id', array(
            'dataId' => (!empty($input['cms_off_id']) ? $input['cms_off_id'] : null),
            'elmId' => 'cms_off_id',
            'name' => 'cms_off_id',
            'first' => 'select',
            'showAdd' => false), Messenger::CurrentRequest);

        Messenger::Instance()->SendToComponent('taf.officer', 'comboTafOfficer', 'view', 'html', 'taf_off_id', array(
            'dataId' => (!empty($input['taf_off_id']) ? $input['taf_off_id'] : null),
            'elmId' => 'taf_off_id',
            'name' => 'taf_off_id',
            'first' => 'select',
            'showAdd' => false), Messenger::CurrentRequest);

        return compact('input', 'id', 'message', 'elmId', 'app_list', 'related');
    }

    function ParseTemplate($rdata = NULL) {
        extract($rdata);

        if (!empty($message)) {
            $this->mrTemplate->addVars('message', $message);
        }

        if (!empty($app_list) && count($app_list) > 0) {
            $this->mrTemplate->addVar('data', 'IS_EMPTY', 'NO');
            $no = 1;
            foreach ($app_list as $val) {
                $val['tabs_id'] = "tabs-input-officer-" . $val['id'] . "";
                $this->mrTemplate->addVars('item', $val);
                $this->mrTemplate->parseTemplate('item', 'a');
                $no++;
            }
        } else {
            $this->mrTemplate->addVar('data', 'IS_EMPTY', 'YES');
        }

        if (!empty($app_list) && count($app_list) > 0) {
            foreach ($app_list as $key => $val) {
                if (!empty($app_list)) {
                    $app_list[$key]['div_id'] = "tabs-input-officer-" . $val['id'] . "";
                    $this->mrTemplate->addVars($app_list[$key]['div_id'], $app_list[$key]);
                }
            }
        }
        if (!empty($related)) {
            $this->mrTemplate->addVar('data_emp', 'IS_EMPTY', 'NO');
            foreach ($related as $key => $value) {
                $html = '<tr class="table-common-even">
          </td><td class="links" style="text-align:center;"><a href="javascript:removeAttachment(' . ($key + 1) . ')"  id="deleteAttachment_' . ($key + 1) . '" title="' . GtfwLangText('delete') . '" class="confirm_delete btn-delete-icon"></a>' .
                        '</td><td><input type="hidden" id="serAttachmentVal_' . $value['serAttachmentVal'] . '" name=serAttachmentVal[] value="' . $value['serAttachmentVal'] . '"/>
          <input type="hidden" id="serAttachmentText_' . ($key + 2) . '" name=serAttachmentText[] value="' . $value['serAttachmentText'] . '"/>' . $value['serAttachmentText'] . '</td></tr>
          ';
                $this->mrTemplate->addVar('html_attachment', 'HTML_ATTACHMENT', $html);
                $this->mrTemplate->parseTemplate('html_attachment', 'a');
            }
        } else {
            $this->mrTemplate->addVar('data_emp', 'IS_EMPTY', 'YES');
        }
        if (!empty($input['serAttachmentVal']))
            unset($input['serAttachmentVal']);
        if (!empty($input['serAttachmentText']))
            unset($input['serAttachmentText']);

        #crm officer
        if (isset($input['crm_is_sales']) && $input['crm_is_sales'] == 1) {
            $input['crm_is_sales'] = 'checked="checked"';
        }
        if (isset($input['crm_is_all']) && $input['crm_is_all'] == 1) {
            $input['crm_is_all'] = 'checked="checked"';
            $input['crm_status_admin'] = 1;
        }
        if (!empty($input['crm_officer_id'])) {
            $this->mrTemplate->addVar('create_crm', 'IS_EMPTY', 'NO');
            $input['create_crm'] = 'checked="checked"';
            $input['crm_status_officer'] = 1;
        } else {
            $this->mrTemplate->addVar('create_crm', 'IS_EMPTY', 'YES');
        }
        if ((isset($input['create_crm']) && $input['create_crm'] == 1)) {
            $input['create_crm'] = 'checked="checked"';
            $input['crm_status_officer'] = 1;
        }
        if (isset($input['crm_is_admin']) && $input['crm_is_admin'] == 1) {
            $input['crm_is_admin'] = 'checked="checked"';
        }
        #end crm
        #hr officer
        if (isset($input['hr_is_all']) && $input['hr_is_all'] == 1) {
            $input['hr_is_all'] = 'checked="checked"';
            $input['hr_status_admin'] = 1;
        }
        if (!empty($input['hr_officer_id'])) {
            $this->mrTemplate->addVar('create_hr', 'IS_EMPTY', 'NO');
            $input['create_hr'] = 'checked="checked"';
            $input['hr_status_officer'] = 1;
        } else {
            $this->mrTemplate->addVar('create_hr', 'IS_EMPTY', 'YES');
        }
        if ((isset($input['create_hr']) && $input['create_hr'] == 1)) {
            $input['create_hr'] = 'checked="checked"';
            $input['hr_status_officer'] = 1;
        }
        if (isset($input['hr_is_admin']) && $input['hr_is_admin'] == 1) {
            $input['hr_is_admin'] = 'checked="checked"';
        }
        #end hr 
        #fin officer
        if (isset($input['fin_is_sales']) && $input['fin_is_sales'] == 1) {
            $input['fin_is_sales'] = 'checked="checked"';
        }
        if (isset($input['fin_is_all']) && $input['fin_is_all'] == 1) {
            $input['fin_is_all'] = 'checked="checked"';
            $input['fin_status_admin'] = 1;
        }
        if (!empty($input['fin_officer_id'])) {
            $this->mrTemplate->addVar('create_fin', 'IS_EMPTY', 'NO');
            $input['create_fin'] = 'checked="checked"';
            $input['fin_status_officer'] = 1;
        } else {
            $this->mrTemplate->addVar('create_fin', 'IS_EMPTY', 'YES');
        }
        if ((isset($input['create_fin']) && $input['create_fin'] == 1)) {
            $input['create_fin'] = 'checked="checked"';
            $input['fin_status_officer'] = 1;
        }
        if (isset($input['fin_is_admin']) && $input['fin_is_admin'] == 1) {
            $input['fin_is_admin'] = 'checked="checked"';
        }
        if (isset($input['fin_is_finance']) && $input['fin_is_finance'] == 1) {
            $input['fin_is_finance'] = 'checked="checked"';
        }
        if (isset($input['fin_is_accounting']) && $input['fin_is_accounting'] == 1) {
            $input['fin_is_accounting'] = 'checked="checked"';
        }
        #end fin
        #fxa officer
        if (isset($input['fxa_is_all']) && $input['fxa_is_all'] == 1) {
            $input['fxa_is_all'] = 'checked="checked"';
            $input['fxa_status_admin'] = 1;
        }
        if (!empty($input['fxa_officer_id'])) {
            $this->mrTemplate->addVar('create_fxa', 'IS_EMPTY', 'NO');
            $input['create_fxa'] = 'checked="checked"';
            $input['fxa_status_officer'] = 1;
        } else {
            $this->mrTemplate->addVar('create_fxa', 'IS_EMPTY', 'YES');
        }
        if ((isset($input['create_fxa']) && $input['create_fxa'] == 1)) {
            $input['create_fxa'] = 'checked="checked"';
            $input['fxa_status_officer'] = 1;
        }
        if (isset($input['fxa_is_admin']) && $input['fxa_is_admin'] == 1) {
            $input['fxa_is_admin'] = 'checked="checked"';
        }
        #end fxa 
        #inv officer
        if (isset($input['inv_is_all']) && $input['inv_is_all'] == 1) {
            $input['inv_is_all'] = 'checked="checked"';
            $input['inv_status_admin'] = 1;
        }
        if (!empty($input['inv_officer_id'])) {
            $this->mrTemplate->addVar('create_inv', 'IS_EMPTY', 'NO');
            $input['create_inv'] = 'checked="checked"';
            $input['inv_status_officer'] = 1;
        } else {
            $this->mrTemplate->addVar('create_inv', 'IS_EMPTY', 'YES');
        }
        if ((isset($input['create_inv']) && $input['create_inv'] == 1)) {
            $input['create_inv'] = 'checked="checked"';
            $input['inv_status_officer'] = 1;
        }
        if (isset($input['inv_is_admin']) && $input['inv_is_admin'] == 1) {
            $input['inv_is_admin'] = 'checked="checked"';
        }
        #end inv
        #ga officer
        if (isset($input['ga_is_all']) && $input['ga_is_all'] == 1) {
            $input['ga_is_all'] = 'checked="checked"';
            $input['ga_status_admin'] = 1;
        }
        if (!empty($input['ga_officer_id'])) {
            $this->mrTemplate->addVar('create_ga', 'IS_EMPTY', 'NO');
            $input['create_ga'] = 'checked="checked"';
            $input['ga_status_officer'] = 1;
        } else {
            $this->mrTemplate->addVar('create_ga', 'IS_EMPTY', 'YES');
        }
        if ((isset($input['create_ga']) && $input['create_ga'] == 1)) {
            $input['create_ga'] = 'checked="checked"';
            $input['ga_status_officer'] = 1;
        }
        if (isset($input['ga_is_admin']) && $input['ga_is_admin'] == 1) {
            $input['ga_is_admin'] = 'checked="checked"';
        }
        if (isset($input['ga_approval_personalveh']) && $input['ga_approval_personalveh'] == 1) {
            $input['IS_PERSONAL_VEH'] = 'checked="checked"';
        }
        if (isset($input['ga_approval_goodsstocktrf']) && $input['ga_approval_goodsstocktrf'] == 1) {
            $input['IS_GOODS_STOCK_TRANS'] = 'checked="checked"';
        }
        if (isset($input['ga_approval_goodsusagereq']) && $input['ga_approval_goodsusagereq'] == 1) {
            $input['IS_GOODS_USAGE_REQ'] = 'checked="checked"';
        }
        if (isset($input['ga_approval_delivery']) && $input['ga_approval_delivery'] == 1) {
            $input['IS_APPROVAL_DELIVERY'] = 'checked="checked"';
        }
        if (isset($input['ga_approval_mailnum']) && $input['ga_approval_mailnum'] == 1) {
            $input['IS_MAIL_NUMBER'] = 'checked="checked"';
        }
        if (isset($input['ga_approval_docnum']) && $input['ga_approval_docnum'] == 1) {
            $input['IS_DOCUMENT_NUMBER'] = 'checked="checked"';
        }
        if (isset($input['ga_approval_parkreimburse']) && $input['ga_approval_parkreimburse'] == 1) {
            $input['IS_PARKING_REIMBURSE'] = 'checked="checked"';
        }
        if (isset($input['ga_approval_parkreimburse']) && $input['ga_approval_parkreimburse'] == 1) {
            $input['IS_PARKING_REIMBURSE'] = 'checked="checked"';
        }
        if (isset($input['ga_approval_fuelreimburse']) && $input['ga_approval_fuelreimburse'] == 1) {
            $input['IS_FUEL_REIMBURSE'] = 'checked="checked"';
        }
        if (isset($input['ga_approval_tollreimburse']) && $input['ga_approval_tollreimburse'] == 1) {
            $input['IS_TOLL_REIMBURSE'] = 'checked="checked"';
        }
        if (isset($input['ga_approval_taxivou']) && $input['ga_approval_taxivou'] == 1) {
            $input['IS_TAXI_VOUCHER'] = 'checked="checked"';
        }
        if (isset($input['ga_approval_taxivoudetreal']) && $input['ga_approval_taxivoudetreal'] == 1) {
            $input['IS_VOUCHER_REALIZATION'] = 'checked="checked"';
        }
        if (isset($input['ga_approval_stampduty']) && $input['ga_approval_stampduty'] == 1) {
            $input['IS_STAMP_DUTY'] = 'checked="checked"';
        }
        if (isset($input['ga_approval_vehiclecont']) && $input['ga_approval_vehiclecont'] == 1) {
            $input['IS_VEHICLE_CONTRACT'] = 'checked="checked"';
        }
        if (isset($input['ga_approval_vehiclefuel']) && $input['ga_approval_vehiclefuel'] == 1) {
            $input['IS_VEHICLE_FUEL'] = 'checked="checked"';
        }
        if (isset($input['ga_approval_vehicleserv']) && $input['ga_approval_vehicleserv'] == 1) {
            $input['IS_VEHICLE_SERVICE'] = 'checked="checked"';
        }
        if (isset($input['ga_approval_vehiclecost']) && $input['ga_approval_vehiclecost'] == 1) {
            $input['IS_VEHICLE_COST'] = 'checked="checked"';
        }
        #end ga
        #prod officer
        if (isset($input['prod_is_all']) && $input['prod_is_all'] == 1) {
            $input['prod_is_all'] = 'checked="checked"';
            $input['prod_status_admin'] = 1;
        }
        if (!empty($input['prod_officer_id'])) {
            $this->mrTemplate->addVar('create_prod', 'IS_EMPTY', 'NO');
            $input['create_prod'] = 'checked="checked"';
            $input['prod_status_officer'] = 1;
        } else {
            $this->mrTemplate->addVar('create_prod', 'IS_EMPTY', 'YES');
        }
        if ((isset($input['create_prod']) && $input['create_prod'] == 1)) {
            $input['create_prod'] = 'checked="checked"';
            $input['prod_status_officer'] = 1;
        }
        if (isset($input['prod_is_admin']) && $input['prod_is_admin'] == 1) {
            $input['prod_is_admin'] = 'checked="checked"';
        }
        #end prod
        #proj officer
        if (isset($input['proj_is_all']) && $input['proj_is_all'] == 1) {
            $input['proj_is_all'] = 'checked="checked"';
            $input['proj_status_admin'] = 1;
        }
        if (!empty($input['proj_officer_id'])) {
            $this->mrTemplate->addVar('create_proj', 'IS_EMPTY', 'NO');
            $input['create_proj'] = 'checked="checked"';
            $input['proj_status_officer'] = 1;
        } else {
            $this->mrTemplate->addVar('create_proj', 'IS_EMPTY', 'YES');
        }
        if ((isset($input['create_proj']) && $input['create_proj'] == 1)) {
            $input['create_proj'] = 'checked="checked"';
            $input['proj_status_officer'] = 1;
        }
        if (isset($input['proj_is_admin']) && $input['proj_is_admin'] == 1) {
            $input['proj_is_admin'] = 'checked="checked"';
        }
        #end proj
        #pcs officer
        if (isset($input['pcs_is_all']) && $input['pcs_is_all'] == 1) {
            $input['pcs_is_all'] = 'checked="checked"';
            $input['pcs_status_admin'] = 1;
        }
        if (!empty($input['pcs_officer_id'])) {
            $this->mrTemplate->addVar('create_pcs', 'IS_EMPTY', 'NO');
            $input['create_pcs'] = 'checked="checked"';
            $input['pcs_status_officer'] = 1;
        } else {
            $this->mrTemplate->addVar('create_pcs', 'IS_EMPTY', 'YES');
        }
        if ((isset($input['create_pcs']) && $input['create_pcs'] == 1)) {
            $input['create_pcs'] = 'checked="checked"';
            $input['pcs_status_officer'] = 1;
        }
        if (isset($input['pcs_is_admin']) && $input['pcs_is_admin'] == 1) {
            $input['pcs_is_admin'] = 'checked="checked"';
        }
        #end pcs
        #qc officer
        if (isset($input['qc_is_all']) && $input['qc_is_all'] == 1) {
            $input['qc_is_all'] = 'checked="checked"';
            $input['qc_status_admin'] = 1;
        }
        if (!empty($input['qc_officer_id'])) {
            $this->mrTemplate->addVar('create_qc', 'IS_EMPTY', 'NO');
            $input['create_qc'] = 'checked="checked"';
            $input['qc_status_officer'] = 1;
        } else {
            $this->mrTemplate->addVar('create_qc', 'IS_EMPTY', 'YES');
        }
        if ((isset($input['create_qc']) && $input['create_qc'] == 1)) {
            $input['create_qc'] = 'checked="checked"';
            $input['qc_status_officer'] = 1;
        }
        if (isset($input['qc_is_admin']) && $input['qc_is_admin'] == 1) {
            $input['qc_is_admin'] = 'checked="checked"';
        }
        #end qc
        #sales officer
        if (isset($input['sales_is_all']) && $input['sales_is_all'] == 1) {
            $input['sales_is_all'] = 'checked="checked"';
            $input['sales_status_admin'] = 1;
        }
        if (!empty($input['sales_officer_id'])) {
            $this->mrTemplate->addVar('create_sales', 'IS_EMPTY', 'NO');
            $input['create_sales'] = 'checked="checked"';
            $input['sales_status_officer'] = 1;
        } else {
            $this->mrTemplate->addVar('create_sales', 'IS_EMPTY', 'YES');
        }
        if ((isset($input['create_sales']) && $input['create_sales'] == 1)) {
            $input['create_sales'] = 'checked="checked"';
            $input['sales_status_officer'] = 1;
        }
        if (isset($input['sales_is_admin']) && $input['sales_is_admin'] == 1) {
            $input['sales_is_admin'] = 'checked="checked"';
        }
        #end sales
        #cms officer
        if (isset($input['cms_is_all']) && $input['cms_is_all'] == 1) {
            $input['cms_is_all'] = 'checked="checked"';
            $input['cms_status_admin'] = 1;
        }
        if (!empty($input['cms_officer_id'])) {
            $this->mrTemplate->addVar('create_cms', 'IS_EMPTY', 'NO');
            $input['create_cms'] = 'checked="checked"';
            $input['cms_status_officer'] = 1;
        } else {
            $this->mrTemplate->addVar('create_cms', 'IS_EMPTY', 'YES');
        }
        if ((isset($input['create_cms']) && $input['create_cms'] == 1)) {
            $input['create_cms'] = 'checked="checked"';
            $input['cms_status_officer'] = 1;
        }
        if (isset($input['cms_is_admin']) && $input['cms_is_admin'] == 1) {
            $input['cms_is_admin'] = 'checked="checked"';
        }
        #end cms
        #taf officer
        if (isset($input['taf_is_all']) && $input['taf_is_all'] == 1) {
            $input['taf_is_all'] = 'checked="checked"';
            $input['taf_status_admin'] = 1;
        }
        if (!empty($input['taf_officer_id'])) {
            $this->mrTemplate->addVar('create_taf', 'IS_EMPTY', 'NO');
            $input['create_taf'] = 'checked="checked"';
            $input['taf_status_officer'] = 1;
        } else {
            $this->mrTemplate->addVar('create_taf', 'IS_EMPTY', 'YES');
        }
        if ((isset($input['create_taf']) && $input['create_taf'] == 1)) {
            $input['create_taf'] = 'checked="checked"';
            $input['taf_status_officer'] = 1;
        }
        if (isset($input['taf_is_admin']) && $input['taf_is_admin'] == 1) {
            $input['taf_is_admin'] = 'checked="checked"';
        }
        #end taf

        if (!empty($input)) {
            $this->mrTemplate->addVars('create_crm', $input);
            $this->mrTemplate->addVars('tabs-input-officer-1', $input);
            $this->mrTemplate->addVars('create_hr', $input);
            $this->mrTemplate->addVars('tabs-input-officer-2', $input);
            $this->mrTemplate->addVars('create_fin', $input);
            $this->mrTemplate->addVars('tabs-input-officer-3', $input);
            $this->mrTemplate->addVars('create_fxa', $input);
            $this->mrTemplate->addVars('tabs-input-officer-4', $input);
            $this->mrTemplate->addVars('create_inv', $input);
            $this->mrTemplate->addVars('tabs-input-officer-5', $input);
            $this->mrTemplate->addVars('create_ga', $input);
            $this->mrTemplate->addVars('tabs-input-officer-6', $input);
            $this->mrTemplate->addVars('create_prod', $input);
            $this->mrTemplate->addVars('tabs-input-officer-7', $input);
            $this->mrTemplate->addVars('create_proj', $input);
            $this->mrTemplate->addVars('tabs-input-officer-8', $input);
            $this->mrTemplate->addVars('create_pcs', $input);
            $this->mrTemplate->addVars('tabs-input-officer-9', $input);
            $this->mrTemplate->addVars('create_qc', $input);
            $this->mrTemplate->addVars('tabs-input-officer-10', $input);
            $this->mrTemplate->addVars('create_sales', $input);
            $this->mrTemplate->addVars('tabs-input-officer-11', $input);
            $this->mrTemplate->addVars('create_cms', $input);
            $this->mrTemplate->addVars('tabs-input-officer-12', $input);
            $this->mrTemplate->addVars('create_taf', $input);
            $this->mrTemplate->addVars('tabs-input-officer-13', $input);
            $this->mrTemplate->addVars('content', $input);
        }


        $this->mrTemplate->addVar('content', 'URL_BACK', GtfwDispt()->GetUrl('emp.employee.mini', 'EmployeeMini', 'view', 'html') . '&display');
        $this->mrTemplate->addVar('content', 'URL', GtfwDispt()->GetUrl('emp.employee.mini', 'addEmployeeOfficer', 'do', 'json') . '&elmId=' . $elmId);
    }

}

?>