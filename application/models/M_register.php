<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_register extends CI_Model {

    function getUniv() {

        $this->db->select('universitas_id as id,universitas_name as name');
        $this->db->from('ref_universitas');
        $this->db->order_by('universitas_name', 'asc');
        $query = $this->db->get();
        return $query;
    }

    function getData($loadType, $loadId) {
        if ($loadType == "fakultas") {
            $fieldList = 'fakultas_id as id,fakulTas_name as name';
            $table = 'ref_fakultas';
            $fieldName = 'fakultas_univ_id';
            $orderByField = 'fakulTas_name';
        } else if($loadType=="jurusan") {
            $fieldList = 'jurusan_id as id,jurusan_name as name';
            $table = 'ref_jurusan';
            $fieldName = 'jurusan_fakultas_id';
            $orderByField = 'jurusan_name';
        } else {
            $fieldList = 'prodi_id as id,prodi_name as name';
            $table = 'ref_program_studi';
            $fieldName = 'prodi_jurusan_id';
            $orderByField = 'prodi_name';
        }
        $this->db->select($fieldList);
        $this->db->from($table);
        $this->db->where($fieldName, $loadId);
        $this->db->order_by($orderByField, 'asc');
        $query = $this->db->get();
        return $query;
    }



    function insertMerc($data) {
        $this->db->insert("aplikan_register", $data);
        return $this->db->insert_id();
    }

    function insetGtfwUser($datauser) {
        $this->db->insert("gtfw_user", $datauser);
        return $this->db->insert_id();
    }

    function insertGtfwGroup($datagroup) {
        $this->db->insert("gtfw_user_group", $datagroup);
    }

    function insertMercUser($datamerchuser) {
        $this->db->insert("aplikan_user", $datamerchuser);
        return true;
    }


}
