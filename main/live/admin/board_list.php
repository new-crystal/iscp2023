<?php include_once('./include/head.php');?>
<?php include_once('./include/header.php');?>
<?php
    $board_type_list = ["News", "News & Notice", "FAQ"];

    $board_type = isset($_GET["t"]) ? preg_replace("/[^0-9]/","",$_GET["t"]) : "";
    $board_type = $board_type ?? 0; 

    switch ($board_type) {
        case 0 :
            $auth = $admin_permission["auth_board_news"];
            break;
        case 1 :
            $auth = $admin_permission["auth_board_notice"];
            break;
        case 2 :
            $auth = $admin_permission["auth_board_faq"];
            break;
    }
    if($auth == 0){
        echo '<script>alert("권한이 없습니다.")</script>';
        echo '<script>history.back();</script>';
    }
    $is_modify = ($auth >= 2);

    $category_id = "";

    $where = "";

    if($board_type != 2){
        $title    = isset($_GET["title"])        ? addslashes(htmlspecialchars($_GET["title"], ENT_QUOTES)) : "";
        $s_date = isset($_GET["s_date"])    ? addslashes(htmlspecialchars($_GET["s_date"], ENT_QUOTES)) : "";
        $e_date = isset($_GET["e_date"])    ? addslashes(htmlspecialchars($_GET["e_date"], ENT_QUOTES)) : "";

        if($title != ""){
            $where .= " AND (b.title_en LIKE '%{$title}%' OR b.title_kr LIKE '%{title}%') ";
        }

        if($s_date != ""){
            $where .= " AND b.register_date >= '{$s_date}' ";
        }

        if($e_date != ""){
            $where .= " AND b.register_date < DATE_ADD('{$e_date}', INTERVAL 1 DAY) ";
        }
    }else{
        $category_id = isset($_GET["c"]) ? preg_replace("/[^0-9]/","",$_GET["c"]) : "";
    
        $sql = "SELECT idx, title_en, title_ko FROM board_category WHERE is_deleted = 'N' AND idx = {$category_id}";
        $category = sql_fetch($sql);

        if($category["idx"] == ""){
            echo "<script>alert('카테고리 정보가 유효하지 않습니다.'); window.location.replace('./board_category_list.php');</script>";
            exit;
        }

        $where .= " AND category = {$category_id} ";
    }
    

    $sql = "
            SELECT
                b.idx, b.title_en, b.title_ko, a.name, b.view, DATE_FORMAT(b.register_date, '%y-%m-%d') AS register_date  
            FROM board AS b
            LEFT JOIN(
                SELECT
                    idx, name
                FROM admin
                WHERE is_deleted = 'N'
            )AS a
            ON b.register = a.idx
            WHERE b.type = {$board_type}
            AND b.is_deleted = 'N'
            {$where}
            ORDER BY b.register_date DESC
           ";
        
    $list = get_data($sql);
?>
    <section class="list">
        <div class="container">
            <div class="title clearfix2">
                <h1 class="font_title"><?=$board_type_list[$board_type]?></h1>
                <?php
                    if($is_modify){
                ?>
                <button type="button" class="btn" onclick="javascript:window.location.href='./board_detail.php?t=<?=$board_type?>&c=<?=$category_id?>';"><?=$board_type_list[$board_type]?> 등록</button>
                <?php
                    }
                ?>
            </div>
            <?php if($board_type != 2){?>
                <div class="contwrap centerT has_fixed_title">
                    <form name="search_form">
                        <table>
                            <colgroup>
                                <col width="10%">
                                <col width="40%">
                                <col width="10%">
                                <col width="40%">
                            </colgroup>
                            <tbody>
                                <tr>
                                    <th>제목</th>
                                    <td>
                                        <input type="text" name="title" value="<?=$title?>">
                                    </td>
                                    <th>등록일</th>
                                    <td class="input_wrap"><input type="text" class="datepicker-here" name="s_date" data-language="en" data-date-format="yyyy-mm-dd" value="<?=$s_date?>" data-type="date"> <span>~</span> <input type="text" class="datepicker-here" name="e_date" data-language="en" data-date-format="yyyy-mm-dd" value="<?=$e_date?>" data-type="date"></td>
                                </tr>
                            </tbody>
                        </table>
                       <button type="button" class="btn search_btn">검색</button>
                   </form>
                </div>
                <div class="contwrap">
                    <p class="total_num">총 <?=number_format(count($list))?>개</p>
                    <table id="datatable" class="list_table">
                        <thead>
                            <tr class="tr_center">
                                <th>제목(영문)</th>
                                <th>제목(국문)</th>
                                <th>작성자</th>
                                <th>조회수</th>
                                <th>등록일</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach($list as $l){
                                    echo "    <tr class='tr_center'>";
                                    echo "        <td><a href='./board_detail.php?t=".$board_type."&i=".$l["idx"]."' class='ellipsis'>".stripslashes($l["title_en"])."</a></td>";
                                    echo "        <td><a href='./board_detail.php?t=".$board_type."&i=".$l["idx"]."' class='ellipsis'>".stripslashes($l["title_ko"])."</a></td>";
                                    echo "        <td>".$l["name"]."</td>";
                                    echo "        <td>".number_format($l["view"])."</td>";
                                    echo "        <td>".$l["register_date"]."</td>";
                                    echo "    </tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            <?php }else{?>
                <div class="contwrap has_fixed_title">
                    <p class="total_num">총 <?=number_format(count($list))?>개</p>
                    <table id="datatable" class="list_table">
                        <thead>
                            <tr class="tr_center">
                                <th colspan="3"><?=stripslashes($category["title_ko"])?></th>
                            </tr>
                            <tr class="tr_center">
                                <th>질문 제목(영문)</th>
                                <th>질문 제목(국문)</th>
                                <th>등록일</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach($list as $l){
                                    echo "    <tr class='tr_center'>";
                                    echo "        <td><a href='./board_detail.php?t=".$board_type."&i=".$l["idx"]."&c=".$category_id."' class='ellipsis'>".stripslashes($l["title_en"])."</a></td>";
                                    echo "        <td><a href='./board_detail.php?t=".$board_type."&i=".$l["idx"]."&c=".$category_id."' class='ellipsis'>".stripslashes($l["title_ko"])."</a></td>";
                                    echo "        <td>".$l["register_date"]."</td>";
                                    echo "    </tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            <?php }?>
        </div>
    </section>

    <script src="./js/common.js"></script>
<?php include_once('./include/footer.php');?>