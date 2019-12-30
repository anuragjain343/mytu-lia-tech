<div id="commonModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php if($user_data=='users' OR $user_data=='vendor' ){ 
              $controller =  base_url('admin/users/sendPushNotificationToAll');
                $id ='sendAllFormAjax';
                ?>
            <?php } else{
                $controller = base_url('admin/users/sendPushNotification');
                $id ='sendFormAjax';
            } ?>
            <form class="form-horizontal" role="form" id="<?php echo $id; ?>" method="post" action="<?php echo $controller;  ?>" enctype="multipart/form-data">
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
                                     <?php if($user_data=='users' OR $user_data=='vendor' ){ ?>
                                     <div class="col-md-9">
                                        <input type="text" class="form-control" name="userName" id="event_name" value="<?php echo 'All &nbsp;'.$user_data;?>" disabled/>
                                         <input type="hidden"  name="usertype" id="event_name" value="<?php echo $user_data;?>" />
                                    </div>
                                     <?php } else{ ?>
                                    <div class="col-md-9">
                                        <input type="hidden"  name="userId" value="<?php echo $user_data->id;?>" >
                                         <input type="hidden"  name="deviceToken" value="<?php echo $user_data->deviceToken;?>" >
                                          <input type="hidden"  name="usertype" value="<?php echo $user_data->userType;?>" >
                                        <input type="text" class="form-control" name="userName" id="event_name" value="<?php echo $user_data->fullName;?>" disabled/>
                                    </div>
                                    <?php }?>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Message</label>
                                    <div class="col-md-9">
                                      <textarea class="form-control" rows="5" id="comment" name="msg" placeholder="Write here..."></textarea>
                                    </div>
                                </div>
                            </div> 
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
