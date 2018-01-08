<layout name="../Layout/Appadmin/Layout" />
<style>
    .transparent{
        opacity : 0;
        height:0px;
        overflow:hidden;
    }
</style>
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
            <div class="tree-main"> 
                <div class="top-null"></div>
                <div class="division-content"> 
                    <div class="division-con js_contents">
                        <div class="divi-right"> 
                            {$tpls}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script >
   
    $(function($){
        //点击区域外关闭此下拉框
        $(document).on('click',function(e){
            if($(e.target).parents('.js_select_list').length>0){
                var currUl = $(e.target).parents('.js_select_list').find('.js_select_option');
                $('.js_select_list .js_select_option').not(currUl).hide()
            }else{
                $('.js_select_list .js_select_option').hide();
            }
        });
        //折叠展开
        $('.js_contents').on('click','.js_showhide',function(){
            if($(this).hasClass('add-hide-icon')){
                $(this).removeClass('add-hide-icon');
            }else{
                $(this).addClass('add-hide-icon');
            }

            $(this).parents('.js_showhidefu').siblings('.js_siblings').toggle();
        })
      

    });
</script>



 