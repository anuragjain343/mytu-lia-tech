<?php
        $frontend_assets =  base_url().'frontend_asset/';
?>
<!-- Header -->
<div class="intro-section fix" id="home">
  <div class="intro-bg bg-cms"></div>
  <div class="intro-inner">
    <div class="intro-content">
      <div id="round"></div>
      <div class="container">
        <div class="row">
          <div class="lead-o col-lg-6 col-xm-12">
            <h1><span class="top-heading-i">Awesome</h1>
            <h2><strong> Free Download TuliA</strong></span></h2> 
            <div class="list-o-i whites">
              <p class="whites">Event Planning, Wedding Planning, Vendor Search, Budget Planning, Easy Planning, Affordable Planning, Freelance Vendors.</p>
              <p class="whites">TuliA- Event Vendor Search At Your Finger Tips! </p>
            </div>
            <br>
           <a href="https://itunes.apple.com/in/app/TuliA/id1338181586?mt=8&ign-mpt=uo%3D4" target="_blank">
            <img src="<?php echo $frontend_assets ?>img/app-store.png" alt="" class="mb10"></a>
            &nbsp;&nbsp;
            <a href="https://play.google.com/store/apps/details?id=com.tulia" target="_blank"><img src="<?php echo $frontend_assets ?>img/play-store.png" alt="" class="mb10"></a>  </div>
          <div class="col-lg-6 col-xm-12 mobileapp wow fadeInRight hidden-xs"> <img class="img-center img-responsive" src="<?php echo $frontend_assets ?>img/mainimg.png" alt=""></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End-Header --> 

<section class="blogSection" id="imaginations">
  <div class="container">
    <div class="section-title center text-center">
      <h2 ><strong>Imaginations</strong></h2>
    </div>
    <div class="blogInner">
      <div id="ourBlogs" class="themeDot">
        <div id="blog_list">
            
        </div>
      </div>
    </div>
    
  </div>
