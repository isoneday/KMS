<?php

class DoCountNewMessage extends JsonResponse {

   function ProcessRequest()
   {
      $Obj = GtfwDispt()->load->business('CompMessage', 'comp.message');
      $count = $Obj->countNewMessage();
      return array('exec'=>"window.newMessageCount=$count",'count'=>$count);
   }

}
?>
