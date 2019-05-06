<?php
$getF_name = @$_REQUEST['file'];
if(!empty($_REQUEST['id'])){
    $get_id = @$_REQUEST['id'];
}

$rollBackFileName = @$_REQUEST['name'];

?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Upload Area</title>
    <script src="jquery-1.7.2.min.js" type="text/javascript"></script>
    <script src="jquery-ui.min.js"></script>
    <script src="jquery.uploadify.min.js" type="text/javascript"></script>
    <script src="custom.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="uploadify.css">
    <link rel="stylesheet" href="jquery-ui.css">
<script>
    function getFileExtension(name)
    {
        var found = name.lastIndexOf('.') + 1;
        return (found > 0 ? name.substr(found) : "");
    }
    function changePagination(pageId,liId){
        $(".flash").show();
        $(".flash").fadeIn(400).html
            ('<img style="position: relative;top: 7px" src="ajax-loader.gif" />');
        var dataString = pageId;
        var mod = $("#mod").val();
        var lastPage = $("#mod").attr('class');

        $.ajax({
            dataType: 'json',
            type: "POST",
            url: "pagination.php",
            data: {id:dataString,mod:mod,lastPage:lastPage},
            cache: false,
            success: function(result){

                $(".link a").removeClass("In-active current") ;
                $("#"+liId+" a").addClass( "In-active current" );
                $("#container").html(' ');
                $.each(result, function(i, item) {

                    if(getFileExtension(item) == 'pdf'){
                        $("#container").append('<div id="FlieDiv" class="masonry-brick" ><div class="view">'+
                            '<img src="pdf.png" style="border: 2px solid rgb(255, 255, 255);" id="0" name="'+item+'"/></div>'+item+'</div>');

                    }else if(getFileExtension(item) == 'doc' || getFileExtension(item) == 'docx'){
                        $("#container").append('<div id="FlieDiv" class="masonry-brick" ><div class="view">'+
                            '<img src="doc.png" style="border: 2px solid rgb(255, 255, 255);" id="0" name="'+item+'"/></div>'+item+'</div>');
                    }else{
                        $("#container").append('<div id="FlieDiv" class="masonry-brick" ><div class="view">'+
                            '<img src="uploads/'+item+'" style="border: 2px solid rgb(255, 255, 255);" id="0" name="'+item+'"/></div>'+item+'</div>');
                    }

                });
                $(".flash").delay().fadeOut();
            }
        });
    }
	function searching(){
	var search_field_value = $(".searching").val();
		if(search_field_value != ""){
			$(".search_loading").html('loading...');
		}else{
			$(".search_loading").html('');
		}
		$.ajax({
            dataType: 'json',
            type: "POST",
            url: "search.php",
            data: {search_field_value:search_field_value},
            cache: false,
            success: function(result){
				
                $("#container").html(' ');
                $.each(result, function(i, item) {

                    if(getFileExtension(item) == 'pdf'){
                        $("#container").append('<div id="FlieDiv" class="masonry-brick" ><div class="view">'+
                            '<img src="pdf.png" style="border: 2px solid rgb(255, 255, 255);" id="0" name="'+item+'"/></div>'+item+'</div>');

                    }else if(getFileExtension(item) == 'doc' || getFileExtension(item) == 'docx'){
                        $("#container").append('<div id="FlieDiv" class="masonry-brick" ><div class="view">'+
                            '<img src="doc.png" style="border: 2px solid rgb(255, 255, 255);" id="0" name="'+item+'"/></div>'+item+'</div>');
                    }else{
                        $("#container").append('<div id="FlieDiv" class="masonry-brick" ><div class="view">'+
                            '<img src="uploads/'+item+'" style="border: 2px solid rgb(255, 255, 255);" id="0" name="'+item+'"/></div>'+item+'</div>');
                    }
					$(".search_loading").html('');
                });
				
				}
        });
	}
