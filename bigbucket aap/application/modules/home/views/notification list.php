<?php if(!empty($notify_list)){ 
        foreach ($notify_list as $value) { ?>
        <li>
            <?php if($value->notification_type == 'user_review' ){ ?>
                <a href="<?php echo site_url(); ?>home/users/vndrReview/<?php echo encoding($value->notification_message->reference_id); ?>">
            <?php }else if($value->notification_type == 'post_create'){ ?>
                <a href="<?php echo site_url(); ?>home/Vendorpost/eventDetail/<?php echo encoding($value->notification_message->reference_id); ?>">
            <?php }else{ ?>
                <a href="<?php echo site_url(); ?>home/posts/postDetail/<?php echo encoding($value->notification_message->reference_id); ?>">
                <?php } ?>
                <div class="notif-sec">
                    <div class="section-left">
                        <img src="<?php echo $value->user_image; ?>" alt="Image" style="width:60px">
                    </div>
                    <div class="section-body">
                        <h4><?php echo $value->fullName; ?></h4>
                        <p><?php echo $value->notification_message->body; ?></p>
                    </div>
                </div>
            </a>
        </li>
    <?php } }else{ ?>
    <li>
        <a href="#">
            <div class="notif-sec no-noti-sec">
                <div class="section-left no-noti-drop">
                    <i class="fa fa-bell-slash"></i>
                </div>
                <div class="section-body no-noti-body">
                    No Notification Available
                </div>
            </div>
        </a>
    </li>
<?php } ?>
