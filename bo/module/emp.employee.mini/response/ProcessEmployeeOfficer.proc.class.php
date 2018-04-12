<?php

/**
 * @author Prima Noor
 */
class ProcessEmployeeOfficer {

    var $Obj;
    var $user;
    var $ObjCrm;
    var $ObjHr;
    var $ObjFin;
    var $ObjFxa;
    var $ObjInv;
    var $ObjGa;
    var $ObjProd;
    var $ObjProj;
    var $ObjPcs;
    var $ObjQc;
    var $ObjSales;
    var $ObjCms;
    var $ObjTaf;
    var $cssDone = 'notebox-done';
    var $cssFail = 'notebox-warning';
    var $cssAlert = 'notebox-alert';

    function __construct() {
        $this->ObjEmployeeMini = GtfwDispt()->load->business('EmployeeMini');
        $this->user = Security::Authentication()->GetCurrentUser()->GetUserId();
        $this->ObjCrm = GtfwDispt()->load->business('CrmOfficer', 'crm.officer');
        $this->ObjFin = GtfwDispt()->load->business('FinOfficer', 'fin.officer');
        $this->ObjHr = GtfwDispt()->load->business('EmpOfficer', 'emp.officer');
        $this->ObjFxa = GtfwDispt()->load->business('FxaOfficer', 'fxa.officer');
        $this->ObjInv = GtfwDispt()->load->business('InvOfficer', 'inv.officer');
        $this->ObjGa = GtfwDispt()->load->business('GaOfficer', 'ga.officer');
        $this->ObjProd = GtfwDispt()->load->business('ProdOfficer', 'prod.officer');
        $this->ObjProj = GtfwDispt()->load->business('ProjOfficer', 'proj.officer');
        $this->ObjPcs = GtfwDispt()->load->business('PcsOfficer', 'pcs.officer');
        $this->ObjQc = GtfwDispt()->load->business('QcOfficer', 'qc.officer');
        $this->ObjSales = GtfwDispt()->load->business('SalesOfficer', 'sales.officer');
        $this->ObjCms = GtfwDispt()->load->business('CmsOfficer', 'cms.officer');
        $this->ObjTaf = GtfwDispt()->load->business('TafOfficer', 'taf.officer');
    }

