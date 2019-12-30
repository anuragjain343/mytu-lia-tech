 <section class="blogSection inspiration-blog" id="inspiration">
  <div class="container">
    <div class="section-title center text-center">
      <h2 ><strong>Imaginations</strong></h2>
    </div>
    <div class="blogInner">
        <div id="blog_list"></div>
        <div style="clear: both"></div>
        <div id="ourBlogs" class="themeDot"></div>
   </div>
  </div>
</section>

<script type="text/javascript">  
    // First time load product page
    get_view_me_list1();
    //when click on load more button 
    $('body').on('click', "#btnLoadViewMe1", function (event) {
            is_load_more = 1;
        get_view_me_list1(is_load_more);
    });

    //ajax funnction to get_product_list 
   function get_view_me_list1(is_load_more=0){ 
    if(is_load_more!=0){//if is_load_more is not 0 then get offset data from btnlod attr
        offset = $('#btnLoadViewMe1').attr("data-offset");
    }else{ //set offset =0 when is_load_more is 0
        offset = 0;
    }
    $.ajax({
        url: base_url+"home/blogList2",
        type: "POST",
        data:{offset:offset}, 
        dataType: "JSON",
        beforeSend: function() {
           // show_loader();
        }, 
        success: function(data){ 
           // hide_loader();
            if(data.status==-1){
                toastr.error(data.msg);
                window.setTimeout(function () {
                      window.location.href = data.url;
                }, 1000); 
            }
            $('#btnLoadViewMe1').remove();
            //remove load more button 

            if(offset==0){ //clear div when offset 0
                $("#blog_list").html('');
            }
            if(data.no_record==0){//show data in div when no previous record 
                $("#blog_list").html(data.html_view);
                
            }else{
                //append data when already record show in view
                $("#blog_list").append(data.html_view);
                $("#ourBlogs").append(data.btn_html);
            }
        },
    }); 
}

</script>