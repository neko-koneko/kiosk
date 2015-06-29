<?php
include("inc/views/admin_head.php");
include("inc/views/admin_header.php");
$base = $base.'admin/';
?>

<div class="w100 fleft admin-container bbsz asc p20" style="background:#222; position:absolute; top:114px;left:0;right:0;bottom:0">
    <div class="fleft w100 p10 bbsz asc" style="position: absolute; top: 0px; bottom: 0px; right: 0px; overflow-y: auto; overflow-x: hidden;">
        <h1>Меню</h1>
        <div class="fleft w100 asc bbsz pb10">
	        <a class="asc bbsz green admin-confirm-button" href="<?=$base.$main_request_array[1];?>/new/">Добавить</a>
        </div>

        <form enctype="multipart/form-data" action="<?=$base.$main_request_array[1];?>/savestructure" method="POST">
            <table class="fleft w100 admin-table" id="menutable">
                <thead>
                    <tr NoDrag="1" NoDrop="1">
                        <th>id</th>
                        <th>Название</th>
                        <th style="width:100px"><a href="<?=$base.$main_request_array[1];?>/view/available/<?=$orderType;?>">вкл</th>
                        <th style="width:100px">действия</th>
                    </tr>
                </thead>
                <tbody>
                    <? foreach($menu as $item): ?>
                        <tr>
                            <td>
                                <?=$item['id'];?>
                                <input type="hidden" name="order[<?=$item['id'];?>]" value="<?=$item['id'];?>">
                            </td>
                            <td><a href="<?=$base.$main_request_array[1];?>/edit/<?=$item['id'];?>"><?=$item['name'];?></a></td>
                            <? if($item['id'] > 1): ?>
                                <?php
                                    $onoffClass = ($item['available']=='Y')?'green':'red';
                                    $onoffText = ($item['available']=='Y')?'Вкл':'Выкл';
                                    $onoffTitle = ($item['available']=='Y')?'Выключить':'Включить';
                                    $onoffAction = ($item['available']=='Y')?'off':'on';
                                ?>
                                <td>
                                    <a class="<?=$onoffClass;?> tdn" href="<?=$base.$main_request_array[1];?>/<?=$onoffAction;?>/<?=$item['id'];?>"><?=$onoffText;?></a>
                                </td>
                                <td>
                                    <a class="red tdn" href="<?=$base.$main_request_array[1];?>/confirmdelete/<?=$item['id'];?>" title="Удалить">[X]</a>
                                </td>
                            <? else: ?>
                                <td></td><td></td>
                            <? endif; ?>
                        </tr>
                    <? endforeach; ?>
                </tbody>
            </table>
            <div class="fleft w100 asc bbsz pt10">
                <input class="asc bbsz green admin-confirm-button" type="submit" value="Сохранить" />
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
	var table = document.getElementById('menutable');
	var tableDnD = new TableDnD();
	tableDnD.init(table);
</script>

<?php
 include("inc/views/footer.php");
?>