    function input() {
        $post = $_POST->AsArray();
        $Val = GtfwDispt()->load->library('Validation');

        #$Val->set_rules('emp_id', GtfwLangText('employee_data'), 'required');

        $result = $Val->run();
        if ($result) {
            if (isset($post['create_crm'])) {
                if (empty($post['crm_officer_id'])) {
                    $result = $this->addCrmOfficer($post, 'add');
                } else {
                    $result = $this->addCrmOfficer($post, 'update');
                }
            }
            if (isset($post['create_hr'])) {
                if (empty($post['hr_officer_id'])) {
                    $result = $this->addHrOfficer($post, 'add');
                } else {
                    $result = $this->addHrOfficer($post, 'update');
                }
            }
            if (isset($post['create_fin'])) {
                if (empty($post['fin_officer_id'])) {
                    $result = $this->addFinOfficer($post, 'add');
                } else {
                    $result = $this->addFinOfficer($post, 'update');
                }
            }
            if (isset($post['create_fxa'])) {
                if (empty($post['fxa_officer_id'])) {
                    $result = $this->addFxaOfficer($post, 'add');
                } else {
                    $result = $this->addFxaOfficer($post, 'update');
                }
            }
            if (isset($post['create_inv'])) {
                if (empty($post['inv_officer_id'])) {
                    $result = $this->addInvOfficer($post, 'add');
                } else {
                    $result = $this->addInvOfficer($post, 'update');
                }
            }
            if (isset($post['create_ga'])) {
                if (empty($post['ga_officer_id'])) {
                    $result = $this->addGaOfficer($post, 'add');
                } else {
                    $result = $this->addGaOfficer($post, 'update');
                }
            }
            if (isset($post['create_prod'])) {
                if (empty($post['prod_officer_id'])) {
                    $result = $this->addProdOfficer($post, 'add');
                } else {
                    $result = $this->addProdOfficer($post, 'update');
                }
            }
            if (isset($post['create_proj'])) {
                if (empty($post['proj_officer_id'])) {
                    $result = $this->addProjOfficer($post, 'add');
                } else {
                    $result = $this->addProjOfficer($post, 'update');
                }
            }
            if (isset($post['create_pcs'])) {
                if (empty($post['pcs_officer_id'])) {
                    $result = $this->addPcsOfficer($post, 'add');
                } else {
                    $result = $this->addPcsOfficer($post, 'update');
                }
            }
            if (isset($post['create_qc'])) {
                if (empty($post['qc_officer_id'])) {
                    $result = $this->addQcOfficer($post, 'add');
                } else {
                    $result = $this->addQcOfficer($post, 'update');
                }
            }
            if (isset($post['create_sales'])) {
                if (empty($post['sales_officer_id'])) {
                    $result = $this->addSalesOfficer($post, 'add');
                } else {
                    $result = $this->addSalesOfficer($post, 'update');
                }
            }
            if (isset($post['create_cms'])) {
                if (empty($post['cms_officer_id'])) {
                    $result = $this->addCmsOfficer($post, 'add');
                } else {
                    $result = $this->addCmsOfficer($post, 'update');
                }
            }
            if (isset($post['create_taf'])) {
                if (empty($post['taf_officer_id'])) {
                    $result = $this->addTafOfficer($post, 'add');
                } else {
                    $result = $this->addTafOfficer($post, 'update');
                }
            }
            if ($result) {
                $msg = GtfwLangText('msg_add_officer_success');
                $css = $this->cssDone;
            } else {
                $msg = GtfwLangText('msg_add_officer_fail');
                $css = $this->cssFail;
            }
        } else {
            $msg = $Val->error_string('', '<br />');
            $css = $this->cssFail;
        }
        if ($result) {
            Messenger::Instance()->Send('emp.employee.mini', 'EmployeeMini', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
        } else {
            Messenger::Instance()->Send('emp.employee.mini', 'inputEmployeeOfficer', 'view', 'html', array($post, $msg, $css), Messenger::NextRequest);
        }
        return $result;
    }

    function addCrmOfficer($post, $process) {
        $result = true;
        if (empty($post['crm_off_id'])) {
            $post['crm_off_id'] = 0;
        }
        $post['crm_is_locked'] = 0;
        if (empty($post['crm_is_sales'])) {
            $post['crm_is_sales'] = '';
        }
        if (empty($post['crm_is_admin'])) {
            $post['crm_is_admin'] = '';
        }
        if (empty($post['crm_is_all'])) {
            $post['crm_is_all'] = '';
        }
        if ($process == 'add') {
            $this->ObjCrm->StartTrans();
            $params = array(
                $post['crm_off_id'],
                $post['id'],
                null, //$post['email'],
                null, //$this->base64url_encode($post['password']),
                $post['crm_is_sales'],
                $post['crm_is_all'],
                $post['crm_is_admin'],
                '1',
                $post['crm_desc'],
                $post['crm_is_locked'],
                $this->user
            );
            $result = $result && $this->ObjCrm->insertOfficer($params);
            $this->ObjCrm->EndTrans($result);
        } else {
            $this->ObjCrm->StartTrans();
            $params = array(
                $post['crm_off_id'],
                $post['id'],
                null, //$post['email'],
                null, //$this->base64url_encode($post['password']),
                $post['crm_is_sales'],
                $post['crm_is_all'],
                $post['crm_is_admin'],
                '1',
                $post['crm_desc'],
                $post['crm_is_locked'],
                $this->user,
                $post['crm_officer_id']
            );
            $result = $result && $this->ObjCrm->updateOfficer($params);
            $this->ObjCrm->EndTrans($result);
        }
        return $result;
    }

    function addHrOfficer($post, $process) {
        $result = true;
        if (empty($post['hr_off_id'])) {
            $post['hr_off_id'] = 0;
        }
        $post['hr_is_locked'] = 0;
        if (empty($post['hr_is_admin'])) {
            $post['hr_is_admin'] = '';
        }
        if (empty($post['hr_is_all'])) {
            $post['hr_is_all'] = '';
        }
        if ($process == 'add') {
            $this->ObjHr->StartTrans();
            $params = array(
                $post['hr_off_id'],
                $post['id'],
                $post['hr_is_all'],
                $post['hr_is_admin'],
                '1',
                $post['hr_desc'],
                $this->user
            );
            $result = $result && $this->ObjHr->insertEmpOfficer($params);
            $this->ObjHr->EndTrans($result);
        } else {
            $this->ObjHr->StartTrans();
            $params = array(
                $post['hr_off_id'],
                $post['id'],
                $post['hr_is_all'],
                $post['hr_is_admin'],
                '1',
                $post['hr_desc'],
                $this->user,
                $post['hr_officer_id']
            );
            $result = $result && $this->ObjHr->updateEmpOfficer($params);
            $this->ObjHr->EndTrans($result);
        }
        return $result;
    }

    function addFinOfficer($post, $process) {
        $result = true;
        if (empty($post['fin_off_id'])) {
            $post['fin_off_id'] = 0;
        }
        $post['fin_is_locked'] = 0;
        if (empty($post['fin_is_sales'])) {
            $post['fin_is_sales'] = '';
        } if (empty($post['fin_is_admin'])) {
            $post['fin_is_admin'] = '';
        }
        if (empty($post['fin_is_all'])) {
            $post['fin_is_all'] = '';
        }
        if (empty($post['fin_is_finance'])) {
            $post['fin_is_finance'] = '';
        }
        if (empty($post['fin_is_accounting'])) {
            $post['fin_is_accounting'] = '';
        }
        if ($process == 'add') {
            $this->ObjFin->StartTrans();
            $params = array(
                $post['fin_off_id'],
                $post['id'],
                $post['fin_is_finance'],
                $post['fin_is_accounting'],
                $post['fin_is_all'],
                $post['fin_is_admin'],
                '1',
                $post['fin_desc'],
                $this->user
            );
            $result = $result && $this->ObjFin->insertFinOfficer($params);
            $this->ObjFin->EndTrans($result);
        } else {
            $this->ObjFin->StartTrans();
            $params = array(
                $post['fin_off_id'],
                $post['id'],
                $post['fin_is_finance'],
                $post['fin_is_accounting'],
                $post['fin_is_all'],
                $post['fin_is_admin'],
                '1',
                $post['fin_desc'],
                $this->user,
                $post['fin_officer_id']
            );
            $result = $result && $this->ObjFin->updateFinOfficer($params);
            $this->ObjFin->EndTrans($result);
        }
        return $result;
    }

    function addFxaOfficer($post, $process) {
        $result = true;
        if (empty($post['fxa_off_id'])) {
            $post['fxa_off_id'] = 0;
        }
        $post['fxa_is_locked'] = 0;
        if (empty($post['fxa_is_admin'])) {
            $post['fxa_is_admin'] = '';
        }
        if (empty($post['fxa_is_all'])) {
            $post['fxa_is_all'] = '';
        }
        if ($process == 'add') {
            $this->ObjFxa->StartTrans();
            $params = array(
                $post['fxa_off_id'],
                $post['id'],
                null,
                null,
                $post['fxa_is_all'],
                $post['fxa_is_admin'],
                '1',
                $post['fxa_desc'],
                '1',
                $this->user
            );
            $result = $result && $this->ObjFxa->insertFxaOfficer($params);
            $officer_id = $this->ObjFxa->LastInsertId();
            if ($result) {
                if (!empty($post['serAttachmentVal'])) {
                    $result = $this->addOfficerAssetVarian($post, $officer_id);
                }
            }
            $this->ObjFxa->EndTrans($result);
        } else {
            $this->ObjFxa->StartTrans();
            $params = array(
                $post['fxa_off_id'],
                $post['id'],
                null,
                null,
                $post['fxa_is_all'],
                $post['fxa_is_admin'],
                '1',
                $post['fxa_desc'],
                '1',
                $this->user,
                $post['fxa_officer_id']
            );
            $result = $result && $this->ObjFxa->updateFxaOfficer($params);
            if ($result) {
                $result = $this->ObjFxa->deleteOfficerAssetVarian($post['fxa_officer_id']);
                $result = $result && $this->addOfficerAssetVarian($post, $post['fxa_officer_id']);
            }
            $this->ObjFxa->EndTrans($result);
        }
        return $result;
    }

    function addInvOfficer($post, $process) {
        $result = true;
        if (empty($post['inv_off_id'])) {
            $post['inv_off_id'] = 0;
        }
        $post['inv_is_locked'] = 0;
        if (empty($post['inv_is_admin'])) {
            $post['inv_is_admin'] = '';
        }
        if (empty($post['inv_is_all'])) {
            $post['inv_is_all'] = '';
        }
        if ($process == 'add') {
            $this->ObjInv->StartTrans();
            $params = array(
                $post['inv_off_id'],
                $post['id'],
                $post['inv_is_all'],
                $post['inv_is_admin'],
                '1',
                $post['inv_desc'],
                $this->user
            );
            $result = $result && $this->ObjInv->insertInvOfficer($params);
            $this->ObjInv->EndTrans($result);
        } else {
            $this->ObjInv->StartTrans();
            $params = array(
                $post['inv_off_id'],
                $post['id'],
                $post['inv_is_all'],
                $post['inv_is_admin'],
                '1',
                $post['inv_desc'],
                $this->user,
                $post['inv_officer_id']
            );
            $result = $result && $this->ObjInv->updateInvOfficer($params);
            $this->ObjInv->EndTrans($result);
        }
        return $result;
    }

    function addGaOfficer($post, $process) {
        $result = true;
        if (empty($post['ga_off_id'])) {
            $post['ga_off_id'] = 0;
        }
        $post['ga_is_locked'] = 0;
        if (empty($post['ga_is_admin'])) {
            $post['ga_is_admin'] = '';
        }
        if (empty($post['ga_is_all'])) {
            $post['ga_is_all'] = '';
        }
        if (empty($post['ga_approval_personalveh'])) {
            $post['ga_approval_personalveh'] = '';
        }
        if (empty($post['ga_approval_goodsstocktrf'])) {
            $post['ga_approval_goodsstocktrf'] = '';
        }
        if (empty($post['ga_approval_goodsusagereq'])) {
            $post['ga_approval_goodsusagereq'] = '';
        }
        if (empty($post['ga_approval_delivery'])) {
            $post['ga_approval_delivery'] = '';
        }
        if (empty($post['ga_approval_mailnum'])) {
            $post['ga_approval_mailnum'] = '';
        }
        if (empty($post['ga_approval_docnum'])) {
            $post['ga_approval_docnum'] = '';
        }
        if (empty($post['ga_approval_parkreimburse'])) {
            $post['ga_approval_parkreimburse'] = '';
        }
        if (empty($post['ga_approval_fuelreimburse'])) {
            $post['ga_approval_fuelreimburse'] = '';
        }
        if (empty($post['ga_approval_tollreimburse'])) {
            $post['ga_approval_tollreimburse'] = '';
        }
        if (empty($post['ga_approval_taxivou'])) {
            $post['ga_approval_taxivou'] = '';
        }
        if (empty($post['ga_approval_taxivoudetreal'])) {
            $post['ga_approval_taxivoudetreal'] = '';
        }
        if (empty($post['ga_approval_stampduty'])) {
            $post['ga_approval_stampduty'] = '';
        }
        if (empty($post['ga_approval_stampduty'])) {
            $post['ga_approval_stampduty'] = '';
        }
        if (empty($post['ga_approval_vehiclecont'])) {
            $post['ga_approval_vehiclecont'] = '';
        }
        if (empty($post['ga_approval_vehiclefuel'])) {
            $post['ga_approval_vehiclefuel'] = '';
        }
        if (empty($post['ga_approval_vehicleserv'])) {
            $post['ga_approval_vehicleserv'] = '';
        }
        if (empty($post['ga_approval_vehiclecost'])) {
            $post['ga_approval_vehiclecost'] = '';
        }
        if ($process == 'add') {
            $this->ObjGa->StartTrans();
            $params = array(
                $post['ga_off_id'],
                $post['id'],
                null,
                null,
                $post['ga_is_all'],
                $post['ga_is_admin'],
                $post['ga_approval_personalveh'],
                $post['ga_approval_goodsstocktrf'],
                $post['ga_approval_goodsusagereq'],
                $post['ga_approval_delivery'],
                $post['ga_approval_mailnum'],
                $post['ga_approval_docnum'],
                $post['ga_approval_parkreimburse'],
                $post['ga_approval_fuelreimburse'],
                $post['ga_approval_tollreimburse'],
                $post['ga_approval_taxivou'],
                $post['ga_approval_taxivoudetreal'],
                $post['ga_approval_stampduty'],
                $post['ga_approval_vehiclecont'],
                $post['ga_approval_vehiclefuel'],
                $post['ga_approval_vehicleserv'],
                $post['ga_approval_vehiclecost'],
                '1',
                $post['ga_desc'],
                '1',
                $this->user
            );
            $result = $result && $this->ObjGa->insertGaOfficer($params);
            $this->ObjGa->EndTrans($result);
        } else {
            $this->ObjGa->StartTrans();
            $params = array(
                $post['ga_off_id'],
                $post['id'],
                null,
                null,
                $post['ga_is_all'],
                $post['ga_is_admin'],
                $post['ga_approval_personalveh'],
                $post['ga_approval_goodsstocktrf'],
                $post['ga_approval_goodsusagereq'],
                $post['ga_approval_delivery'],
                $post['ga_approval_mailnum'],
                $post['ga_approval_docnum'],
                $post['ga_approval_parkreimburse'],
                $post['ga_approval_fuelreimburse'],
                $post['ga_approval_tollreimburse'],
                $post['ga_approval_taxivou'],
                $post['ga_approval_taxivoudetreal'],
                $post['ga_approval_stampduty'],
                $post['ga_approval_vehiclecont'],
                $post['ga_approval_vehiclefuel'],
                $post['ga_approval_vehicleserv'],
                $post['ga_approval_vehiclecost'],
                '1',
                $post['ga_desc'],
                '1',
                $this->user,
                $post['ga_officer_id']
            );
            $result = $result && $this->ObjGa->updateGaOfficer($params);
            $this->ObjGa->EndTrans($result);
        }
        return $result;
    }

    function addProdOfficer($post, $process) {
        $result = true;
        if (empty($post['prod_off_id'])) {
            $post['prod_off_id'] = 0;
        }
        if (empty($post['prod_is_admin'])) {
            $post['prod_is_admin'] = '';
        }
        if (empty($post['prod_is_all'])) {
            $post['prod_is_all'] = '';
        }
        if ($process == 'add') {
            $this->ObjProd->StartTrans();
            $params = array(
                $post['prod_off_id'],
                $post['id'],
                $post['prod_is_all'],
                $post['prod_is_admin'],
                '1',
                $post['prod_desc'],
                $this->user
            );
            $result = $result && $this->ObjProd->insertProdOfficer($params);
            $this->ObjProd->EndTrans($result);
        } else {
            $this->ObjProd->StartTrans();
            $params = array(
                $post['prod_off_id'],
                $post['id'],
                $post['prod_is_all'],
                $post['prod_is_admin'],
                '1',
                $post['prod_desc'],
                $this->user,
                $post['prod_officer_id']
            );
            $result = $result && $this->ObjProd->updateProdOfficer($params);
            $this->ObjProd->EndTrans($result);
        }
        return $result;
    }

    function addProjOfficer($post, $process) {
        $result = true;
        if (empty($post['proj_off_id'])) {
            $post['proj_off_id'] = 0;
        }
        if (empty($post['proj_is_admin'])) {
            $post['proj_is_admin'] = '';
        }
        if (empty($post['proj_is_all'])) {
            $post['proj_is_all'] = '';
        }
        if ($process == 'add') {
            $this->ObjProj->StartTrans();
            $params = array(
                $post['proj_off_id'],
                $post['id'],
                $post['proj_is_all'],
                $post['proj_is_admin'],
                '1',
                $post['proj_desc'],
                $this->user
            );
            $result = $result && $this->ObjProj->insertProjOfficer($params);
            $this->ObjProj->EndTrans($result);
        } else {
            $this->ObjProj->StartTrans();
            $params = array(
                $post['proj_off_id'],
                $post['id'],
                $post['proj_is_all'],
                $post['proj_is_admin'],
                '1',
                $post['proj_desc'],
                $this->user,
                $post['proj_officer_id']
            );
            $result = $result && $this->ObjProj->updateProjOfficer($params);
            $this->ObjProj->EndTrans($result);
        }
        return $result;
    }

    function addPcsOfficer($post, $process) {
        $result = true;
        if (empty($post['pcs_off_id'])) {
            $post['pcs_off_id'] = 0;
        }
        if (empty($post['pcs_is_admin'])) {
            $post['pcs_is_admin'] = '';
        }
        if (empty($post['pcs_is_all'])) {
            $post['pcs_is_all'] = '';
        }
        if ($process == 'add') {
            $this->ObjPcs->StartTrans();
            $params = array(
                $post['pcs_off_id'],
                $post['id'],
                $post['pcs_is_all'],
                $post['pcs_is_admin'],
                '1',
                $post['pcs_desc'],
                $this->user
            );
            $result = $result && $this->ObjPcs->insertPcsOfficer($params);
            $this->ObjPcs->EndTrans($result);
        } else {
            $this->ObjPcs->StartTrans();
            $params = array(
                $post['pcs_off_id'],
                $post['id'],
                $post['pcs_is_all'],
                $post['pcs_is_admin'],
                '1',
                $post['pcs_desc'],
                $this->user,
                $post['pcs_officer_id']
            );
            $result = $result && $this->ObjPcs->updatePcsOfficer($params);
            $this->ObjPcs->EndTrans($result);
        }
        return $result;
    }

    function addQcOfficer($post, $process) {
        $result = true;
        if (empty($post['qc_off_id'])) {
            $post['qc_off_id'] = 0;
        }
        if (empty($post['qc_is_admin'])) {
            $post['qc_is_admin'] = '';
        }
        if (empty($post['qc_is_all'])) {
            $post['qc_is_all'] = '';
        }
        if ($process == 'add') {
            $this->ObjQc->StartTrans();
            $params = array(
                $post['qc_off_id'],
                $post['id'],
                $post['qc_is_all'],
                $post['qc_is_admin'],
                '1',
                $post['qc_desc'],
                $this->user
            );
            $result = $result && $this->ObjQc->insertQcOfficer($params);
            $this->ObjQc->EndTrans($result);
        } else {
            $this->ObjQc->StartTrans();
            $params = array(
                $post['qc_off_id'],
                $post['id'],
                $post['qc_is_all'],
                $post['qc_is_admin'],
                '1',
                $post['qc_desc'],
                $this->user,
                $post['qc_officer_id']
            );
            $result = $result && $this->ObjQc->updateQcOfficer($params);
            $this->ObjQc->EndTrans($result);
        }
        return $result;
    }

    function addSalesOfficer($post, $process) {
        $result = true;
        if (empty($post['sales_off_id'])) {
            $post['sales_off_id'] = 0;
        }
        if (empty($post['sales_is_admin'])) {
            $post['sales_is_admin'] = '';
        }
        if (empty($post['sales_is_all'])) {
            $post['sales_is_all'] = '';
        }
        if ($process == 'add') {
            $this->ObjSales->StartTrans();
            $params = array(
                $post['sales_off_id'],
                $post['id'],
                $post['sales_is_all'],
                $post['sales_is_admin'],
                '1',
                $post['sales_desc'],
                $this->user
            );
            $result = $result && $this->ObjSales->insertSalesOfficer($params);
            $this->ObjSales->EndTrans($result);
        } else {
            $this->ObjSales->StartTrans();
            $params = array(
                $post['sales_off_id'],
                $post['id'],
                $post['sales_is_all'],
                $post['sales_is_admin'],
                '1',
                $post['sales_desc'],
                $this->user,
                $post['sales_officer_id']
            );
            $result = $result && $this->ObjSales->updateSalesOfficer($params);
            $this->ObjSales->EndTrans($result);
        }
        return $result;
    }

    function addCmsOfficer($post, $process) {
        $result = true;
        if (empty($post['cms_off_id'])) {
            $post['cms_off_id'] = 0;
        }
        if (empty($post['cms_is_admin'])) {
            $post['cms_is_admin'] = '';
        }
        if (empty($post['cms_is_all'])) {
            $post['cms_is_all'] = '';
        }
        if ($process == 'add') {
            $this->ObjCms->StartTrans();
            $params = array(
                $post['cms_off_id'],
                $post['id'],
                $post['cms_is_all'],
                $post['cms_is_admin'],
                '1',
                $post['cms_desc'],
                $this->user
            );
            $result = $result && $this->ObjCms->insertCmsOfficer($params);
            $this->ObjCms->EndTrans($result);
        } else {
            $this->ObjCms->StartTrans();
            $params = array(
                $post['cms_off_id'],
                $post['id'],
                $post['cms_is_all'],
                $post['cms_is_admin'],
                '1',
                $post['cms_desc'],
                $this->user,
                $post['cms_officer_id']
            );
            $result = $result && $this->ObjCms->updateCmsOfficer($params);
            $this->ObjCms->EndTrans($result);
        }
        return $result;
    }

    function addTafOfficer($post, $process) {
        $result = true;
        if (empty($post['taf_is_admin'])) {
            $post['taf_is_admin'] = '';
        }
        if (empty($post['taf_is_all'])) {
            $post['taf_is_all'] = '';
        }
        if ($process == 'add') {
            $this->ObjTaf->StartTrans();
            $params = array(
                $post['id'],
                $post['taf_is_all'],
                $post['taf_is_admin'],
                '1',
                $post['taf_desc'],
                '1',
                $this->user
            );
            $result = $result && $this->ObjTaf->insertTafOfficer($params);
            $this->ObjTaf->EndTrans($result);
        } else {
            $this->ObjTaf->StartTrans();
            $params = array(
                $post['id'],
                $post['taf_is_all'],
                $post['taf_is_admin'],
                '1',
                $post['taf_desc'],
                '1',
                $this->user,
                $post['taf_officer_id']
            );
            $result = $result && $this->ObjTaf->updateTafOfficer($params);
            $this->ObjTaf->EndTrans($result);
        }
        return $result;
    }

    function addOfficerAssetVarian($post, $officer_id) {
        $result = true;
        $this->ObjFxa->StartTrans();
        if (!empty($post['serAttachmentVal'])) {
            foreach ($post['serAttachmentVal'] as $key => $val) {
                if (!empty($val)) {
                    $params = array(
                        $officer_id,
                        $val,
                        $this->user
                    );
                    $result = $result && $this->ObjFxa->insertOfficerAssetVarian($params);
                }
            }
        }
        $this->ObjFxa->EndTrans($result);
        return $result;
    }

}

?>