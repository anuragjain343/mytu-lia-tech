<div id="commonModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" role="form" id="editBlogFormAjax" method="post" action="<?php echo base_url('admin/imaginations/update') ?>" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title"><?php echo $title;?></h4>
                </div>
                <div class="modal-body">
                    
                    <div class="alert alert-danger" id="error-box" style="display: none"></div>
                    <div class="form-body">
                        <div class="row">
                                 
                             <div class="col-md-12" >
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Send Message to</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="blog_name" id="event_name" value="<?php echo $user_data->fullName;?>" disabled/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Description</label>
                                    <div class="col-md-9">
                                      <textarea class="form-control" rows="5" id="comment"></textarea>
                                    </div>
                                </div>
                      
                            </div> 
                            
                             <input type="hidden" name="id" value="" />
                            <input type="hidden" name="exists_image" value="" />
                            <div class="space-22"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit"  class="btn btn-danger" id="submit_blog">Send</button>
                </div>
            </form>
        </div> <!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
