<?php 
ini_set("display_errors", "Off");

include('../conn.php');
$sql_cmd_r = "SELECT * FROM `typecho_ss` WHERE status='publish' or status is null order by cid desc";
$req = mysqli_query($conn,$sql_cmd_r);
$users_info=[];
foreach($config as $config_v){
    array_push($users_info,array('mail'=>$config_v['mail'],'name'=>$config_v['name']));
};
$data_array = [];    
?>
<link rel="stylesheet" href="app.css">
<script src="https://blog.menhood.wang/usr/themes/Bilispace/static/jquery.min.js"></script> 
<script src="https://blog.menhood.wang/usr/themes/Bilispace/static/jquery.lazyload.min.js"></script>
<link rel="stylesheet" href="https://blog.menhood.wang/usr/themes/Bilispace/static/jquery.fancybox.min.css">
<script src="https://blog.menhood.wang/usr/themes/Bilispace/static/jquery.fancybox.min.js"></script>
<header>
<!--<img id="bg" src="bg.jpg">-->
<video muted loop autoplay id="bg" src="bg.mp4" ></video>
<p id="user-name" class="data-name"><?php echo $config['admin']['name'];?></p>
<img id="avt" class="data-avt" src="<?php echo "https://dn-qiniu-avatar.qbox.me/avatar/".md5($config['admin']['mail']);?>">
</header>
<div id="main">
    <div id="list">
        <ul>
<?php

while ($data = mysqli_fetch_assoc($req)):
    if(empty($data['authorId'])){$user_id='0';}else{$user_id=$data['authorId']-1;};
?>

    
    <li>
			<div class="po-avt-wrap">
				<img class="po-avt data-avt" src="<?php echo "https://cdn.v2ex.com/gravatar/".md5($users_info[$user_id]['mail']);?>">
			</div>
			<div class="po-cmt">
				<div class="po-hd">
					<p class="po-name"><span class="data-name"><?php echo $users_info[$user_id]['name'];?></span></p>
					<div class="post">
						<p><?php echo $data['text'];?></p>
						<p>
						    <?php if(!empty($data['img'])):
                                $img_urls = json_decode($data['img']);
                                    for ($i = 0;$i < count($img_urls); $i++):
                            ?>
                                        <img class="list-img" style="height: 80px;" src="<?php echo "../".$img_urls[$i] ?>">
                            <?php   endfor;
                            endif;
                            ?> 
						</p>
					</div>
					<p class="time"><?php echo date("Y-m-d H:m:s",$data['created']);?></p><!--<img class="c-icon" src="c.png">-->
				</div>
				<div class="r"></div>
				<div class="cmt-wrap">
					<!--<div class="like"><img src="l.png">甲，乙，丙，丁...</div>-->
					<!--<div class="cmt-list">-->
					<!--	<p><span>wu勋-EXO：</span>나는 서명～</p>-->
					<!--	<p><span>鹿晗：</span>我们在国内冻成狗，我也想跟哥您去热热～</p>-->
					<!--	<p><span>权龙：</span>나는 서명～</p>-->
					<!--	<p><span>王聪：</span>去哪玩啊？那么爽</p>-->
					<!--	<p>-->
					<!--		<span class="data-name"><?php echo $pyq_config[$user_id]['user'];?></span>-->
					<!--		回复-->
					<!--				<span>-->
					<!--					王聪-->
					<!--				</span>-->
					<!--				<span>-->
					<!--					：-->
					<!--				</span>-->
					<!--		。-->
					<!--	</p>-->
					<!--	<p><span>杨：</span>😘私人飞机出行，求带上我～</p>-->
					<!--</div>-->
				</div>
			</div>
		</li>


<?php endwhile;

?>
</ul>
</div></div>
<pre>
    <?php mysqli_close($conn);?>
    </pre>
<script>
var img_array = $(".list-img");
$(function(){
    loadfancybox();
})
function loadfancybox(){
for (i = 0; i < img_array.length; i++) {
    var imgs = img_array;
    imgs[i].outerHTML = '<a href="' + imgs[i].src + ' "data-fancybox="images" data-caption="' + imgs[i].alt + '" >' + '<div class="post-img"><img data-original="' + imgs[i].src + '" src="https://i.loli.net/2018/10/30/5bd8193caea80.gif" class="lazyload" alt="' + imgs[i].alt + '" title="' + imgs[i].title + '"></div>' + '<\/a>';
};
$('[data-fancybox="images"]').fancybox({
    'transitionIn': 'elastic', 
    'transitionOut': 'elastic'
});
$("img.lazyload").lazyload({
    effect: 'fadeIn',
    threshold: 180
});    
}
</script>