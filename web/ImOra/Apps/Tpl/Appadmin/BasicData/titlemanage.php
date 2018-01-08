<layout name="../Layout/Layout"/>
<style>
    .manage_position_list {
        width: 20%;
        background: #c0c0c0 none repeat scroll 0 0;
        height: 1200px;
        margin: 10px 10px 0 40px;
        padding: 20px 0;
        float: left;
    }
    .position_list_for_choice {
        width: 230px;
        height: 400px;
        display: none;
        margin: 0 0 0 96px;
        position:absolute;
        z-index:2;
    }

    .wrapRight {
        padding: 20px 0;
        float: left;
        width: 70%;
        height: 1200px;
        margin: 10px 20px 0 0;

    }

    .js_operation_buttons {
        border-bottom: 1px solid #b8b8b8;
        padding-bottom: 15px;
        height: 30px;
    }
    ._center {
        display: -webkit-flex;
        display: flex;
        -webkit-align-items: center;
        align-items: center;
        -webkit-justify-content: center;
        justify-content: center;
        margin-top: 30px;
    }
    .button_input{
        background: #444 none repeat scroll 0 0;
        border: medium none;
        color: #ccc;
        font: 14px/30px "微软雅黑";
        height: 30px;
        margin:40px 20px 0 60px ;
        text-align: center;
        width: 60px;
        cursor:pointer;
    }
    .manage_position_list li {
        position:relative;
        cursor: pointer;
        list-style:none;
    }
    .manage_position_list li ul {
         display:none;
        margin: 0 0 0 20px;
        list-style:none;
    }
    .manage_position_list li[status='2'] {
    text-decoration: line-through;
    }
    .manage_position_list li[status='3'] {
    display: none;
    }
    .manage_position_list li i {
    display: block;
    font-style: initial;
    height: 35px;
    margin: 0 0 0 10px;
    overflow: hidden;
    width: 95%;
    text-overflow: ellipsis;
    white-space: nowrap;
    color:#333; font: 14px/35px "微软雅黑";
    text-indent: 8px;
    }
    .manage_position_list li u {
    border-bottom: 7px solid transparent;
    border-left: 7px solid #666;
    border-top: 7px solid transparent;
    border-right: 0;
    display: inline-block;
    height: 0;
    cursor:pointer;
    position:absolute;
    left:2px;
    top:12px;
    }
    .manage_position_list li u.open{
    border-left: 7px solid transparent;
    border-right: 7px solid transparent;
    border-top: 7px solid #666;
    border-bottom: 0;
    display: inline-block;
    left:0;
    top:16px;
    }

</style>
<div class="js_position_list_for_edit manage_position_list">
    {:recursivePrint($positionList, 0 , 'categoryid')}
</div>
<div class="wrapRight">
    <div class="js_operation_buttons">
        <div id="add_position" class="left_binadmin cursorpointer"  style="margin-left:10px">新建</div>
        <div id="delete_position" class="left_binadmin cursorpointer">删除</div>
    </div>
    <div class="js_formZone _center">
        <form method="post" action="" id="item_manage_form">
            <div class="Administrator_user">
                <label for="positionName"><span>名称</span></label>
                <input type="text" id="positionName" name="positionName" placeholder="职能名称" maxlength="32"/>
            </div>
            <div class="Administrator_user">
                <label for="keyword"><span>关键字</span></label>
                <input type="text" id="keyword" name="keyword" placeholder="关键字" maxlength="32"/>
                <p style="color:red;">※多个关键词请使用”逗号“区分</p>
            </div>
            <div class="Administrator_user">
                <label for="sort"><span>排序</span></label>
                <input type="text" id="sort" name="sort" placeholder="排序"/>
            </div>
            <div class="Administrator_user">
                <label for="parentId"><span>所属行业</span></label>
                <input type="text" id="parentName" name="parentName" placeholder="上级分类" readonly="readonly"/>
                <input type="hidden" id="parentId" name="parentId" value="0"/>
                <input type="hidden" id="positionId" name="positionId" value="0"/>
                <div class="js_position_list_for_choice manage_position_list position_list_for_choice">
                    {:recursivePrint(array($positionList[0]))}
                </div>
            </div>

            <div class="_center">
                <input type="hidden" id="categoryId" name="categoryId" value=""/>
                <input class="button_input hidden" name="stopItem" type="submit" value="停用" id="changeStatusDisable"/>
                <input class="button_input hidden" name="stopItem" type="submit" value="启用" id="changeStatusEnable"/>
                <input class="button_input"  type="submit" value="保存" id="submitItemForm"/>
            </div>
        </form>
    </div>

</div>
<script type="text/javascript">
$(function () {
	$.Position.init();
});

</script>