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
<video muted loop autoplay id="bg" src="<?php echo $config['admin']['bg_url'];?>" ></video>
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
                                        <img class="list-img" style="height: 80px;" src="<?php echo $img_urls[$i] ?>">
                            <?php   endfor;
                            endif;
                            ?> 
						</p>
					</div>
					<p class="time"><?php echo date("Y-m-d H:m:s",$data['created']);?></p><!--<img class="c-icon" src="c.png">-->
				</div>
				<div class="r"></div>
			</div>
		</li>


<?php endwhile;

?>
</ul>
<p style="text-align:center;">
    到底了 
</p>
</div></div>
<pre>
    <?php mysqli_close($conn);?>
    </pre>
<script>
var img_array = $(".list-img");
$(function(){
    loadfancybox();
    $(".post p img").width("80");
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