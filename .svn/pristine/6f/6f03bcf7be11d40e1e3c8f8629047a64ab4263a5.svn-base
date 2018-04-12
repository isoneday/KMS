<?php

class DoGetNotif extends JsonResponse {

   function ProcessRequest()
   {
      $Obj = GtfwDispt()->load->business('Notification', 'comp.notification');
      $data = $Obj->getNewNotification();
      if (empty($data)) return array('exec'=>'alert("there is no notification!")');
      
      $array = array(); $i = 0;
      foreach ($data as $data)
      {
         $url = explode('|',$data['notif_url'],5);
         if (count($url) < 4) $url = implode('|',$url);
         else $url = Dispatcher::Instance()->GetUrl($url[0],$url[1],$url[2],$url[3]);
         
         $array[$i][] = $data['notif_title'];
         $array[$i][] = $data['notif_content'];
         $array[$i][] = $url;
         $array[$i][] = $data['notif_duration'];
         $i++;
      }
      
      return array('notification'=>$array);
   }
}
?>
