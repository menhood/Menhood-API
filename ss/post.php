<?php
session_start();
include('conn.php');
if (isset($_SESSION['userid']) && $_SERVER['REQUEST_METHOD'] == 'GET'):

// 获取select结果集的行数 判断是否跳转
$install = mysqli_query($conn,"select * from `typecho_ss` where `cid`=2;");
if (mysqli_num_rows($install) < 1) {
    header("location:curd.php?install");
    exit();
}

//判断页面是否是提交状态
if (isset($_GET['page']) && $_GET['page'] > 1) {
    $page_now_num = $_GET['page'];
} else {
    $page_now_num = 1;
}
$url = $_SERVER['REQUEST_URI'];
$url = parse_url($url);
$url = $url['path'];
$_GET['pagesize']?$pageSize = $_GET['pagesize']:$pageSize = 5;
//计算起始位置
$page = ($page_now_num-1)*$pageSize;

//默认每页说说数量
$res = mysqli_query($conn,"SELECT * FROM typecho_ss WHERE status='publish' or status is null ");
$num = mysqli_num_rows($res);
$page_sum = ceil($num/$pageSize);

if ($_GET['recycle'] == 'true') {
    $recycle = "true";
    $sql_cmd_read_post = "select * from typecho_ss WHERE status='hidden';";
} else {
    $recycle = "";
    $sql_cmd_read_post = "SELECT * FROM typecho_ss WHERE status='publish' or status is null limit $page,$pageSize";
}
//去数据库取数据
$res = mysqli_query($conn,$sql_cmd_read_post);

//计算页面
$prevpage = $page_now_num > 1 ? "?page=".($page_now_num-1) : '?page=1';
$nextpage = ($page_now_num + 1) > $num ? '?page='.$num : '?page='.($page_now_num + 1);
?>
<head>
    <title>
        ss-Menhood
    </title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="description" content="ss-Menhood，简易说说系统">
    <!--WEUI引入-->
    <link rel="stylesheet" href="https://cdn.bootcss.com/weui/1.1.3/style/weui.min.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/jquery-weui/1.2.1/css/jquery-weui.min.css">
    <style>
        body, html {
            height: 100%;
            -webkit-tap-highlight-color: transparent;
        }
        .center {
            text-align: center;
        }
        .demos-title {
            text-align: center;
            font-size: 34px;
            color: #3cc51f;
            font-weight: 400;
            margin: 0 15%;
        }

        .demos-sub-title {
            text-align: center;
            color: #888;
            font-size: 14px;
        }

        .demos-header {
            padding: 35px 0;
            margin-top: 35px;
        }

        .demos-content-padded {
            padding: 15px;
        }

        .demos-second-title {
            text-align: center;
            font-size: 24px;
            color: #3cc51f;
            font-weight: 400;
            margin: 0 15%;
        }

        footer {
            text-align: center;
            font-size: 14px;
            padding: 20px;
        }

        footer a {
            color: #999;
            text-decoration: none;
        }

        input::-ms-input-placeholder {
            text-align: center;
        }

        input::-webkit-input-placeholder {
            text-align: center;
        }
    </style>
