<head>
    <title>
        编辑
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

    </style>
</head>
<!--Head End-->

<body>
    <main>

        <?php session_start();
        if (!isset($_SESSION['userid'])) {
            header('location:index.php');
            exit('未登录！将跳转首页登录');
        }
        ?>

        <div class="demos-content-padded">
            <?php if ($_GET['action'] == "new"):
            ?>
            <script>
                <?php echo 'document.title = "编辑"+"【新建】";var action="new",cid="";';
                ?> console.log("新建");
            </script>
            <div class="weui-cells__title">
                编辑说说
            </div>
            <div class="weui-cells weui-cells_form">
                <div class="weui-cell">
                    <div class="weui-cell__bd">
                        <textarea onKeyUp="cal_words()" class="weui-textarea" placeholder="请输入文本" rows="3" id="text"><?php echo $data['text'];
                            ?></textarea>
                        <div class="weui-textarea-counter">
                            <span id="cal_words"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="weui-cell weui-cell_select weui-cell_select-after">
                <div class="weui-cell__hd">
                    <label for="" class="weui-label">状态</label>
                </div>
                <div class="weui-cell__bd">
                    <select class="weui-select" name="status" id="status" >
                        <option value="publish" selected="selected">公开</option>
                        <option value="hidden">隐藏</option>
                    </select>
                </div>
            </div>

            <!--图片上传-->
            <div class="weui-gallery" id="gallery">
                <span class="weui-gallery__img" id="galleryImg"></span>
                <div class="weui-gallery__opr">
                    <a href="javascript:" class="weui-gallery__del">
                        <i class="weui-icon-delete weui-icon_gallery-delete"></i>
                    </a>
                </div>
            </div>
            <div class="weui-cells weui-cells_form">
                <div class="weui-cell">
                    <div class="weui-cell__bd">
                        <div class="weui-uploader">
                            <div class="weui-uploader__bd">
                                <ul class="weui-uploader__files" id="uploaderFiles">

                                </ul>
                                <div class="weui-uploader__input-box">
                                    <form id="upload_form" enctype="multipart/form-data">
                                        <input id="uploaderInput" class="weui-uploader__input zjxfjs_file" type="file" name="file" accept="image/*" multiple="">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <a href="javascript:;" class="weui-btn weui-btn_primary" id="submit">发布</a>
            <?php endif;
            ?>

            <?php if ($_GET['action'] == "edit"):
            include('conn.php');
            $sql_cmd_edit = "SELECT * FROM typecho_ss WHERE cid=".$_GET['cid'];
            $req = mysqli_query($conn,$sql_cmd_edit);
            $data = mysqli_fetch_array($req);
            ?>
            <script>
                <?php echo 'document.title = "编辑"+"【'.$data['title'].'】";var action="edit",cid='.$_GET['cid'].';';
                ?> console.log("修改");
            </script>
            <div class="weui-cells__title">
                编辑说说
            </div>
            <div class="weui-cells weui-cells_form">
                <div class="weui-cell">
                    <div class="weui-cell__bd">
                        <textarea onKeyUp="cal_words()" class="weui-textarea" placeholder="请输入文本" rows="3" id="text"><?php echo $data['text'];
                            ?></textarea>
                        <div class="weui-textarea-counter">
                            <span id="cal_words"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="weui-cell weui-cell_select weui-cell_select-after">
                <div class="weui-cell__hd">
                    <label for="" class="weui-label">状态</label>
                </div>
                <div class="weui-cell__bd">
                    <select class="weui-select" name="status" id="status" >
                        <option value="publish">公开</option>
                        <option value="hidden" <?php if($data['status']=='hidden'){echo 'selected="selected"';}?>>隐藏</option>
                    </select>
                </div>
            </div>
            
            <!--图片上传-->
            <div class="weui-gallery" id="gallery">
                <span class="weui-gallery__img" id="galleryImg"></span>
                <div class="weui-gallery__opr">
                    <a href="javascript:" class="weui-gallery__del">
                        <i class="weui-icon-delete weui-icon_gallery-delete"></i>
                    </a>
                </div>
            </div>
            <div class="weui-cells weui-cells_form">
                <div class="weui-cell">
                    <div class="weui-cell__bd">
                        <div class="weui-uploader">
                            <div class="weui-uploader__bd">
                                <ul class="weui-uploader__files" id="uploaderFiles">

                                </ul>
                                <div class="weui-uploader__input-box">
                                    <form id="upload_form" enctype="multipart/form-data">
                                        <input id="uploaderInput" class="weui-uploader__input zjxfjs_file" name="file" type="file" accept="image/*" multiple="">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <a href="javascript:;" class="weui-btn weui-btn_primary" id="submit">保存</a>
            <?php endif;
            ?>

        </div>
    </main>
    <footer class="weui-footer weui-footer_fixed-bottom">
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
    <script src="https://cdn.bootcss.com/mui/3.7.1/js/mui.min.js"></script>
    <!-- 如果使用了某些拓展插件还需要额外的JS -->
    <script src="https://cdn.bootcss.com/jquery-weui/1.2.1/js/swiper.min.js"></script>
    <script>
        var postdata = {
            "action": "",
            "cid": "",
            "title": "",
            "text": "",
            "img": [],
            "authorId": "",
            "status": ""
        };

        //字数统计
        function cal_words() {
            var length = document.getElementById("text").value.length;
            document.getElementById("cal_words").innerHTML = length;
        }
        //剪切省略号
        function cutString(str, len) {
            //length属性读出来的汉字长度为1
            if (str.length * 2 <= len) {
                return str;
            }
            var strlen = 0;
            var s = "";
            for (var i = 0; i < str.length; i++) {
                s = s + str.charAt(i);
                if (str.charCodeAt(i) > 128) {
                    strlen = strlen + 2;
                    if (strlen >= len) {
                        return s.substring(0, s.length - 1) + "...";
                    }
                } else {
                    strlen = strlen + 1;
                    if (strlen >= len) {
                        return s.substring(0, s.length - 2) + "...";
                    }
                }
            }
            return s;
        }

        //上传图片
        function upload() {
            var form = new FormData(document.getElementById("upload_form"));
            console.log(form);
            $.ajax({
                url: "upload.php",
                type: "post",
                data: form,
                processData: false,
                contentType: false,
                success: function(result) {
                    $.toast(result.msg, "text");
                    console.log("上传成功提示");
                    console.log(result);
                    postdata.img.push(result.img);
                },
                error: function(result){
                    $.toast(result.msg, "text");
                    console.log("上传失败提示");
                    console.log(result.msg);
                }
            })
        }
        mui.init();
        $(function() {
            var tmpl = '<li class="weui-uploader__file" style="background-image:url(#url#)"></li>',
            $gallery = $("#gallery"),
            $galleryImg = $("#galleryImg"),
            $uploaderInput = $("#uploaderInput"),
            $uploaderFiles = $("#uploaderFiles");
                
            <?php if($_GET['action']=='edit' && !empty($data['img'])):?>
                //获取数据库已保存的图片信息
                postdata.img = <?php echo $data['img'];?>;
                for(var n=0;n<postdata.img.length;n++){
                    $uploaderFiles.append($(tmpl.replace('#url#',postdata.img[n])));
                }
            <?php endif;?>
                
            $uploaderInput.on("change", function(e) {
                upload();
                var src, url = window.URL || window.webkitURL || window.mozURL,
                files = e.target.files; 
                for (var i = 0, len = files.length; i < len; ++i) {
                    var file = files[i];
                    if (url) {
                        src = url.createObjectURL(file);
                    } else {
                        src = e.target.result;
                    }
                    $uploaderFiles.append($(tmpl.replace('#url#', src)));
                }

            });
            var index; //第几张图片
            $uploaderFiles.on("click", "li", function() {
                index = $(this).index();
                $galleryImg.attr("style", this.getAttribute("style"));
                $gallery.fadeIn(100);
            });
            $gallery.on("click", function() {
                $gallery.fadeOut(100);
            });
            //删除图片
            $(".weui-gallery__del").click(function() {
                $uploaderFiles.find("li").eq(index).remove();
                postdata.img.splice(index,1);
            });
        });

        $(document).on("click", "#menu", function() {
            $(location).attr("href", "post.php");
        });

        $(document).on("click", "#submit", function() {
            postdata.action = action;
            postdata.cid = cid;
            postdata.title = cutString($("#text").val(), 20);
            postdata.text = $("#text").val();
            postdata.authorId = "1";
            postdata.status=$("#status option:selected").val();
            //发送数据
            $.ajax({
                url: "curd.php",
                type: "post",
                data: JSON.stringify(postdata),
                contentType: "application/json",
                dataType: "json",
                success: function (result) {
                    console.log("edit ajax success!");
                    console.log(result);
                    $.toast(result.msg, "text");
                    if (result.code == 0) {
                        $(location).attr("href", "post.php");
                    }
                },
                error: function (res) {
                    $.toast("发布失败！", "text");
                    console.log("Error!");
                    console.log(res);
                }
            })
        });
    </script>
</body>