<?php

/**
 * @author GTFW CRUD Generator 
 */
class Unit extends Database {

    public function __construct($connectionNumber = 0) {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/core.unit/business/mysqlt/unit.sql.php');
        $this->SetDebugOn();
    }

    public function countUnit($filter) {
        if (is_array($filter))
            extract($filter);
        $str = '';

        if (!empty($parent_id)) {
            $str .= " AND a.unit_parent_id = $parent_id";
        }
        if (!empty($name)) {
            $str .= " AND LOWER(unit_name) LIKE('%$name%')";
        }
        $query = $this->mSqlQueries['count_unit'];
        $query = str_replace('--search--', $str, $query);
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    public function getUnit($filter) {
        if (is_array($filter))
            extract($filter);
        $str = '';

        if (!empty($parent_id)) {
            $str .= " AND a.unit_parent_id = $parent_id";
        }
        if (!empty($name)) {
            $str .= " AND LOWER(a.unit_name) LIKE('%$name%')";
        }
        $limit = '';
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";
        }
        $query = $this->mSqlQueries['get_unit'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());
        return $result;
    }

    public function getDetailUnit($id) {
        $result = $this->Open($this->mSqlQueries['get_detail_core_unit'], array($id));
        if ($result) {
            return $result[0];
        }
    }

    public function getDetailUnitToOrder($id) {
        $result = $this->Open($this->mSqlQueries['get_detail_core_unit_to_order'], array($id));
        if ($result) {
            return $result[0];
        }
    }

    public function getEmpDetailUnitToOrder($id) {
        $result = $this->Open($this->mSqlQueries['get_emp_detail_core_unit_to_order'], array($id));
        if ($result) {
            return $result[0];
        }
    }

    function getUnitByParent($items, $root_id = 0) {
        $this->html = array();
        $this->items = $items;

        foreach ($this->items as $item)
            $children[$item['parent_id']][] = $item;

        // loop will be false if the root has no children (i.e., an empty menu!)
        $loop = !empty($children[$root_id]);

        // initializing $parent as the root
        $parent = $root_id;
        $parent_stack = array();

        while ($loop && (($option = each($children[$parent])) || ($parent > $root_id))) {
            if ($option === false) {
                $parent = array_pop($parent_stack);
            } elseif (!empty($children[$option['value']['id']])) {
                $tab = str_repeat("&nbsp;&nbsp;", (count($parent_stack) + 1) * 2 - 2);

                // menu item containing childrens (open)
                $this->html[] = array(
                    'id' => $option['value']['id'],
                    'name' => $tab . $option['value']['name']
                );

                array_push($parent_stack, $option['value']['parent_id']);
                $parent = $option['value']['id'];
            } else {
                $tab = str_repeat("&nbsp;&nbsp;", (count($parent_stack) + 1) * 2 - 2);
                // menu item with no children (aka "leaf")

                $this->html[] = array(
                    'id' => $option['value']['id'],
                    'name' => $tab . $option['value']['name']
                );
            }
        }
        return $this->html;
    }

    function getUnitNoParent($items, $root_id = 0) {
        $this->html = array();
        $this->items = $items;

        foreach ($this->items as $item)
            $children[$item['parent_id']][] = $item;

        // loop will be false if the root has no children (i.e., an empty menu!)
        $loop = !empty($children[$root_id]);

        // initializing $parent as the root
        $parent = $root_id;
        $parent_stack = array();

        while ($loop && (($option = each($children[$parent])) || ($parent > $root_id))) {
            if ($option === false) {
                $parent = array_pop($parent_stack);
            } elseif (!empty($children[$option['value']['id']])) {
                $tab = str_repeat("", (count($parent_stack) + 1) * 2 - 2);

                // menu item containing childrens (open)
                $this->html[] = array(
                    'id' => $option['value']['id'],
                    'name' => $tab . $option['value']['name']
                );

                array_push($parent_stack, $option['value']['parent_id']);
                $parent = $option['value']['id'];
            } else {
                $tab = str_repeat("", (count($parent_stack) + 1) * 2 - 2);
                // menu item with no children (aka "leaf")

                $this->html[] = array(
                    'id' => $option['value']['id'],
                    'name' => $tab . $option['value']['name']
                );
            }
        }
        return $this->html;
    }

