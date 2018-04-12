<?php

class ViewPaging extends HtmlResponse
{
    var $mComponentParameters;

    function TemplateModule()
    {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/comp.paging/template');
        $this->SetTemplateFile('view_paging.html');
    }

    function ProcessRequest()
    {
        # if js is enabled
        $msg = Messenger::Instance()->Receive(__file__);
		
        if (isset($msg[0]['page'])) {
            $itemsViewed = $msg[0]['itemsViewed'];
            $url = $msg[0]['url'];
            $page = $msg[0]['page'];
            $nav_class = $msg[0]['nav_class'];
            $keyword = $msg[0]['keyword'];
            $combo = $msg[0]['combo'];
        } else {
            # if js is disabled
            $page = false;
            $itemsViewed = 10;
            $totItems = 0;
            $url = '';

            // By default fetch param from gtfw-render module
            if (isset($this->mComponentParameters['itemviewed']))
                $itemsViewed = $this->mComponentParameters['itemviewed'];

            if (isset($this->mComponentParameters['totitems']))
                $totItems = $this->mComponentParameters['totitems'];

            if (isset($this->mComponentParameters['pagingurl']))
                $url = $this->mComponentParameters['pagingurl'];

            if (isset($this->mComponentParameters['page'])) {
                $page = $this->mComponentParameters['page'];
            } else
                $page = false;

            if (isset($this->mComponentParameters['nav_class'])) {
                $nav_class = $this->mComponentParameters['nav_class'];
            } else
                $nav_class = '';

            // support component messenger
            $msg = Messenger::Instance()->Receive(__file__, $this->mComponentName);
            
            if (!empty($msg)) {
                $itemsViewed = $msg[0][0];
                $totItems = $msg[0][1];
                $url = $msg[0][2];
                $dest = !empty($msg[0][4])?$msg[0][4]:'subcontent-element';

                if (isset($msg[0][3])) {
                    if (is_array($msg[0][3])) {
                        $page = $msg[0][3][0];
                        $keyword = $msg[0][3][1];
                        $combo = $msg[0][3][2];
                    } else {
                        $page = $msg[0][3];
                        $keyword = false;
                        $combo = false;
                    }
                } else {
                    $page = false;
                    $keyword = false;
                    $combo = false;
                }
            }
        }
        
        $dataViewed = $itemsViewed;
        
        $display[0]['id'] = "5";
        $display[0]['name'] = "5";
        $display[1]['id'] = "10";
        $display[1]['name'] = "10";
        $display[2]['id'] = "20";
        $display[2]['name'] = "20";
        $display[3]['id'] = "50";
        $display[3]['name'] = "50";
        $display[4]['id'] = "100";
        $display[4]['name'] = "100";
        $display[5]['id'] = "200";
        $display[5]['name'] = "200";
        $display[6]['id'] = "1000000000";
        $display[6]['name'] = GtfwLangText('all');
        //print_r($tipe);
        Messenger::Instance()->SendToComponent('comp.combobox', 'Combobox', 'view', 'html', 'display', array('paging-display', $display, $dataViewed, '', ' data-url="'.$url.'" data-dest="'.$dest.'" style= ""'), Messenger::CurrentRequest);
        return $this->multipage($totItems, $itemsViewed, $url, $page, $nav_class, $keyword, $combo, $dataViewed, $dest);
    }