</section>
<!-- END Services--> 
<!-- END Demo--> 
<!-- Start Features Section-->
<section id="features" class="main-section center-align">
    <div class="gradient-color overlay"></div>
    <div class="container">
      <div class="section-title"><h2>TuliA <strong>Features</strong></h2></div>
        <!--Title-->
        <ul class="nav nav-tabs featuresTab" role="tablist">
          <li role="presentation" class="active"><a href="#forVendor" aria-controls="forVendor" role="tab" data-toggle="tab">User Features</a></li>
          <li role="presentation"><a href="#forUser" aria-controls="forUser" role="tab" data-toggle="tab">Vendor Features</a></li>
        </ul>
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane active" id="forVendor">
            <div class="row p-t-2">
              <div class="col s12 m12 l4 p-tb-1 feature-left">
                  <div class="single-feature p-tb-2">
                      <a class="hoverable feature-link forV same-height active" data-owl-item="0">
                          <!--Title -->
                          <div>
                              <h3>User type </h3>
                              <p>Select your role from this screen to login in this app</p>
                          </div>
                          <!-- Icon -->
                          <div>
                              <i class="fa fa-mobile gradient-color waves-effect waves-light" aria-hidden="true"></i>
                          </div>
                      </a>
                  </div>
                  <div class="single-feature p-tb-2">
                      <a class="hoverable feature-link forV same-height" data-owl-item="1">
                          <!-- Title -->
                          <div>
                              <h3>User events</h3>
                              <p>After your posting events, you will see how many vendors will be interested in doing this event</p>
                          </div>
                          <!-- Icon -->
                          <div>
                              <i class="fa fa-gift gradient-color waves-effect waves-light" aria-hidden="true"></i>
                          </div>
                      </a>
                  </div>
                  <div class="single-feature p-tb-2">
                      <a class="hoverable feature-link forV same-height" data-owl-item="2">
                          <!-- Title -->
                          <div>
                              <h3>User profile</h3>
                              <p>You will edit your profile either as a user or vendor, you will also change your business category</p>
                          </div>
                          <!-- Icon-->
                          <div>
                              <i class="fa fa-user gradient-color waves-effect waves-light" aria-hidden="true"></i>
                          </div>
                      </a>
                  </div>
              </div>
              <div class="col push-m3 push-s3 s6 m6 l4 p-tb-1 images-slider">
                  <!--Features Images-->
                  <div class="owl-carousel owl-features">
                      <div>
                          <img class="responsive-img" src="<?php echo $frontend_assets ?>img/Ufeature_01.png" alt="">
                      </div>
                      <div>
                          <img class="responsive-img" src="<?php echo $frontend_assets ?>img/Ufeature_02.png" alt="">
                      </div>
                      <div>
                          <img class="responsive-img" src="<?php echo $frontend_assets ?>img/Ufeature_03.png" alt="">
                      </div>
                      <div>
                          <img class="responsive-img" src="<?php echo $frontend_assets ?>img/Ufeature_04.png" alt="">
                      </div>
                      <div>
                          <img class="responsive-img" src="<?php echo $frontend_assets ?>img/Ufeature_05.png" alt="">
                      </div>
                      <div>
                          <img class="responsive-img" src="<?php echo $frontend_assets ?>img/Ufeature_06.png" alt="">
                      </div>
                  </div>
              </div>
              <div class="col s12 m12 l4 p-tb-1 feature-right">
                <div class="single-feature p-tb-2">
                  <a class="hoverable feature-link forV same-height" data-owl-item="3">
                      <!-- Icon -->
                      <div>
                          <i class="fa fa-video-camera gradient-color waves-effect waves-light" aria-hidden="true"></i>
                      </div>
                      <div>
                          <!-- Title -->
                          <h3>Vendor categories</h3>
                          <p>You can select your event category before searching any vendor profile</p>
                      </div>
                  </a>
                  </div>
                  <div class="single-feature p-tb-2">
                    <a class="hoverable feature-link forV same-height" data-owl-item="4">
                        <!-- Icon -->
                        <div>
                            <i class="fa fa-star gradient-color waves-effect waves-light" aria-hidden="true"></i>
                        </div>
                        <div>
                            <!-- Title -->
                            <h3>Vendor details</h3>
                            <p>You will see the current profile of any vendor before hiring them for your event</p>
                        </div>
                    </a>
                  </div>
                  <div class="single-feature p-tb-2">
                    <a class="hoverable feature-link forV same-height" data-owl-item="5">
                        <!-- Icon -->
                        <div class="chticon">
                            <i class="gradient-color waves-effect waves-light" aria-hidden="true">
                              <img src="<?php echo $frontend_assets ?>img/chat-3.png" alt="">
                            </i>
                        </div>
                        <div>
                            <!-- Title -->
                            <h3>Chat history</h3>
                            <p>Here is the list of all the user/ Vendors who<br> sent a message to you</p>
                        </div>
                    </a>
                  </div>
              </div>
            </div>
          </div>
          <div role="tabpanel" class="tab-pane" id="forUser">
            <div class="row p-t-2">
              <div class="col s12 m12 l4 p-tb-1 feature-left">
                  <div class="single-feature p-tb-2">
                      <a class="hoverable feature-link forU same-height1 active" data-owl-item="0">
                          <!--Title -->
                          <div>
                              <h3>User type </h3>
                              <p>Select your role from this screen to login in this app</p>
                          </div>
                          <!-- Icon -->
                          <div>
                              <i class="fa fa-mobile gradient-color waves-effect waves-light" aria-hidden="true"></i>
                          </div>
                      </a>
                  </div>
                  <div class="single-feature p-tb-2">
                      <a class="hoverable feature-link forU same-height1" data-owl-item="1">
                          <!-- Title -->
                          <div>
                              <h3>All events</h3>
                              <p>After you login, you can see all posting according to your category</p>
                          </div>
                          <!-- Icon -->
                          <div>
                              <i class="fa fa-gift gradient-color waves-effect waves-light" aria-hidden="true"></i>
                          </div>
                      </a>
                  </div>
                  <div class="single-feature p-tb-2">
                      <a class="hoverable feature-link forU same-height1" data-owl-item="2">
                          <!-- Title -->
                          <div>
                              <h3>Event details</h3>
                              <p>When you select any event, complete information of that event will be there and you can also show your interest to do it</p>
                          </div>
                          <!-- Icon-->
                          <div>
                              <i class="fa fa-file-text-o gradient-color waves-effect waves-light" aria-hidden="true"></i>
                          </div>
                      </a>
                  </div>
              </div>
              <div class="col push-m3 push-s3 s6 m6 l4 p-tb-1 images-slider">
                  <!--Features Images-->
                  <div class="owl-carousel owl-carousel1 owl-features1">
                      <div>
                          <img class="responsive-img" src="<?php echo $frontend_assets ?>img/Vfeature_01.png" alt="">
                      </div>
                      <div>
                          <img class="responsive-img" src="<?php echo $frontend_assets ?>img/Vfeature_02.png" alt="">
                      </div>
                      <div>
                          <img class="responsive-img" src="<?php echo $frontend_assets ?>img/Vfeature_03.png" alt="">
                      </div>
                      <div>
                          <img class="responsive-img" src="<?php echo $frontend_assets ?>img/Vfeature_04.png" alt="">
                      </div>
                      <div>
                          <img class="responsive-img" src="<?php echo $frontend_assets ?>img/Vfeature_05.png" alt="">
                      </div>
                      <div>
                          <img class="responsive-img" src="<?php echo $frontend_assets ?>img/Vfeature_06.png" alt="">
                      </div>
                  </div>
              </div>
              <div class="col s12 m12 l4 p-tb-1 feature-right">
                <div class="single-feature p-tb-2">
                  <a class="hoverable feature-link forU same-height1" data-owl-item="3">
                      <!-- Icon -->
                      <div>
                          <i class="fa fa-user gradient-color waves-effect waves-light" aria-hidden="true"></i>
                      </div>
                      <div>
                          <!-- Title -->
                          <h3>Vendor profile</h3>
                          <p> You can see your profile and edit it too from here</p>
                      </div>
                  </a>
                  </div>
                  <div class="single-feature p-tb-2">
                    <a class="hoverable feature-link forU same-height1" data-owl-item="4">
                        <!-- Icon -->
                        <div>
                            <i class="fa fa-file-picture-o gradient-color waves-effect waves-light" aria-hidden="true"></i>
                        </div>
                        <div>
                            <!-- Title -->
                            <h3>Vendor media</h3>
                            <p>Here you can see all media you posted to make your profile strong and attractive</p>
                        </div>
                    </a>
                  </div>
                  <div class="single-feature p-tb-2">
                    <a class="hoverable feature-link forU same-height1" data-owl-item="5">
                        <!-- Icon -->
                        <div>
                            <i class="fa fa-calendar gradient-color waves-effect waves-light" aria-hidden="true"></i>
                        </div>
                        <div>
                            <!-- Title -->
                            <h3>My Event</h3>
                            <p>List of all event on which you showed your interest</p>
                        </div>
                    </a>
                  </div>
              </div>
            </div>
          </div>
        </div>
    </div>
