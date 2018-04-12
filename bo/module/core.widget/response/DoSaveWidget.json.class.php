<?php
/**
 * @author Prima Noor 
 */
   
class DoSaveWidget extends JsonResponse
{
   	function ProcessRequest()
   	{	
   	    $post = $_POST->AsArray();
        echo '<pre>'; print_r($post); echo '</pre>';
        $menu_id = $post['menu_id'];
        $data = json_decode($post['data']);
        if (isset($data)) {
            $ObjHome = GtfwDispt()->load->business('CoreWidget', 'core.widget');
            $result = true;
            $ObjHome->StartTrans();
            $userId = Security::Authentication()->GetCurrentUser()->GetUserId();
            echo '<pre>'; print_r($userId); echo '</pre>';
            $result = $ObjHome->deleteUserWidget($userId, $menu_id);
            echo '<pre>'; print_r($ObjHome->GetLastError()); echo '</pre>';
            if (!empty($data)) {
                foreach ($data as $val) {
                    $params = array(
                        $userId,
                        $menu_id,
                        $val->id,
                        $val->size_x,
                        $val->size_y,
                        $val->row,
                        $val->col                    
                    );
                    if ($result) $result = $ObjHome->saveUserWidget($params);
                echo '<pre>'; print_r($ObjHome->GetLastError()); echo '</pre>';
                    
                }
            }
            $ObjHome->EndTrans($result);
            echo '<pre>'; print_r($ObjHome->GetLastError()); echo '</pre>';
        }
      	//return array('exec'=>"console.log('saved')");
        return NULL;
   	}
}
?>