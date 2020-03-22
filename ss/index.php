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

    </style>
</head>
<!--Head End-->

<body>
    <main>
        <?php
        session_start();
        // 检测是否登录
        if (!isset($_SESSION['userid'])) :
        ?>

        <script>
            console.log("未登录状态");
        </script>
        <header class="demos-header">
            <h1 class="demos-title">ss系统登录</h1>
        </header>

        <div class="demos-content-padded">
            <div class="weui-flex">
                <div class="weui-flex__item">
                    <div class="placeholder">
                        <div class="weui-cells__title">
                            用户名
                        </div>
                        <div class="weui-cells">
                            <div class="weui-cell">
                                <div class="weui-cell__bd">
                                    <input id="user" class="weui-input" type="text" placeholder="请输入用户名">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="weui-flex">
                <div class="weui-flex__item">
                    <div class="placeholder">
                        <div class="weui-cells__title">
                            密码
                        </div>
                        <div class="weui-cells">
                            <div class="weui-cell">
                                <div class="weui-cell__bd">
                                    <input id="pwd" class="weui-input" type="password" placeholder="请输入密码">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="weui-flex demos-content-padded">
                <div class="weui-flex__item">
                    <div class="placeholder">
                        <a href="javascript:;" id="login" class="weui-btn weui-btn_primary">登录</a>
                    </div>
                </div>
            </div>

        </div>

        <?php else :
        // include('post.php');
        header("location:post.php")
        ?>
        
        <?php endif;
        ?>
    </main>

    <footer class="weui-footer weui-footer_fixed-bottom">
        <p class="weui-footer__links">
            <a href="http://menhood.wang" class="weui-footer__link">Menhood</a>

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
    <script>
        //回车确认登录
        document.onkeydown = function (e) {
            var theEvent = window.event || e;
            var code = theEvent.keyCode || theEvent.which;
            if (code == 13) {
                $('#login').click();
            }
        };
        $("#login").click(function () {
            var username, password;
            username = $("#user").val();
            password = $("#pwd").val();
            $.ajax({
                url: "login.php",
                type: "post",
                data: {
                    username: username,
                    password: password
                },
                dataType: "json",
                success: function (result) {
                    console.log("success!");
                    console.log(result);
                    $.toast(result.msg, "text");
                    if (result.code == 0) {
                        location.reload();
                    }
                },
                error: function (res) {
                    var res_json = eval(res.responseText);
                    $.toast(res_json.msg, "text");
                    console.log("Error!");
                    console.log(res);
                }
            });
        });

    </script>

</body>