</head>
<!--Head End-->
<body>
    <main>
        <script>
            document.title = "说说"; console.log("已登录"); <?php echo "var recycle=\"".$recycle."\";";
            ?>
        </script>
        <div class="demos-content-padded">
            <div class="weui-flex">
                <div class="weui-flex__item">
                    <div class="placeholder">
                        <div class="weui-cells__title center" id="ss_list">
                            说说列表
                        </div>
                    </div>
                </div>
            </div>

            <div class="weui-flex">
                <div class="weui-flex__item">
                    <a href="edit.php?action=new" class="weui-btn weui-btn_primary" id="New">新建</a>
                </div>
            </div>

            <?php if ($res):
            while (($row = mysqli_fetch_assoc($res))):
            ?>
            <div class="weui-panel__bd" id="cid_<?php echo $row['cid'];
                ?>" onclick="edit(<?php echo $row['cid'];
                ?>)" <?php if ($row['cid'] == 2) { echo 'style="display:none;"';
                }
                ?>>
                <div class="weui-media-box weui-media-box_text">
                    <h4 class="weui-media-box__title"><?php echo $row['title'];
                        ?></h4>
                    <p class="weui-media-box__desc">
                        <?php echo $row['text'];
                        ?>
                        <?php if (!empty($row['img'])):
                        $img_urls = json_decode($row['img']);
                        for ($i = 0;$i < count($img_urls); $i++):
                        ?>
                        <img class="weui-media-box__thumb" src="<?php echo $img_urls[$i] ?>">
                        <?php endfor;
                        endif;
                        ?>

                    </p>
                    <ul class="weui-media-box__info">
                        <li class="weui-media-box__info__meta">创建时间：<?php echo date("Y-m-d H:m:s",$row['created']);
                            ?></li>
                        <li class="weui-media-box__info__meta ">修改时间：<?php echo date("Y-m-d H:m:s",$row['modified']);//echo $row['authorid'];
                            ?></li>
                    </ul>
                </div>
            </div>
            <?php
            endwhile;
            endif;
            ?>
            <br>
            <div class="weui-flex">
                <div class="weui-flex__item">
                    <a href="<?php echo $prevpage.'"';
                        if ($page_now_num == 1) { echo  ' style="display:none;" ';
                        }
                        ?>  class="weui-btn weui-btn_mini weui-btn_primary" id="Prevpage">上一页</a>
                        </div>
                        <div class="weui-flex__item">
                        <input id="page_num" class="weui-input" type="number" pattern="[0-9]*" placeholder="<?php echo $page_now_num."/".$page_sum;
                        ?>">
                        </div>
                        <div class="weui-flex__item">
                        <button class="weui-btn weui-btn_mini weui-btn_default" id="jump_btn" >跳转</button>
                        </div>
                        <div class="weui-flex__item">
                        <a href="<?php echo $nextpage.'"';
                        if ($page_now_num == $page_sum) { echo  ' style="display:none;" ';
                        }
                        ?> class="weui-btn weui-btn_mini weui-btn_primary" id="Nextpage">下一页</a>
                </div>
            </div>
        </div>
    </main>

    <footer class="weui-footer">
        <p class="weui-footer__links">
            <i class="weui-icon-info-circle" id="menu"></i>
        </p>
        <p class="weui-footer__text">
            Copyright ©
            <?php echo date('Y');
            ?> ss-Menhood
        </p>
    </footer>

    <!-- 引入JQ WEUI -->
    <script src="https://cdn.bootcss.com/jquery/1.11.0/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/jquery-weui/1.2.1/js/jquery-weui.min.js"></script>
    <!-- 如果使用了某些拓展插件还需要额外的JS -->
    <script src="https://cdn.bootcss.com/jquery-weui/1.2.1/js/swiper.min.js"></script>
    <script src="https://cdn.bootcss.com/jquery-weui/1.2.1/js/city-picker.min.js"></script>
    <script>
        $(document).on("click", "#menu", function() {
            var confirm_title, confirm_URL;
            if (recycle) {
                confirm_title = "文章页";
                confirm_URL = "post.php";
            } else {
                confirm_title = "回收站";
                confirm_URL = "post.php?recycle=true";
            }
            $.actions({
                title: "操作",
                onClose: function() {
                    console.log("close");
                },
                actions: [{
                    text: "登出",
                    className: 'color-danger',
                    onClick: function() {
                        $.confirm({
                            title: '登出',
                            text: '确认要注销吗？',
                            onOK: function () {
                                //点击确认
                                $.ajax({
                                    url: "login.php",
                                    type: "get",
                                    data: {
                                        "action": "logout"
                                    },
                                    dataType: "json",
                                    success: function (result) {
                                        console.log("success!");
                                        console.log(result);
                                        $.toast(result.msg, "text");
                                        if (result.code == 0) {
                                            $.showLoading();
                                            $(location).attr("href", "index.php");
                                            //   $("main").html(result.data);
                                            // $(location).attr("href","post.php");
                                        }
                                    },
                                    error: function (res) {
                                        $.toast(res.msg, "text");
                                        console.log("Error!");
                                        console.log(res);
                                    }
                                });
                            },
                            onCancel: function () {}
                        });
                    }
                }, {
                    text: confirm_title,
                    className: 'color-warning',
                    onClick: function() {
                        //跳转回收站页面
                        $(location).attr("href", confirm_URL);
                    }
                }]
            });
        });

        $(document).on("click", "#ss_list", function() {
            $(location).attr("href", "post.php");
        });

        function edit(cid) {
            var confirm_title, confirm_text, confirm_action, resume;
            if (recycle) {
                confirm_title = "彻底删除";
                confirm_text = "确认要彻底删除吗？";
                confirm_action = "del_recycle";
                // resume = ',{text: "恢复",className: "color-primary",onClick: function() {//恢复$.ajax({url: "curd.php",type: "post",data: {"action": "resume","cid": cid},dataType: "json",success: function (result) {console.log("删除ajax success!");console.log(result);$.toast(result.msg, "text");if (result.code == 0) {$("#cid_"+cid).remove();}},error: function (res) {$.toast("删除失败", "text");console.log("Error!");console.log(res);}});}}';
            } else {
                confirm_title = "删除";
                confirm_text = "确认要删除吗？";
                confirm_action = "del";
                resume = '';
            }
            $.actions({
                title: "操作",
                onClose: function() {
                    console.log("编辑actions_onclose");
                },
                actions: [{
                    text: "编辑说说",
                    className: 'color-primary',
                    onClick: function() {
                        //跳转编辑页面
                        $(location).attr("href", "edit.php?action=edit&cid="+cid);
                    }
                }, {
                    text: confirm_title,
                    className: 'color-danger',
                    onClick: function() {
                        $.confirm({
                            title: confirm_title,
                            text: confirm_text,
                            onOK: function () {
                                //点击确认删除
                                $.ajax({
                                    url: "curd.php",
                                    type: "post",
                                    data: {
                                        "action": confirm_action,
                                        "cid": cid
                                    },
                                    contentType: "application/json",
                                    dataType: "json",
                                    success: function (result) {
                                        console.log("删除ajax success!");
                                        console.log(result);
                                        $.toast(result.msg, "text");
                                        if (result.code == 0) {
                                            //$("#cid_"+cid).remove();
                                            // $.showLoading();
                                            location.reload();
                                            //   $("main").html(result.data);
                                            // $(location).attr("href","post.php");
                                        }
                                    },
                                    error: function (res) {
                                        $.toast("删除失败", "text");
                                        console.log("Error!");
                                        console.log(res);
                                    }
                                });
                            }
                        });
                    }
                }]
            });
        };

        $(document).on("click", "#jump_btn", function() {
            $(location).attr("href", "?page="+$("#page_num").val());
        })
    </script>
</body>

<?php elseif($_GET['type']=='json') :
header('Content-type: application/json');
$sql_cmd_r = "SELECT * FROM typecho_ss WHERE status='publish' or status is null";
$req = mysqli_query($conn,$sql_cmd_r);
$data_array = [];
while ($data = mysqli_fetch_assoc($req)) {
    array_push($data_array,$data);
}
echo json_encode($data_array,JSON_UNESCAPED_UNICODE);
?>
<?php else:
$sql_cmd_r = "SELECT * FROM typecho_ss WHERE status='publish' or status is null";
$req = mysqli_query($conn,$sql_cmd_r);
$data_array = [];
while ($data = mysqli_fetch_assoc($req)):
?>
<ul>
    <li>
        <?php echo $data['text'];
        if(!empty($data['img'])):
            $img_urls = json_decode($data['img']);
                for ($i = 0;$i < count($img_urls); $i++):
        ?>
                    <img src="<?php echo $img_urls[$i] ?>">
        <?php   endfor;
        endif;
        ?>            
    </li>
</ul>
<?php endwhile;endif;
mysqli_close($conn);
?>