<?php
// include('conn.php');
// $sql_cmd_edit = "SELECT * FROM typecho_ss WHERE cid=101";
// $req = mysqli_query($conn,$sql_cmd_edit);
// $data = mysqli_fetch_array($req);
// echo "<pre>";
// var_dump($data);



// 上传信息
// ,"info":"Upload: ' . $_FILES["file"]["name"] .
//         'Type: ' . $_FILES["file"]["type"] .
//         'Size: ' . ($_FILES["file"]["size"] / 1024) . ' Kb '.
//         'Temp file: ' . $_FILES["file"]["tmp_name"] . '"}
?>
<?php //curd
// mysqli_query($conn,$sql_cmd_c);
// mysqli_query($conn,$sql_cmd_i);
// mysqli_query($conn,$sql_cmd_u);
// mysqli_query($conn,$sql_cmd_d);
// mysqli_query($conn,$sql_cmd_o);

// $req = $conn->query($sql_cmd_o);
// while($data = mysqli_fetch_array($req)){
// // echo $data['cid'].$data['title'].$data['text']."<br>";
// // echo '<pre>';
// // var_dump($data);
// }
// echo "Done !";
// mysqli_close($conn);

?>

<?php
// $list = $data_array;
// $mlist = array_chunk($list,10);
// //看分出了多少
// // echo "<pre>".print_r($mlist,true)."</pre>";

// //计算共有几页
// $totalpage = count($mlist);
// $nowpage = isset($_GET['pageid']) ? intval($_GET['pageid']) : 1;
// if(!$nowpage){
// $nowpage = 1;
// }

// $position = $nowpage - 1;

// $prevpage = $nowpage > 1 ? "?pageid=".($nowpage-1) : '?pageid=1';
// $nextpage = ($nowpage + 1) > $totalpage ? '?pageid='.$totalpage : '?pageid='.($nowpage + 1);

// $list = $mlist[$position];

// echo "<pre>".print_r($list,true)."</pre>";
// echo 'Toal: '.$totalpage;
// echo ' <a href="'.$prevpage.'">Prev</a> ';
// echo ' <a href="'.$nextpage.'">Next</a> ';
?>

<!--<script id="tpl" type="text/html">-->
<!--    <% for(var i in list) {   %>-->
<!--    <a href="js91.html?id=<%=list[i].id%>" class="weui-media-box weui-media-box_appmsg">-->
<!--<div class="weui-media-box__hd">
        <!--            <img class="weui-media-box__thumb" src="">-->
<!--        </div>-->-->
<!--        <div class="weui-media-box__bd">-->
<!--            <h4 class="weui-media-box__title">ID: <%=list[i].cid%>标题: <%=list[i].title%></h4>-->
<!--            <p class="weui-media-box__desc"><%=list[i].modified%></p>-->
<!--        </div>-->
<!--    </a>-->
<!--    <% } %>-->
<!--</script>-->
<!--  <div class="weui-cell__bd" id="getmore">查看更多<i id="loading" class="weui-loading" style="opacity: 1; display: none;"></i></div>  -->

<?php //foreach($data_array as $v): ?>
<!--  <div class="weui-flex" id="cid_<?php //echo $v['cid'] ?>" onclick="edit('<?php //echo $v['cid'] ?>')">-->
<!--  <div class="weui-panel"  >-->
<!--  <div class="weui-panel__hd"><?php //echo $v['title'] ?></div>-->
<!--  <div class="weui-panel__bd">-->
<!--    <div class="weui-media-box weui-media-box_text">-->
<!--      <h4 class="weui-media-box__title"><?php //echo $v['title'] ?></h4>-->
<!--      <p class="weui-media-box__desc"><?php //echo $v['text'] ?></p>-->
<!--      <ul class="weui-media-box__info">-->
<!--        <li class="weui-media-box__info__meta"><?php //echo date("Y-d-m H:m:s",$v['created']) ?></li>-->
<!--        <li class="weui-media-box__info__meta"></li>-->
<!--        <li class="weui-media-box__info__meta weui-media-box__info__meta_extra"><?php //echo date("Y-d-m H:m:s",$v['modified']) ?></li>-->
<!--      </ul>-->
<!--    </div>-->
<!--  </div>-->
<!--</div>-->
<?php //echo $v['cid'];//var_dump($v) ?>
<!--</div>-->
<?php //endforeach; ?>

<?php //elseif ($_POST['ajax'] == 2):
// header('Content-type: application/json');
// echo json_encode($data_array,JSON_UNESCAPED_UNICODE);
?>
<script>
    // $('#loading').hide();
    // var pagesize=10;//每页数据条数
    // function ajaxpage(page){
    //     $.ajax({
    //         type:"post",
    //         url:'post.php',
    //         data: {"page":page,"pagesize":pagesize,ajax:2},
    //         dataType:'json',
    //         timeout:10000,
    //         beforeSend:function(xhr){
    //             $('#loading').show();
    //         },
    //         success:function(rs){
    //             $('#loading').hide();
    //             $("#ss-list").append(tpl(document.getElementById('tpl').innerHTML,rs));

    //           var maxpage = Math.ceil(rs.total / pagesize);
    //             sessionStorage['maxpage'] = maxpage;

    //             if(page==maxpage){
    //                 $("#getmore").html("没有更多数据了");return false;
    //             }
    //         },
    //         error:function(xhr){
    //             console.log('ajax出错');
    //             console.log(xhr);
    //         },
    //     });
    // }

    // $(function(){

    //     var page = 2;
    //     var maxpage;

    //     $('#getmore').on('click', function() {
    //         maxpage = sessionStorage['maxpage'];
    //         if(page<=maxpage) {
    //             ajaxpage(page);
    //             page++;
    //         }
    //     });
    //     ajaxpage(1);
    // })
</script>