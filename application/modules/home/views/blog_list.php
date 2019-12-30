<?php 
if(!empty($blogList)){
foreach ($blogList as $val) { ?>
    <div class="col-md-4 col-sm-4 col-xs-12">
        <article class="post-wrap mt-10 mb-10">
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
                      <p>
                        <?php $length = strlen($val->description);?>
                        <?php 
                        if($length  == 180){
                            echo $val->description;

                        }else if($length >=170 AND $length <=179){
                             echo $val->description;
                        }
                         else if($length < 169){
                         echo $val->description; 
                       
                        }
                        else{
                         echo trim(substr($val->description,0,160)).'...';
                        ?>
                        <a href="javascript:void(0)" onclick="detailsFn('<?php echo $val->blogId;?>')" style='color:red;'>
                        <span id="moreDataTitle<?php echo $val->blogId;?>" data-value="<?php echo $val->title;?>"></span>   
                        <span id="moreData<?php echo $val->blogId;?>" data-value="<?php echo $val->description;?>"></span> 
                        <?php  }?>
                        <?php if($length > 180){
                            echo "Read More";
                        } ?>
                        </a>
                        </p>
                </div>
            </div>                    
        </article>

    </div>
<?php } }?>
 <?php if(!empty($blogList) && count($blogList)>=6){ ?> 

<div style="clear: both"></div>
<div class="col-md-4 col-sm-4 col-xs-12 col-md-offset-4">
    <div class="login-snd ">
        <a href="<?php echo base_url();?>home/imaginations"><button type="button" class="m-btn login-btn block-btn load_more_btn center-block"  >See More</button></a>
    </div>
</div>
<?php } ?>