    public function insertUnit($params) {
        return $this->Execute($this->mSqlQueries['insert_unit'], $params);
    }

    public function updateUnit($params) {
        return $this->Execute($this->mSqlQueries['update_unit'], $params);
    }

    public function deleteUnit($id) {
        return $this->Execute($this->mSqlQueries['delete_unit'], array($id));
    }

    public function listUnit() {
        $result = $this->Open($this->mSqlQueries['list_unit'], array());
        if (!empty($result)) {
            return $this->getUnitByParent($result);
        }
    }

    public function listUnitNotParent() {
        $result = $this->Open($this->mSqlQueries['list_unit_to_report'], array());
        if (!empty($result)) {
            return $this->getUnitNoParent($result);
        }
    }

    public function getEmpByParentToOrder($id) {
        $result = $this->Open($this->mSqlQueries['get_emp_by_parent_to_order'], array($id));
        return $result;
    }

    public function listUnitByParentToOrder($id) {
        return $this->Open($this->mSqlQueries['list_unit_by_parent_to_order'], array($id));
    }

    public function listUnitByParent($id) {
        return $this->Open($this->mSqlQueries['list_unit_by_parent'], array($id));
    }

    public function listUnitToContractSummary() {
        $result = $this->Open($this->mSqlQueries['list_unit_to_contract_summary'], array());
        if (!empty($result)) {
            return $this->getUnitByParent($result);
        }
    }

    public function listUnitToOpportunitySummary() {
        $result = $this->Open($this->mSqlQueries['list_unit_to_opportunity_summary'], array());
        if (!empty($result)) {
            return $this->getUnitByParent($result);
        }
    }

    public function listUnitToProfit() {
        $result = $this->Open($this->mSqlQueries['list_unit_to_profit'], array());
        if (!empty($result)) {
            return $result;
        }
    }

    public function listUnitToProfitDetail() {
        $result = $this->Open($this->mSqlQueries['list_unit_to_profit_detail'], array());
        if (!empty($result)) {
            return $result;
        }
    }

    public function listUnitToGa() {
        $result = $this->Open($this->mSqlQueries['list_unit_to_ga'], array());
        if (!empty($result)) {
            return $result;
        }
    }

    public function listUnitToGaDetail() {
        $result = $this->Open($this->mSqlQueries['list_unit_to_ga_detail'], array());
        if (!empty($result)) {
            return $result;
        }
    }

    public function listUnitToTf() {
        $result = $this->Open($this->mSqlQueries['list_unit_to_tf'], array());
        if (!empty($result)) {
            return $result;
        }
    }

    public function listUnitToTfDetail() {
        $result = $this->Open($this->mSqlQueries['list_unit_to_tf_detail'], array());
        if (!empty($result)) {
            return $result;
        }
    }

    public function listUnitToBgUnit() {
        $result = $this->Open($this->mSqlQueries['list_unit_to_bg_unit'], array());
        if (!empty($result)) {
            return $result;
        }
    }

    public function listUnitToBgUnitDetail() {
        $result = $this->Open($this->mSqlQueries['list_unit_to_bg_unit_detail'], array());
        if (!empty($result)) {
            return $result;
        }
    }

    public function listUnitToProj() {
        $result = $this->Open($this->mSqlQueries['list_unit_to_proj'], array());
        if (!empty($result)) {
            return $result;
        }
    }

    public function listUnitToProjDetail() {
        $result = $this->Open($this->mSqlQueries['list_unit_to_proj_detail'], array());
        if (!empty($result)) {
            return $result;
        }
    }

    public function listUnitToCms() {
        $result = $this->Open($this->mSqlQueries['list_unit_to_cms'], array());
        if (!empty($result)) {
            return $result;
        }
    }

    public function listUnitToCmsDetail() {
        $result = $this->Open($this->mSqlQueries['list_unit_to_cms_detail'], array());
        if (!empty($result)) {
            return $result;
        }
    }

}

// End of file Unit.class.php