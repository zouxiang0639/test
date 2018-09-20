<div id="reply_ajax" style="margin-bottom: -18px;">

    <div class="page-reply">
        <ul class="pagination" style="display: none">
            <li><a href="{!! route('f.reply.show', ['article_id' => $info->id]) !!}">2</a></li>
        </ul>
    </div>
</div>
<p class="abc"></p>

<div style="display: none">

    <div class="reply">
        <div class="img" >
        </div>
        <div class="con">
            <form class="reply-form">
                <input type="hidden" name="article_id" value="{!! $info->id !!}">
                <input type="hidden" name="at" value="0">
                <input type="hidden" name="parent_id" value="0">
                <input type="hidden" class="picture" name="picture" value="">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="tea">
                    <textarea name="contents"></textarea>
                </div>
                <div class="opt">

                    <a   href="javascript:;"   class=" img img—submit" data-href="{!! route('f.reply.store') !!}"><i class="fa fa-image"></i></a>
                    <input style="display: none" class="layui-upload-file" accept="undefined" name="file" type="file">
                    <a  href="javascript:;"  class="txt reply—submit" data-href="{!! route('f.reply.store') !!}">回复</a>
                </div>
            </form>

        </div>
    </div>
</div>

@section('script')
    @parent
<script>
   $(function(){
       var comTie =  $(".new-inner");

       var locked = true;
       //异步加载回复子数据
       $("#reply_ajax").on('click', '.pagination a', function(){
           var parentId = $(this).attr('data-id');
           if (! locked) {
               return false;
           }
           locked = false;

           $.ajax({
               url: $(this).attr('href'),
               type: 'PUT',
               data: {
                   "_method": "PUT",
                   'parent_id' : parentId,
                   "_token": $('meta[name="csrf-token"]').attr('content')
               },
               cache: false,
               dataType: 'json',
               success:function(res) {
                   if(res.code != 0) {
                       $('.page').html(res.data);
                   } else {
                       $('#reply_ajax').html(res.data);
                       locked = true;
                   }
               },
               error:function () {
                   locked = true;
               }

           });
           return false;
       });

       //异步加载回复子数据
       comTie.on('click', '.reply-show-child', function(){
           var parentId = $(this).attr('data-id');
           var check = $(this).attr('data-check');
           var _this = $(this);

           if(check == '0') {
               if (! locked) {
                   return false;
               }

               locked = false;

               $.ajax({
                   url: '{!! route('f.reply.show.child') !!}',
                   type: 'POST',
                   data: {
                       "_method": "PUT",
                       'parent_id' : parentId,
                       'article_id' : '{!! $info->id !!}',
                       "_token": $('meta[name="csrf-token"]').attr('content')
                   },
                   cache: false,
                   dataType: 'json',
                   success:function(res) {
                       if(res.code != 0) {
                           $('.page').html(res.data);
                       } else {
                           if($(".delete-"+parentId).length == 0) {
                               $('.reply-' + parentId).after(res.data);
                           } else {
                               $('.delete-' + parentId).after(res.data);
                           }

                           locked = true;
                           _this.attr('data-check', 1);
                       }
                   },
                   error:function () {
                       locked = true;
                   }

               });
           } else if (check == '1') {
               $('.child-'+parentId).hide();
               _this.attr('data-check', 2);
           } else if(check == '2') {
               $('.child-'+parentId).show();
               _this.attr('data-check', 1);
           }


       });

       comTie.on('click', '.reply-one-edit', function(){
           var id = $(this).attr('data-id');
           if($(this).attr('data-check') == '1') {

               $(this).attr('data-check', '0');
               $(".delete-"+ id).remove();
           } else {
               $('.reply input[name=at]').val($(this).attr('data-at'));
               $('.reply input[name=parent_id]').val(id);

               $(this).attr('data-check', '1');

//               var html ='<li class="edit-container delete-'+ id +'">';
//               html += $(".reply").html();
//               html += '</li>';
               var html ='<li class="share clearfix delete-'+ id +' "><div class="sh-l fl"><i></i></div><div class="sh-r fr edit-container"> ';
               html += $(".reply").html();
               html += '</div></li>';
               $(this).parents('.reply-' + id).after(html);
               $('.abc').click();
           }
       });

       comTie.on('click', '.reply-two-edit', function(){
           var id = $(this).attr('data-id');

           if($(this).attr('data-check') == '1') {
               $(this).attr('data-check', '0');
               $(".delete-"+ id).remove();
           } else {
               $('.reply input[name=at]').val($(this).attr('data-at'));
               $('.reply input[name=parent_id]').val($(this).attr('data-pid'));

               $(this).attr('data-check', '1');

               var html ='<li class="share clearfix delete-'+ id +' "><div class="sh-l fl"><i></i></div><div class="sh-r fr edit-container"> ';
               html += $(".reply").html();
               html += '</div></li>';
               $(this).parents('.reply-' + id).after(html);
               $('.abc').click();
           }
       });

       //评论点赞
       comTie.on('click', '.thumbs', function(){
           var numClass = $(this).children().children(".num");

           var num = parseInt(numClass.text());
           var _this = $(this);

           if (! locked) {
               return false;
           }

           locked = false;

           $.ajax({
               url: $(this).attr('data-href'),
               type: 'POST',
               data: {
                   "_method": "PUT",
                   "_token": $('meta[name="csrf-token"]').attr('content')
               },
               cache: false,
               dataType: 'json',
               success:function(res) {
                   if(res.code == 1020001){
                       swal({
                           title: "",
                           text: "<p class='text-danger'>" + res.msg + "</p>",
                           html: true
                       });

                   }else  if(res.code != 0) {
                       swal(res.data, '', 'error');
                   } else {

                       if(res.data == true) {
                           _this.children("i").addClass('default');
                           numClass.text(num + 1);
                       } else {
                           _this.children("i").removeClass('default');
                           numClass.text(num - 1);
                       }
                   }
                   locked = true;
               },
               error:function () {
                   locked = true;
               }

           });
       });

       //评论删除
       comTie.on('click', '.delete-reply', function(){
           var _this = $(this);
           swal({
                       title: "确认删除?",
                       type: "warning",
                       showCancelButton: true,
                       confirmButtonColor: "#DD6B55",
                       confirmButtonText: "确定",
                       closeOnConfirm: false,
                       cancelButtonText: "取消"
                   },
                   function(){

                       if (! locked) {
                           return false;
                       }

                       locked = false;
                       $.ajax({
                           url: _this.attr('data-href'),
                           type: 'POST',
                           data: {
                               "_method":"DELETE",
                               "_token":$('meta[name="csrf-token"]').attr('content')
                           },
                           cache: false,
                           dataType: 'json',
                           success:function(res) {
                               if(res.code != 0) {
                                   swal(res.data, '', 'error');

                               } else {
                                   swal(res.data, '', 'success');
                                   _this.parents('li').remove();
                               }
                               locked = true;
                           },
                           error:function () {
                               locked = true;
                           }

                       });

                   }
           );
       });


       $('#reply_ajax .pagination a').trigger('click');
   })
</script>
@stop