$(document).keypress(function(e) {
    if(e.which == 13) {
        searching();
    }
});
  $(document).ready(function(){

      $("#FlieDiv img").css('border','2px solid #fff');
     var name = '<?php echo $rollBackFileName; ?>';
      var loc = '<?php echo @$_REQUEST['loc']; ?>';
      
      if(loc){
          var id = $("#FlieDiv img[name='"+name+"']").attr('id');
          $("#FlieDiv img[name='"+name+"']").addClass('selected');
          $("#FlieDiv img[name='"+name+"']").parent('div').addClass('selectedDiv');
          $("#FlieDiv img[name='"+name+"']").before('<span name="'+id+'" id="'+name+'" class="ui-icon ui-icon-closethick"></span>');
          $("#done").attr('class',name);
          $("#done").attr('fileName',loc);
          $('.selected').css('border','2px solid #777');
          $("#done").prop( "disabled", false );
      }
//          $("#FlieDiv img").one('click',function(){
				
              $(document).on('click', '#FlieDiv img', function(){
                  $("#done").prop( "disabled", false );
                  var existSpan = $(this).closest("#FlieDiv").find('span').attr('id');
					var root = $(this).parent('div');
                    var id = this.id;
                    var name = this.name;
					
						$.ajax({
							dataType: 'json',
							type: "POST",
							url: "check_image_dimension.php",
							data: {name: name},
							cache: false,
							success: function(result){
								if(result == 'b'){
									alert("Image width should be less than 1700px.");
									$('#'+id).css('border','2px solid #fff');
									$("#done").removeClass(name+'*');
									$('#'+id).removeClass('selected');
									root.removeClass('selectedDiv');
									root.find('.ui-icon').remove();
									if ($('#FlieDiv span').length){
										$("#done").prop( "disabled", false );
									}else{
										$("#done").prop( "disabled", true );
									}
								}
							}
						});
				
					
					
              if(name != existSpan){
                  $("#FlieDiv img").css('border','2px solid #fff');
                  $("#done").addClass(name+'*');
                  $('#'+id).addClass('selected');
                  $('.selected').css('border','2px solid #777');

                  $(this).one().before('<span name="'+id+'" id="'+name+'" class="ui-icon ui-icon-closethick"></span>');
                  $(this).parent('div').addClass('selectedDiv');
              }
          });
            $(".ui-icon").live("click",function(){
               var id = $(this).attr('name');
                var imageName = this.id;

                $('#'+id).css('border','2px solid #fff');
                $("#done").removeClass(imageName+'*');

                $('#'+id).removeClass('selected');
                $(this).parent('div').removeClass('selectedDiv');
                $(this).remove();
                if ($('#FlieDiv span').length){
                    $("#done").prop( "disabled", false );
                }else{
                    $("#done").prop( "disabled", true );
                }
            });


    $( "#tabs" ).tabs({
      collapsible: true
    });
      <?php $timestamp = time();  ?>
      $('#file_upload').uploadify({
          'onSelect' : function(file) {
          },
          'method'   : 'post',
          'formData'     : {
              'timestamp' : '<?php echo $timestamp;?>',
              'token'     : '<?php echo md5('unique_salt' . $timestamp);?>',
              'someKey' : 'someValue'
          },
          'fileTypeExts' : '*.gif; *.jpg; *.png; *.pdf; *.docx; *.doc',
          'fileSizeLimit' : '1000KB',
          'swf'      : 'uploadify.swf',
          'uploader' : 'uploadify.php?<?php if(!empty($get_id)){echo 'id='.$get_id.'&loc=';}else{echo 'loc=';} ?><?php if(!empty($getF_name)){echo $getF_name;}else{ ?>'+loc+'<?php }  ?>',
          'uploadLimit' : 1,
          'onUploadSuccess' : function(file, data, response) {
              if(data.indexOf('**') == -1){
//                  var myarr = data.split("**");
//                  window.location = 'index.php?name='+file.name+'&loc='+myarr[0]+'&id='+myarr[1];
                  window.location = 'index.php?name='+file.name+'&loc='+data;
              }else{
                  window.location = 'index.php?name='+file.name+'&loc='+data;
              }

          }
      });
	
  });
  </script>
