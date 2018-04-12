<?php

class ViewNotifList extends HtmlResponse
{

    function TemplateModule()
    {
        $this->SetTemplateBasedir('module/comp.notification/template');
        $this->SetTemplateFile('view_notif_list.html');
    }

    function ProcessRequest()
    {
        $Obj = GtfwDispt()->load->business('Notification');
        $ObjSetting = GtfwDispt()->load->business('Setting', 'core.setting');

        // Generate parameter

        $msg = Messenger::Instance()->Receive(__FILE__);
		$filter_data = isset($msg[0][0])? $msg[0][0]:NULL;
		$pesan['pesan'] = isset($msg[1][1])?$msg[1][1]:NULL;
		$pesan['class'] = isset($msg[1][2])?$msg[1][2]:NULL;
		
		if (!isset($_GET['display']) || empty($filter_data)) {
		    $page = 1;
		    $start = 0;
		    $display = (int)$ObjSetting->getValue('view_per_page');
		    $filter = compact('page', 'display', 'start');
		} elseif ($_GET['display']->Raw() != '') {
		    $page = (int)$_GET['page']->SqlString()->Raw();
		    $display = (int)$_GET['display']->SqlString()->Raw();
		
		    if ($page < 1)
		        $page = 1;
		    if ($display < 1)
		        $display = (int)$ObjSetting->getValue('view_per_page');
		    $start = ($page - 1) * $display;
		
		    $filter = compact('page', 'display', 'start');
		    $filter += $filter_data;
		} else {
		    $filter = $filter_data;
		    $page = $filter['page'];
		    $display = $filter['display'];
		    $start = $filter['start'];
		}
		
		$post_data = $_POST->AsArray();
		if (isset($post_data))
		    foreach ($post_data as $key => $value)
		        $filter[$key] = $value;
		Messenger::Instance()->Send(Dispatcher::Instance()->mModule, Dispatcher::Instance()->mSubModule, Dispatcher::Instance()->mAction, Dispatcher::Instance()->mType, array($filter), Messenger::UntilFetched);
		$return['filter'] = $filter;
        
        $return['notificationList'] = $Obj->getNotification($filter);
        $total = $Obj->countNotification();
        
		$url = Dispatcher::Instance()->GetUrl(Dispatcher::Instance()->mModule, Dispatcher::Instance()->mSubModule, Dispatcher::Instance()->mAction, Dispatcher::Instance()->mType);
		Messenger::Instance()->SendToComponent('comp.paging', 'Paging', 'view', 'html', 'paging_top', array($display, $total, $url, $page), Messenger::CurrentRequest);
        
        // Generate url
        $url = array();
        $url['view'] = Dispatcher::Instance()->GetUrl('comp.notification', 'notifList', 'view', 'html');
        $return['url'] = $url;

        $nav[0]['url'] = "";
        $nav[0]['menu'] = "";
        $title = GtfwLangText('notification');

        Messenger::Instance()->SendToComponent('comp.breadcrump', 'breadcrump', 'view', 'html', 'breadcrump', array(
            $title,
            $nav,
            'breadcrump',
            'hidden',
            ''), Messenger::CurrentRequest);

        return $return;
    }

    function ParseTemplate($data = null)
    {
        extract($data);
        
        $this->mrTemplate->addVar('search', 'URL', GtfwDispt()->GetCurrentUrl().'&display');
        if (!empty($filter)) {
            $this->mrTemplate->addVars('search', $filter);
        }

        $number = $filter['start'] + 1;
        if (!empty($notificationList)){
            foreach ($notificationList as $item) {
                $item['IS_EMPTY'] = "NO";
                $item['number'] = $number++;
                $item['class_name'] = ($number % 2) ? 'table-common-even' : '';
                $item['notifDateSubmitLabel'] = $this->Date($item['insert_timestamp']);

                $this->mrTemplate->AddVars('notification', $item);
                $this->mrTemplate->ParseTemplate('notification', 'a');
            }
        } else
            $this->mrTemplate->AddVar('notification', 'IS_EMPTY', 'YES');
    }

    function Date($date)
    {
        static $days = array(
            'Ahad',
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jum\'at',
            'Sabtu');
        static $months = array(
            1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'Sepetember',
            'Oktober',
            'November',
            'Desember');
        static $currentTime;

        if (!isset($currentTime))
            $currentTime = getdate(time());
        $sentTime = getdate(strtotime($date));
        $divTime = $currentTime[0] - $sentTime[0];
        if ($divTime < 43200 or ($divTime < 86400 and $currentTime['mday'] == $sentTime['mday']))
            $return = date('H:i', $sentTime[0]);
        elseif ($divTime < 432000 or ($divTime < 604800 and date('W', $currentTime[0]) == date('W', $sentTime[0])))
            $return = $days[$sentTime['wday']] . ', ' . date('H:i', $sentTime[0]);
        elseif ($divTime < 15768000 or ($divTime < 31500000 and $currentTime['mon'] == $sentTime['mon']))
            $return = $sentTime['mday'] . ' ' . $months[$sentTime['mon']];
        else
            $return = $sentTime['year'] . ' ' . $months[$sentTime['mon']];

        return $return;
    }

}

?>
