<!-- Modal -->
<div class="modal fade" id="commonModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">  
            <div class="nav-tabs-custom">
                <!-- <button type="button" class="pull-right btn cls-bt cls" data-dismiss="modal"><i class="fa fa-close"></i></button> -->
                <div class="box-left">
                    <div class="modal-body">
                        <div class="row invoice-info">
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- Box Comment -->
                                    <div class="user-block user-blog">
                                        <h4>Blog Details</h4>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body box-brdr-bdy">
                                        <p class="pst-ttl ved-tit"><?php echo display_placeholder_text(ucfirst($blogDetail->title));?></p>
                                        <p class="pop-tme"><?php echo time_elapsed_string($blogDetail->createdOn); ?></p>
                                        <div class="media-caro">
                                            <?php
                                            if($blogDetail->attachment_type == 'video'){
                                                $video = base_url().BLOG_CONTENT.$blogDetail->image; ?>
                                                <video class="ved-wid" controls muted src="<?php echo $video ;?>" >=</video>
                                            <?php }else{
                                                $img = base_url().BLOG_CONTENT.$blogDetail->image; ?>
                                                <img class="img-responsive pad img-wid" src="<?php echo $img ;?>" alt="image">
                                            <?php  } ?>
                                        </div>
                                        <p style="padding-top: 13px;"></p>
                                        <p class="descr-pop"><?php echo display_placeholder_text($blogDetail->description);?></p>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <!-- /.row -->
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                    <!-- /.tab-content -->
                </div>
            </div> <!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
<div>
