<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
require_once('./model/database.php');
require_once('./model/utils.php');
if($_SESSION['done']==1){
    $_SESSION['done']=0;
    exit();
}
$page=$_GET['page']-1;
if(!isset($_SESSION['kind'])){
    $_SESSION['kind']="all";
}
if(!isset($_SESSION['mode'])){
    $_SESSION['mode']="hot";
}
if($_SESSION['mode']=="hot"){
    $popular="/popular";
}
else{
    $popular="";
}
if($_SESSION['kind']=="sex"&&!isset($_SESSION['sex'])){
    echo '
<div class="element">
<pre>
看板部分內容需滿18歲方可瀏覽。(*´艸`*)

根據「電腦網路內容分級辦法」規定，若您尚未年滿18歲，請點選離開。(つд⊂)

若您已滿18歲，亦不可將本區之內容派發、傳閱、出售、出租、交給或借予年齡未滿18歲的人士瀏覽，或將本板內容向該人士出示、播放或放映。
</pre>
';
    echo '
<button class="btn btn-danger" onclick="kind(\'all\')"">不同意本條款或未滿18歲</button>
<button class="btn btn-primary" onclick="kind(\'setsex\')">我同意且年滿18歲</button>
</div>
';
    $_SESSION['done']=1;
exit();
}
$url  = "https://www.dcard.tw/api/forum/".$_SESSION['kind']."/".$page.$popular;
if(ok($url)){
    $file = file_get_contents($url);
    $json = json_decode($file);
    $onece=0;
    foreach($json as $j){
        if($onece==0){
            echo'<div class="element" style="display:none;"></div>';
            $onece++;
        }
        $sql="SELECT * FROM cache WHERE did=".$j->id." LIMIT 1";
        $rs = $db->query($sql);
        $row= $rs->fetch();
        $img=false;
        if($row['did']){
            $img=$row['img'];
            $imgurl=$row['imgurl'];
            $title=$row['title'];
            $did=$row['did'];
        }
        else{
            $url  = "https://www.dcard.tw/api/post/all/".$j->id;
            if(ok($url)){
                $file = file_get_contents($url);
                $json = json_decode($file);
                $content=$json->version[0]->content;
                $a=strpos($content,"imgur.com");
                $img=true;
                if($content[$a-1]=="."){
                    if($content[$a+18]==".")
                        $imgurl=substr($content,$a+10,11);
                    else
                        $imgurl=substr($content,$a+10,12);
                }
                else{
                    if(!isset($content[$a+18])&&$content[$a+18]!=" "&&$content[$a+18]!="\\")
                        $imgurl=substr($content,$a+10,8).".jpg";
                    else
                        $imgurl=substr($content,$a+10,7).".jpg";
                }
                if(!$a||$json->pinned==true){
                    $img=false;
                    $imgurl="";
                }
                $title=base64_encode($json->version[0]->title);
                $did=$json->id;
                $sql = "INSERT INTO cache (did , title, imgurl, img) VALUES ('{$did}', '{$title}', '{$imgurl}', '{$img}')";
                $rs = $db->prepare($sql);
                $rs->execute();
            }
        }
        if($img)
            echo '
            <div class="item element">
            <a href="https://www.dcard.tw/f/all/p/'.$did.'" target="blank">
            <img src="http://i.imgur.com/'.$imgurl.'" width="100%" alt="'.$j->version[0]->title.'">
            <p class="ep_like glyphicon glyphicon-heart">'.$j->likeCount.'</p>
            <div class="ep_box">
            <p class="ep_info">'.$j->version[0]->title.'</p>
            </div>
            </div>
            </a>';
    }
}
else{
    echo'<div class="element">Dcard好像連不太上...請稍候再試</div>';
}
?>
