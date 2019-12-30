<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo 'Imaginations'  .'('.$count.')';?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin/dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="<?php echo site_url('admin/imaginations');?>">Imaginations</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          
          <!-- /.box -->
        <div class="text-right">            
          <a href="<?php echo site_url(); ?>admin/imaginations/addImaginations/" class="btn btn-primary btn-raised"> Add Imaginations</a>
        </div>


          <div class="box">
            
            <!-- /.box-header -->
            <div class="box-body">
               <!-- <input type="text" name="event_date" placeholder="Pick date" class="form-control" id="datepicker" data-date-format='yyyy-mm-dd'> -->
               <div class="">
                 <table id="blog_list" class="table table-bordered table-striped">
                  <thead>
                  <th style="width: 15%">S.No.</th>
                  <th>Title</th>
                  <th>Attachments</th>
                  <th>Posted On</th>
                  
                  <th style="width: 25%">Action</th>
                  </thead>
                  <tbody>
                      
                  </tbody>
                  <tfoot>
                  
                  </tfoot>
                </table>
              </div>  
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  <div id="form-modal-box"></div>
 