    function ParseTemplate($data = null)
    {
        if (!empty($data)) {
            $this->mrTemplate->SetAttribute('page_nav', 'visibility', 'visible');

            $this->mrTemplate->AddVar('page_nav', 'URL', $data['url']);

            foreach ($data as $key => $value) {
                if ($value != '') {
                    if (is_array($value)) {
                        $this->mrTemplate->AddVar("page_nav_$key", "START_REC_INFO", $value['start'] + 1);
                        $this->mrTemplate->AddVar("page_nav_$key", "END_REC_INFO", $value['end']);
                        $this->mrTemplate->AddVar("page_nav_$key", "ALL_REC_INFO", $value['all']);
                        $this->mrTemplate->AddVar("page_nav_$key", 'NAV_CLASS', $data['nav_class']);
                    } else {
                        $this->mrTemplate->AddVar("page_nav_$key", 'IS_AVAIL', 'YES');
                        $this->mrTemplate->AddVar("page_nav_$key", strtoupper($key) . "_NAV_URL", $value);
                        $this->mrTemplate->AddVar("page_nav_$key", 'NAV_CLASS', $data['nav_class']);
                    }
                } else {
                    $this->mrTemplate->AddVar("page_nav_$key", 'IS_AVAIL', 'NO');
                }
            }
            $this->mrTemplate->addGlobalVar('DESTINATION', $data['dest']);
        } else {
            $this->mrTemplate->SetAttribute('page_nav', 'visibility', 'hidden');
        }
    }

    function multipage($jmlitem, $itemviewed, $webpage, $page = false, $nav_class = '', $keyword = false, $combo = false, $dataViewed, $dest)
    {
        $num = $jmlitem;
        $spp = $itemviewed;
        $multipage = array();

        if ($num > 0) {
            if ($page) {
                $start = ($page - 1) * $spp;
            } else {
                $start = 0;
                $page = 1;
            }

            if (($start + $spp) < $num) {
                $end = $start + $spp;
            } else {
                $end = $num;
            }

            if ($num > $spp) {
                $pages = $num / $spp;
                $pages = ceil($pages);

                $awal = 1;

                if (($page - 1) < 1) {
                    $pgawal = $page;
                    if (($page + 3) < $pages) {
                        $pgakhir = $pgawal + 4;
                    } elseif (($page + 3) >= $pages) {
                        $pgakhir = $pages;
                    }

                } else {
                    $pgawal = $page - 1;
                    if (($page + 3) < $pages) {
                        $pgakhir = $pgawal + 4;
                    } elseif (($page + 3) >= $pages) {
                        $pgakhir = $pages;
                    }
                }

                //for ($i = $pgawal; $i <= $pgakhir; $i++) {
                //   $fwd_back .= " <a href=\"$webpage&idx=".$i."\">".$i."</a> ";
                //}

                if ($pgakhir > 0) {
                    $prev = $page - 1;
                    $next = $page + 1;

                    if ($page <= $awal) {

                        // first and prev will be not available
                        $first = "";
                        $prev = "";
                        $next = "$webpage&page=$next&keyword=$keyword&combo=$combo&display=$dataViewed";
                        $last = "$webpage&page=$pages&keyword=$keyword&combo=$combo&display=$dataViewed";
                    } elseif ($page > $awal && $page < $pages) {

                        $first = "$webpage&page=$awal&keyword=$keyword&combo=$combo&display=$dataViewed";
                        $last = "$webpage&page=$pages&keyword=$keyword&combo=$combo&display=$dataViewed";
                        $next = "$webpage&page=$next&keyword=$keyword&combo=$combo&display=$dataViewed";
                        $prev = "$webpage&page=$prev&keyword=$keyword&combo=$combo&display=$dataViewed";
                    } else {
                        $first = "$webpage&page=$awal&keyword=$keyword&combo=$combo&display=$dataViewed";
                        $last = "";
                        $next = "";
                        $prev = "$webpage&page=$prev&keyword=$keyword&combo=$combo&display=$dataViewed";
                    }
                } else {
                    $multipage = null;
                }
            } else {
                $first = "";
                $last = "";
                $next = "";
                $prev = "";
            }

            $multipage = array("first" => $first, "prev" => $prev, "next" => $next, "last" => $last, "info" => array("start" => $start, "end" => $end, "all" => $num), "nav_class" => $nav_class, "url" => $webpage, 'dest' => $dest);

        }
        return $multipage;
    }
}

?>
