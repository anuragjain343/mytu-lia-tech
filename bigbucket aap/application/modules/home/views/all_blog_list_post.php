<?php 
if(!empty($blogList)){
foreach ($blogList as $val) { ?>
    <div class="col-md-4 col-sm-4 col-xs-12">
        <article class="post-wrap post-wrap-bg mt-10 mb-10">
            <div class="post-media" >
                <span class="tg-timetag"><?php echo date('M-d-Y', strtotime($val->createdOn)); ?></span>
                <?php if($val->type == 'video'){ ?>
                    <video class="ved-wid" controls muted src="<?php echo $val->blog_image ;?>" ></video>
                <?php }else{ ?>
                    <img src="<?php echo $val->blog_image; ?>" alt="Image" class="img-responsive"> 
                <?php } ?>
            </div>
            <div class="post-header">
                <h2 class="post-title"><a href="#" class="blg-title"><?php echo $val->title; ?></a></h2>
            </div>
            <div class="post-body">
                <div class="post-excerpt">
                    <p><?php echo $val->description; ?></p>
                </div>
            </div>                    
        </article>

    </div>

<?php } }?>
