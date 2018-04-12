<?php
/**
 * @author Prima Noor 
 */
   
class ViewApplicationPackager extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_application_packager.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $msg = Messenger::Instance()->Receive(__FILE__);
		$message['content'] = isset($msg[0][1])?$msg[0][1]:NULL;
		$message['style'] = isset($msg[0][2])?$msg[0][2]:NULL;
        
   	    $ObjMenu = Dispatcher::Instance()->load->business('CoreMenu', 'core.menu');
                
        $menuList = $ObjMenu->getMenuList();
        
        if (!empty($menuList)) {
            $list = array();
            foreach ($menuList as $val) {
                $list[] = array(
                    'id'    => $val['id'],
                    'parent_id' => $val['parent_id'],
                    'title' => $val['name'],
                    'position' => $val['order']                    
                );  
            }
        }
        $menu = $this->getMenu($list, 0);
        
      	return compact('menu', 'message');
   	}
   
   	function ParseTemplate($rdata = NULL)
   	{
   	    if (is_array($rdata))
            extract($rdata);
            
        if (!empty($message)) {
            $this->mrTemplate->addVars('message', $message);
        }
            
        if (!empty($menu)) {
            $this->mrTemplate->addVar('content', 'menu', $menu);
        }
        
        $this->mrTemplate->addVar('content', 'action', Dispatcher::Instance()->GetUrl(Dispatcher::Instance()->mModule, 'applicationPackager', 'do', 'json'));
   	}

    /**
     * generate block ul menu
     * @param array $items(id, parent_id, title, link, position)
     * 
     **/
    function getMenu($items, $root_id = 0)
    {
        $this->html = array();
        $this->items = $items;

        foreach ($this->items as $item)
            $children[$item['parent_id']][] = $item;

        // loop will be false if the root has no children (i.e., an empty menu!)
        $loop = !empty($children[$root_id]);

        // initializing $parent as the root
        $parent = $root_id;
        $parent_stack = array();

        // HTML wrapper for the menu (open)
        $this->html[] = '<ul>';
        
        $actionLabel = GtfwLangText('action');

        while ($loop && (($option = each($children[$parent])) || ($parent > $root_id))) {
            if ($option === false) {
                $parent = array_pop($parent_stack);

                // HTML for menu item containing childrens (close)
                $this->html[] = str_repeat("\t", (count($parent_stack) + 1) * 2) . '</ul>';
                $this->html[] = str_repeat("\t", (count($parent_stack) + 1) * 2 - 1) . '</li>';
            } elseif (!empty($children[$option['value']['id']])) {
                $tab = str_repeat("\t", (count($parent_stack) + 1) * 2 - 1);

                // HTML for menu item containing childrens (open)
                $this->html[] = $tab
                                .'<li id="'.$option['value']['id'].'" class="">'
                                .'<a>'
                                .$option['value']['title']
                                .'</a>';
                $this->html[] = $tab . "\t" . '<ul class="sub">';

                array_push($parent_stack, $option['value']['parent_id']);
                $parent = $option['value']['id'];
            } else {// HTML for menu item with no children (aka "leaf")
                $tab = str_repeat("\t", (count($parent_stack) + 1) * 2 - 1);
                $this->html[] = $tab
                                .'<li id="'.$option['value']['id'].'">'
                                .'<a data-menuid="'.$option['value']['id'].'">'
                                .$option['value']['title'].(!empty($label)?' ('.implode(', ', $label).')':'')
                                .'</a>'
                                .'</li>';
            }
        }

        // HTML wrapper for the menu (close)
        $this->html[] = '</ul>';

        return implode("\r\n", $this->html);
    }
}
?>