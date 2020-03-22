<?php 
    $pyq_config=array(
        "user"=>"援军",
        "mail"=>"menhood@menhood.wang",
        "ss_table"=>"typecho_ss"
    )
?>
<link rel="stylesheet" href="app.css">
<header>
<img id="bg" src="bg.jpg">
<p id="user-name" class="data-name"><?php echo $pyq_config['user'];?></p>
<img id="avt" class="data-avt" src="<?php echo "https://dn-qiniu-avatar.qbox.me/avatar/".md5($pyq_config['mail']);?>">
</header>
<div id="main">
    <div id="list">
        <ul>
<?php
include('../conn.php');
$sql_cmd_r = "SELECT * FROM ".$pyq_config['ss_table']." WHERE status='publish' or status is null";
$req = mysqli_query($conn,$sql_cmd_r);
$data_array = [];
while ($data = mysqli_fetch_assoc($req)):
?>

    
    <li>
			<div class="po-avt-wrap">
				<img class="po-avt data-avt" src="<?php echo "https://dn-qiniu-avatar.qbox.me/avatar/".md5($pyq_config['mail']);?>">
			</div>
			<div class="po-cmt">
				<div class="po-hd">
					<p class="po-name"><span class="data-name"><?php echo $pyq_config['user'];?></span></p>
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
					<p class="time"><?php echo date("Y-m-d H:m:s",$data['created']);?></p><img class="c-icon" src="c.png">
				</div>
				<div class="r"></div>
				<div class="cmt-wrap">
					<div class="like"><img src="l.png">甲，乙，丙，丁...</div>
					<div class="cmt-list">
						<p><span>甲：</span>M～</p>
						<p><span>乙：</span>我们在国内冻成狗～</p>
						<p><span>丙：</span>NB～</p>
						<p><span>丁：</span>？那么爽</p>
						<p>
							<span class="data-name"><?php echo $pyq_config['user'];?></span>
							回复
									<span>
										丁
									</span>
									<span>
										：
									</span>
							！
						</p>
						<p><span>？：</span>😘！？</p>
					</div>
				</div>
			</div>
		</li>


<?php endwhile;
mysqli_close($conn);
?>
</ul>
</div></div>