</section>
<!-- End Features Section-->

<section class="service-type" id="vendor">
  <div class="container">
    <div class="section-title"><h2>Our <strong>Vendors & Categories</strong></h2></div>
    <!-- For showing random vendor start-->
    <?php if(!empty($user_session_id)){?>
      <div id="ourVendors" class="owl-carousel owl-theme themeDot">
        <?php foreach ($vendor as $val) { ?>
            <div class="item">
                <a href="<?php echo site_url(); ?>home/users/vendorList">
                    <div class="profile_outer">
                        <div class="vendors_img_wrap">
                            <img src="<?php echo $val->user_image; ?>" class=" ven-image" alt="Alice Bohn">
                        </div>
                        <div class="profile_inner">
                            <h5 class="vendors_profile_title">
                                <a href="javascript:void(0);"><?php echo $val->fullName; ?></a>
                            </h5>
                            <h5 class="vendors_title"><?php echo $val->category_name; ?></h5>
                        </div>
                    </div>
                </a>
            </div>

         <?php } ?>
      </div>
      <?php } else { ?>
         <div id="ourVendors" class="owl-carousel owl-theme themeDot">
          <?php foreach ($vendor as $val) { ?>
            <div class="item">
               <a class="page-scroll" data-toggle="modal" data-target="#LoginModal" href="#">
                    <div class="profile_outer">
                        <div class="vendors_img_wrap">
                            <img src="<?php echo $val->user_image; ?>" class=" ven-image" alt="Alice Bohn">
                        </div>
                        <div class="profile_inner">
                            <h5 class="vendors_profile_title">
                                <a href="javascript:void(0);"><?php echo $val->fullName; ?></a>
                            </h5>
                            <h5 class="vendors_title"><?php echo $val->category_name; ?></h5>
                        </div>
                    </div>
                </a>
            </div>

         <?php } ?>
      </div>
          <?php } ?>
      <!-- End-->