</head>
<body>
<div id="tabs" style="height: 730px;">
  <ul>
    <li><a href="#tabs-1">Media Library</a></li>
    <!--<li><a href="#tabs-2">Uploads Files</a></li>-->
  </ul>
    <style type="text/css">
        ul.tsc_pagination { margin: 0px 0px 14px 19px; padding:0px; height:100%; overflow:hidden; font:12px \'Tahoma\'; list-style-type:none; }
        ul.tsc_pagination li { float:left; margin:0px; padding:0px; margin-left:5px; }
        ul.tsc_pagination li:first-child { margin-left:0px; }
        ul.tsc_pagination li a { color:black; display:block; text-decoration:none; padding:7px 10px 7px 10px; }
        ul.tsc_pagination li a img { border:none; }
        ul.tsc_paginationC li a { color:#707070; background:#FFFFFF; border-radius:3px; -moz-border-radius:3px; -webkit-border-radius:3px; border:solid 1px #DCDCDC; padding:6px 9px 6px 9px; }
        ul.tsc_paginationC li { padding-bottom:1px; }
        ul.tsc_paginationC li a:hover,
        ul.tsc_paginationC li a.current { color:#FFFFFF; box-shadow:0px 1px #EDEDED; -moz-box-shadow:0px 1px #EDEDED; -webkit-box-shadow:0px 1px #EDEDED; }
        ul.tsc_paginationC01 li a:hover,
        ul.tsc_paginationC01 li a.current { color:#893A00; text-shadow:0px 1px #FFEF42; border-color:#FFA200; background:#FFC800; background:-moz-linear-gradient(top, #FFFFFF 1px, #FFEA01 1px, #FFC800); background:-webkit-gradient(linear, 0 0, 0 100%, color-stop(0.02, #FFFFFF), color-stop(0.02, #FFEA01), color-stop(1, #FFC800)); }
        ul.tsc_paginationC li a.In-active {
            pointer-events: none;
            cursor: default;
        }
    </style>
  <div id="tabs-1" >
      <div class="buttonArea">
          <h3 style="width: 70%; float: left;"><button id="done" name="<?php if(!empty($get_id)){ echo $get_id;} ?>" style="cursor: pointer; margin-left: 19px;" fileName="<?php echo $getF_name; ?>">Set Upload File</button><button class="Cancel" >Cancel</button></h3>
          <div style="width: 25%;float: left;margin: 24px 0;"><input type="text" class="searching" /><input type="submit" class="searching_btn" value="Search" onclick="searching();" /><span class="search_loading"></span></div>
		  <div style="clear: both"></div>
      </div>

      <?php
      $dir = "uploads/";
	  
      if ($opendir = opendir($dir))
      {
          $images=array();
          while (($file = readdir($opendir)) !==FALSE)
          {
              if($file != "." && $file != ".." && $file !="thumbs")
              {
                  $images["$file"]=$file;
              }
          }
      }
      $count=0;
      sort($images);
      define('PAGE_PER_NO',33); // number of results per page.
      function getPagination($count){
          $paginationCount= floor($count / PAGE_PER_NO);
          $paginationModCount= $count % PAGE_PER_NO;
          if(!empty($paginationModCount)){
              $paginationCount++;
          }
          return $paginationCount;
      }



      $count=sizeof($images);
      $mod= sizeof($images)%33;
      if($count > 0){
          $paginationCount=getPagination($count);
      }

      $content ='<div id="pageData"></div>';
      if($count > 0){

          $content .='<ul class="tsc_pagination tsc_paginationC tsc_paginationC01">
    <li class="first link" id="first">
        <a  href="javascript:void(0)" onclick="changePagination(\'0\',\'first\')">F i r s t</a>
    </li>';
          $P_num = 0;
          for($i=0;$i<$paginationCount;$i++){

              $content .='<li id="'.$i.'_no" class="link">
          <a  href="javascript:void(0)" onclick="changePagination(\''.$P_num.'\',\''.$i.'_no\')">
              '.($i+1).'
          </a>
    </li>';
              $P_num = $P_num += 33;
          }

          $content .='<li class="last link" id="last">
         <a href="javascript:void(0)" onclick="changePagination(\''.($P_num-33).'\',\'last\')">L a s t</a>
    </li>
    <li class="flash"></li>
</ul>';
      }
      echo '<input type="hidden" id="mod" value="'.$mod.'" class="'.$paginationCount.'" />';
      echo $content;
      ?>

      <div id="container"  class="js-masonry" style="margin-left: 16px"
           data-masonry-options='{ "columnWidth": 200, "itemSelector": ".item" }' >



          <?php
          for($j=0;$j<33;$j++){
//          foreach($images as $image){

              ?>
              <div id='FlieDiv'>
			  
			  <?php if($images[$j]!="")
				{
				?>
                  <div class="view">
                  <?php
				
                  if(substr($images[$j],strpos($images[$j],'.',4)) == '.pdf'){
                      echo "<img src='/uploadify/pdf.png' style='' id='".$count."' name='".$images[$j]."'/>";
                  }elseif(substr($images[$j],strpos($images[$j],'.',4)) == '.docx' || substr($images[$j],strpos($images[$j],'.',4)) == '.doc'){
                      echo "<img src='/uploadify/doc.png' style='' id='".$count."' name='".$images[$j]."'/>";
                  }else{
                      echo "<img src='$dir$images[$j]' style='' id='".$count."' name='".$images[$j]."'/>";
                  }
                  ?>
				  
				  </div>
				  <?php echo $images[$j]; 
				  
				  }
				  ?>
              </div>

              <?php  $count+=1; }

          if($count<=0) echo "No Gallery image exist.";

          ?>

           </div>
      <?php


      ?>
      </div>
  <!--<div id="tabs-2">
    <input type="file" name="file_upload" id="file_upload" />
  </div>-->

</div>


</body>
</html>
