@extends('admin.layouts.app')

@section("content")

<script type="text/javascript">
  $(function(){
    setNav(".page_manage");
  });
</script>


<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    页面管理
  </h1>
</section>

<!-- Main content -->
<section class="content">
	<div class="box">
		<div class="box-header">
			<a href="{{route('admin.page.edit')}}" class="btn btn-primary pull-right">新增</a>
		</div>
		<div class="box-body">
			<table id="example2" class="table table-bordered table-hover">
				<thead>
					<tr>
					<th>ID</th>
					<th style="width: 500px;">页面名称</th>
          <th>创建时间</th>          
					<th>操作</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div><!-- /.box-body -->
	</div><!-- /.box -->
</section><!-- /.content -->

    <!-- DATA TABES SCRIPT -->
    <script src="/admin_resource/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="/admin_resource/plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>

    <!-- page script -->
    <script type="text/javascript">
      window.g_data = [];

      $(function () {

        var table_param = {        
          "sAjaxSource": "{{route('admin.page.list')}}",
          "iDisplayLength": 10,
          'columns':[
            {'aTargets': [0], 'data': 'id', 'orderable': true},
            {'aTargets': [1], 'data': 'title'},
            {'aTargets': [2], 'data': 'created_at'},
            {
              "targets": [3],
              "data": "id",
              "render": function(data, type, full) {
              	
                return "<a href='/page?id="+data+"' class='edit fa fa-eye' target='_blank' title='查看'>查看</a>&nbsp;&nbsp;&nbsp;&nbsp;"
                    +"<a href='{{route('admin.page.edit')}}?id="+data+"' class='edit fa fa-pencil-square-o' title='编辑'>编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;"
                  +"<a href='javascript:;' class='delete fa fa-close' data-id='" + data + "' title='删除'>删除</a>";
              }
            },
          ]
        };
        // var param = $.extend({}, dataTable_param, table_param);
        // console.log(param);
        $('#example2').dataTable($.extend({}, dataTable_param, table_param));


        //删除
        $(document).on('click', '.delete', function(){
            if(!confirm("确定删除？")){
              return;
            }

            var id = $(this).data("id");
            $.post('{{route("admin.page.del")}}', {id: id}, function(res){
                    if (res.code == 200) {
                        $.simplyToast('操作成功!', 'success');
                        $("#example2").dataTable().fnDraw(false);
                    }else{
                        $.simplyToast(res.msg, 'danger');
                    }
                });
        });


      });


      
    </script>


<style type="text/css">
  .edit-dialog .list li{
    list-style: none;
  }

  .edit-dialog .list li label{
    text-align: right;
    width: 120px;
  }

  .edit-dialog .list li span{
    padding-left: 20px;
  }
</style>

@endsection