<?php if(!empty($user_session_id)){?>
    <div class="ourServices">
        <div class="row">
            <div id="ourServicesSlide" class="owl-carousel owl-theme themeDot" >
                <?php $t = $countCategory/7;
                      $new_t = number_format($t);
                      if($t>$new_t){
                        $new_t = $new_t+1;
                      }

                        $x = 7;
                        $e = $v = 0;
                    for ($s=0; $s <  $new_t; $s++) {  
                    $v = $countCategory - $x;
                    $x = $v>-1 ? $x : $countCategory;
                ?>
                <div class="item">
                    <div class="row">
                    <?php 
                        $i = 4;
                        $j = 0;
                        $k = 0;
                    
                        for ($d=$e; $d <  $x; $d++) {
                            $val = $categoryImg[$d];
                        ?>
                        
                        <div class="col-md-<?php echo $i; ?> col-sm-<?php echo $i; ?> col-xs-12" >
                            <a class="category-card category-venue" href="<?php echo site_url(); ?>home/users/vendorList/<?php echo encoding($val->id); ?>">
                                <div class="category-card__wrapper">
                                    <div class="category-card__tint">
                                        <div class="category-card__image" style="background-image: url('<?php echo $val->cat_image;?>') !important ;"></div>
                                    </div>
                                    <div class="category-card__text-wrapper">
                                        <h4 class="category-card__label" >
                                            <?php echo ucfirst($val->name); ?>
                                        </h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <?php 
                            $j = $j+$i;

                            if($k!=0 && $j==12){
                                if($k==1){
                                    $i = 4;
                                }else{
                                    $i = 8;
                                }
                            }else if($i == 4 && $k==0){
                               $i = 8;
                                
                            }else if($i == 8){

                                $i = 4;
                            }
                            if($j==12){
                                $j=0;
                            }
                            if($k==6){
                                break;
                            }
                       $k++; } ?>

                    </div>
                </div>
                <?php 
                    $e = $e+7;
                    $x = $x+7;
                   
                }  ?>
            </div>
        </div>
    </div>
    <?php } else { ?>
     <div class="ourServices">
        <div class="row">
            <div id="ourServicesSlide" class="owl-carousel owl-theme themeDot" >
                <?php $t = $countCategory/7;
                      $new_t = number_format($t);
                      if($t>$new_t){
                        $new_t = $new_t+1;
                      }

                        $x = 7;
                        $e = $v = 0;
                    for ($s=0; $s <  $new_t; $s++) {  
                    $v = $countCategory - $x;
                    $x = $v>-1 ? $x : $countCategory;
                ?>
                <div class="item">
                    <div class="row">
                    <?php 
                        $i = 4;
                        $j = 0;
                        $k = 0;
                    
                        for ($d=$e; $d <  $x; $d++) {
                            $val = $categoryImg[$d];
                        ?>
                        
                        <div class="col-md-<?php echo $i; ?> col-sm-<?php echo $i; ?> col-xs-12" >
                          
                              <a class="category-card category-venuep age-scroll" data-toggle="modal" data-target="#LoginModal" href="#">
                                <div class="category-card__wrapper">
                                    <div class="category-card__tint">
                                        <div class="category-card__image" style="background-image: url('<?php echo $val->cat_image;?>') !important ;"></div>
                                    </div>
                                    <div class="category-card__text-wrapper">
                                        <h4 class="category-card__label" >
                                            <?php echo ucfirst($val->name); ?>
                                        </h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <?php 
                            $j = $j+$i;

                            if($k!=0 && $j==12){
                                if($k==1){
                                    $i = 4;
                                }else{
                                    $i = 8;
                                }
                            }else if($i == 4 && $k==0){
                               $i = 8;
                                
                            }else if($i == 8){

                                $i = 4;
                            }
                            if($j==12){
                                $j=0;
                            }
                            if($k==6){
                                break;
                            }
                       $k++; } ?>

                    </div>
                </div>
                <?php 
                    $e = $e+7;
                    $x = $x+7;
                   
                }  ?>
            </div>
        </div>
    </div>
    <?php } ?>
  </div>
</section>
<!-- Volunteer Heading -->
<div id="downloapp" class="app-download">
  <div class="text-con-app  low-back-up">
    <div class="container">
      <div class="row">
        <div class="lead col-lg-7 col-lg-offset-3 col-xm-offset-0 col-xm-12 text-center download-back ">
          <div class="download-text-o"><span class="small-do">Free Download </span> <br>
            <strong>Get App Download</strong> </div>
          <p class="download-p">Experience the best version of TuliA by getting the app.</p>
          <a href="https://itunes.apple.com/in/app/TuliA/id1338181586?mt=8&ign-mpt=uo%3D4" target="_blank"><img src="<?php echo $frontend_assets ?>img/app-store.png" alt=""></a>
          <a href="https://play.google.com/store/apps/details?id=com.tulia" target="_blank"><img src="<?php echo $frontend_assets ?>img/play-store.png" alt=""></a> </div>
      </div>
    </div>
  </div>
</div>

<!-- End Volunteer -->

<script type="text/javascript">

    $(document).ready(function(){
        get_view_me_list();
    });

</script>