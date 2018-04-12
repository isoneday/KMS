<?php

class DoLogout extends HtmlResponse
{
    function ProcessRequest()
    {
        Security::Instance()->Logout(true);
        
        $cookie = $_COOKIE;
        foreach ($cookie as $k => $v) {
            if (is_array($cookie[$k])) {
                foreach ($cookie as $key => $val) {
                    setcookie($k.'['.$key.']','',time(+3600*24*(-100)));
                }
            }
            setcookie($k,'',time(+3600*24*(-100)));
        }
     
     echo "<script>";
      echo "document.location.href='http://localhost/gtkms/index.php?mod=core.login&sub=login&act=view&typ=html'";
echo "</script>";
   
//        $login = GtfwCfg('application', 'login_page');
    //    $this->RedirectTo(Dispatcher::Instance()->GetUrl($login['mod'], $login['sub'], $login['act'], $login['typ']));
    }
}

?>
