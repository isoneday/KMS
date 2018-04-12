<?php

class DoLogin extends HtmlResponse
{
    function ProcessRequest()
    {
        $login = GtfwCfg('application', 'login_page');
        $urlLogin = Dispatcher::Instance()->GetUrl($login['mod'], $login['sub'], $login['act'], $login['typ']);
        $urlLogin1 = Dispatcher::Instance()->GetUrl($login['mod'], $login['sub'], $login['act'], $login['typ']);
      
        $home = GtfwCfg('application', 'default_page');
        $urlHome = Dispatcher::Instance()->GetUrl($home['mod'], $home['sub'], $home['act'], $home['typ']);
     //    $Val->set_rules('username', GtfwLangText('username'), 'required');
        if (empty($_SESSION['back_to']))
        {
            $urlBack = (string) $_REQUEST['back_to'];
            $tmp1 = parse_url($urlBack);
            $tmp2 = parse_url($urlLogin);
            
            if ($tmp1['query'] != $tmp2['query'])
                $_SESSION['back_to'] = $urlBack;
            else $_SESSION['back_to'] = $urlHome;
        }
        //$_SESSION['back_to'];exit;
		$username = $_REQUEST['username']->SqlString()->Raw();
		$hashed = $_REQUEST['hashed']->Integer()->Raw();
		$password_hashed = $_REQUEST['password_hashed']->SqlString()->Raw();
		$password = $_REQUEST['password']->SqlString()->Raw();
        //if (Security::Instance()->Login($_REQUEST['username'] . '', ($_REQUEST['hashed'] === 1)?$_REQUEST['password_hashed']:$_REQUEST['password'] . '', $_REQUEST['hashed'] . '' == 1)) {
		if (Security::Instance()->Login($username . '', ($hashed === 1)?$password_hashed:$password . '', $hashed . '' == 1)) {
            
            $myDomain = preg_replace('/^[^\.]*\.([^\.]*)\.(.*)$/', '/\1.\2/', $_SERVER['HTTP_HOST']);
            $setDomain = ($_SERVER['HTTP_HOST']) != "localhost" ? ".$myDomain" : false;
            
            setcookie("language", Security::Instance()->mAuthentication->GetCurrentUser()->mLangCode, time() + 3600 * 24 * (2), '/', "$setDomain", 0);
            # redirect to proper place
            $url = $_SESSION['back_to'];

            unset($_SESSION['back_to']);
            echo "<script>alert('login successfully!!','.success');";
      echo "document.location.href='http://localhost/gtkms/bo/index.php?mod=core.home&sub=landingPage&act=view&typ=html'";
            echo "</script>";
            
         //   $this->RedirectTo($url);
        } else {

          $msg = GtfwLangText('msg_delete_fail');
            $css = $this->cssFail;
        
        Messenger::Instance()->Send('core.login', 'login', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
  //      return $urlLogin;
echo "<script>alert('invalid username or password!!');";
      echo "document.location.href='http://localhost/gtkms/bo/index.php?mod=core.login&sub=login&act=view&typ=html'";
echo "</script>";

//echo $location.href="http://localhost/gtkms/index.php?mod=core.login&sub=login&act=view&typ=html";
     // window.open("http://localhost/gtkms/index.php?mod=core.login&sub=login&act=view&typ=html","_self");
    //   echo "login gagal"
 
        }
        return null;
    }

}

?>
